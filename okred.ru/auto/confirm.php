<?
session_start();
session_register("spass");
session_register("slogin");
session_register("sid");
?>
<!--/***************** DO NOT REMOVE! *********************/---->
<!--/*   Author: Nevezhyn Evgeny  Date : 11/06/2005       */---->
<!--/*   nevius@bk.ru      All Rights Reserved ...        */---->
<!--/*   http://nevius.ru/                                */---->
<!--/***************** DO NOT MODIFY! *********************/---->

<?php
include("var.php");
echo "<head><title>Подтверждение регистрации : $sitename</title>";
include("top.php");
echo "<div class=tbl1>";
echo "<center><h3>Подтверждение регистрации</h3>";
$err1 = "Не заполнено обязательное поле - E-mail!<br>";
$err2 = "Не заполнено обязательное поле - Код активации!<br>";
$err3 = "Неправильный email или код активации!<br>";
$err6 = "Вы не авторизированы!<br>";
$error = "";
$login=$_GET['login'];
$code=$_GET['code'];
if ($login == "") {$error .= "$err1";}
if ($code == "") {$error .= "$err2";}
$result = @mysql_query("SELECT ID,email,code FROM $autortable WHERE (email = '$login' and code = '$code')");
if (@mysql_num_rows($result) == 0) {$error .= "$err3";}
unset($result);
echo "<center><font color=red>$error</font></center>";
if (!isset($login) or !isset($code) or $login=='' or $code=='' or $error != "") {
echo ("
<p>Для подтверждения регистрации введите E-mail и Код активации, которые были высланы вам в письме:
<form method=get action=\"confirm.php\">
<table>
<tr><td align=right><strong>E-mail:</strong></td>
<td><input type=text name=\"login\" size=30><td></tr>
<tr><td align=right valign=top><strong>Код активации:</strong></td>
<td><input type=password name=\"code\" size=30><br><small><a href=recpass.php>Забыли пароль</a></small></td></tr>
</table>
<center><p><input type=submit value=\"Подтвердить\" name=\"submit\" class=i3>
<br><br><a href=registr.php>Регистрация</a><br><br>
</form>
<br><br>
<form name=repeat method=post action=\"sendconf.php\">
<input type=submit value=\"Выслать повторно\" name=\"submit\" class=i3>
</form>
");
}
elseif (isset($login) and isset($code) and $login != '' and $code != '' and $error == "") {
$result = @mysql_query("UPDATE $autortable SET status='user' WHERE (email = '$login' and code = '$code')");
unset($result);
$result = @mysql_query("SELECT * FROM $autortable WHERE (email = '$login' and code = '$code')");
while ($myrow=mysql_fetch_array($result)) {
$email=$myrow["email"];
$pass=$myrow["pass"];
$sid=$myrow["ID"];
$category=$myrow["category"];
}
$_SESSION['slogin']=$email;
$_SESSION['spass']=$pass;
echo ("
<h3 align=center>Спасибо за регистрацию на сайте $sitename!</h3><br><br>
");
$reglineafter="<p align=center>Выберите дальнейшее действие:<br><br>";
if ($category=='rab' or $category=='agency') {$reglineafter=$reglineafter."<a href=addvac.php>Добавить вакансию</a><br><br>";}
if ($category=='soisk' or $category=='agency') {$reglineafter=$reglineafter."<a href=addres.php>Добавить резюме</a><br><br>";}
$reglineafter=$reglineafter."<a href=autor.php>В личный раздел</a></p>";
echo ("
$reglineafter<br><br>
");
}
echo "</div>";
include("down.php");
?>