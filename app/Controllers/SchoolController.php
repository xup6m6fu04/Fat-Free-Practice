<?php


namespace App\Controllers;

use App\Services\SchoolService;
use App\Traits\LoggerTrait;
use Carbon\Carbon;
use Exception;
use Monolog\Logger;

class SchoolController extends Controller
{
    protected $f3;
    protected $db;
    protected $schoolService;

    use LoggerTrait;

    public function __construct()
    {
        global $f3;
        $this->f3 = $f3;
        $this->db = $f3->get('db');
        $this->schoolService = new SchoolService();
    }

    public function pageSchool()
    {
        $key_word = ($this->f3->get('GET.key_word')) ?? false;
        if ($key_word) {
            $key_word = '%' . $key_word . '%';
            $data_nums = $this->schoolService->countSchoolsByKeyWord($key_word);
        } else {
            $data_nums = $this->schoolService->countAllSchools();
        }

        $page = ($this->f3->get('GET.page')) ?? 1;
        $per = ($this->f3->get('GET.per')) ?? 20;

        $args = paginate($data_nums, $page, $per);

        $schools = $this->schoolService->getSchoolByParams($args, $key_word);

        $this->f3->set('schools', $schools);
        $this->f3->set('page', $args);

        $this->template('school.html');
    }

    public function addSchool()
    {
        try {
            // 新增一個學校
            $args = [];
            $args['school_id']    = ($this->f3->get('POST.school_id'))    ?? false;
            $args['name']         = ($this->f3->get('POST.name'))         ?? false;
            $args['enable']       = ($this->f3->get('POST.enable'))       ?? false;

            // 新增資料
            $this->schoolService->addSchool($args);

            return_json(['type' => 'success']);

        } catch (Exception $ex) {
            $this->Log($ex, Logger::ERROR);

            return_json([
                'type' => 'error',
                'message' => $ex->getMessage()
            ]);

        }
    }

    public function editSchool()
    {

        try {
            // 編輯一個學校
            $args = [];
            $args['school_id']    = ($this->f3->get('POST.school_id'))    ?? false;
            $args['name']         = ($this->f3->get('POST.name'))         ?? false;
            $args['enable']       = ($this->f3->get('POST.enable'))       ?? false;

            $this->schoolService->editSchool($args['school_id'], $args);

            return_json([
                'type' => 'success'
            ]);

        } catch (Exception $ex) {
            $this->Log($ex, Logger::ERROR);

            return_json([
                'type' => 'error',
                'message' => $ex->getMessage()
            ]);

        }

    }

    public function getSchoolBySchoolId()
    {
        try {
            $school_id = ($this->f3->get('POST.school_id')) ?? false;
            $school = $this->schoolService->getSchoolBySchoolId($school_id, 'load');

            if (!$school) {
                throw new Exception('School Not Found');
            }

            return_json([
                'type' => 'success',
                'school' => to_Array($school)
            ]);

        } catch (Exception $ex) {
            $this->Log($ex, Logger::ERROR);

            return_json([
                'type' => 'error',
                'message' => $ex->getMessage()
            ]);

        }
    }
}