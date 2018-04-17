<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $view_title ?></title>
    <link rel=stylesheet href='css/problem.css' type='text/css'>
    <link rel="next" href="submitpage.php?
    <?php
    if($pr_flag){
        echo "id=$id";
    }
    else{
        echo "cid=$cid&pid=$pid";
    }?>
">
</head>
<body>
    <div id="C1">
        <?php
        if (isset($_GET['id']))
            require_once ("header.php");
        else
            require_once ("contest_header.php");
        ?>
        <div id="main">
        <?php
        if ($pr_flag){
            echo "<title>题目 $row->problem_id. -- $row->title</title>";
            echo "<center><h2>$id: $row->title</h2>";
        }
        else{
            $PID="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            echo "<title>题目 $PID[$pid]: $row->title </title>";
            echo "<center><h2>题目 $PID[$pid]: $row->title</h2>";
            $id=$row->problem_id;
        }

        echo "<span class='green'>TimeLimit:</span>$row->time_limit s&nbsp;&nbsp;";
        echo "<span class='green'>MemoryLimit:</span>$row->memory_limit MB";
        echo "<br/>";
        echo "<span class='green'>提交:</span>$row->submit &nbsp;&nbsp;";
        echo "<span class='green'>通过:</span>$row->accept";
        echo "<br/>";

        if($pr_flag){
            echo "[<a href='submitpage.php?id=$id'>Submit</a>]";
        }
        else{
            echo "[<a href='submitpage.php?cid=$cid&pid=$pid'>Submit</a>]";
        }

        echo "</center><div style='width:80%;margin-right: auto; margin-left: auto; '>";

        echo "<h2>Description</h2><div class='content'>".$row->description."</div>";
        echo "<h2>Input</h2><div class='content'>".$row->input."</div>";
        echo "<h2>Output</h2><div class='content'>".$row->output."</div> ";

        //处理sample中的<>
        $sample_input=str_replace("<","&lt;",$row->sample_input);
        $sample_output=str_replace("<","&lt;",$row->sample_output);
        $sample_input=str_replace(">","&gt;",$sample_input);
        $sample_output=str_replace(">","&gt;",$sample_output);

        echo "<h2>Sample Input</h2>";
        echo "<pre class=content><span class='sampledata'>".($sample_input)."</span></pre>";

        echo "<h2>Sample Output</h2>";
        echo "<pre class=content><span class='sampledata'>".($sample_output)."</span></pre>";

        echo "<h2>Hint</h2>";
        echo "<div class=content><p>".nl2br($row->hint)."</p></div>";//nl2br() 函数在字符串中的每个新行（\n）之前插入 HTML 换行符
        echo "</div>";
        echo "<center>";
        if ($pr_flag){
            echo "[<a href='submitpage.php?id=$id'>Submit</a>]";
        }
        else{
            echo "[<a href='submitpage.php>cid=$cid&pid=$pid'>Submit</a>]";
        }

        echo "</center>";
        ?>
        </div>
    </div>
    <div class="center">
        <?php require_once ("footer.php"); ?>
    </div>
</body>
</html>