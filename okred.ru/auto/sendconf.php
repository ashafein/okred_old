<?
session_start();
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
echo "<head><title>������������� ����������� : $sitename</title>";
include("top.php");
echo "<center><h3>������������� �����������</h3>";
$err1 = "�� ��������� ������������ ���� - Email!<br>";
$err2 = "�� ��������� ������������ ���� - ������!<br>";
$err3 = "������������ ������ ��� email! ��������� ������������ ����� ������ � email (� ������ ��������)<br>";
$err6 = "�� �� ��������������!<br>";
$error = "";
if ($_SERVER[QUERY_STRING] == "autor") {
$alogin=$_POST['alogin'];
$apass=$_POST['apass'];
if ($alogin == "") {$error .= "$err1";}
if ($apass == "") {$error .= "$err2";}
$result = @mysql_query("SELECT ID,email,pass FROM $autortable WHERE ((email = '$alogin' and pass = '$apass') or (ID = '$id' and pass = '$apass'))");
if (@mysql_num_rows($result) == 0) {$error .= "$err3";}
unset($result);
echo "<center><font color=red>$error</font></center>";
}
if ($_SERVER[QUERY_STRING] != "autor" or $error != "") {
echo ("
<p>��� ����� � ������ ������ ������� E-mail � ������:
<form method=post action=\"sendconf.php?autor\">
<table>
<tr><td align=right><strong>E-mail:</strong></td>
<td><input type=text name=\"alogin\" size=30><td></tr>
<tr><td align=right valign=top><strong>������:</strong></td>
<td><input type=password name=\"apass\" size=30><br><small><a href=recpass.php>������ ������</a></small></td></tr>
</table>
<center><p><input type=submit value=������� ��� name=\"submit\" class=i3>
<br><br><a href=registr.php>�����������</a><br><br>
</form>
");
}
if ($_SERVER[QUERY_STRING] == "autor" and $error == "") {
$result = @mysql_query("SELECT ID,email,email,pass,status,code FROM $autortable WHERE (email = '$alogin' and pass = '$apass')");
while ($myrow=mysql_fetch_array($result)) {
$email=$myrow["email"];
$code=$myrow["code"];
}
$codetxt="������������!<br>��� ������ ������� ��� � ����� � ������������ �� ����� <a href=$siteadress>$sitename</a><br><br>��� ���������� ����������� ���������� ������ �� ������:<br><br><a href=\"$siteadress/confirm.php?login=$email&code=$code\">$siteadress/confirm.php?login=$email&code=$code</a><br><br>���� ����� �� �������� <a href=\"$siteadress/confirm.php\">$siteadress/confirm.php</a> � ������ ��������� ������:<br>E-mail: $alogin<br>��� ���������: $code<br><br>���� �� �� ������ ������� � ��� ���� ����, �� ������ ������� ��� ������.<br><br>������� �� ����������� ����� ������!<br><br>� ���������,<br>$sitename<br><a href=mailto:$adminemail>$adminemail</a><br><a href=$siteadress>$siteadress</a>";
mail($email,"������������� �����������",$codetxt,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/html; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");
echo "<p align=center>�� ��� email-����� ������� ������ � �������������� �����������!</p><br><br>";
}
include("down.php");
?>