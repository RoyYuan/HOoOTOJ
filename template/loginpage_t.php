<html>

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
                        <table id="input_table">
                            <tr>
                                <td width=220> 用户名: </td>
                                <td width=220>
                                    <input name="UserId" type="text" size=20> </td>
                            </tr>
                            <tr>
                                <td> 密码: </td>
                                <td>
                                    <input name="Password" type="password" size=20> </td>
                            </tr>
                            <tr>
                                <td> 验证码: </td>
                                <td>
                                    <input name="Vcode" size="5" type="text" style="height: 20px">&nbsp;<img alt="点击刷新" src="vcode.php" onclick="this.src='vcode.php?'+Math.random()"> </td>
                            </tr>
                            <tr>
                                <td width=220>
                                    <input name="Submit" type="submit" value="Submit"> </td>
                                <td> <a href="forgetpassword.php">忘记密码</a> <a href="registerpage.php">注册新用户</a></td>
                            </tr>
                        </table>
                    </center>
                </form>
            </div>
    </div>
</body>

</html>