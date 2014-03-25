<?php
header('content-type:text/html; charset=utf-8;');
$yArr    = array(
    1 => array('id'=>'1','parentid'=>0,'name'=>'一级栏目一'),
    2 => array('id'=>'2','parentid'=>0,'name'=>'一级栏目二'),
    3 => array('id'=>'3','parentid'=>1,'name'=>'二级栏目一'),
    4 => array('id'=>'4','parentid'=>1,'name'=>'二级栏目二'),
    5 => array('id'=>'5','parentid'=>2,'name'=>'二级栏目三'),
    6 => array('id'=>'6','parentid'=>3,'name'=>'三级栏目一'),
    7 => array('id'=>'7','parentid'=>3,'name'=>'三级栏目二'),
    8 => array('id'=>'8','parentid'=>2,'name'=>'二级栏目三'),
);
echo '<pre>';
/**
 * 无限分类
 * @param array $data 原始数组
 * @param int $id 当前id
 * @param int $layer 当前层级
 */
function genCate($data, $pid = 0, $level = 0)
{
    if($level == 10) break;
    static $tarr= array();
    $l    = str_repeat("&nbsp;", $level);
    $l    = $l.'└';
    foreach($data as $row)
    {
        /**
         * 如果父ID为当前传入的id
         */
        if($row['parentid'] == $pid)
        {
            //如果当前遍历的id不为空
            $row['name']    = htmlspecialchars($l.$row['name']);
            $row['level']    = $level;
            $tarr[]    = $row;
            genCate($data, $row['id'], $level+1);//递归调用
        }
    }
    return $tarr;
}
$carr    = genCate($yArr);
print_r($carr);
?>