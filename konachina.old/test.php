<?php
class test extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	/**
	 *	@desc 首页 跑脚本更新url链接
	*/
	function updyear()
	{
		$this->load->model('main_model', 'main');
		$lists = $this->main->getProductList();

		if(is_array($lists) && !empty($lists))
		{
			foreach ($lists as $row)
			{
				switch ($row['year']) 
				{
					case 2013:
						$replace_url	= 'http://2k13.konaworld.com/';
						break;
					case 2012:
						$replace_url	= 'http://2k12.konaworld.com/';
						break;
					case 2014:
						$replace_url	= 'http://2014.konaworld.com/';
						break;
					default:
						$replace_url	= '';
						break;
				}

				if( $replace_url )
				{
					if( $row['year'] == 2014 )
					{
						$url = 'http://2014.konaworld.com/'.$row['detail_url'];
					}
					else
					{
						$url = str_replace('http://www.konaworld.com/', $replace_url, $row['detail_url']);
					}
					echo $row['id'].' -- '.$url.' --> ';
					if($this->main->updateUrl($row['id'], $url))
					{
						echo "<font style='color:green;'>Success</font><br/>";
					}
					else
					{
						echo "<font style='color:red;'>Fail</font><br/>";
					}
				}
			}
		}

		exit();
	}

}


?>