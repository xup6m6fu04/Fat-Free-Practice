<?php

if (!function_exists('return_json')) {

    function return_json($data)
    {
        header("Content-Type: application/json; charset=utf-8");
        die(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }

}

if(!function_exists('to_Array')) {

    function to_Array($objs)
    {
        $result = [];

        foreach ($objs as $key => $obj) {
            $result[$key] = $obj;
        }

        return $result;
    }

}