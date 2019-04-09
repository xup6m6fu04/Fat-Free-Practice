<?php


namespace App\Traits;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Carbon\Carbon;

Trait LoggerTrait
{
    protected $logger;
    protected $log_name;

    public function Log($log, $log_type = Logger::ERROR)
    {
        // create a log channel
        $this->logger = new Logger('log');
        $this->log_name = 'log-' . Carbon::now()->toDateString() . '.log';


        if (!file_exists(__DIR__ . '/../../storage/log/' . $this->log_name)) {
             file_put_contents(__DIR__ . '/../../storage/log/' . $this->log_name, '');
        }

        $this->logger->pushHandler(new StreamHandler(__DIR__ . '/../../storage/log/' . $this->log_name, Logger::DEBUG));

        switch ($log_type) {
            case Logger::DEBUG :
                $this->logger->debug($log);
                break;
            case Logger::INFO :
                $this->logger->info($log);
                break;
            case Logger::NOTICE :
                $this->logger->notice($log);
                break;
            case Logger::WARNING :
                $this->logger->warning($log);
                break;
            case Logger::ERROR :
                $this->logger->error($log);
                break;
            case Logger::CRITICAL :
                $this->logger->critical($log);
                break;
            case Logger::ALERT :
                $this->logger->alert($log);
                break;
            case Logger::EMERGENCY :
                $this->logger->emergency($log);
                break;

        }
    }
}

