<?php
//检查密码
function check_password($password,$input)
{
    if(strcmp($password,$input)==0)
        return true;
    return false;
}
?>