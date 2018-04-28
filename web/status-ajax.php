<?php
/**
 * Created by PhpStorm.
 * User: RoyYuan
 * Date: 2018/4/27
 * Time: 21:09
 */

$cache_time=2;
$OJ_CACHE_SHARE=false;
require_once ("include/db_info.php");
require_once ("include/const.php");

$submit_id=0;
if (isset($_GET['submit_id'])){
    $submit_id=intval($_GET['submit_id']);
}
$sql="SELECT * FROM submissions WHERE submit_id=$submit_id LIMIT 1";
$result=mysqli_query($mysqli,$sql);
if ($result)
    $rows_cnt=mysqli_num_rows($result);
else
    $rows_cnt=0;

for ($i=0;$i<$rows_cnt;$i++){
    $row=mysqli_fetch_array($result);
    if (isset($_GET['tr'])){
        $r=$row['result'];
        if ($r==11)
            $sql="SELECT `error` FROM `compile_error` WHERE `submit_id`='".$submit_id."'";
        $result=mysqli_query($mysqli,$sql);
        $row=mysqli_fetch_array($result);
        if ($row){
            echo htmlentities(str_replace("\n\r","\n",$row['error']),ENT_QUOTES,"UTF-8");
        }
    }
    else{
        echo $row['result'].",".$row['memory'].",".$row['time'];
    }
}
mysqli_free_result($result);