<?php
$user_id=trim($_POST['user_id']);
$password=trim($_POST['password']);
$password2=trim($_POST['password2']);
$question=trim($_POST['question']);
$answer=trim($_POST['answer']);
$vcode=trim($_POST['vcode']);
$user_id_error=$password_error=$password2_error=$answer_error=$vcode_error="";
if(empty($user_id))
{
    $user_id_error="用户名不能为空";
}
if(empty($password))
{
    $password_error="密码不能为空";
}
if(strcmp($password,$password2))
{
    $password2_error="两次密码不一致";
}
if(empty($answer))
{
    $answer_error="密保答案不能为空";
}
if($vcode!=$_SESSION["vcode"] || $vcode=="" || $vcode==null)
{
    $_SESSION["vcode"]=null;
    $vcode_error="验证码错误";
}

//

?>