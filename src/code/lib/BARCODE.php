<?php

namespace iboxs\tspl\code\lib;

class BARCODE extends Base
{
    public function run()
    {
        $arr=$this->expCode($this->code);
        if(count($arr)<9){
            $this->error('错误：BARCODE指令至少需要9个参数');
            return;
        }
        $x=$arr[0];
        $y=$arr[1];
        $codeType=trim($arr[2]);
        $height=$arr[3];
        $humanReadable=$arr[4];
        $rotation=$arr[5];
        $narrow=trim($arr[6]);
        $wide=trim($arr[7]);
        $codeType=trim($codeType,"\"");
        $content=$arr[8];
        if(count($arr)>9){
            for($i=9;$i<count($arr);$i++){
                $content.=",".$arr[$i];
            }
        }
        switch ($codeType){
            case '128':
                $this->create128BarCode($x,$y,$height,$humanReadable,$rotation,$wide,$content);
                break;
            default:
                $this->error('暂不支持条形码格式'. $codeType);
        }


        return $this->img;
    }

    private function create128BarCode($x,$y,$height,$humanReadable,$rotation,$wide,$content)
    {
        list($qrcode,$width)=$this->barCode($content,$height);
        imagecopy($this->img, $qrcode, $x, $y, 0, 0, $width, $height);  //二维码
    }

    public function barCode($content,$height=140,$weight=3,$weightFactory=3){
        $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
        $generator->useImagick();
        $code = $generator->getBarcode($content, $generator::TYPE_CODE_128,$weightFactory,$height);
        $gimage=imagecreatefromstring($code);
        return array(imagecreatefromstring($code),imagesx($gimage));
    }
}
