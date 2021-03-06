<?php

namespace App\Controllers;

use App\Services\ClassService;
use App\Services\ClassStudentService;
use App\Services\SchoolService;
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
    protected $schoolService;
    protected $classStudentService;
    protected $classService;

    use LoggerTrait;

    public function __construct()
    {
        global $f3;
        $this->f3 = $f3;
        $this->db = $f3->get('db');
        $this->studentService = new StudentService();
        $this->schoolService = new SchoolService();
        $this->classStudentService = new ClassStudentService();
        $this->classService = new ClassService();
    }

    public function pageStudent()
    {
        $key_word = ($this->f3->get('GET.key_word')) ?? false;

        if ($key_word) {
            $key_word = '%' . $key_word . '%';
            $data_nums = $this->studentService->countStudentsByKeyWord($key_word);
        } else {
            $data_nums = $this->studentService->countAllStudents();
        }

        $page = ($this->f3->get('GET.page')) ?? 1;
        $per = ($this->f3->get('GET.per')) ?? 20;

        $args = paginate($data_nums, $page, $per);

        $students = $this->studentService->getStudentByParams($args, $key_word);
        $schools = $this->schoolService->getAllSchools();

        $this->f3->set('students', $students);
        $this->f3->set('schools', $schools);
        $this->f3->set('page', $args);

        $this->template('student.html');
    }

    public function addStudent()
    {
        try {
            // 新增一個學生
            $args = [];
            $args['student_id']   = ($this->f3->get('POST.student_id'))   ?? false;
            $args['name']         = ($this->f3->get('POST.name'))         ?? false;
            $args['email']        = ($this->f3->get('POST.email'))        ?? false;
            $args['password']     = ($this->f3->get('POST.password'))     ?? false;
            $args['enable']       = ($this->f3->get('POST.enable'))       ?? false;

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

    public function addStudentWithSchoolAndClass()
    {
        try {
            // 新增一個學生 含有 school and class 需檢查
            $args = [];
            $args['student_id']   = ($this->f3->get('POST.student_id'))   ?? false;
            $args['school_id']    = ($this->f3->get('POST.school_id'))    ?? false;
            $args['class_id']     = ($this->f3->get('POST.class_id'))     ?? false;
            $args['name']         = ($this->f3->get('POST.name'))         ?? false;
            $args['email']        = ($this->f3->get('POST.email'))        ?? false;
            $args['password']     = ($this->f3->get('POST.password'))     ?? false;
            $args['enable']       = ($this->f3->get('POST.enable'))       ?? false;

            // class
            $class = $this->classService->getClassByClassId($args['class_id']);
            if (!$class) {
                throw new Exception('Class Not Found');
            }
            if ($class->school_id != $args['school_id']) {
                throw new Exception('Class and School Not Match');
            }

            // 新增學生
            $this->studentService->addStudent($args);

            // 搭配班級
            $this->classStudentService->addClassStudent($args);

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
            $args['student_id']   = ($this->f3->get('POST.student_id'))   ?? false;
            $args['name']         = ($this->f3->get('POST.name'))         ?? false;
            $args['email']        = ($this->f3->get('POST.email'))        ?? false;
            // $args['password']     = ($this->f3->get('POST.password'))     ?? false;
            $args['enable']       = ($this->f3->get('POST.enable'))       ?? false;

            $this->studentService->editStudent($args['student_id'], $args);

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

    public function getStudentByStudentId()
    {
        try {

            $student_id = ($this->f3->get('POST.student_id')) ?? false;

            $student = $this->studentService->getStudentByStudentId($student_id, 'load');

            if (!$student) {
                throw new Exception('Student Not Found');
            }

            return_json([
                'type' => 'success',
                'student' => to_Array($student)
            ]);

        } catch (Exception $ex) {

            $this->Log($ex, Logger::ERROR);

            return_json([
                'type' => 'error',
                'message' => $ex->getMessage()
            ]);

        }
    }

    public function getClassAndSchoolByStudentId()
    {
        try {
            $student_id = ($this->f3->get('POST.student_id')) ?? false;

            $student = $this->studentService->getStudentByStudentId($student_id, 'load');

            if (!$student) {
                throw new Exception('Student Not Found');
            }

            $class_student = $this->classStudentService->getByStudentId($student_id);
            $class = $this->classService->getClassByClassId($class_student->class_id);
            $school = $this->schoolService->getSchoolBySchoolId($student->school_id);
            $all_class = $this->classService->getClassBySchoolId($school->school_id);

            return_json([
                'type'          => 'success',
                'student'       => to_Array($student),
                'class_student' => to_Array($class_student),
                'class'         => to_Array($class),
                'school'        => to_Array($school),
                'all_class'     => to_Array_two($all_class)
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