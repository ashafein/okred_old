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
<META NAME=ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<?php
include("var.php");
echo"<title>Редактирование вакансии : $sitename</title>";
include("top.php");
echo "<div class=tbl1>";
echo "<table width=100% align=left bgcolor=$altcolor><tr><td><b>Редактирование вакансии</b></td></tr></table><br><br><center>";

if (isset($_POST['razdel'])) {$razdel = ereg_replace("--",",",$_POST['razdel']);}
if (isset($_GET['razdel'])) {$razdel = ereg_replace("--",",",$_GET['razdel']);}

$sid=$_SESSION['sid'];
$id=$_SESSION['sid'];
$slogin=$_SESSION['slogin'];
$spass=$_SESSION['spass'];

$maxmage = 3;
$maxzp = 8;
$maxprofecy = 50;
$maxcomment = 1000;
$maxstage = 50;
$maxcity = 50;
$maxfirm = 100;
$maxadress = 200;
$err1 = "Предлагаемая должность должна быть не длинее $maxprofecy символов<br>";
$err2 = "Возраст должен быть не длинее $maxmage символов<br>";
$err3 = "Зарплата должна быть не длинее $maxzp символов<br>";
$err4 = "Стаж работы должен быть не длинее $maxstage символов<br>";
$err5 = "Текст Требований должен быть не длинее $maxcomment символов<br>";
$err6 = "Текст Обязанностей должен быть не длинее $maxcomment символов<br>";
$err7 = "Текст Условий должен быть не длинее $maxcomment символов<br>";
$err8 = "Название организации должно быть не длинее $maxfirm символов<br>";
$err9 = "Город должен быть не длинее $maxcity символов<br>";
$err10 = "Поле Местонахождение должно быть не длинее $maxadress символов<br>";
$err11 = "Не заполнено обязательное поле - Сфера деятельности!<br>";
$err12 = "Не заполнено обязательное поле - Раздел!<br>";
$err13 = "Не заполнено обязательное поле - Предлагаемая должность!<br>";
$err14 = "Не заполнено обязательное поле - Требования!<br>";
$err15 = "Не заполнено обязательное поле - Зарплата от...!<br>";
$err16 = "Не заполнено обязательное поле - Город!<br>";
$err17 = "Не заполнено обязательное поле - Период размещения!<br>";
$err18 = "Пожалуйста проверьте правильность E-mail адреса!<br>";
$error = "";
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
$result = @mysql_query("SELECT email,pass,category FROM $autortable WHERE (email = '$slogin' and pass = '$spass')");

if ($_GET['texid'] == '') {$texid=$_POST['texid'];}
elseif ($_GET['texid'] != '') {$texid=$_GET['texid'];}
$REMOTE_ADDR=$_SERVER['REMOTE_ADDR'];

if ((!isset($slogin) or !isset($spass)) or @mysql_num_rows($result) == 0)
{
if (isset($texid))
{echo "<center><br><br><h3>Вы не авторизированы!</h3><b><a href=autor.php>Авторизация</a></b>";}
if (!isset($texid))
{echo "<center><br><br><h3>Объявление не определено!</h3><b><a href=autor.php>Авторизация</a></b>";}
}
else
{//0
while($myrow=mysql_fetch_array($result)) {
$who=$myrow["category"];
}
$resultban = @mysql_query("SELECT * FROM $bunsiptable WHERE bunsip = '$REMOTE_ADDR'");
if (@mysql_num_rows($resultban) != 0) {
while($myrow=mysql_fetch_array($resultban)) {
$ID=$myrow["ID"];
$bunsip=$myrow["bunsip"];
$bunwhy=$myrow["why"];
}
echo "<p align=center><font color=red>Доступ к функциям авторского раздела для вас, к сожалению, закрыт!</font></p><blockquote><p align=justify><b>Причина:</b> $bunwhy</p><br><br>";
}
elseif (@mysql_num_rows($resultban) == 0) 
{ //bunip
if ($_SERVER[QUERY_STRING] != "change")
{ //12
$result = @mysql_query("SELECT * FROM $vactable WHERE ID='$texid' and aid = '$sid'");
if (mysql_num_rows($result) == 0) {
	$error .= "Объявление не определено";}
while ($myrow=mysql_fetch_array($result)) 
{
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
if (!isset($_GET['country']) or $_GET['country']=='0') {
$country=$myrow["country"];
}
if (!isset($_GET['region']) or $_GET['region']=='0') {
$region=$myrow["region"];
}
if (!isset($_GET['city']) or $_GET['city']=='0') {
$city=$myrow["city"];
}
$adress=$myrow["adress"];
$metro=$myrow["metro"];
$firm=$myrow["firm"];
$period=$myrow["period"];
if (!isset($_GET['razdel']) or $_GET['razdel']=='0') {
$razdel=$myrow["razdel"];
}
if (!isset($_GET['podrazdel']) or $_GET['podrazdel']=='0') {$podrazdel=$myrow["podrazdel"];}
if ($podrazdel=='0') {$podrazdel='';}
}
echo "<center><font color=red>$error</font></center>";
} //12
if ($_SERVER[QUERY_STRING] == "change" and isset($_POST['save']))
{ //6

$razdel=$_POST['razdel'];
$podrazdel=$_POST['podrazdel'];
$profecy=$_POST['profecy'];
$agemin=$_POST['agemin'];
$agemax=$_POST['agemax'];
$edu=$_POST['edu'];
$zp=$_POST['zp'];
$gender=$_POST['gender'];
$grafic=$_POST['grafic'];
$zanatost=$_POST['zanatost'];
$stage=$_POST['stage'];
$treb=$_POST['treb'];
$obyaz=$_POST['obyaz'];
$uslov=$_POST['uslov'];
$city=$_POST['city'];
$region=$_POST['region'];
$country=$_POST['country'];
$adress=$_POST['adress'];
$metro=$_POST['metro'];
$firm=$_POST['firm'];
$period=$_POST['period'];

if (strlen($profecy) > $maxprofecy) {$error .= "$err1";}
if (strlen($agemin) > $maxmage or strlen($agemax) > $maxmage) {$error .= "$err2";}
if (strlen($zp) > $maxzp) {$error .= "$err3";}
if (strlen($stage) > $maxstage) {$error .= "$err4";}
if (strlen($treb) > $maxcomment) {$error .= "$err5";}
if (strlen($obyaz) > $maxcomment) {$error .= "$err6";}
if (strlen($uslov) > $maxcomment) {$error .= "$err7";}
if (strlen($firm) > $maxfirm) {$error .= "$err8";}
if (strlen($citynew) > $maxcity) {$error .= "$err9";}
if (strlen($adress) > $maxadress) {$error .= "$err10";}
if ($razdel == "" or $razdel == '0' ) {$error .= "$err11";}
if (isset($podrazdel) and $podrazdel == "") {$error .= "$err12";}
if ($profecy == "") {$error .= "$err13";}
if ($treb == "") {$error .= "$err14";}
if ($zp == "") {$error .= "$err15";}
if ($period == "") {$error .= "$err17";}
// город
if ($city == "") {
$resultadd1 = @mysql_query("SELECT ID,razdel,podrazdel FROM $citytable WHERE podrazdel = '' and ID='$country'");
while($myrow=mysql_fetch_array($resultadd1)) {
$countrys1=$myrow["razdel"];
}
$resultadd2 = @mysql_query("SELECT ID,podrazdel FROM $citytable WHERE ID='$region'");
while($myrow=mysql_fetch_array($resultadd2)) {
$regions1=$myrow["podrazdel"];
}
if ($region != "")
{
$result3c = @mysql_query("SELECT * FROM $citytable WHERE razdel='$countrys1' and podrazdel='$regions1' and categ != '' LIMIT 1");
if (@mysql_num_rows($result3c) != 0) {
$error .= "Не заполнено обязательное поле - Город<br>";
}
}
if ($region == "")
{
$result3c = @mysql_query("SELECT * FROM $citytable WHERE razdel='$countrys1' and categ != '' LIMIT 1");
if (@mysql_num_rows($result3c) != 0) {
$error .= "Не заполнено обязательное поле - Город<br>";
}
}
}
// город

echo "<center><font color=red>$error</font></center>";
} //6
if ($_SERVER[QUERY_STRING] == "change" and $error == "") 
{ //5
function untag ($string) {
$string = ereg_replace("<","&lt;",$string);
$string = ereg_replace(">","&gt;",$string);
$string = ereg_replace('\\\"',"&quot;",$string);
$string = ereg_replace(":","&#58;",$string);
$string = ereg_replace("!","&#33;",$string);
$string = ereg_replace("\r","",$string);
$string = ereg_replace("%","&#37;",$string);
$string = ereg_replace("^ +","",$string);
$string = ereg_replace(" +$","",$string);
$string = ereg_replace(" +"," ",$string);
return $string;
}
$profecy = untag($profecy);
$agemin = untag($agemin);
$agemax = untag($agemax);
$zp = untag($zp);
$treb = untag($treb);
$uslov = untag($uslov);
$obyaz = untag($obyaz);
if ($citynew != '') {$city=$citynew;}
$city = untag($city);
if ($textconfirm=='TRUE') {$status='wait';$stroka='<b>После проверки объявления администратором оно будет добавлено в общую базу.</b>';}
elseif ($textconfirm=='FALSE') {$status='ok';$stroka='<b>В течение нескольких минут объявление будет доступно для просмотра</b>';}
$sql="update $vactable SET razdel='$razdel',podrazdel='$podrazdel',profecy='$profecy',agemin='$agemin',agemax='$agemax',edu='$edu',zp='$zp',gender='$gender',grafic='$grafic',zanatost='$zanatost',stage='$stage',treb='$treb',obyaz='$obyaz',uslov='$uslov',country='$country',region='$region',city='$city',adress='$adress',firm='$firm',period='$period',status='$status',ip='$REMOTE_ADDR',date=now(),metro='$metro' WHERE ID='$texid'";
$result=@mysql_query($sql,$db);
echo "<center><h3>Изменения сохранены!</h3><center><br><br>$stroka<br><br><br><p align=center><a href=autor.php>Вернуться в авторский раздел</a></p><br><br>";
$txt="На сайте $siteadress - изменена вакансия #$texid";
if ($mailchange == 'TRUE')
{mail($adminemail,"Изменение вакансии",$txt,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/plain; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");}
} //5
if ($_SERVER[QUERY_STRING] != "change" or $error != "")
{ //4

if ($razdel == '')
{
if ($_GET['razdel'] == '') {$razdel=$_POST['razdel'];}
elseif ($_GET['razdel'] != '') {$razdel=$_GET['razdel'];}
}
if ($podrazdel == '')
{
if ($_GET['podrazdel'] == '') {$podrazdel=$_POST['podrazdel'];}
elseif ($_GET['podrazdel'] != '') {$podrazdel=$_GET['podrazdel'];}
}
if (isset($podrazdel) and $podrazdel != '')
{
$resultadd2 = @mysql_query("SELECT * FROM $catable WHERE ID='$podrazdel' LIMIT 1");
while($myrow=mysql_fetch_array($resultadd2)) {
$podrazdelsh=$myrow["podrazdel"];
}
}
$resultadd1 = @mysql_query("SELECT * FROM $catable WHERE ID='$razdel' LIMIT 1");
while($myrow=mysql_fetch_array($resultadd1)) {
$razdelsh=$myrow["razdel"];
}

if ($city == '')
{
if ($_GET['city'] == '') {$city=$_POST['city'];}
elseif ($_GET['city'] != '') {$city=$_GET['city'];}
}
if ($region == '')
{
if ($_GET['region'] == '') {$region=$_POST['region'];}
elseif ($_GET['region'] != '') {$region=$_GET['region'];}
}
if ($country == '')
{
if ($_GET['country'] == '') {$country=$_POST['country'];}
elseif ($_GET['country'] != '') {$country=$_GET['country'];}
}

if (isset($city) and $city != '')
{
$resultadd3 = @mysql_query("SELECT ID,categ FROM $citytable WHERE ID='$city'");
while($myrow=mysql_fetch_array($resultadd3)) {
$citys=$myrow["categ"];
}
}
if (isset($region) and $region != '')
{
$resultadd2 = @mysql_query("SELECT ID,podrazdel FROM $citytable WHERE ID='$region'");
while($myrow=mysql_fetch_array($resultadd2)) {
$regions=$myrow["podrazdel"];
}
}
$resultadd1 = @mysql_query("SELECT ID,razdel,podrazdel FROM $citytable WHERE podrazdel = '' and ID='$country'");
while($myrow=mysql_fetch_array($resultadd1)) {
$countrys=$myrow["razdel"];
}

echo "<p><form name=form1 method=post action=changev.php?change>";
echo ("
<p><center><strong>Обязательные поля отмечены символом <font color=#FF0000>*</font></strong></p>
<input type=hidden name=id value=$id>
<input type=hidden name=who value=$who>
<input type=hidden name=texid value=$texid>
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td>
<table cellspacing=1 cellpadding=4 width=100%>
<tr bgcolor=$maincolor><td align=right><strong><font color=#FF0000>*</font>Сфера деятельности:</strong></td>
<td align=left>
<select name=razdel size=1 onChange=location.href=location.pathname+\"?razdel=\"+value+\"&texid=$texid\";>
<option selected value=\"$razdel\">$razdelsh</option>
");
$result2 = @mysql_query("SELECT * FROM $catable WHERE podrazdel = '' order by razdel");
while($myrow=mysql_fetch_array($result2)) {
$razdel1=$myrow["razdel"];
$razdel1ID=$myrow["ID"];
$razdel11 = ereg_replace(",","--",$razdel1);
echo "<option value=\"$razdel1ID\">$razdel1</option>";
}
echo ("
</select></td></tr>
");
if ($razdel != '')
{
$result3 = @mysql_query("SELECT * FROM $catable WHERE podrazdel != '' and razdel='$razdelsh' order by podrazdel");
if (@mysql_num_rows($result3) != 0) {
echo ("
<tr bgcolor=$maincolor><td align=right><strong><font color=#FF0000>*</font>Раздел:</strong></td>
<td align=left><select name=podrazdel size=1 onChange=location.href=location.pathname+\"?texid=$texid&razdel=$razdel&podrazdel=\"+value+\"\";>
<option selected value=\"$podrazdel\">$podrazdelsh</option>
");
while($myrow=mysql_fetch_array($result3)) {
$podrazdel1=$myrow["podrazdel"];
$podrazdelID=$myrow["ID"];
echo "<option value=\"$podrazdelID\">$podrazdel1</option>";
}
echo ("
</select></td></tr>
");
}
elseif (@mysql_num_rows($result3) == 0) {
echo "<input type=hidden name=podrazdel value=0>";
}
}
echo ("
<tr><td valign=top align=right><strong><font color=#FF0000>*</font>Страна:</strong></td>
<td valign=top align=left>
<select name=country size=1 onChange=location.href=location.pathname+\"?texid=$texid&razdel=$razdel&podrazdel=$podrazdel&country=\"+value+\"\";>
<option selected value=\"$country\">$countrys</option>
");
$result2 = @mysql_query("SELECT * FROM $citytable WHERE podrazdel = '' and categ='' order by razdel");
while($myrow=mysql_fetch_array($result2)) {
$razdel1=$myrow["razdel"];
$razdel2=$myrow["ID"];
echo "<option value=\"$razdel2\">$razdel1</option>";
}
echo ("
</select></td></tr>
");
if ($country != '')
{ // страна
$result1 = @mysql_query("SELECT * FROM $citytable WHERE razdel='$countrys' and podrazdel != '' and categ='' order by podrazdel");
if (@mysql_num_rows($result1) != 0)
{ // есть регион
echo ("
<tr><td valign=top align=right><strong><font color=#FF0000>*</font>Регион:</strong></td>
<td valign=top align=left><select name=region size=1 onChange=location.href=location.pathname+\"?texid=$texid&razdel=$razdel&podrazdel=$podrazdel&country=$country&region=\"+value+\"\";>
<option selected value=\"$region\">$regions</option>
");
$result3 = @mysql_query("SELECT * FROM $citytable WHERE podrazdel != '' and razdel='$countrys' and categ='' order by podrazdel");
while($myrow=mysql_fetch_array($result3)) {
$podrazdel1=$myrow["podrazdel"];
$podrazdel2=$myrow["ID"];
echo "<option value=\"$podrazdel2\">$podrazdel1</option>";
}
echo ("
</select></td></tr>
");
if ($region != '')
{ // регион
$result4 = @mysql_query("SELECT * FROM $citytable WHERE podrazdel = '$regions' and razdel='$countrys' and categ != '' order by categ");
if (@mysql_num_rows($result4) != 0) {
echo ("
<tr><td valign=top align=right><strong><font color=#FF0000>*</font>Город:</strong></td>
<td valign=top align=left><select name=city size=1 onChange=location.href=location.pathname+\"?texid=$texid&razdel=$razdel&podrazdel=$podrazdel&country=$country&region=$region&city=\"+value+\"\";>
<option selected value=\"$city\">$citys</option>
");
while($myrow=mysql_fetch_array($result4)) {
$categ=$myrow["categ"];
$categ2=$myrow["ID"];
echo "<option value=\"$categ2\">$categ</option>";
}
echo ("
</select></td></tr>
");
}
} // регион
} // есть регион
elseif (@mysql_num_rows($result1) == 0)
{ // нет региона
$result4 = @mysql_query("SELECT * FROM $citytable WHERE podrazdel = '$regions' and razdel='$countrys' and categ != '' order by categ");
if (@mysql_num_rows($result4) != 0) {
echo ("
<tr><td valign=top align=right><strong><font color=#FF0000>*</font>Город:</strong></td>
<td valign=top align=left><select name=city size=1 onChange=location.href=location.pathname+\"?texid=$texid&razdel=$razdel&podrazdel=$podrazdel&country=$country&region=$region&city=\"+value+\"\";>
<option selected value=\"$city\">$citys</option>
");
while($myrow=mysql_fetch_array($result4)) {
$categ=$myrow["categ"];
$categ2=$myrow["ID"];
echo "<option value=\"$categ2\">$categ</option>";
}
echo ("
</select></td></tr>
");
}
} // нет региона
} // страна

if ($city != '') {$srcity="$city";}
if ($city == '' and $region != '') {$srcity="$region";}
if ($city == '' and $region == '' and $country != '') {$srcity="$country";}
if ($city == '' and $region == '' and $country == '') {$srcity="";}

if ($srcity != '')
{ // city
$qwery1="and city = '$srcity'";
} // city
if ($srcity == "") {$qwery1='';}

$result5 = @mysql_query("SELECT * FROM $metrotable WHERE metro != '' $qwery1 order by metro");
if (@mysql_num_rows($result5) != 0) {
echo ("
<tr><td align=right><strong>Метро:</strong></td>
<td align=left><select name=metro size=1>
<option selected value=\"$metro\">$metro</option>
");
while($myrow=mysql_fetch_array($result5)) {
$metro=$myrow["metro"];
echo "<option value=\"$metro\">$metro</option>";
}
echo ("
</select></td></tr>
");
}

echo ("
<tr bgcolor=$maincolor><td align=right valign=top><font color=#FF0000>*</font>Предлагаемая должность:</td>
<td><input type=text name=profecy size=30 value=\"$profecy\"></td></tr>
<tr bgcolor=$maincolor><td align=right>Возраст:</td>
<td>От&nbsp;<input type=text name=agemin size=5 value=\"$agemin\">&nbsp;До&nbsp;<input type=text name=agemax size=5 value=\"$agemax\">&nbsp;лет</td></tr>
<tr bgcolor=$maincolor><td align=right>Образование:</td>
<td><select name=edu size=1>
<option selected value=\"$edu\">$edu</option>
<option value=\"Не&nbsp;важно\">Не&nbsp;важно</option>
<option value=\"Высшее\">Высшее</option>
<option value=\"Неполное&nbsp;высшее\">Неполное&nbsp;высшее</option>
<option value=\"Среднее&nbsp;специальное\">Среднее&nbsp;специальное</option>
<option value=\"Среднее\">Среднее</option>
<option value=\"Учащийся\">Учащийся</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=right><font color=#FF0000>*</font>Зарплата:</td>
<td>От&nbsp;<input type=text name=zp size=5 value=\"$zp\">&nbsp;$valute</td></tr>
<tr bgcolor=$maincolor><td align=right>Пол:</td>
<td><select name=gender size=1>
<option selected value=\"$gender\">$gender</option>
<option value=\"Не&nbsp;важно\">Не&nbsp;важно</option>
<option value=\"Мужской\">Мужской</option>
<option value=\"Женский\">Женский</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=right>Занятость:</td>
<td><select name=zanatost size=1>
<option selected value=\"$zanatost\">$zanatost</option>
<option value=\"Не&nbsp;важно\">Не&nbsp;важно</option>
<option value=\"Полная\">Полная</option>
<option value=\"По&nbsp;совместительству\">По&nbsp;совместительству</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=right>График работы:</td>
<td><select name=grafic size=1>
<option selected value=\"$grafic\">$grafic</option>
<option value=\"Не&nbsp;важно\">Не&nbsp;важно</option>
<option value=\"Полный&nbsp;день\">Полный&nbsp;день</option>
<option value=\"Неполный&nbsp;день\">Неполный&nbsp;день</option>
<option value=\"Свободный&nbsp;график\">Свободный&nbsp;график</option>
<option value=\"Удаленная&nbsp;работа\">Удаленная&nbsp;работа</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=right>Опыт работы:</td>
<td><input type=text name=stage size=30 value=\"$stage\"></td></tr>
<tr bgcolor=$maincolor><td align=right valign=top><font color=#FF0000>*</font>Требования:<br>(не более 1000 симв.)</td>
<td><textarea rows=3 name=treb cols=28>$treb</textarea></td></tr>
<tr bgcolor=$maincolor><td align=right valign=top>Обязанности:<br>(не более 1000 симв.)</td>
<td><textarea rows=3 name=obyaz cols=28>$obyaz</textarea></td></tr>
<tr bgcolor=$maincolor><td align=right valign=top>Условия:<br>(не более 1000 симв.)</td>
<td><textarea rows=3 name=uslov cols=28>$uslov</textarea></td></tr>
<tr bgcolor=$maincolor><td align=right>Местонахождение:</td>
<td><input type=text name=adress size=30 value=\"$adress\"></td></tr>
");
if ($who == 'agency')
{
echo ("
<tr bgcolor=$maincolor><td align=right>Организация(фирма):</td>
<td><input type=text name=firm size=30 value=\"$firm\"></td></tr>
");
}
echo ("
<tr bgcolor=$maincolor><td align=right><font color=#FF0000>*</font>Период размещения:</td>
<td><select name=period size=1>
<option selected value=$period>$period</option>
<option value=10>10</option>
<option value=30>30</option>
<option value=60>60</option>
<option value=90>90</option>
</select>&nbsp;дней</td></tr>
</table></td></tr></table>
");
echo "<br><br><hr width=90% size=1><br><input type=submit class=i3 value=\"Сохранить изменения\" name=\"save\"></form><p align=center><a href=autor.php>Вернуться в авторский раздел</a></p><br><br>";
} //4
echo ("
<center><form method=post action=\"logout.php\">
<input type=submit name=logout value=Выход class=i3><br><br>
</form>
");
} //bunip
} //0
echo "</div>";
include("down.php");
?>