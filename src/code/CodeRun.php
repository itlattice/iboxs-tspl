<?php

namespace iboxs\tspl\code;

class CodeRun extends CodeBase
{
    public function run()
    {
//        try{
            foreach ($this->code as $code){
                $exp=explode(' ',$code);
                $zl=trim($exp[0]);
                $zl=strtoupper($zl);
                if(in_array($zl,$this->expireCode)){
                    continue;
                }
                $class="iboxs\\tspl\\code\\lib\\".$zl;
                if(!class_exists($class)){
                    throw new \Exception('尚不支持指令【'.$zl.'】');
                }
                $code=str_replace($zl,'',$code);
                $codeObj=new $class($this->baseImage,trim($code));
                $this->baseImage=$codeObj->run();
            }
//        } catch (\Exception $e) {
//            return $this->baseImage;
//        }



        return $this->baseImage;
    }
}
