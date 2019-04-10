<?php


namespace App\Services;

use App\Repositories\SchoolRepository;
use Exception;

class SchoolService
{
    protected $schoolRepository;

    public function __construct()
    {
        $this->schoolRepository = new SchoolRepository();
    }

    public function getAllSchools()
    {
        return $this->schoolRepository->getSchools();
    }

    public function getSchoolById($id, $type = 'load')
    {
        if (!$id) {
            throw new Exception('ID is empty');
        }

        return $this->schoolRepository->getSchools(['id' => $id], $type);
    }

    public function addSchool($args)
    {
        // 檢查內容
        foreach ($args as $key => $arg) {
            if (!$arg) {
                throw new Exception($key . ' 為必填');
            }
            // TODO 檢查格式
        }

        return $this->schoolRepository->addSchool($args);
    }

    public function editSchool($id, $args)
    {
        if (!$args['id']) {
            throw new Exception('ID is Empty');
        }

        $school = $this->getSchoolById($args['id']);

        if (!$school) {
            throw new Exception('School does not exist');
        }

        // 檢查內容
        foreach ($args as $key => $arg) {
            if (!$arg) {
                throw new Exception($key . ' 為必填');
            }
            // TODO 檢查格式
        }

        return $this->schoolRepository->editSchool($id, $args);
    }
}