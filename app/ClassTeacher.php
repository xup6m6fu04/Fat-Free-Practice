<?php

namespace App;

use DB\SQL\Mapper;

class ClassTeacher extends Mapper
{
    protected $table = 'class_teachers';

    public function __construct()
    {
        global $f3;
        parent::__construct($f3->get('db'), $this->table);
    }
}