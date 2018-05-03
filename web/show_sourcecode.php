<?php
/**
 * Created by PhpStorm.
 * User: RoyYuan
 * Date: 2018/4/16
 * Time: 21:13
 */
$cache_time=90;
$OJ_CACHE_SHARE=false;
require_once ('include/do_cache.php');
require_once ('include/db_info.php');
require_once ('include/const.php');
$view_title="Source Code";

if (!isset($_GET['id'])){
    $view_errors="没有相关源码\n";
    require ("template/show_error_t.php");
    exit(0);
}

$ok=false;
$id=strval(intval($_GET['id']));
$sql="SELECT * FROM `submissions` WHERE `submit_id`='".$id."'";
$result=mysqli_query($mysqli,$sql);
$row=mysqli_fetch_object($result);

$code_language=$row->language;
$code_result=$row->result;
$code_time=$row->time;
$code_memory=$row->memory;
$code_problem_id=$row->problem_id;
$view_user_id=$code_username=$row->username;
$contest_id=$row->contest_id;

mysqli_free_result($result);

if (isset($OJ_EXAM_CONTEST_ID)){
    if ($contest_id<$OJ_EXAM_CONTEST_ID && !isset($_SESSION['source_browser'])){
        header("Content-type: text/html; charset=utf-8");
        echo "竞赛中不能看源码！";
        exit();
    }
}

$view_source="没有可看的源码！";
if (isset($_SESSION['user_id']) && $row->user_id==$_SESSION['user_id'])
    $ok=true;
if (isset($_SESSION['source_browser']))
    $ok=true;

$sql="SELECT `sourcecode` FROM `sourcecode` WHERE `submit_id`=".$id;
$result=mysqli_query($mysqli,$sql);
$row=mysqli_fetch_object($result);
if ($row)
    $view_source=$row->sourcecode;

require ("template/show_sourcecode_t.php");

?>