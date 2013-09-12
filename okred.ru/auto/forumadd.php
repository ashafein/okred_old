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

<?php
echo "<head>";
include("var.php");
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\"><META HTTP-EQUIV=\"Cache-Control\" CONTENT=\"No-Cache\">";
echo "<title>Форум : $sitename</title>";
include("top.php");
echo "<center><h3>Форум</h3>";
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
$maxname = 70;	
//$maxemail = 70;	
$maxtema = 100;	
$maxcomment = 5000;
$err1 = "Имя должно быть не длинее $maxname символов<br>";
//$err2 = "E-mail должен быть не длинее $maxemail символов<br>";
$err3 = "Название темы должно быть не длинее $maxtema символов<br>";
$err4 = "Текст Сообщения должен быть не длинее $maxcomment символов<br>";
$err6 = "Не заполнено обязательное поле - Имя!<br>";
$err7 = "Не заполнено обязательное поле - Тема!<br>";
$err8 = "Не заполнено обязательное поле - Сообщение!<br>";
$err9 = "Неправильный пароль! Проверьте правильность ввода пароля (с учетом регистра)<br>";
$err24 = "Не верный цифровой код!<br>";
$error = "";
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
return $string;
}
if ($_SERVER[QUERY_STRING] != "add"){
echo ("
<form name=addmessage method=post action=forumadd.php?add>
<center><p><strong><a href=forum.php>Все темы</a> | <strong><a href=forumsr.php>Поиск</a> | <a href=registr.php>Регистрация</a></strong>
<table>
<tr><td bgcolor=$forumcolor colspan=2><big><strong>Новая тема:</strong></big></td></tr>
<tr><td colspan=2><strong>Обязательные поля отмечены символом <font color=#FF0000>*</font></strong></td></tr>
<tr><td align=right><strong><font color=#FF0000>*</font>Тема:</strong></td>
<td><input type=text name=temanew size=36></td></tr>
<tr><td align=right><strong><font color=#FF0000>*</font>Имя (email - для зарегистрированных пользователей):</strong></td>
<td><input type=text name=namenew size=30></td></tr>
<tr><td align=right valign=top><strong>Пароль:</strong></td>
<td><input type=password name=passnew size=20><br><small>для <a href=registr.php>зарегистрированных</a> пользователей</small></td></tr>
");
//echo "<tr><td align=right valign=top><strong>E-mail адрес:</strong><br></td><td><input type=text name=emailnew size=30><br><input type=checkbox name=rew value=on></input>Уведомить о новых сообщениях</a></td></tr>";
echo ("
<tr><td align=right valign=top><strong><font color=#FF0000>*</font>Сообщение:</strong></td>
<td><textarea rows=6 name=commentnew cols=30></textarea></td></tr>
<SCRIPT LANGUAGE = 'JavaScript'> <!--
function WindowOpen() {
msg=window.open('smiles.htm', 'PopUp', 'copyhistory,width=350,height=400,')
}
//--> </SCRIPT>
<tr><td></td><td align=left><input type=checkbox name=smilies value=off></input>Без <a href=#answer onClick=WindowOpen()>Смайликов</a></td></tr>
");
if ($imgconfirm == 'TRUE')
{ // img conf
echo "<tr><td align=right valign=top><font color=#FF0000>*</font><b>Код на картинке</b>:&nbsp;";
echo "<img src=code.php>";
echo "</td><td><input type=text name=number size=20></td></tr>";
} // img conf
echo ("
</table>
<hr width=90% size=1>
<center><p>Для того, чтобы разместить больше информации о себе необходимо <a href=registr.php>зарегистрироваться</a>!<p><input type=submit value=Создать name=submit></form>
<p><strong><a href=forum.php>Все темы</a> | <strong><a href=forumsr.php>Поиск</a> | <a href=registr.php>Регистрация</a></strong> | <a href=forumadm.php>admin</a></center>
");
}
if ($_SERVER[QUERY_STRING] == "add"){

$namenew=$_POST['namenew'];
$passnew=$_POST['passnew'];
$emailnew=$_POST['emailnew'];
$temanew=$_POST['temanew'];
$commentnew=$_POST['commentnew'];
$number=$_POST['number'];
$link=$_POST['link'];
$rew=$_POST['rew'];
$REMOTE_ADDR=$_SERVER['REMOTE_ADDR'];

if ($passnew != "") {
$res2 = "select email,pass from $autortable where email='$namenew' and pass='$passnew'";
$result2 = @mysql_query($res2);
if (@mysql_num_rows($result2) == "0") {$error .= "$err9";}
}
if (strlen($namenew) > $maxname) {$error .= "$err1";}
//if (strlen($emailnew) > $maxemail) {$error .= "$err2";}
if (strlen($temanew) > $maxtema) {$error .= "$err3";}
if (strlen($commentnew) > $maxcomment) {$error .= "$err4";}
if ($namenew == "") {
	$error .= "$err6";}
if ($temanew == "") {
	$error .= "$err7";}
if ($commentnew == "") {
	$error .= "$err8";}
if ($imgconfirm == 'TRUE' and $_COOKIE['reg_num'] != $number) {$error .= "$err24";}
if ($error != ""){
echo "<center><h3>Ошибка</h3><font color=red>$error</font><p><a href=# onClick=history.go(-1)>Вернуться назад</a><p><br><br><br><br><br><br><br><br>";
}
if ($error==""){
$namenew = untag($namenew);
//$emailnew = untag($emailnew);
$temanew = untag($temanew);
$commentnew = untag($commentnew);
$passnew = untag($passnew);
if ($smilies != "off") {
$SmiliesCodes = array(":)", ":(", ";)", ":o", ":p", ":|");
$c = count($SmiliesCodes);
for ($i = 0; $i < $c; $i++) {
$commentnew = str_replace("$SmiliesCodes[$i]", '<img src=picture/s' . $i . '.gif>', $commentnew);
}
}
$datenew = date("Y/m/d H:i:s");
if ($passnew != "") {$regpass=1;}
if ($passnew == "") {$regpass=0;}
if ($rew == "on") {$rew=1;}
if ($rew == "") {$rew=0;}
$sql="insert into $forumtable (name,tema,comment,email,date,lastdate,rew,pass,ip) values ('$namenew','$temanew','$commentnew','$emailnew',now(),now(),'$rew','$regpass','$REMOTE_ADDR')";
$result=@mysql_query($sql,$db);
$result=@mysql_query("update $forumtable SET lastdate=now() where rootID=$link and parentID=0");
echo "<center>Уважаемый(-ая) <strong>$namenew</strong> Вы только что создали новую тему:<br><font color=blue>$temanew</font><br>со следующим содержанием:<p><table border=0 width=90%><tr><td><p align=justify>$commentnew</p></td></tr></table><p>Спасибо за участие!<br><a href=forum.php>Вернуться</a><p><br><br><br><br><br><br>";
$txt="Тема: $temanew\nСообщение: $commentnew\nIP автора: $REMOTE_ADDR";
if ($mailforumadd == 'TRUE') {
@mail("$adminemail","Новая тема на форуме",$txt,"Return-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/plain; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");}
}
}
include("down.php");
?>