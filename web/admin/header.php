<?php
function check_contest($MSG_CONTEST){
    global $mysqli,$MSG_CONTEST;
    $now=strftime("%Y-%m-%d %H:%M",time());
    $sql="SELECT count(*) FROM `contest` WHERE `end_time`>'$now' AND `hide`=0";
    $result=mysqli_query($mysqli,$sql);
    $row=mysqli_fetch_row($result);
    if (intval($row[0]==0))
        $return=$MSG_CONTEST;
    else
        $return=$row[0]."<span class=red>&nbsp;$MSG_CONTEST</span>";
    mysqli_free_result($result);
    return $return;
}


$OJ_FAQ_LINK="../faqs.php";
$url=basename($_SERVER['REQUEST_URI']);
//$view_marquee_msg=file_get_contents("./admin/msg.txt");

require("header_t.php");
?>
