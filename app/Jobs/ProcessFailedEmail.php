<?php

namespace App\Jobs;
use Illuminate\Support\Facades\Log;

use Dusterio\PlainSqs\Jobs\DispatcherJob;
use Illuminate\Contracts\Queue\Job;

class ProcessFailedEmail extends DispatcherJob
{
    protected $data;

    function __construct($data = 'test')
    {
        parent::__construct($data);
    }


    public function handle(Job $job, $data)
    {
        Log::info('====================SQS QUEUE WORKER==========================');
        var_dump($data);
    }
}
