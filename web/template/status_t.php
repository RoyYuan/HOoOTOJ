<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="refresh" content="60">
    <title>Status</title>
    <link rel="stylesheet" href="css/status.css" type="text/css">
    <style>

        ::-webkit-scrollbar {display:none}

    </style>
</head>
<body>
<div id="C1">
    <?php require_once ("header.php"); ?>
    <center><h2>Status</h2></center>
    <div id="main">
        <br/>
        <div id="center" class="input-append">
            <form id="simform" action="status.php" method="get">
                Problem ID:<input class="input-mini" style="height: 24px;" type="text" size="4" name="problem_id" value="<?php echo htmlentities($problem_id,ENT_QUOTES,'UTF-8')?>">
                用户:<input class="input-mini" style="height: 24px;" type="text" size="10" name="username" value="<?php echo htmlentities($username,ENT_QUOTES,'UTF-8')?>">
                <?php
                if (isset($cid)) echo "<input type='hidden' name='cid' value='$cid'>";
                ?>
                语言:<select class="input-small" size="1" name="language">
                    <?php
                    if (isset($_GET['language']))
                        $language=intval($_GET['language']);
                    else
                        $language=-1;
                    if ($language<0 || $language>=count($language_name))
                        $language=-1;
                    if ($language==-1)
                        echo "<option value='-1' selected>All</option>";
                    else
                        echo "<option value='-1'>All</option>";
                    $i=0;
                    foreach ($language_name as $lang){
                        echo "<option value=$i ";
                        if ($i==$language)
                            echo "selected";
                        echo ">$language_name[$i]</option>";
                        $i++;
                    }
                    ?>
                </select>
                Result:<select class="input-small" size="1" name="judge_result">
                    <?php
                    if (isset($_GET['judge_result']))
                        $judge_result_get=intval($_GET['judge_result']);
                    else
                        $judge_result_get=-1;
                    if ($judge_result_get>=12 || $judge_result_get<0)
                        $judge_result_get=-1;
                    if ($judge_result_get==-1)
                        echo "<option value='-1' selected>All</option>";
                    else
                        echo "<option value='-1'>All</option>";
                    for ($j=0;$j<12;$j++){
                        $i=($j+4)%12;
                        if ($i==$judge_result_get)
                            echo "<option value='".strval($judge_result_get)."'selected>".$judge_result[$i]."</option>";
                        else
                            echo "<option value='".strval($i)."'>".$judge_result[$i]."</option>";
                    }
                    ?>
                </select>

                <input type="submit" class="input" value="搜索" style="height: 25px;">
            </form>
            <br/>
            <table id="result_table"  class="table table-striped" align="center" width="90%">
                <thead>
                <tr class="toprow">
                    <th width="10%" style="text-align:center;">Run ID</th>
                    <th  width="10%" style="text-align:center;">用户</th>
                    <th width="10%" style="text-align:center;">Problem</th>
                    <th width="10%" style="text-align:center;">结果</th>
                    <th width="7.5%" style="text-align:center;">空间<span class="glyphicon glyphicon-book"></span>(kb)</th>
                    <th width="7.5%" style="text-align:center;">时间<span class="glyphicon glyphicon-time"></span>(ms)</th>
                    <th width="5%" style="text-align:center;">语言</th>
                    <th width="5%" style="text-align:center;">代码长度</th>
                    <th width="15%" style="text-align:center;">提交时间</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $cnt=0;
                foreach ($view_status as $row){
//                    if ($cnt)
//                        echo "<tr class='oddrow'>";
//                    else
//                        echo "<tr class='evenrow'>";
                    if ($cnt)
                        echo "<tr class='info'>";
                    else
                        echo "<tr>";
                    foreach ($row as $table_cell){
                        echo "<td align=\"center\" valign=\"middle\">";
                        echo "\t".$table_cell;
                        echo "</td>";
                    }
                    echo "</tr>";
                    $cnt=1-$cnt;
                }
                ?>
                </tbody>
            </table>

            <?php
            echo "[<a href='status.php?".$str."'>最前页</a>]&nbsp;&nbsp;";
            if (isset($_GET['prevtop']))
                echo "[<a href='status.php?".$str."&top=".intval($_GET['prevtop'])."'>上一页</a>]&nbsp;&nbsp;";
            else
                echo "[<a href='status.php?".$str."&top=".intval($top+20)."'>上一页</a>]&nbsp;&nbsp;";
            echo "[<a href='status.php?".$str."&top=".intval($bottom-1)."&prevtop=".$top."'>下一页</a>]";
            ?>
        </div>


    </div>
</div>
<div class="center">
    <?php require_once ("footer.php"); ?>
</div>
</body>
<script>
    var i=0;
    var judge_result=[
        <?php
        foreach ($judge_result as $result) {
            echo "'$result',";
        }
        ?>
    ''];
    function auto_refresh() {
        var tb=window.document.getElementById('result_table');
        var rows=tb.rows;
        for (var i=1;i<rows.length;i++){
            var cell=rows[i].cells[3].innerHTML;
            var sid=rows[i].cells[0].innerHTML;
            if (cell.indexOf(judge_result[0])!=-1 || cell.indexOf(judge_result[2])!=-1 || cell.indexOf(judge_result[3])!=-1) {
                fresh_result(sid);
            }
        }
    }

    function findRow(submit_id){
        var tb=window.document.getElementById('result_table');
        var rows=tb.rows;
        for (var i=1;i<rows.length;i++){
            var cell=rows[i].cells[0];
            if (cell.innerHTML==submit_id)
                return rows[i];
        }
    }

    function fresh_result(submit_id) {
        var xmlhttp;
        if (window.XMLHttpRequest){
            xmlhttp=new XMLHttpRequest();
        }
        xmlhttp.onreadystatechange=function () {
            if (xmlhttp.readyState==4 && xmlhttp.status==200){
                var tb=window.document.getElementById('result_table');
                var row=findRow(submit_id);
                var r=xmlhttp.responseText;
                var ra=r.split(",");
                var loader="<img width=18 src='image/loader.gif>";
                row.cells[3].innerHTML="<span class='btn btn-warning'>"+judge_result[ra[0]]+"</span>"+loader;
                row.cells[4].innerHTML=ra[1];
                row.cells[5].innerHTML=ra[2];
                if(ra[0]<4)
                    window.setTimeout("fresh_result("+submit_id+")",2000);
                else
                    window.location.reload();
            }
        }
        xmlhttp.open("GET","status-ajax.php?submit_id="+submit_id,true);
        xmlhttp.send();
    }
    auto_refresh();
</script>
</html>