<?php

class Api {
    const API_ID = '16d87195707ac9db849979d22b3dd5d6'; //開通的APP ID
    const API_KEY = 'f58cffd75eb58b1d4c061c3e2aa082f8'; //開通的key
    
    /*
     * 請求方法
     */
    public static function request($url, $data = '', $timeout = 30) {
        if(empty($data) || is_array($data) || is_object($data)) $data = '';
        
        //生成sign
        $a = substr(self::API_KEY, 0, 16) . substr(self::API_ID, 16);
        $b = substr(self::API_ID, 0, 16) . substr(self::API_KEY, 16);
        $sign = md5($a . 'json' . $data . $b) . self::API_ID;
echo "\n----------------------------------------------------------------------------------------------------\n";
print_r($data);
        $post = array(
            'sign' => $sign, //簽名
            'type' => 'json', //請求類型為 JSON
            'data' => $data //參數內容
        );
echo "\n----------------------------------------------------------------------------------------------------\n";
print_r($post);
        //生成請求的參數
        $params = http_build_query($post);
        //echo urldecode($params);exit;
        $referer = 'http://www.test.com'; //設置header
echo "\n----------------------------------------------------------------------------------------------------\n";
print_r(  urldecode($params) );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_REFERER, $referer);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        $json = curl_exec($ch);
        curl_close($ch);

        return json_decode($json, true);
    }
}