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

    public function countAllSchools()
    {
        return $this->schoolRepository->getSchools([], 'count');
    }

    public function countSchoolsByKeyWord($key_word)
    {
        $args = [
            'school_id' => $key_word,
            'name'      => $key_word,
            'enable'    => $key_word
        ];

        return $this->schoolRepository->getSchools($args, 'count', true);
    }

    /**
     * @param $args
     * @param bool $key_word
     * @return mixed
     */
    public function getSchoolByParams($args, $key_word = false)
    {
        if ($key_word) {
            $args['school_id'] = $key_word;
            $args['name']      = $key_word;
            $args['enable']    = $key_word;
        }

        // TODO : 好像該做點什麼
        return $this->schoolRepository->getSchools($args, 'find', $key_word);
    }

    public function getSchoolBySchoolId($school_id, $type = 'load')
    {
        if (!$school_id) {
            throw new Exception('School ID is empty');
        }

        return $this->schoolRepository->getSchools(['school_id' => $school_id], $type);
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

    public function editSchool($school_id, $args)
    {
        if (!$args['school_id']) {
            throw new Exception('School ID is Empty');
        }

        $school = $this->getSchoolBySchoolId($args['school_id']);

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

        return $this->schoolRepository->editSchool($school_id, $args);
    }
}