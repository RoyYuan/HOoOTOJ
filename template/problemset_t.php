<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>题库</title>
    <link rel="stylesheet" type="text/css" href="css/problemset.css" />
</head>

<body>
<div id="C1">
    <?php require_once ("header.php");?>
    <div id="main">
        <script type="text/javascript" src="include/jquery-latest.js"></script>
        <script type="text/javascript" src="include/jquery.tablesorter.js"></script>
        <script type="text/javascript">
            $(document).ready(function()
                {
                    $("#problemset").tablesorter();
                }
            );
        </script>
        <h3 align="center">
            <?php
            for($i=1;$i=$view_total_page;$i++){
                if($i>1) echo '&nbsp;';
                if($i==page) echo "<span class=red>$i</span>";
                else echo "<a href='problemset.php?page=".$i."'>".$i."</a>";
            }
            ?>
        </h3>
        <center>
            <table id="problemset" width="90%" class="table table-striped">
                <thead>
                    <tr class="toprow">
                        <th width="5"></th>
                        <th width="120"><A><?php echo $MSG_PROBLEM_ID?></A></th>
                        <th><?php echo $MSG_TITLE?></th>
                        <th style="cursor:hand" width="60"><?php echo $MSG_AC?></th>
                        <th style="cursor:hand" width="60"><?php echo $MSG_SUBMIT?></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $cnt=0;
                foreach ($view_problemset as $row){
                    if($cnt)
                        echo "<tr class='oddrow'>";
                    else
                        echo "<tr class='evenrow'>";
                    foreach ($row as $table_cell){
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
</body>
</html>