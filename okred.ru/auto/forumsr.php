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
echo"<title>Поиск : $sitename</title>";
include("top.php");
$n = getenv('REQUEST_URI');
echo "<h3 align=center>Поиск</h3>";
if (!isset($_GET['submit']) and (!isset($_GET['page']))) {
echo "<form name=search method=GET action=\"forumsr.php?search\">";
echo ("
<center><table bgcolor=$forummaincolor border=0 cellpadding=4>
<tr bgcolor=$forummaincolor>
<td align=right>Строка поиска:</td>
<td align=left><input type=text name=srcomment size=30></td>
</tr>
<tr bgcolor=$forummaincolor>
<td colspan=2 align=center>Показывать сообщений на странице:&nbsp;
<select name=maxThread size=1>
<option selected value=20>20</option>
<option value=10>10</option>
<option value=30>30</option>
</select></td>
</tr>
<tr bgcolor=$forummaincolor>
<td colspan=2 align=center>&nbsp;</td></tr>
<tr bgcolor=$forummaincolor>
<td colspan=2 align=center><input type=submit value=Искать name=submit></td></tr>
</table>
</form>
");
}
if ((isset($_GET['submit']) or isset($_GET['page']))) {

$srcomment=$_GET['srcomment'];
$page=$_GET['page'];
$maxThread=$_GET['maxThread'];

if ($srcomment != "") {$srcomment = ereg_replace(" ","*.",$srcomment); $qwery='REGEXP';}
if ($srcomment == "") {$srcomment = '%'; $qwery='LIKE';}
$result = @mysql_query("SELECT * FROM $forumtable WHERE comment $qwery '$srcomment' or tema $qwery '$srcomment'");
$totaltexts=@mysql_num_rows($result);
if (!isset($maxThread) or $maxThread=='') {$maxThread = $maxThreadef;}
if(!isset($page)) $page = 1;
if( $totaltexts <= $maxThread ) $totalPages = 1;
elseif( $totaltexts % $maxThread == 0 ) $totalPages = $totaltexts / $maxThread;
else $totalPages = ceil( $totaltexts / $maxThread );
if( $totaltexts == 0 ) $threadStart = 0;
else $threadStart = $maxThread * $page - $maxThread + 1;
if( $page == $totalPages ) $threadEnd = $totaltexts;
else $threadEnd = $maxThread * $page;
$initialMsg = $maxThread * $page - $maxThread;
$pages = (int) (($totaltexts + $maxThread - 1) / $maxThread);
$line = "Страница: |";
for ($k = 1; $k <= $pages; $k++) {
  if ($k != $page) {$line .= "<a href=\"$n&page=$k\"> $k </a>|";}
  if ($k == $page) {$line .= " $k |";}
}
echo "<center><p><strong><big>Результаты поиска</strong></big><br>";
echo "Результаты поиска: найдено <b>$totaltexts</b> сообщений<br>$line</p>";
echo "<center><p>$line<p>";
echo "<table border=0 width=95% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=4 width=100%><tr bgcolor=$forummaincolor><td colspan=5 align=center><strong><a href=forumadd.php>Новая тема</a> | <strong><a href=forumsr.php>Поиск</a> | <a href=registr.php>Регистрация</a></strong></td></tr>";
echo "<tr bgcolor=$forumcolor><td><strong>Тема</strong></td><td><strong>Ответов</strong></td>";
echo "<td><strong>Автор</strong></td><td><strong>Последнее&nbsp;сообщение</strong></td><td><strong>Просмотров</strong></td></tr>";
$d=0;
$result = @mysql_query("SELECT * FROM $forumtable WHERE (comment $qwery '$srcomment' or tema $qwery '$srcomment') order by lastdate DESC LIMIT $initialMsg, $maxThread");
while ($myrow=@mysql_fetch_array($result)) 
{ //4
$tema=$myrow["tema"];
$name=$myrow["name"];
$pass=$myrow["pass"];
$lastdate=$myrow["lastdate"];
$rootID=$myrow["rootID"];
$parentID=$myrow["parentID"];
$count=$myrow["count"];
if ($d % 2 != 1) {$color="$forummaincolor";}
else {$color="$forumcolor";}
if ($parentID == 0) {$url="forum.php?link=$rootID";}
elseif ($parentID != 0) {$url="forum.php?link=$parentID";}
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
}
} //4
echo "<tr bgcolor=$forummaincolor><td colspan=5 align=center><strong><a href=forumadd.php>Новая тема</a> | <strong><a href=forumsr.php>Поиск</a> | <a href=registr.php>Регистрация</a></strong> | <a href=forumadm.php>admin</a></td></tr></table></td></tr></table>";
echo "<p><center>$line";
}
include("down.php");
?>