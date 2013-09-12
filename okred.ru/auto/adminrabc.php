<?
session_start();
?>
<!--/***************** DO NOT REMOVE! *********************/---->
<!--/*   Author: Nevezhyn Evgeny  Date : 25/02/2003       */---->
<!--/*   nevius@bk.ru      All Rights Reserved ...        */---->
<!--/*   http://nevius.ru/                                */---->
<!--/***************** DO NOT MODIFY! *********************/---->

<?php
include("var.php");
echo "<html><head><title>Администрирование - Управление отзывами: $sitename</title>";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\">";
include("top.php");
$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);
$result = @mysql_query("SELECT pass FROM $admintable");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
$err2="Не выбрано ни одного отзыва!<br>";
$error = "";
if (!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass)
{
echo "<center><b>Вы не <a href=admin.php>авторизированы</a>!</b><br><br>";
}
else
{ // ok
if ($_SERVER[QUERY_STRING] != "del"){
$srid=$_GET['srid'];
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
$result = @mysql_query("SELECT ID,tid FROM $rabcommentstable");
$totalThread = @mysql_num_rows($result);
$mes = $totalThread;
unset($result);
$page=$_GET['page'];
if(!isset($page)) $page = 1;
if( $totalThread <= $maxThread ) $totalPages = 1;
elseif( $totalThread % $maxThread == 0 ) $totalPages = $totalThread / $maxThread;
else $totalPages = ceil( $totalThread / $maxThread );
if( $totalThread == 0 ) $threadStart = 0;
else $threadStart = $maxThread * $page - $maxThread + 1;
if( $page == $totalPages ) $threadEnd = $totalThread;
else $threadEnd = $maxThread * $page;
$initialMsg = $maxThread * $page - $maxThread;
$pages = (int) (($totalThread + $maxThread - 1) / $maxThread);
$line = "Страница: |";
for ($k = 1; $k <= $pages; $k++) {
  if ($k != $page) {$line .= "<a href=\"adminc.php?srid=$srid&page=$k\"> $k </a>|";}
  if ($k == $page) {$line .= " $k |";}
}
echo "<center><p><strong><big>Администрирование - Управление отзывами</strong></big><p>Пометьте галочкой отзывы, которые нужно удалить и нажмите на кнопку \"Удалить отмеченные\".<p>";
echo "Для быстрого перехода к отзыву введите номер фирмы (ID): <form name=sr method=get action=adminc.php><input type=text name=srid size=7>&nbsp;<input type=submit name=submit value=Перейти></form><br><br>";
echo "Всего отзывов: <b>$totalThread</b><br>$line</p>";
echo "<form name=delreg method=post action=adminrabc.php?del><table border=0 width=95% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=4 width=100% class=tbl1>";
echo "<tr bgcolor=$altcolor><td>&nbsp;</td><td>&nbsp;</td><td><strong>Комментарий</strong></td><td><strong>К компании</strong></td><td><strong>Автор</strong></td></tr>";
if (@$srid == "") {$result = @mysql_query("SELECT * FROM $rabcommentstable order by ID DESC LIMIT $initialMsg, $maxThread");}
if (@$srid != "") {$result = @mysql_query("SELECT * FROM $rabcommentstable WHERE tid='$srid' order by ID DESC");}
while($myrow=mysql_fetch_array($result)) {
$ID=$myrow["ID"];
$tid=$myrow["tid"];
$name=$myrow["login"];
$ip=$myrow["ip"];
$comment=$myrow["comment"];
$res = @mysql_query("SELECT ID,firm,city FROM $autortable WHERE ID='$tid'");
while($myrow1=mysql_fetch_array($res)) {
$aname=$myrow1["firm"];
}
$nameline="$name&nbsp;($ip)&nbsp;";
echo "<tr bgcolor=$maincolor><td><input type=checkbox name=delmes[] value=$ID></td>";
echo "<td></td>";
echo "<td>$comment</td>";
echo "<td>$aname (ID: $tid)</td>";
echo "<td>$nameline</td></tr>";
}
echo "<tr bgcolor=$altcolor><td colspan=5 align=right>Всего отзывов: <b>$totalThread</b></td></tr></td></tr></table></table>";
echo "<p><center>$line<p>";
echo ("
<hr width=90% size=1><br>
<center><input type=submit value='Удалить отмеченные' name=delete></form>
");
}
if ($_SERVER[QUERY_STRING] == "del"){
$delmes=$_POST['delmes'];
if (count($delmes)==0) {
	$error .= "$err2";}
if ($error != ""){
echo "<center><h3>Ошибка</h3><font color=red>$error</font><p><a href=# onClick=history.go(-1)>Вернуться назад</a><p><br><br><br><br><br><br><br><br>";
}
if ($error==""){
unset($result);
for ($i=0;$i<count($delmes);$i++){
$result=@mysql_query("delete from $rabcommentstable WHERE ID=$delmes[$i]");
}
echo "<center><b>Выбранные отзывы удалены!</b><br><a href=adminrabc.php>Вернуться</a><p><br><br><br><br>";
}
}
}
echo "<center><a href=admin.php>На общую страницу администрирования</a><br><br>";
include("down.php");
?>