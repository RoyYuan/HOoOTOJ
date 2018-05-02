<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>忘记密码</title>
    <link rel="stylesheet" type="text/css" href="css/forgetpage.css" />
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
        function answerCheck(o) {
            flag2=false;
            if (o.value.length>0){
                $("#answer_error").prop("class","alert alert-danger hide");
                flag2=true;
            }
            else{
                document.getElementById("answer_error").innerHTML="Error:不能为空！";
                $("#answer_error").prop("class","alert alert-danger");
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
    $user_id=$question=$answer=$vcode="";
    $user_id_error=$answer_error=$vcode_error="";
    //$vcode_error=$_SESSION["vcode"];
if($_SERVER["REQUEST_METHOD"]=="POST")
{
    $_SESSION['vcode_error']=false;
    $user_id = trim($_POST['user_id']);
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
        if (empty($user_id)) {
//        $user_id_error = "用户名不能为空";
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
    if($flag==1)
    {
        require_once ("forget.php");
        forget($user_id,$question,$answer);
    }
}
    ?>
        <div id="C1">
            <?php require_once("header.php"); ?>
            <h1>忘记密码</h1>
            <div id="main">
                <form id="fg_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <center>
                        <table id="input_table" style="width:100%;font-size:20px;border-collapse:separate;   border-spacing:10px;">
                            <tr>
                                <td width=40%></td>
<!--                                <td width=220> 用户名:</td>-->
                                <td width=20%>
<!--                                    <i class="fa fa-user fa-lg"></i>-->
                                    <input id=username name="user_id" class="form-control" placeholder="帐号" type="text" onkeyup="usernameCheck(this)" size=20 value="<?php echo $user_id ?>"></td>
                                <td width=40%>
                                    <span class="error">
                                        *
<!--                                        --><?php //echo $user_id_error; ?>
                                        <span id="username_error"></span>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
<!--                                <td> 密保问题:</td>-->
                                <td>
                                    <select class="form-control" name="question">
                                <option value="Mother"
                                        <?php if (!strcmp($question, "Mother")){ ?>selected="selected"<?php } ?> >您母亲的姓名是？</option>
                                <option value="Father"
                                        <?php if (!strcmp($question, "Father")){ ?>selected="selected"<?php } ?> >您父亲的姓名是？</option>
                                <option value="Game"
                                        <?php if (!strcmp($question, "Game")){ ?>selected="selected"<?php } ?> >您最爱的游戏是？</option>
                            </select>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
<!--                                <td> 密保答案:</td>-->
                                <td>
                                    <input id=answer class="form-control" placeholder="密保答案" name="answer" type="text" onkeyup="answerCheck(this)" size=20 value="<?php echo $answer ?>"></td>
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
                                    <input class="form-control" placeholder="验证码" name="vcode" size="5" type="text">
                                </td>
                                <td>
                                    <img alt="点击刷新" src="vcode.php" onclick="this.src='vcode.php?'+Math.random()">
                                    <span class="error">
                                        *
                                        <span id="vcode_error" class="alert alert-danger <?php if (!isset($_SESSION['vcode_error']) || !$_SESSION['vcode_error']) echo hide;?>">
                                        Error:验证码错误
                                    </span>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <input id="Submit" class="btn btn-primary" name="Submit" type="button" value="确认" onclick="doSubmit()">
                                    [<a href="loginpage.php" style="font-size: 15px;">返回登录</a>]
                                </td>
                                <td></td>
<!--                                <td></td>-->
                            </tr>
                        </table>
                    </center>
                </form>
            </div>
        </div>
</body>
<div class="center">
    <?php require_once ("footer.php"); ?>
</div>
<script>
    function doSubmit(){
        flag1=flag2=false;
        usernameCheck(document.getElementById("username"));
        answerCheck(document.getElementById("answer"));
        if (flag1 & flag2)
            $("#fg_form").submit();
        else
            ;
    }
</script>
</html>