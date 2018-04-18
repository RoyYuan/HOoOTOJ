<?php
/**
 * Created by PhpStorm.
 * User: RoyYuan
 * Date: 2018/4/17
 * Time: 13:20
 */
function check_ac($cid,$pid){
    require_once ("include/db_info.php");
    $mysqli=$GLOBALS['mysqli'];
    $sql="SELECT COUNT(*) FROM `submissions` WHERE `contest_id`='$cid' AND `contest_num`='$pid' AND `result`='4' AND `user_id`='".$_SESSION['user_id']."'";
    $result=mysqli_query($mysqli,$sql);
    $row=mysqli_fetch_array($result);
    $ac=intval($row[0]);
    mysqli_free_result($result);
    if ($ac>0)
        return "<font color=green>Y</font>";
    $sql="SELECT count(*) FROM `submissions` WHERE `contest_id`='$cid' AND `contest_num`='$pid' AND `user_id`='".$_SESSION['user_id']."'";
    $result=mysqli_query($mysqli,$sql);
    $row=mysqli_fetch_array($result);
    $sub=intval($row[0]);
    mysqli_free_result($result);
    if ($sub>0)
        return "<font color=red>N</font>";
    else
        return "";
}

$OJ_CACHE_SHARE=!isset($_GET['cid']);
require_once ("include/db_info.php");
require_once ("include/do_cache.php");
require_once ("include/const.php");

$view_title="竞赛";
function formatTimeLength($length){
    $hour=0;
    $minute=0;
    $second=0;
    $result="";

    $second=$length%60;
    $length=floor($length/60);
    $minute=$length%60;
    $hour=floor($length/60);
    $result=$hour."小时".$minute."分".$second."秒";
    return $result;
}


if (isset($_GET['cid'])){
    $cid=intval($_GET['cid']);
    $contest_cid=$cid;

    $sql="SELECT * FROM `contest` WHERE `contest_id`='$cid' ";
    $result=mysqli_query($mysqli,$sql);
    $rows_cnt=mysqli_num_rows($result);
    $contest_ok=true;
    $password='';
    if (isset($_POST['password']))
        $password=$_POST['password'];
    if (get_magic_quotes_gpc())
        $password=stripcslashes($password);

    if ($rows_cnt==0){
        mysqli_free_result($result);
        $view_title="比赛已经关闭！";
    }
    else{
        $row=mysqli_fetch_object($result);
        if ($row->hide=='1')
            $contest_ok=false;
        if (isset($_SESSION['administrator']))
            $contest_ok=true;

        $now=time();
        $start_time=strtotime($row->start_time);
        $end_time=strtotime($row->end_time);
        $contest_description=$row->description;
        $contest_title=$row->contest_title;
        $contest_start_time=$row->start_time;
        $contest_end_time=$row->end_time;

        if (!isset($_SESSION['administrator']) && $now<$start_time){
            $view_errors="<h2>暂时不可浏览具体信息！</h2>";
            require ("template/show_error_t.php");
            exit(0);
        }
    }
    if (!$contest_ok){
        $view_errors="<h2>暂时不可浏览具体信息！<br/><a href='contestrank.php?cid=$cid'>排名</a></h2>";
        $view_errors.="<form method=post action='contest.php?cid=$cid'>竞赛密码：<input class='input-mini' type='password'><input class='btn' type='submit'></form>";
        require ("template/show_error_t.php");
        exit(0);
    }
    $sql="SELECT * FROM (SELECT problems.title AS title,problems.problem_id AS pid,contest_problem.num AS pnum FROM contest_problem,problems WHERE contest_problem.problem_id=problems.problem_id AND contest_problem.contest_id=$cid ORDER BY contest_problem.num)
problems LEFT JOIN (SELECT problem_id pid1,COUNT(1) accepted FROM submissions WHERE result=4 AND contest_id=$cid GROUP BY pid1)p1 ON problems.pid=p1.pid1
LEFT JOIN (SELECT problem_id pid2,COUNT(1) submit FROM submissions WHERE contest_id=$cid GROUP BY pid2)p2 ON problems.pid=p2.pid2
ORDER BY pnum";

    $result=mysqli_query($mysqli,$sql);
    $contest_problemset=Array();
    $cnt=0;
    while($row=mysqli_fetch_object($result)){
        $contest_problemset[$cnt][0]="";
        if (isset($_SESSION['user_id']))
            $contest_problemset[$cnt][0]=check_ac($cid,$cnt+1);
        $contest_problemset[$cnt][1]="$row->pid Problem &nbsp;".$PID[$cnt];
        $contest_problemset[$cnt][2]="<a href='problem.php?cid=$cid&pid=".($cnt+1)."'>$row->title</a>";
        $contest_problemset[$cnt][3]=$row->accepted;
        $contest_problemset[$cnt][4]=$row->submit;
        $cnt++;
    }

    mysqli_free_result($result);
}
else{
    $keyword="";
    if (isset($_POST['keyword'])){
        $keyword=mysqli_real_escape_string($mysqli,$_POST['keyword']);
    }
    $mycontests="";
    foreach ($_SESSION as $key=>$value){
        if ($key[0]=='c' && intval(substr($key,1))>0){
            $mycontests.=",".intval(substr($key,1));
        }
    }
    if (strlen($mycontests)>0)
        $mycontests=substr($mycontests,1);
    $wheremy="";
    if (isset($_GET['my']))
        $wheremy=" AND contest_id in ($mycontests)";
    $sql="SELECT * FROM contest WHERE hide=0 $wheremy ORDER BY contest_id DESC";
    //$sql="SELECT * FROM contest LEFT JOIN(SELECT * FROM groups WHERE groups.groups like 'm%')p ON concat('m',contest_id)=groups WHERE contest.hide=0 AND contest.title like '%keyword%' $wheremy ORDER BY contest_id DESC limit 1;";

    $result=mysqli_query($mysqli,$sql);
    $contest_list=Array();
    $i=0;
    if (mysqli_num_rows($result)>0){
        while($row=mysqli_fetch_object($result)){
            $contest_list[$i][0]="<td class='center'>".$row->contest_id."</td>";
            $contest_list[$i][1]="<td><a href='contest.php?cid=$row->contest_id'>$row->contest_title</a></td>";
            $start_time=strtotime($row->start_time);
            $end_time=strtotime($row->end_time);
            $now=time();
            $length=$end_time-$start_time;
            $left=$end_time-$now;
            if ($now>$end_time){
                $contest_list[$i][2]="<td><span class=green>已结束于$row->end_time</span></td>";
            }
            elseif ($now<$start_time){
                $contest_list[$i][2]="<td><span class=blue>开始于$row->start_time</span>&nbsp;";
                $contest_list[$i][2].="<span class=green>总时长".formatTimeLength($length)."</span></td>";
            }
            else{
                $contest_list[$i][2]="<td><span class=red>正在进行</span>&nbsp;";
                $contest_list[$i][2].="<span class=green>剩余时长".formatTimeLength($left)."</span></td>";
            }
            $i++;
        }
    }
    mysqli_free_result($result);
}
if (isset($_GET['cid']))
    require ("template/contest_t.php");
else
    require ("template/contestset_t.php");
?>
