<?php
function check_login($username, $password)
{
    require_once("include/db_info.php");
    $mysqli=$GLOBALS['mysqli'];

    //去除斜杠
    if (get_magic_quotes_gpc()) {
        $username = stripslashes($username);
        $password = stripslashes($password);
    }


    //mysqli_real_escape_string();转义字符串中的特殊字符
    $username = mysqli_real_escape_string($mysqli, $username);


    session_destroy();
    session_start();

    //从数据库获取密码和用户id
    $sql = "SELECT `user_id`,`password` FROM `users` WHERE `username`='" . $username . "'";
    $result = mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_array($result);
    //验证密码
    if ($row && check_password($row['password'], $password)) {
        //密码正确
        $user_id = $row['user_id'];
        mysqli_free_result($result);

        //从数据库获取用户权限
        $sql = "SELECT `groups` FROM `groups` WHERE `user_id`='" . mysqli_real_escape_string($mysqli, $user_id) . "'";
        $result = mysqli_query($mysqli, $sql);
        $row=mysqli_fetch_array($result);
        if (mysqli_num_rows($result))
            $_SESSION['groups'.$row['groups']] = true;

        //将已经登陆的用户写入session
        $_SESSION['user_id'] = $user_id;

        //进入主页面
        echo "<script language='javascript'>alert('登陆成功!\\n');";
        echo "window.location.href='index.php';\n";
        echo "</script>";
    } else {
        mysqli_free_result($result);
        //密码错误
        echo "<script>\n";
        echo "alert('用户名或密码错误!');\n";
        echo "history.go(-1);\n";
        echo "</script>";
    }
}

//检查密码
function check_password($password, $input)
{
    if (strcmp($password, $input) == 0)
        return true;
    return false;
}

?>