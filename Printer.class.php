<?php

/**
* @windows ��ӡ�� 
* @auth Mr.Y
* @����ǰ����ȷ����װptrinter.dll���
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
	* @purpose ��ӡ��ʼ
	* @param $goodsArr array ��ӡ������
	* @return null
	* @time 2017.8
	*/
    function Printer($goodsArr){
        $handle = printer_open('XP-58');
        printer_start_doc($handle, "doc name");
        printer_start_page($handle);
        printer_set_option($handle, PRINTER_MODE, "RAW");

        $this->prints($handle,'����ƾ��',10,10,0.6);
        $this->pintLine($handle,1,40,500,40);
        $this->prints($handle,"���̵�ַ��{$this->address}",10,80);
        $this->prints($handle,"�� �� Ա��{$this->name}",10,120);
        $this->prints($handle,"������ţ�{$this->order_no}",10,160);
        $this->pintLine($handle,1,190,500,190);
        $this->prints($handle,'��Ʒ',10,200);
        $this->prints($handle,'�۸�*����',140,200);
        $this->prints($handle,'���',290,200);
        $this->pintLine($handle,1,230,500,230);
        $position = 240;
        foreach ($goodsArr as $key => $value){
            $this->prints($handle,"{$value['goods_name']}",10,$position,0.4);
            $this->prints($handle,"{$value['price']}*{$value['num']}",140,$position,0.4);
            $this->prints($handle,"{$value['money']}",290,$position,0.4);
            $position += 40;
        }

        $this->pintLine($handle,1,$position+40,500,$position+40);
        $this->prints($handle,"�ϼƣ�{$this->total}",10,$position+50);
        $this->prints($handle,"��ԱID��{$this->tel}",10,$position+80);
        $this->prints($handle,"ʱ�䣺{$this->time}",10,$position+110);
        printer_end_page($handle);
        printer_end_doc($handle);
        printer_close($handle);
    }

	/**
	* @purpose ���ô�ӡ�������С
	* @param $multiple int&float����Խ������Խ��
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
	* @purpose ��ӡ����
	* @param $handle ���
	* @param $text text ����
	* @param $_x,$_y ƫ����
	* @param $multiple int&float����Խ������Խ��
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
	* @purpose ����ת��
	* @param $content ����
	* @return string
	* @time 2017.8
	*/
    function iconvs($content){
        //$text = iconv('UTF-8','GBK',$content);
        $text = mb_convert_encoding($content, "GBK", "GBK");
        return $text;
    }
	/**
	* @purpose ��ӡ����
	* @param $handle ���
	* @param $_x,$_y,$in_x,$in_y ƫ��������������ʼ�ͽ���λ�ã�
	* @return bool
	* @time 2017.8
	*/
    function pintLine($handle,$_x,$_y,$in_x,$in_y){
        printer_draw_line($handle,$_x,$_y,$in_x,$in_y);
        return true;
    }

	/**
	* @purpose ���壬��ʽ
	* @param $fontHeight ����߶�
	* @param $fontWidth ������
	* @param $fontWeight ������
	* @return string
	* @time 2017.8
	*/
    function generateFont($fontHeight,$fontWidth,$fontWeight=PRINTER_FW_BOLD){
        return printer_create_font("΢���ź�",$fontHeight,$fontWidth,$fontWeight,false,false,false,0);
    }
	/**
	* @purpose ��ӡͼƬ
	* @param $handle ���
	* @param $img_path ͼƬ·��
	* @param $_x,$_y ƫ����
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
    'order_info'=>array( 'address'=>'��������',
        'name'=>'����',
        'order_no'=>'ox123123',
        'total'=>10000,
        'tel'=>15884591848),
    'goodsArr'=>array(
        array('goods_name'=>'С��',
            'price'=>1255,
            'num'=>400,
            'money'=>43
        ),
        array('goods_name'=>'С�׹㷺',
            'price'=>124,
            'num'=>4,
            'money'=>43555
        ),
        array('goods_name'=>'С��',
            'price'=>124,
            'num'=>4,
            'money'=>43555
        ),
        array('goods_name'=>'С�׷���',
            'price'=>124,
            'num'=>4,
            'money'=>43555
        ),
        array('goods_name'=>'С��',
            'price'=>124,
            'num'=>4,
            'money'=>43555
        ),
        array('goods_name'=>'С�׸���',
            'price'=>124,
            'num'=>4,
            'money'=>43555
        ),
        array('goods_name'=>'С��65',
            'price'=>124,
            'num'=>4,
            'money'=>43555
        )
    )
);
$s = new Printer($order);