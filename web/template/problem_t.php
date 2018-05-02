<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $view_title ?></title>
    <style>

        ::-webkit-scrollbar {display:none}

    </style>
    <link rel=stylesheet href='css/problem.css' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/chart.css">
    <script src="js/jquery.js"></script>
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
            $PID="0ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            echo "<title>题目 $PID[$pid]: $row->title </title>";
            echo "<center><h2>题目 $PID[$pid]: $row->title</h2>";
            $id=$row->problem_id;
        }

        echo "<span class='green'>TimeLimit:</span>$row->time_limit s&nbsp;&nbsp;";
        echo "<span class='green'>MemoryLimit:</span>$row->memory_limit MB";
        echo "<br/>";
        if ($pr_flag){
            echo "<span class='green'>提交:</span>$row->submit &nbsp;&nbsp;";
            echo "<span class='green'>通过:</span>$row->accept";
            echo "<br/>";
        }
        if($pr_flag){
            echo "[<a href='submitpage.php?id=$id'>Submit</a>]";
        }
        else{
            echo "[<a href='submitpage.php?cid=$cid&pid=$pid'>Submit</a>]";
        }

        echo "</center><div style='width:80%;margin-right: auto; margin-left: auto; '>";
        //处理sample中的<>
        $sample_input=str_replace("<","&lt;",$row->sample_input);
        $sample_output=str_replace("<","&lt;",$row->sample_output);
        $sample_input=str_replace(">","&gt;",$sample_input);
        $sample_output=str_replace(">","&gt;",$sample_output);
        ?>
            <div class='panel panel-default'>
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
                        <?php echo $row->description; ?>
                    </p>
                </div>
            </div>
            <div class='panel panel-default'>
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
                        <?php echo $row->input; ?>
                    </p>
                </div>
            </div>
            <div class='panel panel-default'>
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
                        <?php echo $row->output; ?>
                    </p>
                </div>
            </div>
            <div class='panel panel-default'>
                <div class="panel-heading font-bold" style="color: white"s>
                <span>
                    样例输入
                    <small>
                        Sample Input
                    </small>
                </span>
                </div>
                <div class="panel-body">
                    <pre><?php echo $sample_input; ?></pre>
                </div>
            </div>
            <div class='panel panel-default'>
                <div class="panel-heading font-bold" style="color: white">
                <span>
                    样例输出
                    <small>
                        Sample Output
                    </small>
                </span>
                </div>
                <div class="panel-body">
                    <pre><?php echo $sample_output; ?></pre>
                </div>
            </div>
            <div class='panel panel-default'>
                <div class="panel-heading font-bold" style="color: white"s>
                <span>
                    提示
                    <small>
                         Hint
                    </small>
                </span>
                </div>
                <div class="panel-body">
                    <p>
                        <?php echo nl2br($row->hint); ?>
                    </p>
                </div>
            </div>
            <?php
        echo "<center>";
//        easypiechart
        if ($row->submit && isset($_GET['id'])) {
            $ac_rate=$row->accept*100/$row->submit;
            ?>
            <div id="chart">
                <span class="chart" data-size="150" data-line-cap="butt" data-scale-color="black" data-line-width="20" data-track-color="lightgrey" data-bar-color="deepskyblue" data-percent="<?php echo intval($row->accept * 100 / $row->submit) ?>">
                    <span class="percent"></span>%
                    <br/>
                    <div class="easypie-text">通过率</div>
                </span>
            </div>
            <script src="js/jquery.js"></script>
            <script src="js/jquery.easypiechart.js"></script>
            <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
            <script>
                $(function() {
                    $('.chart').easyPieChart({
                        easing: 'easeOutBounce',
                        onStep: function(from, to, percent) {
                            $(this.el).find('.percent').text(Math.round(percent));
                        }
                    });
                    var chart = window.chart = $('.chart').data('easyPieChart');
                });
            </script>
            <?php
        }
        if ($pr_flag){?>
            <span class="block">
                <a href="submitpage.php?id=<?php echo $id;?>">
                    <button class="btn btn-primary">Submit</button>
                </a>
            </span>
<!--            <input class="btn btn-primary" value="Submit" type="button" onclick="javascript::window.location.href='submitpage.php?id=-->
            <?php
//            echo "<input class='btn btn-primary' type='button' onclick=\"javascript::window.location.href='submitpage.php?id=$id'\"><a href='submitpage.php?id=$id'>Submit</a>";
        }
        else{
            ?>
            <span class="block">
                <a href="submitpage.php?cid=<?php echo $cid;?>&pid=<?php echo $pid;?>">
                    <button class="btn btn-primary">Submit</button>
                </a>
            </span>
            <?php
//            echo "<input class='btn btn-primary'><a href='submitpage.php>cid=$cid&pid=$pid'>Submit</a>";
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