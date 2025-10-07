<?php

namespace GIS\CategoryProduct\Templates;


use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Interfaces\ModifierInterface;

class ProductShowThumb implements ModifierInterface
{
    public function apply(ImageInterface $image): ImageInterface
    {
        return $image->cover(77, 77);
    }
}
