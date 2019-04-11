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

    public function countAllTeachers()
    {
        return $this->teacherRepository->getTeachers([], 'count');
    }

    public function countTeachersByKeyWord($key_word)
    {
        $args = [
            'id'        => $key_word,
            'name'      => $key_word,
            'email'     => $key_word,
            'enable'    => $key_word
        ];

        return $this->teacherRepository->getTeachers($args, 'count', true);
    }

    public function getTeacherByParams($args, $key_word = false)
    {
        if ($key_word) {
            $args['id']        = $key_word;
            $args['name']      = $key_word;
            $args['email']     = $key_word;
            $args['enable']    = $key_word;
        }

        // TODO : 好像該做點什麼
        return $this->teacherRepository->getTeachers($args, 'find', $key_word);
    }

    public function getTeacherById($id, $type = 'load')
    {
        if (!$id) {
            throw new Exception('ID is empty');
        }

        return $this->teacherRepository->getTeachers(['id' => $id], $type);
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

        // 密碼加密
        $args['password'] = password_hash($args['password'], PASSWORD_BCRYPT);
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