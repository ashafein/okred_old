<?
session_start();
session_name()
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
$maxThread=12;
$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);

$r=$_GET['r'];
$c=$_GET['c'];
$ord=$_GET['ord'];
$page=$_GET['page'];

echo "<title>Галерея соискателей : $sitename</title>";

include("top.php");

if ($srcity != '')
{ // city
if (eregi("^[r]",$srcity)) {
$srcityshow1=@substr($srcity,1,1000);
$qwery1="and $restable.country = '$srcityshow1'";
}
if (eregi("^[p]",$srcity)) {
$srcityshow1=@substr($srcity,1,1000);
$qwery1="and $restable.region = '$srcityshow1'";
}
if (eregi("^[c]",$srcity)) {
$srcityshow1=@substr($srcity,1,1000);
$qwery1="and $restable.city = '$srcityshow1'";
}
} // city
if ($srcity == "") {$qwery1='';}

//

$srrazdel=$_GET['srrazdel'];
$srpodrazdel=$_GET['srpodrazdel'];

if (isset($srpodrazdel) and $srpodrazdel != '')
{
$resultadd2 = @mysql_query("SELECT * FROM $catable WHERE ID='$srpodrazdel' LIMIT 1");
while($myrow=mysql_fetch_array($resultadd2)) {
$podrazdelsh=$myrow["podrazdel"];
}
}
$resultadd1 = @mysql_query("SELECT * FROM $catable WHERE ID='$srrazdel' LIMIT 1");
while($myrow=mysql_fetch_array($resultadd1)) {
$razdelsh=$myrow["razdel"];
}

echo ("
<h3 align=center>Галерея соискателей</h3>
Сфера деятельности: 
<select name=srrazdel size=1 onChange=location.href=location.pathname+\"?srrazdel=\"+value+\"\";>
");
if ($razdelsh=='')
{
echo ("
<option selected value=>Любая</option>
");
}
if ($razdelsh != '')
{
echo ("
<option selected value=\"$srrazdel\">$razdelsh</option>
<option value=>Любая</option>
");
}
$result2 = @mysql_query("SELECT * FROM $catable WHERE podrazdel = '' order by razdel");
while($myrow=mysql_fetch_array($result2)) {
$razdel1=$myrow["razdel"];
$razdel1ID=$myrow["ID"];
echo "<option value=\"$razdel1ID\">$razdel1</option>";
}
echo ("
</select>&nbsp;&nbsp; 
");
if ($srrazdel != '')
{
$result3 = @mysql_query("SELECT * FROM $catable WHERE podrazdel != '' and razdel='$razdelsh' order by podrazdel");
if (@mysql_num_rows($result3) != 0) {
echo ("
Раздел: 
<select name=srpodrazdel size=1 onChange=location.href=location.pathname+\"?srrazdel=$srrazdel&srpodrazdel=\"+value+\"\";>
");
if ($podrazdelsh == '')
{
echo ("
<option selected value=>Любой</option>
");
}
if ($podrazdelsh != '')
{
echo ("
<option selected value=\"$srpodrazdel\">$podrazdelsh</option>
<option value=>Любой</option>
");
}
while($myrow=mysql_fetch_array($result3)) {
$podrazdel1=$myrow["podrazdel"];
$podrazdel1ID=$myrow["ID"];
echo "<option value=\"$podrazdel1ID\">$podrazdel1</option>";
}
echo ("
</select>
");
}
}

if ($srpodrazdel != '') {$qwerypodrazdel="and $restable.podrazdel = $srpodrazdel";}
if ($srpodrazdel == '') {$qwerypodrazdel="";}
if ($srrazdel != '') {$qweryrazdel="and $restable.razdel = $srrazdel";}
if ($srrazdel == '') {$qweryrazdel="";}

$result = @mysql_query("SELECT $restable.ID as resID,$restable.razdel,$restable.podrazdel,$restable.profecy,$restable.status,$restable.top,$restable.aid,$restable.city,$restable.region,$restable.country,$autortable.ID as autID,$autortable.foto1 FROM $restable,$autortable WHERE $restable.status='ok' and $autortable.foto1 != '' and $restable.aid=$autortable.ID $qweryrazdel $qwerypodrazdel $qwery1");
$totaltexts=@mysql_num_rows($result);
if (!isset($maxThread) or $maxThread=='') {$maxThread = 10;}
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
  if ($k != $page) {$line .= "<a href=\"gallery.php?srrazdel=$srrazdel&srpodrazdel=$srpodrazdel&page=$k\"> $k </a>|";}
  if ($k == $page) {$line .= " $k |";}
}
if ($totaltexts == 0) {
echo "<center><b>Нет фото</b><br><br>";
}
elseif ($totaltexts != 0)
{ //2
$result = @mysql_query("SELECT $restable.ID as resID,$restable.razdel,$restable.podrazdel,$restable.profecy as resprofecy,$restable.status,$restable.top,$restable.aid as resaid,$restable.city,$restable.region,$restable.country,$autortable.ID as autID,$autortable.foto1 as autfoto1 FROM $restable,$autortable WHERE $restable.status='ok' and $autortable.foto1 != '' and $restable.aid=$autortable.ID $qweryrazdel $qwerypodrazdel $qwery1 order by $restable.top DESC LIMIT $initialMsg, $maxThread");
echo ("
<table border=0 cellpadding=0 cellspacing=8><tr><td>
");
$st=0;
while ($myrow=@mysql_fetch_array($result)) 
{ //4
$ID=$myrow["resID"];
$profecy=$myrow["resprofecy"];
$aid=$myrow["resaid"];
$foto1=$myrow["autfoto1"];
if ($st >= 4) {
$st=0; echo "</td></tr><tr><td align=center>";
}
if ($st < 4) {
echo "</td><td align=center>";
}

$fotourl=$foto1;
if (file_exists($photodir.'s'.$fotourl)) {$fotourl="s$fotourl";}
echo "<a href=\"photo.php?link=$aid&f=$photodir$foto1&w=a\" target=_blank><img src=\"$photodir$fotourl\" height=$smallfotoheight alt=\"Увеличить\" border=0></a><br><a href=linkres.php?link=$ID>$profecy</a>";
$st=$st+1;
} //4


echo "</td></tr></table>";
echo "<p align=center class=tbl1>$line<br><br>";
}
include("down.php");
?>