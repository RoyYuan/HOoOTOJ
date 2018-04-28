<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.css">
    <script src="../js/jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.js"></script>
</head>
<body>
<?php
$flag=0;
$now="active";
if (!isset($_SESSION))
    session_start();
if (isset($_SESSION['groups']) && $_SESSION['groups']<=-2)
    $flag=1;
?>
<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <!--            <img class="navbar-brand" src="image/logo.png">-->
            <a class="navbar-brand" href="#">HOoOT Online Judge</a>
        </div>
        <div style="font-family: 宋体;font-weight:bold">
            <ul class="nav navbar-nav">
                <li>
                    <a href="../index.php">主页</a>
                </li>
                <li class="dropdown  <?php if (strlen($url) && (substr_compare($url,"problemset.php",0,14,TRUE)==0 || substr_compare($url,"problem_add_page.php",0,20,TRUE)==0 || substr_compare($url,"problem_list.php",0,16,TRUE)==0)) echo $now; ?>">
                    <?php
                    if ($flag){?>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">题库</a>
                        <ul class="dropdown-menu">
                            <li><a href="../problemset.php">进入题库</a></li>
                            <li><a href="problem_add_page.php">添加题目</a></li>
                            <li><a href="problem_list.php">管理题库</a></li>
                        </ul>
                        <?php
                    }
                    else{
                        ?>
                        <a href="../problemset.php">题库</a>
                        <?php
                    }
                    ?>
                </li>
                <li class="<?php if (strlen($url) && substr_compare($url,"status.php?cid=",0,15)!=0 && (substr_compare($url,"status.php",0,10,TRUE)==0)) echo $now; ?>">
                    <a href="../status.php">Status</a>
                </li>
                <li class="dropdown <?php if (strlen($url) && (substr_compare($url,"status.php?cid=",0,15)==0 || substr_compare($url,"contest",0,7)==0 || substr_compare($url,"contest.php",0,11,TRUE)==0 || substr_compare($url,"contest_add_page.php",0,20,TRUE)==0 || substr_compare($url,"contest_list.php",0,16,TRUE)==0)) echo $now; ?>">
                    <?php
                    if ($flag){?>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">竞赛</a>
                        <ul class="dropdown-menu">
                            <li><a href="../contest.php">进入竞赛列表</a></li>
                            <li><a href="contest_add_page.php">添加竞赛</a></li>
                            <li><a href="contest_list.php">竞赛管理</a></li>
                        </ul>
                        <?php
                    }
                    else{
                        ?>
                        <a href="../contest.php">竞赛</a>
                        <?php
                    }
                    ?>
                </li>
                <li class="<?php if (strlen($url) && (substr_compare($url,"faqs.php",0,8,TRUE)==0)) echo $now; ?>">
                    <a href="../faqs.php">FAQ</a>
                </li>
            </ul>
            <?php
            if (!isset($_SESSION['user_id'])) {
                ?>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="../registerpage.php"><span class="glyphicon glyphicon-user"></span> 注册&nbsp;</a></li>
                    <li><a href="../loginpage.php"><span class="glyphicon glyphicon-log-in"></span> 登录&nbsp;</a></li>
                </ul>
                <?php
            }
            else{
                echo "<ul class=\"nav navbar-nav navbar-right\">";
                if ($flag){
                    ?>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            权限操作
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="password_reset.php">重置他人密码</a>
                            </li>
                            <li>
                                <a href="groups_change.php">更改他人权限</a>
                            </li>
                        </ul>
                    </li>
                    <?php
                }
                ?>
                    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span>个人中心</a>
                        <ul class="dropdown-menu">
                            <li><a href="../user_info.php?user=<?php echo$_SESSION['user_id']?>">个人信息</a></li>
                            <li><a href="../logout.php">注销</a></li>
                        </ul>
                    </li>
                </ul>
                <?php
            }
            ?>
        </div>
    </div>

</nav>
</body>
</html>

