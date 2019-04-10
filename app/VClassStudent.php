<?php

namespace App;

use DB\SQL\Mapper;

class VClassStudent extends Mapper
{
    //***** WARNING *****//
    //                   //
    //   此表為檢視表，    //
    //   僅可作為查詢使用  //
    //                   //
    //***** WARNING *****//

    protected $table = 'v_class_students';

    public function __construct()
    {
        global $f3;
        parent::__construct($f3->get('db'), $this->table);
    }
}