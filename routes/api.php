<?php

$f3->route('POST /api/add-teacher', 'App\Controllers\TeacherController->addTeacher');
$f3->route('POST /api/add-student', 'App\Controllers\StudentController->addStudent');
$f3->route('POST /api/add-school', 'App\Controllers\SchoolController->addSchool');
$f3->route('POST /api/add-class', 'App\Controllers\ClassController->addClass');
$f3->route('POST /api/edit-student', 'App\Controllers\StudentController->editStudent');
$f3->route('POST /api/assign-student', 'App\Controllers\AssignController->assignStudent');
$f3->route('POST /api/edit-teacher', 'App\Controllers\TeacherController->editTeacher');
$f3->route('POST /api/assign-teacher', 'App\Controllers\AssignController->assignTeacher');
$f3->route('POST /api/edit-school', 'App\Controllers\SchoolController->editSchool');
$f3->route('POST /api/edit-class', 'App\Controllers\ClassController->editClass');
$f3->route('POST /api/get-teacher-by-teacher-id', 'App\Controllers\TeacherController->getTeacherByTeacherId');
$f3->route('POST /api/get-student-by-student-id', 'App\Controllers\StudentController->getStudentByStudentId');
$f3->route('POST /api/get-class-and-school-by-student-id', 'App\Controllers\StudentController->getClassAndSchoolByStudentId');
$f3->route('POST /api/get-school-by-school-id', 'App\Controllers\SchoolController->getSchoolBySchoolId');
$f3->route('POST /api/get-class-by-class-id', 'App\Controllers\ClassController->getClassByClassId');
$f3->route('POST /api/get-class-by-school-id', 'App\Controllers\ClassController->getClassBySchoolId');

$f3->route('POST /api/get-class-and-school-by-teacher-id', 'App\Controllers\TeacherController->getClassAndSchoolByTeacherId');
