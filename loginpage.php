<html>

<head>
    <!--        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">-->
    <title>Login</title>
</head>

<body>
    <div id="C1">
            <div id="head" style="text-align:center">
                <h2>
                    <span class="red">
                        HOoOT Online Judge
                    </span>
                </h2> </div>
            <div id="main">
                <form action="login.php" method="post">
                    <center>
                        <table width=400 algin=center>
                            <tr>
                                <td width=200> 用户名: </td>
                                <td width=240>
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
                                    <input name="Vcode" size="4" type="text" style="height: 24px"> <img alt="click to change" src="vcode.php" onclick="this.src='vcode.php?'+Math.random()"> </td>
                            </tr>
                            <tr>
                                <td width=200>
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