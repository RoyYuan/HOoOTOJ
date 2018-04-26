<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>编译错误信息</title>
    <link rel="stylesheet" type="text/css" href="css/show_error.css" />
    <style>

        ::-webkit-scrollbar {display:none}

    </style>
</head>

<body>
<div id="C1">
    <?php require_once ("header.php");?>
    <div id="main">
        <div id="errors">
            <?php echo $view_errors ?>
        </div>
    </div>
</div>

<div class="center">
    <?php require_once ("footer.php"); ?>
</div>
</body>

</html>
