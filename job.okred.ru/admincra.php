<?
session_start();
session_register("uid");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<?php
include("var.php");
echo"<title>��������� ������� : $sitename</title>";
include("top.php");
?>
<h3><center><strong>��������� �������</strong></center></h3>
<?php
$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);
$result = @mysql_query("SELECT pass FROM $admintable");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
$err10 = "�� ��������� ������������ ���� - ������������ �������!<br>";
$error = "";
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
if (!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass)
{
echo "<center><b>�� �� <a href=admin.php>��������������</a>!</b><br><br>";
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
$result = @mysql_query("SELECT * FROM $afishacatable WHERE ID = '$id'");
if ($c=='r')
{
while ($myrow=mysql_fetch_array($result)) {
$oldname=$myrow["category"];
$newname=$myrow["category"];
}
}
echo "<center><font color=red>$error</font></center>";
} //2
if ($_SERVER[QUERY_STRING] == "add") {
$newname=$_POST['newname'];
if ($newname == "") {$error .= "$err10";}
echo "<center><font color=red>$error</font></center>";
if ($_SERVER[QUERY_STRING] == "add" and $error == "") {
$result = @mysql_query("SELECT * FROM $afishacatable WHERE ID = '$id'");
if ($c=='r')
{
while ($myrow=mysql_fetch_array($result)) {
$oldname=$myrow["category"];
}
$sql="update $afishacatable SET category='$newname' WHERE category='$oldname'";
}
$result=@mysql_query($sql,$db);
}
}
if ($_SERVER[QUERY_STRING] != "add" or $error != "") {
echo ("
<form name=form method=post ENCTYPE=\"multipart/form-data\" action=admincra.php?add>
<input type=hidden name=id value=$id>
<input type=hidden name=c value=$c>
<center>��������:&nbsp;<input type=text name=newname size=30 value=\"$newname\">
");
echo "<center><p><input type=submit value=\"��������\" name=\"submit\"></form>";
echo "<center><a href=admin.php>�� ����� �������� �����������������</a><br><br>";
}
else {
echo "<br><br><h3 align=center>��������� ���������!</h3><p align=center><a href=adminmca.php>�� �������� �������������� ��������</a><br><br><a href=admin.php>�� �������� �����������������</a></p><br><br>";
}
} //firmid
if (!isset($id) or $id=='')
{
echo "<center><br><br><h3>������ �� ���������!</h3><b><a href=adminmca.php>���������</a></b><br><br>";
}
} //ok
include("down.php");
?>