<?php

namespace iboxs\tspl\code\lib;

use iboxs\basic\Basic;

class Base
{
    protected $img;

    protected $code;

    public function __construct($img,$code){
        $this->img = $img;
        $this->code = $code;
    }

    public function error($message)
    {
        throw new \Exception($message);
    }

    public function black($x,$y)
    {
        $black = imagecolorallocate($this->img, 0, 0, 0);
        imagesetpixel($this->img, $x, $y, $black);
    }

    public function expCode($code)
    {
        $arr=explode(",",$code);
        $result=[];
        $temp="";
        foreach ($arr as $k=>$item) {
            $item=ltrim($item);
            if(Basic::startWith($item,"\"")){
                if($temp!=""){
                    $temp.=','.$item;
                    $result[]=$temp;
                    $temp="";
                    continue;
                }
                if(Basic::endWith($item,"\"")){ //正常
                    $result[]=$item;
                } else{
                    $temp=$item;
                }
            } else{
                if(Basic::endWith($item,"\"")&&$temp!=""){
                    $temp.=','.$item;
                    $result[]=$temp;
                    $temp="";
                    continue;
                }
                $result[]=$item;
            }
        }
        foreach ($result as $k=>$item) {
            $result[$k]=trim($item);
            $result[$k]=trim($item,"\"");
        }
        return $result;
    }
}
