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
echo "<head><title>����������������� : $sitename</title>";
include("top.php");
echo "<center><h3>�����������������</h3>";
$result = @mysql_query("SELECT pass FROM $admintable");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
$err2 = "�� ��������� ������������ ���� - ������!<br>";
$err3 = "�������� ������!<br>";
$error = "";
if ($_SERVER[QUERY_STRING] == "admin") {
$apass=$_POST['apass'];
$newpass=$_POST['newpass'];

if ($apass == "") {$error .= "$err2";}
if ($newpass != 1 and $adminpass != $apass) {
	$error .= "$err3";}
echo "<center><font color=red>$error</font></center>";
}
if (($_SERVER[QUERY_STRING] != "admin" or $error != "") and ($_SESSION['uid'] != $adminpass or $_SESSION['uid']=='')) {
if (mysql_connect($bdhost,$bdlogin,$bdpass) and $adminpass == "")
{
echo ("
<p>������ �������������� �� �����. ���������� ��� ������:
<form method=post action=\"admin.php?admin\">
<input type=hidden name=newpass value=1>
<table>
<tr><td align=right valign=top><strong>������:</strong></td>
<td><input type=password name=\"apass\" size=20></td></tr>
</table>
<center><p><input type=submit value=����� name=\"submit\">
</form><p>
");
}
if ($adminpass != "")
{
echo ("
<p>��� ����� �� �������� ����������������� ������� ������:
<form method=post action=\"admin.php?admin\">
<table>
<tr><td align=right valign=top><strong>������:</strong></td>
<td><input type=password name=\"apass\" size=20></td></tr>
</table>
<center><p><input type=submit value=����� name=\"submit\">
</form><p>
");
}
}
if (($_SERVER[QUERY_STRING] == "admin" and $error == "") or (isset($_SESSION['uid']) and $_SESSION['uid'] == $adminpass)) {
if ($newpass==1)
{
unset($result);
$sql="update $admintable SET pass='$apass'";
$result=mysql_query($sql,$db);
}
if (isset($apass)) {$_SESSION['uid']=$apass;}
$result = @mysql_query("SELECT status FROM $promotable WHERE status='wait'");
$tot3 = @mysql_num_rows($result);
echo ("
<form method=post action=\"admin.php?confirm\">
<div class=tbl1>
<p align=center>�������� ����������� ��������:<br><br>
<b>������/�������/������, �������:</b><br>
<li><a href=admincity.php>�������������� �����-��������-�������</a><br>
<li><a href=adminmet.php>�������������� ������� �����</a><br>
<li><a href=adminmc.php>�������������� ��������</a><br>
<br>
<b>������������</b><br>
<li><a href=adminda.php>������� ������������</a><br>
<li><a href=admincat.php>��������/��������� �� �������� ��������/�������������</a><br>
<li><a href=adminmes.php>��������� �������������</a><br>
<br>
<b>������ � ���������:</b><br>
<li><a href=adminrabc.php>�������� �������</a><br>
<br>
<b>��������</b><br>
<li><a href=adminov.php>�������� ��������</a><br>
<li><a href=admindv.php>�������/������������� ��������</a><br>
<li><a href=admindov.php>���������� �������� ���</a><br>
<li><a href=admindsv.php>��������/�������� �������� �� ��������</a><br>
<br>
<b>������</b><br>
<li><a href=adminor.php>�������� ������</a><br>
<li><a href=admindr.php>�������/������������� ������</a><br>
<li><a href=admindor.php>���������� ������ ���</a><br>
<li><a href=admindsr.php>��������/�������� �������� �� ������</a><br>
<br>
<b>������</b><br>
<li><a href=adminmct.php>�������������� �������� ������</a><br>
<li><a href=adminat.php>�������� ������</a><br>
<li><a href=admindt.php>�������/������������� ������</a><br>
<li><a href=adminc.php>�������� ������������ � �������</a><br>
<br>
<b>������-�����</b><br>
<li><a href=adminfaq.php?action=new>FAQ - ����� �������</a><br>
<li><a href=adminfaq.php?action=view>FAQ - �������� ����������</a><br>
<br>
<b>�������</b><br>
<li><a href=adminews.php?action=add>�������� �������</a><br>
<li><a href=adminews.php?action=view>�������� / �������� ��������</a><br>
<br>
<b>�������</b><br>
<li><a href=adminpra.php>�������� ��������� ����</a><br>
<li><a href=adminpro.php>�������� / �������� ��������� ������</a><br>
<li><a href=adminprok.php>�������� ��������� ����� �������������</a> (<b>$tot3</b>)<br>
<br>
<b>�����:</b><br>
<li><a href=adminnew.php>�������� �����</a><br>
<li><a href=adminnd.php>������������� �����</a><br>
<li><a href=adminrep.php>�������� �����</a><br>
<li><a href=adminrd.php>������������� ������</a><br>
<li><a href=adminmca.php>�������������� ��������</a><br>
<li><a href=adminzav.php>�������� ����������</a><br>
<li><a href=adminzd.php>������������� ����������</a><br>
<br>
<li><a href=adminrs.php>���������� ���������</a><br>
<li><a href=forumadm.php>�����</a><br>
<li><a href=adminbl.php>����������� ip-�����</a><br>
<li><a href=admincp.php>�������� ������</a><br>
<br>
<li><a href=adminzha.php>������</a><br>
<br>
</p>
</div>
");
}
include("down.php");
?>