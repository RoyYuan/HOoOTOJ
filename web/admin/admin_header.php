<?php @session_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script src="../js/jquery.js"></script>
<?php
/**
 * Created by PhpStorm.
 * User: RoyYuan
 * Date: 2018/4/22
 * Time: 19:59
 */
if (!isset($_SESSION['groups']) || (isset($_SESSION['groups']) && $_SESSION['groups']>=-1)){
    echo "<script>\n";
    echo "alert('您的帐号不能进行管理操作\\n');\n";
    echo "window.location.href='index.php';\n";
    echo "</script>";
    exit(1);
}
require_once ("../include/db_info.php");
?>