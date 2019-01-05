<?php
/**
 * @category    product-service
 * @package     Product
 * @author      mAm  <mamreezaa@gmail.com>
 */

namespace App\Http\Middleware;

use Closure;

class Authorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $model = null;

        if ($request->is('v1/products*')) {
            $model = 'products';
        }

        $allowedResources = config("resources.$model");
        $resourceCalls = resourceCalls($request, $allowedResources);
        if ($resourceCalls['invalid']) {
            return response()->json(['invalid_resource_call' => $resourceCalls['invalid']], 400);
        }

        $request->include = $resourceCalls['valid'];
        return $next($request);
    }
}
