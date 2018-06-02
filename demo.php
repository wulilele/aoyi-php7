<?php
header("Content-Type: text/html;charset=utf-8");
/**
 * Created by PhpStorm.
 * User: RoseKnife Hua
 * Date: 2018/5/25 0025
 * Time: 18:01
 */
include_once "src/Lite.php";


$config = [
    'appid' => '',
    'secret' => '',
    'apiurl' => 'http://59.110.0.201:8084/ayht-interface/'
];


$l = new RoseKnife\Aoyihutong\Lite($config);
print_r($l->getMoney());