<?php @session_start();

//连接数据库
static $DB_HOST="localhost";
static $DB_NAME="HOoOTOJ1";
static $DB_USER="root";
static $DB_PASSWORD="";

//OJ设置
static $OJ_DATA="C:/Users/RoyYuan/Documents/HOoOTOJ/data";
static $OJ_NAME="HOoOTOJ";
static $OJ_RANK_LOCK_PERCENT=0;

//初始化db设置
global $mysqli;
if(($mysqli=mysqli_connect($DB_HOST,$DB_USER,$DB_PASSWORD))==null)
    die('不能连接：'.mysqli_error());
mysqli_query($mysqli,"set names utf8");
if(!mysqli_select_db($mysqli,$DB_NAME))
    die('无法连接至指定数据库'.mysqli_error());
mysqli_query($mysqli,"SET time_zone='+8:00'");

?>