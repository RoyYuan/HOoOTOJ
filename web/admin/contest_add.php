<?php
/**
 * Created by PhpStorm.
 * User: RoyYuan
 * Date: 2018/4/23
 * Time: 15:44
 */
require_once ("../include/db_info.php");
require_once ("../include/const.php");

$start_time=$_POST['start_time'];
$end_time=$_POST['end_time'];
$contest_title=$_POST['title'];
$private=$_POST['private'];
$password=$_POST['password'];
$description=$_POST['description'];
if (get_magic_quotes_gpc()){
    $contest_title=stripcslashes($contest_title);
    $private=stripcslashes($private);
    $password=stripcslashes($password);
    $description=stripcslashes($description);
}
$contest_title=mysqli_real_escape_string($mysqli,$contest_title);
$private=mysqli_real_escape_string($mysqli,$private);
$password=mysqli_real_escape_string($mysqli,$password);
$description=mysqli_real_escape_string($mysqli,$description);

$user_id=$_SESSION['user_id'];

$sql="INSERT INTO `contest`(`contest_title`,`start_time`,`end_time`,`private`,`contest_key`,`hide`,`owner_id`)
VALUES ('$contest_title','$start_time','$end_time','$private','$password',0,'$user_id')";
//echo $sql;
mysqli_query($mysqli,$sql) or die(mysqli_error());
$cid=mysqli_insert_id($mysqli);
echo "Added Contest ".$cid;
$problem_list=trim($_POST['contest_problems']);
$pieces=explode(",",$problem_list);
if (count($pieces)>0 && strlen($pieces[0])>0){
    $sql_1="INSERT INTO `contest_problem` (`contest_id`,`problem_id`,`num`)
VALUES('$cid','$pieces[0]',1)";
    for ($i=2;$i<=count($pieces);$i++){
        $j=$i-1;
        $sql_1=$sql_1.",('$cid','$pieces[$j]',$i)";
    }
//    echo $sql_1;
    mysqli_query($mysqli,$sql_1) or die(mysqli_error());
    $sql="UPDATE `problems` SET `hide`=0 WHERE `problem_id` in ($problem_list)";
    mysqli_query($mysqli,$sql) or die(mysqli_error());
}
echo "<script>window.location.href='contest_list.php';</script>";