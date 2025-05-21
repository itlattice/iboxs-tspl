<?php

namespace iboxs\tspl\code\lib;

class TEXT extends Base
{
    public function run()
    {
        $arr=$this->expCode($this->code);
        if(count($arr)<7){
            $this->error('错误：TEXT指令至少需要5个参数');
            return;
        }
        $x=$arr[0];
        $y=$arr[1];
        $font=$arr[2];
        $rotation=$arr[3];
        $xMultiplication=$arr[4];
        $yMultiplication=$arr[5];
        $content=$arr[6];
        if(count($arr)>7){
            for($i=7;$i<count($arr);$i++){
                $content.=",".$arr[$i];
            }
        }
        $font=trim($font,"\"");
        $content=trim($content,"\"");
        switch($font){
            case 'TST24.BF2': //简体中文24*24
            case 'TSS24.BF2': //繁体中文24*24
                $this->TSS24BF2($x,$y,$rotation,$xMultiplication,$yMultiplication,$content);
                break;
            default:
                $this->error('不支持的字体:'.$font);
        }
        return $this->img;
    }

    private function TSS24BF2($x,$y,$rotation,$xMultiplication,$yMultiplication,$content){
        $basicX=16;
        $basicY=16;
        $charWidthPx = $basicX*$xMultiplication;   // 单个字符横向像素大小
        $charHeightPx = $basicY*$yMultiplication;  // 单个字符纵向像素大小
        $fontPath = __DIR__ . '/../../resouce/fonts/simhei.ttf'; // 请确保此字体文件存在
        if(!file_exists($fontPath)){
            dd('');
        }
        $fontSize = $this->calculateFontSizeForCharHeight($fontPath, $charHeightPx);
        $textColor = imagecolorallocate($this->img, 0, 0, 0);
        $ascent =$this-> getFontAscent($fontPath, $fontSize);
        $this->drawTextWithCharSizeAndAngle($this->img, $content, $fontPath, $fontSize, $rotation, $x, $y, $textColor, $charWidthPx,$ascent);
    }


    function getFontAscent($fontPath, $fontSize) {
        $box = imagettfbbox($fontSize, 0, $fontPath, 'W');
        return abs($box[7]); // 返回从基线到最高点的距离
    }

    /**
     * 计算适合字符高度的字体大小
     */
    function calculateFontSizeForCharHeight($fontPath, $desiredHeight) {
        // 初始字体大小猜测
        $fontSize = $desiredHeight * 0.75;

        // 二分查找合适的字体大小
        $minSize = 1;
        $maxSize = 100;

        for ($i = 0; $i < 10; $i++) { // 10次迭代通常足够精确
            $box = imagettfbbox($fontSize, 0, $fontPath, 'W'); // 使用大写W作为最高字符的代表
            $actualHeight = abs($box[7] - $box[1]); // 计算高度

            if (abs($actualHeight - $desiredHeight) < 1) {
                break;
            }

            if ($actualHeight > $desiredHeight) {
                $maxSize = $fontSize;
                $fontSize = ($fontSize + $minSize) / 2;
            } else {
                $minSize = $fontSize;
                $fontSize = ($fontSize + $maxSize) / 2;
            }
        }

        return $fontSize;
    }

    /**
     * 绘制具有指定字符大小和旋转角度的文字
     */
    function drawTextWithCharSizeAndAngle($image, $text, $fontPath, $fontSize, $angle, $x, $y, $color, $charWidth, $ascent) {
        $length = mb_strlen($text);
        imagettftext($image, $fontSize, $angle, $x, $y+$ascent, $color, $fontPath, $text);
    }
}
