<?php

namespace App\Jobs;

use App\Models\ApiLogs;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ApiRequestResponseLoggerJob implements ShouldQueue
{
    use Queueable;

    private $data;
    /**
     * Create a new job instance.
     */
    public function __construct(array $data) 
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        ApiLogs::create($this->data);
    }
}
