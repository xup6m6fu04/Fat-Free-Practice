<?php

namespace App;

use DB\SQL\Mapper;

class ClassStudent extends Mapper
{
    protected $table = 'class_students';

    public function __construct()
    {
        global $f3;
        parent::__construct($f3->get('db'), $this->table);
    }
}