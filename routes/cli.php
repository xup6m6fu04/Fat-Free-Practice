<?php

\Middleware::instance()->before('GET|POST /seed/*', function(\Base $f3, $params, $alias) {
    if(php_sapi_name() != "cli") {
        echo "Only Cli !";
        exit;
    }
    $f3->route('GET /seed/teacher', 'App\Commands\SeedCommand->seedTeacher');
    $f3->route('GET /seed/student', 'App\Commands\SeedCommand->seedStudent');
});

\Middleware::instance()->run();