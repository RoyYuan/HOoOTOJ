<?php
/**
 * Created by PhpStorm.
 * User: RoyYuan
 * Date: 2018/4/14
 * Time: 15:34
 */
function is_running($cid){
    $mysqli=$GLOBALS['mysqli'];
    $now=strftime("%Y-%m-%d %H:%M",time());
    $sql="SELECT count(*) FROM `contest` WHERE `contest_id`='$cid' AND `end_time`>'$now'";
    $result=mysqli_query($mysqli,$sql);
    $row=mysqli_fetch_array($result);
    $cnt=intval($row[0]);
    mysqli_free_result($result);
    return $cnt>0;
}

$judge_color=Array("btn gray","btn btn-info","btn btn-warning","btn btn-warning","btn btn-success","btn btn-danger","btn btn-danger","btn btn-warning","btn btn-warning","btn btn-warning","btn btn-warning","btn btn-warning","btn btn-warning","btn btn-info");


$cache_time=2;
$OJ_CACHE_SHARE=false;
require_once ("include/db_info.php");
require_once ("include/do_cache.php");
require_once ("include/const.php");
$view_title="STATUS";

$str="";
$lock=false;
$lock_time=date("Y-m-d H:i:s",time());
$sql="SELECT * FROM `submissions` WHERE problem_id>0 ";
if (isset($_GET['cid'])){
    //获取竞赛cid的status
    $cid=intval($_GET['cid']);
    $sql=$sql." AND `contest_id`='$cid' AND num>0";
    $str="&cid=$cid";
    $sql_lock="SELECT `start_time`,`title`,`end_time` FROM `contest` WHERE `contest_id`='$cid'";
    $result=mysqli_query($mysqli,$sql_lock) or die(mysqli_error($mysqli));
    $rows_cnt=mysqli_num_rows($result);
    $start_time=0;
    $end_time=0;
    if ($rows_cnt>0){
        $row=mysqli_fetch_array($result);
        $start_time=strtotime($row[0]);
        $title=$row[1];
        $end_time=strtotime($row[2]);
    }
    $lock_time=$end_time-($end_time-$start_time)*$OJ_RANK_LOCK_PERCENT;
    $time_sql="";
    if (time()>$lock_time && time()<$end_time){
        $lock=true;
    }
    else
        $lock=false;
}
else{
    if (isset($_SESSION['administrator']) || (isset($_SESSION['user_id']) && isset($_GET['user_id']) && $_GET['user_id'] && $_GET['user_id']==$_SESSION['user_id'])){
        $sql="SELECT * FROM `submissions` WHERE contest_id is null";
    }
    else{
        $sql="SELECT * FROM `submissions` WHERE problem_id>0 AND contest_id is null";
    }
}
$start_first=true;
$order_str=" ORDER BY `submit_id` DESC";

if (isset($_GET['top'])){
    $top=strval(intval($_GET['top']));
    if ($top!=-1)
        $sql=$sql."AND `submit_id`<='".$top."' ";
}

$problem_id="";
if (isset($_GET['problem_id']) && $_GET['problem_id']!=""){
    if (isset($_GET['cid'])){
        $problem_id=htmlentities($_GET['problem_id'],ENT_QUOTES,'UTF-8');
        $num=strpos($PID,$problem_id);
        $sql.="AND `num`='".$num."' ";
        $str.="&problem_id=".$problem_id;
    }
    else{
        $problem_id=strval(intval($_GET['problem_id']));
        if ($problem_id!='0'){
            $sql.="AND `problem_id`='".$problem_id."' ";
            $str.="&problem_id=".$problem_id;
        }
        else
            $problem_id="";
    }
}


$user_id="";
if (isset($_GET['user_id']) && $_GET['user_id']!=""){
    $user_id=trim($_GET['user_id']);
    $sql=$sql."AND `user_id`='".$user_id."' ";
    if ($str!="")
        $str.="&";
    $str.="user_id=".$user_id;
}

if (isset($_GET['judge_result']))
    $result=intval($_GET['judge_result']);
else
    $result=-1;

if ($result>12 || $result<0)
    $result=-1;
if ($result!=-1 && !$lock){
    $sql.="AND `result`='".strval($result)."' ";
    $str=$str."&judge_result=".$result;
}


$sql=$sql.$order_str." LIMIT 20";

$result=mysqli_query($mysqli,$sql);
if ($result)
    $rows_cnt=mysqli_num_rows($result);
else
    $rows_cnt=0;
$top=$bottom=-1;
$cnt=0;
if ($start_first){
    $row_start=0;
    $row_add=1;
}
else{
    $row_start=$rows_cnt-1;
    $row_add=-1;
}
$view_status=Array();
$last=0;
for ($i=0;$i<$rows_cnt;$i++){
    $row=mysqli_fetch_array($result);
    if ($i==0 && $row['result']<4)
        $last=$row['submit_id'];

    if ($top==-1)
        $top=$row['submit_id'];
    $bottom=$row['submit_id'];
    $flag=(!is_running(intval($row['contest_id']))) || isset($_SESSION['administrator']) ||
        (isset($_SESSION['user_id']) && !strcmp($_row['user_id'],$_SESSION['user_id']));

    $cnt=1-$cnt;

    //0
    $view_status[$i][0]=$row['submit_id'];

    //1
    if ($row['contest_id']>0){
        $view_status[$i][1]="<a href='contest_rank.php?cid=".$row['contest_id']."&user_id=".$row['user_id']."#".$row['user_id']."'>".$row['user_id']."</a>";
    }
    else{
        $view_status[$i][1]="<a href='userinfo.php?user=".$row['user_id']."'>".$row['user_id']."</a>";
    }

    //2
    if ($row['contest_id']>0){
        $view_status[$i][2]="<div class='center'><a href='problem.php?cid=".$row['contest_id']."&pid=".$row['num']."'>";
        if (isset($cid)){
            $view_status[$i][2].=$PID[$row['num']];
        }
        else{
            $view_status[$i][2].=$row['problem_id'];
        }
        $view_status[$i][2].="</div></a>";
    }
    else{
        $view_status[$i][2]="<div class='center'><a href='problem.php?id=".$row['problem_id']."'>".$row['problem_id']."</a></div>";
    }

    //3
    $view_status[$i][3]="";
    if (intval($row['result'])==11 && ((isset($_SESSION['user_id']) && $row['user_id']==$_SESSION['user_id']) || isset($_SESSION['source_brower']) ) ){
        $view_status[$i][3].="<a href='ceinfo.php?sid=".$row['submit_id']."' class='".$judge_color[$row['result']]."' title='点击查看详情'>CE</a>";
    }
    elseif ( (((intval($row['result'])==5 || intval($row['result'])==6) && $OJ_SHOW_DIFF) || $row['result']==10 || $row['result']==13) && ((isset($_SESSION['user_id']) && $row['user_id']==$_SESSION['user_id']) || isset($_SESSION['source_brower']))){
        $view_status[$i][3].= "<a href='reinfo.php?sid=".$row['solution_id']."' class='".$judge_color[$row['result']]."' title='点击查看详情'>".$judge_result[$row['result']]."</a>";
    }
    else{
        if (!$lock || $lock_time>$row['submit_time'] || $row['user_id']==$_SESSION['user_id']) {
            $view_status[$i][3].= "<span class='";
            $view_status[$i][3].=$judge_color[$row['result']];
            $view_status[$i][3].="'>";
            $view_status[$i][3].=$judge_result[$row['result']];
            $view_status[$i][3].="</span>";
        }
        else{
            echo "<td>----";
        }
    }
    if (isset($_SESSION['http_judge'])){
        $view_status[$i][3].="<form class='http_judge_form form-inline'><input type='hidden' name='sid' value='".$row['submit_id']."'>";
        $view_status[$i][3].="</form>";
    }

    //4-7
    if ($flag){
        //4&5
        if ($row['result']>=4){
            $view_status[$i][4]="<div id='center' class='red'>".$row['memory']."</div>";
            $view_status[$i][5]="<div id='center' class='red'>".$row['time']."</div>";
        }
        else{
            $view_status[$i][4]="---";
            $view_status[$i][5]="---";
        }
        //6
        if ( !(isset($_SESSION['user_id']) && strtolower($row['user_id'])==strtolower($_SESSION['user_id']) || isset($_SESSION['source_brower']))){
            $view_status[$i][6]=$language_name[$row['language']];
        }
        else{
            $view_status[$i][6]="<a target=_blank href=showsource.php?id=".$row['submit_id'].">".$language_name[$row['language']]."</a>";
            if ($row['problem_id']>0){
                if (isset($cid)){
                    $view_status[$i][6].="/<a target=_self href=\"submitpage.php?cid=".$cid."&pid=".$row['num']."&sid=".$row['submit_id']."\">Edit</a>";
                }
                else{
                    $view_status[$i][6].="/<a target=_self href=\"submitpage.php?id=".$row['problem_id']."&sid=".$row['submit_id']."\">Edit</a>";
                }
            }
        }
        //7
        $view_status[$i][7]=$row['code_length']." B";
    }
    else{
        for($j=4;$j<8;$j++)
            $view_status[$i][$j]="----";
    }

    //8
    $view_status[$i][8]=$row['submit_time'];
}

if ($result)
    mysqli_free_result($result);

if (isset($_GET['cid']))
    require ("template/contest_status_t.php");
else
    require ("template/status_t.php");
?>