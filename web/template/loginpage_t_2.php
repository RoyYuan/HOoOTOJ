<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>登陆</title>
    <link rel="stylesheet" type="text/css" href="css/loginpage.css" />
    <script src="js/jquery.js"></script>
</head>

<body>
<?php
session_start();
$vcode = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vcode = trim($_POST['vcode']);
    $flag = 1;
    if (strcasecmp($_SESSION["vcode"], $vcode) || $vcode == "" || $vcode == null) {
        $_SESSION["vcode"] = null;
        echo '<script> alert("验证码错误"); </script>';
        $flag = 0;
    }
}
?>
    <div id="C1">
        <?php require_once("header.php"); ?>
        <div id="main">
            <form method="post">
                <center>
                        <table id="input_table" style="font-size:20px">
                            <tr>
                                <td width=220></td>
                                <td width=220> 用户名:</td>
                                <td width=220>
                                    <input name="username" id="username" type="text" size=20 onchange="check_username()"></td>
                                <td width=220>
                                    <span class="error">
                                        <p id="username_error"></p>
                                   </span>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td> 密码:</td>
                                <td>
                                    <input name="password" id="password" type="password" size=20 onchange="check_password()"></td>
                                <td>
                                    <span class="error">
                                       <p id="password_error"></p>
                                   </span>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td> 验证码:</td>
                                <td>
                                    <input name="vcode" size="5" type="text">&nbsp;<img alt="点击刷新" src="vcode.php" onclick="this.src='vcode.php?'+Math.random()">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td width=220>
                                    <input name="submit" class="S" type="submit" value="登陆"></td>
                                <td><a href="forgetpage.php">忘记密码</a> <a href="registerpage.php">注册新用户</a></td>
                                <td></td>
                            </tr>
                        </table>
                    </center>
                </form>
            </div>
        </div>
<div class="center">
    <?php require_once ("footer.php"); ?>
</div>
</body>

</html>