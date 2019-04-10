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
        // 取得所有學校資料
        $this->f3->set('schools', $this->schoolService->getAllSchools());
        return $this->template('school.html');
    }

    public function addSchool()
    {
        try {
            // 新增一個學校
            $args = [];
            $args['id']           = ($this->f3->get('POST.id'))           ?? false;
            $args['name']         = ($this->f3->get('POST.name'))         ?? false;
            $args['enable']       = ($this->f3->get('POST.enable'))       ?? false;
            $args['created_at']   = Carbon::now();
            $args['updated_at']   = Carbon::now();

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
            $args['id']           = ($this->f3->get('POST.id'))           ?? false;
            $args['name']         = ($this->f3->get('POST.name'))         ?? false;
            $args['enable']       = ($this->f3->get('POST.enable'))       ?? false;
            $args['updated_at']   = Carbon::now();

            $this->schoolService->editSchool($args['id'], $args);

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

    public function getSchoolById()
    {
        try {
            $id = ($this->f3->get('POST.id')) ?? false;
            $school = $this->schoolService->getSchoolById($id, 'load');

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