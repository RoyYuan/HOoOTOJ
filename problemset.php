<?php
/**
 * Created by PhpStorm.
 * User: RoyYuan
 * Date: 2018/4/7
 * Time: 20:53
 */
require_once ('include/db_info.php');
//problem_id别名upid
$sql="SELECT max(`problem_id`) as upid FROM `problems`";
$page_cnt=100;
$result=mysqli_query($mysqli,$sql);
echo mysqli_error($mysqli);
$row=mysqli_fetch_object($result);
//将其转换为整型变量
$cnt=intval($row->upid);
$cnt/=$page_cnt;//得到页数

//得到当前页的题目id范围
$page='1';
$page_start=($page_cnt-1)*intval($page);
$page_end=$page_start+$page_cnt;
$sub_arr=Array();

//按照id范围搜索
if(isset($_GET['search']) && trim($_GET['search'])!=""){
    $search=mysqli_real_escape_string($mysqli,$_GET['search']);
    $filter_sql=" ( title like '%$search%' or source like '%$search%')";
}
else{
    $filter_sql="  `problem_id`>='".strval($page_start)."' AND `problem_id`<'".strval($page_end)."' ";
}
//按照权限显示题目，有的在contest里，有的是hide=1
if(isset($_SESSION['administrator'])){
    $sql="SELECT `problem_id`,`title`,`submit`,`accept` FROM `problems` WHERE $filter_sql";
}
else{
    $now=strftime("%Y-%m-%d %H:%M",time());
    $sql="SELECT `problem_id`,`title`,`submit`,`accept` FROM `problems`".
        "WHERE `problems`.`hide`=0 AND $filter_sql AND `problem_id` NOT IN(
        SELECT `problem_id` FROM `contest_problem` WHERE `contest_id` IN(
        SELECT `contest_id` FROM `contest` WHERE
        (`end_time`>'$now' or `contest`.`hide`=1) AND `problems`.`hide`=0)
        )";
}
$sql=" ORDER BY `problem_id`";//按照题目id排序
$result=mysqli_query($mysqli,$sql); //or die(mysqli_error());

//从$result中获取当前页面能显示的题目信息放进$view_problemset中
$view_total_page=$cnt+1;
$cnt=0;
$view_problemset=Array();
$i=0;
while($row=mysqli_fetch_object($result)){
    $view_problemset[$i]=Array();
    $view_problemset[$i][1]="<div class='center'>".$row->problem_id."</div>";;
    $view_problemset[$i][2]="<div class='left'><a href='problem.php?id=".$row->problem.id."'>".$row->title."</a></div>";;
    $view_problemset[$i][3]="<div class='center'>".$row->submit."</div>";;
    $view_problemset[$i][4]="<div class='center'>".$row->accept."</div>";;
    $i++;
}
mysqli_free_result($result);
require("template/problemset_t.php");
?>