<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Jobs\SlackNotification;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $rendered = parent::render($request, $exception);

        if (env('SLACK_NOTIFICATION_ENABLE'))
            dispatch(
                new SlackNotification(
                    $exception->getMessage(),
                    [
                        'url' => $request->getUri(),
                        'status' => $rendered->getStatusCode(),
                        'env' => env('APP_URL')
                    ]
                )
            );

        return response()->json([
            'error' => [
                'code' => $rendered->getStatusCode(),
                'request' => $request->getRequestUri(),
                'message' => $exception->getMessage()
            ]
        ], $rendered->getStatusCode());
    }
}
