<?php
/**
 * Created by PhpStorm.
 * User: RoyYuan
 * Date: 2018/4/25
 * Time: 21:39
 */
function check_username($str){
    return true;
}


$cache_time=10;
$OJ_CACHE_SHARE=false;
require_once ("include/do_cache.php");
require_once ("include/db_info.php");
require_once ("include/const.php");

$user=$_GET['user'];
if (!check_username($user)){
    echo "没有该用户！";
    exit(0);
}
$view_title=$user."@".$OJ_NAME;
$user_mysql=mysqli_real_escape_string($mysqli,$user);
$sql="SELECT `username` FROM `users` WHERE `user_id`='$user_mysql'";
$result=mysqli_query($mysqli,$sql);
$row_cnt=mysqli_num_rows($result);
if ($row_cnt==0){
    echo "没有该用户！";
    exit(0);
}
$row=mysqli_fetch_object($result);
$username=$row->username;

$sql="SELECT COUNT(DISTINCT problem_id) AS `ac` FROM `submissions` WHERE `user_id`='".$user_mysql."' AND `result`=4";
$result=mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
$row=mysqli_fetch_object($result);
$accepted=$row->ac;
mysqli_free_result($result);

$sql="SELECT COUNT(submit_id) AS `sub` FROM `submissions` WHERE `user_id`='".$user_mysql."' AND problem_id>0";
$result=mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
$row=mysqli_fetch_object($result);
$submited=$row->sub;
mysqli_free_result($result);

$sql="UPDATE `users` SET `solved`='".$accepted."',`submit`='".$submited."' WHERE `user_id`='".$user_mysql."'";
$result=mysqli_query($mysqli,$sql);
$sql="SELECT COUNT(*) AS `Rank` FROM `users` WHERE `solved`>$accepted";
$result=mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
$row=mysqli_fetch_array($result);
$rank=intval($row[0])+1;


require ("template/user_info_t.php");
?>