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
        <script src="include/sortTable.js"></script>
        <center>
            <div>
                <h3>Contest<?php echo $contest_cid ?></h3>
                <p><?php echo $contest_description ?></p><br/>
                Start Time:<font color="#993399"><?php echo $contest_start_time ?></font>
                End Time:<font color="#993399"><?php echo $contest_end_time ?></font>
                Current Time:<font color="#993399"><span id="nowdate"><?php echo date("Y-m-d H:i:s")?></span></font>
                Status:<?php
                $now=time();
                if ($now>$end_time)
                    echo "<span class='red'>Ended</span>";
                elseif ($now<$start_time)
                    echo "<span class='red'>Not Started</span>";
                else
                    echo "<span class='red'>Running</span>";
                ?>
                <br/>
                [<a href="status.php?cid=<?php echo $contest_cid?>">Status</a>]
                [<a href="contest_rank.php?cid=<?php echo $contest_cid?>">Standing</a>]
            </div>
            <table id="problemset" width="90%">
                <thead>
                <tr align="center" class="toprow">
                    <td width="5%">
                    </td>
                    <td style="cursor:hand" onclick="sortTable('problemset',1,'int');" width="15%">
                        <a>Problem ID</a>
                    </td>
                    <td width="60%">
                        Title
                    </td>
                    <td style="cursor:hand" onclick="sortTable('problemset',3,'int');" width="5%">
                        <a>Accepted</a>
                    </td>
                    <td style="cursor:hand" onclick="sortTable('problemset',4,'int');" width="5%">
                        <a>Submited</a>
                    </td>
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
                        echo "<td>";
                        echo "\t".$table_cell;
                        echo "</td>";
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