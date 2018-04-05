<?php function checkcontest($MSG_CONTEST){
    global $mysqli,$MSG_CONTEST;
    $now=strftime("%Y-%m-%d %H:%M",time());
    $sql="SELECT count(*) FROM `contest` WHERE `end_time` > '$now' AND `defunct`='N'";
}
?>