<?php
session_start();
?>
<html><head>
<?php
include("var.php");
echo"<title>������ �������� �� ���� : $sitename</title>";
include("top.php");

$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);

$spAmount=$_POST['spAmount'];
$spUserDataUserId=$_POST['spUserDataUserId'];

$sql="update $autortable SET pay=pay+'$spAmount' WHERE ID='$spUserDataUserId'";
$result=@mysql_query($sql,$db);

echo "<p align=center>������ �������� �� ����<br/><br/><a href=autor.php>��������� � ������ ������</a></p>";
include("down.php");
?>