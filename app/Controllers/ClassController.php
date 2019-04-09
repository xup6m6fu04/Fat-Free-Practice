<?php


namespace App\Controllers;

use App\Services\ClassService;
use App\Traits\LoggerTrait;
use Carbon\Carbon;
use Exception;
use Monolog\Logger;

class ClassController extends Controller
{
    protected $f3;
    protected $db;
    protected $classService;

    use LoggerTrait;

    public function __construct()
    {
        global $f3;
        $this->f3 = $f3;
        $this->db = $f3->get('db');
        $this->classService = new ClassService();
    }

    public function pageClass()
    {
        // 取得所有班級資料
        $this->f3->set('classes', $this->classService->getAllClasss());
        return $this->template('class.html');
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