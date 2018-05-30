<?php
/*function hex2bin($data)
{
    $len = strlen($data);
    return pack("H" . $len, $data); 
}*/
function stringToHex($s)
{
   $hexes = array("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f");
   $r = '';
   for ($i=0; $i<strlen($s); $i++) {
      $r .= ($hexes [(ord($s{$i}) >> 4)] . $hexes [(ord($s{$i}) & 0xf)]);
   }
   return $r;
}
function hexToString($hex)
{
    $string='';
    for ($i=0; $i < strlen($hex)-1; $i+=2){
        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
    }
    return $string;
}
function decrypt($sStr, $sKey)
{    
    $decrypted= mcrypt_decrypt(    
        MCRYPT_DES,    
        $sKey,    
        base64_decode($sStr),    
        MCRYPT_MODE_ECB    
    );    
     
    $dec_s = strlen($decrypted);    
    $padding = ord($decrypted[$dec_s-1]);    
    $decrypted = substr($decrypted, 0, -$padding);    
    return $decrypted;    
}    

print "<p>key               plain             crypt             guess             stat</p><br/>";
$null = "\0\0\0\0\0\0\0\0";
$vectors = file(dirname(__FILE__) . "/tests/vectors.txt");

// 生成 sso_token -- tapd_token | email | client_ip | login_time
$key = 'toppro.io@2018';
$plain= 'ff5a0745ebf50db80e2e8037544f1b82|tanning@weilaigongzuo.com|121.69.132.42|1527586235';


require_once 'CryptBlowfish.php';
$b = new CryptBlowfish($key);
$b->setKey($key);

$guess = $b->encrypt($plain);
$guess = stringToHex($guess);

$deText = $guess;
$deText = hexToString($guess);
$text = $b->decrypt( $deText );
//$text = bin2hex($text);

//$text = decrypt( $guess, $key );

// fail
/*require_once 'DesUtil.php';
$b = new DesUtil();
$guess = $b->ecbEncrypt($key, $plain);

$text  = $b->ecbDecrypt($key, $guess);*/


/*//加密  
//$key = 'toppro.i';
function chaocuoEncrypt($str, $key){  
    $block = mcrypt_get_block_size('des', 'ecb');  
    $pad = $block - (strlen($str) % $block);  
    $str .= str_repeat(chr($pad), $pad);  
    //return base64_encode(mcrypt_encrypt(MCRYPT_DES, $key, $str, MCRYPT_MODE_ECB) );
    return base64_encode(mcrypt_encrypt(MCRYPT_DES, $key, $str, MCRYPT_MODE_ECB) );
}    
//解密  
function chaocuoDecrypt($sStr, $sKey) {    
        $decrypted= mcrypt_decrypt(    
        MCRYPT_DES,    
        $sKey,    
        base64_decode($sStr),    
        MCRYPT_MODE_ECB    
    );    
     
    $dec_s = strlen($decrypted);    
    $padding = ord($decrypted[$dec_s-1]);    
    $decrypted = substr($decrypted, 0, -$padding);    
    return $decrypted;    
}

$guess = chaocuoEncrypt($plain,$key);
$text = chaocuoDecrypt($guess,$key);*/


echo "<pre>";
var_dump( [$guess, $text] );
echo '</pre>';