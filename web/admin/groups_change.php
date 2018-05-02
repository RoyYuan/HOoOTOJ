<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Content-Language" content="zh-cn">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>权限更改</title>
    <link rel=stylesheet href='admin.css' type='text/css'>
    <script src="../js/jquery.js"></script>
    <style>

        ::-webkit-scrollbar {display:none}

    </style>
</head>

<body>
<?php require_once ("../include/db_info.php");?>
<?php require_once ("admin_header.php");
require_once ("header.php");?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name=$_POST['username'];
    $sql="SELECT `user_id` FROM `users` WHERE `username`='$user_name'";
    $result=mysqli_query($mysqli,$sql);
    $row_cnt=mysqli_num_rows($result);
    if ($row_cnt==0){
        echo "<script>\n";
        echo "alert('不存在该用户！\\n');\n";
        echo "history.go(-1);\n";
        echo "</script>";
        exit(1);
    }
    $row=mysqli_fetch_object($result);
    $user_id=$row->user_id;
    mysqli_free_result($result);
    $sql="SELECT `groups` FROM `groups` WHERE `user_id`='$user_id' AND `groups`<=0";
    $result=mysqli_query($mysqli,$sql);
    $row=mysqli_fetch_object($result);
    $user_group=$row->groups;
    mysqli_free_result($result);
    $my_user_id=$_SESSION['user_id'];
    $sql="SELECT `groups` FROM `groups` WHERE `user_id`='$my_user_id' AND `groups`<=0";
    $result=mysqli_query($mysqli,$sql);
    $row=mysqli_fetch_object($result);
    $my_group=$row->groups;
    mysqli_free_result($result);
    $new_groups=-$_POST['new_groups'];
    if ($my_group>=$new_groups){
        echo "<script>\n";
        echo "alert('目标权限组过高！\\n');\n";
        echo "history.go(-1);\n";
        echo "</script>";
        exit(1);
    }
    if ($my_group<$user_group){
        $sql="UPDATE `groups` SET `groups`='$new_groups' WHERE `user_id`='$user_id' AND `groups`<=0";
        $result=mysqli_query($mysqli,$sql);
        echo "<script>\n";
        echo "alert('操作成功！\\n');\n";
        echo "history.go(-1);\n";
        echo "</script>";
        exit(1);
    }
    else{
        echo "<script>\n";
        echo "alert('您的帐号不能对此用户进行操作！\\n');\n";
        echo "history.go(-1);\n";
        echo "</script>";
        exit(1);
    }
}
?>



<h1 class="center">权限更改</h1>
<div align="center">
    <form method="post" action="groups_change.php">
        <div>
            <p>
                您只能更改权限小于您的用户的权限。
            </p>
        </div>
        <div>
            <p>帐号：<input name="username" type="text" size="30">
            </p>
            <p>移动到权限组：
                <select name="new_groups">
                    <option value="0">G0</option>
                    <option value="1">G1</option>
                    <option value="2">G2</option>
                    <option value="3">G3</option>
                    <option value="4">G4</option>
                </select>
            </p>
        </div>
        <div class="center">
            <input type="submit" value="确认" name="submit">
        </div>
    </form>
</div>

<div class="center">
    <?php require_once ("../footer.php"); ?>
</div>
</body>
</html>