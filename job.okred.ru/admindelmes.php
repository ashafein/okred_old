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
echo"<title>�������� ��������� : $sitename</title>";
include("top.php");
?>
<h3><center><strong>�������� ���������</strong></center></h3>
<?php
$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);
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
if ($_SERVER[QUERY_STRING] == "del") {
$link=$_POST['link'];
$foto1="mes$link.jpg";
$foto2="mes$link.gif";
@unlink($upath.$photodir.$foto1);
@unlink($upath.$photodir.$foto2);
@unlink($upath.$photodir.'s'.$foto1);
@unlink($upath.$photodir.'s'.$foto2);
$sql="delete from $messagetable where ID=$link";
$result=@mysql_query($sql,$db);
}
if ($_SERVER[QUERY_STRING] != "del") {
echo ("
<form name=form method=post action=admindelmes.php?del>
<input type=hidden name=link value=$link>
<center><table width=90%>
<tr><td align=center>
��� ����, ����� ������� ���������, ������� ������ \"�������\".<br><br>
<input type=submit value=\"�������\" name=\"delete\">
</td></tr>
</table></form>
");
}
else {
echo "<br><br><h3 align=center>��������� �������!</h3><br><br>";
}
} //ok
echo "<center><a href=admin.php>�� ����� �������� �����������������</a><br><br>";
include("down.php");
?>