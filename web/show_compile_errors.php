<?php
/**
 * Created by PhpStorm.
 * User: RoyYuan
 * Date: 2018/4/26
 * Time: 21:16
 */
$cache_time=10;
$OJ_CACHE_SHARE=false;
require_once ("./include/do_cache.php");
require_once ("./include/db_info.php");
require_once ("./include/const.php");


if (!isset($_GET['sid'])){
    $view_errors="没有该提交信息！";
    require ("template/show_error_t.php");
    exit(0);
}


$flag=false;
$submit_id=strval(intval($_GET['sid']));
$sql="SELECT * FROM `submissions` WHERE `submit_id`='".$submit_id."'";
$result=mysqli_query($mysqli,$sql);
$row=mysqli_fetch_object($result);
if ($row && $row->user_id==$_SESSION['user_id'])
    $flag=true;
if (isset($_SESSION['groups']) && $_SESSION['groups']<=-2)
    $flag=true;
$view_reinfo="";
mysqli_free_result($result);
if ($flag){
    $sql="SELECT `error` FROM `compile_error` WHERE `submit_id`='".$submit_id."'";
    $result=mysqli_query($mysqli,$sql);
    $row=mysqli_fetch_object($result);
    if ($row)
        $view_errors= htmlentities(str_replace("\n\r","\n",$row->error),ENT_QUOTES,"UTF-8");
    mysqli_free_result($result);
}
else{
    $view_errors="你没有权限查看此信息！";
    require ("template/show_error_t.php");
    exit(0);
}

require ("template/show_compile_errors_t.php");
?>