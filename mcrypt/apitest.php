<?php
/**
 *	@desc 数据组API接口使用范例
 *			使用 php mcrypt模块实现
 *	@author cntnn11
 *	@date 2015年06月05日14:50:25
*/


ini_set('display_errors', '1');
include './JkDataApi.class.php';
$jkdata_api	= new JkDataApi;

function test($jkdata_api)
{
	$token		= '0ea8380269b0350bd095c0012aa37b44';
	$url		= 'http://stat.jikexueyuan.lc/Home/ApiTest/getTestData';
	$res		= $jkdata_api->getApiData( $url, $token, $params );
	return $res;
}

function getStudyDetail($jkdata_api)
{
	$token		= '16a58baa1e63ddf911ab4eb1b95a72bd';
	$url		= 'http://stat.jikexueyuan.lc/Home/ApiCourse/getStudyDetail';
	$params['sdate']	= '2015-06-01';
	$params['edate']	= '2015-06-30';
	$params['cids']		= '3,4,5,65,76,78';
	$res		= $jkdata_api->getApiData( $url, $token, $params );
	return $res;
}

function getKeyMax($jkdata_api)
{
	$token	= '827003dd7d76fff0593df3f375e810c6';
	//$url	= 'http://stat.jikexueyuan.lc/Home/ApiSearch/getKeyMax';
	$url	= 'http://stat.jikexy.com/Home/ApiSearch/getKeyMax';
	$params['sdate']	= '';
	$params['edate']	= '';
	$params['type']		= 'course';
	$params['limit']	= 20;
	$res		= $jkdata_api->getApiData( $url, $token, $params );
	return $res;
}


//$res	= test($jkdata_api);
//$res	= getStudyDetail($jkdata_api);
$res	= getKeyMax($jkdata_api);

echo '<hr/>';
echo '<pre>';
echo $res;
$result	= json_decode( $res, true );
var_dump(' result -> ', $result );
echo '</pre>';

echo '<hr/><p>END!</p>';





