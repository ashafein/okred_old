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
echo "<title>Поиск : $sitename</title>";
include("top.php");
$n = getenv('REQUEST_URI');
$maxThread=$maxtext;

$in=$_GET['in'];
$page=$_GET['page'];
$query=$_GET['query'];

if (isset($_GET['search']) or isset($page))
{//0
$query = ereg_replace(" ","*.",$query);
if ($in=='intext')
{
$result = @mysql_query("SELECT ID,text,status FROM $textable WHERE text REGEXP '$query' and status='ok' order by ID DESC");
}
if ($in=='intitle')
{
$result = @mysql_query("SELECT ID,title,status FROM $textable WHERE title REGEXP '$query' and status='ok' order by ID DESC");
}
$totaltexts=@mysql_num_rows($result);
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
  if ($k != $page) {$line .= "<a href=\"searcht.php?in=$in&query=$query&page=$k\"> $k </a>|";}
  if ($k == $page) {$line .= " $k |";}
}
echo "<table width=100% border=0 class=tbl1><tr><td bgcolor=$altcolor align=left><b><big>Результаты&nbsp;поиска</big></b></td></tr></table><br>";
if ($totaltexts == 0) {
echo "<center><b>Статья не найдена!</b><br><br><a href=# onClick=history.go(-1)>Вернуться назад</a><br><br>";
}
else
{ //2
echo "<p align=center class=tbl1>Найдено статей: <b>$totaltexts</b><br><br>$line</p>";
if ($in=='intext')
{
$result = @mysql_query("SELECT * FROM $textable WHERE text REGEXP '$query' and status='ok' order by ID DESC LIMIT $initialMsg, $maxThread");
}
if ($in=='intitle')
{
$result = @mysql_query("SELECT * FROM $textable WHERE title REGEXP '$query' and status='ok' order by ID DESC LIMIT $initialMsg, $maxThread");
}
while ($myrow=mysql_fetch_array($result)) 
{ //4
$ID=$myrow["ID"];
$title=$myrow["title"];
$genre=$myrow["genre"];
$theme=$myrow["theme"];
$size=$myrow["size"];
$preview=$myrow["preview"];
$date=$myrow["date"];
if ($theme != '') {$themeline="<tr bgcolor=$maincolor><td align=left colspan=2>Тема: <b>$theme</b></td></tr>";}
if ($theme == '') {$themeline="";}
$totalpage=(int) ($size / ($maxpagesize/1000));
$totalpage = $totalpage + 1;
echo ("
<div align=right><table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=4 width=100% class=tbl1>
<tr bgcolor=$altcolor><td width=70% align=left colspan=2><a href=\"text.php?link=$ID&g=$genre\"><b><big>$title</big></b></a></td></tr>
<tr bgcolor=$maincolor><td align=left colspan=2>Жанр: <b>$genre</b></td></tr>
$themeline
<tr bgcolor=$maincolor><td align=left colspan=2>Размер: <b>$size</b> Кб.&nbsp;&nbsp;Страниц: <b>$totalpage</b></td></tr>
<tr bgcolor=$altcolor><td align=left colspan=2><p align=justify>$preview</p></td></tr>
<tr bgcolor=$maincolor><td align=left colspan=2>Размещена: <b>$date</b></td></tr>
</table></td></tr></table></div><br><br>
");
} //4
echo "<p align=center class=tbl1>$line<br><br><a href=searcht.php>На страницу поиска</a></p>";
} //2
} //0
if (!isset($_GET['submit']) and !isset($page)) 
{
echo ("
<h3 align=center>Поиск статей</h3>
<form name=delreg method=get action=searcht.php?search><center><table border=0 width=80% bgcolor=$maincolor class=tbl1>
<tr bgcolor=$maincolor><td align=left><small>Введите слово или сочетание слов, разделенных пробелами:</small><br><br><input type=text name=query size=50>&nbsp;<input type=submit name=search value=Найти><br><input type=radio name=in value=intext checked> В тексте<input type=radio name=in value=intitle> В названии</td></tr>
</table></form>
");
}
include("down.php");
?>