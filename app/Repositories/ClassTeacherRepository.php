<?php


namespace App\Repositories;

use App\ClassTeacher;
use Carbon\Carbon;
use Exception;

class ClassTeacherRepository
{
    public function addClassTeacher($args)
    {
        $class_teacher = new ClassTeacher();
        $class_teacher->class_id     = $args['class_id'];
        $class_teacher->teacher_id   = $args['teacher_id'];
        $class_teacher->created_at   = Carbon::now()->timestamp;
        $class_teacher->updated_at   = Carbon::now()->timestamp;
        $class_teacher->save();

        return $class_teacher;
    }

    public function editClassTeacher($id, $args)
    {
        $class_teacher = $this->getClassTeachers(['id' => $id], 'load');

        $class_teacher->class_id     = $args['class_id'];
        $class_teacher->teacher_id   = $args['teacher_id'];
        $class_teacher->updated_at   = Carbon::parse($args['updated_at'])->timestamp;
        $class_teacher->save();

        return $class_teacher;
    }

    public function deleteClassTeacher($teacher_id)
    {
        $class_teacher = $this->getClassTeachers(['teacher_id' => $teacher_id], 'find');
        foreach ($class_teacher as $value) {
            $value->erase();
        }
    }

    public function getClassTeachers($args = [], $type = 'find', $key_word = false)
    {
        $connect = ($key_word) ? 'OR ' : 'AND ';
        $symbol = ($key_word) ? 'like ' : '= ';
        $bind_arr[0] = ($key_word) ? '' : '    1=1  ';

        $id            = $args['id']            ?? false;
        $class_id      = $args['class_id']      ?? false;
        $teacher_id    = $args['teacher_id']    ?? false;
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
        if ($teacher_id) {
            $bind_arr[0] .= $connect . ' teacher_id ' . $symbol . ' :teacher_id ';
            $bind_arr[':teacher_id'] = $teacher_id;
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

        $class_teacher = new ClassTeacher();
        return $class_teacher->$type($bind_arr);

    }
}