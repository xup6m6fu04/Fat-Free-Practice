<?php


namespace App\Repositories;

use App\Classes;

class ClassRepository
{
    public function addClass($args)
    {
        $class = new Classes();
        $class->id           = $args['id'];
        $class->school_id    = $args['school_id'];
        $class->name         = $args['name'];
        $class->enable       = $args['enable'];
        $class->created_at   = $args['created_at'];
        $class->updated_at   = $args['updated_at'];
        $class->save();

        return $class;
    }

    public function editClass($id, $args)
    {
        $class = $this->getClasses(['id' => $id], 'load');

        $class->name         = $args['name'];
        $class->enable       = $args['enable'];
        $class->updated_at   = $args['updated_at'];
        $class->save();

        return $class;
    }

    public function getClasses($args = [], $type = 'find')
    {
        $id            = $args['id']            ?? false;
        $school_id     = $args['school_id']     ?? false;
        $name          = $args['name']          ?? false;
        $enable        = $args['enable']        ?? false;
        $created_start = $args['created_start'] ?? false;
        $created_end   = $args['created_at']    ?? false;
        $updated_start = $args['updated_start'] ?? false;
        $updated_end   = $args['updated_at']    ?? false;

        $bind_arr[0] = ' 1=1 ';

        if ($id) {
            $bind_arr[0] .= ' AND id=:id ';
            $bind_arr[':id'] = $id;
        }
        if ($school_id) {
            $bind_arr[0] .= ' AND school_id=:school_id ';
            $bind_arr[':school_id'] = $school_id;
        }
        if ($name) {
            $bind_arr[0] = ' AND name=:name ';
            $bind_arr[':name'] = $name;
        }
        if ($enable) {
            $bind_arr[0] = ' AND enable=:enable ';
            $bind_arr[':enable'] = $enable;
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

        $class = new Classes();
        return $class->$type($bind_arr);

    }
}