<?
session_start();
session_register("uid");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<!--/***************** DO NOT REMOVE! *********************/---->
<!--/*   Author: Nevezhyn Evgeny  Date : 11/06/2005       */---->
<!--/*   nevius@bk.ru      All Rights Reserved ...        */---->
<!--/*   http://nevius.ru/                                */---->
<!--/***************** DO NOT MODIFY! *********************/---->

<head>
<META NAME=ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<?php
include("var.php");
$maxThread = 20;
echo "<title>Администрирование - Удаление ссылок: $sitename</title>";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\">";
include("top.php");
$err1="Неверный пароль!<br>";
$err2="Не выбрано ни одной ссылки!<br>";
$error = "";
$uu=$_SESSION['uid'];
$result = @mysql_query("SELECT * FROM $admintable where pass = '$uu'");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
$vacconfirm=$myrow["vacconfirm"];
$vacdel=$myrow["vacdel"];
$resconfirm=$myrow["resconfirm"];
$resdel=$myrow["resdel"];
$userdel=$myrow["userdel"];
$main=$myrow["main"];
}
if ((!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass) and ($main != 'main'))
{
echo "<center><b>Вы не <a href=admin.php>авторизированы</a>!</b><br><br>";
}
else
{ // ok
echo "<center><p><strong><big>Администрирование - Удаление ссылок</strong></big>";
echo "<form name=delreg method=post action=adminmpd.php?confirm>";
if ($_SERVER[QUERY_STRING] != "confirm") 
{
$result = @mysql_query("SELECT * FROM $mainpagetable WHERE status='ok' order by date DESC");
$totaltexts=@mysql_num_rows($result);
if ($totaltexts == 0) {echo "<center><b>Нет ссылок!</b>";}
else
{ //2
echo "<center>Всего агентств: <b>$totaltexts</b><br><br>";
echo ("
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$maincolor><td><img src=\"picture/basket.gif\" border=0></td><td>Агентство</td><td>Ссылка</td><td>Дата публ.</td><td>Статус проверки</td></tr>
");
while ($myrow=mysql_fetch_array($result)) 
{ //4
$ID=$myrow["ID"];
$url=$myrow["url"];
$date=$myrow["date"];
$checked=$myrow["checked"];
$aid=$myrow["aid"];
$resultaut = @mysql_query("SELECT * FROM $autortable WHERE ID='$aid'");
while ($myrow1=mysql_fetch_array($resultaut)) {
$firm=$myrow1["firm"];
$category=$myrow1["category"];
}
if ($checked=='ok') {$statusline='<font color=green>Работает</font>';}
if ($checked=='') {$statusline='<font color=red>Не работает</font>';}
echo ("
<tr bgcolor=$maincolor>
<td valign=top width=20><input type=checkbox name=confmes[] value=$ID></td>
<td valign=top><a href=agency.php?id=$aid target=_blank><b>$firm</b></a></td>
<td valign=top><a href=$url target=_blank>$url</a></td>
<td valign=top>$date</td>
<td valign=top>$statusline</td>
</tr>
");
} //4
echo "</table></td></tr></table>";
echo ("
<br><center><input type=submit name=delete value='Удалить отмеченные'><br><br>
");
} //2
echo "</form>";
}
}
if ($_SERVER[QUERY_STRING] == "confirm"){
$confmes=$_POST['confmes'];
if (count($confmes)==0) {
	$error .= "$err2";}
if ($error != ""){
echo "<center><h3>Ошибка</h3><font color=red>$error</font><p><a href=# onClick=history.go(-1)>Вернуться назад</a><p><br><br><br><br><br><br><br><br>";
}
if ($error==""){
if ($_SERVER[QUERY_STRING] == "confirm" and isset($_POST['delete'])) {
for ($i=0;$i<count($confmes);$i++){
$result=@mysql_query("delete from $mainpagetable where ID=$confmes[$i]");
}
echo "<br><br><h3 align=center>Выбранные ссылки удалены!</h3><br><br>";
}

}
} //ok
echo "<center><a href=admin.php>На общую страницу администрирования</a><br><br>";
include("down.php");
?>