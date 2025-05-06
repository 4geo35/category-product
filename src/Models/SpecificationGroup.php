<?php

namespace GIS\CategoryProduct\Models;

use GIS\CategoryProduct\Interfaces\SpecificationGroupInterface;
use Illuminate\Database\Eloquent\Model;

class SpecificationGroup extends Model implements SpecificationGroupInterface
{
    protected $fillable = [
        "title",
    ];
}
