<?
session_start();

if ($_SERVER[QUERY_STRING] == "selcity") {
if ($_POST['city'] != '') {$srcity="c".$_POST['city'];}
if ($_POST['city'] == '' and $_POST['region'] != '') {$srcity="p".$_POST['region'];}
if ($_POST['city'] == '' and $_POST['region'] == '' and $_POST['country'] != '') {$srcity="p".$_POST['country'];}
if ($city != '') {$srcity="c$city";}
if ($city == '' and $region != '') {$srcity="p$region";}
if ($city == '' and $region == '' and $country != '') {$srcity="r$country";}
if ($city == '' and $region == '' and $country == '') {$srcity="";}
if (isset($srcity) and $srcity != '') {setcookie("srcitymy",$srcity,time()+864000);}
if (isset($srcity) and $srcity == '') {setcookie("srcitymy");}
}

if (isset($_GET['srcity']) and $_GET['srcity'] != '') {$srcity=$_GET['srcity']; setcookie("srcitymy",$srcity,time()+864000);}
if (isset($_GET['srcity']) and $_GET['srcity'] == '') {setcookie("srcitymy");$srcity='';}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<?php
include("var.php");
echo"<title>$sitename</title>";
echo "<META HTTP-EQUIV=\"Cache-Control\" CONTENT=\"No-Cache\">";
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

$result = @mysql_query("SELECT status,country,region,city FROM $vactable WHERE status='ok' $qwery1");
$vactot=@mysql_num_rows($result);
$result = @mysql_query("SELECT status,date,country,region,city FROM $vactable WHERE status='ok' $qwery1 and ((date + INTERVAL 86400 SECOND) > now())");
$vacday=@mysql_num_rows($result);
$result = @mysql_query("SELECT status,country,region,city FROM $restable WHERE status='ok' $qwery1");
$restot=@mysql_num_rows($result);
$result = @mysql_query("SELECT status,date,country,region,city FROM $restable WHERE status='ok' $qwery1 and ((date + INTERVAL 86400 SECOND) > now())");
$resday=@mysql_num_rows($result);
$result = @mysql_query("SELECT category,country,region,city FROM $autortable WHERE category='agency' $qwery1");
$agetot=@mysql_num_rows($result);
$result = @mysql_query("SELECT category,country,region,city FROM $autortable WHERE category='rab' $qwery1");
$rabtot=@mysql_num_rows($result);
$result = @mysql_query("SELECT ID FROM $rasvac");
$rasvactot=@mysql_num_rows($result);
$result = @mysql_query("SELECT ID FROM $rasres");
$rasrestot=@mysql_num_rows($result);
?>

<div class="hot-vac">
<table width="100%" border="0" class="icons">
    <td valign="middle"><a href="addvac.php"><img src="images/vac.jpg" width="95" height="73" alt="создать вакансию" /><br />
Создать вакансию</a></td>
    <td><a href="searchv.php"><img src="images/vac-seach.jpg" width="95" height="73" alt="найти вакансию" /><br />
      Найти вакансию</a></td>
  </tr>
  <tr>
    <td><a href="searchr.php"><img src="images/rez-seach.jpg" width="95" height="73" alt="найти резюме" /><br />
Найти резюме</a></td>
    <td><a href="addres.php"><img src="images/rez.jpg" width="95" height="73" alt="разместить резюме" /><br />
      Разместить резюме</a></td>
  </tr>
</table>
   </div><!--hot-vac-->

<?
//<!-- рекламный блок начало -->
if ($qwerypromo == '')
{
$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'beforenew' order by allcity DESC,RAND() limit $promobeforenewlimit");
}
if ($qwerypromo != '')
{
$resultprtop = mysql_query("select * from $promotable where status='ok' and wheres = 'beforenew' $qwerypromo order by city DESC,date DESC limit $promobeforenewlimit");
}
 $rows = mysql_num_rows($resultprtop);
if($rows != 0)
{
while($myrow=mysql_fetch_array($resultprtop))
{
$ptitle=$myrow["title"];
$plink=$myrow["link"];
$pfoto=$myrow["foto"];
if ($pfoto != '') {echo "<div align=center><table border=0 bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=1 width=100% class=tbl1><tr bgcolor=$maincolor><td><a href=\"$plink\" title='$ptitle' target=_blank><img src=\"$pfoto\" alt=\"$ptitle\" border=0></a></td></tr></table></td></tr></table></div><br />";}
if ($pfoto == '') {echo "<div align=center><table border=0 bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=1 width=100% class=tbl1><tr bgcolor=$maincolor><td><a href=\"$plink\" title='$ptitle' target=_blank>$ptitle</a></td></tr></table></td></tr></table></div><br />";}
}
}
//<!-- рекламный блок конец -->
?>

<h1>Вакансии недели. Москва</h1>

  <table width="100%" border="0">

<?
$resultn = @mysql_query("SELECT * FROM $vactable WHERE status='ok' and dayof='yes' $qwery1 order by RAND() LIMIT $mainpagedaylimit");
$totaltextsn=@mysql_num_rows($resultn);
if ($totaltextsn != 0) {
while($myrow=mysql_fetch_array($resultn)) {
$wid=$myrow["ID"];
$profecy=$myrow["profecy"];
$zp=$myrow["zp"];
$aid=$myrow["aid"];

$resultaut = @mysql_query("SELECT * FROM $autortable WHERE ID='$aid'");
while ($myrow=mysql_fetch_array($resultaut)) {
$acountry=$myrow["country"];
$aregion=$myrow["region"];
$acity=$myrow["city"];

$citytar=$acity;
if ($acity=='0') {$citytar=$aregion;}
if ($aregion=='0' and $acity=='0') {$citytar=$acountry;}
$resultadd3c = @mysql_query("SELECT * FROM $citytable WHERE ID='$citytar'");
while($myrowc=mysql_fetch_array($resultadd3c)) {
$acitys=$myrowc["categ"];
if ($acity=='0') {$acitys=$myrowc["podrazdel"];}
if ($acity=='0' and $aregion=='0') {$acitys=$myrowc["razdel"];}
}
$afirm=$myrow["firm"];
}

echo ("
   <tr>
    <td width=\"333\" valign=\"top\"><a href=\"linkvac.php?link=$wid\">$profecy</a></td>
     <td width=\"39\" valign=\"top\" class=\"vac_week\"></td>
     <td width=\"229\" valign=\"top\">$afirm, $acitys</td>
   
   <td valign=\"top\" width=\"202\" class=\"red\">
");

if ($zp != 0) {echo "$zp $valute</font>";}

echo ("
</td>
  </tr>  
");
}
}
 
echo "</table>";

include("down.php");
?>