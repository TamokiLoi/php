<?php

use App\ImageStore\Facades\Tool;

if (!function_exists('getThumbnail')) {
    function get_thumbnail($fileName, $suffix = '_thumb')
    {
        return Tool::getThumbnail($fileName, $suffix);
    }
}
