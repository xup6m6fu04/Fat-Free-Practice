<?php

namespace App\Controllers;

use App\Services\TeacherService;
use App\Traits\LoggerTrait;
use Carbon\Carbon;
use Exception;
use Monolog\Logger;

class TeacherController extends Controller
{
    protected $f3;
    protected $db;
    protected $teacherService;

    use LoggerTrait;

    public function __construct()
    {
        global $f3;
        $this->f3 = $f3;
        $this->db = $f3->get('db');
        $this->teacherService = new TeacherService();
    }

    public function pageTeacher()
    {
        // 取得所有老師資料
        $this->f3->set('teachers', $this->teacherService->getAllTeachers());
        return $this->template('teacher.html');
    }

    public function addTeacher()
    {
        try {

            // 新增一個老師
            $args = [];
            $args['id']         = ($this->f3->get('POST.id'))        ?? false;
            $args['school_id']  = ($this->f3->get('POST.school_id')) ?? false;
            $args['name']       = ($this->f3->get('POST.name'))      ?? false;
            $args['email']      = ($this->f3->get('POST.email'))     ?? false;
            $args['password']   = ($this->f3->get('POST.password'))  ?? false;
            $args['enable']     = ($this->f3->get('POST.enable'))    ?? false;
            $args['created_at'] = Carbon::now();
            $args['updated_at'] = Carbon::now();

            // 新增資料
            $this->teacherService->addTeacher($args);

            return_json(['type' => 'success']);

        } catch (Exception $ex) {

            $this->Log($ex, Logger::ERROR);

            return_json([
                'type' => 'error',
                'message' => $ex->getMessage()
            ]);

        }
    }

    public function editTeacher()
    {

        try {

            // 編輯一個老師
            $args = [];
            $args['id']           = ($this->f3->get('POST.id'))           ?? false;
            $args['school_id']    = ($this->f3->get('POST.school_id'))    ?? false;
            $args['name']         = ($this->f3->get('POST.name'))         ?? false;
            $args['email']        = ($this->f3->get('POST.email'))        ?? false;
            // $args['password']     = ($this->f3->get('POST.password'))     ?? false;
            $args['enable']       = ($this->f3->get('POST.enable'))       ?? false;
            $args['updated_at']   = Carbon::now();

            $this->teacherService->editTeacher($args['id'], $args);

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