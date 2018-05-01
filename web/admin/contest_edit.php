<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Content-Language" content="zh-cn">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>编辑竞赛</title>
    <link rel=stylesheet href='admin.css' type='text/css'>
    <script src="../js/jquery.js"></script>
    <style>

        ::-webkit-scrollbar {display:none}

    </style>
</head>

<body style="">
<?php require_once("../include/db_info.php"); ?>
<?php
require_once("admin_header.php");
require_once("header.php");?>
<?php
/**
 * Created by PhpStorm.
 * User: RoyYuan
 * Date: 2018/4/25
 * Time: 10:59
 */
require_once ("admin_header.php");
$cid=intval($_GET['cid']);
$sql="SELECT `owner_id` FROM `contest` WHERE `contest_id`=$cid";
$result=mysqli_query($mysqli,$sql);
$row=mysqli_fetch_row($result);
$owner_id=$row[0];
if ($_SESSION['groups']>-4 && $_SESSION['user_id']!=$owner_id){
    mysqli_free_result($result);
    echo "<script>\n";
    echo "alert('您的帐号不能对此竞赛进行编辑！\\n');\n";
    echo "history.go(-1);\n";
    echo "</script>";
    exit(1);
}
mysqli_free_result($result);
if (isset($_POST['private'])){
    $cid=intval($_POST['cid']);
    $start_time=$_POST['start_time'];
    $end_time=$_POST['end_time'];
    $contest_title=$_POST['title'];
    $private=$_POST['private'];
    $password=$_POST['password'];
    $description=$_POST['description'];
    if (get_magic_quotes_gpc()){
        $contest_title=stripcslashes($contest_title);
        $private=stripcslashes($private);
        $password=stripcslashes($password);
        $description=stripcslashes($description);
    }
    $contest_title=mysqli_real_escape_string($mysqli,$contest_title);
    $private=mysqli_real_escape_string($mysqli,$private);
    $password=mysqli_real_escape_string($mysqli,$password);
    $description=mysqli_real_escape_string($mysqli,$description);

    $sql="UPDATE `contest` SET `contest_title`='$contest_title',`description`='$description',`start_time`='$start_time',`end_time`='$end_time',`private`='$private',`contest_key`='$password' WHERE `contest_id`=$cid";
    mysqli_query($mysqli,$sql);
    $sql="DELETE FROM `contest_problem` WHERE `contest_id`=$cid";
    mysqli_query($mysqli,$sql);
    $problem_list=trim($_POST['contest_problems']);
    $pieces=explode(',',$problem_list);
    if (count($pieces)>0 && strlen($pieces[0])>0){
        $sql_1="INSERT INTO `contest_problem`(`contest_id`,`problem_id`,`num`) VALUE ('$cid','$pieces[0]',1)";
        for ($i=1;$i<count($pieces);$i++)
            $sql_1.=",('$cid','$pieces[$i]',".intval($i+1).")";
        $sql="UPDATE `submissions` SET `contest_num`=-1 WHERE `contest_id`=$cid";
        mysqli_query($mysqli,$sql);
        for ($i=1;$i<=count($pieces);$i++){
            $sql_2="UPDATE `submissions` SET `contest_num`='$i' WHERE `contest_id`='$cid' AND `problem_id`='".$pieces[intval($i-1)]."';";
            mysqli_query($mysqli,$sql_2);
        }
        mysqli_query($mysqli,$sql_1) or die(mysqli_error());
        $sql="UPDATE `problems` SET `hide`=0 WHERE `problem_id` IN ($problem_list)";
        mysqli_query($mysqli,$sql) or die(mysqli_error());
    }
    echo "<script>window.location.href=\"contest_list.php\";</script>";
    exit();
}
else {
    $cid=intval($_GET['cid']);
    $sql = "SELECT * FROM `contest` WHERE `contest_id`=$cid";
    $result = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($result)!=1){
        mysqli_free_result($result);
        echo "没有该竞赛！";
        exit(0);
    }
    $row = mysqli_fetch_object($result);
    $title=htmlentities($row->contest_title,ENT_QUOTES,"UTF-8");
    $start_time=new datetime($row->start_time);
    $start_time=$start_time->format("Y-m-d\TH:i");
    $end_time=new datetime($row->end_time);
    $end_time=$end_time->format("Y-m-d\TH:i");
    $description=$row->description;
    $hide=$row->hide;
    $private=$row->private;
    $password=$row->contest_key;
    mysqli_free_result($result);
    $problem_list="";
    $sql="SELECT `problem_id` FROM `contest_problem` WHERE `contest_id`=$cid ORDER BY `num`";
    $result=mysqli_query($mysqli,$sql) or die(mysqli_error());
    for ($i=mysqli_num_rows($result);$i>0;$i--){
        $row=mysqli_fetch_row($result);
        $problem_list=$problem_list.$row[0];
        if ($i>1)
            $problem_list.=',';
    }

    ?>
    <h1 class="center">编辑竞赛</h1>

    <form style="margin-left:2cm;" method="post" action="contest_edit.php?cid=."$cid>
        <input type="hidden" name="cid" value="<?php echo $cid ?>">
        <div style="width: 90%;">
            <div style="width: 50%;">
                <input name="title" class="form-control" style="height:35px;font-size: 25px;" placeholder="竞赛标题" type="text" value="<?php echo $title ?>">
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
                            <input  class="form-control" name="start_time" type="datetime-local" min='<?php echo $now;?>' value="<?php echo $start_time?>"></p>
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
                            <input  class="form-control" name="end_time" type="datetime-local" min='<?php echo $now;?>' value="<?php echo $end_time?>"></p>
                        </p>
                    </div>
                </div>
            </div>
            <div style="width: 70%;height: 100px">
            </div>
            <br/>
            <br/>
            <div class="btn-group" data-toggle="buttons">
                <label id=btn1 class="btn btn-primary <?php if($private==0) echo 'active'?>">
                    <input id=select1 type="radio" name="private" value="0">公开
                </label>
                <label id=btn2 class="btn btn-primary <?php if($private==1) echo 'active'?>">
                    <input id=select2 type="radio" name="private" value="1">私人
                </label>
            </div>
            <br/>
            <br/>
            <p align="left" style="width: 20%"><input  placeholder="若是私人请设置密码" class="form-control" type="text" name="password" value="<?php echo $password?>"></p>
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
                        <textarea  class="form-control" rows="13" name="description" style="width: 100%" ><?php echo $description?></textarea>
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
                        <input class="form-control input-xxlarge" value="<?php echo $problem_list?>" placeholder="请输入ProblemID,用英文逗号隔开" type="text" size="60" name="contest_problems">
                    </p>
                </div>
            </div>
        </div>

<!--        <p align="left">竞赛标题:&nbsp;<input name="title" class="input input-xxlarge" type="text" name="title" size="60" value="--><?php //echo $title ?><!--"></p>-->
<!--        <p align="left">开始时间:&nbsp;<input name="start_time" type="datetime-local" min='--><?php //echo $now; ?><!--' value="--><?php //echo $start_time?><!--"></p>-->
<!--        <p align="left">结束时间:&nbsp;<input name="end_time" type="datetime-local" min='--><?php //echo $now; ?><!--' value="--><?php //echo $end_time?><!--"></p>-->
<!--        <p align="left">是否公开:&nbsp;<select name="private">-->
<!--                <option value="0" --><?php //if ($private==0) echo "selected=selected"?><!-- >Public</option>-->
<!--                <option value="1" --><?php //if ($private==1) echo "selected=selected"?><!-- >Private</option>-->
<!--            </select></p>-->
<!--        <p align="left">若是private请设置密码:&nbsp;<input type="text" name="password" value="--><?php //echo $password?><!--"></p>-->
<!--        <p align="left">Description:<br/>-->
<!--            <textarea rows="13" name="description" style="width: 90%">--><?php //echo $description?><!--</textarea></p>-->
<!--        <p align="left">Problems:&nbsp;<input class="input-xxlarge" type="text" size="60" name="contest_problems" value="--><?php //echo $problem_list?><!--"></p>-->

        <div align="center">
            <input class="btn" style="width: 60px;height: 40px;" type="reset" value="重置" name="reset">
            <input class="btn" style="width: 60px;height: 40px;" type="submit" value="提交" name="submit">
            <?php require_once("../footer.php"); ?>
        </div>
    </form>
    <?php
}
?>
</body>
</html>
