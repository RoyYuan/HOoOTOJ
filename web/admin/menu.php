<!DOCTYPE html>
<?php require_once ("admin_header.php");?>
<html>
<head>
    <title><?php echo $MSG_ADMIN?></title>
</head>

<body>
    <hr>
<h4>
    <ol>
        <li>
            <a class="btn btn-primary" href="watch.php" target="main">
                <b><?php echo $MSG_SEEOJ?></b>
            </a>
        </li>
        <?php if (isset($_SESSION['administrator'])){?>
        <li>
        <?php }
    </ol>
</h4>
</body>
</html>
