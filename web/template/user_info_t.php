<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php echo $view_title?></title>
    <link rel="stylesheet" href="css/user_info.css" type="text/css">
    <style>

        ::-webkit-scrollbar {display:none}

    </style>
</head>
<body>
<script src="js/jquery.js"></script>
<div id="C1">
    <?php require_once ("header.php"); ?>
    <div id="main">
        <center>
            <h1><?php echo $username;?>的个人信息</h1>
            <table class="table table-striped" id="statics" width="50%">
                <tr class="oddrow">
                    <td width="50%" align="center">
                        用户
                    </td>
                    <td width="50%" align="center">
                        <?php echo htmlentities($username,ENT_QUOTES,"UTF-8"); ?>
                    </td>
                </tr>
                <tr class="evenrow">
                    <td  align="center">
                        排名
                    </td>
                    <td align="center">
                        <?php echo $rank; ?>
                    </td>
                </tr>
                <tr class="oddrow">
                    <td align="center">
                        已解决题数
                    </td>
                    <td align="center">
                        <?php echo $accepted; ?>
                    </td>
                </tr>
                <tr class="evenrow">
                    <td align="center">
                        已提交次数
                    </td>
                    <td align="center">
                        <?php echo $submited; ?>
                    </td>
                </tr>
            </table>
            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id']==$user_mysql){?>
            <div>
                [<a href="password_change.php">更改密码</a>]
            </div>
            <?php } ?>
        </center>
    </div>
</div>

</body>
</html>