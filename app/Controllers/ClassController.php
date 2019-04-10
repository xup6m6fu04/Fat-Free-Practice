<?php


namespace App\Controllers;

use App\Services\ClassService;
use App\Services\ClassStudentService;
use App\Services\SchoolService;
use App\Services\VClassStudentService;
use App\Traits\LoggerTrait;
use Carbon\Carbon;
use Exception;
use Monolog\Logger;

class  ClassController extends Controller
{
    protected $f3;
    protected $db;
    protected $classService;
    protected $schoolService;
    protected $classStudentService;
    protected $vClassStudentService;

    use LoggerTrait;

    public function __construct()
    {
        global $f3;
        $this->f3 = $f3;
        $this->db = $f3->get('db');
        $this->classService = new ClassService();
        $this->schoolService = new SchoolService();
        $this->classStudentService = new ClassStudentService();
        $this->vClassStudentService = new VClassStudentService();
    }

    public function pageClass()
    {
        try {
            $school_id = ($this->f3->get('GET.school_id')) ?? false;
            $school = $this->schoolService->getSchoolById($school_id);

            if (!$school) {
                throw new Exception('School Not Found');
            }

            $this->f3->set('school', $school);
            $this->f3->set('classes', $this->classService->getClassBySchoolId($school_id));
            $this->template('class.html');

        } catch (Exception $ex) {
            $this->Log($ex, Logger::ERROR);
            $this->template('school.html');
        }

    }

    public function pageClassStudent()
    {
        try {
            $class_id = ($this->f3->get('GET.class_id')) ?? false;
            $class = $this->classService->getClassById($class_id);

            if (!$class) {
                throw new Exception('Class Not Found');
            }

            $school = $this->schoolService->getSchoolById($class->school_id);

            if (!$school) {
                throw new Exception('School Not Found');
            }

            $class_students = $this->vClassStudentService->getByClassId($class_id);

            $this->f3->set('school', $school);
            $this->f3->set('class', $class);
            $this->f3->set('class_students', $class_students);

            $this->template('class_student.html');

        } catch (Exception $ex) {

            $this->Log($ex, Logger::ERROR);
            $this->template('school.html');

        }
    }

    public function addClass()
    {
        try {
            // 新增一個班級
            $args = [];
            $args['id']           = ($this->f3->get('POST.id'))        ?? false;
            $args['school_id']    = ($this->f3->get('POST.school_id')) ?? false;
            $args['name']         = ($this->f3->get('POST.name'))      ?? false;
            $args['enable']       = ($this->f3->get('POST.enable'))    ?? false;
            $args['created_at']   = Carbon::now();
            $args['updated_at']   = Carbon::now();

            // 新增資料
            $this->classService->addClass($args);

            return_json(['type' => 'success']);

        } catch (Exception $ex) {
            $this->Log($ex, Logger::ERROR);

            return_json([
                'type' => 'error',
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function editClass()
    {

        try {
            // 編輯一個班級
            $args = [];
            $args['id']           = ($this->f3->get('POST.id'))     ?? false;
            $args['name']         = ($this->f3->get('POST.name'))   ?? false;
            $args['enable']       = ($this->f3->get('POST.enable')) ?? false;
            $args['updated_at']   = Carbon::now();

            $this->classService->editClass($args['id'], $args);

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

    public function getClassById()
    {
        try {
            $id = ($this->f3->get('POST.id')) ?? false;
            $class = $this->classService->getClassById($id, 'load');

            if (!$class) {
                throw new Exception('Class Not Found');
            }

            return_json([
                'type' => 'success',
                'class' => to_Array($class)
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