<?php
/**
* @windows 打印类（js版）
* @auth Mr.Y
*/
class Printer2Jquery{
    //开始打印
    function Printer($goodsArr){
        $PrinterHtml = '';
        $PrinterHtml .= '<!doctype html>
        <html>
        <head>
        <meta charset="utf-8">
        <title>jQuery打印插件</title>
        <script language="javascript" src="jquery-1.4.4.min.js"></script>
        <!-- 
        如果您使用的是高版本jQuery调用下面jQuery迁移辅助插件即可
        <script src="http://www.jq22.com/jquery/jquery-migrate-1.2.1.min.js"></script>
        -->
        <script language="javascript" src="jquery.jqprint-0.3.js"></script>
        
        <script language="javascript">
        $(document).ready(function() {
            print();
        });
        function print(){
            $("#print").jqprint();
        }
        </script>
        </head>
        <body>
        <div id="print">
        <table width="100%" border="0" style="font-size:8px; margin:0; padding:0px;">
          <tr>
            <td colspan="4"><h3 align="center">消费凭条</h3></td>
          </tr>
          <tr>
            <td>地&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;址：</td>
            <td colspan="3">'.$goodsArr['order_info']['address'].'</td>
            </tr>
          <tr>
            <td>收&nbsp;&nbsp;银&nbsp;&nbsp;员：</td>
            <td colspan="3">'.$goodsArr['order_info']['name'].'</td>
            </tr>
          <tr>
            <td>订单编号：</td>
            <td colspan="3">'.$goodsArr['order_info']['order_no'].'</td>
            </tr>
          <tr>
            <td>商品</td>
            <td>价格</td>
            <td>数量</td>
            <td>小计</td>
          </tr>
         ';
        foreach ($goodsArr['goodsArr'] as $key => $value){
            $total = $value['num'] * $value['price'];
            $PrinterHtml .='
              <tr>
                <td>'.$value['goods_name'].'</td>
                <td>￥'.$value['price'].'</td>
                <td>'.$value['num'].'</td>
                <td>￥'.$total.'</td>
              </tr>
             ';
        }
         $PrinterHtml .='
          <tr>
            <td>合计：</td>
            <td colspan="3">￥'.$goodsArr['order_info']['total'].'</td>
            </tr>
          <tr>
            <td>会员ID：</td>
            <td colspan="3">'.$goodsArr['order_info']['tel'].'</td>
            </tr>
        
        </table>
        </div>
        <!--input onClick="print()" type="button" value="打印"-->
        </body>
        </html>
        ';
        return $PrinterHtml;
    }

    //编码转换
    function iconvs($content)
    {
        //$text = iconv('utf-8','gbk',$content);
        $text = mb_convert_encoding($content, "GBK", "utf-8");
        return $text;
    }

}
