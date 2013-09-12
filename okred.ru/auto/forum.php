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
//$maxemail = 50;	
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
$link=$_GET['link'];
if ($_SERVER[QUERY_STRING] != "add"){
$result = @mysql_query("SELECT rootID FROM $forumtable WHERE parentID=0");
$totalThread = @mysql_num_rows($result);
unset($result);
$result = @mysql_query("SELECT rootID FROM $forumtable");
$mes = @mysql_num_rows($result);
unset($result);
$page=$_GET['page'];
if(!isset($page)) $page = 1;
if( $totalThread <= $maxforumThread ) $totalPages = 1;
elseif( $totalThread % $maxforumThread == 0 ) $totalPages = $totalThread / $maxforumThread;
else $totalPages = ceil( $totalThread / $maxforumThread );
if( $totalThread == 0 ) $threadStart = 0;
else $threadStart = $maxforumThread * $page - $maxforumThread + 1;
if( $page == $totalPages ) $threadEnd = $totalThread;
else $threadEnd = $maxforumThread * $page;
$initialMsg = $maxforumThread * $page - $maxforumThread;
$pages = (int) (($totalThread + $maxforumThread - 1) / $maxforumThread);
$line = "Страница: |";
for ($k = 1; $k <= $pages; $k++) {
  if ($k != $page) {$line .= "<a href=\"forum.php?page=$k\"> $k </a>|";}
  if ($k == $page) {$line .= " $k |";}
}
if (!isset($link)){
echo "<center><p>$line<p>";
echo "<table border=0 width=95% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=4 width=100%><tr bgcolor=$forummaincolor><td colspan=5 align=center><strong><a href=forumadd.php>Новая тема</a> | <strong><a href=forumsr.php>Поиск</a> | <a href=registr.php>Регистрация</a></strong></td></tr>";
echo "<tr bgcolor=$forumcolor><td><strong>Тема</strong></td><td><strong>Ответов</strong></td>";
echo "<td><strong>Автор</strong></td><td><strong>Последнее&nbsp;сообщение</strong></td><td><strong>Просмотров</strong></td></tr>";
}
$d=0;
$sql1="select * from $forumtable where parentID=0 order by lastdate DESC,rootID DESC LIMIT $initialMsg, $maxforumThread";
$result2=@mysql_query($sql1,$db);
while($myrow=mysql_fetch_array($result2)) {
$tema=$myrow["tema"];
$name=$myrow["name"];
$pass=$myrow["pass"];
$lastdate=$myrow["lastdate"];
$rootID=$myrow["rootID"];
$count=$myrow["count"];
if ($d % 2 != 1) {$color="$forummaincolor";}
else {$color="$forumcolor";}
$url="$n?link=$rootID";
$replymes1 = "select parentID from $forumtable where parentID=$rootID";
$resultrm1 = @mysql_query($replymes1);
$replymes= @mysql_numrows($resultrm1);
$d=$d+1;
if (!isset($link)){
if ($pass!="0") {
$sql3="select ID,email,date from $autortable where email='$email'";
$result4=@mysql_query($sql3,$db);
while ($myrow1=mysql_fetch_array($result4)) {
$autorid=$myrow1["ID"];
$regdate=$myrow1["date"];
}
$nameline="<b>Пользователь</b>";
}
if ($pass=="0") {
$nameline="$name";
}
echo "<tr bgcolor=$color><td><a href=$url>$tema</a></td>";
echo "<td>$replymes</td>";
echo "<td>$nameline</td>";
echo "<td><small>$lastdate</small></td>";
echo "<td>$count</td></tr>";
}}
if (!isset($link)){
echo "<tr bgcolor=$forumaltcolor><td colspan=5 align=right>Всего тем: <b>$totalThread</b></td></tr><tr bgcolor=$forummaincolor><td colspan=5 align=center><strong><a href=forumadd.php>Новая тема</a> | <strong><a href=forumsr.php>Поиск</a> | <a href=registr.php>Регистрация</a></strong> | <a href=forumadm.php></a></td></tr></table></td></tr></table>";
echo "<p><center>$line";
}
if (isset($link)) {
$sql="update $forumtable SET count=count+1 WHERE rootID=$link and parentID=0";
$result=@mysql_query($sql,$db);
$result = @mysql_query("select rootID,parentID from $forumtable where parentID=$link");
$totalThread = @mysql_num_rows($result);
unset($result);
$page=$_GET['page'];
if(!isset($page)) $page = 1;
if( $totalThread <= $maxforumThread ) $totalPages = 1;
elseif( $totalThread % $maxforumThread == 0 ) $totalPages = $totalThread / $maxforumThread;
else $totalPages = ceil( $totalThread / $maxforumThread );
if( $totalThread == 0 ) $threadStart = 0;
else $threadStart = $maxforumThread * $page - $maxforumThread + 1;
if( $page == $totalPages ) $threadEnd = $totalThread;
else $threadEnd = $maxforumThread * $page;
$initialMsg = $maxforumThread * $page - $maxforumThread;
$pages = (int) (($totalThread + $maxforumThread - 1) / $maxforumThread);
$line = "Страница: |";
for ($k = 1; $k <= $pages; $k++) {
  if ($k != $page) {$line .= "<a href=\"forum.php?link=$link&page=$k\"> $k </a>|";}
  if ($k == $page) {$line .= " $k |";}
}
$sql2="select rootID,parentID,name,tema,comment,email,date,rew,pass from $forumtable where rootID=$link and parentID=0";
$result3=@mysql_query($sql2,$db);
while ($myrow=mysql_fetch_array($result3)) {
$tema=$myrow["tema"];
$name=$myrow["name"];
$date=$myrow["date"];
$email=$myrow["email"];
$rootID=$myrow["rootID"];
$parentID=$myrow["parentID"];
$comment=$myrow["comment"];
$pass=$myrow["pass"];
}
if ($pass!="0") {
$sql3="select ID,email,date from $autortable where email='$email'";
$result4=@mysql_query($sql3,$db);
while ($myrow1=mysql_fetch_array($result4)) {
$autorid=$myrow1["ID"];
$regdate=$myrow1["date"];
}
$regpass="<i><small>Зарегистрирован с $regdate</small></i>";
$nameline="<b>Пользователь</b> ($regpass)";
}
if ($pass=="0") {
$regpass="<i>Гость</i>";
$nameline="$name ($regpass)";
}
$replymes1 = "select parentID from $forumtable where parentID=$link";
$resultrm1 = @mysql_query($replymes1);
$replymes= @mysql_numrows($resultrm1);
echo "<center><h3>Тема: $tema</h3>Всего ответов: <b>$replymes</b>";
echo "<table border=0 width=95% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=4 width=100%><tr bgcolor=$forummaincolor><td colspan=2 align=center><strong><a href=forum.php>Все темы</a> | <a href=forumadd.php>Новая тема</a> | <strong><a href=forumsr.php>Поиск</a> | <a href=registr.php>Регистрация</a></strong></td></tr>";
echo "<tr bgcolor=$forumcolor><td><big><strong>$tema</strong></big></td><td><small>$date</small></td></tr><tr><td bgcolor=#E6E6E6 colspan=2><small><strong>Автор: </strong>$nameline</small></td></tr>";
echo "<tr bgcolor=$forummaincolor><td colspan=2>$comment</td></tr>";
echo "<tr><td bgcolor=$forumaltcolor align=right colspan=2><a href=$n?link=$rootID#answer>Ответить &gt;&gt;</a></td></tr>";
$sql2="select rootID,parentID,name,tema,comment,email,date,rew,pass from $forumtable where parentID=$rootID LIMIT $initialMsg, $maxforumThread";
$result3=@mysql_query($sql2,$db);
if (@mysql_num_rows($result3) != "0") {
while ($myrow=mysql_fetch_array($result3)) {
$tema=$myrow["tema"];
$name=$myrow["name"];
$date=$myrow["date"];
$email=$myrow["email"];
$rootID=$myrow["rootID"];
$parentID=$myrow["parentID"];
$comment=$myrow["comment"];
$rew=$myrow["rew"];
$pass=$myrow["pass"];
if ($pass!="0") {
$sql3="select ID,email,date from $autortable where email='$email'";
$result4=@mysql_query($sql3,$db);
while ($myrow1=mysql_fetch_array($result4)) {
$autorid=$myrow1["ID"];
$regdate=$myrow1["date"];
}
$regpass="<i><small>Зарегистрирован с $regdate</small></i>";
$nameline="<b>Пользователь</b> ($regpass)";
}
if ($pass=="0") {
$regpass="<i>Гость</i>";
$nameline="$name ($regpass)";
}
echo "<tr bgcolor=$forumcolor><td><big><strong>Re: $tema</strong></big></td><td><small>$date</small></td></tr><tr><td bgcolor=#E6E6E6 colspan=2><small><strong>Автор: </strong>$nameline</small></td></tr>";
echo "<tr bgcolor=$forummaincolor><td colspan=2>$comment</td></tr>";
echo "<tr><td bgcolor=$forumaltcolor align=right colspan=2><a href=$n?link=$parentID#answer>Ответить &gt;&gt;</a></td></tr>";
}}
echo "<tr bgcolor=$forummaincolor><td align=center colspan=2><strong><a href=forum.php>Все темы</a> | <a href=forumadd.php>Новая тема</a> | <strong><a href=forumsr.php>Поиск</a> | <a href=registr.php>Регистрация</a></strong> | <a href=forumadm.php>admin</a></td></tr></table></td></tr></table>";
echo "<p><center>$line";
echo "<a name=answer></a>";
$tema=str_replace(" ","&nbsp;",$tema);
echo ("
<form name=addmessage method=post action=forum.php?add>
<p><center><table>
<tr><td bgcolor=$forumcolor colspan=2><big><strong>Оставить сообщение по этой теме:</strong></big></td></tr>
<tr><td colspan=2><strong>Обязательные поля отмечены символом <font color=#FF0000>*</font></strong></td></tr>
<tr><td align=right><strong><font color=#FF0000>*</font>Тема:</strong></td>
<td><input type=text name=temanew size=36 value=Re:$tema></td></tr>
<tr><td align=right><strong><font color=#FF0000>*</font>Имя (email для зарегистрированных пользователей):</strong></td>
<td><input type=text name=namenew size=30></td></tr>
<tr><td align=right valign=top><strong>Пароль:</strong></td>
<td><input type=password name=passnew size=20><br><small>для <a href=registr.php>зарегистрированных</a> пользователей</small></td></tr>
");
//echo "<tr><td align=right valign=top><strong>E-mail адрес:</strong><br></td><td><input type=text name=emailnew size=30><br><input type=checkbox name=rew value=on></input>Уведомить о новых сообщениях<br><small>(только для <a href=registr.php>зарегистрированных</a> пользователей)</small></td></tr>";
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
<input type=hidden name=link value=$link>
<hr width=90% size=1>
<center><p>Для того, чтобы разместить больше информации о себе необходимо <a href=registr.php>зарегистрироваться</a>!<p><input type=submit value=Ответить name=submit></form>
");
}
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
$res5 = "select email,pass from $autortable where email='$namenew' and pass='$passnew'";
$result5 = @mysql_query($res5);
if (@mysql_num_rows($result5) == "0") {$error .= "$err9";}
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
echo "<center><h3>Ошибка</h3><font color=red>$error</font><p><a href=# onClick=history.go(-1)>Вернуться назад</a><p><br><br><br><br>";
}
if ($error==""){
$temanew=str_replace("Re:","",$temanew);
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
$parentID=$link;
if ($passnew != "") {$regpass=1;}
if ($passnew == "") {$regpass=0;}
if ($rew == "on") {$rew=1;}
if ($rew == "") {$rew=0;}
$sql5="insert into $forumtable (parentID,name,tema,comment,email,date,rew,pass,ip) values ('$parentID','$namenew','$temanew','$commentnew','$emailnew',now(),'$rew','$regpass','$REMOTE_ADDR')";
$result6=@mysql_query($sql5,$db);
$result=@mysql_query("update $forumtable SET lastdate=now() where rootID=$link and parentID=0");
echo "<center>Уважаемый(-ая) <strong>$namenew</strong> Вы оставили свои комментарии по теме:<br><font color=blue>$temanew</font><br>следующего содержания:<p align=justify>$commentnew</p>Спасибо за участие!<br><a href=forum.php>Вернуться</a><p><br><br><br><br>";
$txt="Тема: $temanew\nСообщение: $commentnew\nIP автора: $REMOTE_ADDR";
if ($mailforumadd == 'TRUE') {
@mail("$adminemail", "Новое сообщение на форуме сайта $sitename", $txt,"Return-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/plain; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");}
}
}
include("down.php");
?>