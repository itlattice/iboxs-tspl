<?php

namespace iboxs\tspl\code;

class CodeBase
{
    protected $code;

    protected $baseImage;

    protected $expireCode;

    public function __construct($code,$img){
        $this->code = $code;
        $this->baseImage = $img;
        $this->expireCode = [
            'SIZE','GAP','PRINT'
        ];
    }
}
