<?php


namespace App\Repositories;

use App\Classes;
use App\Traits\LoggerTrait;
use Carbon\Carbon;
use Monolog\Logger;

class ClassRepository
{
    use LoggerTrait;

    protected $db;
    protected $f3;

    public function __construct()
    {
        global $f3;
        $this->f3 = $f3;
        $this->db = $f3->get('db');
    }

    public function addClass($args)
    {
        $class = new Classes();
        $class->class_id     = $args['class_id'];
        $class->school_id    = $args['school_id'];
        $class->name         = $args['name'];
        $class->enable       = $args['enable'];
        $class->created_at   = Carbon::now()->timestamp;
        $class->updated_at   = Carbon::now()->timestamp;
        $class->save();

        return $class;
    }

    public function editClass($id, $args)
    {
        $class = $this->getClasses(['id' => $id], 'load');

        $class->name         = $args['name'];
        $class->enable       = $args['enable'];
        $class->updated_at   = Carbon::parse($args['updated_at'])->timestamp;
        $class->save();

        return $class;
    }

    public function getClassesInClassId($string)
    {
        $classes = new Classes();
        return $classes->find("class_id IN ( " . $string . " )");
    }

    public function getClassesBySchoolId($args = [], $type = 'find', $key_word = false)
    {
        $connect = ($key_word) ? 'OR ' : 'AND ';
        $symbol = ($key_word) ? 'like ' : '= ';
        $verify = true;

        $class_id      = $args['class_id']      ?? false;
        $school_id     = $args['school_id']     ?? false;
        $name          = $args['name']          ?? false;
        // $password      = $args['password']      ?? false;
        $enable        = $args['enable']        ?? false;

        // SQL Params
        $limit_start  = $args['sql_limit_start']  ?? 0;
        $limit_end    = $args['sql_limit_end']    ?? 10;
        $order        = $args['sql_order']        ?? 'created_at';
        $sort         = $args['sql_sort']         ?? 'desc';

        $bind_arr[0] = '  school_id=:school_id AND ( ';

        if ($class_id) {
            $bind_arr[0] .= ($verify)
                ? ' class_id '. $symbol .' :class_id '
                : $connect . ' class_id '. $symbol .' :class_id ';
            $verify = false;
            $bind_arr[':class_id'] = $class_id;
        }
        if ($name) {
            $bind_arr[0] .= ($verify)
                ? ' name '. $symbol .' :name '
                : $connect . ' name '. $symbol .' :name ';
            $verify = false;
            $bind_arr[':name'] = $name;
        }
        if ($enable) {
            $bind_arr[0] .= ($verify)
                ? ' enable '. $symbol .' :enable '
                : $connect . ' enable '. $symbol .' :enable ';
            $verify = false;
            $bind_arr[':enable'] = $enable;
        }

        if ($verify) {
            $bind_arr[0] = '  school_id=:school_id ';
        } else {
            $bind_arr[0] .= ' ) ';
        }

        $bind_arr[':school_id'] = $school_id;

        $bind_arr[0] .= ' ORDER BY ' . $order . ' ' . $sort . ' LIMIT :limit_start, :limit_end ';
        $bind_arr[':limit_start'] = $limit_start;
        $bind_arr[':limit_end'] = $limit_end;


        $class = new Classes();
        return $class->$type($bind_arr);

    }

    public function getClasses($args = [], $type = 'find', $key_word = false)
    {
        $connect = ($key_word) ? 'OR ' : 'AND ';
        $symbol = ($key_word) ? 'like ' : '= ';
        $bind_arr[0] = ($key_word) ? '' : '    1=1  ';

        $id            = $args['id']            ?? false;
        $class_id      = $args['class_id']      ?? false;
        $school_id     = $args['school_id']     ?? false;
        $name          = $args['name']          ?? false;
        // $password      = $args['password']      ?? false;
        $enable        = $args['enable']        ?? false;
        $created_start = $args['created_start'] ?? false;
        $created_end   = $args['created_at']    ?? false;
        $updated_start = $args['updated_start'] ?? false;
        $updated_end   = $args['updated_at']    ?? false;

        // SQL Params
        $limit_start  = $args['sql_limit_start']  ?? 0;
        $limit_end    = $args['sql_limit_end']    ?? 999999;
        $order        = $args['sql_order']        ?? 'created_at';
        $sort         = $args['sql_sort']         ?? 'desc';

        if ($id) {
            $bind_arr[0] .= $connect . ' id '. $symbol .' :id ';
            $bind_arr[':id'] = $id;
        }
        if ($class_id) {
            $bind_arr[0] .= $connect . ' class_id '. $symbol .' :class_id ';
            $bind_arr[':class_id'] = $class_id;
        }
        if ($school_id) {
            $bind_arr[0] .= $connect . ' school_id ' . $symbol . ' :school_id ';
            $bind_arr[':school_id'] = $school_id;
        }
        if ($name) {
            $bind_arr[0] .= $connect . ' name ' . $symbol . ' :name ';
            $bind_arr[':name'] = $name;
        }
        if ($enable) {
            $bind_arr[0] .= $connect . ' enable ' . $symbol . ' :enable ';
            $bind_arr[':enable'] = $enable;
        }
        if ($created_start) {
            $bind_arr[0] .= ' AND created_at >=:created_start ';
            $bind_arr[':created_start'] = $created_start;
        }
        if ($created_end) {
            $bind_arr[0] .= ' AND created_at <:created_end ';
            $bind_arr[':created_end'] = $created_end;
        }
        if ($updated_start) {
            $bind_arr[0] .= ' AND updated_at >=:updated_start ';
            $bind_arr[':updated_start'] = $updated_start;
        }
        if ($updated_end) {
            $bind_arr[0] .= ' AND updated_at <:updated_end ';
            $bind_arr[':updated_end'] = $updated_end;
        }

        $bind_arr[0] .= ' ORDER BY ' . $order . ' ' . $sort . ' LIMIT :limit_start, :limit_end ';
        $bind_arr[':limit_start'] = $limit_start;
        $bind_arr[':limit_end'] = $limit_end;

        $bind_arr[0] = substr($bind_arr[0], 3);

        $class = new Classes();
        return $class->$type($bind_arr);

    }
}