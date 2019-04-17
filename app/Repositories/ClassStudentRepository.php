<?php


namespace App\Repositories;

use App\ClassStudent;
use Carbon\Carbon;

class ClassStudentRepository
{
    public function addClassStudent($args)
    {
        $class_student = new ClassStudent();
        $class_student->class_id     = $args['class_id'];
        $class_student->student_id   = $args['student_id'];
        $class_student->created_at   = Carbon::now()->timestamp;
        $class_student->updated_at   = Carbon::now()->timestamp;
        $class_student->save();

        return $class_student;
    }

    public function editClassStudent($student_id, $args)
    {
        $class_student = $this->getClassStudents(['student_id' => $student_id], 'load');

        $class_student->class_id     = $args['class_id'];
        $class_student->updated_at   = Carbon::now()->timestamp;
        $class_student->save();

        return $class_student;
    }

    public function getClassStudents($args = [], $type = 'find', $key_word = false)
    {
        $connect = ($key_word) ? 'OR ' : 'AND ';
        $symbol = ($key_word) ? 'like ' : '= ';
        $bind_arr[0] = ($key_word) ? '' : '    1=1  ';

        $id            = $args['id']            ?? false;
        $class_id      = $args['class_id']      ?? false;
        $student_id    = $args['student_id']    ?? false;
        $created_start = $args['created_start'] ?? false;
        $created_end   = $args['created_at']    ?? false;
        $updated_start = $args['updated_start'] ?? false;
        $updated_end   = $args['updated_at']    ?? false;

        // SQL Params
        $limit_start  = $args['sql_limit_start']  ?? 0;
        $limit_end    = $args['sql_limit_end']    ?? 10;
        $order        = $args['sql_order']        ?? 'created_at';
        $sort         = $args['sql_sort']         ?? 'desc';

        if ($id) {
            $bind_arr[0] .= $connect . ' id '. $symbol .' :id ';
            $bind_arr[':id'] = $id;
        }
        if ($class_id) {
            $bind_arr[0] .= $connect . ' class_id ' . $symbol . ' :class_id ';
            $bind_arr[':class_id'] = $class_id;
        }
        if ($student_id) {
            $bind_arr[0] .= $connect . ' student_id ' . $symbol . ' :student_id ';
            $bind_arr[':student_id'] = $student_id;
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

        $class_student = new ClassStudent();
        return $class_student->$type($bind_arr);

    }
}