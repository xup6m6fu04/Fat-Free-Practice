<?php

if (!function_exists('return_json')) {
    function return_json($data)
    {
        header("Content-Type: application/json; charset=utf-8");
        die(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }
}

if (!function_exists('to_Array')) {
    function to_Array($objs)
    {
        $result = [];

        foreach ($objs as $key => $obj) {
            $result[$key] = $obj;
        }

        return $result;
    }
}

if (!function_exists('to_Array_two')) {
    function to_Array_two($objs)
    {
        $result = [];

        foreach ($objs as $key => $obj) {
            foreach($obj as $key2 => $l_obj) {
                $result[$key][$key2] = $l_obj;
            }
        }

        return $result;
    }
}

if (!function_exists('paginate')) {
    function paginate($data_nums, $page = 1, $per = 20)
    {
        $page = (int)($page);
        $per = (int)($per);

        if ($page <= 0 || !is_int($page)) {
            $page = 1;
        }

        if ($per <= 0 || !is_int($per)) {
            $per = 20;
        }

        $pages = ceil($data_nums / $per);
        $start = ($page - 1) * $per;

        return [
            'sql_limit_start' => $start,
            'sql_limit_end'   => $per,
            'data_nums'       => $data_nums,
            'total_pages'     => $pages,
            'page'            => $page,
            'per'             => $per
        ];
    }
}