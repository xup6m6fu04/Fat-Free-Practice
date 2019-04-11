<?php


namespace App\Services;

use App\Repositories\VClassTeacherRepository;
use App\Repositories\SchoolRepository;
use Exception;

class VClassTeacherService
{
    protected $vClassTeacherRepository;
    protected $schoolRepository;

    public function __construct()
    {
        $this->vClassTeacherRepository = new VClassTeacherRepository();
        $this->schoolRepository = new SchoolRepository();
    }

    public function countByClassId($class_id, $key_word = false)
    {
        if (!$class_id) {
            throw new Exception('Class ID Not Found');
        }

        if ($key_word) {
            $args['school_id']   = $key_word;
            $args['class_id']    = $key_word;
            $args['teacher_id']  = $key_word;
            $args['name']        = $key_word;
            $args['email']       = $key_word;
            $args['enable']      = $key_word;
        }

        return $this->vClassTeacherRepository->getVClassTeachers(['class_id' => $class_id], 'count',  $key_word);
    }

    public function getByClassId($class_id, $key_word = false)
    {
        if (!$class_id) {
            throw new Exception('Class ID Not Found');
        }

        if ($key_word) {
            $args['school_id']  = $key_word;
            $args['class_id']   = $key_word;
            $args['teacher_id'] = $key_word;
            $args['name']       = $key_word;
            $args['email']      = $key_word;
            $args['enable']     = $key_word;
        }

        return $this->vClassTeacherRepository->getVClassTeachers(['class_id' => $class_id], 'find',  $key_word);
    }
}