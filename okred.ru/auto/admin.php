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
echo "<head><title>Администрирование : $sitename</title>";
include("top.php");
echo "<center><h3>Администрирование</h3>";
$result = @mysql_query("SELECT pass FROM $admintable");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
$err2 = "Не заполнено обязательное поле - Пароль!<br>";
$err3 = "Неверный пароль!<br>";
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
<p>Пароль администратора не задан. Установите его сейчас:
<form method=post action=\"admin.php?admin\">
<input type=hidden name=newpass value=1>
<table>
<tr><td align=right valign=top><strong>Пароль:</strong></td>
<td><input type=password name=\"apass\" size=20></td></tr>
</table>
<center><p><input type=submit value=Войти name=\"submit\">
</form><p>
");
}
if ($adminpass != "")
{
echo ("
<p>Для входа на страницу администрирования введите Пароль:
<form method=post action=\"admin.php?admin\">
<table>
<tr><td align=right valign=top><strong>Пароль:</strong></td>
<td><input type=password name=\"apass\" size=20></td></tr>
</table>
<center><p><input type=submit value=Войти name=\"submit\">
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
<p align=center>Выберите необходимое действие:<br><br>
<b>Страны/регионы/города, разделы:</b><br>
<li><a href=admincity.php>Редактирование стран-регионов-городов</a><br>
<li><a href=adminmet.php>Редактирование станций метро</a><br>
<li><a href=adminmc.php>Редактирование разделов</a><br>
<br>
<b>Пользователи</b><br>
<li><a href=adminda.php>Удалить пользователя</a><br>
<li><a href=admincat.php>Включить/исключить из каталога агентств/работодателей</a><br>
<li><a href=adminmes.php>Поддержка пользователей</a><br>
<br>
<b>Отзывы о компаниях:</b><br>
<li><a href=adminrabc.php>Удаление отзывов</a><br>
<br>
<b>Вакансии</b><br>
<li><a href=adminov.php>Одобрить вакансии</a><br>
<li><a href=admindv.php>Удалить/редактировать вакансии</a><br>
<li><a href=admindov.php>Установить вакансии дня</a><br>
<li><a href=admindsv.php>Просмотр/удаление подписки на вакансии</a><br>
<br>
<b>Резюме</b><br>
<li><a href=adminor.php>Одобрить резюме</a><br>
<li><a href=admindr.php>Удалить/редактировать резюме</a><br>
<li><a href=admindor.php>Установить резюме дня</a><br>
<li><a href=admindsr.php>Просмотр/удаление подписки на резюме</a><br>
<br>
<b>Статьи</b><br>
<li><a href=adminmct.php>Редактирование разделов статей</a><br>
<li><a href=adminat.php>Добавить статью</a><br>
<li><a href=admindt.php>Удалить/редактировать статьи</a><br>
<li><a href=adminc.php>Удаление комментариев к статьям</a><br>
<br>
<b>Вопрос-ответ</b><br>
<li><a href=adminfaq.php?action=new>FAQ - Новые вопросы</a><br>
<li><a href=adminfaq.php?action=view>FAQ - Просмотр информации</a><br>
<br>
<b>Новости</b><br>
<li><a href=adminews.php?action=add>Добавить новость</a><br>
<li><a href=adminews.php?action=view>Просмотр / удаление новостей</a><br>
<br>
<b>Реклама</b><br>
<li><a href=adminpra.php>Добавить рекламный блок</a><br>
<li><a href=adminpro.php>Просмотр / удаление рекламных блоков</a><br>
<li><a href=adminprok.php>Одобрить рекламные блоки пользователей</a> (<b>$tot3</b>)<br>
<br>
<b>Афиша:</b><br>
<li><a href=adminnew.php>Добавить афишу</a><br>
<li><a href=adminnd.php>Редактировать афишу</a><br>
<li><a href=adminrep.php>Добавить отчет</a><br>
<li><a href=adminrd.php>Редактировать отчеты</a><br>
<li><a href=adminmca.php>Редактирование разделов</a><br>
<li><a href=adminzav.php>Добавить учреждение</a><br>
<li><a href=adminzd.php>Редактировать учреждения</a><br>
<br>
<li><a href=adminrs.php>Управление рассылкой</a><br>
<li><a href=forumadm.php>Форум</a><br>
<li><a href=adminbl.php>Блокировать ip-адрес</a><br>
<li><a href=admincp.php>Изменить пароль</a><br>
<br>
<li><a href=adminzha.php>Жалобы</a><br>
<br>
</p>
</div>
");
}
include("down.php");
?>