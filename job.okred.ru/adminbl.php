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

<?php
include("var.php");
echo "<head><title>Администрирование - Блокировка ip-адреса: $sitename</title>";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\">";
include("top.php");
$err2="Не выбрано ни одного ip-адреса!<br>";
$err3="Неверный формат ip-адреса!<br>";
$error = "";
$result = @mysql_query("SELECT pass FROM $admintable");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
if (!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass)
{
echo "<center><b>Вы не <a href=admin.php>авторизированы</a>!</b><br><br>";
}
else
{ // ok
if ($_SERVER[QUERY_STRING] != "del"){
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
$result = @mysql_query("SELECT ID,bunsip FROM $bunsiptable order by bunsip");
$totalThread = @mysql_num_rows($result);
echo "<center><p><strong><big>Администрирование - Блокировка/Разблокировка ip-адресов</strong></big><p>";
echo "Всего заблокированных: <b>$totalThread</b></p>";
echo "<form name=delreg method=post action=adminbl.php?del><center>";
$result = @mysql_query("SELECT * FROM $bunsiptable order by bunsip");
while($myrow=mysql_fetch_array($result)) {
$ID=$myrow["ID"];
$bunsip=$myrow["bunsip"];
$bunwhy=$myrow["why"];
echo "<input type=checkbox name=delmes[] value=$ID>$bunsip (Причина: $bunwhy)<br>";
}
if ($totalThread != 0)
{echo "<br><input type=submit value='Разблокировать отмеченные' name=delete><br><br>";}
echo "Введите ip-адрес, который нужно заблокировать (Например, 125.0.0.125):<br><br>IP-адрес: <input type=text name=ip size=20><br><br>Причина блокировки: <input type=text name=why size=20><br><br>Срок: <input type=text name=period size=20> дней<br><br><center><input type=submit value='Блокировать' name=addto><br><br>";
echo ("
</form>
");
}
if ($_SERVER[QUERY_STRING] == "del"){
$delmes=$_POST['delmes'];
$ip=$_POST['ip'];
$why=$_POST['why'];
$period=$_POST['period'];
$addto=$_POST['addto'];
if (count($delmes)==0 and $ip=="") {
	$error .= "$err2";}
if (isset($addto) and !ereg("^[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+$",$ip)) {
	$error .= "$err3";}
if ($error != ""){
echo "<center><h3>Ошибка</h3><font color=red>$error</font><p><a href=# onClick=history.go(-1)>Вернуться назад</a><p><br><br><br><br><br><br><br><br>";
}
if ($error==""){
if (isset($_POST['delete']))
{
unset($result);
for ($i=0;$i<count($delmes);$i++){
$result=@mysql_query("delete from $bunsiptable WHERE ID=$delmes[$i]");
}
echo "<center><b>Выбранные адреса разблокированы!</b><br><a href=adminbl.php>Вернуться</a><p><br><br><br><br>";
}
if (isset($_POST['addto']))
{
$sql="insert into $bunsiptable (bunsip,why,period,date) values ('$ip','$why','$period',now())";
$result=@mysql_query($sql,$db);
echo "<center><b>Указанный адрес заблокирован!</b><br><a href=adminbl.php>Вернуться</a><p><br><br><br><br>";
}
}
}
} //ok
echo "<center><a href=admin.php>На общую страницу администрирования</a><br><br>";
include("down.php");
?>