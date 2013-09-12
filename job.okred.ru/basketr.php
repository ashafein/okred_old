<?
echo ("
<table border=0 class=tbl1>
<tr><td align=center colspan=3><b>Ваши закладки:</b></td></tr>
");
$REMOTE_ADDR=$_SERVER['REMOTE_ADDR'];
$basketselectresult = @mysql_query("SELECT * FROM $resordertable WHERE (user = '$REMOTE_ADDR' and status='basket')");
if (@mysql_num_rows($basketselectresult) != 0)
{
$bpos=0;
while ($myrow=mysql_fetch_array($basketselectresult)) 
{
$unitID=$myrow["ID"];
$unit=$myrow["unit"];
$number=$myrow["number"];
$selectresult1 = @mysql_query("SELECT ID,profecy,status FROM $restable WHERE (ID = $unit and status='ok')");
while ($myrow=mysql_fetch_array($selectresult1)) 
{
$bname=$myrow["profecy"];
}
$bpos=$bpos+1;
echo "<tr><td>$bpos.</td><td><a href=\"$basketurl&d=$unit\"><img src=\"picture/remove.gif\" alt=\"Убрать закладку\" border=0></a></td><td><a href=linkres.php?link=$unit>$bname</a></td></tr>";
}
echo "<tr><td align=center colspan=3><form method=post action=orderr.php><input type=submit name=checkout value=\"Смотреть\" class=i3></td></tr></form>";
}
if (@mysql_num_rows($basketselectresult) == 0)
{
echo "<tr><td align=center>Закладок нет</td></tr>";
}
echo "</table>";
?>