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

    public function getByClassId($class_id)
    {
        if (!$class_id) {
            throw new Exception('Class ID Not Found');
        }

        return $this->classStudentRepository->getClassStudents(['class_id' => $class_id]);
    }
}