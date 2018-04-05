<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>注册</title>
    <link rel="stylesheet" type="text/css" href="css/register.css" /> </head>

<body>
    <div id="C1">
        <?php require_once("header.php"); ?>
            <div id="main">
                <form action="register.php" method="post">
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
                                <td> 确认密码: </td>
                                <td>
                                    <input name="Password2" type="password" size=20> </td>
                            </tr>
                            <tr>
                                <td> 密保问题: </td>
                                <td>
                                    <select>
                                        <option value="Mother">您母亲的姓名是？</option>
                                        <option value="Father">您父亲的姓名是？</option>
                                        <option value="Game">您最爱的游戏是？</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td> 密保答案: </td>
                                <td>
                                    <input name="Answer" type="text" size=20> </td>
                            </tr>
                            <tr>
                                <td>
                                    <input name="Submit"  type="submit" value="Submit">
                                </td>
                                <td>
                                    <a href="loginpage.php">返回登录</a>
                                </td>
                            </tr>
                        </table>
                    </center>
                </form>
            </div>
    </div>
</body>

</html>