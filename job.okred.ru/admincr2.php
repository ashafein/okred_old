<?
session_start();
session_register("uid");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<?php
include("var.php");
echo"<title>Редактирование станции метро : $sitename</title>";
include("top.php");
echo "<h3><center><strong>Редактирование станции метро</strong></center></h3>";
$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);
$result = @mysql_query("SELECT pass FROM $admintable");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
$err10 = "Название не введено!<br>";
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
if (isset($id) and $id != '')
{ //firmid
if ($_SERVER[QUERY_STRING] != "add")
{ //2
$result = @mysql_query("SELECT * FROM $metrotable WHERE ID = '$id'");
while ($myrow=mysql_fetch_array($result)) {
$oldname=$myrow["metro"];
$newname=$myrow["metro"];
}
echo "<center><font color=red>$error</font></center>";
} //2
if ($_SERVER[QUERY_STRING] == "add") {
$newname=$_POST['newname'];
if ($newname == "") {$error .= "$err10";}
echo "<center><font color=red>$error</font></center>";
if ($_SERVER[QUERY_STRING] == "add" and $error == "") {
$result = @mysql_query("SELECT * FROM $metrotable WHERE ID = '$id'");
while ($myrow=mysql_fetch_array($result)) {
$oldname=$myrow["metro"];
}
$sql="update $metrotable SET metro='$newname' WHERE metro='$oldname'";
$result=@mysql_query($sql,$db);
}
}
if ($_SERVER[QUERY_STRING] != "add" or $error != "") {
echo ("
<form name=form method=post ENCTYPE=\"multipart/form-data\" action=admincr2.php?add>
<input type=hidden name=id value=$id>
<center>Название:&nbsp;<input type=text name=newname size=30 value=\"$newname\">
");
echo "<center><p><input type=submit value=\"Сохранить\" name=\"submit\"></form>";
}
else {
echo "<br><br><h3 align=center>Изменения сохранены</h3><p align=center><a href=adminmet.php>Вернуться</a><br><br>";
}
} //firmid
if (!isset($id) or $id=='')
{
echo "<center><br><br><h3>$t170!</h3><b><a href=adminmet.php>Вернуться</a></b><br><br>";
}
} //ok
echo "<center><a href=admin.php>На общую страницу администрирования</a><br><br>";
include("down.php");
?>