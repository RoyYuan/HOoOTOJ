<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>忘记密码</title>
    <link rel="stylesheet" type="text/css" href="css/forgetpage.css"/>
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
        flag1=flag2=false;
        function passwordCheck(o) {
            flag1=false;
            if (o.value.length<6){
                document.getElementById("password_error").innerHTML="Error:长度应不短于6位";
                $("#password_error").prop("class","alert alert-danger");
                flag1=false;
            }
            else{
                $("#password_error").prop("class","alert alert-danger hide");
                flag1=true;
            }
            flag2=false;
            pd2=document.getElementById("password2").value;
            if (pd2==o.value) {
                $("#password2_error").prop("class","alert alert-danger hide");
                flag2=true;
            }
            else{
                document.getElementById("password2_error").innerHTML="Error:两次密码不一致！";
                $("#password2_error").prop("class","alert alert-danger");
                flag2=false;
            }
        }
        function password2Check(o) {
            flag2=false;
            pd1=document.getElementById("password").value;
            if (pd1==o.value) {
                $("#password2_error").prop("class","alert alert-danger hide");
                flag2=true;
            }
            else{
                document.getElementById("password2_error").innerHTML="Error:两次密码不一致！";
                $("#password2_error").prop("class","alert alert-danger");
                flag2=false;
            }
        }
    </script>
</head>

<body>
<?php
if(!isset($_SESSION)){
    session_start();
}
if (isset($_SESSION['user_id'])){
    $view_errors="你已登陆！";
    require ("show_error.php");
    exit(0);
}
$password = $password2 = "";
$password_error = $password2_error = "";
//$vcode_error=$_SESSION["vcode"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    if($flag==1){
        require_once ("forget.php");
        forget2($password);
    }
}
?>
<div id="C1">
    <?php require_once("header.php"); ?>
    <div id="main">
        <form id="fg2_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <center>
                <table id="input_table" style="width: 100%;font-size:20px;border-collapse:separate;   border-spacing:10px;">
                    <tr>
                        <td width=40%></td>
<!--                        <td width=220> 新密码:</td>-->
                        <td width=20%>
                            <input class=form-control id="password" placeholder="新密码" onkeyup="passwordCheck(this)" name="password" type="password" size=20></td>
                        <td width=40%>
                            <span class="error">
                                        *
<!--                                --><?php //echo $password_error; ?>
                                <span id="password_error"></span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
<!--                        <td> 确认新密码:</td>-->
                        <td>
                            <input class=form-control id=password2 placeholder="确认新密码" onkeyup="password2Check(this)" name="password2" type="password" size=20></td>
                        <td>
                            <span class="error">
                                        *
<!--                                --><?php //echo $password2_error; ?>
                                <span id="password2_error"></span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input id="Submit" class="btn btn-primary" name="Submit" type="button" value="确认" onclick="doSubmit()">
                            [<a href="loginpage.php" style="font-size: 15px">返回登录</a>]
                        </td>
                        <td></td>
<!--                        <td></td>-->
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
    function doSubmit()
    {
        flag1=flag2=false;
        passwordCheck(document.getElementById("password"));
        password2Check(document.getElementById("password2"));
        if (flag1 & flag2)
            $("#fg2_form").submit();
        else
            ;
    }
</script>

</body>

</html>
