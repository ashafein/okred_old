<?
session_start();
?>
<!--/***************** DO NOT REMOVE! *********************/---->
<!--/*   Author: Nevezhyn Evgeny  Date : 25/02/2003       */---->
<!--/*   nevius@bk.ru      All Rights Reserved ...        */---->
<!--/*   http://nevius.ru/                                */---->
<!--/***************** DO NOT MODIFY! *********************/---->

<html><head>
<?php
include("var.php");
echo"<title>������������ �� ���� : $sitename</title>";
include("top.php");
?>
<h3><center><strong>������������ �� ����</strong></center></h3>
<?php
$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);
$sid=$_SESSION['sid'];
$slogin=$_SESSION['slogin'];
$spass=$_SESSION['spass'];
$id=$sid;
$result = @mysql_query("SELECT email,pass FROM $autortable WHERE (email = '$slogin' and pass = '$spass')");
if ((!isset($slogin) or !isset($spass)) or @mysql_num_rows($result) == 0)
{
echo "<center><br><br><h3>�� �� ��������������!</h3><b><a href=autor.php>�����������</a></b>";
}
else
{//1
if ($_SERVER[QUERY_STRING] == "del") {
$link=$_POST['link'];

$result = @mysql_query("SELECT * FROM $messagetable WHERE ID='$link'");
while ($myrow=mysql_fetch_array($result)) {
$mesID=$myrow["ID"];
$tid=$myrow["tid"];
$aid=$myrow["aid"];
$date=$myrow["date"];
$comment=$myrow["comment"];
}
if ($aid == '0') {$sender = "�������������";}
if ($aid != '0') {$sender = "������������ ID: $aid";}
if ($tid == '0') {$recip = "�������������";}
if ($tid != '0') {$recip = "������������ ID: $tid";}
$txt="������ �� ���� � ��������� �� ����� $siteadress<br><br>��������� (ID:$mesID): $comment<br>�����������: $sender<br>����������: $recip<br>����: $date";
mail($adminemail,"������ �� ���� � ���������",$txt,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/html; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");


echo "<br><br><h3 align=center>������ ����������!</h3><p align=center>������������� �������� ���� ������ � ����� � ������ ��������������� ����<a href=autor.php>��������� � ������ ������</a></p><br><br>";
}
if ($_SERVER[QUERY_STRING] != "del") {
$link=$_GET['link'];
echo ("
<form name=form method=post action=messpam.php?del>
<input type=hidden name=link value=$link>
<center><table width=90%>
<tr><td align=center>
��� ����, ����� ��������� ������ �� ���������, ������� ������ \"���� � ���������\".<br><br>
<input type=submit value=\"���� � ���������\" name=\"delete\">
</td></tr>
</table></form>
");
echo "<br><br><p align=center><a href=autor.php>��������� � ������ ������</a></p>";
}
} //1
include("down.php");
?>