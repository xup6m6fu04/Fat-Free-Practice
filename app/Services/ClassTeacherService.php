<?php


namespace App\Services;

use App\Repositories\ClassTeacherRepository;
use App\Repositories\SchoolRepository;
use Exception;

class ClassTeacherService
{
    protected $classTeacherRepository;
    protected $schoolRepository;

    public function __construct()
    {
        $this->classTeacherRepository = new ClassTeacherRepository();
        $this->schoolRepository = new SchoolRepository();
    }

    public function getByClassId($class_id)
    {
        if (!$class_id) {
            throw new Exception('Class ID Not Found');
        }

        return $this->classTeacherRepository->getClassTeachers(['class_id' => $class_id]);
    }

    public function getByParams($args)
    {
        return $this->classTeacherRepository->getClassTeachers($args);
    }

    public function getByTeacherId($teacher_id, $type = 'load')
    {
        if (!$teacher_id) {
            throw new Exception('Teacher ID Not Found');
        }

        return $this->classTeacherRepository->getClassTeachers(['teacher_id' => $teacher_id], $type);
    }

    public function addSchool($args)
    {
        // 檢查內容
        foreach ($args as $key => $arg) {
            if (!$arg) {
                throw new Exception($key . ' 為必填');
            }
            // TODO 檢查格式
        }

        return $this->classTeacherRepository->addClassTeacher($args);
    }

    public function editClassTeacher($student_id, $args)
    {
        if (!$args['class_id']) {
            throw new Exception('Class ID is Empty');
        }

        if (!$student_id) {
            throw new Exception('Teacher ID is Empty');
        }

        return $this->classTeacherRepository->editClassTeacher($student_id, $args);
    }
}