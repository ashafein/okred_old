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
echo "<title>����������������� - ���������� ���������: $sitename</title>";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\">";
include("top.php");
$result = @mysql_query("SELECT pass FROM $admintable");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
$error = "";
if (!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass)
{
echo "<center><b>�� �� <a href=admin.php>��������������</a>!</b><br><br>";
}
else
{ // ok
if ($_SERVER[QUERY_STRING] != "del"){
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
$totalThread = 0;
echo "<center><p><strong><big>����������������� - ���������� ���������</strong></big><p>";
$resl = @mysql_query("SELECT name,date,status FROM $rassilka WHERE name='admin'");
while ($myrow=mysql_fetch_array($resl)) 
{
$status=$myrow["status"];
}
echo "<form name=delreg method=post action=adminrs.php?del><center>";
if ($status=='on') {$statusline='<font color=green><b>�������</b></font>';$stc='<input type=submit value=��������� name=off>';}
if ($status=='off') {$statusline='<font color=red><b>���������</b></font>';$stc='<input type=submit value=�������� name=on>';}
echo "<hr width=60% size=1>�������������� ��������:&nbsp;$statusline<br>$stc<br><br><hr width=60% size=1>";
echo ("
</form>
");
}
if ($_SERVER[QUERY_STRING] == "del")
{ //del
if ($error != ""){
echo "<center><h3>������</h3><font color=red>$error</font><p><a href=# onClick=history.go(-1)>��������� �����</a><p><br><br><br><br><br><br><br><br>";
}
if ($error=="")
{ //err
if (isset($_POST['on']))
{
unset($result);
$sql="update $rassilka SET status='on' WHERE name='admin'";
$result=@mysql_query($sql,$db);
echo "<center><b>�������� ������������!</b><br><br>";
}
if (isset($_POST['off']))
{
unset($result);
$sql="update $rassilka SET status='off' WHERE name='admin'";
$result=@mysql_query($sql,$db);
echo "<center><b>�������� ��������������!</b><br><br>";
}
} //err
} //del
} //ok
echo "<center><a href=admin.php>�� ����� �������� �����������������</a><br><br>";
include("down.php");
?>