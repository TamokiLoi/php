<?php

use App\ImageStore\Facades\Tool;

if (!function_exists('getThumbnail')) {
    function get_thumbnail($fileName)
    {
        return Tool::getThumbnail($fileName);
    }
}
