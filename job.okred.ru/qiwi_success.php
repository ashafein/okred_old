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

$order=$_GET['order'];

$hasresult = @mysql_query("SELECT * FROM $qiwitable WHERE aid='$sid' and code='$order'");
if (@mysql_num_rows($hasresult) == 0)
{
echo "<h3 align=center>���� �� ������</h3>";
}

if (@mysql_num_rows($hasresult) != 0)
{
while($myrow=mysql_fetch_array($hasresult)) {
$ID=$myrow["ID"];
$pay=$myrow["pay"];
$aid=$myrow["aid"];
}

$resultdel=@mysql_query("delete from $qiwitable WHERE ID=$ID");

$sql="update $kuponautortable SET pay=pay+'$pay' WHERE ID='$aid'";
$result=@mysql_query($sql,$db);

$resultstat=@mysql_query("insert into $kuponstattable (price,aid,payfrom,payto,status,date,comment) values ('$pay','$aid','','','in',now(),'���������� �� ���� ������������ $aid ����� qiwi (������ $order)')");

echo "<p align=center>������ $pay ���. �������� �� ����<br/><br/><a href=autor.php>��������� � ������ ������</a></p>";
}
include("down.php");
?>