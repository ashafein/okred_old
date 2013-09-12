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
echo"<title>Удаление сообщения : $sitename</title>";
include("top.php");
?>
<h3><center><strong>Удаление сообщения</strong></center></h3>
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
echo "<center><br><br><h3>Вы не авторизированы!</h3><b><a href=autor.php>Авторизация</a></b>";
}
else
{//1
if ($_SERVER[QUERY_STRING] == "del") {
$link=$_POST['link'];
$foto1="mes$link.jpg";
$foto2="mes$link.gif";
@unlink($upath.$photodir.$foto1);
@unlink($upath.$photodir.$foto2);
@unlink($upath.$photodir.'s'.$foto1);
@unlink($upath.$photodir.'s'.$foto2);
$sql="delete from $messagetable where ID=$link and tid=$sid";
$result=@mysql_query($sql,$db);
echo "<br><br><h3 align=center>Сообщение удалено!</h3><br><br><br><br><p align=center><a href=autor.php>Вернуться в личный раздел</a></p><br><br>";
}
if ($_SERVER[QUERY_STRING] != "del") {
$link=$_GET['link'];
echo ("
<form name=form method=post action=delmes.php?del>
<input type=hidden name=link value=$link>
<center><table width=90%>
<tr><td align=center>
Для того, чтобы удалить сообщение, нажмите кнопку \"Удалить\".<br><br>
<input type=submit value=\"Удалить\" name=\"delete\">
</td></tr>
</table></form>
");
echo "<br><br><p align=center><a href=autor.php>Вернуться в личный раздел</a></p>";
}
} //1
include("down.php");
?>