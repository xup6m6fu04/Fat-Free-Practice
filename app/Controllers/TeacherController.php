<?php

namespace App\Controllers;

use App\Repositories\TeacherRepository;
use App\Services\TeacherService;
use App\Teacher;
use DB\SQL\Mapper;

class TeacherController extends Controller
{
    protected $f3;
    protected $db;
    protected $teacherService;

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
        $this->f3->set('teachers', $this->teacherService->getAllTeacher());
        return $this->template('teacher.html');
    }


}