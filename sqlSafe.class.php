<?php

/**
 * Create by .
 * Cser Administrator
 * Time 11:27
 * note:验证数据传输
 */
class sqlSafe
{
    //get方式
    private $getfilter = "'|(and|or)\\b.+?(>|<|=|in|like)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
    //post方式
    private $postfilter = "\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
    //获取cookie内的数据
    private $cookiefilter = "\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|UPDATE.+?SET|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";

    //构造函数
    public function __construct()
    {
        foreach ($_GET as $key => $value) {
            $this->stopattack($key, $value, $this->getfilter);
        }
        foreach ($_POST as $key => $value) {
            $this->stopattack($key, $value, $this->postfilter);
        }
        foreach ($_COOKIE as $key => $value) {
            $this->stopattack($key, $value, $this->cookiefilter);
        }
    }

    //开始验证
    public function stopattack($StrFiltKey, $StrFiltValue, $ArrFiltReq)
    {
        if (is_array($StrFiltValue)) $StrFiltValue = implode($StrFiltValue);
        if (preg_match("/" . $ArrFiltReq . "/is", $StrFiltValue) == 1) {
            $this->writeslog($_SERVER["REMOTE_ADDR"] . "    " . strftime("%Y-%m-%d %H:%M:%S") . "    " . $_SERVER["PHP_SELF"] . "    " . $_SERVER["REQUEST_METHOD"] . "    " . $StrFiltKey . "    " . $StrFiltValue);
            $msg['code'] = '90000';
            $msg['msg'] = '您提交的参数非法,系统已记录您的本次操作！';
            return msg;
        }
    }

    //日志
    public function writeslog($log)
    {
        $log_path = CACHE_PATH . 'logs' . DIRECTORY_SEPARATOR . 'sql_log.txt';
        $ts = fopen($log_path, "a+");
        fputs($ts, $log . "\r\n");
        fclose($ts);
    }
}