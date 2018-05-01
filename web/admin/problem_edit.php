<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Content-Language" content="zh-cn">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>编辑题目</title>
    <link rel=stylesheet href='admin.css' type='text/css'>
    <script src="../js/jquery.js"></script>
    <style>

        ::-webkit-scrollbar {display:none}

    </style>
</head>
<body>
<center>
    <?php require_once ("../include/db_info.php");
    require_once ("../include/const.php");?>
    <?php
    require_once ("admin_header.php");
    require_once ("header.php");
    ?>
</center>
<?php
if (isset($_GET['id'])) {
    $id=$_GET['id'];
    $sql="SELECT `owner_id` FROM `problems` WHERE `problem_id`=$id";
    $result=mysqli_query($mysqli,$sql);
    $row=mysqli_fetch_object($result);
    $owner_id=$row->owner_id;
    if ($_SESSION['groups']>-3 && $_SESSION['user_id']!=$owner_id){
        mysqli_free_result($result);
        echo "<script>\n";
        echo "alert('您的帐号不能对此题目进行编辑！\\n');\n";
        echo "history.go(-1);\n";
        echo "</script>";
        exit(1);
    }
    mysqli_free_result($result);
    ?>
    <?php
    $sql = "SELECT * FROM `problems` WHERE `problem_id`=" . intval($_GET['id']);
    $result = mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_object($result);
    ?>
    <h1 class="center">编辑题目</h1>
    <h3>Problem ID:<?php echo $row->problem_id ?></h3>
    <form style="margin-left:2cm;" method="post" action="problem_edit.php?owner=$owner_id.">
        <input type=hidden name='problem_id' value='<?php echo $row->problem_id?>'>
        <div style="width: 90%">
            <div style="width: 50%;">
                <input name="title" class="form-control" style="height:35px;font-size: 25px;" placeholder="题目标题" type="text" value='<?php echo htmlentities($row->title, ENT_QUOTES, "UTF-8"); ?>'>
                <br/>
                <div style="float: left;width: 15%;height: 80px">
                    <p>时间限制(s):&nbsp;<input type="text" class="form-control" name="time_limit" size="20" value='<?php echo htmlentities($row->time_limit, ENT_QUOTES, "UTF-8"); ?>'></p>
                </div>
                <div style="float: left;width: 15%;height: 80px">
                    <p>空间限制(mb):&nbsp;<input type="text" class="form-control" name="memory_limit" size="20" value='<?php echo htmlentities($row->memory_limit, ENT_QUOTES, "UTF-8"); ?>'></p>
                </div>
                <div style="width: 70%;height: 80px">
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading font-bold" style="color: white">
            <span>
                题目描述
                <small>
                    Description
                </small>
            </span>
                </div>
                <div class="panel-body">
                    <p>
                        <textarea class="form-control" style="width: 100%" rows="13" name="description"><?php echo htmlentities($row->description, ENT_QUOTES, "UTF-8"); ?></textarea>
                    </p>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading font-bold" style="color: white">
            <span>
                输入描述
                <small>
                    Input Description
                </small>
            </span>
                </div>
                <div class="panel-body">
                    <p>
                        <textarea class="form-control" style="width: 100%" rows="13" name="input"><?php echo htmlentities($row->input, ENT_QUOTES, "UTF-8") ?></textarea>
                    </p>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading font-bold" style="color: white">
            <span>
                输出描述
                <small>
                    Output Description
                </small>
            </span>
                </div>
                <div class="panel-body">
                    <p>
                        <textarea class="form-control" style="width: 100%" rows="13" name="output"><?php echo htmlentities($row->output, ENT_QUOTES, "UTF-8") ?></textarea>
                    </p>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading font-bold" style="color: white">
            <span>
                样例输入
                <small>
                    Sample Input
                </small>
            </span>
                </div>
                <div class="panel-body">
                    <p>
                        <textarea class="form-control input input-xxlarge" style="width: 100%" rows="13" name="sample_input"><?php echo htmlentities($row->sample_input, ENT_QUOTES, "UTF-8") ?></textarea>
                    </p>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading font-bold" style="color: white">
            <span>
                样例输出
                <small>
                    Sample Output
                </small>
            </span>
                </div>
                <div class="panel-body">
                    <p>
                        <textarea class="form-control input input-xxlarge" style="width: 100%" rows="13" name="sample_output"><?php echo htmlentities($row->sample_output, ENT_QUOTES, "UTF-8") ?></textarea>
                    </p>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading font-bold" style="color: white">
            <span>
                提示
                <small>
                    Hint
                </small>
            </span>
                </div>
                <div class="panel-body">
                    <p>
                        <textarea class="form-control" style="width: 100%" rows="13" name="hint"><?php echo htmlentities($row->hint, ENT_QUOTES, "UTF-8") ?></textarea>
                    </p>
                </div>
            </div>
            <div align="center">
                <input class="btn btn-primary" style="width: 60px;height: 40px;" type="submit" value="提交" name="submit">
            </div>
        </div>


<!--        <p align="left">题目标题:&nbsp;<input class="input input-xxlarge" type="text" name="title" size="60"-->
<!--                                          value='--><?php //echo htmlentities($row->title, ENT_QUOTES, "UTF-8"); ?><!--'></p>-->
<!--        <p align="left">时间限制:&nbsp;<input type="text" name="time_limit" size="20"-->
<!--                                          value='--><?php //echo htmlentities($row->time_limit, ENT_QUOTES, "UTF-8"); ?><!--'>S-->
<!--        </p>-->
<!--        <p align="left">空间限制:&nbsp;<input type="text" name="memory_limit" size="20"-->
<!--                                          value='--><?php //echo htmlentities($row->memory_limit, ENT_QUOTES, "UTF-8"); ?><!--'>MByte-->
<!--        </p>-->
<!--        <p align="left">Description:<br/>-->
<!--            <textarea style="width: 90%" rows="13" name="description">--><?php //echo htmlentities($row->description, ENT_QUOTES, "UTF-8"); ?><!--</textarea>-->
<!--        </p>-->
<!--        <p align="left">Input:<br/>-->
<!--            <textarea style="width: 90%" rows="13" name="input">--><?php //echo htmlentities($row->input, ENT_QUOTES, "UTF-8") ?><!--</textarea>-->
<!--        </p>-->
<!--        <p align="left">Output:<br/>-->
<!--            <textarea style="width: 90%" rows="13" name="output">--><?php //echo htmlentities($row->output, ENT_QUOTES, "UTF-8") ?><!--</textarea>-->
<!--        </p>-->
<!--        <p align="left">Sample Input:<br/>-->
<!--            <textarea class="input input-xxlarge" style="width: 90%" rows="13" name="sample_input">--><?php //echo htmlentities($row->sample_input, ENT_QUOTES, "UTF-8") ?><!--</textarea>-->
<!--        </p>-->
<!--        <p align="left">Sample Output:<br/>-->
<!--            <textarea class="input input-xxlarge" style="width: 90%" rows="13" name="sample_output">--><?php //echo htmlentities($row->sample_output, ENT_QUOTES, "UTF-8") ?><!--</textarea>-->
<!--        </p>-->
<!--        <p align="left">Hint:<br/>-->
<!--            <textarea style="width: 90%" rows="13" name="hint">--><?php //echo htmlentities($row->hint, ENT_QUOTES, "UTF-8") ?><!--</textarea>-->
<!--        </p>-->
    </form>

    <?php
}
else{
//    require_once
    $id=intval($_POST['problem_id']);
    $title=$_POST['title'];
    $time_limit=$_POST['time_limit'];
    $memory_limit=$_POST['memory_limit'];
    $description=$_POST['description'];
    $input=$_POST['input'];
    $output=$_POST['output'];
    $sample_input=$_POST['sample_input'];
    $sample_output=$_POST['sample_output'];
    $hint=$_POST['hint'];
    if (get_magic_quotes_gpc()){
        $title = stripslashes ( $title);
        $time_limit = stripslashes ( $time_limit);
        $memory_limit = stripslashes ( $memory_limit);
        $description = stripslashes ( $description);
        $input = stripslashes ( $input);
        $output = stripslashes ( $output);
        $sample_input = stripslashes ( $sample_input);
        $sample_output = stripslashes ( $sample_output);
        $hint = stripslashes ( $hint);
    }
    $base_dir=$OJ_DATA."/$id";
    echo "样例测试文件已更新！<br/>";
    if ($sample_input){
        $fp=fopen($base_dir."/sample.in","w");
        fputs($fp,preg_replace("(\r\n)","\n",$sample_input));
        fclose($fp);

        $fp=fopen($base_dir."/sample.out","w");
        fputs($fp,preg_replace("(\r\n)","\n",$sample_output));
        fclose($fp);
    }
    $title = stripslashes ( $title);
    $time_limit = stripslashes ( $time_limit);
    $memory_limit = stripslashes ( $memory_limit);
    $description = stripslashes ( $description);
    $input = stripslashes ( $input);
    $output = stripslashes ( $output);
    $sample_input = stripslashes ( $sample_input);
    $sample_output = stripslashes ( $sample_output);
    $hint = stripslashes ( $hint);

    $sql="UPDATE `problems` SET `title`='$title',`time_limit`='$time_limit',`memory_limit`='$memory_limit',`description`='$description',`input`='$input',`output`='$output',`sample_input`='$sample_input',`sample_output`='$sample_output',`hint`='$hint' WHERE `problem_id`=$id";
    @mysqli_query($mysqli,$sql) or die(mysqli_errors());
    echo "更新成功！";
    echo "<a href='../problem.php?id=$id'>浏览该题目</a>";
}
?>
</body>
</html>