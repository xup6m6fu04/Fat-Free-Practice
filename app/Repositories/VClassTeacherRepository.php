<?php


namespace App\Repositories;

use App\VClassTeacher;

class VClassTeacherRepository
{

    //***** WARNING *****//
    //                   //
    //   此表為檢視表，    //
    //   僅可作為查詢使用  //
    //                   //
    //***** WARNING *****//

    public function getVClassTeachers($args = [], $type = 'find', $key_word = false)
    {
        $connect = ($key_word) ? 'OR ' : 'AND ';
        $symbol = ($key_word) ? 'like ' : '= ';
        $bind_arr[0] = ($key_word) ? '' : '    1=1  ';

        $school_id     = $args['school_id']     ?? false;
        $class_id      = $args['class_id']      ?? false;
        $teacher_id    = $args['teacher_id']    ?? false;
        $name          = $args['name']          ?? false;
        $email         = $args['email']         ?? false;
        // $password      = $args['password']      ?? false;
        $enable        = $args['enable']        ?? false;
        $created_start = $args['created_start'] ?? false;
        $created_end   = $args['created_at']    ?? false;
        $updated_start = $args['updated_start'] ?? false;
        $updated_end   = $args['updated_at']    ?? false;

        // SQL Params
        $limit_start  = $args['sql_limit_start']  ?? 0;
        $limit_end    = $args['sql_limit_end']    ?? 10;
        $order        = $args['sql_order']        ?? 'created_at';
        $sort         = $args['sql_sort']         ?? 'desc';

        if ($school_id) {
            $bind_arr[0] .= $connect . ' school_id '. $symbol .' :school_id ';
            $bind_arr[':school_id'] = $school_id;
        }
        if ($class_id) {
            $bind_arr[0] .= $connect . ' class_id '. $symbol .' :class_id ';
            $bind_arr[':class_id'] = $class_id;
        }
        if ($teacher_id) {
            $bind_arr[0] .= $connect . ' teacher_id ' . $symbol . ' :teacher_id ';
            $bind_arr[':teacher_id'] = $teacher_id;
        }
        if ($name) {
            $bind_arr[0] .= $connect . ' name ' . $symbol . ' :name ';
            $bind_arr[':name'] = $name;
        }
        if ($email) {
            $bind_arr[0] .= $connect . ' email ' . $symbol . ' :email ';
            $bind_arr[':email'] = $email;
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

        $v_class_teacher = new VClassTeacher();
        return $v_class_teacher->$type($bind_arr);

    }
}