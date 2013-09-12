<?
session_start();
session_name()
?>
<!--/***************** DO NOT REMOVE! *********************/---->
<!--/*   Author: Nevezhyn Evgeny  Date : 01/09/2004       */---->
<!--/*   nevius@bk.ru      All Rights Reserved ...        */---->
<!--/*   http://nevius.ru/                                */---->
<!--/***************** DO NOT MODIFY! *********************/---->

<?php
include("var.php");
echo "<head><title>Отправка вакансии на резюме : $sitename</title>";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\"><META HTTP-EQUIV=\"Cache-Control\" CONTENT=\"No-Cache\">";
include("top.php");
$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);

$p=$_POST['p'];
$d=$_POST['d'];
$bn=$_POST['bn'];
if ($ident == 'session') {$REMOTE_ADDR=$PHPSESSID;}
if ($ident != 'session') {$REMOTE_ADDR=$_SERVER['REMOTE_ADDR'];}

$sid=$_SESSION['sid'];
$id=$_SESSION['sid'];
$slogin=$_SESSION['slogin'];
$spass=$_SESSION['spass'];

$result = @mysql_query("SELECT email,pass,category FROM $autortable WHERE (email = '$slogin' and pass = '$spass' and (category='rab' or category='agency'))");
if ((!isset($slogin) or !isset($spass)) or @mysql_num_rows($result) == 0)
{
echo "<center><br><br><h3>Вы не авторизированы как работодатель или агентство!</h3><b><a href=autor.php>Авторизация</a></b>";
}
else
{ //1
while($myrow=mysql_fetch_array($result)) {
$who=$myrow["category"];
}
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
//---------------main--------------
//
if ($_SERVER[QUERY_STRING] == "send")
{ //send

$vacID=$_POST['vacID'];

$body='';
$txtdown = "<br>Спасибо за пользование нашим сайтом!<br><a href=$siteadress>$sitename</a>";
$resultaut = @mysql_query("SELECT * FROM $autortable WHERE ID='$id'");
while ($myrow=mysql_fetch_array($resultaut)) {
$category=$myrow["category"];
$email=$myrow["email"];
$hidemail=$myrow["hidemail"];
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

$resultvac = @mysql_query("SELECT *,DATE_FORMAT(date,'%d.%m.%Y') as date,LPAD(ID,8,'0') as vID FROM $vactable WHERE ID=$vacID and status='ok' LIMIT 1");
if (@mysql_num_rows($resultvac) != 0)
{ //вакансия
while ($myrow=@mysql_fetch_array($resultvac)) 
{
$vID=$myrow["vID"];
$ID=$myrow["ID"];
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
}
$resultadd2 = @mysql_query("SELECT ID,podrazdel FROM $catable WHERE ID='$podrazdel'");
while($myrow=mysql_fetch_array($resultadd2)) {
$podrazdel1=$myrow["podrazdel"];
}
$resultadd1 = @mysql_query("SELECT ID,razdel,podrazdel FROM $catable WHERE podrazdel = '' and ID='$razdel'");
while($myrow=mysql_fetch_array($resultadd1)) {
$razdel1=$myrow["razdel"];
}

$body .= ("
<div align=left><table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$altcolor><td align=center><b>Вакансия $vID</b></td></tr></table></td></tr></table>
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$maincolor><td valign=top colspan=2><b>Предлагаемая должность:</b> $profecy</b>. Зарплата от <font color=blue><b>$zp</b></font> $valute<br></td></tr>
<tr bgcolor=$maincolor><td align=center colspan=2><b>Требования и условия</b></td></tr>
");
if ($agemin != 0 and $agemax == 0) {$body .= "<tr bgcolor=$maincolor><td>Возраст:</td><td>от $agemin лет</td></tr>";}
if ($agemin == 0 and $agemax != 0) {$body .= "<tr bgcolor=$maincolor><td>Возраст:</td><td>до $agemax лет</td></tr>";}
if ($agemin != 0 and $agemax != 0) {$body .= "<tr bgcolor=$maincolor><td>Возраст:</td><td>от $agemin до $agemax лет</td></tr>";}
if ($gender == 'Мужской') {$body .= "<tr bgcolor=$maincolor><td>Пол:</td><td>Мужской</td></tr>";}
if ($gender == 'Женский') {$body .= "<tr bgcolor=$maincolor><td>Пол:</td><td>Женский</td></tr>";}
if ($edu != '' and !eregi("важно",$edu)) {$body .= "<tr bgcolor=$maincolor><td>Образование:</td><td>$edu</td></tr>";}
if ($edu != '' and eregi("важно",$edu)) {$body .= "<tr bgcolor=$maincolor><td>Образование:</td><td>Любое</td></tr>";}
if ($zanatost != '' and !eregi("важно",$zanatost)) {$body .= "<tr bgcolor=$maincolor><td>Занятость:</td><td>$zanatost</td></tr>";}
if ($zanatost != '' and eregi("важно",$zanatost)) {$body .= "<tr bgcolor=$maincolor><td>Занятость:</td><td>Любая</td></tr>";}
if ($grafic != '' and !eregi("важно",$grafic)) {$body .= "<tr bgcolor=$maincolor><td>График&nbsp;работы:</td><td>$grafic</td></tr>";}
if ($grafic != '' and eregi("важно",$grafic)) {$body .= "<tr bgcolor=$maincolor><td>График&nbsp;работы:</td><td>Любой</td></tr>";}
if ($stage != '') {$body .= "<tr bgcolor=$maincolor><td>Опыт работы:</td><td>$stage</td></tr>";}
if ($treb != '') {$body .= "<tr bgcolor=$maincolor><td valign=top>Требования:</td><td>$treb</td></tr>";}
if ($obyaz != '') {$body .= "<tr bgcolor=$maincolor><td valign=top>Обязанности:</td><td>$obyaz</td></tr>";}
if ($uslov != '') {$body .= "<tr bgcolor=$maincolor><td valign=top>Условия:</td><td>$uslov</td></tr>";}
if ($citys != '' or $adress !='') {$body .= "<tr bgcolor=$maincolor><td valign=top>Место&nbsp;работы:</td><td>$citys $adress</td></tr>";}
if ($firm != '') {$body .= "<tr bgcolor=$maincolor><td valign=top>Организация (место работы):</td><td valign=top>$firm</td></tr>";}
} // вакансия

$body .= ("
<tr bgcolor=$maincolor><td colspan=2><a href=$siteadress/linkvac.php?link=$vacID>Просмотр вакансии</a></td></tr>
</table></td></tr></table></div>
");

$basketselectresult = @mysql_query("SELECT * FROM $resordertable WHERE (user = '$REMOTE_ADDR' and status='basket') order by ID DESC");
if (@mysql_num_rows($basketselectresult) != 0)
{ //s2
while ($myrow=mysql_fetch_array($basketselectresult)) 
{ //s3
$unitID=$myrow["ID"];
$unit=$myrow["unit"];
$number=$myrow["number"];
$result = @mysql_query("SELECT ID,aid,profecy FROM $restable WHERE ID=$unit and status='ok'");
while ($myrow=@mysql_fetch_array($result)) 
{ //s4
$resID=$myrow["ID"];
$resaid=$myrow["aid"];
$resprofecy=$myrow["profecy"];
$txttop = ("
Здравствуйте!<br>
На ваше резюме <a href=\"$siteadress/linkres.php?link=$resID\"><b>$resprofecy</b></a><br>
размещенную на сайте <a href=$siteadress>$sitename</a> отправлена вакансия.<br><br>
");
$resultaut = @mysql_query("SELECT ID,email FROM $autortable WHERE ID='$resaid'");
while ($myrow=mysql_fetch_array($resultaut)) 
{ //s5
$resemail=$myrow["email"];
$rastext = $txttop.$body.$txtdown;
mail($resemail,"Вакансия на ваше резюме на сайте $sitename",$rastext,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/html; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");
} //s5
} //s4
} //s3
} //s2
$delresult=@mysql_query("delete from $resordertable where (user = '$REMOTE_ADDR' and unit=$p and status='basket')");
echo "<h3 align=center class=tbl1>Вакансия отправлена!</h3><br><br>";
} //send
//---------------main--------------
}//1
include("down.php");
?>