<link rel="stylesheet" type="text/css" href="../css/header.css">
<?php
$flag=0;
if (isset($_SESSION['groups']) && $_SESSION['groups']<=-2)
    $flag=1;
?>
<div id="head">
    <center>
        <h2><img id="logo" src="../image/logo.png"><span style="color:red">HOoOT Online Judge</span></h2>
    </center>
</div>
<div id="subhead">
    <div id="menu" class="navbar">
        <?php $now="btn-warning"; ?>
        <br/>
        <br/>
        <a class="btn" style="width: 100px;" href="../"><i class="icon-home"></i>主页</a>
        <div class="problem_set">
            <a style="width: 100px;" class="btn <?php if (strlen($url) && (substr_compare($url,"problemset.php",0,14,TRUE)==0 || substr_compare($url,"problem_add_page.php",0,20,TRUE)==0 || substr_compare($url,"problem_list.php",0,16,TRUE)==0)) echo $now; ?>"
            <?php
            if ($flag){
                echo "><i class=\"icon-question-sign\"></i>题库</a>";
                echo "<div class='admin-problemset'><a style=\"width: 100px;\" class='btn' href='../problemset.php'>进入题库</a>";
                echo "<a style=\"width: 100px;\" class='btn' href='problem_add_page.php'>添加新题目</a>";
                echo "<a style=\"width: 100px;\" class='btn' href='problem_list.php'>管理题库</a></div>";
            }
            else
            {
                echo "href=\"../problemset.php\"><i class=\"icon-question-sign\"></i>题库</a>";
            }
            ?>
        </div>
        <!--        <a class="btn --><?php //if ($url=="problemset.php") echo $now; ?><!--" href="problemset.php"><i class="icon-question-sign"></i>题库</a>-->
        <a style="width: 100px;" class="btn <?php if (strlen($url) && (substr_compare($url,"status.php",0,10,TRUE)==0)) echo $now; ?>" href="../status.php"><i class="icon-check"></i>Status</a>
        <div class="contest_set">
            <a style="width: 100px;" class="btn <?php if (strlen($url) && (substr_compare($url,"contest.php",0,11,TRUE)==0 || substr_compare($url,"contest_add_page.php",0,20,TRUE)==0 || substr_compare($url,"contest_list.php",0,16,TRUE)==0)) echo $now; ?>"
            <?php
            if ($flag){
                echo "><i class='icon-fire'></i>竞赛</a>";
                echo "<div class='admin-contestset'><a style='width: 100px' class='btn' href='../contest.php'>进入竞赛列表</a>";
                echo "<a style='width: 100px;' class='btn' href='contest_add_page.php'>添加新竞赛</a>";
                echo "<a style='width: 100px' class='btn' href='contest_list.php'>管理竞赛</a></div>";
            }
            else{
                echo "href=\"../contest.php\"><i class=\"icon-fire\"></i>竞赛</a>";
            }
            ?>
        </div>
        <!--        <a style="width: 100px;" class="btn --><?php //if ($url=="contest.php") echo $now; ?><!--" href="contest.php"><i class="icon-fire"></i>竞赛</a>-->
        <a style="width: 100px;" class="btn <?php if ($url=="faqs.php") echo $now; ?>" href="../faqs.php"><i class="icon-info-sign"></i>FAQ</a>
    </div>

    <div id="profile">
        <script src="profile.php?<?php echo rand(); ?>"></script>
    </div>
</div>
<!--<div id=broadcast class="container">-->
<!--    <marquee id=broadcast scrollamount=1 direction=up scrolldelay=250 onMouseOver='this.stop()' onMouseOut='this.start()';>-->
<!--        --><?php //echo $view_marquee_msg?>
<!--    </marquee>-->
<!--</div>-->
<br>