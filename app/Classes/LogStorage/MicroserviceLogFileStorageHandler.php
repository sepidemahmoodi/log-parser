<?php
namespace App\Classes\LogStorage;

class MicroserviceLogFileStorageHandler
{
    private $logFileStorage;
    public function __construct(LogFileStorageInterface $logFileStorage)
    {
        $this->logFileStorage = $logFileStorage;
    }

    /**
     * @param $logData
     * @return mixed
     */
    public function handle($logData)
    {
        return $this->logFileStorage->store($logData);
    }
}
