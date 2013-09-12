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

<head>
<?php
include("var.php");
echo"<title>Фотография : $sitename</title>";
$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);

$f=$_GET['f'];
$link=$_GET['link'];
$w=$_GET['w'];

if (!isset($f) or !isset($link) or $link=='' or $f == '' or $w == '') {
echo "<center><br><br><b>Фотография не определена</b>";
}
else
{
if ($w=='r')
{$result = @mysql_query("SELECT * FROM $restable WHERE ID = '$link' and status='ok'");}
if ($w=='a')
{$result = @mysql_query("SELECT * FROM $autortable WHERE ID = '$link' and status='user'");}
if (@mysql_num_rows($result) == 0) {
echo "<center>Объявление не определено!<br><br><a href=# onClick=history.go(-1)>Вернуться назад</a><br><br>";
}
else
{
while ($myrow=mysql_fetch_array($result)) 
{
$ID=$myrow["ID"];
$foto1=$myrow["foto1"];
}
echo "<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=4 width=100%>";
echo ("
<tr bgcolor=$maincolor><td colspan=2 align=center><b>Фотография:</b><br><br>
");
echo "<img src=\"$f\" border=0><br><br>";
echo "</td></tr>";
echo "</table></td></tr></table><br><br>";
}
}
?>