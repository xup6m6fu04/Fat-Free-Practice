<?php


namespace App\Services;

use App\Repositories\ClassStudentRepository;
use App\Repositories\SchoolRepository;
use Exception;

class ClassStudentService
{
    protected $classStudentRepository;
    protected $schoolRepository;

    public function __construct()
    {
        $this->classStudentRepository = new ClassStudentRepository();
        $this->schoolRepository = new SchoolRepository();
    }

    public function getByClassId($class_id, $key_word = false)
    {
        if (!$class_id) {
            throw new Exception('Class ID Not Found');
        }

        if ($key_word) {
            $args['class_id']   = $key_word;
            $args['teacher_id'] = $key_word;
        } else {
            $args['class_id'] = $class_id;
        }

        return $this->classStudentRepository->getClassStudents($args, 'find', $key_word);
    }

    public function getByParams($args)
    {
        return $this->classStudentRepository->getClassStudents($args);
    }

    public function getByStudentId($student_id, $type = 'load')
    {
        if (!$student_id) {
            throw new Exception('Student ID Not Found');
        }

        return $this->classStudentRepository->getClassStudents(['student_id' => $student_id], $type);
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

        return $this->classStudentRepository->addClassStudent($args);
    }

    public function editClassStudent($student_id, $args)
    {
        if (!$args['class_id']) {
            throw new Exception('Class ID is Empty');
        }

        if (!$student_id) {
            throw new Exception('Student ID is Empty');
        }

        return $this->classStudentRepository->editClassStudent($student_id, $args);
    }
}