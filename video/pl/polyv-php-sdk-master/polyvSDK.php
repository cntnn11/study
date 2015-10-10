<?php 

class PolyvSDK {
		
	private $_readtoken;				
	private $_writetoken;
	private $_privatekey;
	private $_sign;
	private $_error_tip	= [
		0	=> '无错误',
		1	=> '找不到writetoken关联的user',
		2	=> '文件为空或者writetoken为空',
		3	=> '提交的json名字JSONRPC为null',
		4	=> '提交文件格式不正确',
		5	=> 'readtoken为空',
		6	=> '分页输入出错',
		7	=> 'vid不能为空',
		8	=> '找不到方法名',
		10	=> 'userid不能为空',
		11	=> '上传目录为空',
		12	=> '远程URL文件不能访问',
		13	=> '远程视频文件自定义名称不能为空',
		15	=> '其他异常',
		16	=> '空间已满',
		17	=> '用户无是用接口权限',
		18	=> '标题重复',
		19	=> '标题为空',
		20	=> '播放列表不存在',
		21	=> '参数错误',
		22	=> '参数签名错误',
	];
	
	function __construct($writetoken, $readtoken, $privatekey)
	{
		$this->_writetoken		= $writetoken;
		$this->_readtoken		= $readtoken;
		$this->_privatekey		= $privatekey;
		$this->_sign			= true;			//提交参数是否需要签名
	}
	private function sanitize_for_xml($input) {
		
	  $output = preg_replace('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', '', $input);
	  
	  return $output;
	}
	private function _processXmlResponse($url, $xml = ''){

		if (extension_loaded('curl')) {
			$ch = curl_init() or die ( curl_error() );
			$timeout = 10;
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);	
			curl_setopt( $ch, CURLOPT_URL, $url );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			if(!empty($xml)){
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                       'Content-type: application/xml',
                                       'Content-length: ' . strlen($xml)
                                     ));
			}
			$data = curl_exec( $ch );
			curl_close( $ch );

			if($data){
				return (new SimpleXMLElement($this->sanitize_for_xml($data)));
			}else{
				return false;
			}
		}
		if(!empty($xml))
			throw new Exception('Set xml, but curl does not installed.');

		return (simplexml_load_file($url));	
	}
	private function makeVideo($video){
		return array(
					'vid' => (string)$video->vid, 
					'hlsIndex' => (string)$video->hlsIndex, 
					'swf_link' => (string)$video->swf_link, 
					'ptime' => (string)$video->ptime, 
					'status' => (int) $video->status, 
					'df' => (int) $video->df, 
					'first_image' => (string)$video->first_image, 
					'title' => (string)$video->title, 
					'desc' => (string)$video->context, 
					'duration' => (string)$video->duration, 
					'flv1' => (string)$video->flv1, 
					'flv2' => (string)$video->flv2, 
					'flv3' => (string)$video->flv3, 
					'mp4_1' => (string)$video->mp4_1,
					'mp4_2' => (string)$video->mp4_2,
					'mp4_3' => (string)$video->mp4_3,					
					'hls_1' => (string)$video->hls_1,
					'hls_2' => (string)$video->hls_2,
					'hls_3' => (string)$video->hls_3,
					'seed' => (string)$video->seed
					);
	}
			
	public function getById($vid) {
		
	    $xml = "";
		if($this->_sign){
			$hash = sha1('readtoken='.$this->_readtoken.'&vid='.$vid.$this->_privatekey);
		}
		//echo "-->".'http://beta.polyv.net/uc/services/rest?readtoken='.$this->_readtoken.'&method=getById&vid='.$vid.'&format=xml&sign='.$hash;
		$xml = $this->_processXmlResponse('http://v.polyv.net/uc/services/rest?readtoken='.$this->_readtoken.'&method=getById&vid='.$vid.'&format=xml&sign='.$hash, $xml);
		if($xml) {
			if($xml->error=='0') 
				
					return $this->makeVideo($xml->data->video);
			else 
				return array(
					'returncode' => $xml->error
					);
		}
		else {
			return null;
		}
		
	}
	
					
	/**
	 * 通过视频标题获取信息
	 */
	public function searchByTitle($keyword,$pageNum,$numPerPage) {
		if($this->_sign){
			$hash = sha1('keyword='.$keyword.'&numPerPage='.$numPerPage.'&pageNum='.$pageNum.'&readtoken='.$this->_readtoken.$this->_privatekey);
		}
		//echo 'http://v.polyv.net/uc/services/rest?readtoken='.$this->_readtoken.'&method=searchByTitle&keyword='.$keyword.'&pageNum='.$pageNum.'&numPerPage='.$numPerPage.'&format=xml&sign='.$hash;
		$xml = $this->_processXmlResponse('http://v.polyv.net/uc/services/rest?readtoken='.$this->_readtoken.'&method=searchByTitle&keyword='.$keyword.'&pageNum='.$pageNum.'&numPerPage='.$numPerPage.'&format=xml&sign='.$hash, $xml);
		if($xml) {
			if($xml->error=='0') {
				foreach ($xml->data->video as $video){ 
					
					$videodata = $this->makeVideo($video);
					$result[$num] =$videodata;
					$num++;
				}
				return $result;
			}else{
				return array(
					'returncode' => $xml->error
					);
			}
		}
		else {
			return null;
		}
		
	}
	
	public function uploadfile($title,$desc,$tag,$cataid,$filename) {
		$JSONRPC = '{"title":"'.$title.'","tag":"'.$tag.'","desc":"'.$desc.'"}';
				
		if($this->_sign){
			$hash = sha1('cataid='.$cataid.'&JSONRPC='.$JSONRPC.'&writetoken='.$this->_writetoken.$this->_privatekey);
		}
		//echo 'cataid='.$cataid.'&JSONRPC='.$JSONRPC.'&writetoken='.$this->_writetoken.$this->_privatekey.' hash:'.$hash;
		if (extension_loaded('curl')) {
			$ch = curl_init() or die ( curl_error() );
			$timeout = 360;
			
			$post = array(
				'JSONRPC' => $JSONRPC,
				'cataid'=>$cataid,
				'writetoken'=>$this->_writetoken,
				'sign'=>$hash,
				'format'=>'xml',
				'Filedata'=> new CURLFile($filename),
			);

			curl_setopt( $ch, CURLOPT_URL, "http://v.polyv.net/uc/services/rest?method=uploadfile" );
			curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

			$data	= curl_exec( $ch );
			curl_close( $ch );

			if($data)
			{
				$xml = (new SimpleXMLElement($data));
				if($xml) {
					if($xml->error=='0') 
							return $this->makeVideo($xml->data->video);
					else 
						return array(
							'returncode' => $xml->error
							);
				}
				else {
					return null;
				}
				
			}
			else
			{
				return false;
			}
		}
	}

	/**
	 *	@desc 抓取远程视频链接
	*/
	public function uploadUrlFile($title,$desc,$tag,$cataid,$video_url)
	{
		$JSONRPC	= '{"title":"'.$title.'","tag":"'.$tag.'","desc":"'.$desc.'"}';
		if($this->_sign)
		{
			$hash	= sha1('cataid='.$cataid.'&JSONRPC='.$JSONRPC.'&writetoken='.$this->_writetoken.$this->_privatekey);
		}

		if (extension_loaded('curl'))
		{
			$ch			= curl_init() or die ( curl_error() );
			$timeout	= 360;
			$params		= array(
				/*'cataid'	=> $cataid,
				'sign'		=> $hash,*/
				'desc'		=> $desc,
				'fileUrl'	=> $video_url,
				'tag'		=> $tag,
				'writetoken'=> $this->_writetoken,
				'title'		=> $title,
				'format'	=> 'json',
				'method'	=> 'uploadUrlFile',
			);

			$pl_url		= "http://v.polyv.net/uc/services/rest?" . http_build_query($params);
			curl_setopt( $ch, CURLOPT_URL, $pl_url );
			curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

			//$data	= curl_exec( $ch );
			$res	= '{"error":"0","data":[{"images_b":["http://img.videocc.net/uimage/1/15d8ff7460/b/15d8ff74605300f766c4c419e14b047b_0_b.jpg","http://img.videocc.net/uimage/1/15d8ff7460/b/15d8ff74605300f766c4c419e14b047b_1_b.jpg","http://img.videocc.net/uimage/1/15d8ff7460/b/15d8ff74605300f766c4c419e14b047b_2_b.jpg","http://img.videocc.net/uimage/1/15d8ff7460/b/15d8ff74605300f766c4c419e14b047b_3_b.jpg","http://img.videocc.net/uimage/1/15d8ff7460/b/15d8ff74605300f766c4c419e14b047b_4_b.jpg","http://img.videocc.net/uimage/1/15d8ff7460/b/15d8ff74605300f766c4c419e14b047b_5_b.jpg"],"tag":"视频标签","mp4":"http://mpv.videocc.net/15d8ff7460/b/15d8ff74605300f766c4c419e14b047b_1.mp4","title":"20151009 极客学院上传","df":1,"times":"0","mp4_1":"http://mpv.videocc.net/15d8ff7460/b/15d8ff74605300f766c4c419e14b047b_1.mp4","vid":"15d8ff74605300f766c4c419e14b047b_1","cataid":"1","swf_link":"http://player.polyv.net/videos/15d8ff74605300f766c4c419e14b047b_1.swf","source_filesize":11109395,"status":"10","seed":1,"flv1":"http://plvod01.videocc.net/15d8ff7460/b/15d8ff74605300f766c4c419e14b047b_1.flv","sourcefile":"http://mpv.videocc.net/15d8ff7460/b/15d8ff74605300f766c4c419e14b047b.mp4","playerwidth":"","hlsIndex":"http://v.polyv.net/hlsIndex/15d8ff74605300f766c4c419e14b047b_1.m3u8","hls1":"http://v.polyv.net/hls/15d8ff74605300f766c4c419e14b047b_1.m3u8?df=1","default_video":"http://plvod01.videocc.net/15d8ff7460/b/15d8ff74605300f766c4c419e14b047b_1.flv","duration":"00:05:43","filesize":[0],"first_image":"http://img.videocc.net/uimage/1/15d8ff7460/b/15d8ff74605300f766c4c419e14b047b_0.jpg","original_definition":"960x540","context":"视频的描述","images":["http://img.videocc.net/uimage/1/15d8ff7460/b/15d8ff74605300f766c4c419e14b047b_0.jpg","http://img.videocc.net/uimage/1/15d8ff7460/b/15d8ff74605300f766c4c419e14b047b_1.jpg","http://img.videocc.net/uimage/1/15d8ff7460/b/15d8ff74605300f766c4c419e14b047b_2.jpg","http://img.videocc.net/uimage/1/15d8ff7460/b/15d8ff74605300f766c4c419e14b047b_3.jpg","http://img.videocc.net/uimage/1/15d8ff7460/b/15d8ff74605300f766c4c419e14b047b_4.jpg","http://img.videocc.net/uimage/1/15d8ff7460/b/15d8ff74605300f766c4c419e14b047b_5.jpg"],"playerheight":"","ptime":"2015-10-09 18:16:09"}]}';
			curl_close( $ch );

			$data	= json_decode($res, true);
			if( is_array($data) )
			{
				if( $data['error'] == 0 && isset($data['data'][0]) )
				{
					return $data['data'][0];
				}
				else
				{
					return $this->_error_tip[$data['error']];
				}
			}
		}
		return false;
	}


	public function getCata($cataid) {
		$xml = ''; 
		$num = 0;
		if($this->_sign){
			$hash = sha1('cataid='.$cataid.'&readtoken='.$this->_readtoken.$this->_privatekey);
		}
		$xml = $this->_processXmlResponse('http://v.polyv.net/uc/services/rest?readtoken='.$this->_readtoken.'&format=xml&method=getCata&sign='.$hash, $xml);
		if($xml) {
			if($xml->error=='0') {
				foreach ($xml->data->video as $video){ 
					$videodata = array(
					'cataid' => $video->cataid, 
					'articles' => $video->articles, 
					'cataname' => $video->cataname
					);
					
					
					$result[$num] =$videodata;
					$num++;
				}
				return $result;
			}else{
				return array(
					'returncode' => $xml->error
					);
			}
		}
		else {
			return null;
		}
		
	}
	public function getNewList($pageNum,$numPerPage,$catatree) {
	
		$xml = ''; 
		$num = 0;
		if($this->_sign){
			$hash = sha1('catatree='.$catatree.'&numPerPage='.$numPerPage.'&pageNum='.$pageNum.'&readtoken='.$this->_readtoken.$this->_privatekey);
		}
		$xml = $this->_processXmlResponse('http://v.polyv.net/uc/services/rest?readtoken='.$this->_readtoken.'&method=getNewList&pageNum='.$pageNum.'&format=xml&numPerPage='.$numPerPage.'&catatree='.$catatree.'&sign='.$hash, $xml);
		if($xml) {
			if($xml->error=='0') {
				foreach ($xml->data->video as $video){ 
					
					$videodata = $this->makeVideo($video);
					$result[$num] =$videodata;
					$num++;
				}
				return $result;
			}else{
				return array(
					'returncode' => $xml->error
					);
			}
		}
		else {
			return null;
		}
		
	}
}
