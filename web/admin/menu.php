<!DOCTYPE html>
<html>
<head>
    <title><?php echo $MSG_ADMIN?></title>
    <link rel=stylesheet href='admin.css' type='text/css'>
    <script src="../js/jquery.js"></script>
</head>

<body>
<?php
if(!isset($_SESSION)){
    session_start();
}
?>
<h4>
    <ol>
            <li>
                <a class="btn btn-primary" href="..\index.php" target="_parent"><b>退出管理页面</b></a>
            </li>
            <br/>
<!--            G5可以编辑新闻和主页公告-->
            <?php if (isset($_SESSION['groups']) && $_SESSION['groups']<=-5){?>
            <li>
                <a class="btn btn-primary" href="news_add_page.php" target="main"><b>添加新闻</b></a>
            </li><br/>
            <li>
                <a class="btn btn-primary" href="news_list.php" target="main"><b>新闻列表</b></a>
            </li><br/>
            <li>
                <a class="btn btn-primary" href="message_set.php" target="main"><b>设置公告</b></a>
            </li><br/>
            <?php }
//            G2以上可以增加题目和竞赛
            if (isset($_SESSION['groups']) && $_SESSION['groups']<=-2){?>
            <li>
                <a class="btn btn-primary" href="problem_add_page.php" target="main"><b>添加题目</b></a>
            </li><br/>
            <li>
                <a class="btn btn-primary" href="problem_list.php" target="main"><b>题目列表</b></a>
            </li><br/>
            <li>
                <a class="btn btn-primary" href="contest_add_page.php" target="main"><b>添加竞赛</b></a>
            </li><br/>
            <li>
                <a class="btn btn-primary" href="contest_list.php" target="main"><b>竞赛列表</b></a>
            </li><br/>
            <li>
                <a class="btn btn-primary" href="password_reset.php" target="main"><b>重置密码</b></a>
            </li><br/>
            <li>
                <a class="btn btn-primary" href="groups_change.php" target="main"><b>更改权限</b></a>
            </li><br/>
            <?php }?>
        </li>
    </ol>
</h4>

</body>
</html>
