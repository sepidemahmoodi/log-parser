<?php

namespace App\Jobs;

use App\Classes\LogStorage\MicroserviceLogFileStorage;
use App\Classes\LogStorage\MicroserviceLogFileStorageHandler;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LogStoreProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $chunkOfData;

    /**
     * Create a new job instance.
     *
     * @param $chunkOfData
     */
    public function __construct($chunkOfData)
    {
        $this->chunkOfData = $chunkOfData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $logStorage = new MicroserviceLogFileStorageHandler(new MicroserviceLogFileStorage);
        $logStorage->handle($this->chunkOfData);
    }
}
