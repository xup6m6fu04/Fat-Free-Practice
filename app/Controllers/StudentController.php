<?php

namespace App\Controllers;

use App\Services\StudentService;
use App\Traits\LoggerTrait;
use Carbon\Carbon;
use Exception;
use Monolog\Logger;

class StudentController extends Controller
{
    protected $f3;
    protected $db;
    protected $studentService;

    use LoggerTrait;

    public function __construct()
    {
        global $f3;
        $this->f3 = $f3;
        $this->db = $f3->get('db');
        $this->studentService = new StudentService();
    }

    public function pageStudent()
    {
        // 取得所有學生資料
        $this->f3->set('students', $this->studentService->getAllStudents());
        return $this->template('student.html');
    }

    public function addStudent()
    {
        try {

            // 新增一個老師
            $args = [];
            $args['id']           = ($this->f3->get('POST.id'))           ?? false;
            $args['school_id']    = ($this->f3->get('POST.school_id'))    ?? false;
            $args['name']         = ($this->f3->get('POST.name'))         ?? false;
            $args['email']        = ($this->f3->get('POST.email'))        ?? false;
            $args['password']     = ($this->f3->get('POST.password'))     ?? false;
            $args['subscription'] = ($this->f3->get('POST.subscription')) ?? false;
            $args['enable']       = ($this->f3->get('POST.enable'))       ?? false;
            $args['created_at']   = Carbon::now();
            $args['updated_at']   = Carbon::now();

            // 新增資料
            $this->studentService->addStudent($args);

            return_json(['type' => 'success']);

        } catch (Exception $ex) {

            $this->Log($ex, Logger::ERROR);

            return_json([
                'type' => 'error',
                'message' => $ex->getMessage()
            ]);

        }
    }

    public function editStudent()
    {

        try {

            // 編輯一個學生
            $args = [];
            $args['id']           = ($this->f3->get('POST.id'))           ?? false;
            $args['school_id']    = ($this->f3->get('POST.school_id'))    ?? false;
            $args['name']         = ($this->f3->get('POST.name'))         ?? false;
            $args['email']        = ($this->f3->get('POST.email'))        ?? false;
            // $args['password']     = ($this->f3->get('POST.password'))     ?? false;
            $args['subscription'] = ($this->f3->get('POST.subscription')) ?? false;
            $args['enable']       = ($this->f3->get('POST.enable'))       ?? false;
            $args['updated_at']   = Carbon::now();

            $this->studentService->editStudent($args['id'], $args);

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


}