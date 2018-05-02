<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>注册</title>
    <link rel="stylesheet" type="text/css" href="css/registerpage.css" />
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
        flag1=false;
        flag2=false;
        function usernameCheck(o) {
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
            flag3=false;
            pd2=document.getElementById("password2").value;
            if (pd2==o.value) {
                $("#password2_error").prop("class","alert alert-danger hide");
                flag3=true;
            }
            else{
                document.getElementById("password2_error").innerHTML="Error:两次密码不一致！";
                $("#password2_error").prop("class","alert alert-danger");
                flag3=false;
            }
        }
        function password2Check(o) {
            flag3=false;
            pd1=document.getElementById("password").value;
            if (pd1==o.value) {
                $("#password2_error").prop("class","alert alert-danger hide");
                flag3=true;
            }
            else{
                document.getElementById("password2_error").innerHTML="Error:两次密码不一致！";
                $("#password2_error").prop("class","alert alert-danger");
                flag3=false;
            }
        }
        function answerCheck(o) {
            flag4=false;
            if (o.value.length>0){
                $("#answer_error").prop("class","alert alert-danger hide");
                flag4=true;
            }
            else{
                document.getElementById("answer_error").innerHTML="Error:不能为空！";
                $("#answer_error").prop("class","alert alert-danger");
                flag4=false;
            }
        }
    </script>
</head>

<body>
<?php
@session_start();
$username = $password = $password2 = $question = $answer = $vcode = "";
$vcode_error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['vcode_error']=false;
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $password2 = trim($_POST['password2']);
    $question = trim($_POST['question']);
    switch($question){
        case "Mother":$question=1; break;
        case "Father":$question=2; break;
        case "Game":$question=3; break;
        default:;
    }
    $answer = trim($_POST['answer']);
    $vcode = trim($_POST['vcode']);
    $flag = 1;
    if (empty($username)) {
//        $username_error = "用户名不能为空";
        $flag = 0;
    }
    if (empty($password)) {
//        $password_error = "密码不能为空";
//        $password2_error = "两次密码不一致";
        $password=$password2="";
        $flag = 0;
    }
    if (strcmp($password, $password2)) {
//        $password2_error = "两次密码不一致";
        $password=$password2="";
        $flag = 0;
    }
    if (empty($answer)) {
//        $answer_error = "密保答案不能为空";
        $flag = 0;
    }
    if (strcasecmp($_SESSION["vcode"], $vcode) || $vcode == "" || $vcode == null) {
//    $vcode_error=$_SESSION["vcode"];
        $_SESSION["vcode"] = null;
        $_SESSION['vcode_error']=true;
//        $vcode_error = "验证码错误";
        $flag = 0;
    }
    else{
        $_SESSION['vcode_error']=false;
    }
    if($flag==1)
    {
        require_once("register.php");
        register($username,$password,$question,$answer);
    }
}


//

?>
        <div id="C1">
            <?php require_once("header.php"); ?>
            <div id="main">
                <h1>注册</h1>
                <form id=reg_form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <center>
                        <table id="input_table" style="width:100%;border-collapse:separate;   border-spacing:10px;">
                            <tr>
                                <td width=40%></td>
<!--                                <td width=220> 用户名:</td>-->
                                <td width=20%>
                                    <input id=username name="username" class="form-control" placeholder="帐号" type="text" size=20 onkeyup="usernameCheck(this)" value="<?php echo $username ?>"></td>
                                <td width=40%>
                                    <span class="error">
                                        *
<!--                                        --><?php //echo $username_error; ?>
                                        <span id=username_error class="alert alert-danger hide"></span>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
<!--                                <td> 密码:</td>-->
                                <td>
                                    <input id=password name="password" class="form-control" placeholder="密码" type="password" size=20 onkeyup="passwordCheck(this)" value="<?php echo $password ?>"></td>
                                <td>
                                    <span class="error">
                                        *
<!--                                        --><?php //echo $password_error; ?>
                                        <span id="password_error" class="alert alert-danger hide"></span>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
<!--                                <td> 确认密码:</td>-->
                                <td>
                                    <input id=password2 name="password2" class="form-control" placeholder="确认密码" type="password" size=20 onkeyup="password2Check(this)" value="<?php echo $password2 ?>"></td>
                                <td>
                                    <span class="error">
                                        *
<!--                                        --><?php //echo $password2_error; ?>
                                        <span id="password2_error" class="alert alert-danger hide"></span>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
<!--                                <td> 密保问题:</td>-->
                                <td>
                                    <select name="question" class="form-control">
                                <option value="Mother"
                                        <?php if (!strcmp($question, "Mother")){ ?>selected="selected"<?php } ?> >
                                    您母亲的姓名是？
                                </option>
                                <option value="Father"
                                        <?php if (!strcmp($question, "Father")){ ?>selected="selected"<?php } ?> >
                                    您父亲的姓名是？
                                </option>
                                <option value="Game"
                                        <?php if (!strcmp($question, "Game")){ ?>selected="selected"<?php } ?> >您最爱的游戏是？
                                </option>
                            </select>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
<!--                                <td> 密保答案:</td>-->
                                <td>
                                    <input id=answer name="answer" class="form-control" placeholder="密保答案" type="text" size=20 onkeyup="answerCheck(this)" value="<?php echo $answer ?>"></td>
                                <td>
                                    <span class="error">
                                        *
<!--                                        --><?php //echo $answer_error; ?>
                                        <span id="answer_error"></span>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
<!--                                <td> 验证码:</td>-->
                                <td>
                                    <input name="vcode" class="form-control" placeholder="验证码" size="5" type="text">
                                </td>
                                <td>
                                    <img alt="点击刷新" src="vcode.php" onclick="this.src='vcode.php?'+Math.random()">
                                    <span id="vcode_error" class="alert alert-danger <?php if (!isset($_SESSION['vcode_error']) || !$_SESSION['vcode_error']) echo hide;?>">
                                        Error:验证码错误
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <input id="Submit" class="btn btn-primary" name="Submit" type="button" value="注册" onclick="doSubmit()">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<a href="loginpage.php">返回登录</a>]</td>
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
    function doSubmit() {
        flag1=flag2=flag3=flag4=false;
        usernameCheck(document.getElementById("username"));
        passwordCheck(document.getElementById("password"));
        password2Check(document.getElementById("password2"));
        answerCheck(document.getElementById("answer"));
        if (flag1 & flag2 & flag3 & flag4)
            $("#reg_form").submit();
        else
            ;
    }
</script>

</body>

</html>
