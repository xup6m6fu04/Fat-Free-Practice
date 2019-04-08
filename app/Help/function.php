<?php

if (!function_exists('return_json')) {
    function return_json($data)
    {
        header("Content-Type: application/json; charset=utf-8");
        die(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }
}