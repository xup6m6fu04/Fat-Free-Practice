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
            'teacher_id' => $key_word,
            'name'       => $key_word,
            'email'      => $key_word,
            'enable'     => $key_word
        ];

        return $this->teacherRepository->getTeachers($args, 'count', true);
    }

    public function getTeacherByParams($args, $key_word = false)
    {
        if ($key_word) {
            $args['teacher_id'] = $key_word;
            $args['name']       = $key_word;
            $args['email']      = $key_word;
            $args['enable']     = $key_word;
        }

        // TODO : 好像該做點什麼
        return $this->teacherRepository->getTeachers($args, 'find', $key_word);
    }

    public function getTeacherByTeacherId($teacher_id, $type = 'load')
    {
        if (!$teacher_id) {
            throw new Exception('Teacher ID is empty');
        }

        return $this->teacherRepository->getTeachers(['teacher_id' => $teacher_id], $type);
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

    public function editTeacher($teacher_id, $args)
    {
        if (!$args['teacher_id']) {
            throw new Exception('Teacher ID is Empty');
        }

        $teacher = $this->getTeacherByTeacherId($args['teacher_id']);

        if (!$teacher) {
            throw new Exception('Teacher does not exist');
        }

        // 檢查內容
        foreach ($args as $key => $arg) {
            if (!$arg) {
                throw new Exception($key . ' 為必填');
            }
            // TODO 檢查格式
        }

        return $this->teacherRepository->editTeacher($teacher_id, $args);
    }
}