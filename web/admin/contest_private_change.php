<?php
/**
 * Created by PhpStorm.
 * User: RoyYuan
 * Date: 2018/4/24
 * Time: 17:11
 */
require_once ("admin_header.php");
$cid=intval($_GET['cid']);
$sql="SELECT `owner_id` FROM `contest` WHERE `contest_id`=$cid";
$result=mysqli_query($mysqli,$sql);
$row=mysqli_fetch_row($result);
$owner_id=$row[0];
if ($_SESSION['groups']>-4 && $_SESSION['user_id']!=$owner_id){
    mysqli_free_result($result);
    echo "<script>\n";
    echo "alert('您的帐号不能对此竞赛进行编辑！\\n');\n";
    echo "history.go(-1);\n";
    echo "</script>";
    exit(1);
}
mysqli_free_result($result);
$sql="SELECT `private` FROM `contest` WHERE `contest_id`=$cid";
$result=mysqli_query($mysqli,$sql);
$num=mysqli_num_rows($result);
if ($num<1){
    mysqli_free_result($result);
    echo "没有该竞赛！";
    require_once ("../footer.php");
    exit(0);
}
$row=mysqli_fetch_row($result);
if (intval($row[0])==0)
    $sql="UPDATE `contest` SET `private`=1 WHERE `contest_id`=$cid";
else
    $sql="UPDATE `contest` SET `private`=0 WHERE `contest_id`=$cid";
mysqli_query($mysqli,$sql);
mysqli_free_result($result);
?>
<script>
    history.go(-1);
</script>
