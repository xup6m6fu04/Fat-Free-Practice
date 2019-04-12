<?php

\Middleware::instance()->before('GET|POST /seed/*', function(\Base $f3, $params, $alias) {
    if(php_sapi_name() != "cli") {
        echo "Only Cli !";
        exit;
    }
    $f3->route('GET /seed/all', 'App\Commands\SeedCommand->seedAll');
    $f3->route('GET /seed/teacher', 'App\Commands\SeedCommand->seedTeacher');
    $f3->route('GET /seed/student', 'App\Commands\SeedCommand->seedStudent');
    $f3->route('GET /seed/school', 'App\Commands\SeedCommand->seedSchool');
    $f3->route('GET /seed/class', 'App\Commands\SeedCommand->seedClass');

    $f3->route('GET /seed/assign-student', 'App\Commands\SeedCommand->assignStudent');
    $f3->route('GET /seed/assign-teacher', 'App\Commands\SeedCommand->assignTeacher');
    $f3->route('GET /seed/assign-all', 'App\Commands\SeedCommand->assignAll');

    $f3->route('GET /seed/run', 'App\Commands\SeedCommand->run');
});

\Middleware::instance()->run();
