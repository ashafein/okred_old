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
echo"<title>Пожаловаться на спам : $sitename</title>";
include("top.php");
?>
<h3><center><strong>Пожаловаться на спам</strong></center></h3>
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

$result = @mysql_query("SELECT * FROM $messagetable WHERE ID='$link'");
while ($myrow=mysql_fetch_array($result)) {
$mesID=$myrow["ID"];
$tid=$myrow["tid"];
$aid=$myrow["aid"];
$date=$myrow["date"];
$comment=$myrow["comment"];
}
if ($aid == '0') {$sender = "Администратор";}
if ($aid != '0') {$sender = "Пользователь ID: $aid";}
if ($tid == '0') {$recip = "Администратор";}
if ($tid != '0') {$recip = "Пользователь ID: $tid";}
$txt="Жалоба на спам в сообщении на сайте $siteadress<br><br>Сообщение (ID:$mesID): $comment<br>Отправитель: $sender<br>Получатель: $recip<br>Дата: $date";
mail($adminemail,"Жалоба на спам в сообщении",$txt,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/html; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");


echo "<br><br><h3 align=center>Жалоба отправлена!</h3><p align=center>Администрация проверет вашу жалобу о спаме и примет соответствующие меры<a href=autor.php>Вернуться в личный раздел</a></p><br><br>";
}
if ($_SERVER[QUERY_STRING] != "del") {
$link=$_GET['link'];
echo ("
<form name=form method=post action=messpam.php?del>
<input type=hidden name=link value=$link>
<center><table width=90%>
<tr><td align=center>
Для того, чтобы отправить жалобу на сообщение, нажмите кнопку \"Спам в сообщении\".<br><br>
<input type=submit value=\"Спам в сообщении\" name=\"delete\">
</td></tr>
</table></form>
");
echo "<br><br><p align=center><a href=autor.php>Вернуться в личный раздел</a></p>";
}
} //1
include("down.php");
?>