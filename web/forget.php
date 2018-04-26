<?php
/**
 * Created by PhpStorm.
 * User: RoyYuan
 * Date: 2018/4/10
 * Time: 11:27
 */
function forget($username, $question, $answer){
    require_once ("include/db_info.php");
    require_once ("include/functions.php");

//mysqli_real_escape_string();转义字符串中的特殊字符
    $username=mysqli_real_escape_string($mysqli,$username);

    if(get_magic_quotes_gpc()){
        $username=stripcslashes($username);
        $question=stripcslashes($question);
        $answer=stripcslashes($answer);
    }
//验证密保问题
    $sql="SELECT `question`,`answer` FROM `users` WHERE `username`='"
        .$username
        ."'";
    $result=mysqli_query($mysqli,$sql);
    $row=mysqli_fetch_array($result);
    if($row && $row['question'] == $question && $row['answer'] == $answer){
        //密保正确
        $_SESSION['forget_username']=$username;
        mysqli_free_result($result);
        echo "<script>\n";
        echo "window.location.href='forgetpage2.php'";
        echo "</script>";
    }
    else{
        mysqli_free_result($result);
        echo "<script>\n";
        echo "alert('密保信息有误\\n');\n";
        echo "history.go(-1);\n";
        echo "</script>";
    }
}
function forget2($password){
    require_once ("include/db_info.php");

    if(get_magic_quotes_gpc()){
        $password=stripcslashes($password);
    }

    $sql="UPDATE `users` SET password='"
        .$password
        . "'WHERE `username`='"
        .mysqli_real_escape_string($mysqli,$_SESSION['forget_username'])
        ."'";
    $result=mysqli_query($mysqli,$sql);
    if(mysqli_affected_rows($mysqli)==0){
        echo "<script>\n";
        echo "alert('设置密码失败\\n');\n";
        echo "window.location.href='loginpage.php';\n</script>";
        exit(0);
    }
    echo "<script>\n";
    echo "alert('设置密码成功\\n');\n";
    echo "window.location.href='loginpage.php';\n";
    echo "</script>";
}
function password_change($password){
    require_once ("include/db_info.php");
    $mysqli=$GLOBALS['mysqli'];
    if (get_magic_quotes_gpc())
        $password=stripcslashes($password);
    echo $password;
    $sql="UPDATE `users` SET `password`='"
        .$password
        ."' WHERE `user_id`='"
        .mysqli_real_escape_string($mysqli,$_SESSION['user_id'])
        ."'";
    $result=mysqli_query($mysqli,$sql);
    if(mysqli_affected_rows($mysqli)==0){
        echo "<script>\n";
        echo "alert('设置密码失败\\n');\n";
        echo "window.location.href='index.php';\n";
        echo "</script>";
        exit(0);
    }
    echo "<script>\n";
    echo "alert('设置密码成功\\n');\n";
    echo "window.location.href='index.php';\n";
    echo "</script>";
}
?>