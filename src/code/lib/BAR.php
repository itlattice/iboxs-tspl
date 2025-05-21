<?php

namespace iboxs\tspl\code\lib;

class BAR extends Base
{
    public function run()
    {
        $arr=$this->expCode($this->code);
        if(count($arr)<4){
            $this->error('错误：BAR指令至少需要5个参数');
            return;
        }
        $x=$arr[0];
        $y=$arr[1];
        $width=$arr[2];
        $height=$arr[3];

        for($i=$x;$i<=($x+$width);$i++){
            for($j=$y;$j<=($y+$height);$j++){
                $this->black($i,$j);
            }
        }
        return $this->img;
    }
}
