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
echo "<head><title>����������������� - ���������� ip-������: $sitename</title>";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\">";
include("top.php");
$err2="�� ������� �� ������ ip-������!<br>";
$err3="�������� ������ ip-������!<br>";
$error = "";
$result = @mysql_query("SELECT pass FROM $admintable");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
if (!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass)
{
echo "<center><b>�� �� <a href=admin.php>��������������</a>!</b><br><br>";
}
else
{ // ok
if ($_SERVER[QUERY_STRING] != "del"){
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
$result = @mysql_query("SELECT ID,bunsip FROM $bunsiptable order by bunsip");
$totalThread = @mysql_num_rows($result);
echo "<center><p><strong><big>����������������� - ����������/������������� ip-�������</strong></big><p>";
echo "����� ���������������: <b>$totalThread</b></p>";
echo "<form name=delreg method=post action=adminbl.php?del><center>";
$result = @mysql_query("SELECT * FROM $bunsiptable order by bunsip");
while($myrow=mysql_fetch_array($result)) {
$ID=$myrow["ID"];
$bunsip=$myrow["bunsip"];
$bunwhy=$myrow["why"];
echo "<input type=checkbox name=delmes[] value=$ID>$bunsip (�������: $bunwhy)<br>";
}
if ($totalThread != 0)
{echo "<br><input type=submit value='�������������� ����������' name=delete><br><br>";}
echo "������� ip-�����, ������� ����� ������������� (��������, 125.0.0.125):<br><br>IP-�����: <input type=text name=ip size=20><br><br>������� ����������: <input type=text name=why size=20><br><br>����: <input type=text name=period size=20> ����<br><br><center><input type=submit value='�����������' name=addto><br><br>";
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
echo "<center><h3>������</h3><font color=red>$error</font><p><a href=# onClick=history.go(-1)>��������� �����</a><p><br><br><br><br><br><br><br><br>";
}
if ($error==""){
if (isset($_POST['delete']))
{
unset($result);
for ($i=0;$i<count($delmes);$i++){
$result=@mysql_query("delete from $bunsiptable WHERE ID=$delmes[$i]");
}
echo "<center><b>��������� ������ ��������������!</b><br><a href=adminbl.php>���������</a><p><br><br><br><br>";
}
if (isset($_POST['addto']))
{
$sql="insert into $bunsiptable (bunsip,why,period,date) values ('$ip','$why','$period',now())";
$result=@mysql_query($sql,$db);
echo "<center><b>��������� ����� ������������!</b><br><a href=adminbl.php>���������</a><p><br><br><br><br>";
}
}
}
} //ok
echo "<center><a href=admin.php>�� ����� �������� �����������������</a><br><br>";
include("down.php");
?>