<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php echo $view_title?></title>
    <link rel=stylesheet href='css/contestset.css' type='text/css'>
</head>
<body>
<div id="C1">
    <?php require_once ("header.php"); ?>
    <div id="main">
        <center>
            <table width="90%">
                <h2>Contest List</h2>
                ServerTime:<span id="nowdate"></span>
                <tr class="toprow" align="center">
                    <td width="10%">
                        ID
                    </td>
                    <td width="50%">
                        Name
                    </td>
                    <td width="40%">
                        Status
                    </td>
                </tr>
                <tbody>
                <?php
                $cnt=1;
                foreach ($contest_list as $row){
                    echo "<tr class=";
                    if ($cnt)
                        echo "'oddrow'>";
                    else
                        echo "'evenrow'>";
                    foreach ($row as $table_cell){
                        echo $table_cell;
                    }
                    echo "</tr>";
                    $cnt=1-$cnt;
                }
                ?>
                </tbody>
            </table>
        </center>
        <script>
            var diff=new Date("<?php echo date("Y/m/d H:i:s")?>").getTime()-new Date().getTime();
            function clock()
            {
                var x,h,m,s,n,xingqi,y,mon,d;
                var x = new Date(new Date().getTime()+diff);
                y = x.getYear()+1900;
                if (y>3000) y-=1900;
                mon = x.getMonth()+1;
                d = x.getDate();
                xingqi = x.getDay();
                h=x.getHours();
                m=x.getMinutes();
                s=x.getSeconds();

                n=y+"-"+mon+"-"+d+" "+(h>=10?h:"0"+h)+":"+(m>=10?m:"0"+m)+":"+(s>=10?s:"0"+s);
                //alert(n);
                document.getElementById('nowdate').innerHTML=n;
                setTimeout("clock()",1000);
            }
            clock();
        </script>
    </div>
</div>
<div class="center">
    <?php require_once ("footer.php"); ?>
</div>
</body>
</html>