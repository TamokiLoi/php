<?php

namespace App\ImageStore\Facades;
use Illuminate\Support\Facades\Facade;
use App\ImageStore\ToolFactory;

class Tool extends Facade
{
    protected static function getFacadeAccessor()
    { 
        return ToolFactory::class;
    }
}
