<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Submit</title>
    <link rel="stylesheet" href="css/submitpage.css" type="text/css">
</head>
<body>
<div id="C1">
    <?php
    if (isset($_GET['id'])){
        require_once("header.php");
        $id=$_GET['id'];
    }
    else
        require_once("contest_header.php");
    ?>
    <div id="main">
        <center>
            <form id="form_solution" action="submit.php" method="post">
                <?php if(isset($id)){?>
                    Problem <span class="blue"><b><?php echo $id ?></b></span>
                    <input id="problem_id" type="hidden" value="<?php echo $id?>" name="id"><br>
                <?php }else {?>
                    Problem <span class="blue"><b><?php echo chr($pid+ord('A'))?></b></span> of Contest <span class="blue"><b><?php echo $cid?></b></span><br>
                    <input id="cid" type="hidden" value="<?php echo $cid?>" name="cid">
                    <input id="pid" type="hidden" value="<?php echo $pid?>" name="pid">
                <?php }?>
                Language: C++<br>

                <textarea style="width: 80%;" cols="180" rows="20" id="source_code" name="source_code"></textarea><br>

                <input id="submit" type="button" value="提交" onclick="do_submit()">
                <input type="reset" value="重置">
            </form>
        </center>

        <script>
            function do_submit() {
                if (typeof(eAL) != "undefined") {
                    eAL.toggle("source_code");
                    eAL.toggle("source_code");
                }
                var mark = "<?php echo isset($id) ? 'problem_id' : 'cid';?>";
                var problem_id = document.getElementById(mark);
                if (mark = 'problem_id')
                    problem_id.value = "<?php if (isset($id)) echo $id?>";
                else
                    problem_id.value = "<?php if (isset($cid)) echo $cid?>";
                document.getElementById("form_solution").target = "_self";
                document.getElementById("form_solution").submit();
            }
        </script>

    </div>

</div>
</body>
</html>