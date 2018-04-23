<?php
/**
 * Created by PhpStorm.
 * User: RoyYuan
 * Date: 2018/4/22
 * Time: 21:28
 */

function add_problem($title,$time_limit,$memory_limit,$description,$input,$output,$sample_input,$sample_output,$test_input,$test_output,$hint,$OJ_DATA,$owner){
    $mysqli=$GLOBALS['mysqli'];
    $title=mysqli_real_escape_string($mysqli,$title);
    $time_limit=mysqli_real_escape_string($mysqli,$time_limit);
    $memory_limit=mysqli_real_escape_string($mysqli,$memory_limit);
    $description=mysqli_real_escape_string($mysqli,$description);
    $input=mysqli_real_escape_string($mysqli,$input);
    $output=mysqli_real_escape_string($mysqli,$output);
    $sample_input=mysqli_real_escape_string($mysqli,$sample_input);
    $sample_output=mysqli_real_escape_string($mysqli,$sample_output);
//    $test_input=mysqli_real_escape_string($mysqli,$test_input);
//    $test_output=mysqli_real_escape_string($mysqli,$test_output);
    $hint=mysqli_real_escape_string($mysqli,$hint);
    $owner=mysqli_real_escape_string($mysqli,$owner);
    $sql="INSERT INTO `problems` (`title`,`description`,`input`,`output`,`sample_input`,`sample_output`,`hint`,`time_limit`,`memory_limit`,`owner_id`,`hide`,`deleted`,`submit`,`accept`)
VALUES('$title','$description','$input','$output','$sample_input','$sample_output','$hint','$time_limit','$memory_limit','$owner',1,0,0,0)";
    @mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
    $pid=mysqli_insert_id($mysqli);
    echo "<br> Added Problem $pid ";
    return $pid;
}
function mk_data($pid,$filename,$input,$OJ_DATA){
    $base_dir="$OJ_DATA/$pid";
    $fp=@fopen($base_dir."/$filename","w");
    if ($fp){
        fputs ( $fp, preg_replace ( "(\r\n)", "\n", $input ) );
        fclose ( $fp );
    }
    else{
        echo "Error while opening".$base_dir . "/$filename ,try [chgrp -R www-data $OJ_DATA] and [chmod -R 771 $OJ_DATA ] ";
    }
}

require_once ("admin_header.php");
//require_once ("check_post_key.php");
if (!(isset($_SESSION['groups']) || (isset($_SESSION['groups']) && $_SESSION['groups']>=-1))){
    echo "<script>\n";
    echo "alert('您的帐号不能进行增加题目操作\\n');\n";
    echo "window.location.href='index.php';\n";
    echo "</script>";
}

require_once ("../include/db_info.php");

$title=$_POST['title'];
$time_limit=$_POST['time_limit'];
$memory_limit=$_POST['memory_limit'];
$description=$_POST['description'];
$input=$_POST['input'];
$output=$_POST['output'];
$sample_input=$_POST['sample_input'];
$sample_output=$_POST['sample_output'];
$test_input=$_POST['test_input'];
$test_output=$_POST['test_output'];
$hint=$_POST['hint'];
if (get_magic_quotes_gpc()){
    $title = stripslashes($title);
    $time_limit = stripslashes($time_limit);
    $memory_limit = stripslashes($memory_limit);
    $description = stripslashes($description);
    $input = stripslashes($input);
    $output = stripslashes($output);
    $sample_input = stripslashes($sample_input);
    $sample_output = stripslashes($sample_output);
    $test_input = stripslashes($test_input);
    $test_output = stripslashes($test_output);
    $hint = stripcslashes($hint);
}
$user_id=$_SESSION['user_id'];
$pid=add_problem($title,$time_limit,$memory_limit,$description,$input,$output,$sample_input,$sample_output,$test_input,$test_output,$hint,$OJ_DATA,$user_id);
$base_dir="$OJ_DATA/$pid";
mkdir($base_dir);
if (!strlen($sample_input) && strlen($sample_output))
    $sample_input='0';
if (strlen($sample_input))
    mk_data($pid,"sample.in",$sample_input,$OJ_DATA);
if (strlen($sample_output))
    mk_data($pid,"sample.out",$sample_output,$OJ_DATA);
if (!strlen($test_input) && strlen($test_output))
    $test_input='0';
if (strlen($test_input))
    mk_data($pid,"test.in",$test_input,$OJ_DATA);
if (strlen($test_output))
    mk_data($pid,"test.out",$test_output,$OJ_DATA);
?>