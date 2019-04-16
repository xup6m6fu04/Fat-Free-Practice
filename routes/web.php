<?php
$f3->route('GET /admin/login', 'App\Controllers\LoginController->pageLogin');
$f3->route('GET /admin/school', 'App\Controllers\SchoolController->pageSchool');
$f3->route('GET /admin/teacher', 'App\Controllers\TeacherController->pageTeacher');
$f3->route('GET /admin/student', 'App\Controllers\StudentController->pageStudent');
$f3->route('GET /admin/class', 'App\Controllers\ClassController->pageClass');
$f3->route('GET /admin/class-students', 'App\Controllers\ClassController->pageClassStudent');
$f3->route('GET /admin/class-teachers', 'App\Controllers\ClassController->pageClassTeacher');


