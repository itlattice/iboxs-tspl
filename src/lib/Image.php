<?php
namespace iboxs\tspl\lib;

use iboxs\basic\Basic;
use Exception;
use iboxs\tspl\code\CodeRun;

class Image extends Base
{
    protected $baseImage;

    public function createImage(){
        $baseImageCode=$this->tsplArr[0];
        if(!Basic::startWith($baseImageCode,"SIZE")){
            throw new Exception('首行必须是SIZE指令，便于生成图片底图');
        }
        $baseImageCode=trim(str_replace("SIZE","",$baseImageCode));
        $exp=explode(",",$baseImageCode);
        if(count($exp)<2){
            throw new Exception('SIZE指令错误【'.$baseImageCode.'】,Line:1');
        }
        $kd=trim(str_replace("mm","",$exp[0]));
        $gd=trim(str_replace("mm","",$exp[1]));
        $kd=trim(str_replace("MM","",$kd));
        $gd=trim(str_replace("MM","",$gd));
        $this->createBaseImage($kd,$gd);
        $this->runCode();
        return $this;
    }

    public function base64()
    {
        ob_start();
        imagepng($this->baseImage);
        $image_data = ob_get_clean();
        imagedestroy($this->baseImage);
        $base64_image = base64_encode($image_data);
        return $base64_image;
    }

    private function createBaseImage($kd,$gd)
    {
        $resolution=8;
        $width_px = $kd * $resolution;
        $height_px = $gd * $resolution;
        $image = imagecreatetruecolor($width_px, $height_px);
        $white = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $white);
        $this->baseImage=$image;
    }

    private function runCode()
    {
        $code=new CodeRun($this->tsplArr,$this->baseImage);
        $this->baseImage=$code->run();
    }
}
?>
