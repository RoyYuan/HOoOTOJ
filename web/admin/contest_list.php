<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Content-Language" content="zh-cn">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Contest List</title>
    <link rel=stylesheet href='admin.css' type='text/css'>
    <script src="../js/jquery.js"></script>
    <style>

        ::-webkit-scrollbar {display:none}

    </style>
</head>
<body>
<?php
/**
 * Created by PhpStorm.
 * User: RoyYuan
 * Date: 2018/4/22
 * Time: 19:58
 */
require ("admin_header.php");
require_once ("header.php");
echo "<center><h2>Contest List</h2></center>";

$sql="SELECT MAX(`contest_id`) AS upid,MIN(`contest_id`) AS btid FROM `contest`";
$page_cnt=50;
$result=mysqli_query($mysqli,$sql);
echo mysqli_error($mysqli);
$row=mysqli_fetch_object($result);
$base=intval($row->btid);
$cnt=intval($row->upid)-$base+1;
$cnt=intval($cnt/$page_cnt)+(($cnt%$page_cnt)>0?1:0);
if (isset($_GET['page'])){
    $page=intval($_GET['page']);
}
else{
    $page=$cnt;
}
$page_start=$base+$page_cnt*intval($page-1);
$page_end=$page_start+$page_cnt;
echo "<div class='center'>";
for ($i=1;$i<=$cnt;$i++){
    if ($i>1)
        echo '&nbsp;';
    if ($i==$page)
        echo "<span class=red>$i</span>";
    else
        echo "<a href='contest_list.php?page=".$i."'>".$i."</a>";
}
echo "</div>";
$sql="SELECT `contest_id`,`contest_title`,`start_time`,`end_time`,`private`,`hide`,`owner_id` FROM `contest`
WHERE contest_id>=$page_start AND contest_id<=$page_end ORDER BY `contest_id` DESC";
if(isset($_GET['keyword']))
    $keyword=$_GET['keyword'];
else
    $keyword="";
$keyword=mysqli_real_escape_string($mysqli,$keyword);
if ($keyword)
    $sql="SELECT `contest_id`,`contest_title`,`start_time`,`end_time`,`private`,`hide`,`owner_id` FROM `contest`
WHERE contest_title LIKE '%$keyword%' ";
$result=mysqli_query($mysqli,$sql) or die(mysqli_error());
?>
<form action="contest_list.php" class="center">
    关键字：<input name="keyword" value="<?php if (isset($keyword)) echo $keyword;?>">
    <input type="submit" style="height: 25px;" value="搜索">
</form>
<br/>

<?php
echo "<center><table class='table table-striped' width='90%' border='1'>";
echo "<tr><td>Contest ID</td><td>Title</td><td>开始时间</td><td>结束时间</td><td>公开性</td><td>可见性</td><td>Edit</td></tr>";
for (;$row=mysqli_fetch_object($result);){
    echo "<tr>";
    echo "<td>".$row->contest_id."</td>";
    echo "<td><a href='../contest.php?cid=$row->contest_id'>".$row->contest_title."</a></td>";
    echo "<td>".$row->start_time."</td>";
    echo "<td>".$row->end_time."</td>";
    $cid=$row->contest_id;
    $user_id=$_SESSION['user_id'];
    if (isset($_SESSION['groups']) && $_SESSION['groups']<=-4 || ($row->owner_id==$user_id)){
        echo "<td><a href='contest_private_change.php?cid=$cid'>".($row->private==0?"<span class=green>公开</span>":"<span class=red>私人</span>")."</a></td>";
        echo "<td><a href='contest_status_change.php?cid=$cid'>".($row->hide==0?"<span class=green>可见</span>":"<span class='red'>不可见</span>")."</a></td>";
        echo "<td><a href='contest_edit.php?cid=$cid'>编辑</a></td>";
    }
    echo "</tr>";
}
echo "</table></center>";
?>
<div class="center">
    <?php require ("../footer.php"); ?>
</div>
</body>
</html>
