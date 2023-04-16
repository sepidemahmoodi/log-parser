<?php

namespace App\Console\Commands;

use App\Classes\DateFormatter\ConvertToLaravelFormat;
use App\Classes\LogParsers\MicroserviceLogFileParser;
use App\Classes\Observers\Log\DatabaseWriter;
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
        $logParser->attach(new DatabaseWriter());
        $logParser->parse($this->filePath);
        $this->info('Process is successfully done.');
        return Command::SUCCESS;
    }

    private function askForFilePath(): string
    {
        $filePath = $this->ask('Please enter the path to the log file:');

        $validator = Validator::make(
            ['filePath' => $filePath],
            ['filePath' => 'required']
        );

        if ($validator->fails()) {
            $this->error('You must enter the path to the log file.');

            return $this->askForFilePath();
        }

        return $filePath;
    }

}
