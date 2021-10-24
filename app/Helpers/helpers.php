<?php

use Illuminate\Support\Str;

if (! function_exists('randomString')) {
    function randomString($number = 8,$prefix = null)
    {
        $prefixCode = '';

        if($prefix){
            $prefixCode = $prefix.'_';
        }

        return strtoupper($prefixCode.''.Str::random($number));
    }
}