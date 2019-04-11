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

    public function countByClassId($class_id, $key_word = false)
    {
        if (!$class_id) {
            throw new Exception('Class ID Not Found');
        }

        if ($key_word) {
            $args['school_id']  = $key_word;
            $args['class_id']   = $key_word;
            $args['student_id'] = $key_word;
            $args['name']       = $key_word;
            $args['email']      = $key_word;
            $args['enable']     = $key_word;
        }

        return $this->vClassStudentRepository->getVClassStudents(['class_id' => $class_id], 'count',  $key_word);
    }

    public function getByClassId($class_id, $key_word = false)
    {
        if (!$class_id) {
            throw new Exception('Class ID Not Found');
        }

        if ($key_word) {
            $args['school_id']  = $key_word;
            $args['class_id']   = $key_word;
            $args['student_id'] = $key_word;
            $args['name']       = $key_word;
            $args['email']      = $key_word;
            $args['enable']     = $key_word;
        }

        return $this->vClassStudentRepository->getVClassStudents(['class_id' => $class_id], 'find',  $key_word);
    }
}