<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>注册</title>
    <link rel="stylesheet" type="text/css" href="css/registerpage.css" /> </head>

<body>
    <?php
    session_start();
$user_id=$password=$password2=$question=$answer=$vcode="";
$user_id_error=$password_error=$password2_error=$answer_error=$vcode_error="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$user_id=trim($_POST['user_id']);
$password=trim($_POST['password']);
$password2=trim($_POST['password2']);
$question=trim($_POST['question']);
$answer=trim($_POST['answer']);
$vcode=trim($_POST['vcode']);
$flag=1;
if(empty($user_id))
{
    $user_id_error="用户名不能为空";
    $flag=0;
}
if(empty($password))
{
    $password_error="密码不能为空";
    $password2_error="两次密码不一致";
    $flag=0;
}
if(strcmp($password,$password2))
{
    $password2_error="两次密码不一致";
    $flag=0;
}
if(empty($answer))
{
    $answer_error="密保答案不能为空";
    $flag=0;
}
if(strcasecmp($_SESSION["vcode"],$vcode) || $vcode=="" || $vcode==null)
{
//    $vcode_error=$_SESSION["vcode"];
    $_SESSION["vcode"]=null;
    $vcode_error="验证码错误";
    $flag=0;
}
}


//

?>
        <div id="C1">
            <?php require_once("header.php"); ?>
                <div id="main">
                    <form action="<?php echo htmlspecialchars($_SERVER[" PHP_SELF "]);?>" method="post">
                        <center>
                            <table id="input_table">
                                <tr>
                                    <td width=220></td>
                                    <td width=220> 用户名: </td>
                                    <td width=220>
                                        <input name="user_id" type="text" size=20 value="<?php echo $user_id ?>"> </td>
                                    <td width=220> <span class="error">
                                        * <?php echo $user_id_error;?></span></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td> 密码: </td>
                                    <td>
                                        <input name="password" type="password" size=20> </td>
                                    <td><span class="error">* <?php echo $password_error;?></span></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td> 确认密码: </td>
                                    <td>
                                        <input name="password2" type="password" size=20> </td>
                                    <td><span class="error">* <?php echo $password2_error;?></span></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td> 密保问题: </td>
                                    <td>
                                        <select name="question">
                                            <option value="Mother" <?php if(!strcmp($question,"Mother")){ ?>selected="selected"<?php } ?> >您母亲的姓名是？</option>
                                            <option value="Father" <?php if(!strcmp($question,"Father")){ ?>selected="selected"<?php } ?> >您父亲的姓名是？</option>
                                            <option value="Game" <?php if(!strcmp($question,"Game")){ ?>selected="selected"<?php } ?> >您最爱的游戏是？</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td> 密保答案: </td>
                                    <td>
                                        <input name="answer" type="text" size=20 value="<?php echo $answer ?>"> </td>
                                    <td><span class="error">* <?php echo $answer_error;?></span></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td> 验证码: </td>
                                    <td>
                                        <input name="vcode" size="5" type="text">&nbsp;<img alt="点击刷新" src="vcode.php" onclick="this.src='vcode.php?'+Math.random()"> </td>
                                    <td><span class="error">* <?php echo $vcode_error;?></span></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <input id="submit" class="S" name="submit" type="submit" value="注册"> </td>
                                    <td> <a href="loginpage.php">返回登录</a> </td>
                                </tr>
                            </table>
                        </center>
                    </form>
                </div>
        </div>
</body>

</html>