<?php
/**
 * Created by PhpStorm.
 * User: RoyYuan
 * Date: 2018/4/15
 * Time: 19:43
 */
require_once ("./db_info.php");

$profile="";
if (isset($_SESSION['user_id'])){
    $sid=$_SESSION['user_id'];
    $profile.= "<i class=icon-user></i><a href=modifypage.php>用户信息</a>&nbsp;<a href='userinfo.php?user=$sid'><span id=red>$sid</span></a>";
    $profile.="&nbsp;<a href='./status.php?user_id=$sid'><span id=red>最近提交</span></a>";
    $profile.= "&nbsp;<a href='./logout.php' target='_top' >注销</a>&nbsp;";
}
else{
    $profile.= "<a href=./loginpage.php>登陆</a>&nbsp;";
    $profile.= "<a href=./registerpage.php>注册</a>&nbsp;";
}
if (isset($_SESSION['administrator'])||isset($_SESSION['contest_creator'])||isset($_SESSION['problem_editor']))
    $profile.= "<a href=./admin/>管理员</a>&nbsp;";
?>
document.write("<?php echo ($profile);?>");
