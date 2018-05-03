<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Source Code</title>
    <link rel=stylesheet href='css/show_sourcecode.css' type="text/css">
    <style>

        ::-webkit-scrollbar {display:none}

    </style>
</head>
<body>
<div id="C1">
    <?php require_once ("header.php"); ?>
    <div id="main">
        <?php
        if ($ok=true){
            echo "<pre>";
            ob_start();
            echo "/**************************************************************\n";
            echo "\tSubmit ID:$id\n\tProblem:$code_problem_id\n\tUser:$code_username\n\tLanguage:".$language_name[$code_language]."\n";
            echo "\tResult:".$judge_result[$code_result]."\n";
            if ($judge_result==4){
                echo "\tTime:".$code_time."ms\n\tMemory:".$code_memory."kb\n";
            }
            echo "****************************************************************/\n\n";
            $auth=ob_get_contents();
            ob_end_clean();

            echo htmlentities(str_replace("\n\r","\n",$view_source),ENT_QUOTES,"UTF-8")."\n".$auth."</pre>";
        }
        else{
            echo "抱歉，你不能看这份Source Code!";
        }
        ?>
    </div>
</div>
<div class="center">
    <?php require_once ("footer.php"); ?>
</div>
</body>
</html>