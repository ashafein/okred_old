<?php
session_start();
?>
<html><head>
<?php
include("var.php");
echo"<title>Платеж зачислен на счет : $sitename</title>";
include("top.php");

$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);

$order=$_GET['order'];

$hasresult = @mysql_query("SELECT * FROM $qiwitable WHERE aid='$sid' and code='$order'");
if (@mysql_num_rows($hasresult) == 0)
{
echo "<h3 align=center>Счет не найден</h3>";
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

$resultstat=@mysql_query("insert into $kuponstattable (price,aid,payfrom,payto,status,date,comment) values ('$pay','$aid','','','in',now(),'Зачисление на счет пользователя $aid через qiwi (платеж $order)')");

echo "<p align=center>Платеж $pay руб. зачислен на счет<br/><br/><a href=autor.php>Вернуться в личный раздел</a></p>";
}
include("down.php");
?>