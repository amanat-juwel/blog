<?php

/**
 * List of plain SQS queues and their corresponding handling classes
 */
return [
    'handlers' => [
        'ses-bounces-queue' => App\Jobs\ProcessFailedEmail::class
    ],

    'default-handler' => App\Jobs\ProcessFailedEmail::class
];