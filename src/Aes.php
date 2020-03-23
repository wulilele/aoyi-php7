<?php

namespace Wulilele\Aoyihutong;

class Aes
{

    private $key;

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function encrypt($input)
    {
        $A = openssl_encrypt($input, 'AES-128-ECB', $this->key, true);
        $hex = "";
        for ($i = 0; $i < strlen($A); $i++) {
            if (strlen(dechex(ord($A[$i]))) == 1) {
                $hex .= '0' . dechex(ord($A[$i]));
            } else {
                $hex .= dechex(ord($A[$i]));
            }
        }
        $hex = strtoupper($hex);
        return $hex;
    }

}