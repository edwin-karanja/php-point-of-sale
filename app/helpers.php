<?php

if (!function_exists('on_page')) {
    function on_page($path)
    {
        return request()->is($path) || strpos(request()->path(), $path) !== false ? true : false;
    }
}

if (!function_exists('return_if')) {
    function return_if($condition, $value)
    {
        if ($condition) {
            return $value;
        }
    }
}