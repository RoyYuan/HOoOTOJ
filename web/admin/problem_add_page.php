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
</head>

<body style="margin-left:2cm;">
<?php require_once ("../include/db_info.php");?>
<?php require_once ("admin_header.php");?>
<h1>添加题目</h1>

<form method="post" action="problem_add.php">
    <input type="hidden" name="problem_id" value="新题目">
    <p align="left">题目标题:<input class="input input-xxlarge" type="text" name="title" size="60"></p>
    <p align="left">时间限制:<input type="text" name="time_limit" size="20" value="1">S</p>
    <p align="left">空间限制:<input type="text" name="memory_limit" size="20" value="32">MByte</p>
    <p align="left">Description:<br/>
    <textarea rows="13" name="description" cols="180"></textarea></p>
    <p align="left">Input:<br/>
    <textarea rows="13" name="input" cols="180"></textarea></p>
    <p align="left">Output:<br/>
    <textarea rows="13" name="output" cols="180"></textarea></p>
    <p align="left">Sample Input:<br/>
    <textarea class="input input-xxlarge" rows="13" name="sample_input" cols="180"></textarea></p>
    <p align="left">Sample Output:<br/>
    <textarea class="input input-xxlarge" rows="13" name="sample_output" cols="180"></textarea></p>
    <p align="left">Test Input:<br/>
    <textarea class="input input-xxlarge" rows="13" name="test_input" cols="180"></textarea></p>
    <p align="left">Test Output:<br/>
    <textarea class="input input-xxlarge" rows="13" name="test_output" cols="180"></textarea> </p>
    <p align="left">Hint:<br/>
    <textarea rows="13" name="hint" cols="180"></textarea></p>
    <div align="center">
        <input class="btn" style="width: 60px;height: 40px;" type="submit" value="提交" name="submit">
        <?php require_once ("../footer.php"); ?>
    </div>
</form>
</body>
</html>