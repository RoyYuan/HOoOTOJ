<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php echo $view_title?></title>
    <link rel=stylesheet href='css/contest.css' type='text/css'>
    <style>

        ::-webkit-scrollbar {display:none}

    </style>
</head>
<body>
<div id="C1">
    <?php require_once ("contest_header.php"); ?>
    <div id="main">
<!--        <script src="include/sortTable.js"></script>-->
        <center>
            <div>
                <h3 style="font-family: Arial">Contest<?php echo $contest_cid ?></h3>
                <p><?php echo $contest_description ?></p><br/>
                开始时间:<font color="#993399"><?php echo $contest_start_time ?></font>
                结束时间:<font color="#993399"><?php echo $contest_end_time ?></font>
                当前时间:<font color="#993399"><span id="nowdate"><?php echo date("Y-m-d H:i:s")?></span></font>
                Status:<?php
                $now=time();
                if ($now>$end_time)
                    echo "<span class='red'>已结束</span>";
                elseif ($now<$start_time)
                    echo "<span class='red'>尚未开始</span>";
                else
                    echo "<span class='red'>正在进行</span>";
                ?>
                <br/>
                [<a href="contest.php?cid=<?php echo $contest_cid?>">Problemset</a>]
                [<a href="status.php?cid=<?php echo $contest_cid?>">Status</a>]
                [<a href="contest_rank.php?cid=<?php echo $contest_cid?>">Standing</a>]
            </div>
            <table id="problemset" class='table table-striped' width="90%">
                <thead>
                <tr align="center" class="toprow">
                    <td width="5%">
                    </td>
                    <td style="cursor:hand;text-align: left" width="15%">
                        <a>Problem ID</a>
                    </td>
                    <td style="cursor:hand;text-align: left" width="60%">
                        <a>Title</a>
                    </td>
                    <td class="pointer" width=120 ><a>AC率（通过<span class='glyphicon glyphicon-ok-circle'></span>&错误<span class='glyphicon glyphicon-remove-circle'></span>）</a></td>
                    <!--                            <th class="pointer" width=60 >通过</th>-->
<!--                    <td style="cursor:hand" width="5%">-->
<!--                        <a>Accepted<span class='glyphicon glyphicon-ok-circle'></span></a>-->
<!--                    </td>-->
<!--                    <td style="cursor:hand" width="5%">-->
<!--                        <a>Submited<span class='glyphicon glyphicon-upload'></span></a>-->
<!--                    </td>-->
                </tr>
                </thead>
                <tbody>
                <?php
                $cnt=0;
                foreach ($contest_problemset as $row){
                    if ($cnt)
                        echo "<tr class='oddrow'>";
                    else
                        echo "<tr class='evenrow'>";
                    foreach ($row as $table_cell) {
                        echo $table_cell;
//                        echo "<td>";
//                        echo "\t".$table_cell;
//                        echo "</td>";
                    }
                    echo "</tr>";
                    $cnt=1-$cnt;
                }
                ?>
                </tbody>
            </table>
        </center>
    </div>
</div>
<div class="center">
    <?php require_once ("footer.php"); ?>
</div>
</body>
</html>