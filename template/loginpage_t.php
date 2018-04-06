<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>登陆</title>
    <link rel="stylesheet" type="text/css" href="css/loginpage.css" /> </head>

<body>
    <div id="C1">
        <?php require_once("header.php"); ?>
            <div id="main">
                <form action="login.php" method="post">
                    <center>
                        <table id="input_table" style="font-size:20px">
                            <tr>
                                <td width=220> 用户名: </td>
                                <td width=220>
                                    <input name="user_id" type="text" size=20> </td>
                            </tr>
                            <tr>
                                <td> 密码: </td>
                                <td>
                                    <input name="password" type="password" size=20> </td>
                            </tr>
                            <tr>
                                <td> 验证码: </td>
                                <td>
                                    <input name="vcode" size="5" type="text">&nbsp;<img alt="点击刷新" src="vcode.php" onclick="this.src='vcode.php?'+Math.random()"> </td>
                            </tr>
                            <tr>
                                <td width=220>
                                    <input name="submit" class="S" type="submit" value="登陆"> </td>
                                <td> <a href="forgetpage.php">忘记密码</a> <a href="registerpage.php">注册新用户</a></td>
                            </tr>
                        </table>
                    </center>
                </form>
            </div>
    </div>
</body>

</html>