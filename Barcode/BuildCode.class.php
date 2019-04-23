<?php

class BuildCode{

    private $codebar = 'BCGcode39';
    private $font;              //字体样式
    private $color_black;       //条形码颜色
    private $color_white;       // 空白间隙颜色
    private $code;              //条码
    private $param;             //需要的数据
    private $path = './codeImg/';

    //构造函数
    function __construct($param){

        //引用class文件夹对应的类
        require('class/BCGFont.php');
        require('class/BCGColor.php');
        require('class/BCGDrawing.php');
        //条形码的编码格式
        include("class/{$this->codebar}.barcode.php");
        //加载字体大小
        $this->font = new BCGFont('class/font/Arial.ttf', 18);
        //输出预处理
        $this->arrayList($param);
        //颜色
        $this->color();
        //条码
        $this->code();
        //绘画
        $this->draw();
    }

    //返回信息
    function BuildCodeStart(){
        return $this->param;
    }

    //数据处理
    private function arrayList($param){
        if (is_array($param)){
            $this->param = $param['BARCode'].'.bmp';
        }else{
            $this->param = $param.'.bmp';
        }
    }

    //魔术方法
    function __set($name, $value){
        if (isset($this->$name)){
            $this->$name = $value;
        }else{
            $this->$name = '';
        }
    }

    function __get($name){
        if (isset($this->$name)){
            return $this->$name;
        }
    }
    //颜色
    private function color(){

        //颜色条形码
        $this->color_black = new BCGColor(0, 0, 0);
        $this->color_white = new BCGColor(255, 255, 255);

    }

    //条码
    private function code(){

        $this->code = new BCGcode39();
        $this->code->setScale(2); // Resolution
        $this->code->setThickness(30); // 条形码的厚度
        $this->code->setForegroundColor($this->color_black); // 条形码颜色
        $this->code->setBackgroundColor($this->color_white); // 空白间隙颜色
        $this->code->setFont($this->font); // Font (or 0)
        $code = explode('.',$this->param);
        $this->code->parse($code[0]); // 条形码需要的数据内容
    }

    //生成
    private function draw(){
        //根据以上条件绘制条形码
        $drawing = new BCGDrawing($this->path.$this->param, $this->color_white);
        $drawing->setBarcode($this->code);
        $drawing->draw();
        // 生成bmp格式的图片
        header('Content-Type: image/bmp');
        $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
    }

}

//$test = new BuildCode('15884591848');