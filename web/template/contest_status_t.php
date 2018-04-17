<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv='refresh' content='60'>
    <title><?php echo $view_title?></title>
    <link rel=stylesheet href='css/contest_status.css' type='text/css'>
</head>
<body>
<div id="C1">
    <?php require_once ("contest_header.php"); ?>
    <div id="main">
        <div id="center">
            <form id="simform" action="status.php" method="get">
                Problem ID:<input class="input-mini" style="height: 24px;" type="text" size="4" name="problem_id" value="<?php echo htmlentities($problem_id,ENT_QUOTES,'UTF-8')?>">
                用户:<input class="input-mini" style="height: 24px;" type="text" size="4" name="user_id" value="<?php echo htmlentities($user_id,ENT_QUOTES,'UTF-8')?>">
                <?php
                if (isset($cid))
                    echo "<input type='hidden' name='cid' value='$cid'>";
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

                <input type="submit" class="input" value="搜索">
            </form>
            <table id="result_table" class="table table-striped content-box-header" align="center" width="80%">
                <thead>
                <tr class="success toprow">
                    <th>Run ID
                    <th>用户
                    <th>Problem
                    <th>结果
                    <th>空间
                    <th>时间
                    <th>语言
                    <th>代码长度
                    <th>提交时间
                </tr>
                </thead>

                <tbody>
                <?php
                $cnt=0;
                foreach ($view_status as $row){
                    if ($cnt)
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
            <?php
            echo "[<a href='status.php?".$str."'>最前页</a>]&nbsp;&nbsp;";
            if (isset($_GET['prevtop']))
                echo "[<a href='status.php?".$str."&top=".intval($_GET['prevtop'])."'>上一页</a>]&nbsp;&nbsp;";
            else
                echo "[<a href='status.php?".$str."&top=".($top+20)."'>上一页</a>]&nbsp;&nbsp;";
            echo "[<a href='status.php?".$str."&top=".$bottom."&prevtop=".$top."'>下一页</a>]";
            ?>
        </div>
    </div>
</div>
<div class="center">
    <?php require_once ("footer.php"); ?>
</div>

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
                    window.setTimeout("fresh_result("+solution_id+")",2000);
                else
                    window.location.reload();
            }
        }
        xmlhttp.open("GET","status-ajax.php?submit_id="+submit_id,true);
        xmlhttp.send();
    }
    <?php
        if ($last>0 && $_SESSION['user_id']==$_GET['user_id'])
            echo "fresh_result($last);";
    ?>
    </script>
</body>
</html>