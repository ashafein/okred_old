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
echo"<title>Восстановление пароля : $sitename</title>";
include("top.php");
?>
<center><p><h3>Восстановление пароля</h3></p>
<?php
$err1 = "Пользователь с таким адресом не зарегистрирован!<br>";
$err2 = "Не заполнено обязательное поле - E-mail!<br>";
$error = "";
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
if ($_SERVER[QUERY_STRING] == "rec") {
$namenew=$_POST['namenew'];
if ($namenew == "") {$error .= "$err2";}
$result = mysql_query("SELECT email,pass FROM $autortable WHERE email='$namenew'");
if (mysql_num_rows($result) == 0) {
	$error .= "$err1";}
while ($myrow=mysql_fetch_array($result)) {
$recpass=$myrow["pass"];
$email=$myrow["email"];
}
echo "<center><font color=red>$error</font></center>";
}
if ($_SERVER[QUERY_STRING] != "rec" or $error != "") {
echo ("
<p>Если вы забыли свой пароль, то заполните приведенную ниже форму (все поля обязательны). После заполнения формы на email-адрес, указанный при регистрации будет выслано письмо с паролем.
<form method=post action=\"recpass.php?rec\">
<table>
<tr><td align=right><strong>E-mail:</strong></td>
<td><input type=text name=namenew size=20></td></tr>
</table>
<center><p><input type=submit value=Далее name=\"submit\">
</form><p>
");
}
if ($_SERVER[QUERY_STRING] == "rec" and $error == "") {
echo "Через некоторое время Пароль будет выслан на указанный Вами при регистрации email-адрес.<p>Удачи!<p><br><br><br><br>";
$txt="Здравствуйте!\nДанное письмо выслано Вам в связи с заявкой на восстановление забытого пароля указанного при регистрации на сайте $sitename.\n\nEmail: $email\nПароль: $recpass\n\nЕсли Вы не делали такого запроса, то, приносим свои извинения за беспокойство! В этом случае просто удалите это письмо.\nС уважением,\n$siteadress\n$adminemail";
mail($email,"Восстановление пароля",$txt,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/plain; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");
}
include("down.php");
?>