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
echo "<head><title>Администрирование - Удаление текстов: $sitename</title>";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\">";
include("top.php");
$err2="Не выбрано ни одной статьи!<br>";
$error = "";
$maxThread=$maxtext;
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
if ($_SERVER[QUERY_STRING] != "del"){
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
$result = @mysql_query("SELECT ID,title,status FROM $textable WHERE status='ok' order by title");
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
  if ($k != $page) {$line .= "<a href=\"admindt.php?page=$k\"> $k </a>|";}
  if ($k == $page) {$line .= " $k |";}
}
echo "<center><p><strong><big>Администрирование - Удаление статей</strong></big><p>Пометьте галочкой сатьи, которые нужно удалить, введите имя и пароль администратора и нажмите на кнопку \"Удалить отмеченные\".<p>";
echo "(Всего статей: <b>$totalThread</b>)<br>$line</p>";
echo "<form name=delreg method=post action=admindt.php?del><table border=0 width=95% bgcolor=$bordercolor><tr><td><table width=100% border=0 cellspacing=1 cellpadding=4>";
echo "<tr bgcolor=$altcolor><td><strong>&nbsp;</strong></td><td><strong>Правка</strong></td><td><strong>Название</strong></td><td><strong>Жанр</strong></td><td><strong>Размер</strong></td></tr>";
$result = @mysql_query("SELECT * FROM $textable WHERE status='ok' order by ID DESC LIMIT $initialMsg, $maxThread");
while($myrow=mysql_fetch_array($result)) {
$ID=$myrow["ID"];
$title=$myrow["title"];
$genre=$myrow["genre"];
$size=$myrow["size"];
echo "<tr><td bgcolor=$maincolor><input type=checkbox name=delmes[] value=$ID></td>";
echo "<td bgcolor=$maincolor><a href=adminct.php?texid=$ID>Правка</a></td>";
echo "<td bgcolor=$maincolor><a href=adminsh.php?ID=$ID>$title</a></td>";
echo "<td bgcolor=$maincolor>$genre</td>";
echo "<td bgcolor=$maincolor>$size Кб.</td>";
echo "</tr>";
}
echo "<tr><td colspan=5 bgcolor=#FFFF99 align=right>Всего статей: <b>$totalThread</b></td></tr></td></tr></table></table>";
echo "<p><center>$line<p>";
echo ("
<center><input type=submit value='Удалить отмеченные' name=submit></form>
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
$res1 = @mysql_query("SELECT ID,foto1,foto2,foto3,foto4,foto5,aid FROM $textable WHERE ID=$delmes[$i]");
while ($myrow=@mysql_fetch_array($res1)) 
{
$foto1=$myrow["foto1"];
$foto2=$myrow["foto2"];
$foto3=$myrow["foto3"];
$foto4=$myrow["foto4"];
$foto5=$myrow["foto5"];
}
@unlink($upath.$photodir.$foto1);
@unlink($upath.$photodir.$foto2);
@unlink($upath.$photodir.$foto3);
@unlink($upath.$photodir.$foto4);
@unlink($upath.$photodir.$foto5);
unset($res1);
$result=@mysql_query("delete from $textable WHERE ID=$delmes[$i]");
unset($result);
$result = @mysql_query("SELECT tid FROM $commentstable WHERE tid=$delmes[$i]");
if (@mysql_num_rows($result) != 0) {
while($myrow=mysql_fetch_array($result)) {
$result = @mysql_query("delete from $commentstable where tid=$delmes[$i]");
}}}
echo "<center><b>Выбранные статьи удалены!</b><br><a href=admindt.php>Вернуться</a><p><br><br><br><br>";
}
}
echo "<center><a href=admin.php>На общую страницу администрирования</a><br><br>";
} //ok
include("down.php");
?>