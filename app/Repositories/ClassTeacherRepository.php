<?php


namespace App\Repositories;

use App\ClassTeacher;

class ClassTeacherRepository
{
    public function addClassTeacher($args)
    {
        $class_teacher = new ClassTeacher();
        $class_teacher->id           = $args['id'];
        $class_teacher->class_id     = $args['class_id'];
        $class_teacher->teacher_id   = $args['teacher_id'];
        $class_teacher->created_at   = $args['created_at'];
        $class_teacher->updated_at   = $args['updated_at'];
        $class_teacher->save();

        return $class_teacher;
    }

    public function editClassTeacher($id, $args)
    {
        $class_teacher = $this->getClassTeachers(['id' => $id], 'load');

        $class_teacher->class_id     = $args['class_id'];
        $class_teacher->teacher_id   = $args['teacher_id'];
        $class_teacher->updated_at   = $args['updated_at'];
        $class_teacher->save();

        return $class_teacher;
    }

    public function getClassTeachers($args = [], $type = 'find')
    {
        $id            = $args['id']            ?? false;
        $class_id      = $args['class_id']      ?? false;
        $teacher_id    = $args['teacher_id']    ?? false;
        $created_start = $args['created_start'] ?? false;
        $created_end   = $args['created_at']    ?? false;
        $updated_start = $args['updated_start'] ?? false;
        $updated_end   = $args['updated_at']    ?? false;

        $bind_arr[0] = ' 1=1 ';

        if ($id) {
            $bind_arr[0] .= ' AND id=:id ';
            $bind_arr[':id'] = $id;
        }
        if ($class_id) {
            $bind_arr[0] .= ' AND class_id=:class_id ';
            $bind_arr[':class_id'] = $class_id;
        }
        if ($teacher_id) {
            $bind_arr[0] = ' AND teacher_id=:teacher_id ';
            $bind_arr[':teacher_id'] = $teacher_id;
        }
        if ($created_start) {
            $bind_arr[0] = ' AND created_at >=:created_start ';
            $bind_arr[':created_start'] = $created_start;
        }
        if ($created_end) {
            $bind_arr[0] = ' AND created_at <:created_end ';
            $bind_arr[':created_end'] = $created_end;
        }
        if ($updated_start) {
            $bind_arr[0] = ' AND updated_at >=:updated_start ';
            $bind_arr[':updated_start'] = $updated_start;
        }
        if ($updated_end) {
            $bind_arr[0] = ' AND updated_at <:updated_end ';
            $bind_arr[':updated_end'] = $updated_end;
        }

        $class_teacher = new ClassTeacher();
        return $class_teacher->$type($bind_arr);

    }
}