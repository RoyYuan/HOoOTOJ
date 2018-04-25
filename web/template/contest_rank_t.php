<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv='refresh' content='60'>
    <title>Ranklist</title>
    <link rel=stylesheet href='css/contest_rank.css' type='text/css'>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery.tablesorter.js"></script>
    <style>

        ::-webkit-scrollbar {display:none}

    </style>
    <script>
        $(document).ready(function(){
            $.tablesorter.addParser({
                id:'punish',
                is:function (s) {
                    return false;
                },
                format:function(s){
                    var v=s.toLowerCase().replace(/\:/,'').replace(/\:/,'').replace(/\(-/,'.').replace(/\)/,'');
                    v=parseFloat('0'+v);
                    return v>1?v:v+Number.MAX_VALUE-1;
                },
                type:'numeric'
            });
            $("#rank").tablesorter({
                headers:{
                    4:{
                        sorter:'punish'
                    }
                    <?php
                    for($i=0;$i<$pid_cnt;$i++){
                        echo ",".($i+5).": { ";
                        echo "  sorter:'punish' ";
                        echo "}";
                    }
                    ?>
                }
            });
        });
    </script>
</head>
<body>
<div id="C1">
    <div id="main" class="center">
        <?php require_once ("contest_header.php");?>
        <div>
            <h3>Contest<?php echo $cid ?></h3>
            [<a href="contest.php?cid=<?php echo $cid?>">Problemset</a>]
            [<a href="status.php?cid=<?php echo $cid?>">Status</a>]
            [<a href="contest_rank.php?cid=<?php echo $cid?>">Standing</a>]
        </div>
        <?php
        $rank=1;
        function sec2str($sec){
            return sprintf("%02d:%02d:%02d",$sec/3600,$sec%3600/60,$sec%60);
        }
        ?>
        <center>
            <h3>Contest RankList -- <?php echo $title ?></h3>
        </center>
        <table id="rank" width="90%">
            <thead>
            <tr class="toprow" align="center">
                <td class="{sorter:'false'}" width="5%">Rank</td>
                <th width="10%">User</th>
                <th width="10%">Username</th>
                <th width="5%">Solved</th>
                <th width="5%">Penalty</th>
                <?php
                for ($i=0;$i<$pid_cnt;$i++)
                    echo "<td><a href='problem.php?cid=$cid&pid=".($i+1)."'>$PID[$i]</a></td>";
                echo "</tr></thead>\n<tbody>";
                for ($i=0;$i<$user_cnt;$i++){
                    if ($i&1)
                        echo "<tr class='oddrow' align='center'>\n";
                    else
                        echo "<tr class='evenrow' align='center'>\n";
                    echo "<td>";
                    $user_id=$U[$i]->user_id;
                    $username=$U[$i]->username;
                    if ($username[0]!="*")
                        echo $rank++;
                    else
                        echo "*";
                    $user_solved=$U[$i]->solved;
                    if (isset($_GET['user_id']) && $user_id==$_GET['user_id'])
                        echo "<td bgcolor=#ffff77>";
                    else
                        echo "<td>";
                    echo "<a name='$user_id' href=userinfo.php?user=$user_id>$user_id</a>";
                    echo "<td><a href='userinfo.php?user=$user_id'>".htmlentities($U[$i]->username,ENT_QUOTES,"UTF-8")."</a>";
                    echo "<td><a href='status.php?user_id=$user_id&cid=$cid'>$user_solved</a>";
                    echo "<td>".sec2str($U[$i]->time);
                    for ($j=0;$j<$pid_cnt;$j++){
                        $bg_bolor="eeeeee";
                        if (isset($U[$i]->problem_ac_sec[$j]) && $U[$i]->problem_ac_sec[$j]>0){
                            $aa=0x33+$U[$i]->problem_wa_times[$j]*32;
                            $aa=$aa>0xaa?0xaa:$aa;
                            $aa=dechex($aa);
                            $bg_bolor="$aa"."ff"."$aa";
                            if ($user_id==$first_blood[$j])
                                $bg_bolor="aaaaff";
                        }
                        elseif (isset($U[$i]->problem_wa_times[$j]) && $U[$i]->problem_wa_times[$j]>0){
                            $aa=0xaa-$U[$i]->problem_wa_times[$j]*10;
                            $aa=$aa>16?$aa:16;
                            $aa=dechex($aa);
                            $bg_bolor="ff$aa$aa";
                        }
                        echo "<td class=well style='padding:1px;background-color:$bg_bolor'>";
                        if (isset($U[$i])){
                            if (isset($U[$i]->problem_ac_sec[$j]) && $U[$i]->problem_ac_sec[$j]>0)
                                echo sec2str($U[$i]->problem_ac_sec[$j]);
                            if (isset($U[$i]->problem_wa_times[$j]) && $U[$i]->problem_wa_times[$j]>0)
                                echo "(-".$U[$i]->problem_wa_times[$j].")";
                        }
                    }
                    echo "</tr>\n";
                }
                echo "</tbody></table>";
                ?>
            <script>
                function getTotal(rows){
                    var total=0;
                    for(var i=0;i<rows.length && total==0;i++){
                        try{
                            total=parseInt(rows[rows.length-i].cells[0].innerHTML);
                            if (isNaN(total))
                                total=0;
                        }catch(e){

                        }
                    }
                    return total;
                }
                function metal(){
                    var tb=window.document.getElementById('rank');
                    var rows=tb.rows;
                    try{
                        var total=getTotal(rows);
                        for (var i=1;i<rows.length;i++){
                            var cell=rows[i].cells[0];
                            var acc=rows[i].cells[3];
                            var ac=parseInt(acc.innerText);
                            if (isNaN(ac))
                                ac=parseInt(acc.textContent);
                            if (cell.innerHTML!="*" && ac>0){
                                var r=parseInt(cell.innerHTML);
                                if (r==1){
                                    cell.innerHTML="Winner";
                                    cell.className="badge badge-warning";
                                }
                                if (r>1 && r<=total*.05+1)
                                    cell.className="badge badge-warning";
                                if (r>total*.05+1 && r<=total*.15+1)
                                    cell.className="badge";
                                if (r>total*0.15+1 && r<=total*0.30+1)
                                    cell.className="badge badge-error";
                                if (r>total*0.30+1 && ac>0)
                                    cell.className="badge badge-info";
                            }
                        }
                    }catch(e){

                    }
                }
                metal();
                </script>
                <div class="center">
                    <?php require_once ("footer.php"); ?>
                </div>
    </div>
</div>
</body>
</html>