<?php
/**
 * Created by PhpStorm.
 * User: RoyYuan
 * Date: 2018/4/25
 * Time: 12:45
 */
require_once ("admin_header.php");
//require_once (",,/include/check_get_key.php");
$id=intval($_GET['id']);
if ($_SESSION['groups']>-4){
    mysqli_free_result($result);
    echo "<script>\n";
    echo "alert('您的帐号不能对此题目进行删除操作！\\n');\n";
    echo "history.go(-1);\n";
    echo "</script>";
    exit(1);
}
$sql="UPDATE `problems` SET `deleted`=1 WHERE `problem_id`=$id";
mysqli_query($mysqli,$sql) or die(mysqli_error());
?>
<script>
    history.go(-1);
</script>