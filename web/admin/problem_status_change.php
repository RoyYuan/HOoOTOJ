<?php
/**
 * Created by PhpStorm.
 * User: RoyYuan
 * Date: 2018/4/24
 * Time: 13:41
 */
require_once ("admin_header.php");
//require_once (",,/include/check_get_key.php");
$id=intval($_GET['id']);
$sql="SELECT `hide` FROM `problems` WHERE `problem_id`=$id";
$result=mysqli_query($mysqli,$sql);
$row=mysqli_fetch_row($result);
$hide=$row[0];
echo $hide;
mysqli_free_result($result);
if ($hide==1)
    $sql="UPDATE `problems` SET `hide`=0 WHERE `problem_id`=$id";
else
    $sql="UPDATE `problems` SET `hide`=1 WHERE `problem_id`=$id";
mysqli_query($mysqli,$sql) or die(mysqli_error());
?>
<script>
    history.go(-1);
</script>
