<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv='refresh' content='60'>
    <title>Ranklist</title>
    <link rel=stylesheet href='css/contest_rank.css' type='text/css'>
    <script type="text/javascript" src="js/jquery-latest.js"></script>
    <script type="text/javascript" src="js/jquery.tablesorter.js"></script>
    <style>

        ::-webkit-scrollbar {display:none}

    </style>
<!--    <script>-->
<!--        $(document).ready(function()-->
<!--            {-->
<!--                $.tablesorter.addParser({-->
<!--                    id: 'punish',-->
<!--                    is: function(s) {-->
<!--                        return false;-->
<!--                    },-->
<!--                    format: function(s) {-->
<!--                        var v=s.toLowerCase().replace(/\:/,'').replace(/\:/,'').replace(/\(-/,'.').replace(/\)/,'');-->
<!--                        //alert(v);-->
<!--                        v=parseFloat('0'+v);-->
<!--                        return v>1?v:v+Number.MAX_VALUE-1;-->
<!--                    },-->
<!--                    // set type, either numeric or text-->
<!--                    type: 'numeric'-->
<!--                });-->
<!---->
<!--                $("#rank").tablesorter({-->
<!--                    headers: {-->
<!--                        3: {-->
<!--                            sorter:'punish'-->
<!--                        }-->
<!--                        --><?php
//                        for ($i=0;$i<$pid_cnt;$i++){
//                            echo ",".($i+4).": { ";
//                            echo "    sorter:'punish' ";
//                            echo "}";
//                        }
//                        ?>
<!--//                    }-->
<!--//                });-->
<!--//            }-->
<!--//        );-->
<!--//    </script>-->
</head>
<body>

<div id="C1">
    <div id="main" class="center">
        <?php require_once ("contest_header.php");?>
        <div>
            <h3 style="font-family: Arial">Contest<?php echo $cid ?>--<?php echo $title?></h3>
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
<!--            --><?php //echo $first_blood[1].$U[0]->problem_ac_sec[1] ?>
            <h3>Contest RankList</h3>
        <table id="rank" class="table table-striped" width="90%">
            <thead>
            <tr class="toprow" align="center">
                <th class="{sorter:'false'} center" width="5%">Rank</th>
<!--                <th width="5%" class="center">User</th>-->
                <th width="10%" class="center">Username</th>
                <th width="5%" class="center">Solved</th>
                <th width="5%" class="center">Penalty</th>
                <?php
                for ($i=0;$i<$pid_cnt;$i++)
                    echo "<td><a href='problem.php?cid=$cid&pid=".($i+1)."'>$PID[$i]</a></td>";
                echo "</tr></thead>\n<tbody>";
                for ($i=0;$i<$user_cnt;$i++){
                    if ($i&1)
                        echo "<tr class='' align='center'>\n";
                    else
                        echo "<tr class='' align='center'>\n";
                    echo "<td>";
                    $user_id=$U[$i]->user_id;
                    $username=$U[$i]->username;
                    if ($username[0]!="*")
                        echo $rank++;
                    else
                        echo "*";
                    echo "</td>";
                    $user_solved=$U[$i]->solved;
                    if (isset($_GET['user_id']) && $user_id==$_GET['user_id'])
                        echo "<td bgcolor=#ffff77>";
                    else
                        echo "<td>";
//                    echo "<a name='$user_id' href=user_info.php?user=$user_id>$user_id</a></td>";
                    echo "<a href='user_info.php?user=$user_id'>".htmlentities($U[$i]->username,ENT_QUOTES,"UTF-8")."</a></td>";
                    echo "<td><a href='status.php?user_id=$user_id&cid=$cid'>$user_solved</a></td>";
                    echo "<td>".sec2str($U[$i]->time)."</td>";
                    for ($j=1;$j<=$pid_cnt;$j++){
                        $bg_color="#eeeeee";
                        if (isset($U[$i]->problem_ac_sec[$j]) && $U[$i]->problem_ac_sec[$j]>0){
//                            $aa=0x33+$U[$i]->problem_wa_times[$j]*32;
//                            $aa=$aa>0xaa?0xaa:$aa;
//                            $aa=dechex($aa);
                            $bg_color="greenyellow";
                            if ($user_id==$first_blood[$j])
                                $bg_color="limegreen";
                        }
                        elseif (isset($U[$i]->problem_wa_times[$j]) && $U[$i]->problem_wa_times[$j]>0){
//                            $aa=0xaa-$U[$i]->problem_wa_times[$j]*10;
//                            $aa=$aa>16?$aa:16;
//                            $aa=dechex($aa);
                            $bg_color="pink";
                        }
                        echo "<td class=well style='background-color:$bg_color'>";
                        if (isset($U[$i])){
                            if (isset($U[$i]->problem_ac_sec[$j]) && $U[$i]->problem_ac_sec[$j]>0)
                                echo sec2str($U[$i]->problem_ac_sec[$j]);
                            if (isset($U[$i]->problem_wa_times[$j]) && $U[$i]->problem_wa_times[$j]>0)
                                echo "(-".$U[$i]->problem_wa_times[$j].")";
                        }
                        echo "</td>";
                    }
                    echo "</tr>\n";
                }
                echo "</tbody></table></center>";
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
                            var rank=rows[i].cells[0];
                            var solved=rows[i].cells[2];
                            var ac=parseInt(solved.innerText);
                            // alert(rank.innerHTML);
                            if (isNaN(ac))
                                ac=parseInt(solved.textContent);
                            // alert(ac);
                            if (rank.innerHTML!="*" && ac>0){
                                var r=parseInt(rank.innerHTML);
                                if (r==1){
                                    rank.innerHTML="Winner";
                                    rank.className="badge";
                                    rank.style="width:100%;background-color: gold;";
                                }
                                else if (r>1 && r<=total*.05+1) {
                                    rank.className = "badge";
                                    rank.style="width:100%;background-color: gold;";
                                }
                                else if (r>total*.05+1 && r<=total*.15+1){
                                    rank.className="badge";
                                    rank.style="width:100%;background-color: #c0c0c0;";
                                }
                                else if (r>total*0.15+1 && r<=total*0.30+1) {
                                    rank.className = "badge";
                                    rank.style="width:100%;background-color: brown;";
                                }
                                else if (ac>0) {
                                    rank.style="width:100%;background-color: deepskyblue;";
                                    rank.className = "badge";
                                }
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