<?
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
echo "<head>";
include("var.php");
echo"<title>Подписка на новые вакансии : $sitename</title>";
include("top.php");
echo "<div class=tbl1>";
?>
<h3><left><strong>Подписка на новые вакансии</strong></left></h3>
<?php
$delip=mysql_query("delete from $bunsiptable where (((date + INTERVAL 86400*period SECOND) < now()) and period != '')");

$sid=$_SESSION['sid'];
$id=$_SESSION['sid'];
$slogin=$_SESSION['slogin'];
$spass=$_SESSION['spass'];
if ($ident == 'session') {$REMOTE_ADDR=$PHPSESSID;}
if ($ident != 'session') {$REMOTE_ADDR=$_SERVER['REMOTE_ADDR'];}

$error = "";
$result = @mysql_query("SELECT * FROM $autortable WHERE (email = '$slogin' and pass = '$spass')");
if ((!isset($slogin) or !isset($spass)) or @mysql_num_rows($result) == 0)
{
echo "<left><br><br><h3>Вы не авторизированы!</h3><b><a href=autor.php>Авторизация</a></b>";
}
else
{//1
while($myrow=mysql_fetch_array($result)) {
$who=$myrow["category"];
$afcountry=$myrow["country"];
$afregion=$myrow["region"];
$afcity=$myrow["city"];
}
$resultban = @mysql_query("SELECT * FROM $bunsiptable WHERE bunsip = '$REMOTE_ADDR'");
if (@mysql_num_rows($resultban) != 0) {
while($myrow=mysql_fetch_array($resultban)) {
$ID=$myrow["ID"];
$bunsip=$myrow["bunsip"];
$bunwhy=$myrow["why"];
}
echo "<p align=left><font color=red>Доступ к функциям авторского раздела для вас, к сожалению, закрыт!</font></p><blockquote><p align=justify><b>Причина:</b> $bunwhy</p><br><br>";
}
elseif (@mysql_num_rows($resultban) == 0) 
{ //bunip
$resultraz = @mysql_query("SELECT email,pass,category FROM $autortable WHERE email = '$slogin' and pass = '$spass' and (category = 'soisk' or category = 'agency')");
if (@mysql_num_rows($resultraz) == 0)
{
echo "<left><br><br><h3>На вакансии могут подписываться только соискатели и агентства!</h3><b><a href=registr.php>Регистрация</a></b>";
}
elseif (mysql_num_rows($resultraz) != 0) 
{ // проверка1

if ($_SERVER[QUERY_STRING] != "add") {
if (!isset($_GET['srcountry']) or $_GET['srcountry']=='0') {$srcountry=$afcountry;}
if (!isset($_GET['srregion']) or $_GET['srregion']=='0') {$srregion=$afregion;}
$srcity=$afcity;
}

if ($_SERVER[QUERY_STRING] == "add") {

$srrazdel=$_POST['srrazdel'];
$srpodrazdel=$_POST['srpodrazdel'];
$srcountry=$_POST['srcountry'];
$srregion=$_POST['srregion'];
$srcity=$_POST['srcity'];
$srprofecy=$_POST['srprofecy'];
$srage=$_POST['srage'];
$sredu=$_POST['sredu'];
$srzp=$_POST['srzp'];
$srzanatost=$_POST['srzanatost'];
$srgrafic=$_POST['srgrafic'];
$srgender=$_POST['srgender'];
$srcomment=$_POST['srcomment'];
$srtime=$_POST['srtime'];

echo "<left><font color=red>$error</font></left>";
function untag ($string) {
$string = ereg_replace("<","&lt;",$string);
$string = ereg_replace(">","&gt;",$string);
$string = ereg_replace('\\\"',"&quot;",$string);
$string = ereg_replace(":","&#58;",$string);
$string = ereg_replace("!","&#33;",$string);
$string = ereg_replace("\r","",$string);
$string = ereg_replace("^ +","",$string);
$string = ereg_replace(" +$","",$string);
$string = ereg_replace(" +"," ",$string);
return $string;
}
$srprofecy = untag($srprofecy);
$srage = untag($srage);
$srzp = untag($srzp);
if ($_SERVER[QUERY_STRING] == "add" and $error == "") {
if (isset($_POST['adds']))
{
$sql="insert into $rasvac (razdel,podrazdel,srprofecy,srage,sredu,srzp,srgender,srgrafic,srzanatost,srcountry,srregion,srcity,aid,date) values ('$srrazdel','$srpodrazdel','$srprofecy','$srage','$sredu','$srzp','$srgender','$srgrafic','$srzanatost','$srcountry','$srregion','$srcity','$id',now())";
$result=@mysql_query($sql,$db);
}
if (isset($_POST['upd']))
{
$sql="UPDATE $rasvac SET razdel='$srrazdel',podrazdel='$srpodrazdel',srprofecy='$srprofecy',srage='$srage',sredu='$sredu',srzp='$srzp',srgender='$srgender',srgrafic='$srgrafic',srzanatost='$srzanatost',srcountry='$srcountry',srregion='$srregion',srcity='$srcity',date=now() WHERE aid='$id'";
$result=@mysql_query($sql,$db);
}
if (isset($_POST['dells']))
{
$sql="delete from $rasvac where aid='$id'";
$result=@mysql_query($sql,$db);
}
}
}
if ($_SERVER[QUERY_STRING] != "add" or $error != "") {

$result = @mysql_query("SELECT * FROM $rasvac WHERE aid='$id'");
if (mysql_num_rows($result) == 0) {$but='add'; echo "<p align=left><b>Подписка не оформлена</b></p>";}
if (mysql_num_rows($result) != 0) {$but='update';
while ($myrow=mysql_fetch_array($result)) 
{
$srprofecy=$myrow["srprofecy"];
$lsrprofecy=$srprofecy;
$lsrprofecy1=$srprofecy;
if ($srprofecy == '') {$lsrprofecy='Любая'; $lsrprofecy1='';}
$srage=$myrow["srage"];
$lsrage=$srage;
$lsrage1=$srage;
if ($srage == '0') {$lsrage='Любой';$lsrage1='';}
$sredu=$myrow["sredu"];
$lsredu=$sredu;
if ($sredu == '%' or $sredu == '') {$lsredu='Любое';}
$srzp=$myrow["srzp"];
$lsrzp=$srzp;
$lsrzp1=$srzp;
if ($srzp == '0') {$lsrzp='Любая';$lsrzp1='';}
$srgender=$myrow["srgender"];
$lsrgender=$srgender;
if ($srgender == '%' or $srgender == '') {$lsrgender='Любой';}
$srgrafic=$myrow["srgrafic"];
$lsrgrafic=$srgrafic;
if ($srgrafic == '%' or $srgrafic == '') {$lsrgrafic='Любой';}
$srzanatost=$myrow["srzanatost"];
$lsrzanatost=$srzanatost;
if ($srzanatost == '%' or $srzanatost == '') {$lsrzanatost='Любая';}

$srcountry=$myrow["srcountry"];
$srregion=$myrow["srregion"];
$srcity=$myrow["srcity"];
$citytar=$srcity;
if ($srcity=='0') {$citytar=$srregion;}
if ($srregion=='0' and $srcity=='0') {$citytar=$srcountry;}
$resultadd3c = @mysql_query("SELECT * FROM $citytable WHERE ID='$citytar'");
while($myrowc=mysql_fetch_array($resultadd3c)) {
$lsrcity=$myrowc["categ"];
if ($srcity=='0') {$lsrcity=$myrowc["podrazdel"];}
if ($srcity=='0' and $srregion=='0') {$lsrcity=$myrowc["razdel"];}
}
if ($lsrcity == '0' or $lsrcity == '') {$lsrcity='Не важно';}

if (!isset($_GET['srrazdel'])) {$srrazdel=$myrow["razdel"];}
$lrazdel=$srrazdel;
if ($srrazdel == 'nnn' or $srrazdel == '0') {$lrazdel='Любая';}
if ($srrazdel != 'nnn' and $srrazdel != '0') {
$resultadd1 = mysql_query("SELECT ID,razdel,podrazdel FROM $catable WHERE podrazdel = '' and ID='$srrazdel'");
while($myrow1=mysql_fetch_array($resultadd1)) {
$lrazdel=$myrow1["razdel"];
}
}
if (!isset($_GET['srpodrazdel'])) {$srpodrazdel=$myrow["podrazdel"];}
$lpodrazdel=$srpodrazdel;
if ($srpodrazdel == '%' or $srpodrazdel == '0' or $srpodrazdel == '') {$lpodrazdel='Любой';}
if ($srpodrazdel != '%' and $srpodrazdel != '0') {
$resultadd2 = mysql_query("SELECT ID,podrazdel FROM $catable WHERE ID='$srpodrazdel'");
while($myrow1=mysql_fetch_array($resultadd2)) {
$lpodrazdel=$myrow1["podrazdel"];
}
}
}
echo ("
<blockquote>
<b>Подписано:</b><br>
Сфера деятельности: <b>$lrazdel</b><br>
Раздел: <b>$lpodrazdel</b><br>
Город: <b>$lsrcity</b><br>
Должность: <b>$lsrprofecy</b><br>
Возраст: <b>$lsrage</b><br>
Образование: <b>$lsredu</b><br>
Зарплата: <b>$lsrzp</b><br>
Занятость: <b>$lsrzanatost</b><br>
График работы: <b>$lsrgrafic</b><br>
Пол: <b>$lsrgender</b><br>
</blockquote>
");
}

echo ("
<form name=form method=post action=subsv.php?add ENCTYPE=multipart/form-data>
");

if ($srrazdel == '' or $srrazdel == '0')
{
if ($_GET['srrazdel'] == '') {$srrazdel=$_POST['srrazdel'];}
elseif ($_GET['srrazdel'] != '') {$srrazdel=$_GET['srrazdel'];}
}
if ($srpodrazdel == '' or $srpodrazdel == '0')
{
if ($_GET['srpodrazdel'] == '') {$srpodrazdel=$_POST['srpodrazdel'];}
elseif ($_GET['srpodrazdel'] != '') {$srpodrazdel=$_GET['srpodrazdel'];}
}
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

if ($srcity == '')
{
if ($_GET['srcity'] == '') {$srcity=$_POST['srcity'];}
elseif ($_GET['srcity'] != '') {$srcity=$_GET['srcity'];}
}
if ($srregion == '')
{
if ($_GET['srregion'] == '') {$srregion=$_POST['srregion'];}
elseif ($_GET['srregion'] != '') {$srregion=$_GET['srregion'];}
}
if ($srcountry == '')
{
if ($_GET['srcountry'] == '') {$srcountry=$_POST['srcountry'];}
elseif ($_GET['srcountry'] != '') {$srcountry=$_GET['srcountry'];}
}

if (isset($srcity) and $srcity != '')
{
$resultadd3 = @mysql_query("SELECT ID,categ FROM $citytable WHERE ID='$srcity'");
while($myrow=mysql_fetch_array($resultadd3)) {
$citys=$myrow["categ"];
}
}
if (isset($srregion) and $srregion != '')
{
$resultadd2 = @mysql_query("SELECT ID,podrazdel FROM $citytable WHERE ID='$srregion'");
while($myrow=mysql_fetch_array($resultadd2)) {
$regions=$myrow["podrazdel"];
}
}
$resultadd1 = @mysql_query("SELECT ID,razdel,podrazdel FROM $citytable WHERE podrazdel = '' and ID='$srcountry'");
while($myrow=mysql_fetch_array($resultadd1)) {
$countrys=$myrow["razdel"];
}

echo ("
<left><table bgcolor=$maincolor border=0 cellpadding=4 class=tbl1>
<tr bgcolor=$maincolor><td align=left>Сфера деятельности:</td>
<td align=left>
<select class=arria name=srrazdel size=1 onChange=location.href=location.pathname+\"?srrazdel=\"+value+\"\";>
<option selected value=\"$srrazdel\">$razdelsh</option>
<option value=>Не важно</option>
");
$result2 = @mysql_query("SELECT * FROM $catable WHERE podrazdel = '' order by razdel");
while($myrow=mysql_fetch_array($result2)) {
$razdel1=$myrow["razdel"];
$razdel1ID=$myrow["ID"];
echo "<option value=\"$razdel1ID\">$razdel1</option>";
}
echo ("
</select></td></tr>
");
if ($srrazdel != '')
{
$result3 = @mysql_query("SELECT * FROM $catable WHERE podrazdel != '' and razdel='$razdelsh' order by podrazdel");
if (@mysql_num_rows($result3) != 0) {
echo ("
<tr bgcolor=$maincolor><td align=left>Раздел:</td>
<td align=left><select class=for name=srpodrazdel size=1 onChange=location.href=location.pathname+\"?srrazdel=$srrazdel&srpodrazdel=\"+value+\"\";>
<option selected value=\"$srpodrazdel\">$podrazdelsh</option>
<option value=>Не важно</option>
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
echo "<input class=arria type=hidden name=podrazdel value=0>";
}
}
echo ("
<tr><td valign=top align=left>Страна:</td>
<td valign=top align=left>
<select class=arria name=srcountry size=1 onChange=location.href=location.pathname+\"?srrazdel=$srrazdel&srpodrazdel=$srpodrazdel&srcountry=\"+value+\"\";>
<option selected value=\"$srcountry\">$countrys</option>
<option value=>Не важно</option>
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
if ($srcountry != '')
{ // страна
$result1 = @mysql_query("SELECT * FROM $citytable WHERE razdel='$countrys' and podrazdel != '' and categ='' order by podrazdel");
if (@mysql_num_rows($result1) != 0)
{ // есть регион
echo ("
<tr><td valign=top align=left>Регион:</td>
<td valign=top align=left><select class=arria name=srregion size=1 onChange=location.href=location.pathname+\"?srrazdel=$srrazdel&srpodrazdel=$srpodrazdel&srcountry=$srcountry&srregion=\"+value+\"\";>
<option selected value=\"$srregion\">$regions</option>
<option value=>Не важно</option>
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
if ($srregion != '')
{ // регион
$result4 = @mysql_query("SELECT * FROM $citytable WHERE podrazdel = '$regions' and razdel='$countrys' and categ != '' order by categ");
if (@mysql_num_rows($result4) != 0) {
echo ("
<tr><td valign=top align=left>Город:</td>
<td valign=top align=left><select class=arria name=srcity size=1>
<option selected value=\"$srcity\">$citys</option>
<option value=>Не важно</option>
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
<tr><td valign=top align=left>Город:</td>
<td valign=top align=left><select class=for name=srcity size=1>
<option selected value=\"$srcity\">$citys</option>
<option value=>Не важно</option>
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
echo ("
<tr bgcolor=$maincolor>
<td align=left>Должность:</td>
<td align=left><input class=for type=text name=srprofecy size=20 value=\"$lsrprofecy1\"></td>
</tr>
<tr bgcolor=$maincolor><td align=left>Возраст:</td>
<td align=left><input class=for type=text name=srage size=3 value=\"$lsrage1\"> лет</td></tr>
<tr bgcolor=$maincolor>
<td align=left>Образование:</td>
<td align=left><select class=for name=sredu size=1>
<option selected value=\"$sredu\">$lsredu</option>
<option value=%>Любое</option>
<option value=\"Высшее\">Высшее</option>
<option value=\"Неполное&nbsp;высшее\">Неполное&nbsp;высшее</option>
<option value=\"Среднее&nbsp;специальное\">Среднее&nbsp;специальное</option>
<option value=\"Среднее\">Среднее</option>
<option value=\"Учащийся\">Учащийся</option>
</select>
</td></tr>
<tr bgcolor=$maincolor><td align=left>Зарплата:</td>
<td>Более&nbsp;<input class=for type=text name=srzp size=5 value=\"$lsrzp1\">&nbsp;$valute</td></tr>
<tr bgcolor=$maincolor><td align=left>Занятость:</td>
<td><select class=for name=srzanatost size=1>
<option selected value=\"$srzanatost\">$lsrzanatost</option>
<option value=%>Любая</option>
<option value=\"Полная\">Полная</option>
<option value=\"По&nbsp;совместительству\">По&nbsp;совместительству</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=left>График работы:</td>
<td><select class=for name=srgrafic size=1>
<option selected value=\"$srgrafic\">$lsrgrafic</option>
<option value=%>Любой</option>
<option value=\"Полный&nbsp;день\">Полный&nbsp;день</option>
<option value=\"Неполный&nbsp;день\">Неполный&nbsp;день</option>
<option value=\"Свободный&nbsp;график\">Свободный&nbsp;график</option>
<option value=\"Удаленная&nbsp;работа\">Удаленная&nbsp;работа</option>
</select></td></tr>
<tr bgcolor=$maincolor>
<td align=left>Пол:</td>
<td align=left><select class=for name=srgender size=1>
<option selected value=\"$srgender\">$lsrgender</option>
<option value=%>Любой</option>
<option value=Мужской>Мужской</option>
<option value=Женский>Женский</option>
</select>
</td></tr>
<tr bgcolor=$maincolor>
<td colspan=2 align=left>
");
if ($but=='add')
{
echo "<input class=dob type=submit value=Подписаться name=adds>";
}
if ($but=='update')
{
echo "<input class=for type=submit value=\"Внести изменения\" name=upd>&nbsp;<input class=for type=submit value=Отписаться name=dells>";
}
echo ("
</td></tr>
</table>
</form>
");
echo "<p align=left class=tbl1><a href=autor.php>Вернуться в авторский раздел</a></p>";
}
else {
echo "<br><h3 align=left>Изменения сохранены!</h3><p align=left><a href=autor.php>Вернуться в авторский раздел</a></p><br><br>";
}
} // проверка1
} //bunip
}//1
echo "</div>";
include("down.php");
?>