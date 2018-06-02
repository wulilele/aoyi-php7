<?php
/**
 * Created by PhpStorm.
 * User: RoseKnife Hua
 * Date: 2018/6/1 0001
 * Time: 16:01
 */

namespace RoseKnife\Aoyihutong;
date_default_timezone_set('Asia/Shanghai');

class Lite
{

    private $APPID = "";
    private $SECRET = "";
    private $APIURL = "";

    private $timestr = "";

    /**
     * Lite 构造.
     * @param $config
     */
    public function __construct($config)
    {
        $this->APPID = $config['appid'];
        $this->SECRET = $config['secret'];
        $this->APIURL = $config['apiurl'];
    }

    /*
     * 发送短信
     */
    public function send($templateid,$phone, $content, $name, $sex = '先生')
    {
        return true;
    }

    /**
     * 查询余额
     */
    public function getMoney()
    {
        $url = $this->APIURL . 'balance';
        $data = [
            'public_key' => $this->APPID,
            'sign' => $this->encrypt_openssl()
        ];
        print_r($data);
        echo $url . "<hr />";
        return $this->postData($url, $data);
    }

    //encrypt_openssl新版加密
    public function encrypt_openssl()
    {
        return openssl_encrypt($this->getMillisecond(), 'AES-128-ECB', $this->SECRET, 0, '');
    }

    /**
     * @return 生成13位时间
     */
    private function getMillisecond()
    {
        return $this->timestr = date('YmdHis') . '000';
    }

    /**
     * 发送请求
     * @param $url
     * @param $data
     * @return mixed
     */
    private function postData($url, $data, $timeout = 300)
    {
        /* $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_POST, true);
         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
         curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);  // 从证书中检查SSL加密算法是否存在
         $handles = curl_exec($ch);
         curl_close($ch);
         return $handles;*/

        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url . '?public_key=' . $data['public_key'] . '&sign=' . $data['sign']);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 1);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //执行命令
        $result = curl_exec($curl);
        //关闭URL请求
        curl_close($curl);
        //显示获得的数据
        return $result;
    }
}