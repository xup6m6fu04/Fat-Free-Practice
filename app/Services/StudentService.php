<?php


namespace App\Services;

use App\Repositories\StudentRepository;
use Exception;

class StudentService
{
    protected $studentRepository;

    public function __construct()
    {
        $this->studentRepository = new StudentRepository();
    }

    public function getAllStudents()
    {
        return $this->studentRepository->getStudents();
    }

    public function countAllStudents()
    {
        return $this->studentRepository->getStudents([], 'count');
    }

    public function countStudentsByKeyWord($key_word)
    {
        $args = [
            'student_id' => $key_word,
            'name'       => $key_word,
            'email'      => $key_word,
            'enable'     => $key_word
        ];

        return $this->studentRepository->getStudents($args, 'count', true);
    }

    public function getStudentByParams($args, $key_word = false)
    {
        if ($key_word) {
            $args['student_id'] = $key_word;
            $args['name']       = $key_word;
            $args['email']      = $key_word;
            $args['enable']     = $key_word;
        }

        // TODO : 好像該做點什麼
        return $this->studentRepository->getStudents($args, 'find', $key_word);
    }

    public function getStudentByStudentId($student_id, $type = 'load')
    {
        if (!$student_id) {
            throw new Exception('Student ID is empty');
        }

        return $this->studentRepository->getStudents(['student_id' => $student_id], $type);
    }

    public function getStudentsInStudentId($string, $key_word)
    {
        return $this->studentRepository->getStudentsInStudentId($string, $key_word);
    }

    public function addStudent($args)
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
        return $this->studentRepository->addStudent($args);
    }

    public function editStudent($student_id, $args)
    {
        if (!$student_id) {
            throw new Exception('Student ID is Empty');
        }

        $student = $this->getStudentByStudentId($student_id);

        if (!$student) {
            throw new Exception('Student does not exist');
        }

        // 檢查內容
        foreach ($args as $key => $arg) {
            if (!$arg) {
                throw new Exception($key . ' 為必填');
            }
            // TODO 檢查格式
        }

        return $this->studentRepository->editStudent($student_id, $args);
    }
}