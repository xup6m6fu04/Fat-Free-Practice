<?php

$f3->route('GET /admin/school', 'App\Controllers\SchoolController->pageSchool');
$f3->route('GET /admin/teacher', 'App\Controllers\TeacherController->pageTeacher');
$f3->route('GET /admin/student', 'App\Controllers\StudentController->pageStudent');


