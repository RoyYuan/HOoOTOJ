<?php
/**
 * Created by PhpStorm.
 * User: RoyYuan
 * Date: 2018/4/16
 * Time: 15:02
 */
if(!isset($_SESSION)){
    session_start();
}

unset($_SESSION['user_id']);
session_destroy();
echo "<script>alert('注销成功!\\n');window.location.href='index.php';</script>";
?>