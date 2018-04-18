<?php
/**
 * Created by PhpStorm.
 * User: RoyYuan
 * Date: 2018/4/18
 * Time: 14:22
 */
$OJ_CACHE_SHARE=true;
$cache_time=10;
require_once ("include/do_cache.php");
require_once ("include/db_info.php");
require_once ("include/const.php");
class Team{
    var $solved=0;
    var $time=0;
    var $problem_wa_times;
    var $problem_ac_sec;
    var $problem_ce_times;
    var $user_id;
    var $username;
    function __construct(){
        $this->solved=0;
        $this->time=0;
        $this->problem_ce_times=Array(0);
        $this->problem_wa_times=Array(0);
        $this->problem_ac_sec=Array(0);
    }
    function Add($pid,$sec,$res){
        if (isset($this->problem_ac_sec[$pid]) && $this->problem_ac_sec[$pid]>0)
            return;
        if ($res!=4){
            if (isset($this->problem_wa_times[$pid])){
                $this->problem_wa_times[$pid]++;
            }
            else{
                $this->problem_wa_times[$pid]=1;
            }
            if ($res==11)
            {
                if (isset($this->problem_ce_times[$pid]))
                    $this->problem_ce_times[$pid]++;
                else
                    $this->problem_ce_times[$pid]=1;
            }
        }
        else{
            $this->problem_ac_sec[$pid]=$sec;
            $this->solved++;
            if (!isset($this->problem_wa_times[$pid]))
                $this->problem_wa_times[$pid]=0;
            if (!isset($this->problem_ce_times[$pid]))
                $this->problem_ce_times[$pid]=0;
            $this->time+=$sec+($this->problem_wa_times[$pid]-$this->problem_ce_times[$pid])*1200;
        }
    }
}

function s_cmp(Team $A,Team $B){
    if ($A->solved!=$B->solved)
        return $A->solved<$B->solved;
    else
        return $A->time>$B->time;
}

if (!isset($_GET['cid']))
    die("没有该竞赛！");
$cid=intval($_GET['cid']);

$sql="SELECT `start_time`,`contest_title`,`end_time` FROM `contest` WHERE `contest_id`=$cid";
$result=mysqli_query($mysqli,$sql);
if ($result)
    $rows_cnt=mysqli_num_rows($result);
else
    $rows_cnt=0;

$start_time=0;
$end_time=0;
if ($rows_cnt>0){
    $row=mysqli_fetch_array($result);
    $start_time=strtotime($row['start_time']);
    $end_time=strtotime($row['end_time']);
    $title=$row['contest_title'];
}
mysqli_free_result($result);
if ($start_time==0){
    $view_errors="没有该竞赛！";
    require ("template/show_error_t.php");
    exit(0);
}

if ($start_time>time()){
    $view_errors="竞赛尚未开始！";
    require ("template/show_error_t.php");
    exit(0);
}

//封榜
if (!isset($OJ_RANK_LOCK_PERCENT))
    $OJ_RANK_LOJ_RANK_LOCK_PERCENT=0;
$lock=$end_time-($end_time-$start_time)*$OJ_RANK_LOCK_PERCENT;

$sql="SELECT COUNT(1) AS pbc FROM `contest_problem` WHERE `contest_id`='$cid'";
$result=mysqli_query($mysqli,$sql);
if ($result)
    $rows_cnt=mysqli_num_rows($result);
else
    $rows_cnt=0;
$row=mysqli_fetch_array($result);

$pid_cnt=intval($row['pbc']);
mysqli_free_result($result);

$sql="SELECT users.user_id,users.username,submissions.result,submissions.contest_num,submissions.submit_time
FROM (SELECT * FROM submissions WHERE submissions.contest_id='$cid' AND contest_num>0 AND problem_id>0) submissions
LEFT JOIN users ON users.user_id=submissions.user_id ORDER BY users.user_id,submit_time";

$result=mysqli_query($mysqli,$sql);
if ($result)
    $rows_cnt=mysqli_num_rows($result);
else
    $rows_cnt=0;

$user_cnt=0;
$user_name='';
$U=Array();
for ($i=0;$i<$rows_cnt;$i++){
    $row=mysqli_fetch_array($result);
    $nick_user=$row['user_id'];
    if (strcmp($user_name,$nick_user)){
        $user_cnt++;
        $U[$user_cnt]=new Team();
        $U[$user_cnt]->user_id=$row['user_id'];
        $U[$user_cnt]->username=$row['username'];
        $user_name=$nick_user;
    }
    if (time()<$end_time && $lock<strtotime($row['submit_time']))
        $U[$user_cnt]->Add(intval($row['contest_num']),strtotime($row['submit_time'])-$start_time,0);
    else
        $U[$user_cnt]->Add(intval($row['contest_num']),strtotime($row['submit_time'])-$start_time,intval($row['result']));
}
mysqli_free_result($result);
usort($U,"s_cmp");

$first_blood=Array();
for ($i=0;$i<$pid_cnt;$i++){
    $sql="SELECT user_id FROM submissions WHERE contest_id='$cid' AND result=4 AND contest_num=$i ORDER BY submit_time limit 1";
    $result=mysqli_query($mysqli,$sql);
    $rows_cnt=mysqli_num_rows($result);
    $row=mysqli_fetch_array($result);
    if ($rows_cnt==1){
        $first_blood[$i]=$row['user_id'];
    }
    else
        $first_blood[$i]="";
}

require ("template/contest_rank_t.php");
?>