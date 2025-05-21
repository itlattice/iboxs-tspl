<?php

namespace iboxs\tspl;

use iboxs\tspl\lib\Image;

class TSPL
{
    public static function createImage($tspl){
        $image=new Image($tspl);
        $image->createImage();
        return $image;
    }
}
