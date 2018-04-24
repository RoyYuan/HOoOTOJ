<link rel="stylesheet" type="text/css" href="css/header.css">
<div id="head">
    <center>
        <h2><img id="logo" src="image/logo.png"><span style="color:red">HOoOT Online Judge</span></h2>
    </center>
</div>
<div id="subhead">
    <div id="menu" class="navbar">
        <?php $now="btn-warning"; ?>
        <br/>
        <br/>
        <a class="btn" href="./"><i class="icon-home"></i>主页</a>
        <a class="btn <?php if ($url=="problemset.php") echo $now; ?>" href="problemset.php"><i class="icon-question-sign"></i>题库</a>
        <a class="btn <?php if ($url=="status.php") echo $now; ?>" href="status.php"><i class="icon-check"></i>Status</a>
        <a class="btn <?php if ($url=="contest.php") echo $now; ?>" href="contest.php"><i class="icon-fire"></i>竞赛</a>
        <a class="btn <?php if ($url=="faqs.php") echo $now; ?>" href="faqs.php"><i class="icon-info-sign"></i>FAQ</a>
    </div>

    <div id="profile">
        <script src="include/profile.php?<?php echo rand(); ?>"></script>
    </div>
</div>
<!--<div id=broadcast class="container">-->
<!--    <marquee id=broadcast scrollamount=1 direction=up scrolldelay=250 onMouseOver='this.stop()' onMouseOut='this.start()';>-->
<!--        --><?php //echo $view_marquee_msg?>
<!--    </marquee>-->
<!--</div>-->
<br>