<?php
header("Content-Type: text/html;charset=utf-8");

include_once "src/Lite.php";
include_once "src/Aes.php";


$config = [
    'appid' => '公钥',
    'secret' => '私钥',
    'apiurl' => '接口地址',
    'contentsign'=>'【签名】'
];

$sms = new \Wulilele\Aoyihutong\Lite($config);
print_r($sms->getBalance());
print_r($sms->sendsms('','测试短信'));
