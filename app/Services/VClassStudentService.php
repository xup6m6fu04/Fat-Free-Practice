<?php


namespace App\Services;

use App\Repositories\VClassStudentRepository;
use App\Repositories\SchoolRepository;
use Exception;

class VClassStudentService
{
    protected $vClassStudentRepository;
    protected $schoolRepository;

    public function __construct()
    {
        $this->vClassStudentRepository = new VClassStudentRepository();
        $this->schoolRepository = new SchoolRepository();
    }

    public function getByClassId($class_id)
    {
        if (!$class_id) {
            throw new Exception('Class ID Not Found');
        }

        return $this->vClassStudentRepository->getVClassStudents(['class_id' => $class_id]);
    }
}