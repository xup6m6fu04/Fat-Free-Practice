<?php


namespace App\Services;

use App\Repositories\ClassRepository;
use App\Repositories\SchoolRepository;
use Exception;

class ClassService
{
    protected $classRepository;
    protected $schoolRepository;

    public function __construct()
    {
        $this->classRepository = new ClassRepository();
        $this->schoolRepository = new SchoolRepository();
    }

    public function getAllClasses()
    {
        return $this->classRepository->getClasses();
    }

    public function getClassById($id, $type = 'load')
    {
        if (!$id) {
            throw new Exception('ID is empty');
        }


        return $this->classRepository->getClasses(['id' => $id], $type);
    }

    public function addClass($args)
    {
        // 檢查內容
        foreach ($args as $key => $arg) {

            if (!$arg) {
                throw new Exception($key . ' 為必填');
            }

            // TODO 檢查格式
        }

        if (!$this->schoolRepository->getSchools(['id' => $args['school_id']])) {
            throw new Exception('此班級無隸屬的學校');
        }

        return $this->classRepository->addClass($args);
    }

    public function editClass($id, $args)
    {
        if (!$args['id']) {
            throw new Exception('ID is Empty');
        }

        $class = $this->getClassById($args['id']);

        if (!$class) {
            throw new Exception('Class does not exist');
        }

        // 檢查內容
        foreach ($args as $key => $arg) {

            if (!$arg) {
                throw new Exception($key . ' 為必填');
            }

            // TODO 檢查格式
        }

        return $this->classRepository->editClass($id, $args);
    }
}