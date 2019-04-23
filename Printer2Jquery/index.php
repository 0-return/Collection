<?php
header("Content-type:text/html;charset=utf-8");
include 'Printer2Jquery.php';
$order = array(
    'order_info'=>array(
        'address'=>'江阳店铺',
        'name' => '张三',
        'order_no' => 'ox123123',
        'total' => 10000,
        'tel' => 15884591848),
        'times' => '1231232',
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
            'money'=>43555,
        )
    )
);
$test = new Printer2Jquery();
echo $test->Printer($order);