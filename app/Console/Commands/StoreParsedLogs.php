<?php

namespace App\Console\Commands;

use App\Classes\DateFormatter\ConvertToLaravelFormat;
use App\Classes\LogParsers\MicroserviceLogFileParser;
use App\Classes\Observers\Log\LogStorageInDbObserver;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class StoreParsedLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:store {path? : path of logFile}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Read log file and store to database.';

    private $filePath;
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->filePath = $this->askForFilePath();
        $logParser = new MicroserviceLogFileParser(new ConvertToLaravelFormat);
        $logParser->attach(new LogStorageInDbObserver());
        $logParser->parse($this->filePath);
        $this->info('Process is successfully done.');
        return Command::SUCCESS;
    }

    private function askForFilePath(): string
    {
        $filePath = $this->ask('Please enter the path to the log file:');

        $validator = Validator::make(
            ['filePath' => $filePath],
            [
                'filePath' => ['required', function ($attribute, $value, $fail) {
                    if (!file_exists($value)) {
                        $fail('The '.$attribute.' is not exist.');
                    }}]
            ]
        );

        if ($validator->fails()) {
            $this->error($validator->errors());

            return $this->askForFilePath();
        }

        return $filePath;
    }

}
