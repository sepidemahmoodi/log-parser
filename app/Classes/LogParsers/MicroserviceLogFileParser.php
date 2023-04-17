<?php
namespace App\Classes\LogParsers;

use App\Classes\DateFormatter\DateConverterInterface;
use App\Classes\Observers\Log\LogParserObserver;

class MicroserviceLogFileParser
{
    private $observers = [];
    private $dateConverter;
    CONST CHUNK_COUNT = 3;

    /**
     * AbstractLogFileParser constructor.
     * @param DateConverterInterface $dateConverter
     * @param $job
     */
    public function __construct(DateConverterInterface $dateConverter)
    {
        $this->dateConverter = $dateConverter;
    }

    public function attach(LogParserObserver $observer)
    {
        $this->observers[] = $observer;
    }

    public function detach(LogParserObserver $observer)
    {
        $key = array_search($observer, $this->observers, true);

        if ($key !== false) {
            unset($this->observers[$key]);
        }
    }

    /**
     * @param $logFilePath
     * @return string
     */
    public function parse($logFilePath)
    {
        try {
            if($this->checkFileIsExist($logFilePath) && is_readable($logFilePath)) {
                $fileHandle = fopen($logFilePath, 'r');
                while (!feof($fileHandle)) {
                    $chunkData = [];
                    $counter = 0;
                    while (($line = fgets($fileHandle)) !== false && $counter < self::CHUNK_COUNT) {
                        $chunkData[] = $this->prepareData(trim($line));
                        $counter++;
                    }
                    if (!empty($chunkData)) {
                        $this->observers[0]->update($chunkData);
                    }
                }
                fclose($fileHandle);
                return 'Parsing log file is complete';
            }
            throw new \Exception('Log file is not exist.', 404);
        } catch(\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param $logFilePath
     * @return bool
     */
    private function checkFileIsExist($logFilePath)
    {
        return file_exists($logFilePath);
    }

    /**
     * @param $logContent
     * @return array
     */
    private function prepareData($logContent)
    {
        $logContent = str_replace("[", "",  $logContent);
        $logContent = str_replace("]", "",  $logContent);
        $logContent = str_replace('"', "",  $logContent);
        $logContent = str_replace(' -', "",  $logContent);
        $data = explode(" ", $logContent);
        return [
            'type' => 'microservice',
            'service_name' => $data[0] ?? '',
            'date_time' => $this->dateConverter->convert($data[1], 'd/M/Y:H:i:s') ?? '',
            'http_method' => $data[2] ?? '',
            'http_path' => $data[3] ?? '',
            'http_version' => $data[4] ?? '',
            'http_status_code' => $data[5] ?? ''
        ];
    }
}
