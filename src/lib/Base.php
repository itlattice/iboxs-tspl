<?php
namespace iboxs\tspl\lib;

class Base
{
    protected $tspl;
    protected $tsplArr;

    public function __construct($tspl)
    {
        $this->tspl = $tspl;
        $this->tsplArr = $this->exp($tspl);
    }

    private function exp($tspl){
        $arr=explode("\n", $tspl);
        $result=[];
        foreach ($arr as $item) {
            $item=trim($item);
            if($item==""){
                continue;
            }
            $data=strtoupper($item);
            if(in_array($data,['CLS','PRINT 1'])){
                continue;
            }
            $result[]=$item;
        }
        return $result;
    }
}
?>
