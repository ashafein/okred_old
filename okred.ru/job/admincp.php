<?
session_start();
session_register("uid");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


<?php
include("var.php");
echo "<head><title>Администрирование - Изменение пароля: $sitename</title>";
include("top.php");
echo "<center><h3>Изменение пароля</h3>";
$err1 = "Не заполнено обязательное поле - Текущий пароль!<br>";
$err2 = "Не заполнено обязательное поле - Новый пароль!<br>";
$err3 = "Не заполнено обязательное поле - Подтверждение пароля!<br>";
$err4 = "Поля Пароль и Подтверждение пароля должны совпадать!<br>";
$err5 = "Неверный пароль!<br>";
$error = "";
$result = @mysql_query("SELECT pass FROM $admintable");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
if (!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass)
{
echo "<center><b>Вы не <a href=admin.php>авторизированы</a>!</b><br><br>";
}
else
{ // ok
if ($_SERVER[QUERY_STRING] == "add")
{ // add
$oldpass=$_POST['oldpass'];
$newpass=$_POST['newpass'];
$passconf=$_POST['passconf'];
if ($oldpass == "") {$error .= "$err1";}
if ($newpass == "") {$error .= "$err2";}
if ($passconf == "") {$error .= "$err3";}
if ($newpass != $passconf) {$error .= "$err4";}
$result = @mysql_query("SELECT pass FROM $admintable WHERE pass = '$oldpass'");
if (@mysql_num_rows($result) == 0) {$error .= "$err5";}
unset($result);
echo "<center><font color=red>$error</font></center>";
if ($_SERVER[QUERY_STRING] == "add" and $error == "") {
$sql="update $admintable SET pass='$newpass'";
$result=mysql_query($sql,$db);
session_destroy();
unset($uid);
$_SESSION['uid'] = '';
}
} // add
if ($_SERVER[QUERY_STRING] != "add" or $error != "") 
{ // form
echo ("
<form method=post action=\"admincp.php?add\">
<table>
<tr><td align=right valign=top>Текущий пароль:</td>
<td><input type=password name=\"oldpass\" size=20></td></tr>
<tr><td align=right valign=top>Новый пароль:</td>
<td><input type=password name=\"newpass\" size=20></td></tr>
<tr><td align=right valign=top>Подтверждение пароля:</td>
<td><input type=password name=\"passconf\" size=20></td></tr>
</table>
<P><input type=\"submit\" value=\"Изменить\">
</form><br>
<a href=admin.php>На общую страницу администрирования</a>
");
} //form
else {
echo "<center><b>Пароль изменен!</b><br><br><a href=admin.php>На общую страницу администрирования</a><br><br>";
}
} // ok
include("down.php");
?>