<?php


namespace App\Services;

use App\Repositories\TeacherRepository;
use Exception;

class TeacherService
{
    protected $teacherRepository;

    public function __construct()
    {
        $this->teacherRepository = new TeacherRepository();
    }

    public function getAllTeachers()
    {
        return $this->teacherRepository->getTeachers();
    }

    public function getTeacherById($id)
    {
        return $this->teacherRepository->getTeachers(['id' => $id]);
    }

    public function addTeacher($args)
    {
        // 檢查內容
        foreach ($args as $key => $arg) {

            if (!$arg) {
                throw new Exception($key . ' 為必填');
            }

            // TODO 檢查格式
        }

        return $this->teacherRepository->addTeacher($args);
    }

    public function editTeacher($id, $args)
    {
        if (!$args['id']) {
            throw new Exception('ID is Empty');
        }

        $student = $this->getTeacherById($args['id']);

        if (!$student) {
            throw new Exception('Teacher does not exist');
        }

        // 檢查內容
        foreach ($args as $key => $arg) {

            if (!$arg) {
                throw new Exception($key . ' 為必填');
            }

            // TODO 檢查格式
        }

        return $this->teacherRepository->editTeacher($id, $args);
    }
}