<?php
/**
 * @desc 测试开奖逻辑
 *       10w 的奖池
 *       从中抽取 N 个
 *       保证user_id不能重复
 */
function dd($array)
{
	$array = is_array($array) ? $array : [$array];
	echo '<pre>';
	print_r($array);
	echo "</pre>";
}
class Lottery
{
	private $startTime= 0;
	private $database = 'tempdb';
	public function __construct()
	{

	}

    /**
     * @desc 记录微秒时间，当前，起点时间到现在的时间差
     * @return [type] [description]
     */
    public function logMicrotime()
    {
    	$nowTime    = microtime(true);
        if( empty($this->startTime) )
        {
        	$diffTime	= 0;
        	$this->startTime= microtime(true);
        }
        else
        {
echo $nowTime . '-' . $this->startTime . "<br/>";
        	$diffTime	= $nowTime - $this->startTime;
        }
        return [
            's'     => $this->startTime,
            'time'  => $nowTime,
            'diff'  => $diffTime,
        ];
    }

	public function connDB()
	{
		$conn	= mysqli_connect('127.0.0.1', 'root', '');
		if( empty($conn) )
		{
			return false;
		}
		mysqli_set_charset($conn, 'UTF8');
		mysqli_select_db($conn, $this->database);
		return $conn;
	}

	private function query($conn, $sql = '')
	{
		$queryRes = mysqli_query($conn, $sql);
		return $queryRes;
	}

	public function insertDB($sql)
	{
		$conn		= $this->connDB();
		$queryRes	= $this->query($conn, $sql);
		if( mysqli_errno($conn) ) 
		{
			throw new Exception(mysqli_error($conn), 1);
			mysqli_free_result($queryRes);
			mysqli_close($conn);
			return fale;
		}
		else
		{
			$data = mysqli_affected_rows($conn);
			mysqli_free_result($queryRes);
			mysqli_close($conn);
			return $data;
		}
	}

	public function selectDB($sql)
	{
		// # TODO 限制sql只能是 SELECT 操作。需要过滤掉 `INSERT`,`UPDATE`,`DELETE`,`ALTER`,`DROP` 等关键词
		$conn 		= $this->connDB();
		$queryRes	= $this->query($conn, $sql);
		if( mysqli_errno($conn) )
		{
			throw new Exception(mysqli_error($conn), 2);
			mysqli_free_result($queryRes);
			mysqli_close($conn);
			return false;
		}
		else
		{
			$data = mysqli_fetch_all($queryRes, MYSQLI_ASSOC); 
			mysqli_free_result($queryRes);
			mysqli_close($conn);
			return $data;
		}

	}

	public function insertCodeToDB($total = 0, $startCode = 0)
	{
		$countRows	= 0;
		$limit		= 500;
		$total 		= !empty($total) ? $total : 100;
		$maxFor		= intval( ceil( $total / $limit ) );

        $startCode 	= !empty($startCode) ? $startCode : 10514233;
        $createdAt	= date('Y-m-d H:i:s');
        $k = 0;
        for ($i=0; $i < $maxFor; $i++) { 
        	$insertData = [];
        	$insertSql	= 'INSERT INTO `winner_code` (`code`, `activities_id`, `get_date`, `form_scene`, `created_at`, `updated_at`) VALUES';
        	$jForLimit = $limit>$total ? $total : $limit;
            for ($j=0; $j < $jForLimit; $j++)
            {
            	if( $k >= $total )
            	{
            		break;
            	}
//echo $total . '-' . $maxFor . '-' . $i . '-' . $jForLimit . '-' . $k . '<br/>';
                $temp = [
                	(int)$startCode + (int)$k,
                	1,
                	$createdAt,
                	'test',
                	$createdAt,
                	$createdAt,
                ];
                $insertData[]	= "('" . implode("','", $temp) . "')";
                $k++;
            }

            if( !empty($insertData) )
            {
            	$insertSql = $insertSql . implode(',', $insertData);
            	$inserRes = $this->query( $insertSql );
            	$countRows+= !empty($inserRes) ? $inserRes : 0;
            }
        }
        return $countRows;
	}

	public function main($num = 0, $startCode = 0)
	{
		echo json_encode($this->logMicrotime(), JSON_UNESCAPED_UNICODE) . "<br/>";
		//$rows = $this->insertCodeToDB($num, $startCode);
		echo json_encode($this->logMicrotime(), JSON_UNESCAPED_UNICODE) . "<br/>";

		$getCode	= $this->handle();
		echo json_encode($this->logMicrotime(), JSON_UNESCAPED_UNICODE) . "<br/>";
	}

	/**
	 * @desc 处理开奖逻辑-找出所有的code
	 * @return [type] [description]
	 */
	/*// 直取 10w 条
	public function handle()
	{
		$selSql = "select * from winner_code limit 50000;";
		$res 	= $this->selectDB($selSql);
		dd( count($res) );
	}*/

	/**
	 * @desc 抽签逻辑
	 * @param  integer $maxNum [description]
	 * @return [type]          [description]
	 */
	public function handle()
	{
		// 开奖程序预抽取数为 winnerNum * 每人最大奖券数。
		// 再从预抽取人数中，抽取最终的{winnerNum}人。
		
		$totalCode	= 100000;
		$every		= 5;
		$winnerNum	= 3;
		$preWinner	= $winnerNum * $every;

		$preWinnerLists = [];
		for ($i=0; $i < $preWinner; $i++)
		{
			$winnerCode	= random_int(0, $totalCode);
			if( in_array($winnerCode, $preWinnerLists) )
			{
				$i--;
			}
			else
			{
				$preWinnerLists[]	= $winnerCode;
			}
		}

		// 排重过滤
		shuffle($preWinnerLists);
		dd( $preWinnerLists );
		foreach ($preWinnerLists as $positionKey)
		{
			$sql	= "select * from `winner_code` limit 1 offset {$positionKey}";
			$data 	= $this->selectDB($sql);
			dd($data);
		}
		echo json_encode($this->logMicrotime(), JSON_UNESCAPED_UNICODE) . "<br/>";
	}

}


$lotteryCls = new Lottery();
echo '测试开奖逻辑' . PHP_EOL . "<br/>";
$lotteryCls->main(100000);


