<?php
/**
 * Created by PhpStorm.
 * User: RoyYuan
 * Date: 2018/4/7
 * Time: 20:53
 */
require_once ('include/db_info.php');
//problem_id别名upid
$sql="SELECT MAX(`problem_id`) AS upid FROM `problems`";
$page_cnt=100;
$result=mysqli_query($mysqli,$sql);
echo mysqli_error($mysqli);
$row=mysqli_fetch_object($result);
//将其转换为整型变量
$cnt=intval($row->upid);
$cnt/=$page_cnt;//得到页数

//得到当前页的题目id范围
$page='1';
$page_start=($page_cnt)*(intval($page)-1);
$page_end=$page_start+$page_cnt;
$sub_arr=Array();

//submit
if (isset($_SESSION['user_id'])){
    $sql="SELECT `problem_id` FROM `submissions` WHERE `user_id`='".$_SESSION['user_id']."'".
        "group by `problem_id`";
    $result=@mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
    while ($row=mysqli_fetch_array($result))
        $sub_arr[$row[0]]=true;
}
//AC
$acc_arr=Array();
if (isset($_SESSION['user_id'])){
    $sql="SELECT `problem_id` FROM `submissions` WHERE `user_id`='".$_SESSION['user_id']."'".
        "AND `result`=4".
        " group by `problem_id`";
    $result=@mysqli_query($mysqli,$sql) or die(mysqli_error());
    while($row=mysqli_fetch_array($result))
        $acc_arr[$row[0]]=true;
}


//按照提供的title或是id范围搜索
if(isset($_GET['search']) && trim($_GET['search'])!=""){
    $search=mysqli_real_escape_string($mysqli,$_GET['search']);
    $filter_sql=" ( title like '%$search%')";
}
else{
    $filter_sql="  `problem_id`>='".strval($page_start)."' AND `problem_id`<'".strval($page_end)."' ";
}

//按照权限显示题目，有的在contest里，有的是hide=1
if(isset($_SESSION['groups']) && $_SESSION['groups']<=-4){
    //若是管理员，不用在意是否hide或是在contest中
    $sql="SELECT `problem_id`,`title`,`submit`,`accept` FROM `problems` WHERE $filter_sql AND `deleted`=0";
}
else if(isset($_SESSION['groups']) && $_SESSION['groups']<0){
    $now=strftime("%Y-%m-%d %H:%M",time());
    $sql="SELECT `problem_id`,`title`,`submit`,`accept` FROM `problems`".
        "WHERE $filter_sql AND `deleted`=0 AND `problem_id` NOT IN(
        SELECT `problem_id` FROM `contest_problem` WHERE `contest_id` IN(
        SELECT `contest_id` FROM `contest` WHERE
        (`end_time`>'$now' AND `contest`.`private`=1) AND contest.`hide`=0)
        )";
}
else{
    $now=strftime("%Y-%m-%d %H:%M",time());
    $sql="SELECT `problem_id`,`title`,`submit`,`accept` FROM `problems`".
        "WHERE `problems`.`hide`=0 AND $filter_sql AND `deleted`=0 AND `problem_id` NOT IN(
        SELECT `problem_id` FROM `contest_problem` WHERE `contest_id` IN(
        SELECT `contest_id` FROM `contest` WHERE
        (`end_time`>'$now' AND `contest`.`private`=1) AND contest.`hide`=0)
        )";
}
$sql.=" ORDER BY `problem_id`";//按照题目id排序
$result=mysqli_query($mysqli,$sql) or die(mysqli_error());

//从$result中获取当前页面能显示的题目信息放进$view_problemset中
$view_total_page=$cnt+1;
$cnt=0;
$view_problemset=Array();
$i=0;
while($row=mysqli_fetch_object($result)){
    $view_problemset[$i]=Array();
    //给AC的打Y，提交而未过的打N
    if (isset($sub_arr[$row->problem_id])){
        if (isset($acc_arr[$row->problem_id]))
            $view_problemset[$i][0]="<span class='glyphicon glyphicon-ok'></span>";
        else
            $view_problemset[$i][0]="<span class='glyphicon glyphicon-remove'></span>";
    }
    else
        $view_problemset[$i][0]="<div class=none></div>";
    $view_problemset[$i][1]="<div class='center'>".$row->problem_id."</div>";;
    $view_problemset[$i][2]="<div class='left'>&nbsp;<a href='problem.php?id=".$row->problem_id."'>".$row->title."</a></div>";;
    $temp=0;
    if ($row->submit)
     $temp=$row->accept*100/$row->submit;
    $temp1=100-$temp;

    $view_problemset[$i][3]="<div class='progress progress-striped' style='text-align: center;height: 20px'>
<div class=\"progress-bar progress-bar-success\" role=\"progressbar\"
         aria-valuenow=\"60\" aria-valuemin=\"0\" aria-valuemax=\"100\"
         style=\"width:".$temp."% ;\">
        <span>$row->accept Yes</span>
    </div>";
    if ($row->submit>0)
        $view_problemset[$i][3].="<div class=\"progress-bar progress-bar-danger\" role=\"progressbar\"
         aria-valuenow=\"60\" aria-valuemin=\"0\" aria-valuemax=\"100\"
         style=\"width:".$temp1."% ;\">
        <span>".intval($row->submit-$row->accept)." No</span>
    </div>";
$view_problemset[$i][3].="</div>";
//    $view_problemset[$i][3]="<div class=\"progress progress-striped\" style='text-align: center'>
//    <span style='color:black;'>".$row->accept."/".$row->submit."</span>
//    <div class=\"progress-bar progress-bar-info\" role=\"progressbar\"
//         aria-valuenow=\"60\" aria-valuemin=\"0\" aria-valuemax=\"100\"
//         style=\"width:".$temp."% ;\">
//    </div>";
//    if ($row->submit>0)
//        $view_problemset[$i][3].="<div class=\"progress-bar progress-bar-warning\" role=\"progressbar\"
//         aria-valuenow=\"60\" aria-valuemin=\"0\" aria-valuemax=\"100\"
//         style=\"width:".$temp1."% ;\">
//    </div>";
//    $view_problemset[$i][3].= "</div>";

//    $view_problemset[$i][3]="<div class='center'>".$row->submit."</div>";;
//    $view_problemset[$i][4]="<div class='center'>".$row->accept."</div>";;
    $i++;
}
mysqli_free_result($result);
require("template/problemset_t.php");
?>