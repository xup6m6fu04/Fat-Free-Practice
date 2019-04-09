<?php

namespace App;

use DB\SQL\Mapper;

class Classes extends Mapper
{
    protected $table = 'classes';

    public function __construct()
    {
        global $f3;
        parent::__construct($f3->get('db'), $this->table);
    }
}