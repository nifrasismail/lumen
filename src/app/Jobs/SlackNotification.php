<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Log;

class SlackNotification extends Job
{

    public $message;
    public $context;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($message, $context)
    {
        $this->message = $message;
        $this->context = $context;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::channel('slack')->critical($this->message, $this->context);
    }
}
