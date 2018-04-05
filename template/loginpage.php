<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>登陆</title>
</head>

<body>
    <div id="C1">
        <?php if(file_exists("header.php"))
            require_once("header.php"); ?>
        <div id="main">
            <form action="login.php" method="post">
                <center>
                    <table width=440 style="text-align:auto">
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
                                <input name="Vcode" size="5" type="text" style="height: 20px"> <img alt="点击刷新" src="vcode.php" onclick="this.src='vcode.php?'+Math.random()"> </td>
                        </tr>
                        <tr>
                            <td width=220>
                                <input name="Submit" type="submit" size="10" value="Submit"> </td>
                            <td> <a href="ForgetPassword.php">忘记密码</a> </td>
                        </tr>
                    </table>
                </center>
            </form>
        </div>
    </div>
</body>

</html>