<?php
/**
 *	@desc 基于mcrypt的加密解密函数类。PHP环境下必须安装 mcrypt扩展
 *	@author cntn11
 *	@date 2015年06月05日15:23:18
*/
class JkDataApi
{
	public $time	= '';
	public $random	= '';
	private $ver	= '1.0';	// 访问接口的版本号

	function __construct()
	{
		$this->time		= time();
		$this->random	= rand(10000, 99999);
	}

	/**
	 *	@desc 生成API访问链接
	 *	@param $token 由数据组提供的key
	*/
	function getApiData( $url, $token = '', $params = array() )
	{
		$params['time']		= $this->time;
		$params['random']	= $this->random;
		$params['ver']		= $this->ver;
		$de_str				= self::mEncode( $token, http_build_query($params) );

		$params['sig']		= $token.$de_str;
		$s					= http_build_query($params);
		$url				= $url.'?'.$s;

		$ch				= curl_init( $url );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		$content		= curl_exec($ch);
		curl_close($ch);
		return $content;
	}

	/**
	 *	@desc 加密字符串
	 *		参考PHP官网手册： http://php.net/manual/zh/function.mcrypt-encrypt.php
	*/
	public function mEncode( $token, $params_str = '' )
	{
		$sig	= '';
		$sig	= mcrypt_encrypt( MCRYPT_RIJNDAEL_256, $token, $params_str, MCRYPT_MODE_ECB, mcrypt_create_iv( mcrypt_get_iv_size( MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB ), MCRYPT_RAND ) );
		$sig	= base64_encode($sig);
		return $sig;
	}

	/**
	 *	@dessc 解密，把mEncode生成的sig进行解密
	 *			$this->mDecode( $token, $sig );
	 *	@param $token	对外token
	 *	@param $de_str_base64 通过URL链接过来的待解密字串
	*/
	public function mDecode( $token, $de_str_base64 )
	{
		$de_str	= base64_decode($de_str_base64);
		$res	= mcrypt_decrypt( MCRYPT_RIJNDAEL_256, $token, $de_str, MCRYPT_MODE_ECB, mcrypt_get_iv_size( MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB ) );
		return $res;
	}

	/* 备份
	function _postGetData()
	{
		// curl的post解决方案
		$ch				= curl_init();
		curl_setopt($ch, CURLOPT_URL, $url );
		curl_setopt($ch, CURLOPT_POST, count($fields) );
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields );
		curl_setopt($ch, CURLOPT_TIMEOUT, 30 );
		ob_start();
		curl_exec($ch);
		$result	= ob_get_contents();
		ob_end_clean();
		curl_close($ch);
	}*/
}
