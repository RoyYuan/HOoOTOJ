<?php
/**
 * Created by PhpStorm.
 * User: RoyYuan
 * Date: 2018/4/14
 * Time: 15:45
 */
require_once ("include/db_info.php");
if (!isset($cache_time))
    $cache_time=10;
$sid=$OJ_NAME;
$OJ_CACHE_SHARE=(isset($OJ_CACHE_SHARE) && $OJ_CACHE_SHARE) && !isset($_SESSION['administrator']);
if (!$OJ_CACHE_SHARE && isset($_SESSION['user_id'])){
    $sid.=session.id().$_SERVER['REMOTE_ADDR'];
}
if (isset($_SERVER['REQUEST_URI'])){
    $sid.=$_SERVER['REQUEST_URI'];
}

$sid=md5($sid);
$file="cache/cache_$sid.html";

if (file_exists($file))
    $last=filemtime($file);//上次修改时间
else
    $last=0;
$user_cache=(time()-$last<$cache_time);

if ($user_cache){
    include ($file);
    exit();
}
else{
    ob_start();
}
?>