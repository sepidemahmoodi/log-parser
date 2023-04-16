<?php
namespace App\Classes\Observers\Log;

use App\Jobs\LogStoreProcess;

class DatabaseWriter implements DataObserver
{
    public function update(array $data)
    {
        LogStoreProcess::dispatch($data);
    }
}
