<?
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
echo "<head>";
include("var.php");

$link=$_GET['link'];

echo "<title>Вакансия #$link : $sitename</title>";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\"><META HTTP-EQUIV=\"Cache-Control\" CONTENT=\"No-Cache\">";
include("top.php");
$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);
$sid=$_SESSION['sid'];
$id=$_SESSION['sid'];
$slogin=$_SESSION['slogin'];
$spass=$_SESSION['spass'];
$result = @mysql_query("SELECT email,pass FROM $autortable WHERE (email = '$slogin' and pass = '$spass')");
if ((!isset($slogin) or !isset($spass)) or @mysql_num_rows($result) == 0)
{
echo "<center><br><br><h3>Вы не авторизированы!</h3><b><a href=autor.php>Авторизация</a></b>";
}
else
{ //1
if (isset($link) and $link != '') 
{ //link
$result = @mysql_query("SELECT *,DATE_FORMAT(date,'%d.%m.%Y') as date,LPAD(ID,8,'0') as ID FROM $vactable WHERE ID=$link");
if (@mysql_num_rows($result) == 0) {
echo "<center>Объявление не определено!<br><br><br><br>";
}
else
{ //ok
while ($myrow=@mysql_fetch_array($result)) 
{ //4
$tID=$myrow["ID"];
$profecy=$myrow["profecy"];
$agemin=$myrow["agemin"];
$agemax=$myrow["agemax"];
$edu=$myrow["edu"];
$zp=$myrow["zp"];
$gender=$myrow["gender"];
$grafic=$myrow["grafic"];
$zanatost=$myrow["zanatost"];
$stage=$myrow["stage"];
$treb=$myrow["treb"];
$obyaz=$myrow["obyaz"];
$uslov=$myrow["uslov"];
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

$adress=$myrow["adress"];
$firm=$myrow["firm"];
$aid=$myrow["aid"];
$date=$myrow["date"];
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
$resultaut = @mysql_query("SELECT * FROM $autortable WHERE ID='$aid'");
while ($myrow=mysql_fetch_array($resultaut)) {
$category=$myrow["category"];
$email=$myrow["email"];
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

$telephone=$myrow["telephone"];
$aadress=$myrow["adress"];
$url=$myrow["url"];
$fio=$myrow["fio"];
$afirm=$myrow["firm"];
}

echo ("
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$altcolor><td align=center><b>Вакансия $link</b></td></tr></table></td></tr></table>
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$maincolor><td valign=top colspan=2><b>Предлагаемая должность:</b> $profecy</b>. Зарплата от <font color=blue><b>$zp</b></font> $valute<br></td></tr>
<tr bgcolor=$maincolor><td align=center colspan=2><b>Требования и условия</b></td></tr>
");
if ($agemin != 0 and $agemax == 0) {echo "<tr bgcolor=$maincolor><td>Возраст:</td><td>от $agemin лет</td></tr>";}
if ($agemin == 0 and $agemax != 0) {echo "<tr bgcolor=$maincolor><td>Возраст:</td><td>до $agemax лет</td></tr>";}
if ($agemin != 0 and $agemax != 0) {echo "<tr bgcolor=$maincolor><td>Возраст:</td><td>от $agemin до $agemax лет</td></tr>";}
if ($gender == 'Мужской') {echo "<tr bgcolor=$maincolor><td>Пол:</td><td>Мужской</td></tr>";}
if ($gender == 'Женский') {echo "<tr bgcolor=$maincolor><td>Пол:</td><td>Женский</td></tr>";}
if ($edu != '' and !eregi("важно",$edu)) {echo "<tr bgcolor=$maincolor><td>Образование:</td><td>$edu</td></tr>";}
if ($edu != '' and eregi("важно",$edu)) {echo "<tr bgcolor=$maincolor><td>Образование:</td><td>Любое</td></tr>";}
if ($zanatost != '' and !eregi("важно",$zanatost)) {echo "<tr bgcolor=$maincolor><td>Занятость:</td><td>$zanatost</td></tr>";}
if ($zanatost != '' and eregi("важно",$zanatost)) {echo "<tr bgcolor=$maincolor><td>Занятость:</td><td>Любая</td></tr>";}
if ($grafic != '' and !eregi("важно",$grafic)) {echo "<tr bgcolor=$maincolor><td>График&nbsp;работы:</td><td>$grafic</td></tr>";}
if ($grafic != '' and eregi("важно",$grafic)) {echo "<tr bgcolor=$maincolor><td>График&nbsp;работы:</td><td>Любой</td></tr>";}
if ($stage != '') {echo "<tr bgcolor=$maincolor><td>Опыт работы:</td><td>$stage</td></tr>";}
if ($treb != '') {echo "<tr bgcolor=$maincolor><td valign=top>Требования:</td><td>$treb</td></tr>";}
if ($obyaz != '') {echo "<tr bgcolor=$maincolor><td valign=top>Обязанности:</td><td>$obyaz</td></tr>";}
if ($uslov != '') {echo "<tr bgcolor=$maincolor><td valign=top>Условия:</td><td>$uslov</td></tr>";}
if ($citys != '' or $adress !='') {echo "<tr bgcolor=$maincolor><td valign=top>Место&nbsp;работы:</td><td>$citys $adress</td></tr>";}
if ($firm != '') {echo "<tr bgcolor=$maincolor><td valign=top>Организация (место работы):</td><td valign=top>$firm</td></tr>";}
echo ("
<tr bgcolor=$maincolor><td align=center colspan=2><b>Контактная информация</b></td></tr>
");
if ($category=='rab' and $afirm != '') {echo "<tr bgcolor=$maincolor><td valign=top>Организация:</td><td>$afirm</td></tr>";}
if ($category=='agency' and $afirm != '') {echo "<tr bgcolor=$maincolor><td valign=top>Кадровое агентство:</td><td>$afirm</td></tr>";}
if ($acitys != '') {echo "<tr bgcolor=$maincolor><td valign=top>Город:</td><td>$acitys</td></tr>";}
if ($aadress != '') {echo "<tr bgcolor=$maincolor><td valign=top>Адрес:</td><td>$aadress</td></tr>";}
if ($telephone != '') {echo "<tr bgcolor=$maincolor><td valign=top>Телефон:</td><td>$telephone</td></tr>";}
if ($email != '') {echo "<tr bgcolor=$maincolor><td valign=top>Email:</td><td><a href=mailto:$email>$email</a></td></tr>";}
if ($url != '') {echo "<tr bgcolor=$maincolor><td valign=top>URL:</td><td><a href=$url target=_blank>$url</a></td></tr>";}
} //4
echo ("
</table></td></tr></table>
");
} // ok
} // link
}//1

include("down.php");
?>