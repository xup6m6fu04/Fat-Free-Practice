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
            'id'        => $key_word,
            'name'      => $key_word,
            'email'     => $key_word,
            'enable'    => $key_word
        ];

        return $this->studentRepository->getStudents($args, 'count', true);
    }

    public function getStudentByParams($args, $key_word = false)
    {
        if ($key_word) {
            $args['id']        = $key_word;
            $args['name']      = $key_word;
            $args['email']     = $key_word;
            $args['enable']    = $key_word;
        }

        // TODO : 好像該做點什麼
        return $this->studentRepository->getStudents($args, 'find', $key_word);
    }

    public function getStudentById($id, $type = 'load')
    {
        if (!$id) {
            throw new Exception('ID is empty');
        }

        return $this->studentRepository->getStudents(['id' => $id], $type);
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

    public function editStudent($id, $args)
    {
        if (!$args['id']) {
            throw new Exception('ID is Empty');
        }

        $student = $this->getStudentById($args['id']);

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

        return $this->studentRepository->editStudent($id, $args);
    }
}