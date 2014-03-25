<?php
header("content-Type:text/html; charset=utf-8");
echo "<h1>header头信息：content-Type:text/html; charset=utf-8</h1>";
/**
 *	抽象类
 *	2012-07-23
 */
abstract class traffic
{
	private $t_name;	//名称
	private $t_type;	//类型
	private $t_price;	//价格
	private $t_weight;	//重量
	
	abstract function yundong();
}

class car extends traffic
{
	public function yundong()
	{
		return '四个轮子的家用车';
	}
}

class bike extends traffic
{
	function yundong()
	{
		return '两个轮子的山地车';
	}
}

$objcar = new car();
echo $objcar->yundong();
echo '<br />';

?>

<?php
/*后盾网  http://www.houdunwang.com
        2011-3-21 下午01:48:42
*/
/*abstract class xiaosou {
        private $uname;//员工姓名
        private $number;//销售人员工号
        //打电话联系业务
        function tel() {
        
        }
        //通过互联网联系业务
        function web() {
        
        }
        //通过关系网联系业务
        function guanli(){
        
        }
        abstract function yeji();
}
class design extends xiaosou {
        function yeji($yeji) {
                if ($yeji > 20000) {
                        echo "合格的印刷销售人员";
                } else {
                        echo "不合格印刷销售人员";
                }
        }
}
class web extends xiaosou {
        function yeji($yeji) {
                if ($yeji > 50000) {
                        echo "合格的网站销售人员";
                } else {
                        echo "不合格的网站销售人员，要努力了。。。否则可能要被开除";
                }
        }
}*/

/*文章管理  arc   用户管理  user  */

/*interface bing {
        //测量身高
        function sengao();
        //测量视力
        function sili();
        //政治审核
        function zengzi();
        //肝病检查
        function ganyan();
}
//步兵
class bubing implements bing {
        function sengao() {
        }
        function sili() {
        }
        function zengzi() {
        }
        function ganyan() {
        }
}
//空军
class kongjun implements bing {
        function sengao() {
        }
        function sili() {
        }
        function zengzi() {
        }
        function ganyan() {
        }
}
//海军
class haijun implements bing {
        function sengao() {
        }
        function sili() {
        }
        function zengzi() {
        }
        function ganyan() {
        }
}*/

interface usb{
        function connect();//联接USB
        function quit();//退出USB
}
interface caxianban{
        const DIANYA = '220V';
        function caru();//插入
        function bacu();//拨出
}

//数码相机，插在电脑  弹出图片浏览器，    U盾    1装驱动   2打开浏览器    手机插在电脑 充电
class souji implements usb,caxianban{
        function connect(){
                echo "手机在充电,显示手机内容";
        }
        function quit(){
                echo "手机停止充电，退出。。";
        }
        function caru(){
                echo "手机通过".self::DIANYA."电压充电，插线板充电";
        }
        function bacu(){
                echo "手机断电拨出，离开".self::DIANYA."电压插线板";
        }
}

class xiangji implements usb{
        function connect()
        {
                echo "像机插到USB上了，显示图片";
        }
        function quit(){
                echo "像机退出。。。。";
        }
}
//插线板
class cxb{
        function caru($obj){
                $obj = new $obj();
                $obj->caru();
        }
        function bacu($obj){
                $obj = new $obj;
                $obj->bacu();
        }
}
$cxb = new cxb();
$cxb->bacu('souji');
class pc {
        function usbConnect($usb){
                $obj = new $usb();
                $obj->connect();
        }
        function usbQuit($usb){
                $obj = new $usb();
                $obj->quit();
        }
}
$sony = new pc();
//$sony->usbConnect('souji');


//文章管理    分类信息栏目   论坛管理  商城栏目  图集栏目

/*interface channel{
        function edit();
        function del();
}
class arcChannel implements channel{
        function edit(){
                echo "文章栏目管理";
        }
        function del(){
                echo "文章栏目删除";
        }
}
class infoChannel implements channel{
function edit(){
                echo "分类信息栏目管理";
        }
        function del(){
                echo "分类信息栏目删除";
        }
}
class admin{
        function channel($type,$action){
                $channel = new $type();
                $channel->$action();
        }
}
$type = $_GET['m'];
$action = $_GET['a'];
$admin = new admin();
$admin->channel($type,$action);*/
?>