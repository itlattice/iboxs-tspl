<?php

namespace iboxs\tspl\code\lib;

class QRCODE extends Base
{
    public function run()
    {
        $arr=$this->expCode($this->code);
        if(count($arr)<7){
            $this->error('错误：QRCODE指令至少需要9个参数');
            return;
        }
        $x=$arr[0];
        $y=$arr[1];
        $eccLevel=$arr[2];
        $cellWidth=$arr[3];
//        $mode=$arr[4];
        $rolation=$arr[5];
        $content=$arr[6];
        $qrcode=$this->QrCode($content,$eccLevel,$cellWidth);
        imagecopy($this->img, $qrcode, $x, $y, 0, 0, $cellWidth*34, $cellWidth*34);
        return $this->img;
    }

    public function QrCode($content,$level='L',$size=7){
        require_once __DIR__.'/../basic/phpqrcode.php';
        $qrCode = new \QRcode();
        return $qrCode->image($content, false, $level, $size, 2);
    }
}
