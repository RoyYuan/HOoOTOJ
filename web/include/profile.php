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
    $user_id=$_SESSION['user_id'];
    $username=$_SESSION['username'];
    $profile.= "<i class=icon-user></i><a href='userinfo.php?user=$user_id'><span id=red>$username</span></a>";
    $profile.="&nbsp;<a href='./status.php?username=$username'><span id=red>最近提交</span></a>";
    $profile.= "&nbsp;<a href='./logout.php' target='_top' >注销</a>&nbsp;";
}
else{
    $profile.= "<a href=./loginpage.php>登陆</a>&nbsp;";
    $profile.= "<a href=./registerpage.php>注册</a>&nbsp;";
}
if (isset($_SESSION['groups']) && $_SESSION['groups']<=-2)
    $profile.= "<a href=./admin/>管理员</a>&nbsp;";
?>
document.write("<?php echo ($profile);?>");
