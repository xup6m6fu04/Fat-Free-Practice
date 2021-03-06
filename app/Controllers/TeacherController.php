<?php

namespace App\Controllers;

use App\Services\ClassService;
use App\Services\ClassStudentService;
use App\Services\ClassTeacherService;
use App\Services\SchoolService;
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
    protected $schoolService;
    protected $classStudentService;
    protected $classService;
    protected $classTeacherService;

    use LoggerTrait;

    public function __construct()
    {
        global $f3;
        $this->f3 = $f3;
        $this->db = $f3->get('db');
        $this->teacherService = new TeacherService();
        $this->schoolService = new SchoolService();
        $this->classStudentService = new ClassStudentService();
        $this->classService = new ClassService();
        $this->classTeacherService = new ClassTeacherService();
    }

    public function pageTeacher()
    {
        $key_word = ($this->f3->get('GET.key_word')) ?? false;
        if ($key_word) {
            $key_word = '%' . $key_word . '%';
            $data_nums = $this->teacherService->countTeachersByKeyWord($key_word);
        } else {
            $data_nums = $this->teacherService->countAllTeachers();
        }

        $page = ($this->f3->get('GET.page')) ?? 1;
        $per = ($this->f3->get('GET.per')) ?? 20;

        $args = paginate($data_nums, $page, $per);

        $teachers = $this->teacherService->getTeacherByParams($args, $key_word);
        $schools = $this->schoolService->getAllSchools();

        $this->f3->set('schools', $schools);
        $this->f3->set('teachers', $teachers);
        $this->f3->set('page', $args);

        $this->template('teacher.html');
    }

    public function addTeacher()
    {
        try {
            // 新增一個老師
            $args = [];
            $args['teacher_id'] = ($this->f3->get('POST.teacher_id')) ?? false;
            $args['name']       = ($this->f3->get('POST.name'))       ?? false;
            $args['email']      = ($this->f3->get('POST.email'))      ?? false;
            $args['password']   = ($this->f3->get('POST.password'))   ?? false;
            $args['enable']     = ($this->f3->get('POST.enable'))     ?? false;
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
            $args['teacher_id']   = ($this->f3->get('POST.teacher_id'))   ?? false;
            $args['name']         = ($this->f3->get('POST.name'))         ?? false;
            $args['email']        = ($this->f3->get('POST.email'))        ?? false;
            // $args['password']     = ($this->f3->get('POST.password'))     ?? false;
            $args['enable']       = ($this->f3->get('POST.enable'))       ?? false;
            $args['updated_at']   = Carbon::now();

            $this->teacherService->editTeacher($args['teacher_id'], $args);

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

    public function getTeacherByTeacherId()
    {
        try {
            $teacher_id = ($this->f3->get('POST.teacher_id')) ?? false;
            $teacher = $this->teacherService->getTeacherByTeacherId($teacher_id, 'load');

            if (!$teacher) {
                throw new Exception('Teacher Not Found');
            }

            return_json([
                'type' => 'success',
                'teacher' => to_Array($teacher)
            ]);

        } catch (Exception $ex) {
            $this->Log($ex, Logger::ERROR);

            return_json([
                'type' => 'error',
                'message' => $ex->getMessage()
            ]);

        }
    }

    public function getClassAndSchoolByTeacherId()
    {
        try {
            $teacher_id = ($this->f3->get('POST.teacher_id')) ?? false;

            $teacher = $this->teacherService->getTeacherByTeacherId($teacher_id, 'load');

            if (!$teacher) {
                throw new Exception('Teacher Not Found');
            }

            $class_teacher = $this->classTeacherService->getByTeacherId($teacher_id, 'find');
            if (!$class_teacher) {
                $class = [];
            } else {
                $string = '';
                foreach ($class_teacher as $ctv) {
                    $string .= "'" . $ctv->class_id . "',";
                }
                $string = substr($string, 0, -1);

                $class = $this->classService->getClassInClassId($string);
            }

            $school = $this->schoolService->getSchoolBySchoolId($teacher->school_id);
            $all_school = $this->schoolService->getAllSchools();
            $all_class = $this->classService->getAllClasses();

            return_json([
                'type'          => 'success',
                'teacher'       => to_Array($teacher),
                'class_teacher' => to_Array_two($class_teacher),
                'class'         => to_Array_two($class),
                'school'        => to_Array($school),
                'all_school'    => to_Array_two($all_school),
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