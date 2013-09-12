<?
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<?php
include("var.php");
echo"<title>Добавленные менеджеры : $sitename</title>";
include("top.php");
?>
<h3><center><strong>Добавленные менеджеры</strong></center></h3>
<?php
$sid=$_SESSION['sid'];
$id=$_SESSION['sid'];
$slogin=$_SESSION['slogin'];
$spass=$_SESSION['spass'];

$result = @mysql_query("SELECT email,pass FROM $autortable WHERE (email = '$slogin' and pass = '$spass')");
if ((!isset($slogin) or !isset($spass)) or @mysql_num_rows($result) == 0)
{
echo "<center><br><br><h3>Вы не авторизированы!</h3><b><a href=autor.php>Авторизация</a></b>";
}
else
{ //1
if ($_SERVER[QUERY_STRING] != "delete")
{ //3
$result = @mysql_query("SELECT * FROM $autortable WHERE moder = '$id' order by ID DESC");
$totaltexts=@mysql_num_rows($result);
if ($totaltexts == 0) {
echo "<p align=center class=tbl1>Вы не разместили ни одного менеджера!<br><br><a href=moderaf.php>Добавить</a></p>";
}
else
{ //2

$delline = '<br><input type=submit name=delob value="Удалить отмеченные" class=i3>';
echo "<p align=center class=tbl1>Всего : <b>$totaltexts</b></p>";
echo ("
<div align=center><form name=deltext method=post action=moderda.php?delete>
<table border=0 width=740 bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$maincolor><td><img src=\"picture/basket.gif\" border=0></td><td>Контактное лицо</td><td>Должность</td><td>Кол-во вакансий</td></tr>
");
while ($myrow=mysql_fetch_array($result)) 
{ //4
$tID=$myrow["ID"];
$prof=$myrow["prof"];
$fio=$myrow["fio"];
$resultadd1 = @mysql_query("SELECT ID,aid FROM $vactable WHERE aid='$tID'");
$totaltexts=@mysql_num_rows($resultadd1);
echo ("
<tr bgcolor=$maincolor>
<td valign=top width=20><input type=checkbox name=delmes[] value=$tID></td>
<td valign=top>$fio</td>
<td valign=top>$prof</td>
<td valign=top>$totaltexts</td>
</tr>
");
} //4
echo "</table></td></tr></table>";
echo ("
<br><br>Переместить удаляемые вакансии:<br>
<select name=komu size=1>
<option selected value=\"me\">Себе</option>
");
$result = @mysql_query("SELECT * FROM $autortable WHERE moder = '$id' order by ID DESC");
while ($myrow=mysql_fetch_array($result)) 
{
$uID=$myrow["ID"];
$fio=$myrow["fio"];
echo "<option value=\"$uID\">$fio</option>";
}
echo ("
<option selected value=\"del\">Удалить вакансии</option>
</select><br><br>
$delline<br><br>
");

echo ("
</form></div><p align=center class=tbl1><a href=autor.php>Вернуться в авторский раздел</a></p><p>
");
} //2
} //3
if ($_SERVER[QUERY_STRING] == "delete") {
$delmes=$_POST['delmes'];
$komu=$_POST['komu'];
$totob=count($delmes);
if (count($delmes)==0) {
	$error .= "Не выбрано ни одного менеджера!<br>";}
if ($error != ""){
echo "<center><h3>Ошибка</h3><font color=red>$error</font><p><a href=autor.php>Вернуться назад</a><p><br><br><br><br><br><br><br><br>";
}
if ($error == ""){
if (isset($_POST['delob']))
{ // del
for ($i=0;$i<count($delmes);$i++){
if ($komu == 'me')
{
$result=@mysql_query("update $vactable SET aid='$sid' where aid='$delmes[$i]'");
}
if ($komu == 'del')
{
$result=@mysql_query("delete from $autortable where aid='$delmes[$i]'");
}
if ($komu != 'del' and $komu != 'me')
{
$result=@mysql_query("update $vactable SET aid='$komu' where aid='$delmes[$i]'");
}
$result=@mysql_query("delete from $autortable where ID=$delmes[$i] and category='moder'");
}
echo "<p align=center class=tbl1><h3>Выбранные менеджеры удалены!</h3><a href=autor.php>Вернуться в авторский раздел</a></p><br><br>";
} // del

}
}
}//1
include("down.php");
?>