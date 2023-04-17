<?php
namespace App\Classes\Observers\Log;

use App\Jobs\LogStoreProcess;

class LogStorageInDbObserver implements LogParserObserver
{
    public function update(array $data)
    {
        LogStoreProcess::dispatch($data);
    }
}
