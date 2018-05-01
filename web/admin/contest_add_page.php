<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Content-Language" content="zh-cn">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>添加竞赛</title>
    <link rel=stylesheet href='admin.css' type='text/css'>
<!--    <script src="../js/jquery.js"></script>-->
    <style>

        ::-webkit-scrollbar {display:none}

    </style>
</head>

<body style="">
<?php require_once ("../include/db_info.php");?>
<?php
require_once ("admin_header.php");
require_once ("header.php");
$now=strftime("%Y-%m-%dT%H:%M",time());
?>
<h1 class="center">添加竞赛</h1>
<script language="javascript" type="text/javascript">
    //禁用Enter键表单自动提交
    document.onkeydown = function(event) {
        var target, code, tag;
        if (!event) {
            event = window.event; //针对ie浏览器
            target = event.srcElement;
            code = event.keyCode;
            if (code == 13) {
                tag = target.tagName;
                if (tag == "TEXTAREA") { return true; }
                else { return false; }
            }
        }
        else {
            target = event.target; //针对遵循w3c标准的浏览器，如Firefox
            code = event.keyCode;
            if (code == 13) {
                tag = target.tagName;
                if (tag == "INPUT") { return false; }
                else { return true; }
            }
        }
    };
</script>
<!--<div style="width: 50%">-->
<!--    <div class="panel panel-default" style="width: 200px;"></div>-->
<!--</div>-->
<form style="margin-left:2cm;" method="post" action="contest_add.php">
    <div style="width: 90%">
        <div style="width: 50%">
            <input name="title" class="form-control" style="height:35px;font-size: 25px;" placeholder="竞赛标题" type="text">
            <br/>
        </div>
        <div style="width: 15%;float: left;height: 100px">
            <div class="panel panel-default" style="width: 230px">
                <div class="panel-heading font-bold" style="color: white">
                <span>
                    开始时间
                    <small>
                        Start Time
                    </small>
                </span>
                </div>
                <div class="panel-body">
                    <p>
                        <input  class="form-control" name="start_time" type="datetime-local" min='<?php echo $now;?>' ></p>
                    </p>
                </div>
            </div>
        </div>
        <div style="width: 15%;float: left;height: 100px">
            <div class="panel panel-default" style="width: 230px">
                <div class="panel-heading font-bold" style="color: white">
                <span>
                    结束时间
                    <small>
                        End Time
                    </small>
                </span>
                </div>
                <div class="panel-body">
                    <p>
                        <input  class="form-control" name="end_time" type="datetime-local" min='<?php echo $now;?>' ></p>
                    </p>
                </div>
            </div>
        </div>
        <div style="width: 70%;height: 100px">
        </div>
        <br/>
        <br/>
        <div class="btn-group" data-toggle="buttons">
            <label id=btn1 class="btn btn-primary active">
                <input id=select1 type="radio" name="private" value="0">公开
            </label>
            <label id=btn2 class="btn btn-primary">
                <input id=select2 type="radio" name="private" value="1">私人
            </label>
        </div>
        <br/>
        <br/>
        <p align="left" style="width: 20%"><input  placeholder="若是私人请设置密码" class="form-control" type="text" name="password" value=""></p>
        <br/>
        <div class="panel panel-default">
            <div class="panel-heading font-bold" style="color:white">
                <span>
                    竞赛描述
                    <small>
                        Contest Description
                    </small>
                </span>
            </div>
            <div class="panel-body">
                <p>
                    <textarea  class="form-control" rows="13" name="description" style="width: 100%" ></textarea>
                </p>
            </div>
        </div>
        <div class="panel panel-default" style="width: 30%">
            <div class="panel-heading font-bold" style="color:white">
                <span>
                    竞赛题目
                    <small>
                        Contest Problems
                    </small>
                </span>
            </div>
            <div class="panel-body">
                <p>
                    <input class="form-control input-xxlarge" placeholder="请输入ProblemID,用英文逗号隔开" type="text" size="60" name="contest_problems">
                </p>
            </div>
        </div>
    </div>

<!--    <p align="left">竞赛标题:&nbsp;<input name="title" class="input input-xxlarge" type="text" name="title" size="60"></p>-->
<!--    <p align="left">开始时间:&nbsp;<input name="start_time" type="datetime-local" min='--><?php //echo $now;?><!--' ></p>-->
<!--    <p align="left">结束时间:&nbsp;<input name="end_time" type="datetime-local" min='--><?php //echo $now;?><!--' ></p>-->
<!--    <p align="left">是否公开:&nbsp;<select name="private"><option value="0">Public</option><option value="1">Private</option></select></p>-->
<!---->
<!--    <p align="left">Description:<br/>-->
<!--        <textarea rows="13" name="description" style="width: 90%" ></textarea></p>-->
<!--    <p align="left">Problems:&nbsp;<input class="input-xxlarge" type="text" size="60" name="contest_problems"> </p>-->

    <div align="center">
        <input class="btn" style="width: 60px;height: 40px;" type="reset" value="重置" name="reset">
        <input class="btn" style="width: 60px;height: 40px;" type="submit" value="提交" name="submit">
        <?php require_once ("../footer.php"); ?>
    </div>
</form>
<script>
    $("#select1").attr("checked",true);
</script>
</body>
</html>