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
        return "<span class='glyphicon glyphicon-ok'></span>";
    $sql="SELECT count(*) FROM `submissions` WHERE `contest_id`='$cid' AND `contest_num`='$pid' AND `user_id`='".$_SESSION['user_id']."'";
    $result=mysqli_query($mysqli,$sql);
    $row=mysqli_fetch_array($result);
    $sub=intval($row[0]);
    mysqli_free_result($result);
    if ($sub>0)
        return "<span class='glyphicon glyphicon-remove'></span>";
    else
        return "";
}

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

$OJ_CACHE_SHARE=!isset($_GET['cid']);
require_once ("include/db_info.php");
require_once ("include/do_cache.php");
require_once ("include/const.php");

$view_title="竞赛";

if (isset($_GET['cid'])){
    //进入cid的竞赛页面
    $cid=intval($_GET['cid']);
    $contest_cid=$cid;

    $sql="SELECT * FROM `contest` WHERE `contest_id`='$cid'";
    if (isset($_SESSION['groups']) && $_SESSION['groups']<=-4)
        ;
    else
        $sql.=" AND `hide`=0";
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
        $view_errors="<h2>不存在该竞赛！</h2>";
        require ("template/show_error_t.php");
        exit(0);
    }
    else{
        $row=mysqli_fetch_object($result);

        //private contest
        if ($row->private=='1' && !isset($_SESSION['c'.$cid]))
            $contest_ok=false;
        if ($password!="" && $password==$row->contest_key)//验证private邀请密码
            $_SESSION['c'.$cid]=true;
        if ($row->hide==1)
            $contest_ok=false;
        //G4-5可以直接浏览private contest
        if (isset($_SESSION['groups']) && $_SESSION['groups']<=-4)
            $contest_ok=true;

        $now=time();
        $start_time=strtotime($row->start_time);
        $end_time=strtotime($row->end_time);
        $contest_description=$row->description;
        $contest_title=$row->contest_title;
        $contest_start_time=$row->start_time;
        $contest_end_time=$row->end_time;

        if ((!isset($_SESSION['groups']) || (isset($_SESSION['groups']) && $_SESSION['groups']>-2)) && $now<$start_time){
            $view_errors="<h2>比赛尚未开始，还不能浏览详细信息！</h2>";
            require ("template/show_error_t.php");
            exit(0);
        }
    }
    if (!$contest_ok){
        $view_errors="<h2>比赛需要验证后进行！<br/><a href='contest_rank.php?cid=$cid'>排名</a></h2>";
        $view_errors.="<form method=post action='contest.php?cid=$cid'>竞赛密码：<input class='input-mini' type='password' name='password'><input class='btn' type='submit'></form>";
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
        $contest_problemset[$cnt][0]="<td></td>";
        if (isset($_SESSION['user_id']))
            $contest_problemset[$cnt][0]="<td>".check_ac($cid,$cnt+1)."</td>";
        $contest_problemset[$cnt][1]="<td align='left'>&nbsp;Problem &nbsp;".$PID[$cnt]."</td>";
        $contest_problemset[$cnt][2]="<td>&nbsp;<a href='problem.php?cid=$cid&pid=".($cnt+1)."'>$row->title</a></td>";
        $temp=0;
        if ($row->submit)
            $temp=$row->accepted*100/$row->submit;
        $temp1=100-$temp;

        $contest_problemset[$cnt][3]="<td><div class='progress progress-striped' style='text-align: center'>
<div class=\"progress-bar progress-bar-success\" role=\"progressbar\"
         aria-valuenow=\"60\" aria-valuemin=\"0\" aria-valuemax=\"100\"
         style=\"width:".$temp."% ;\">
        <span>$row->accepted Yes</span>
    </div>";
        if ($row->submit>0)
            $contest_problemset[$cnt][3].="<div class=\"progress-bar progress-bar-danger\" role=\"progressbar\"
         aria-valuenow=\"60\" aria-valuemin=\"0\" aria-valuemax=\"100\"
         style=\"width:".$temp1."% ;\">
        <span>".intval($row->submit-$row->accepted)." No</span>
    </div>";
        $contest_problemset[$cnt][3].="</div></td>";


//        $contest_problemset[$cnt][3]="<td class='center'>".$row->accepted."</td>";
//        $contest_problemset[$cnt][4]="<td class='center'>".$row->submit."</td>";
        $cnt++;
    }

    mysqli_free_result($result);
}
else{
    //显示contestset


    $keyword="";
    if (isset($_POST['keyword'])){
        $keyword=mysqli_real_escape_string($mysqli,$_POST['keyword']);
    }

    //此帐号有权限的contests
    $mycontests="";
    foreach ($_SESSION as $key=>$value){
        if ($key[0]=='c' && intval(substr($key,1))>0){
            $mycontests.=",".intval(substr($key,1));
        }
    }
    if (strlen($mycontests)>0)
        $mycontests=substr($mycontests,1);

    //
    $wheremy="";
    if (isset($_GET['my']))
        $wheremy=" AND contest_id in ($mycontests)";
//    $sql="SELECT * FROM contest WHERE hide=0 $wheremy ORDER BY contest_id DESC";
    $sql="select *  from contest left join (select * from groups where groups>0) p on contest_id=groups where hide=0 and contest_title like '%$keyword%' $wheremy  order by contest_id desc;";
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
                $contest_list[$i][2]="<td align='center'><span class='green'>已结束于$row->end_time</span></td>";
            }
            elseif ($now<$start_time){
                $contest_list[$i][2]="<td align='center'><span class='blue'>开始于$row->start_time</span>&nbsp;";
                $contest_list[$i][2].="<span class='green'>总时长".formatTimeLength($length)."</span></td>";
            }
            else{
                $contest_list[$i][2]="<td align='center'><span class='red'>正在进行</span>&nbsp;";
                $contest_list[$i][2].="<span class='green'>剩余时长".formatTimeLength($left)."</span></td>";
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
