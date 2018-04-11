<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Problemset</title>
    <link rel=stylesheet href="css/problemset.css" type='text/css'>
</head>
<body>
    <div id="C1">
        <?php require_once("header.php"); ?>
        <div id="main">
            <script src="js/jquery.js"></script>
            <script src="js/jquery.tablesorter.js"></script>
            <script>
                $(document).ready(function(){
                    $("#problemset").tablesorter();
                    }
                );
            </script>
            <h3 align="center">
                <?php
                for($i=1;$i<=$view_total_page;$i++){
                    if($i>1)
                        echo '&nbsp;';
                    if($i==$page)
                        echo "<span class='red'>$i</span>";
                    else
                        echo "<a href='problemset.php?page=".$i."'>".$i."</a>";
                }
                ?>
            </h3>
            <center>
                <table>
                    <tr align="center" class="evenrow">
                        <td width="5"></td>
                        <td width="50%">
                            <form action="problem.php">
                                Problem ID：
                                <input type="text" name="id" size="5">
                                <button type="submit">搜索</button>
                            </form>
                        </td>
                        <td width="50%">
                            <form>
                                Problem Title:
                                <input type="text" name="search">
                                <button type="submit">搜索相关</button>
                            </form>
                        </td>
                    </tr>
                </table>

                <table id="problemset" width="90%">

                    <thead>
                        <tr class="toprow">
                            <th width="120"><A>题目id</A></th>
                            <th>Title</th>
                            <th class="pointer" width=60 >提交</th>
                            <th class="pointer" width=60 >通过</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                    $cnt=0;
                    foreach($view_problemset as $row){
                        if ($cnt)
                            echo "<tr class='oddrow'>";
                        else
                            echo "<tr class='evenrow'>";
                        foreach($row as $table_cell){
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