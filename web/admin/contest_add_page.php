<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Content-Language" content="zh-cn">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>添加竞赛</title>
    <link rel=stylesheet href='admin.css' type='text/css'>
    <script src="../js/jquery.js"></script>
</head>

<body style="margin-left:2cm;">
<?php require_once ("../include/db_info.php");?>
<?php
require_once ("admin_header.php");
$now=strftime("%Y-%m-%dT%H:%M",time());
?>
<h1 class="center">添加竞赛</h1>

<form method="post" action="contest_add.php">
    <p align="left">竞赛标题:&nbsp;<input name="title" class="input input-xxlarge" type="text" name="title" size="60"></p>
    <p align="left">开始时间:&nbsp;<input name="start_time" type="datetime-local" min='<?php echo $now;?>' ></p>
    <p align="left">结束时间:&nbsp;<input name="end_time" type="datetime-local" min='<?php echo $now;?>' ></p>
    <p align="left">是否公开:&nbsp;<select name="private"><option value="0">Public</option><option value="1">Private</option></select></p>
    <p align="left">若是private请设置密码:&nbsp;<input type="text" name="password" value=""></p>
    <p align="left">Description:<br/>
        <textarea rows="13" name="description" style="width: 90%" ></textarea></p>
    <p align="left">Problems:&nbsp;<input class="input-xxlarge" type="text" size="60" name="contest_problems"> </p>

    <div align="center">
        <input class="btn" style="width: 60px;height: 40px;" type="reset" value="重置" name="reset">
        <input class="btn" style="width: 60px;height: 40px;" type="submit" value="提交" name="submit">
        <?php require_once ("../footer.php"); ?>
    </div>
</form>
</body>
</html>