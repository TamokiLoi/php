<?php

namespace App\ImageStore;

class ToolFactory
{
    public function getThumbnail($fileName, $suffix = '_thumb')
    {
        if ($fileName) {
            // 2019-08/6dcf93b2cd4d91a40a268ae782b70f8b.jpg
            return preg_replace("/(.*)\.(.*)/i", "$1{$suffix}.$2", $fileName);
        }
        return '';
    }
}
