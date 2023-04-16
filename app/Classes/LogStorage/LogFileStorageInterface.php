<?php
namespace App\Classes\LogStorage;

interface LogFileStorageInterface
{
    /**
     * @param $logData
     * @return mixed
     */
    public function store($logData);
}
