<?php

namespace iboxs\tspl\code\lib;

class BOX extends Base
{
    public function run()
    {
        $arr=$this->expCode($this->code);
        if(count($arr)<5){
            $this->error('错误：BOX指令至少需要5个参数');
            return;
        }
        $xStart=$arr[0];
        $yStart=$arr[1];
        $xEnd=$arr[2];
        $yEnd=$arr[3];
        $lineWidth=$arr[4];

        for($i=$xStart;$i<=$xEnd;$i++){
            for($j=$yStart;$j<=($yStart+$lineWidth);$j++){
                $this->black($i,$j);
            }
        }
        for($i=$xStart;$i<=($xStart+$lineWidth);$i++){
            for($j=$yStart;$j<=$yEnd;$j++){
                $this->black($i,$j);
            }
        }
        for($i=($xEnd-$lineWidth);$i<=$xEnd;$i++){
            for($j=$yStart;$j<=$yEnd;$j++){
                $this->black($i,$j);
            }
        }
        for($i=$xStart;$i<=$xEnd;$i++){
            for($j=($yEnd-$lineWidth);$j<=$yEnd;$j++){
                $this->black($i,$j);
            }
        }
        return $this->img;
    }
}
