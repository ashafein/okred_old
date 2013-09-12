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

<head>
<?php
include("var.php");
echo"<title>Изменение сообщения форума : $sitename</title>";
include("top.php");
?>
<h3><center><strong>Изменение сообщения форума</strong></center></h3>
<?php
$maxtema = 100;	
$maxcomment = 5000;
$err3 = "Название темы должно быть не длинее $maxtema символов<br>";
$err4 = "Текст Сообщения должен быть не длинее $maxcomment символов<br>";
$err7 = "Не заполнено обязательное поле - Тема!<br>";
$err8 = "Не заполнено обязательное поле - Сообщение!<br>";
$err22="Неверный пароль!<br>";
$error = "";
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
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
if ($_GET['id'] == '') {$id=$_POST['id'];}
elseif ($_GET['id'] != '') {$id=$_GET['id'];}
$result = @mysql_query("SELECT rootID FROM $forumtable WHERE rootID = '$id'");
if (!isset($id) or @mysql_num_rows($result) == 0)
{
echo "<center><br><br><h3>Сообщение не определено!</h3>";
}
else
{//1
if ($_SERVER[QUERY_STRING] != "add")
{ //2
$result=@mysql_query("select rootID,parentID,name,tema,comment,email,date,rew,pass from $forumtable where rootID=$id");
while ($myrow=mysql_fetch_array($result)) {
$tema=$myrow["tema"];
$name=$myrow["name"];
$date=$myrow["date"];
$email=$myrow["email"];
$rootID=$myrow["rootID"];
$parentID=$myrow["parentID"];
$comment=$myrow["comment"];
$pass=$myrow["pass"];
}
echo "<center><font color=red>$error</font></center>";
} //2
if ($_SERVER[QUERY_STRING] == "add") {

$tema=$_POST['tema'];
$comment=$_POST['comment'];

if (strlen($tema) > $maxtema) {$error .= "$err3";}
if (strlen($comment) > $maxcomment) {$error .= "$err4";}
if ($tema == "") {
	$error .= "$err7";}
if ($comment == "") {
	$error .= "$err8";}
echo "<center><font color=red>$error</font></center>";
function untag ($string) {
$string = ereg_replace("<","&lt;",$string);
$string = ereg_replace(">","&gt;",$string);
$string = ereg_replace('\\\"',"&quot;",$string);
$string = ereg_replace("!","&#33;",$string);
$string = ereg_replace("\r","",$string);
$string = ereg_replace("%","&#37;",$string);
$string = ereg_replace("^ +","",$string);
$string = ereg_replace(" +$","",$string);
$string = ereg_replace(" +"," ",$string);
$string = ereg_replace("&nbsp;"," ",$string);
return $string;
}
$tema = untag($tema);
$comment = untag($comment);
if ($smilies != "off") {
$SmiliesCodes = array(":)", ":(", ";)", ":o", ":p", ":|");
$c = count($SmiliesCodes);
for ($i = 0; $i < $c; $i++) {
$comment = str_replace("$SmiliesCodes[$i]", '<img src=picture/s' . $i . '.gif>', $comment);
}
}
if ($_SERVER[QUERY_STRING] == "add" and $error == "") {
$stroka='<center><b>Изменения сохранены!</b>';
$sql="update $forumtable SET tema='$tema',comment='$comment' WHERE rootID='$id'";
$result=@mysql_query($sql,$db);
}
}
if ($_SERVER[QUERY_STRING] != "add" or $error != "") {
$tema=@str_replace(" ","&nbsp;",$tema);
echo ("
<form name=form method=post action=forumcm.php?add>
<input type=hidden name=id value=$id>
<table width=90%>
<tr><td align=right><strong><font color=#FF0000>*</font>Тема:</strong></td>
<td><input type=text name=tema value=$tema size=36></td></tr>
<tr><td align=right><strong>Логин:</strong></td>
<td><b>$name</b></td></tr>
<tr><td align=right valign=top><strong><font color=#FF0000>*</font>Сообщение:</strong></td>
<td><textarea rows=6 name=comment cols=30>$comment</textarea></td></tr>
<tr><td></td><td align=left><input type=checkbox name=smilies value=off></input>Без Смайликов</td></tr>
</table>
");
echo "<center><p><input type=submit value=\"Изменить\" name=\"submit\"></form>";
echo "<center><a href=forumadm.php>На страницу администрирования</a><br><br>";
}
else {
echo "<br><br><h3 align=center>Изменения сохранены!</h3><br><br>$stroka<br><br><br><br><p align=center><a href=forumadm.php>На страницу администрирования</a></p><br><br>";
}
} //1
} //ok
echo "<center><a href=admin.php>На общую страницу администрирования</a><br><br>";
include("down.php");
?>