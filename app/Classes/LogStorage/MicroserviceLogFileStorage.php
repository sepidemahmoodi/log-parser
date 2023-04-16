<?php
namespace App\Classes\LogStorage;

use App\Models\Log;

class MicroserviceLogFileStorage implements LogFileStorageInterface
{
    /**
     * @param $logData
     * @return mixed|string
     */
    public function store($logData)
    {
        try {
            if (is_array($logData))
                (new Log)->insertBulkData($logData);

        } catch (\Exception $e)
        {
            return $e->getMessage();
        }
    }
}
