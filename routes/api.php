<?php

$f3->route('POST /api/add-teacher', 'App\Controllers\TeacherController->addTeacher');
$f3->route('POST /api/add-student', 'App\Controllers\StudentController->addStudent');
$f3->route('POST /api/edit-student', 'App\Controllers\StudentController->editStudent');
$f3->route('POST /api/edit-teacher', 'App\Controllers\TeacherController->editTeacher');