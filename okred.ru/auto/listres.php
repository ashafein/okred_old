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
$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);

$updres=mysql_query("update $restable set top='0000-00-00 00:00:00' where ((top + INTERVAL 86400*$periodfortop SECOND) < now())");
$updres=mysql_query("update $restable set bold='0000-00-00 00:00:00' where ((bold + INTERVAL 86400*$periodforbold SECOND) < now())");

$r=$_GET['r'];
$c=$_GET['c'];
$maxThread=$_GET['maxThread'];
$ord=$_GET['ord'];
$page=$_GET['page'];


if ($r=='' and $c=='') {echo "<title>Резюме : $sitename</title>";}

if ($r != '')
{
$resultadd2 = @mysql_query("SELECT ID,podrazdel FROM $catable WHERE ID='$c'");
while($myrow=mysql_fetch_array($resultadd2)) {
$titpodrazdel=$myrow["podrazdel"];
$titpodrazdel=" : $titpodrazdel";
}
$resultadd1 = @mysql_query("SELECT ID,razdel,podrazdel FROM $catable WHERE podrazdel = '' and ID='$r'");
while($myrow=mysql_fetch_array($resultadd1)) {
$titrazdel=$myrow["razdel"];
}
echo "<title>Резюме : $titrazdel $titpodrazdel $sitename</title>";
}

echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\"><META HTTP-EQUIV=\"Cache-Control\" CONTENT=\"No-Cache\">";
include("top.php");

if ($srcity != '')
{ // city
if (eregi("^[r]",$srcity)) {
$srcityshow1=@substr($srcity,1,1000);
$qwery1="and country = '$srcityshow1'";
}
if (eregi("^[p]",$srcity)) {
$srcityshow1=@substr($srcity,1,1000);
$qwery1="and region = '$srcityshow1'";
}
if (eregi("^[c]",$srcity)) {
$srcityshow1=@substr($srcity,1,1000);
$qwery1="and city = '$srcityshow1'";
}
} // city
if ($srcity == "") {$qwery1='';}

$p=$_GET['p'];
$d=$_GET['d'];
$bn=$_GET['bn'];
if ($ident == 'session') {$REMOTE_ADDR=$PHPSESSID;}
if ($ident != 'session') {$REMOTE_ADDR=$_SERVER['REMOTE_ADDR'];}
$n = getenv('REQUEST_URI');
// ------------del old------------
$expdate = date("Y-m-d H:i:s", time()- $delperiod*86400);
$delitemdb=mysql_query("delete from $resordertable where date < '$expdate'");
// ------------del old------------
//
// ------------basket------------
//
if (isset($p) and $p != "")
{ //additem
$selectresult = @mysql_query("SELECT * FROM $resordertable WHERE (user = '$REMOTE_ADDR' and unit=$p and status='basket')");
if (@mysql_num_rows($selectresult) == 0)
{
$sql="insert into $resordertable (user,unit,number,date,status) values ('$REMOTE_ADDR',$p,1,now(),'basket')";
$addresult=@mysql_query($sql,$db);
}
} //additem
elseif (isset($d) and $d != "")
{ //removeitem
$selectresult = @mysql_query("SELECT * FROM $resordertable WHERE (user = '$REMOTE_ADDR' and unit=$d and status='basket')");
if (@mysql_num_rows($selectresult) != 0)
{
$delresult=@mysql_query("delete from $resordertable where (user = '$REMOTE_ADDR' and unit=$d and status='basket')");
}
} //removeitem
if (isset($bn) and $bn != "")
{ //count
for ($ib=0;$ib<count($bn);$ib++){
if (eregi("[0-9]+",$bn[$ib]) and $bn[$ib] != 0)
{$result=@mysql_query("update $resordertable set number=$bn[$ib],date=now() WHERE ID=$mess[$ib]");}
unset($result);
}
} //count
//
// ------------basket------------
//
if (!isset($r) or $r=='')
{ //norazdel
$result = @mysql_query("SELECT * FROM $restable WHERE status='ok' $qwery1");
$totalres=@mysql_num_rows($result);
unset($result);
echo ("
<table border=0 width=100% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=4 width=100% class=tbl1>
<tr bgcolor=$altcolor><td><a href=listres.php><b>Резюме</b></a></td><td width=40>$totalres</td></tr>
");
$result = @mysql_query("SELECT * FROM $catable WHERE podrazdel='' order by razdel");
$sum=@mysql_num_rows($result);
while($myrow=mysql_fetch_array($result)) {
$mid=$myrow["ID"];
$razdel=$myrow["razdel"];
$resultmf1 = @mysql_query("SELECT * FROM $restable WHERE razdel='$mid' and status='ok' $qwery1");
$totmf1=@mysql_num_rows($resultmf1);
$resultmdf1 = @mysql_query("SELECT * FROM $catable WHERE razdel='$razdel' and podrazdel != ''");
if (@mysql_num_rows($resultmdf1) != 0) {echo "<tr bgcolor=$maincolor><td><a href=\"listres.php?r=$mid\">$razdel</a></td><td width=40>$totmf1</td></tr>";}
if (@mysql_num_rows($resultmdf1) == 0) {echo "<tr bgcolor=$maincolor><td><a href=\"listres.php?r=$mid&c=0\">$razdel</a></td><td width=40>$totmf1</td></tr>";}
}
echo "</table></td></tr></table>";
} //norazdel

elseif (isset($r) and $r != '')
{ // razdel
if (!isset($c) or $c == '')
{ // no podrazdel
$resultadd1 = @mysql_query("SELECT ID,razdel,podrazdel FROM $catable WHERE podrazdel = '' and ID='$r'");
while($myrow=mysql_fetch_array($resultadd1)) {
$razdel=$myrow["razdel"];
}
$resultmdf1 = @mysql_query("SELECT * FROM $catable WHERE razdel='$razdel' and podrazdel != '' order by podrazdel");
if (@mysql_num_rows($resultmdf1) != 0) {
$result = @mysql_query("SELECT * FROM $restable WHERE status='ok' and razdel=$r $qwery1");
$totalres=@mysql_num_rows($result);
echo ("
<table border=0 width=100% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=4 width=100% class=tbl1>
<tr bgcolor=$altcolor><td><a href=listres.php?r=$r><b>$razdel</b></a></td><td width=40>$totalres</td></tr>
");
while($myrow=mysql_fetch_array($resultmdf1)) {
$moid=$myrow["ID"];
$podrazdel=$myrow["podrazdel"];
$resultmdf2 = @mysql_query("SELECT * FROM $restable WHERE podrazdel='$moid' and status='ok' $qwery1");
$totalmdf2=@mysql_num_rows($resultmdf2);
echo "<tr bgcolor=$maincolor><td><a href=\"listres.php?r=$r&c=$moid\">$podrazdel</a></td><td>$totalmdf2</td>";
}
echo "</table></td></tr></table>";
}
} // no podrazdel

if (isset($c) and $c != '')
{ // list
$result = @mysql_query("SELECT * FROM $restable WHERE razdel='$r' and podrazdel='$c' and status='ok' $qwery1");
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
$line = "<ul>";
for ($k = 1; $k <= $pages; $k++) {
  if ($k != $page) {$line .= "<li><a href=\"listres.php?r=$r&c=$c&maxThread=$maxThread&ord=$ord&page=$k\"> $k </a></li>";}
  if ($k == $page) {$line .= "<li> $k </li>";}
}
$line .= "</ul>";

$resultadd2 = @mysql_query("SELECT ID,podrazdel FROM $catable WHERE ID='$c'");
while($myrow=mysql_fetch_array($resultadd2)) {
$podrazdel=$myrow["podrazdel"];
}
$resultadd1 = @mysql_query("SELECT ID,razdel,podrazdel FROM $catable WHERE podrazdel = '' and ID='$r'");
while($myrow=mysql_fetch_array($resultadd1)) {
$razdel=$myrow["razdel"];
}
$resultmdf1 = @mysql_query("SELECT * FROM $catable WHERE razdel='$razdel' and podrazdel != ''");
//if (@mysql_num_rows($resultmdf1) != 0) {echo "<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0 align=center><tr><td><table width=100% border=0 cellpadding=1 cellspacing=1 class=tbl1><tr bgcolor=$altcolor><td align=left><b><a href=listres.php>Резюме</a> : <a href=listres.php?r=$r>$razdel</a> : <a href=listres.php?r=$r&c=$c>$podrazdel</a></b></td></tr></table></td></tr></table><br>";}
//if (@mysql_num_rows($resultmdf1) == 0) {echo "<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0 align=center><tr><td><table width=100% border=0 cellpadding=1 cellspacing=1 class=tbl1><tr bgcolor=$altcolor><td align=left><b><a href=listres.php>Резюме</a> : <a href=listres.php?r=$r&c=0>$razdel</a></b></td></tr></table></td></tr></table><br>";}
if ($totaltexts == 0) {
echo "<center><b>В данной категории пока нет объявлений!</b><br><br><a href=# onClick=history.go(-1)>Вернуться назад</a><br><br>";
}
elseif ($totaltexts != 0)
{ //2

echo ("
<p class=\"path\"> Сортировать  <a href=\"listres.php?r=$r&c=$c&maxThread=$maxThread&ord=date\">по дате</a> <a href=\"listres.php?r=$r&c=$c&maxThread=$maxThread&ord=zp\">по зарплате</a></p>
");

if (!isset($ord) or $ord == "") {$qweryord='date DESC';}
if (isset($ord) and $ord != "") {$qweryord=$ord;}
$result = @mysql_query("SELECT *,CURRENT_DATE,(YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) AS age,DATE_FORMAT(date,'%d.%m.%Y') as dateq FROM $restable WHERE razdel='$r' and podrazdel='$c' and status='ok' $qwery1 order by top DESC,$qweryord LIMIT $initialMsg, $maxThread");
while ($myrow=@mysql_fetch_array($result)) 
{ //4
$ID=$myrow["ID"];
$profecy=$myrow["profecy"];
$zp=$myrow["zp"];
$grafic=$myrow["grafic"];
$zanatost=$myrow["zanatost"];
$aid=$myrow["aid"];

$country=$myrow["country"];
$region=$myrow["region"];
$city=$myrow["city"];

$citytar=$city;
if ($city=='0') {$citytar=$region;}
if ($region=='0' and $city=='0') {$citytar=$country;}
$resultadd3c = @mysql_query("SELECT * FROM $citytable WHERE ID='$citytar'");
while($myrowc=mysql_fetch_array($resultadd3c)) {
$citys=$myrowc["categ"];
if ($city=='0') {$citys=$myrowc["podrazdel"];}
if ($city=='0' and $region=='0') {$citys=$myrowc["razdel"];}
}

$bold=$myrow["bold"];
$boldstl='';
if ($bold != '0000-00-00 00:00:00') {$boldstl="style=\"font-weight: bold;\"";}

$resultaut = @mysql_query("SELECT *,CURRENT_DATE,(YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) AS age FROM $autortable WHERE ID='$aid'");
while ($myrow1=mysql_fetch_array($resultaut)) {
$prof=$myrow1["prof"];
$gender=$myrow1["gender"];
$age=$myrow1["age"];
$category=$myrow1["category"];
}
if ($category == 'agency')
{
$age=$myrow["age"];
$gender=$myrow["gender"];
$prof=$myrow["prof"];
}
$date=$myrow["dateq"];
$razdel=$myrow["razdel"];
$podrazdel=$myrow["podrazdel"];
$resultadd2 = @mysql_query("SELECT ID,podrazdel FROM $catable WHERE ID='$podrazdel'");
while($myrow=mysql_fetch_array($resultadd2)) {
$podrazdel1=$myrow["podrazdel"];
}
$resultadd1 = @mysql_query("SELECT ID,razdel,podrazdel FROM $catable WHERE podrazdel = '' and ID='$razdel'");
while($myrow=mysql_fetch_array($resultadd1)) {
$razdel1=$myrow["razdel"];
}
$selectresult = @mysql_query("SELECT * FROM $resordertable WHERE (user = '$REMOTE_ADDR' and unit=$ID and status='basket')");
if (@mysql_num_rows($selectresult) == 0)
{$pic='add.gif';$al='p';$sst='Добавить закладку';}
if (@mysql_num_rows($selectresult) != 0)
{$pic='remove.gif';$al='d';$sst='Удалить закладку';}

echo ("
<table width=100% border=0 class=\"vacanc\">
  <tr>
    <td height=43 class=\"vac-title\"><a href=\"linkres.php?link=$ID\">$profecy</a></td>
    <td class=\"zp-vac\">
");

if ($zp != 0) {echo "$zp $valute";}

echo ("
</td>
    <td> $citys</td>
  </tr>
  <tr valign=top class=\"company\">
    <td height=25  class=\"company\">
");

if ($gender == 'Мужской') {$br=1; echo "Мужчина&nbsp";}
if ($gender == 'Женский') {$br=1; echo "Женщина&nbsp";}
if ($age != 0) {$br=1; echo "$age лет(года)";}

echo ("
</td>
    <td>$date</td>
    <td><a href=\"listres.php?r=$r&c=$c&page=$page&maxThread=$maxThread&$al=$ID\">$sst</a></td>
  </tr>
</table>
");

} //4

echo "<div class=\"pages\">$line</div>";

} //2

} //list
} // razdel
$basketurl="listres.php?r=$r&c=$c&page=$page&maxThread=$maxThread";
include("down.php");
?>