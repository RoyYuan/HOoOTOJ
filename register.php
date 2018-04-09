<?php
/**
 * @param $username
 * @param $password
 * @param $question
 * @param $answer
 */
function register($username, $password, $question, $answer){
    require_once("include/db_info.php");
    require_once("include/functions.php");
    //$mysqli=$GLOBALS['mysqli'];
    
    //验证用户名是否被使用过
    $sql="SELECT `username` FROM `users` WHERE `users`.`username`='".$username."'";
    $result=mysqli_query($mysqli,$sql);
    $row_cnt=mysqli_num_rows($result);
    mysqli_free_result($result);
    if($row_cnt>0){
        echo "<script>\n";
        echo "alert('用户名已存在\\n');\n";
        echo "history.go(-1);\n</script>";
        exit(0);
    }
    
    //处理数据
    $answer=mysqli_real_escape_string($mysqli,$answer);
    //将用户数据加入数据库
    $sql="INSERT INTO `users`("
        ."`username`,`password`,`question`,`answer`,`login`,`submit`,`solved`)"
        ."VALUES('".$username."','".$password."','".$question."','".$answer."',1,0,0)";
    mysqli_query($mysqli,$sql);
    if(mysqli_affected_rows($mysqli)==0){
        echo "<script>\n";
        echo "alert('111\\n');\n";
        echo "history.go(-1);\n</script>";
        exit(0);
    }
    
    //将当前用户加入session
    $sql="SELECT `user_id` FROM `users` WHERE `users`.`username`='".$username."'";
    $result=mysqli_query($mysqli,$sql);
    $row=mysqli_fetch_array($result);
    $user_id=$row['user_id'];
    $_SESSION['user_id']=$user_id;
    mysqli_free_result($result);
    
    //将当前用户加入groups表，默认权限组为0
    $sql="INSERT INTO `groups`("."`user_id`,`groups`)"."VALUES('".$user_id."',0)";
    $_SESSION['0']=true;
    $_SESSION['ac']=Array();
    $_SESSION['sub']=Array();
    
    
    //跳转到主界面
    echo "<script>\n";
    echo "window.location.href='index.php';\n";
    echo "</script>";
}
