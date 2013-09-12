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
echo "<head>";
include("var.php");
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\"><META HTTP-EQUIV=\"Cache-Control\" CONTENT=\"No-Cache\">";
echo "<title>Форум : $sitename</title>";
include("top.php");
echo "<center><h3>Форум</h3>";
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
$err1="Неверный пароль!<br>";
$err2="Не выбрано ни одного сообщения!<br>";
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
$link=$_GET['link'];
if ($_SERVER[QUERY_STRING] != "del") {
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
  if ($k != $page) {$line .= "<a href=\"forumadm.php?page=$k\"> $k </a>|";}
  if ($k == $page) {$line .= " $k |";}
}
if (!isset($link)){
echo "$line<p>";
echo "<table border=0 width=95% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=4 width=100%><tr bgcolor=$forummaincolor><td colspan=6 align=center><strong><a href=forum.php>Вернуться в форум</a></strong></td></tr>";
echo "<tr bgcolor=$forumcolor><td><strong>Тема</strong></td><td><strong>Ответов</strong></td>";
echo "<td><strong>Автор</strong></td><td><strong>Последний&nbsp;ответ</strong></td><td><strong>Просмотров</strong></td></tr>";
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
$sql3="select ID,email,date from $autortable where email='$name'";
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
echo "<tr><td colspan=6 bgcolor=$forumaltcolor align=right>Всего тем: <b>$totalThread</b></td></tr></table></td></tr></table>";
echo "<p><center>$line";
}
if (isset($link)) {
$sql2="select rootID,parentID,name,tema,comment,email,date,rew,pass from $forumtable where rootID=$link and parentID=0";
$result3=@mysql_query($sql2,$db);
while ($myrow=mysql_fetch_array($result3)) {
$tema=$myrow["tema"];
$name=$myrow["name"];
$date=$myrow["date"];
$email=$myrow["email"];
$emailto1=$email;
$rootID=$myrow["rootID"];
$parentID=$myrow["parentID"];
$comment=$myrow["comment"];
$pass=$myrow["pass"];
}
if ($pass!="0") {
$sql3="select ID,email,date from $autortable where email='$name'";
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
echo "<form name=addmessage method=post action=forumadm.php?del>";
echo "<center><h3>Тема: $tema</h3>Всего ответов: <b>$replymes</b>";
echo "<table border=0 width=95% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=4 width=100%>";
echo "<tr bgcolor=$forumcolor><td><big><strong>$tema</strong></big></td><td><small>$date</small></td></tr><tr><td bgcolor=#E6E6E6 colspan=2><small><strong>Автор: </strong>$nameline</small></td></tr>";
echo "<tr bgcolor=$forummaincolor><td colspan=2>$comment</td></tr>";
echo "<tr><td bgcolor=$forumaltcolor align=left><a href=forumcm.php?id=$rootID><b>Правка</b></a></td><td bgcolor=$forumaltcolor align=right><input type=checkbox name=delmes[] value=$rootID>Удалить ($rootID-$parentID)</td></tr>";
$sql2="select rootID,parentID,name,tema,comment,email,date,rew,pass from $forumtable where parentID=$rootID";
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
$sql3="select ID,email,date from $autortable where email='$name'";
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
echo "<tr><td bgcolor=$forummaincolor colspan=2>$comment</td></tr>";
echo "<tr><td bgcolor=$forumaltcolor align=left><a href=forumcm.php?id=$rootID><b>Правка</b></a></td><td bgcolor=$forumaltcolor align=right><input type=checkbox name=delmes[] value=$rootID>Удалить ($rootID-$parentID)</td></tr>";
}}
echo "<tr bgcolor=$forummaincolor><td align=center colspan=2><strong><a href=forumadm.php>Admin</a> | <a href=forum.php>Вернуться в форум</a></strong></td></tr></table></td></tr></table>";
echo "<a name=answer></a>";
$tema=str_replace(" ","&nbsp;",$tema);
echo ("
<center><input type=submit value='Удалить отмеченные' name=submit></form>
");
}
}
if ($_SERVER[QUERY_STRING] == "del"){
$delmes=$_POST['delmes'];
if ($delmes=="") {
	$error .= "$err2";}
if ($error != ""){
echo "<center><h3>Ошибка</h3><font color=red>$error</font><p><a href=# onClick=history.go(-1)>Вернуться назад</a><p><br><br><br><br><br><br><br><br>";
}
if ($error==""){
for ($i=0;$i<count($delmes);$i++){
$result = @mysql_query("SELECT rootID,parentID FROM $forumtable WHERE rootID=$delmes[$i] and parentID=0");
$td = @mysql_num_rows($result);
if ($td != 0)
{
$sql="delete from $forumtable where rootID=$delmes[$i] and parentID=0";
$result=@mysql_query($sql,$db);
$sql1="delete from $forumtable where parentID=$delmes[$i]";
$result=@mysql_query($sql1,$db);
}
if ($td == 0)
{
$sql="delete from $forumtable where rootID=$delmes[$i]";
$result=@mysql_query($sql,$db);
}
}
echo "<center>Выбранное сообщение удалено!<br><a href=forumadm.php>На страницу администрирования</a><p><br><br><br><br>";
}
}
echo "<center><a href=admin.php>На общую страницу администрирования</a><br><br>";
} //ok
include("down.php");
?>