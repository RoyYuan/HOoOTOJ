<?php
/**
 * Created by PhpStorm.
 * User: RoyYuan
 * Date: 2018/4/11
 * Time: 12:21
 */
require_once ('include/db_info.php');
$now=strftime("%Y-%m-%d %H:%M",time());
if (isset($_GET['cid']))
    $ucid="$cid=".intval($_GET['cid']);
else
    $ucid="";
$pr_flag=false;
$co_flag=false;

//跳转到指定id的problem
if (isset($_GET['id']))
{
    $id=intval($_GET['id']);
    if (!isset($_SESSION['administrator']) && $id!=1000 && !isset($_SESSION['contest_creator']))
    {
        $sql="SELECT * FROM `problems`".
            " WHERE `problem_id`=$id AND `problems`.`hide`=0 AND `problem_id` NOT IN (
            SELECT `problem_id` FROM `contest_problem` WHERE `contest_id` IN(
            SELECT `contest_id` FROM `contest` WHERE `end_time`>'$now' or `contest`.`hide`=1
            )
            )";
    }
    else
        $sql="SELECT * FROM `problems` WHERE `problem_id`=$id";
    $pr_flag=true;
}
//contest_id & problem_id
elseif (isset($_GET['cid']) && isset($_GET['pid'])){
    $cid=intval($_GET['cid']);
    $pid=intval($_GET['pid']);
    //根据权限决定sql
    if(!isset($_SESSION['administrator']))
        $sql="SELECT `hide` FROM `contest` WHERE `hide`=0 AND `contest_id`=$cid AND `start_time`<='$now'";
    else
        $sql="SELECT `hide` FROM `contest` WHERE `contest_id`=$cid";
    $result=mysqli_query($mysqli,$sql);
    $rows_cnt=mysqli_num_rows($result);
    $row=mysqli_fetch_row($result);
    $contest_ok=true;
    if ($row[0] && !isset($_SESSION['c'.$cid]))
        $contest_ok=false;
    if (isset($_SESSION['administrator']))
        $contest_ok=true;
    $ok_cnt=$rows_cnt=1;
    mysqli_free_result($result);
    if($ok_cnt!=1){
        $view_errors="没有该竞赛！";
        require("template/show_error_t.php");
        exit(0);
    }
    else{
        //从题库中找到该cid与对应pid的题
        $sql="SELECT * FROM `problem`"
            ."WHERE `hide`=0 AND `problem_id`=(
            SELECT `problem_id` FROM `contest_problem` WHERE `contest_id`=$cid AND `num`=$pid
            )";
    }

    if (!$contest_ok){
        $view_errors="不是参赛成员！";
        require ("template/show_error_t.php");
        exit(0);
    }
    $co_flag=true;
}
else{
    $view_errors="没有该题目";
    require ("template/show_error_t.php");
    exit(0);
}
$result=mysqli_query($mysqli,$sql) or die(mysqli_error());

if(mysqli_num_rows($result)!=1){
    $view_errors="";
    if (isset($_GET['id'])){
        $id=intval($_GET['id']);
        mysqli_free_result($result);
        $sql="SELECT contest.`contest_id` FROM `contest_problem`,`contest` WHERE contest.contest_id = contest_problem.contest_id AND `problem_id`=$id AND contest.`hide`=0 ORDER BY `num`";
        $result=mysqli_query($mysqli,$sql);
        if($i=mysqli_num_rows($result)){
            $view_errors.="该题目正用于竞赛";
            require ("template/show_error_t.php");
            exit(0);
        }
        else{
            $view_errors="没有该题目";
            require ("template/show_error_t.php");
            exit(0);
        }
    }
    else{
        $view_errors="没有该题目";
        require ("template/show_error_t.php");
        exit(0);
    }
}
else{
    $row=mysqli_fetch_object($result);
    $view_title=$row->title;
}
mysqli_free_result($result);
require ("template/problem_t.php");

?>