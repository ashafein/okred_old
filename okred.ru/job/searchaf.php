<?
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
echo "<head>";
include("var.php");
echo "<title>Поиск : $sitename</title>";
include("top.php");

$qwery=$_GET['qwery'];
$page=$_GET['page'];

if ((isset($qwery) and $qwery != '') or isset($page))
{// поиск по слову
$qwerymark = $qwery;
$qwery = ereg_replace(" ","*.",$qwery);

// формируем таблицу с результатами

$finded = '';
$result = mysql_query("select * from $afishatable where title REGEXP '$qwery' or preview REGEXP '$qwery' or detail REGEXP '$qwery' or autor REGEXP '$qwery' order by date DESC");
if (@mysql_num_rows($result) != 0) {
while($myrow=mysql_fetch_array($result)) {
$ID=$myrow["ID"];
if ($finded != '') {$finded .= ':';}
$finded .= "$ID";
$finded .= "-n";
}
}
$result = mysql_query("select * from $reporttable where title REGEXP '$qwery' or preview REGEXP '$qwery' or detail REGEXP '$qwery' or autor REGEXP '$qwery' order by date DESC");
if (@mysql_num_rows($result) != 0) {
while($myrow=mysql_fetch_array($result)) {
$ID=$myrow["ID"];
if ($finded != '') {$finded .= ':';}
$finded .= "$ID";
$finded .= "-r";
}
}

if ($finded == '')
{ // нет совпадений 
$result = mysql_query("select ip from $searchtable where ip = '$REMOTE_ADDR'");
if (@mysql_num_rows($result) != 0) {
$sql="delete from $searchtable where ip='$REMOTE_ADDR'";
$resultadd=@mysql_query($sql,$db);
}

echo ("
<div align=center><table border=0 cellspacing=8 cellpadding=2>
<tr>
<td valign=top></td>
</tr>
<tr><td align=center>Ничего не найдено</td></tr>
</table></div>
");
} // нет совпадений

if ($finded != '')
{ // если есть совпадения 
$result = mysql_query("select ip from $searchtable where ip = '$REMOTE_ADDR'");
if (@mysql_num_rows($result) == 0) {
$sql="insert into $searchtable (finded,qwery,date,ip) values ('$finded','$qwery',now(),'$REMOTE_ADDR')";
$resultadd=@mysql_query($sql,$db);
}
elseif (@mysql_num_rows($result) != 0) {
$sql="update $searchtable set finded='$finded',qwery='$qwery',date=now() where ip='$REMOTE_ADDR'";
$resultadd=@mysql_query($sql,$db);
}
} // есть совпадения
// заканчиваем формирование таблицы с результатами

if ($finded != '')
{ // что-то найдено finded != ''
$resultf = mysql_query("select * from $searchtable where ip = '$REMOTE_ADDR' and qwery = '$qwery'");
while($myrow=mysql_fetch_array($resultf)) {
$findres=$myrow["finded"];
}
$bazze = split (":",$finded);
$messages=count($bazze);


if (!isset($page)) {$page = 1;}
$numfrom = count($bazze) - ($messperpage * ($page - 1));
$numto = count($bazze) - ($messperpage * $page) + 1;
if ($numto < 1) {$numto = 1;}
$pages = (int) ((count($bazze) + $messperpage - 1) / $messperpage);
$line = '';
if ($pages > 1)
{
$line = "Страница: <a href=\"searchaf.php?qwery=$qwery&page=1\"><<</a> |";
for ($k = 1; $k <= $pages; $k++) {
if (($k - $page) < 3 and ($k + 3) > $page)
{
  if ($k != $page) {$line .= "<a href=\"searchaf.php?qwery=$qwery&page=$k\"> $k </a>|";}
  if ($k == $page) {$line .= " $k |";}
}
}
$line .= "<a href=\"searchaf.php?qwery=$qwery&page=$pages\">>></a>";
}

echo ("
<table width=90% border=0 cellspacing=8 cellpadding=2>
<tr>
<td valign=top></td>
<td align=right align=bottom class=text>Найдено совпадений: <b>$messages</b></td>
</tr>
</table>
");

for ($i = $numfrom - 1 ; $i >= $numto - 1; $i--)
{ //1
	list($tID,$wtbl) = split ("-",$bazze[$i]);
	$num = (string) ($i+1);
	$num2 = (string) (count($bazze) - $i);

if ($wtbl == 'n')
{ // афиша
$result = mysql_query("select * from $afishatable where ID=$tID");
if (@mysql_num_rows($result) != 0)
{ // есть афиша
$rows = mysql_num_rows($result);

for($k=0;$k < $rows;$k++)
   {
echo "<table width=90% border=0 cellspacing=8 cellpadding=2>";
    $preview=mysql_result($result, $k , "preview");
    $detail=mysql_result($result, $k , "detail");
    $title=mysql_result($result, $k , "title");
$title = eregi_replace("$qwerymark","<font color=red>$qwerymark</font>",$title);
    $idnum=mysql_result($result, $k , "ID");
    $datum=mysql_result($result, $k , "datum");
    $datumend=mysql_result($result, $k , "datumend");
    $foto1=mysql_result($result, $k , "foto1");
    $dati=explode("-",$datum);
if ($preview != "") {
$preview = ereg_replace("\n","<br>",$preview);
$preview = ereg_replace("     ","&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$preview);
$preview = eregi_replace("$qwerymark","<font color=red>$qwerymark</font>",$preview);
if (eregi('ФОТО1',$preview) and $foto1 != ""){$preview=@str_replace('ФОТО1',"<img src=\"$afishadir$foto1\" border=0 align=left class=image>",$preview);}
}

if($preview=="") {
echo "<tr><td class=newstbltop><font color=#555555>$dati[2].$dati[1].$dati[0]";
if ($datumend != '0000-00-00') {$datumend=explode("-",$datumend);echo "&nbsp;-&nbsp;$datumend[2].$datumend[1].$datumend[0]";}
echo "</font>&nbsp;&nbsp;&nbsp;<a href=\"afisha.php?link=".$idnum."&year=".$dati[0]."&today=".$dati[2]."&month=".$dati[1]."\"><strong>".$title."</strong></a></td></tr>";
}
elseif($preview != "" and $detail != ""){
echo "<tr><td class=newstbltop><font color=#555555>$dati[2].$dati[1].$dati[0]";
if ($datumend != '0000-00-00') {$datumend=explode("-",$datumend);echo "&nbsp;-&nbsp;$datumend[2].$datumend[1].$datumend[0]";}
echo "</font>&nbsp;&nbsp;&nbsp;<a href=\"afisha.php?link=".$idnum."&year=".$dati[0]."&today=".$dati[2]."&month=".$dati[1]."\"><strong>".$title."</strong></a></td></tr><tr><td class=newstbl><p align=justify>".$preview;
echo "<br><a href=\"afisha.php?link=".$idnum."&year=".$dati[0]."&today=".$dati[2]."&month=".$dati[1]."\">Подробнее</a>&nbsp;&raquo;</p></td></tr>";
}
elseif($preview != "" and $detail == "") {
echo "<tr><td class=newstbltop><font color=#555555>$dati[2].$dati[1].$dati[0]";
if ($datumend != '0000-00-00') {$datumend=explode("-",$datumend);echo "&nbsp;-&nbsp;$datumend[2].$datumend[1].$datumend[0]";}
echo "</font>&nbsp;&nbsp;&nbsp;<strong>".$title."</strong></td></tr><tr><td class=newstbl><p align=justify>".$preview."</p></td></tr>";
}
echo "<tr><td height=15></td></tr>";
echo "</table>";
}
} // есть афиша
} // афиша

if ($wtbl == 'r')
{ // отчеты
$result = mysql_query("select * from $reporttable where ID=$tID");
if (@mysql_num_rows($result) != 0)
{ // есть отчет
$rows = mysql_num_rows($result);

for($k=0;$k < $rows;$k++)
   {
echo "<table width=90% border=0 cellspacing=8 cellpadding=2>";
    $preview=mysql_result($result, $k , "preview");
    $detail=mysql_result($result, $k , "detail");
    $title=mysql_result($result, $k , "title");
$title = eregi_replace("$qwerymark","<font color=red>$qwerymark</font>",$title);
    $idnum=mysql_result($result, $k , "ID");
    $datum=mysql_result($result, $k , "datum");
    $foto1=mysql_result($result, $k , "foto1");
    $dati=explode("-",$datum);
if ($preview != "") {
$preview = ereg_replace("\n","<br>",$preview);
$preview = ereg_replace("     ","&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$preview);
$preview = eregi_replace("$qwerymark","<font color=red>$qwerymark</font>",$preview);
if (eregi('ФОТО1',$preview) and $foto1 != ""){$preview=@str_replace('ФОТО1',"<img src=\"$afishadir$foto1\" border=0 align=left class=image>",$preview);}
}

                   if($preview=="") {
                   echo "<tr><td class=reptbltop>&nbsp;&nbsp;&nbsp;
                         <a href=\"report.php?link=$idnum\"><strong>".$title."</strong></a></td></tr>";
                         }
                   elseif($preview != "" and $detail != ""){
                         echo "<tr><td class=reptbltop>&nbsp;&nbsp;&nbsp;
                               <a href=\"report.php?link=$idnum\"><strong>".$title."</strong></a></td></tr><tr><td class=reptbl><p align=justify>".$preview;
                         echo "<br><a href=\"report.php?link=$idnum\">Подробнее</a>&nbsp;&raquo;</p></td></tr>";
                         }
                   elseif($preview != "" and $detail == "") {
                         echo "<tr><td class=reptbltop>&nbsp;&nbsp;&nbsp;
                               <strong>".$title."</strong></td></tr><tr><td class=reptbl><p align=justify>".$preview."</p></td></tr>";
                        }
                   echo "<tr><td height=15></td></tr>";
echo "</table>";
 }
} // есть отчеты
} // отчеты

} //1
echo "<p align=center class=text>$line<br><br>";
} // что-то найдено finded != ''
} // поиск по слову

if ((!isset($qwery) or $qwery == '') and !isset($page)) 
{
echo "<p align=center class=text><b>Нужно ввести строку для поиска</b><br><br>";
echo ("
<form name=search method=GET action=searchaf.php>
<table cellpadding=0 cellspacing=0 border=0>
<tr><td>Поиск: <input type=text name=qwery size=14></td>
<td><input type=submit name=submit value='Найти'></td>
</tr></table>
</form>
");
}
include("down.php");
?>