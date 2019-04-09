<?php

$f3->route('POST /api/add-teacher', 'App\Controllers\TeacherController->addTeacher');
$f3->route('POST /api/add-student', 'App\Controllers\StudentController->addStudent');
$f3->route('POST /api/add-school', 'App\Controllers\SchoolController->addSchool');
$f3->route('POST /api/add-class', 'App\Controllers\ClassController->addClass');
$f3->route('POST /api/edit-student', 'App\Controllers\StudentController->editStudent');
$f3->route('POST /api/edit-teacher', 'App\Controllers\TeacherController->editTeacher');
$f3->route('POST /api/edit-school', 'App\Controllers\SchoolController->editSchool');
$f3->route('POST /api/edit-class', 'App\Controllers\ClassController->editClass');
$f3->route('POST /api/get-teacher-by-id', 'App\Controllers\TeacherController->getTeacherById');
$f3->route('POST /api/get-student-by-id', 'App\Controllers\StudentController->getStudentById');
$f3->route('POST /api/get-school-by-id', 'App\Controllers\SchoolController->getSchoolById');
