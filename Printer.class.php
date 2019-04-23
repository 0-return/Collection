<?php

/**
* @windows 打印类 
* @auth Mr.Y
* @运行前，请确保安装ptrinter.dll类库
*/
class Printer{
    const FONT_SIZE = 50;
    const RATIO = 0.5;
    const OTHER_FONT_SIZE_RATIO = 0.325;

    private $address;
    private $name;
    private $order_no;
    private $total;
    private $tel;
    private $codeImg;
    private $time;

    function __construct($order){
        foreach ($order['order_info'] as $k => $v){
            $this->$k = $this->iconvs($v);
        }
        $this->Printer($order['goodsArr']);
    }

    function __set($key,$value){
        if (isset($this->$key)){
            $this->$key = $value;
        }else{
            $this->$key = '';
        }
    }

    function __get($key){
        if (isset($this->$key)){
            return $this->$key;
        }else{
            return null;
        }
    }
	/**
	* @purpose 打印开始
	* @param $goodsArr array 打印的内容
	* @return null
	* @time 2017.8
	*/
    function Printer($goodsArr){
        $handle = printer_open('XP-58');
        printer_start_doc($handle, "doc name");
        printer_start_page($handle);
        printer_set_option($handle, PRINTER_MODE, "RAW");

        $this->prints($handle,'消费凭条',10,10,0.6);
        $this->pintLine($handle,1,40,500,40);
        $this->prints($handle,"店铺地址：{$this->address}",10,80);
        $this->prints($handle,"收 银 员：{$this->name}",10,120);
        $this->prints($handle,"订单编号：{$this->order_no}",10,160);
        $this->pintLine($handle,1,190,500,190);
        $this->prints($handle,'商品',10,200);
        $this->prints($handle,'价格*数量',140,200);
        $this->prints($handle,'金额',290,200);
        $this->pintLine($handle,1,230,500,230);
        $position = 240;
        foreach ($goodsArr as $key => $value){
            $this->prints($handle,"{$value['goods_name']}",10,$position,0.4);
            $this->prints($handle,"{$value['price']}*{$value['num']}",140,$position,0.4);
            $this->prints($handle,"{$value['money']}",290,$position,0.4);
            $position += 40;
        }

        $this->pintLine($handle,1,$position+40,500,$position+40);
        $this->prints($handle,"合计：{$this->total}",10,$position+50);
        $this->prints($handle,"会员ID：{$this->tel}",10,$position+80);
        $this->prints($handle,"时间：{$this->time}",10,$position+110);
        printer_end_page($handle);
        printer_end_doc($handle);
        printer_close($handle);
    }

	/**
	* @purpose 设置打印的字体大小
	* @param $multiple int&float数字越大，字体越大
	* @return string
	* @time 2017.8
	*/
    function getFont($multiple)
    {
        $fontWidth = $multiple * self::FONT_SIZE * self::RATIO;
        $fontHeight = $multiple * self::FONT_SIZE;
        $font =  $this->generateFont($fontHeight,$fontWidth,PRINTER_FW_BOLD);
        return $font;
    }
	/**
	* @purpose 打印内容
	* @param $handle 句柄
	* @param $text text 内容
	* @param $_x,$_y 偏移量
	* @param $multiple int&float数字越大，字体越大
	* @return bool
	* @time 2017.8
	*/
    function prints($handle,$text,$_x,$_y,$multiple = 0.5){
        $getFont = $this->getFont($multiple);
        printer_select_font($handle,$getFont);
        printer_draw_text($handle,$this->iconvs($text),$_x, $_y);
        printer_delete_font($getFont);
        return true;
    }
	/**
	* @purpose 编码转换
	* @param $content 内容
	* @return string
	* @time 2017.8
	*/
    function iconvs($content){
        //$text = iconv('UTF-8','GBK',$content);
        $text = mb_convert_encoding($content, "GBK", "GBK");
        return $text;
    }
	/**
	* @purpose 打印线条
	* @param $handle 句柄
	* @param $_x,$_y,$in_x,$in_y 偏移量（线条的起始和结束位置）
	* @return bool
	* @time 2017.8
	*/
    function pintLine($handle,$_x,$_y,$in_x,$in_y){
        printer_draw_line($handle,$_x,$_y,$in_x,$in_y);
        return true;
    }

	/**
	* @purpose 字体，样式
	* @param $fontHeight 字体高度
	* @param $fontWidth 字体宽度
	* @param $fontWeight 字体厚度
	* @return string
	* @time 2017.8
	*/
    function generateFont($fontHeight,$fontWidth,$fontWeight=PRINTER_FW_BOLD){
        return printer_create_font("微软雅黑",$fontHeight,$fontWidth,$fontWeight,false,false,false,0);
    }
	/**
	* @purpose 打印图片
	* @param $handle 句柄
	* @param $img_path 图片路径
	* @param $_x,$_y 偏移量
	* @return bool
	* @time 2017.8
	*/
    public function printBarCodeByImg($handle,$img_path,$_x,$_y)
    {
        printer_draw_bmp($handle, $img_path,$_x,$_y);
        return true;
    }

}

$order = array(
    'order_info'=>array( 'address'=>'江阳店铺',
        'name'=>'张三',
        'order_no'=>'ox123123',
        'total'=>10000,
        'tel'=>15884591848),
    'goodsArr'=>array(
        array('goods_name'=>'小米',
            'price'=>1255,
            'num'=>400,
            'money'=>43
        ),
        array('goods_name'=>'小米广泛',
            'price'=>124,
            'num'=>4,
            'money'=>43555
        ),
        array('goods_name'=>'小米',
            'price'=>124,
            'num'=>4,
            'money'=>43555
        ),
        array('goods_name'=>'小米方的',
            'price'=>124,
            'num'=>4,
            'money'=>43555
        ),
        array('goods_name'=>'小米',
            'price'=>124,
            'num'=>4,
            'money'=>43555
        ),
        array('goods_name'=>'小米更多',
            'price'=>124,
            'num'=>4,
            'money'=>43555
        ),
        array('goods_name'=>'小米65',
            'price'=>124,
            'num'=>4,
            'money'=>43555
        )
    )
);
$s = new Printer($order);