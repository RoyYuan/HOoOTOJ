<?php if(file_exists("include/db_info.php")){
    require_once("include/db_info.php");
}
$judge_result=Array('等待判题','等待重判','编译中','判题中','Accepted','Presentation Error','Wrong Answer','Time Limit Exceed','Memory Limit Exceed','Output Limit Exceed','Runtime Error','Compile Error','Compile OK');
//$jresult=Array($MSG_PD,$MSG_PR,$MSG_CI,$MSG_RJ,$MSG_AC,$MSG_PE,$MSG_WA,$MSG_TLE,$MSG_MLE,$MSG_OLE,$MSG_RE,$MSG_CE,$MSG_CO,$MSG_TR);
$judge_color=Array("gray","gray","orange","orange","green","red","red","red","red","red","red","navy ","navy");
//$language_name=Array("C++","C","Pascal","Java","Ruby","Bash","Python","PHP","Perl","C#","Obj-C","FreeBasic","Schema","Clang","Clang++","Lua","JavaScript","Other Language");
//$language_ext=Array( "cc", "c", "pas", "java", "rb", "sh", "py", "php","pl", "cs","m","bas","scm","c","cc","lua","js" );
$PID="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
$language_name=Array("C++","C","Java");
$language_ext=Array("cc","c","java");
?>
