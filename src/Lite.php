<?php
/**
 * Created by PhpStorm.
 * User: RoseKnife Hua
 * Date: 2018/6/1 0001
 * Time: 16:01
 */

namespace RoseKnife\Aoyihutong;
use RoseKnife\Aoyihutong\AES;

date_default_timezone_set('Asia/Shanghai');

class Lite
{

    private $APPID = "";
    private $SECRET = "";
    private $APIURL = "";
    private $CONTENTSIGN = "";

    private $AES;

    /**
     * Lite 构造.
     * @param $config
     */
    public function __construct($config)
    {
        $this->APPID = $config['appid'];
        $this->SECRET = $config['secret'];
        $this->APIURL = $config['apiurl'];
        $this->CONTENTSIGN = $config['contentsign'];

        $this->AES = new AES($this->SECRET);
    }

    /*
     * 发送短信,多个手机号的请用半角逗号分隔
     */
    public function sendsms($phone, $content)
    {
        $url = $this->APIURL . 'sendsms';
        $data = [
            'public_key' => $this->APPID,
            'sign' => $this->sign(),
            'encry' => "true",
            'sms_data' => $this->AES->encrypt(json_encode([
                'mobiles' => explode(',', $phone),
                'smscontent' => $this->CONTENTSIGN . $content,
                'extendedcode' => "",
                'sendtime' => null
            ]))
        ];
        //var_dump($data);
        return $this->postData($url, $data);
    }

    /**
     * 查询余量
     */
    public function getBalance()
    {
        $url = $this->APIURL . 'balance';
        $data = [
            'public_key' => $this->APPID,
            'sign' => $this->sign()
        ];
        return $this->postData($url, $data);
    }

    /**
     * @return 签名
     */
    private function sign()
    {
        return $this->AES->encrypt(date('YmdHis') . '800');
    }


    /**
     * 发送请求
     * @param $url
     * @param $data
     * @return mixed
     */
    private function postData($url, $data = null, $timeout = 300)
    {
        $headers = array(
            "Content-type: application/x-www-form-urlencoded;charset='utf-8'",
            "Accept: application/json",
            "Cache-Control: no-cache",
            "Pragma: no-cache"
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}