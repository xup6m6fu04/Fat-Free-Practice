<?php


namespace App\Services;

use App\Repositories\TeacherRepository;

class TeacherService
{
    protected $teacherRepository;

    public function __construct()
    {
        $this->teacherRepository = new TeacherRepository();
    }

    public function getAllTeacher()
    {
        return $this->teacherRepository->getTeacher();
    }
}