<?php
/**
 * Created by PhpStorm.
 * User: RoyYuan
 * Date: 2018/4/13
 * Time: 13:33
 */
session_start();
if (!isset($_SESSION['user_id'])){
    require_once ("header.php");
    echo "<a href='loginpage.php'>登陆</a>";
    exit(0);
}

require_once ("include/db_info.php");

$now=strftime("%Y-%m-%d %H:%M",time());
$user_id=$_SESSION['user_id'];
if (isset($_POST['cid'])){
    $pid=intval($_POST['pid']);
    $cid=intval($_POST['cid']);
    $sql="SELECT `problem_id` FROM `contest_problem` WHERE `num`='pid' AND `contest_id`=$cid";
}
else{
    $id=intval($_POST['id']);
    $sql="SELECT `problem_id` FROM `problems` WHERE `problem_id`=$id AND `problem_id` NOT IN (SELECT DISTINCT problem_id FROM `contest_problem` WHERE `contest_id` IN (
SELECT `contest_id` FROM `contest` WHERE (`end_time`>'$now' or `contest`.hide=1)))";
    if (!isset($_SESSION['administrator']))
        $sql.="AND `problems`.`hide`=0";
}

$result=mysqli_query($mysqli,$sql);
if ($result && mysqli_num_rows($result) <1 && !isset($_SESSION['administrator']) && !((isset($cid) && $cid<=0) || (isset($id)&&$id<=0))){
    mysqli_free_result($result);
    $view_errors="没有该题目<br>";
    require ("template/show_error_t.php");
    exit(0);
}

mysqli_free_result($result);

if (isset($_POST['id'])){
    $id=intval($_POST['id']);
}
elseif (isset($_POST['pid']) && isset($_POST['cid']) && $_POST['cid']!=0){
    $cid=intval($_POST['cid']);
    $pid=intval($_POST['pid']);
    $sql="SELECT `hide` FROM `contest` WHERE `contest_id`='$cid' AND `start_time`<='$now' AND `end_time`>'$now'";
    $result=mysqli_query($mysqli,$sql);
    $rows_cnt=mysqli_num_rows($result);
    if ($rows_cnt!=1){
        echo "现在不能提交";
        mysqli_free_result($result);
        exit(0);
    }
    $sql="SELECT `problem_id` FROM `contest_problem` WHERE `contest_id`='$cid' AND `num`='$pid'";
    $result=mysqli_query($mysqli,$sql);
    $rows_cnt=mysqli_num_rows($result);
    if ($rows_cnt!=1){
        $view_errors="没有该题目<br>";
        require ("template/show_error_t.php");
        mysqli_free_result($result);
        exit(0);
    }
    else{
        $row=mysqli_fetch_object($result);
        $id=intval($row->problem_id);
        mysqli_free_result($result);
    }
}

$source_code=$_POST['source_code'];
if (get_magic_quotes_gpc()){
    $source_code=stripcslashes($source_code);
}
$source_code=mysqli_real_escape_string($mysqli,$source_code);

$len=strlen($source_code);

if ($len<2){
    $view_errors="代码太短<br>";
    require ("template/show_error_t.php");
    exit(0);
}
if ($len>65536){
    $view_errors="代码太长<br>";
    require ("template/show_error_t.php");
    exit(0);
}

$store_id=0;
if (isset($_SESSION['store_id']))
    $store_id=$_SESSION['store_id'];
if (!isset($pid)){
    $sql="INSERT INTO submissions(problem_id,user_id,language,code_length)
    VALUES ('$id','$user_id',0,'$len')";
}
else{
    $sql="INSERT INTO submissions(problem_id,user_id,language,code_length,contest_id,contest_num)
    VALUES ('$id','$user_id',0,'$len','$cid','$pid')";
}
mysqli_query($mysqli,$sql);
$flag=mysqli_affected_rows($mysqli);
if ($flag<1)
{
    $view_errors="提交失败";
    require ("template/show_error_t.php");
    exit(0);
}


$insert_id=mysqli_insert_id($mysqli);
$sql="INSERT INTO `sourcecode`(`submit_id`,`sourcecode`) VALUES('$insert_id','$source_code')";
mysqli_query($mysqli,$sql);


$statusURL=strstr($_SERVER['REQUEST_URI'],"submit",true)."status.php";
if (isset($cid))
    $statusURL.="?cid=$cid";
$sid="";
if (isset($_SESSION['user_id'])){
    $sid.=session_id().$_SERVER['REMOTE_ADDR'];
}
if (isset($_SERVER["REQUEST_URI"])){
    $sid.=$statusURL;
}

$sid=md5($sid);
$file="cache/cache_$sid.html";
if (file_exists($file))
    unlink($file);

$statusURL="status.php?user_id=".$_SESSION['user_id'];
if (isset($cid))
    $statusURL.="&cid=$cid";

header("Location: $statusURL");
?>