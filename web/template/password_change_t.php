<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>更改密码</title>
    <link rel="stylesheet" type="text/css" href="css/password_change.css"/>
    <style>

        ::-webkit-scrollbar {display:none}

    </style>
</head>

<body>
<?php
if(!isset($_SESSION)){
    session_start();
}
require_once ("include/db_info.php");
$last_password=$password = $password2 = "";
$last_password_error=$password_error = $password2_error = "";
//$vcode_error=$_SESSION["vcode"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $last_password = trim($_POST['last_password']);
    $password = trim($_POST['password']);
    $password2 = trim($_POST['password2']);
    $flag = 1;
    if (empty($password)) {
        $password_error = "密码不能为空";
        $password2_error = "两次密码不一致";
        $flag = 0;
    }
    if (strcmp($password, $password2)) {
        $password2_error = "两次密码不一致";
        $password = $password2 = "";
        $flag = 0;
    }
    $user_id=$_SESSION['user_id'];
    $sql="SELECT `password` FROM `users` WHERE `user_id`=$user_id";
    $result=mysqli_query($mysqli,$sql);
    $row=mysqli_fetch_object($result);
    $cl_password=$row->password;
    if (strcmp($cl_password,$last_password)){
        $last_password_error="原密码不正确！";
        $last_password="";
        $flag=0;
    }
    if($flag==1){
        require_once ("forget.php");
        password_change($password);
    }
}
?>
<div id="C1">
    <?php require_once("header.php"); ?>
    <div id="main">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <center>
                <table id="input_table">
                    <tr>
                        <td width="220"></td>
                        <td width="220">旧密码:</td>
                        <td width="220">
                            <input name="last_password" type="password" size="20">
                        </td>
                        <td width="220"><span class="error">
                                *<?php echo $last_password_error; ?>
                            </span></td>
                    </tr>
                    <tr>
                        <td width=220></td>
                        <td width=220> 新密码:</td>
                        <td width=220>
                            <input name="password" type="password" size=20></td>
                        <td width=220> <span class="error">
                                        * <?php echo $password_error; ?></span></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td> 确认新密码:</td>
                        <td>
                            <input name="password2" type="password" size=20></td>
                        <td> <span class="error">
                                        * <?php echo $password2_error; ?></span></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input id="submit" class="S" name="Submit" type="submit" value="确认"></td>
                        <td><a href="loginpage.php">返回登录</a></td>
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
