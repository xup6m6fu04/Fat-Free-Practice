<?php

namespace App\Controllers;

use App\Services\ClassService;
use App\Services\ClassStudentService;
use App\Services\ClassTeacherService;
use App\Services\SchoolService;
use App\Services\StudentService;
use App\Services\TeacherService;
use App\Traits\LoggerTrait;
use Exception;
use Monolog\Logger;

class LoginController extends Controller
{
    protected $f3;
    protected $db;
    protected $schoolService;
    protected $classService;
    protected $studentService;
    protected $teacherService;
    protected $classStudentService;
    protected $classTeacherService;

    use LoggerTrait;

    public function __construct()
    {
        global $f3;
        $this->f3 = $f3;
        $this->db = $f3->get('db');
        $this->schoolService = new SchoolService();
        $this->classService = new ClassService();
        $this->studentService = new StudentService();
        $this->teacherService = new TeacherService();
        $this->classStudentService = new ClassStudentService();
        $this->classTeacherService = new ClassTeacherService();
    }

    public function pageLogin()
    {
        $this->template('login.html');
    }
}