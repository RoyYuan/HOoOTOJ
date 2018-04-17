<?php
/**
 * Created by PhpStorm.
 * User: RoyYuan
 * Date: 2018/4/12
 * Time: 13:55
 */
require_once ("include/db_info.php");
if (!isset($_SESSION['user_id'])){
    $view_errors="<a href=loginpage.php>登陆</a>";
    require ("template/show_error_t.php");
    exit(0);
}
if (!isset($_GET['id']) && (!isset($_GET['cid']) || !isset($_GET['pid']))){
    $view_errors="<h2>没有该题目</h2>";
    require ("template/show_error_t.php");
    exit(0);
}
if (isset($_GET['cid']))
    $cid=intval($_GET['cid']);
if (isset($_GET['pid']))
    $pid=intval($_GET['pid']);
require_once ("template/submitpage_t.php");
?>