<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>登陆</title>
    <link rel="stylesheet" type="text/css" href="css/loginpage.css" />
    <style>

        ::-webkit-scrollbar {display:none}

    </style>
    <?php if(!isset($_SESSION)){
        session_start();
    }
    if (isset($_SESSION['user_id'])){
        ?>
        <script>
            alert("您已经登陆，请注销后重试！");
            history.go(-1);
        </script>
    <?php
    }
    ?>
    <script>
        flag1 = false;
        flag2 = false;
        // document.getElementById("vcode_error").innerHTML="Error:验证码错误";
        function usernameCheck(o){
            flag1=false;
            if (!/^[a-zA-Z]{1,1}[a-zA-Z0-9]{5,14}$/.test(o.value)){
                document.getElementById("username_error").innerHTML="Error:应由6-15位数字或大小写字母构成,开头须是字母";
                $("#username_error").prop("class","alert alert-danger");
                flag1=false;
            }
            else{
                $("#username_error").prop("class","alert alert-danger hide");
                flag1=true;
            }
        }
        function passwordCheck(o) {
            flag2=false;
            if (o.value.length<6){
                document.getElementById("password_error").innerHTML="Error:长度应不短于6位";
                $("#password_error").prop("class","alert alert-danger");
                flag2=false;
            }
            else{
                $("#password_error").prop("class","alert alert-danger hide");
                flag2=true;
            }
        }
    </script>
</head>

<body>
<?php
if(!isset($_SESSION)){
    session_start();
}
$username = $password = $vcode = "";
$vcode_error = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vcode_error = false;
    $_SESSION['vcode_error']=false;
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $vcode = trim($_POST['vcode']);
    $flag = 1;
    if (empty($username)) {
//        $username_error = "用户名不能为空";
        $flag = 0;
    }
    if (empty($password)) {
//        $password_error = "密码不能为空";
        $flag = 0;
    }
    if (strcasecmp($_SESSION["vcode"], $vcode) || $vcode == "" || $vcode == null) {
//    $vcode_error=$_SESSION["vcode"];
        $_SESSION["vcode"] = null;
        $_SESSION['vcode_error']=true;
        $vcode_error = true;
        $flag = 0;
    }
    else{
        $_SESSION['vcode_error']=false;
    }
    if ($flag==1)
    {
        require_once("login.php");
        check_login($username,$password);
    }
}
//

?>

<div id="C1">
    <?php require_once("header.php"); ?>
    <div id="main">
        <h1>登陆</h1>
        <form id="login_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  method="post">
            <center>
                <table id="input_table" style="width:100%;font-size:20px;border-collapse:separate;border-spacing:10px;">
                    <tr>
                        <td width=40%></td>
                        <!--                                <td width=220> 用户名:</td>-->
                        <td width=20%>
                            <!--                            <i class="fa fa-user fa-lg"></i>-->
                            <input name="username" id=username class="form-control" placeholder="帐号" type="text" size=20 onkeyup="usernameCheck(this)" value="<?php echo $username ?>">
                        </td>
                        <td width=40%>
                            <span id=username_error class="alert alert-danger hide"></span>
                            <!--                            <span class="error">-->
                            <!--                                --><?php //echo $username_error; ?>
                            <!--                            </span>-->
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <!--                                <td> 密码:</td>-->
                        <td>
                            <input name="password" id=password class="form-control" placeholder="密码" type="password" size=20 onkeyup="passwordCheck(this)">
                        </td>
                        <td>
                            <span id="password_error" class="alert alert-danger hide"></span>
                            <!--                                    <span class="error">-->
                            <!--                                       --><?php //echo $password_error; ?>
                            <!--                                   </span>-->
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <!--                                <td> 验证码:</td>-->
                        <td width=220>
                            <input name="vcode" id="vcode" class="form-control" placeholder="验证码" size="5" type="text">
                        </td>
                        <td>
                            <img id="vcodeImg" alt="点击刷新" src="vcode.php" onclick="this.src='vcode.php?'+Math.random()">
                            <span id="vcode_error" class="alert alert-danger <?php if (!isset($_SESSION['vcode_error']) || !$_SESSION['vcode_error']) echo hide;?>">
                                Error:验证码错误
                            </span>
                            <!--                            --><?php //echo $_SESSION['vcode'];?>
                            <!--                            <span class="error">-->
                            <!--                                       --><?php //echo $vcode_error; ?>
                            <!--                                   </span>-->
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td width=330>
                            <input name="Submit" class="btn btn-primary" type="button" value="登陆" onclick="doSubmit()">&nbsp;&nbsp;
                            [<a href="forgetpage.php" style="font-size: 15px;">忘记密码</a>]
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
<script>
    function doSubmit(){
        flag1=flag2=false;
        usernameCheck(document.getElementById("username"));
        passwordCheck(document.getElementById("password"));
        // console.log(flag1);
        // console.log(flag2);
        if (flag1&&flag2)
            $("#login_form").submit();
        else
            ;
    }
</script>
</body>

</html>