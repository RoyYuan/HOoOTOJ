<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Content-Language" content="zh-cn">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Problem List</title>
    <link rel=stylesheet href='admin.css' type='text/css'>
    <script src="../js/jquery.js"></script>
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
if (isset($_GET['keyword']))
    $keyword=$_GET['keyword'];
else
    $keyword="";
$keyword=mysqli_real_escape_string($mysqli,$keyword);
$sql="SELECT MAX(`problem_id`) AS upid FROM `problems`";
$page_cnt=100;
$result=mysqli_query($mysqli,$sql);
echo mysqli_error($mysqli);
$row=mysqli_fetch_object($result);
$cnt=intval($row->upid);
$cnt=intval($cnt/$page_cnt)+(($cnt%$page_cnt)>0?1:0);
if (isset($_GET['page'])){
    $page=intval($_GET['page']);
}
else{
    $page=$cnt;
}
$page_start=$page_cnt*intval($page-1);
$page_end=$page_start+$page_cnt;

echo "<center><h2>Problem List</h2></center>";

echo "<form class='center' action='problem_list.php'>";
echo "题号范围：<select class='input-mini center' onchange=\"location.href='problem_list.php?page='+this.value;\">";
for ($i=1;$i<=$cnt;$i++){
    if ($i>1)
        echo '&nbsp;';
    if ($i==$page)
        echo "<option value='$i' selected>";
    else
        echo "<option value='$i'>";
    echo intval($i-1);
    echo "**</option>";
}
echo "</select>";

$sql="SELECT `problem_id`,`title`,`hide`,`owner_id` FROM `problems`
WHERE problem_id>=$page_start AND problem_id<=$page_end AND deleted=0 ORDER BY `problem_id` DESC";
if ($keyword)
    $sql="SELECT `problem_id`,`title`,`hide`,`owner_id` FROM `problems`
WHERE deleted=0 AND title LIKE '%$keyword%'";
$result=mysqli_query($mysqli,$sql) or die(mysqli_error());
?>
<form action="problem_list.php">
    关键字：<input name="keyword">
    <input style="height: 25px;" type="submit" value="搜索">
</form>
<?php
echo "<center><table class='table table-striped' width='90%' border='1'>";
echo "<form method='post' action=contest_add.php>";
//echo "<tr><td colspan='7'><input type='submit' name='problem2contest' value='添加到新的竞赛'>";
echo "<tr><td>ProblemID</td><td>Title</td><td>添加者ID</td>";
if (isset($_SESSION['groups']) && $_SESSION['groups']<=-2){
    echo "<td>Status</td><td>Edit</td><td>TestData</td><td>Delete</td></tr>";
}
for (;$row=mysqli_fetch_object($result);){
    echo "<tr>";
    echo "<td>$row->problem_id</td>";
    echo "<td><a href='../problem.php?id=$row->problem_id'>".$row->title."</a></td>";
    echo "<td>$row->owner_id</td>";
    if ((isset($_SESSION['groups']) && $_SESSION['groups']<=-3) || $_SESSION['user_id']==$row->owner_id){
        echo "<td><a href='problem_status_change.php?id=$row->problem_id'>".($row->hide==0?"<span titlc='点击以设为不可见' class=green>可见的</span>":"<span class=red title='点击以设为可见的'>不可见的</span>")."</a></td>";
        echo "<td><a href='problem_edit.php?id=$row->problem_id&owner=$row->owner_id'>编辑</a>";
        echo "<td><a href='phpfm.php?frame=3&pid=$row->problem_id'>测试数据</a>";
    }
    if ($_SESSION['groups']==-5){
        echo "<td>";?>
        <a href=# onclick='javascript::if(confirm("删除?")) location.href="problem_delete.php?id=<?php echo $row->problem_id?>";'>删除</a>
        <?php
    }
    echo "</tr>";
}
echo "</form></table></center>";
echo "<div class='center'>";
require ("../footer.php");
echo "</div>";
?>
</body>
</html>
