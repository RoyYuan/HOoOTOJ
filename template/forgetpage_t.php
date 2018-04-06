<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>忘记密码</title>
    <link rel="stylesheet" type="text/css" href="css/forgetpage.css" />
</head>

<body>
    <div id="C1">
        <?php require_once("header.php"); ?>
        <div id="main">
            <form action="forget.php" method="post">
                <center>
                    <table id="input_table">
                        <tr>
                            <td width=220> 用户名:</td>
                            <td width=220>
                                <input name="UserId" type="text" size=20></td>
                        </tr>
                        <tr>
                            <td> 密保问题:</td>
                            <td>
                                <select>
                                <option value="Mother">您母亲的姓名是？</option>
                                <option value="Father">您父亲的姓名是？</option>
                                <option value="Game">您最爱的游戏是？</option>
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td> 密保答案:</td>
                            <td>
                                <input name="Answer" type="text" size=20></td>
                        </tr>
                        <tr>
                            <td> 验证码:</td>
                            <td>
                                <input name="Vcode" size="5" type="text">&nbsp;<img alt="点击刷新" src="vcode.php" onclick="this.src='vcode.php?'+Math.random()">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input id="submit" class="S" name="Submit" type="submit" value="确认"></td>
                            <td><a href="loginpage.php">返回登录</a></td>
                        </tr>
                    </table>
                </center>
            </form>
        </div>
    </div>
</body>

</html>
