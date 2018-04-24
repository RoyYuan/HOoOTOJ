<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Content-Language" content="zh-cn">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>添加题目</title>
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

<h1 class="center">添加题目</h1>

<form style="margin-left:2cm;" method="post" action="problem_add.php">
    <input type=hidden name=problem_id value="New Problem">
    <p align="left">题目标题:&nbsp;<input class="input input-xxlarge" type="text" name="title" size="60"></p>
    <p align="left">时间限制:&nbsp;<input type="text" name="time_limit" size="20" value="1">S</p>
    <p align="left">空间限制:&nbsp;<input type="text" name="memory_limit" size="20" value="32">MByte</p>
    <p align="left">Description:<br/>
    <textarea style="width: 90%" rows="13" name="description"></textarea></p>
    <p align="left">Input:<br/>
    <textarea style="width: 90%" rows="13" name="input"></textarea></p>
    <p align="left">Output:<br/>
    <textarea style="width: 90%" rows="13" name="output"></textarea></p>
    <p align="left">Sample Input:<br/>
    <textarea class="input input-xxlarge" style="width: 90%" rows="13" name="sample_input"></textarea></p>
    <p align="left">Sample Output:<br/>
    <textarea class="input input-xxlarge" style="width: 90%" rows="13" name="sample_output"></textarea></p>
    <p align="left">Test Input:<br/>
    <textarea class="input input-xxlarge" style="width: 90%" rows="13" name="test_input"></textarea></p>
    <p align="left">Test Output:<br/>
    <textarea class="input input-xxlarge" style="width: 90%" rows="13" name="test_output"></textarea> </p>
    <p align="left">Hint:<br/>
    <textarea style="width: 90%" rows="13" name="hint"></textarea></p>
    <div align="center">
        <input class="btn" style="width: 60px;height: 40px;" type="submit" value="提交" name="submit">
    </div>
</form>
<div class="center">
    <?php require_once ("../footer.php"); ?>
</div>
</body>
</html>