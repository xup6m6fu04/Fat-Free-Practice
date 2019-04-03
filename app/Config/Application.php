<?php

namespace App\Config;

use Illuminate\Filesystem\Filesystem;
use Dotenv\Dotenv;

class Application
{
    public $config;
    public $fileSystem;
    public $environment;

    public function __construct()
    {
        $this->config = new Config();
        $this->fileSystem = new Filesystem();
        $this->environment = $this->getEnvironment();
        $this->config->loadConfigFiles(__DIR__ . '/../../config');
    }

    public function getEnvironment()
    {
        $environment = '';
        $environmentPath = __DIR__ . '/../.env';
        if ($this->fileSystem->isFile($environmentPath)) {
            $environment = trim($this->fileSystem->get($environmentPath));
            $envFile = __DIR__ . '/../app' . $environment;
            if ($this->fileSystem->isFile($envFile . '.env')) {
                $dotEnv = new Dotenv(__DIR__ . '/app/', '.' . $environment . '.env');
                $dotEnv->load();
            }
        }
        return $environment;
    }
}