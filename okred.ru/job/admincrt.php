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
<?php
include("var.php");
echo"<title>Изменение раздела : $sitename</title>";
include("top.php");
?>
<h3><center><strong>Изменение раздела</strong></center></h3>
<?php
$result = @mysql_query("SELECT pass FROM $admintable");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
$err10 = "Не заполнено обязательное поле - Наименование раздела!<br>";
$error = "";
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
if (!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass)
{
echo "<center><b>Вы не <a href=admin.php>авторизированы</a>!</b><br><br>";
}
else
{ // ok
if ($_GET['id'] == '') {$id=$_POST['id'];}
elseif ($_GET['id'] != '') {$id=$_GET['id'];}
if ($_GET['c'] == '') {$c=$_POST['c'];}
elseif ($_GET['c'] != '') {$c=$_GET['c'];}
if (isset($id) and $id != '')
{ //firmid
if ($_SERVER[QUERY_STRING] != "add")
{ //2
$result = @mysql_query("SELECT * FROM $textcatable WHERE ID = '$id'");
if ($c=='r')
{
while ($myrow=mysql_fetch_array($result)) {
$oldname=$myrow["genre"];
$newname=$myrow["genre"];
}
}
echo "<center><font color=red>$error</font></center>";
} //2
if ($_SERVER[QUERY_STRING] == "add") {
$newname=$_POST['newname'];
if ($newname == "") {$error .= "$err10";}
echo "<center><font color=red>$error</font></center>";
if ($_SERVER[QUERY_STRING] == "add" and $error == "") {
$result = @mysql_query("SELECT * FROM $textcatable WHERE ID = '$id'");
if ($c=='r')
{
while ($myrow=mysql_fetch_array($result)) {
$oldname=$myrow["genre"];
}
$sql="update $textcatable SET genre='$newname' WHERE genre='$oldname'";
}
$result=@mysql_query($sql,$db);
}
}
if ($_SERVER[QUERY_STRING] != "add" or $error != "") {
echo ("
<form name=form method=post ENCTYPE=\"multipart/form-data\" action=admincrt.php?add>
<input type=hidden name=id value=$id>
<input type=hidden name=c value=$c>
<center>Название:&nbsp;<input type=text name=newname size=30 value=\"$newname\">
");
echo "<center><p><input type=submit value=\"Изменить\" name=\"submit\"></form>";
echo "<center><a href=admin.php>На общую страницу администрирования</a><br><br>";
}
else {
echo "<br><br><h3 align=center>Изменения сохранены!</h3><p align=center><a href=adminmct.php>На страницу редактирования разделов</a><br><br><a href=admin.php>На страницу администрирования</a></p><br><br>";
}
} //firmid
if (!isset($id) or $id=='')
{
echo "<center><br><br><h3>Раздел не определен!</h3><b><a href=adminmct.php>Вернуться</a></b><br><br>";
}
} //ok
include("down.php");
?>