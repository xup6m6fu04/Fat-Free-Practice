<?php

require __DIR__ . '/../vendor/autoload.php';

$f3 = \Base::instance();

// 設定 view 路徑
$f3->set('UI', '../resources/view/');

// 載入 env 管理套件 (https://github.com/vlucas/phpdotenv)
Dotenv\Dotenv::create(__DIR__ . '/../')->load();

// 載入 config 管理套件 (https://github.com/illuminate/config)
$app = new App\Config\Application();
$f3->set('config', $app->config);
$config = $f3->get('config');

// 時區設定
date_default_timezone_set($config->get('app.timezone'));

// 連線資料庫

if ($config->get('database.default') === 'mysql') {
    $f3->set('db', new DB\SQL
        (
            'mysql:host=' . $config->get('database.connections.mysql.host') .
            ';port='      . $config->get('database.connections.mysql.port') .
            ';dbname='    . $config->get('database.connections.mysql.database'),
            $config->get('database.connections.mysql.username'),
            $config->get('database.connections.mysql.password'),
            [
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'
            ]
        )
    );
}

// 網頁 專用路由 (CMS)
require __DIR__ . '/../routes/web.php';

// API 專用路由
require __DIR__ . '/../routes/api.php';

// Cli 專用路由
require __DIR__ . '/../routes/cli.php';

$f3->run();

