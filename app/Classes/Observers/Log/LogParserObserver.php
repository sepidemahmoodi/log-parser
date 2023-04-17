<?php
namespace App\Classes\Observers\Log;

interface LogParserObserver
{
    public function update(array $data);
}
