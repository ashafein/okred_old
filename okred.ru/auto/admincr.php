<?
session_start();
session_register("uid");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
include("var.php");
echo "<head><title>Администрирование - Правка резюме: $sitename</title>";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\">";
?>

<SCRIPT>
function Hide(d) {document.getElementById(d).style.display = 'none';}
function Shw(d) {document.getElementById(d).style.display = 'block';}
</SCRIPT>

<?
include("top.php");
if (isset($_POST['razdel'])) {$razdel = ereg_replace("--",",",$_POST['razdel']);}
if (isset($_GET['razdel'])) {$razdel = ereg_replace("--",",",$_GET['razdel']);}
$maxzp = 8;
$maxprofecy = 50;
$maxfio = 100;
$maxcomment = 1000;
$maxuslov = 1000;
$maxciv = 30;
$maxprof = 500;
$maxdopsved = 1000;
$err1 = "Желаемая должность должна быть не длинее $maxprofecy символов<br>";
$err2 = "Зарплата должна быть не длинее $maxzp символов<br>";
$err3 = "Поле ФИО соискателя должно быть не длинее $maxfio символов<br>";
$err4 = "Текст Условий труда должен быть не длинее $maxuslov символов<br>";
$err5 = "Текст Комментариев должен быть не длинее $maxcomment символов<br>";
$err6 = "Гражданство должно быть не длинее $maxciv символов<br>";
$err115 = "Поле Проф.навыки должно быть не длинее $maxprof символов<br>";
$err116 = "Поле Дополнительные сведения должно быть не длинее $maxdopsved символов<br>";
$err7 = "Не заполнено обязательное поле - Сфера деятельности!<br>";
$err8 = "Не заполнено обязательное поле - Раздел!<br>";
$err9 = "Не заполнено обязательное поле - Желаемая должность!<br>";
$err11 = "Не заполнено обязательное поле - Период размещения!<br>";
$error = "";
if ($_GET['texid'] == '') {$texid=$_POST['texid'];}
elseif ($_GET['texid'] != '') {$texid=$_GET['texid'];}
$result = @mysql_query("SELECT pass FROM $admintable");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
if (!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass)
{
if (isset($texid))
{echo "<center><b>Вы не <a href=admin.php>авторизированы</a>!</b><br><br>";}
if (!isset($texid))
{echo "<center><br><br><h3>Объявление не определено!</h3><b><a href=admindr.php>На страницу удаления</a></b>";}
}
else
{ // ok
if ($_SERVER[QUERY_STRING] != "change")
{ //1
$result = @mysql_query("SELECT *,(YEAR(birth)) AS byear,(MONTH(birth)) AS bmonth,(DAYOFMONTH(birth)) AS bday FROM $restable WHERE ID='$texid'");
if (mysql_num_rows($result) == 0) {
	$error .= "Объявление не определено";}
while ($myrow=mysql_fetch_array($result)) 
{ //4
$tID=$myrow["ID"];
$profecy=$myrow["profecy"];
$zp=$myrow["zp"];
$grafic=$myrow["grafic"];
$zanatost=$myrow["zanatost"];
$uslov=$myrow["uslov"];
$comment=$myrow["comment"];
$fio=$myrow["fio"];
$gender=$myrow["gender"];
$byear=$myrow["byear"];
$bmonth=$myrow["bmonth"];
$bday=$myrow["bday"];
$family=$myrow["family"];
$civil=$myrow["civil"];
$prof=$myrow["prof"];
$dopsved=$myrow["dopsved"];
$period=$myrow["period"];
$aid=$myrow["aid"];

$expir1org=$myrow["expir1org"];
$expir1perfmonth=$myrow["expir1perfmonth"];
$expir1perfyear=$myrow["expir1perfyear"];
$expir1pertmonth=$myrow["expir1pertmonth"];
$expir1pertyear=$myrow["expir1pertyear"];
$expir1dol=$myrow["expir1dol"];
$expir1obyaz=$myrow["expir1obyaz"];
$expir2org=$myrow["expir2org"];
$expir2perfmonth=$myrow["expir2perfmonth"];
$expir2perfyear=$myrow["expir2perfyear"];
$expir2pertmonth=$myrow["expir2pertmonth"];
$expir2pertyear=$myrow["expir2pertyear"];
$expir2dol=$myrow["expir2dol"];
$expir2obyaz=$myrow["expir2obyaz"];
$expir3org=$myrow["expir3org"];
$expir3perfmonth=$myrow["expir3perfmonth"];
$expir3perfyear=$myrow["expir3perfyear"];
$expir3pertmonth=$myrow["expir3pertmonth"];
$expir3pertyear=$myrow["expir3pertyear"];
$expir3dol=$myrow["expir3dol"];
$expir3obyaz=$myrow["expir3obyaz"];
$expir4org=$myrow["expir4org"];
$expir4perfmonth=$myrow["expir4perfmonth"];
$expir4perfyear=$myrow["expir4perfyear"];
$expir4pertmonth=$myrow["expir4pertmonth"];
$expir4pertyear=$myrow["expir4pertyear"];
$expir4dol=$myrow["expir4dol"];
$expir4obyaz=$myrow["expir4obyaz"];
$expir5org=$myrow["expir5org"];
$expir5perfmonth=$myrow["expir5perfmonth"];
$expir5perfyear=$myrow["expir5perfyear"];
$expir5pertmonth=$myrow["expir5pertmonth"];
$expir5pertyear=$myrow["expir5pertyear"];
$expir5dol=$myrow["expir5dol"];
$expir5obyaz=$myrow["expir5obyaz"];
$edu1sel=$myrow["edu1sel"];
$edu1school=$myrow["edu1school"];
$edu1year=$myrow["edu1year"];
$edu1fac=$myrow["edu1fac"];
$edu1spec=$myrow["edu1spec"];
$edu2sel=$myrow["edu2sel"];
$edu2school=$myrow["edu2school"];
$edu2year=$myrow["edu2year"];
$edu2fac=$myrow["edu2fac"];
$edu2spec=$myrow["edu2spec"];
$edu3sel=$myrow["edu3sel"];
$edu3school=$myrow["edu3school"];
$edu3year=$myrow["edu3year"];
$edu3fac=$myrow["edu3fac"];
$edu3spec=$myrow["edu3spec"];
$edu4sel=$myrow["edu4sel"];
$edu4school=$myrow["edu4school"];
$edu4year=$myrow["edu4year"];
$edu4fac=$myrow["edu4fac"];
$edu4spec=$myrow["edu4spec"];
$edu5sel=$myrow["edu5sel"];
$edu5school=$myrow["edu5school"];
$edu5year=$myrow["edu5year"];
$edu5fac=$myrow["edu5fac"];
$edu5spec=$myrow["edu5spec"];
$lang1=$myrow["lang1"];
$lang1uroven=$myrow["lang1uroven"];
$lang2=$myrow["lang2"];
$lang2uroven=$myrow["lang2uroven"];
$lang3=$myrow["lang3"];
$lang3uroven=$myrow["lang3uroven"];
$lang4=$myrow["lang4"];
$lang4uroven=$myrow["lang4uroven"];
$lang5=$myrow["lang5"];
$lang5uroven=$myrow["lang5uroven"];

if (!isset($_GET['razdel']) or $_GET['razdel']=='0') {
$razdel=$myrow["razdel"];
}
if (!isset($_GET['podrazdel']) or $_GET['podrazdel']=='0') {$podrazdel=$myrow["podrazdel"];}
if ($podrazdel=='0') {$podrazdel='';}
$resultaut = @mysql_query("SELECT ID,category FROM $autortable WHERE ID='$aid'");
while($myrow=mysql_fetch_array($resultaut)) {
$who=$myrow["category"];
}
}
echo "<center><font color=red>$error</font></center>";
} //1
if ($_SERVER[QUERY_STRING] == "change")
{ //6

$razdel=$_POST['razdel'];
$podrazdel=$_POST['podrazdel'];
$profecy=$_POST['profecy'];
$zp=$_POST['zp'];
$grafic=$_POST['grafic'];
$zanatost=$_POST['zanatost'];
$uslov=$_POST['uslov'];
$comment=$_POST['comment'];
$fio=$_POST['fio'];
$gender=$_POST['gender'];
$byear=$_POST['byear'];
$bmonth=$_POST['bmonth'];
$bday=$_POST['bday'];
$family=$_POST['family'];
$civil=$_POST['civil'];
$prof=$_POST['prof'];
$dopsved=$_POST['dopsved'];
$period=$_POST['period'];

$expir1org=$_POST['expir1org'];
$expir1perfmonth=$_POST['expir1perfmonth'];
$expir1perfyear=$_POST['expir1perfyear'];
$expir1pertmonth=$_POST['expir1pertmonth'];
$expir1pertyear=$_POST['expir1pertyear'];
$expir1dol=$_POST['expir1dol'];
$expir1obyaz=$_POST['expir1obyaz'];
$expir2org=$_POST['expir2org'];
$expir2perfmonth=$_POST['expir2perfmonth'];
$expir2perfyear=$_POST['expir2perfyear'];
$expir2pertmonth=$_POST['expir2pertmonth'];
$expir2pertyear=$_POST['expir2pertyear'];
$expir2dol=$_POST['expir2dol'];
$expir2obyaz=$_POST['expir2obyaz'];
$expir3org=$_POST['expir3org'];
$expir3perfmonth=$_POST['expir3perfmonth'];
$expir3perfyear=$_POST['expir3perfyear'];
$expir3pertmonth=$_POST['expir3pertmonth'];
$expir3pertyear=$_POST['expir3pertyear'];
$expir3dol=$_POST['expir3dol'];
$expir3obyaz=$_POST['expir3obyaz'];
$expir4org=$_POST['expir4org'];
$expir4perfmonth=$_POST['expir4perfmonth'];
$expir4perfyear=$_POST['expir4perfyear'];
$expir4pertmonth=$_POST['expir4pertmonth'];
$expir4pertyear=$_POST['expir4pertyear'];
$expir4dol=$_POST['expir4dol'];
$expir4obyaz=$_POST['expir4obyaz'];
$expir5org=$_POST['expir5org'];
$expir5perfmonth=$_POST['expir5perfmonth'];
$expir5perfyear=$_POST['expir5perfyear'];
$expir5pertmonth=$_POST['expir5pertmonth'];
$expir5pertyear=$_POST['expir5pertyear'];
$expir5dol=$_POST['expir5dol'];
$expir5obyaz=$_POST['expir5obyaz'];
$edu1sel=$_POST['edu1sel'];
$edu1school=$_POST['edu1school'];
$edu1year=$_POST['edu1year'];
$edu1fac=$_POST['edu1fac'];
$edu1spec=$_POST['edu1spec'];
$edu2sel=$_POST['edu2sel'];
$edu2school=$_POST['edu2school'];
$edu2year=$_POST['edu2year'];
$edu2fac=$_POST['edu2fac'];
$edu2spec=$_POST['edu2spec'];
$edu3sel=$_POST['edu3sel'];
$edu3school=$_POST['edu3school'];
$edu3year=$_POST['edu3year'];
$edu3fac=$_POST['edu3fac'];
$edu3spec=$_POST['edu3spec'];
$edu4sel=$_POST['edu4sel'];
$edu4school=$_POST['edu4school'];
$edu4year=$_POST['edu4year'];
$edu4fac=$_POST['edu4fac'];
$edu4spec=$_POST['edu4spec'];
$edu5sel=$_POST['edu5sel'];
$edu5school=$_POST['edu5school'];
$edu5year=$_POST['edu5year'];
$edu5fac=$_POST['edu5fac'];
$edu5spec=$_POST['edu5spec'];
$lang1=$_POST['lang1'];
$lang1uroven=$_POST['lang1uroven'];
$lang2=$_POST['lang2'];
$lang2uroven=$_POST['lang2uroven'];
$lang3=$_POST['lang3'];
$lang3uroven=$_POST['lang3uroven'];
$lang4=$_POST['lang4'];
$lang4uroven=$_POST['lang4uroven'];
$lang5=$_POST['lang5'];
$lang5uroven=$_POST['lang5uroven'];

if (strlen($profecy) > $maxprofecy) {$error .= "$err1";}
if (strlen($zp) > $maxzp) {$error .= "$err2";}
if (strlen($fio) > $maxfio) {$error .= "$err3";}
if (strlen($uslov) > $maxuslov) {$error .= "$err4";}
if (strlen($comment) > $maxcomment) {$error .= "$err5";}
if (strlen($civil) > $maxciv) {$error .= "$err6";}
if (strlen($prof) > $maxprof) {$error .= "$err115";}
if (strlen($dopsved) > $maxdopsved) {$error .= "$err116";}
if ($razdel == "" or $razdel == '0') {$error .= "$err7";}
if (isset($podrazdel) and $podrazdel == "") {$error .= "$err8";}
if ($profecy == "") {$error .= "$err9";}
if ($period == "") {$error .= "$err11";}
echo "<center><font color=red>$error</font></center>";
} //6
if (($_SERVER[QUERY_STRING] != "change" and $error == "") or ($_SERVER[QUERY_STRING] == "change" and $error != ""))
{ //3
echo "<p><strong>Изменение резюме</strong><form name=form1 method=post ENCTYPE=multipart/form-data action=admincr.php?change>";
if ($_SERVER[QUERY_STRING] != "change" or $error != "")
{ //4

if ($razdel == '')
{
if ($_GET['razdel'] == '') {$razdel=$_POST['razdel'];}
elseif ($_GET['razdel'] != '') {$razdel=$_GET['razdel'];}
}
$resultadd1 = @mysql_query("SELECT * FROM $catable WHERE ID='$razdel' LIMIT 1");
while($myrow=mysql_fetch_array($resultadd1)) {
$razdelsh=$myrow["razdel"];
}

echo ("
<p><center><strong>Обязательные поля отмечены символом <font color=#FF0000>*</font></strong></p>
<input type=hidden name=texid value=$texid>
<input type=hidden name=who value=$who>
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
<td align=left><select name=podrazdel size=1>
<option selected value=\"$podrazdel\">$podrazdel</option>
");
while($myrow=mysql_fetch_array($result3)) {
$podrazdel=$myrow["podrazdel"];
$podrazdelID=$myrow["ID"];
echo "<option value=\"$podrazdelID\">$podrazdel</option>";
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
<tr bgcolor=$maincolor><td align=right valign=top><font color=#FF0000>*</font>Желаемая должность:</td>
<td><input type=text name=profecy size=30 value=\"$profecy\"></td></tr>
<tr bgcolor=$maincolor><td align=right>Желаемая зарплата:</td>
<td>От&nbsp;<input type=text name=zp size=5 value=\"$zp\">&nbsp;$valute</td></tr>
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
<tr bgcolor=$maincolor><td align=right valign=top>Условия труда:<br>(не более 1000 симв.)</td>
<td><textarea rows=3 name=uslov cols=28>$uslov</textarea></td></tr>

<tr bgcolor=$maincolor><td colspan=2 align=center><hr width=90% size=1><br><b>Образование</b>:</td></tr>
<tr bgcolor=$maincolor><td colspan=2 align=center>

<table width=100%>
<tr bgcolor=$maincolor><td align=right valign=top>Образование:</td>
<td><select name=edu1sel size=1>
<option selected value=\"$edu1sel\">$edu1sel</option>
<option value=\"Среднее\">Среднее</option>
<option value=\"Среднее-специальное\">Среднее-специальное</option>
<option value=\"Неполное&nbsp;высшее\">Неполное&nbsp;высшее</option>
<option value=\"Высшее\">Высшее</option>
<option value=\"МВА\">МВА</option>
<option value=\"Курсы&nbsp;переподготовки\">Курсы&nbsp;переподготовки</option>
<option value=\"Второе&nbsp;высшее\">Второе&nbsp;высшее</option>
<option value=\"Докторантура\">Докторантура</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=right>Учебное заведение:</td>
<td><input type=text name=edu1school size=30 value=\"$edu1school\"></td></tr>
<tr bgcolor=$maincolor><td align=right>Окончил(а) в:</td>
<td><input type=text name=edu1year size=5 value=\"$edu1year\"> году</td></tr>
<tr bgcolor=$maincolor><td align=right>Факультет:</td>
<td><input type=text name=edu1fac size=30 value=\"$edu1fac\"></td></tr>
<tr bgcolor=$maincolor><td align=right>Специальность:</td>
<td><input type=text name=edu1spec size=30 value=\"$edu1spec\"></td></tr>
</table>
");

$lastedu=1;
if ($edu2sel != '' or $edu2school != '' or $edu2year != '' or $edu2fac != '' or $edu2spec != '') 
{
$style2table='';
$style1but="style=\"display : none;\"";
$lastedu=2;
}
elseif ($edu2sel == '' and $edu2school == '' and $edu2year == '' and $edu2fac == '' and $edu2spec == '') 
{
$style2table="style=\"display : none;\"";
$style1but='';
$lastedu=1;
}
if ($edu3sel != '' or $edu3school != '' or $edu3year != '' or $edu3fac != '' or $edu3spec != '') 
{
$style3table='';
$style2but="style=\"display : none;\"";
$lastedu=3;
}
elseif ($edu3sel == '' and $edu3school == '' and $edu3year == '' and $edu3fac == '' and $edu3spec == '') 
{
$style3table="style=\"display : none;\"";
$style2but="style=\"display : none;\"";
}
if ($edu4sel != '' or $edu4school != '' or $edu4year != '' or $edu4fac != '' or $edu4spec != '') 
{
$style4table='';
$style3but="style=\"display : none;\"";
$lastedu=4;
}
elseif ($edu4sel == '' and $edu4school == '' and $edu4year == '' and $edu4fac == '' and $edu4spec == '') 
{
$style4table="style=\"display : none;\"";
$style3but="style=\"display : none;\"";
}
if ($edu5sel != '' or $edu5school != '' or $edu5year != '' or $edu5fac != '' or $edu5spec != '') 
{
$style5table='';
$style4but="style=\"display : none;\"";
}
elseif ($edu5sel == '' and $edu5school == '' and $edu5year == '' and $edu5fac == '' and $edu5spec == '') 
{
$style5table="style=\"display : none;\"";
$style4but="style=\"display : none;\"";
}
if ($lastedu == 1) {$style1but="";}
if ($lastedu == 2) {$style2but="";}
if ($lastedu == 3) {$style3but="";}
if ($lastedu == 4) {$style4but="";}

echo ("
<div id=but1 $style1but>
<input name=submit type=button value=\"ДОБАВИТЬ НОВУЮ ИНФОРМАЦИЮ ОБ ОБРАЗОВАНИИ (можно еще 4)\" onclick=\"Hide('but1');Shw('edu2');Shw('but2');\">
</div>

<div id=edu2 $style2table>
<table width=100%>
<tr bgcolor=$maincolor><td colspan=2><br></td></tr>
<tr bgcolor=$maincolor><td align=right valign=top>Образование:</td>
<td><select name=edu2sel size=1>
<option selected value=\"$edu2sel\">$edu2sel</option>
<option value=\"Среднее\">Среднее</option>
<option value=\"Среднее-специальное\">Среднее-специальное</option>
<option value=\"Неполное&nbsp;высшее\">Неполное&nbsp;высшее</option>
<option value=\"Высшее\">Высшее</option>
<option value=\"МВА\">МВА</option>
<option value=\"Курсы&nbsp;переподготовки\">Курсы&nbsp;переподготовки</option>
<option value=\"Второе&nbsp;высшее\">Второе&nbsp;высшее</option>
<option value=\"Докторантура\">Докторантура</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=right>Учебное заведение:</td>
<td><input type=text name=edu2school size=30 value=\"$edu2school\"></td></tr>
<tr bgcolor=$maincolor><td align=right>Окончил(а) в:</td>
<td><input type=text name=edu2year size=5 value=\"$edu2year\"> году</td></tr>
<tr bgcolor=$maincolor><td align=right>Факультет:</td>
<td><input type=text name=edu2fac size=30 value=\"$edu2fac\"></td></tr>
<tr bgcolor=$maincolor><td align=right>Специальность:</td>
<td><input type=text name=edu2spec size=30 value=\"$edu2spec\"></td></tr>
<tr bgcolor=$maincolor><td colspan=2><br></td></tr>
</table>
</div>

<div id=but2 $style2but>
<input name=submit type=button value=\"ДОБАВИТЬ НОВУЮ ИНФОРМАЦИЮ ОБ ОБРАЗОВАНИИ (можно еще 3)\" onclick=\"Hide('but2');Shw('edu3');Shw('but3');\">
</div>

<div id=edu3 $style3table>
<table width=100%>
<tr bgcolor=$maincolor><td align=right valign=top>Образование:</td>
<td><select name=edu3sel size=1>
<option selected value=\"$edu3sel\">$edu3sel</option>
<option value=\"Среднее\">Среднее</option>
<option value=\"Среднее-специальное\">Среднее-специальное</option>
<option value=\"Неполное&nbsp;высшее\">Неполное&nbsp;высшее</option>
<option value=\"Высшее\">Высшее</option>
<option value=\"МВА\">МВА</option>
<option value=\"Курсы&nbsp;переподготовки\">Курсы&nbsp;переподготовки</option>
<option value=\"Второе&nbsp;высшее\">Второе&nbsp;высшее</option>
<option value=\"Докторантура\">Докторантура</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=right>Учебное заведение:</td>
<td><input type=text name=edu3school size=30 value=\"$edu3school\"></td></tr>
<tr bgcolor=$maincolor><td align=right>Окончил(а) в:</td>
<td><input type=text name=edu3year size=5 value=\"$edu3year\"> году</td></tr>
<tr bgcolor=$maincolor><td align=right>Факультет:</td>
<td><input type=text name=edu3fac size=30 value=\"$edu3fac\"></td></tr>
<tr bgcolor=$maincolor><td align=right>Специальность:</td>
<td><input type=text name=edu3spec size=30 value=\"$edu3spec\"></td></tr>
<tr bgcolor=$maincolor><td colspan=2><br></td></tr>
</table>
</div>

<div id=but3 $style3but>
<input name=submit type=button value=\"ДОБАВИТЬ НОВУЮ ИНФОРМАЦИЮ ОБ ОБРАЗОВАНИИ (можно еще 2)\" onclick=\"Hide('but3');Shw('edu4');Shw('but4');\">
</div>

<div id=edu4 $style4table>
<table width=100%>
<tr bgcolor=$maincolor><td align=right valign=top>Образование:</td>
<td><select name=edu4sel size=1>
<option selected value=\"$edu4sel\">$edu4sel</option>
<option value=\"Среднее\">Среднее</option>
<option value=\"Среднее-специальное\">Среднее-специальное</option>
<option value=\"Неполное&nbsp;высшее\">Неполное&nbsp;высшее</option>
<option value=\"Высшее\">Высшее</option>
<option value=\"МВА\">МВА</option>
<option value=\"Курсы&nbsp;переподготовки\">Курсы&nbsp;переподготовки</option>
<option value=\"Второе&nbsp;высшее\">Второе&nbsp;высшее</option>
<option value=\"Докторантура\">Докторантура</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=right>Учебное заведение:</td>
<td><input type=text name=edu4school size=30 value=\"$edu4school\"></td></tr>
<tr bgcolor=$maincolor><td align=right>Окончил(а) в:</td>
<td><input type=text name=edu4year size=5 value=\"$edu4year\"> году</td></tr>
<tr bgcolor=$maincolor><td align=right>Факультет:</td>
<td><input type=text name=edu4fac size=30 value=\"$edu4fac\"></td></tr>
<tr bgcolor=$maincolor><td align=right>Специальность:</td>
<td><input type=text name=edu4spec size=30 value=\"$edu4spec\"></td></tr>
<tr bgcolor=$maincolor><td colspan=2><br></td></tr>
</table>
</div>

<div id=but4 $style4but>
<input name=submit type=button value=\"ДОБАВИТЬ НОВУЮ ИНФОРМАЦИЮ ОБ ОБРАЗОВАНИИ (можно еще 1)\" onclick=\"Hide('but4');Shw('edu5');\">
</div>

<div id=edu5 $style5table>
<table width=100%>
<tr bgcolor=$maincolor><td align=right valign=top>Образование:</td>
<td><select name=edu5sel size=1>
<option selected value=\"$edu5sel\">$edu5sel</option>
<option value=\"Среднее\">Среднее</option>
<option value=\"Среднее-специальное\">Среднее-специальное</option>
<option value=\"Неполное&nbsp;высшее\">Неполное&nbsp;высшее</option>
<option value=\"Высшее\">Высшее</option>
<option value=\"МВА\">МВА</option>
<option value=\"Курсы&nbsp;переподготовки\">Курсы&nbsp;переподготовки</option>
<option value=\"Второе&nbsp;высшее\">Второе&nbsp;высшее</option>
<option value=\"Докторантура\">Докторантура</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=right>Учебное заведение:</td>
<td><input type=text name=edu5school size=30 value=\"$edu5school\"></td></tr>
<tr bgcolor=$maincolor><td align=right>Окончил(а) в:</td>
<td><input type=text name=edu5year size=5 value=\"$edu5year\"> году</td></tr>
<tr bgcolor=$maincolor><td align=right>Факультет:</td>
<td><input type=text name=edu5fac size=30 value=\"$edu5fac\"></td></tr>
<tr bgcolor=$maincolor><td align=right>Специальность:</td>
<td><input type=text name=edu5spec size=30 value=\"$edu5spec\"></td></tr>
<tr bgcolor=$maincolor><td colspan=2><br></td></tr>
</table>
</div>

</td></tr>
<tr bgcolor=$maincolor><td colspan=2 align=center><hr width=90% size=1><br><b>Опыт работы</b>:</td></tr>

<tr bgcolor=$maincolor><td colspan=2 align=center>

<table width=100%>
<tr bgcolor=$maincolor><td align=right>Организация:</td>
<td><input type=text name=expir1org size=30 value=\"$expir1org\"></td></tr>
<tr bgcolor=$maincolor><td align=right>Период работы:</td>
<td>с <select name=expir1perfmonth size=1>
<option selected value=\"$expir1perfmonth\">$expir1perfmonth</option>
<option value=\"январь\">январь</option>
<option value=\"февраль\">февраль</option>
<option value=\"март\">март</option>
<option value=\"апрель\">апрель</option>
<option value=\"май\">май</option>
<option value=\"июнь\">июнь</option>
<option value=\"июль\">июль</option>
<option value=\"август\">август</option>
<option value=\"сентябрь\">сентябрь</option>
<option value=\"октябрь\">октябрь</option>
<option value=\"ноябрь\">ноябрь</option>
<option value=\"декабрь\">декабрь</option>
</select> <input type=text name=expir1perfyear size=4 value=\"$expir1perfyear\">&nbsp;&nbsp;&nbsp;&nbsp;
по <select name=expir1pertmonth size=1>
<option selected value=\"$expir1pertmonth\">$expir1pertmonth</option>
<option value=\"наст.время\">наст.время</option>
<option value=\"январь\">январь</option>
<option value=\"февраль\">февраль</option>
<option value=\"март\">март</option>
<option value=\"апрель\">апрель</option>
<option value=\"май\">май</option>
<option value=\"июнь\">июнь</option>
<option value=\"июль\">июль</option>
<option value=\"август\">август</option>
<option value=\"сентябрь\">сентябрь</option>
<option value=\"октябрь\">октябрь</option>
<option value=\"ноябрь\">ноябрь</option>
<option value=\"декабрь\">декабрь</option>
</select> <input type=text name=expir1pertyear size=4 value=\"$expir1pertyear\"><br>
<small>месяц</small>
</td></tr>
<tr bgcolor=$maincolor><td align=right>Занимаемая должность:</td>
<td><input type=text name=expir1dol size=30 value=\"$expir1dol\"></td></tr>
<tr bgcolor=$maincolor><td align=right>Ваши обязанности:</td>
<td><textarea rows=5 name=expir1obyaz cols=40>$expir1obyaz</textarea><br>
<small>Кратко опишите ваши обязанности за время работы в данной организации</small>
</td></tr>
</table>
");

$lastexpir=1;
if ($expir2org != '' or $expir2perfmonth != '' or $expir2perfyear != '' or $expir2pertmonth != '' or $expir2pertyear != '' or $expir2dol != '' or $expir2obyaz != '') 
{
$style2expir='';
$style1butexp="style=\"display : none;\"";
$lastexpir=2;
}
elseif ($expir2org == '' and $expir2perfmonth == '' and $expir2perfyear == '' and $expir2pertmonth == '' and $expir2pertyear == '' and $expir2dol == '' and $expir2obyaz == '') 
{
$style2expir="style=\"display : none;\"";
$style1butexp='';
$lastexpir=1;
}
if ($expir3org != '' or $expir3perfmonth != '' or $expir3perfyear != '' or $expir3pertmonth != '' or $expir3pertyear != '' or $expir3dol != '' or $expir3obyaz != '') 
{
$style3expir='';
$style2butexp="style=\"display : none;\"";
$lastexpir=3;
}
elseif ($expir3org == '' and $expir3perfmonth == '' and $expir3perfyear == '' and $expir3pertmonth == '' and $expir3pertyear == '' and $expir3dol == '' and $expir3obyaz == '') 
{
$style3expir="style=\"display : none;\"";
$style2butexp="style=\"display : none;\"";
}
if ($expir4org != '' or $expir4perfmonth != '' or $expir4perfyear != '' or $expir4pertmonth != '' or $expir4pertyear != '' or $expir4dol != '' or $expir4obyaz != '') 
{
$style4expir='';
$style3butexp="style=\"display : none;\"";
$lastexpir=4;
}
elseif ($expir4org == '' and $expir4perfmonth == '' and $expir4perfyear == '' and $expir4pertmonth == '' and $expir4pertyear == '' and $expir4dol == '' and $expir4obyaz == '') 
{
$style4expir="style=\"display : none;\"";
$style3butexp="style=\"display : none;\"";
}
if ($expir5org != '' or $expir5perfmonth != '' or $expir5perfyear != '' or $expir5pertmonth != '' or $expir5pertyear != '' or $expir5dol != '' or $expir5obyaz != '') 
{
$style5expir='';
$style4butexp="style=\"display : none;\"";
}
elseif ($expir5org == '' and $expir5perfmonth == '' and $expir5perfyear == '' and $expir5pertmonth == '' and $expir5pertyear == '' and $expir5dol == '' and $expir5obyaz == '') 
{
$style5expir="style=\"display : none;\"";
$style4butexp="style=\"display : none;\"";
}
if ($lastexpir == 1) {$style1butexp="";}
if ($lastexpir == 2) {$style2butexp="";}
if ($lastexpir == 3) {$style3butexp="";}
if ($lastexpir == 4) {$style4butexp="";}

echo ("
<div id=butexp1 $style1butexp>
<input name=submit type=button value=\"ДОБАВИТЬ НОВОЕ МЕСТО РАБОТЫ (можно еще 4)\" onclick=\"Hide('butexp1');Shw('expir2');Shw('butexp2');\">
</div>

<div id=expir2 $style2expir>
<table width=100%>
<tr bgcolor=$maincolor><td colspan=2><br></td></tr>
<tr bgcolor=$maincolor><td align=right>Организация:</td>
<td><input type=text name=expir2org size=30 value=\"$expir2org\"></td></tr>
<tr bgcolor=$maincolor><td align=right>Период работы:</td>
<td>с <select name=expir2perfmonth size=1>
<option selected value=\"$expir2perfmonth\">$expir2perfmonth</option>
<option value=\"январь\">январь</option>
<option value=\"февраль\">февраль</option>
<option value=\"март\">март</option>
<option value=\"апрель\">апрель</option>
<option value=\"май\">май</option>
<option value=\"июнь\">июнь</option>
<option value=\"июль\">июль</option>
<option value=\"август\">август</option>
<option value=\"сентябрь\">сентябрь</option>
<option value=\"октябрь\">октябрь</option>
<option value=\"ноябрь\">ноябрь</option>
<option value=\"декабрь\">декабрь</option>
</select> <input type=text name=expir2perfyear size=4 value=\"$expir2perfyear\">&nbsp;&nbsp;&nbsp;&nbsp;
по <select name=expir2pertmonth size=1>
<option selected value=\"$expir2pertmonth\">$expir2pertmonth</option>
<option value=\"наст.время\">наст.время</option>
<option value=\"январь\">январь</option>
<option value=\"февраль\">февраль</option>
<option value=\"март\">март</option>
<option value=\"апрель\">апрель</option>
<option value=\"май\">май</option>
<option value=\"июнь\">июнь</option>
<option value=\"июль\">июль</option>
<option value=\"август\">август</option>
<option value=\"сентябрь\">сентябрь</option>
<option value=\"октябрь\">октябрь</option>
<option value=\"ноябрь\">ноябрь</option>
<option value=\"декабрь\">декабрь</option>
</select> <input type=text name=expir2pertyear size=4 value=\"$expir2pertyear\"><br>
<small>месяц</small>
</td></tr>
<tr bgcolor=$maincolor><td align=right>Занимаемая должность:</td>
<td><input type=text name=expir2dol size=30 value=\"$expir2dol\"></td></tr>
<tr bgcolor=$maincolor><td align=right>Ваши обязанности:</td>
<td><textarea rows=5 name=expir2obyaz cols=40>$expir2obyaz</textarea><br>
<small>Кратко опишите ваши обязанности за время работы в данной организации</small>
</td></tr>
</table>
</div>

<div id=butexp2 $style2butexp>
<input name=submit type=button value=\"ДОБАВИТЬ НОВОЕ МЕСТО РАБОТЫ (можно еще 3)\" onclick=\"Hide('butexp2');Shw('expir3');Shw('butexp3');\">
</div>

<div id=expir3 $style3expir>
<table width=100%>
<tr bgcolor=$maincolor><td colspan=2><br></td></tr>
<tr bgcolor=$maincolor><td align=right>Организация:</td>
<td><input type=text name=expir3org size=30 value=\"$expir3org\"></td></tr>
<tr bgcolor=$maincolor><td align=right>Период работы:</td>
<td>с <select name=expir3perfmonth size=1>
<option selected value=\"$expir3perfmonth\">$expir3perfmonth</option>
<option value=\"январь\">январь</option>
<option value=\"февраль\">февраль</option>
<option value=\"март\">март</option>
<option value=\"апрель\">апрель</option>
<option value=\"май\">май</option>
<option value=\"июнь\">июнь</option>
<option value=\"июль\">июль</option>
<option value=\"август\">август</option>
<option value=\"сентябрь\">сентябрь</option>
<option value=\"октябрь\">октябрь</option>
<option value=\"ноябрь\">ноябрь</option>
<option value=\"декабрь\">декабрь</option>
</select> <input type=text name=expir3perfyear size=4 value=\"$expir3perfyear\">&nbsp;&nbsp;&nbsp;&nbsp;
по <select name=expir3pertmonth size=1>
<option selected value=\"$expir3pertmonth\">$expir3pertmonth</option>
<option value=\"наст.время\">наст.время</option>
<option value=\"январь\">январь</option>
<option value=\"февраль\">февраль</option>
<option value=\"март\">март</option>
<option value=\"апрель\">апрель</option>
<option value=\"май\">май</option>
<option value=\"июнь\">июнь</option>
<option value=\"июль\">июль</option>
<option value=\"август\">август</option>
<option value=\"сентябрь\">сентябрь</option>
<option value=\"октябрь\">октябрь</option>
<option value=\"ноябрь\">ноябрь</option>
<option value=\"декабрь\">декабрь</option>
</select> <input type=text name=expir3pertyear size=4 value=\"$expir3pertyear\"><br>
<small>месяц</small>
</td></tr>
<tr bgcolor=$maincolor><td align=right>Занимаемая должность:</td>
<td><input type=text name=expir3dol size=30 value=\"$expir3dol\"></td></tr>
<tr bgcolor=$maincolor><td align=right>Ваши обязанности:</td>
<td><textarea rows=5 name=expir3obyaz cols=40>$expir3obyaz</textarea><br>
<small>Кратко опишите ваши обязанности за время работы в данной организации</small>
</td></tr>
</table>
</div>

<div id=butexp3 $style3butexp>
<input name=submit type=button value=\"ДОБАВИТЬ НОВОЕ МЕСТО РАБОТЫ (можно еще 2)\" onclick=\"Hide('butexp3');Shw('expir4');Shw('butexp4');\">
</div>

<div id=expir4 $style4expir>
<table width=100%>
<tr bgcolor=$maincolor><td colspan=2><br></td></tr>
<tr bgcolor=$maincolor><td align=right>Организация:</td>
<td><input type=text name=expir4org size=30 value=\"$expir4org\"></td></tr>
<tr bgcolor=$maincolor><td align=right>Период работы:</td>
<td>с <select name=expir4perfmonth size=1>
<option selected value=\"$expir4perfmonth\">$expir4perfmonth</option>
<option value=\"январь\">январь</option>
<option value=\"февраль\">февраль</option>
<option value=\"март\">март</option>
<option value=\"апрель\">апрель</option>
<option value=\"май\">май</option>
<option value=\"июнь\">июнь</option>
<option value=\"июль\">июль</option>
<option value=\"август\">август</option>
<option value=\"сентябрь\">сентябрь</option>
<option value=\"октябрь\">октябрь</option>
<option value=\"ноябрь\">ноябрь</option>
<option value=\"декабрь\">декабрь</option>
</select> <input type=text name=expir4perfyear size=4 value=\"$expir4perfyear\">&nbsp;&nbsp;&nbsp;&nbsp;
по <select name=expir4pertmonth size=1>
<option selected value=\"$expir4pertmonth\">$expir4pertmonth</option>
<option value=\"наст.время\">наст.время</option>
<option value=\"январь\">январь</option>
<option value=\"февраль\">февраль</option>
<option value=\"март\">март</option>
<option value=\"апрель\">апрель</option>
<option value=\"май\">май</option>
<option value=\"июнь\">июнь</option>
<option value=\"июль\">июль</option>
<option value=\"август\">август</option>
<option value=\"сентябрь\">сентябрь</option>
<option value=\"октябрь\">октябрь</option>
<option value=\"ноябрь\">ноябрь</option>
<option value=\"декабрь\">декабрь</option>
</select> <input type=text name=expir4pertyear size=4 value=\"$expir4pertyear\"><br>
<small>месяц</small>
</td></tr>
<tr bgcolor=$maincolor><td align=right>Занимаемая должность:</td>
<td><input type=text name=expir4dol size=30 value=\"$expir4dol\"></td></tr>
<tr bgcolor=$maincolor><td align=right>Ваши обязанности:</td>
<td><textarea rows=5 name=expir4obyaz cols=40>$expir4obyaz</textarea><br>
<small>Кратко опишите ваши обязанности за время работы в данной организации</small>
</td></tr>
</table>
</div>

<div id=butexp4 $style4butexp>
<input name=submit type=button value=\"ДОБАВИТЬ НОВОЕ МЕСТО РАБОТЫ (можно еще 1)\" onclick=\"Hide('butexp4');Shw('expir5');\">
</div>

<div id=expir5 $style5expir>
<table width=100%>
<tr bgcolor=$maincolor><td colspan=2><br></td></tr>
<tr bgcolor=$maincolor><td align=right>Организация:</td>
<td><input type=text name=expir5org size=30 value=\"$expir5org\"></td></tr>
<tr bgcolor=$maincolor><td align=right>Период работы:</td>
<td>с <select name=expir5perfmonth size=1>
<option selected value=\"$expir5perfmonth\">$expir5perfmonth</option>
<option value=\"январь\">январь</option>
<option value=\"февраль\">февраль</option>
<option value=\"март\">март</option>
<option value=\"апрель\">апрель</option>
<option value=\"май\">май</option>
<option value=\"июнь\">июнь</option>
<option value=\"июль\">июль</option>
<option value=\"август\">август</option>
<option value=\"сентябрь\">сентябрь</option>
<option value=\"октябрь\">октябрь</option>
<option value=\"ноябрь\">ноябрь</option>
<option value=\"декабрь\">декабрь</option>
</select> <input type=text name=expir5perfyear size=4 value=\"$expir5perfyear\">&nbsp;&nbsp;&nbsp;&nbsp;
по <select name=expir5pertmonth size=1>
<option selected value=\"$expir5pertmonth\">$expir5pertmonth</option>
<option value=\"наст.время\">наст.время</option>
<option value=\"январь\">январь</option>
<option value=\"февраль\">февраль</option>
<option value=\"март\">март</option>
<option value=\"апрель\">апрель</option>
<option value=\"май\">май</option>
<option value=\"июнь\">июнь</option>
<option value=\"июль\">июль</option>
<option value=\"август\">август</option>
<option value=\"сентябрь\">сентябрь</option>
<option value=\"октябрь\">октябрь</option>
<option value=\"ноябрь\">ноябрь</option>
<option value=\"декабрь\">декабрь</option>
</select> <input type=text name=expir5pertyear size=4 value=\"$expir5pertyear\"><br>
<small>месяц</small>
</td></tr>
<tr bgcolor=$maincolor><td align=right>Занимаемая должность:</td>
<td><input type=text name=expir5dol size=30 value=\"$expir5dol\"></td></tr>
<tr bgcolor=$maincolor><td align=right>Ваши обязанности:</td>
<td><textarea rows=5 name=expir5obyaz cols=40>$expir5obyaz</textarea><br>
<small>Кратко опишите ваши обязанности за время работы в данной организации</small>
</td></tr>
<tr bgcolor=$maincolor><td colspan=2><br></td></tr>
</table>
</div>

</td></tr>
<tr bgcolor=$maincolor><td colspan=2 align=center><hr width=90% size=1><br><b>Знание иностранных языков</b>:</td></tr>
<tr bgcolor=$maincolor><td colspan=2 align=center>

<table width=100%>
<tr bgcolor=$maincolor><td align=right valign=top>Выберите язык:</td>
<td><select name=lang1 size=1>
<option selected value=\"$lang1\">$lang1</option>
<option value=\"Английский\">Английский</option>
<option value=\"Немецкий\">Немецкий</option>
<option value=\"Французский\">Французский</option>
<option value=\"Испанский\">Испанский</option>
<option value=\"Китайский\">Китайский</option>
<option value=\"Итальянский\">Итальянский</option>
<option value=\"Арабский\">Арабский</option>
<option value=\"Иврит\">Иврит</option>
<option value=\"Корейский\">Корейский</option>
<option value=\"Турецкий\">Турецкий</option>
<option value=\"Финский\">Финский</option>
<option value=\"Шведский\">Шведский</option>
<option value=\"Японский\">Японский</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=right valign=top>Уровень знаний:</td>
<td><select name=lang1uroven size=1>
<option selected value=\"$lang1uroven\">$lang1uroven</option>
<option value=\"Элементарный&nbsp;(Elementary)\">Элементарный&nbsp;(Elementary)</option>
<option value=\"Ниже&nbsp;среднего&nbsp;(Pre-Intermediate)\">Ниже&nbsp;среднего&nbsp;(Pre-Intermediate)</option>
<option value=\"Средний&nbsp;(Intermediate)\">Средний&nbsp;(Intermediate)</option>
<option value=\"Выше&nbsp;среднего&nbsp;(Upper-Intermediate)\">Выше&nbsp;среднего&nbsp;(Upper-Intermediate)</option>
<option value=\"Высший&nbsp;(Advanced)\">Высший&nbsp;(Advanced)</option>
</select></td></tr>
</table>
");

$lastlang=1;
if ($lang2 != '' or $lang2uroven != '') 
{
$style2lang='';
$style1butlan="style=\"display : none;\"";
$lastlang=2;
}
elseif ($lang2 == '' and $lang2uroven == '') 
{
$style2lang="style=\"display : none;\"";
$style1butlan='';
$lastlang=1;
}
if ($lang3 != '' or $lang3uroven != '') 
{
$style3lang='';
$style2butlan="style=\"display : none;\"";
$lastlang=3;
}
elseif ($lang3 == '' and $lang3uroven == '') 
{
$style3lang="style=\"display : none;\"";
$style2butlan="style=\"display : none;\"";
}
if ($lang4 != '' or $lang4uroven != '') 
{
$style4lang='';
$style3butlan="style=\"display : none;\"";
$lastlang=4;
}
elseif ($lang4 == '' and $lang4uroven == '') 
{
$style4lang="style=\"display : none;\"";
$style3butlan="style=\"display : none;\"";
}
if ($lang5 != '' or $lang5uroven != '') 
{
$style5lang='';
$style4butlan="style=\"display : none;\"";
}
elseif ($lang5 == '' and $lang5uroven == '') 
{
$style5lang="style=\"display : none;\"";
$style4butlan="style=\"display : none;\"";
}
if ($lastlang == 1) {$style1butlan="";}
if ($lastlang == 2) {$style2butlan="";}
if ($lastlang == 3) {$style3butlan="";}
if ($lastlang == 4) {$style4butlan="";}

echo ("
<div id=butlan1 $style1butlan>
<input name=submit type=button value=\"Я ЗНАЮ ЕЩЕ ИНОСТРАННЫЕ ЯЗЫКИ (можно еще 4)\" onclick=\"Hide('butlan1');Shw('dlang2');Shw('butlan2');\">
</div>

<div id=dlang2 $style2lang>
<table width=100%>
<tr bgcolor=$maincolor><td colspan=2><br></td></tr>
<tr bgcolor=$maincolor><td align=right valign=top>Выберите язык:</td>
<td><select name=lang2 size=1>
<option selected value=\"$lang2\">$lang2</option>
<option value=\"Английский\">Английский</option>
<option value=\"Немецкий\">Немецкий</option>
<option value=\"Французский\">Французский</option>
<option value=\"Испанский\">Испанский</option>
<option value=\"Китайский\">Китайский</option>
<option value=\"Итальянский\">Итальянский</option>
<option value=\"Арабский\">Арабский</option>
<option value=\"Иврит\">Иврит</option>
<option value=\"Корейский\">Корейский</option>
<option value=\"Турецкий\">Турецкий</option>
<option value=\"Финский\">Финский</option>
<option value=\"Шведский\">Шведский</option>
<option value=\"Японский\">Японский</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=right valign=top>Уровень знаний:</td>
<td><select name=lang2uroven size=1>
<option selected value=\"$lang2uroven\">$lang2uroven</option>
<option value=\"Элементарный&nbsp;(Elementary)\">Элементарный&nbsp;(Elementary)</option>
<option value=\"Ниже&nbsp;среднего&nbsp;(Pre-Intermediate)\">Ниже&nbsp;среднего&nbsp;(Pre-Intermediate)</option>
<option value=\"Средний&nbsp;(Intermediate)\">Средний&nbsp;(Intermediate)</option>
<option value=\"Выше&nbsp;среднего&nbsp;(Upper-Intermediate)\">Выше&nbsp;среднего&nbsp;(Upper-Intermediate)</option>
<option value=\"Высший&nbsp;(Advanced)\">Высший&nbsp;(Advanced)</option>
</select></td></tr>
</table>
</div>

<div id=butlan2 $style2butlan>
<input name=submit type=button value=\"Я ЗНАЮ ЕЩЕ ИНОСТРАННЫЕ ЯЗЫКИ (можно еще 3)\" onclick=\"Hide('butlan2');Shw('dlang3');Shw('butlan3');\">
</div>

<div id=dlang3 $style3lang>
<table width=100%>
<tr bgcolor=$maincolor><td colspan=2><br></td></tr>
<tr bgcolor=$maincolor><td align=right valign=top>Выберите язык:</td>
<td><select name=lang3 size=1>
<option selected value=\"$lang3\">$lang3</option>
<option value=\"Английский\">Английский</option>
<option value=\"Немецкий\">Немецкий</option>
<option value=\"Французский\">Французский</option>
<option value=\"Испанский\">Испанский</option>
<option value=\"Китайский\">Китайский</option>
<option value=\"Итальянский\">Итальянский</option>
<option value=\"Арабский\">Арабский</option>
<option value=\"Иврит\">Иврит</option>
<option value=\"Корейский\">Корейский</option>
<option value=\"Турецкий\">Турецкий</option>
<option value=\"Финский\">Финский</option>
<option value=\"Шведский\">Шведский</option>
<option value=\"Японский\">Японский</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=right valign=top>Уровень знаний:</td>
<td><select name=lang3uroven size=1>
<option selected value=\"$lang3uroven\">$lang3uroven</option>
<option value=\"Элементарный&nbsp;(Elementary)\">Элементарный&nbsp;(Elementary)</option>
<option value=\"Ниже&nbsp;среднего&nbsp;(Pre-Intermediate)\">Ниже&nbsp;среднего&nbsp;(Pre-Intermediate)</option>
<option value=\"Средний&nbsp;(Intermediate)\">Средний&nbsp;(Intermediate)</option>
<option value=\"Выше&nbsp;среднего&nbsp;(Upper-Intermediate)\">Выше&nbsp;среднего&nbsp;(Upper-Intermediate)</option>
<option value=\"Высший&nbsp;(Advanced)\">Высший&nbsp;(Advanced)</option>
</select></td></tr>
</table>
</div>

<div id=butlan3 $style3butlan>
<input name=submit type=button value=\"Я ЗНАЮ ЕЩЕ ИНОСТРАННЫЕ ЯЗЫКИ (можно еще 2)\" onclick=\"Hide('butlan3');Shw('dlang4');Shw('butlan4');\">
</div>

<div id=dlang4 $style4lang>
<table width=100%>
<tr bgcolor=$maincolor><td colspan=2><br></td></tr>
<tr bgcolor=$maincolor><td align=right valign=top>Выберите язык:</td>
<td><select name=lang4 size=1>
<option selected value=\"$lang4\">$lang4</option>
<option value=\"Английский\">Английский</option>
<option value=\"Немецкий\">Немецкий</option>
<option value=\"Французский\">Французский</option>
<option value=\"Испанский\">Испанский</option>
<option value=\"Китайский\">Китайский</option>
<option value=\"Итальянский\">Итальянский</option>
<option value=\"Арабский\">Арабский</option>
<option value=\"Иврит\">Иврит</option>
<option value=\"Корейский\">Корейский</option>
<option value=\"Турецкий\">Турецкий</option>
<option value=\"Финский\">Финский</option>
<option value=\"Шведский\">Шведский</option>
<option value=\"Японский\">Японский</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=right valign=top>Уровень знаний:</td>
<td><select name=lang4uroven size=1>
<option selected value=\"$lang4uroven\">$lang4uroven</option>
<option value=\"Элементарный&nbsp;(Elementary)\">Элементарный&nbsp;(Elementary)</option>
<option value=\"Ниже&nbsp;среднего&nbsp;(Pre-Intermediate)\">Ниже&nbsp;среднего&nbsp;(Pre-Intermediate)</option>
<option value=\"Средний&nbsp;(Intermediate)\">Средний&nbsp;(Intermediate)</option>
<option value=\"Выше&nbsp;среднего&nbsp;(Upper-Intermediate)\">Выше&nbsp;среднего&nbsp;(Upper-Intermediate)</option>
<option value=\"Высший&nbsp;(Advanced)\">Высший&nbsp;(Advanced)</option>
</select></td></tr>
</table>
</div>

<div id=butlan4 $style4butlan>
<input name=submit type=button value=\"Я ЗНАЮ ЕЩЕ ИНОСТРАННЫЕ ЯЗЫКИ (можно еще 1)\" onclick=\"Hide('butlan4');Shw('dlang5');\">
</div>

<div id=dlang5 $style5lang>
<table width=100%>
<tr bgcolor=$maincolor><td colspan=2><br></td></tr>
<tr bgcolor=$maincolor><td align=right valign=top>Выберите язык:</td>
<td><select name=lang5 size=1>
<option selected value=\"$lang5\">$lang5</option>
<option value=\"Английский\">Английский</option>
<option value=\"Немецкий\">Немецкий</option>
<option value=\"Французский\">Французский</option>
<option value=\"Испанский\">Испанский</option>
<option value=\"Китайский\">Китайский</option>
<option value=\"Итальянский\">Итальянский</option>
<option value=\"Арабский\">Арабский</option>
<option value=\"Иврит\">Иврит</option>
<option value=\"Корейский\">Корейский</option>
<option value=\"Турецкий\">Турецкий</option>
<option value=\"Финский\">Финский</option>
<option value=\"Шведский\">Шведский</option>
<option value=\"Японский\">Японский</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=right valign=top>Уровень знаний:</td>
<td><select name=lang5uroven size=1>
<option selected value=\"$lang5uroven\">$lang5uroven</option>
<option value=\"Элементарный&nbsp;(Elementary)\">Элементарный&nbsp;(Elementary)</option>
<option value=\"Ниже&nbsp;среднего&nbsp;(Pre-Intermediate)\">Ниже&nbsp;среднего&nbsp;(Pre-Intermediate)</option>
<option value=\"Средний&nbsp;(Intermediate)\">Средний&nbsp;(Intermediate)</option>
<option value=\"Выше&nbsp;среднего&nbsp;(Upper-Intermediate)\">Выше&nbsp;среднего&nbsp;(Upper-Intermediate)</option>
<option value=\"Высший&nbsp;(Advanced)\">Высший&nbsp;(Advanced)</option>
</select></td></tr>
</table>
</div>

</td></tr>

<tr bgcolor=$maincolor><td colspan=2><br></td></tr>

");
if ($who=='agency') {
echo ("
<tr bgcolor=$maincolor><td align=right>ФИО соискателя:</td>
<td><input type=text name=fio size=30 value=\"$fio\"></td></tr>
<tr bgcolor=$maincolor><td align=right valign=top>Дата рождения:</td>
<td><select name=bday size=1>
        <option selected value=$bday>$bday</option>
        <option    value=01>01</option>
        <option    value=02>02</option>
        <option    value=03>03</option>
        <option    value=04>04</option>
        <option    value=05>05</option>
        <option    value=06>06</option>
        <option    value=07>07</option>
        <option    value=08>08</option>
        <option    value=09>09</option>
        <option    value=10>10</option>
        <option    value=11>11</option>
        <option    value=12>12</option>
        <option    value=13>13</option>
        <option    value=14>14</option>
        <option    value=15>15</option>
        <option    value=16>16</option>
        <option    value=17>17</option>
        <option    value=18>18</option>
        <option    value=19>19</option>
        <option    value=20>20</option>
        <option    value=21>21</option>
        <option    value=22>22</option>
        <option    value=23>23</option>
        <option    value=24>24</option>
        <option    value=25>25</option>
        <option    value=26>26</option>
        <option    value=27>27</option>
        <option    value=28>28</option>
        <option    value=29>29</option>
        <option    value=30>30</option>
        <option    value=31>31</option>
</select>&nbsp;
<select name=bmonth size=1>
        <option selected value=$bmonth>$bmonth</option>
        <option value=01>01</option>
        <option value=02>02</option>
        <option value=03>03</option>
        <option value=04>04</option>
        <option value=05>05</option>
        <option value=06>06</option>
        <option value=07>07</option>
        <option value=08>08</option>
        <option value=09>09</option>
        <option value=10>10</option>
        <option value=11>11</option>
        <option value=12>12</option>
</select>&nbsp;
<select name=byear size=1>
        <option selected value=$byear>$byear</option>
        <option value=1900>1900</option>
        <option value=1901>1901</option>
        <option value=1902>1902</option>
        <option value=1903>1903</option>
        <option value=1904>1904</option>
        <option value=1905>1905</option>
        <option value=1906>1906</option>
        <option value=1907>1907</option>
        <option value=1908>1908</option>
        <option value=1909>1909</option>
        <option value=1910>1910</option>
        <option value=1911>1911</option>
        <option value=1912>1912</option>
        <option value=1913>1913</option>
        <option value=1914>1914</option>
        <option value=1915>1915</option>
        <option value=1916>1916</option>
        <option value=1917>1917</option>
        <option value=1918>1918</option>
        <option value=1919>1919</option>
        <option value=1920>1920</option>
        <option value=1921>1921</option>
        <option value=1922>1922</option>
        <option value=1923>1923</option>
        <option value=1924>1924</option>
        <option value=1925>1925</option>
        <option value=1926>1926</option>
        <option value=1927>1927</option>
        <option value=1928>1928</option>
        <option value=1929>1929</option>
        <option value=1930>1930</option>
        <option value=1931>1931</option>
        <option value=1932>1932</option>
        <option value=1933>1933</option>
        <option   value=1934>1934</option>
        <option   value=1935>1935</option>
        <option   value=1936>1936</option>
        <option   value=1937>1937</option>
        <option   value=1938>1938</option>
        <option   value=1939>1939</option>
        <option   value=1940>1940</option>
        <option   value=1941>1941</option>
        <option   value=1942>1942</option>
        <option   value=1943>1943</option>
        <option   value=1944>1944</option>
        <option   value=1945>1945</option>
        <option   value=1946>1946</option>
        <option   value=1947>1947</option>
        <option   value=1948>1948</option>
        <option   value=1949>1949</option>
        <option   value=1950>1950</option>
        <option   value=1951>1951</option>
        <option   value=1952>1952</option>
        <option   value=1953>1953</option>
        <option   value=1954>1954</option>
        <option   value=1955>1955</option>
        <option   value=1956>1956</option>
        <option   value=1957>1957</option>
        <option   value=1958>1958</option>
        <option   value=1959>1959</option>
        <option   value=1960>1960</option>
        <option   value=1961>1961</option>
        <option   value=1962>1962</option>
        <option   value=1963>1963</option>
        <option   value=1964>1964</option>
        <option   value=1965>1965</option>
        <option   value=1966>1966</option>
        <option   value=1967>1967</option>
        <option   value=1968>1968</option>
        <option   value=1969>1969</option>
        <option   value=1970>1970</option>
        <option   value=1971>1971</option>
        <option   value=1972>1972</option>
        <option   value=1973>1973</option>
        <option   value=1974>1974</option>
        <option   value=1975>1975</option>
        <option   value=1976>1976</option>
        <option   value=1977>1977</option>
        <option   value=1978>1978</option>
        <option   value=1979>1979</option>
        <option   value=1980>1980</option>
        <option   value=1981>1981</option>
        <option   value=1982>1982</option>
        <option   value=1983>1983</option>
        <option   value=1984>1984</option>
        <option   value=1985>1985</option>
        <option   value=1986>1986</option>
        <option   value=1987>1987</option>
        <option   value=1988>1988</option>
        <option   value=1989>1989</option>
        <option   value=1990>1990</option>
        <option   value=1991>1991</option>
        <option   value=1992>1992</option>
        <option   value=1993>1993</option>
        <option   value=1994>1994</option>
        <option   value=1995>1995</option>
        <option   value=1996>1996</option>
        <option   value=1997>1997</option>
        <option   value=1998>1998</option>
        <option   value=1999>1999</option>
        <option   value=2000>2000</option>
</select><br><small>день&nbsp;&nbsp;&nbsp;месяц&nbsp;&nbsp;&nbsp;год</small></td></tr>
<tr bgcolor=$maincolor><td align=right>Пол:</td>
<td><select name=gender size=1>
<option selected value=\"$gender\">$gender</option>
<option value=\"Мужской\">Мужской</option>
<option value=\"Женский\">Женский</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=right>Семейное положение:</td>
<td><select name=family size=1>
<option selected value=\"$family\">$family</option>
<option value=\"Не&nbsp;состою&nbsp;в&nbsp;браке,&nbsp;детей&nbsp;нет\">Не&nbsp;состою&nbsp;в&nbsp;браке,&nbsp;детей&nbsp;нет</option>
<option value=\"Не&nbsp;состою&nbsp;в&nbsp;браке,&nbsp;дети&nbsp;есть\">Не&nbsp;состою&nbsp;в&nbsp;браке,&nbsp;дети&nbsp;есть</option>
<option value=\"Состою&nbsp;в&nbsp;браке,&nbsp;детей&nbsp;нет\">Состою&nbsp;в&nbsp;браке,&nbsp;детей&nbsp;нет</option>
<option value=\"Состою&nbsp;в&nbsp;браке,&nbsp;дети&nbsp;есть\">Состою&nbsp;в&nbsp;браке,&nbsp;дети&nbsp;есть</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=right>Гражданство:</td>
<td><input type=text name=civil size=30 value=\"$civil\"></td></tr>
<tr bgcolor=$maincolor><td align=right valign=top><font color=#FF0000>*</font>Профессиональные навыки и знания:</td>
<td><textarea rows=7 name=prof cols=50>$prof</textarea><br><small>Кратко укажите ваши умения и навыки. Информация отсюда будет отображаться в кратком резюме.</small></td></tr>
<tr bgcolor=$maincolor><td align=right valign=top>Дополнительные сведения:</td>
<td><textarea rows=7 name=dopsved cols=50>$dopsved</textarea><br><small>Напишите здесь, например, ваши увлечения, занятия в свободное время, круг интересов и т.п.</small></td></tr>
");
}
echo ("
<tr bgcolor=$maincolor><td align=right valign=top>Комментарий к резюме:<br>(не более 1000 симв.)</td>
<td><textarea rows=7 name=comment cols=50>$comment</textarea></td></tr>
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
echo "<center><p><input type=submit value=\"Сохранить\" name=\"submit\" class=i3></form>";
echo "<p align=center><a href=admindv.php>Вернуться на страницу удаления</a></p>";
} //4
} //3

if ($_SERVER[QUERY_STRING] == "change" and $error == "") 
{ //5
function untag ($string) {
$string = ereg_replace("<","&lt;",$string);
$string = ereg_replace(">","&gt;",$string);
$string = ereg_replace('\\\"',"&quot;",$string);
$string = ereg_replace(":","&#58;",$string);
$string = ereg_replace("!","&#33;",$string);
$string = ereg_replace("\r","",$string);
$string = ereg_replace("\n","<br>",$string);
$string = ereg_replace("%","&#37;",$string);
$string = ereg_replace("^ +","",$string);
$string = ereg_replace(" +$","",$string);
$string = ereg_replace(" +"," ",$string);
return $string;
}
$profecy = untag($profecy);
$zp = untag($zp);
$uslov = untag($uslov);
$comment = untag($comment);
$fio = untag($fio);
$civil = untag($civil);
$prof = untag($prof);
$dopsved = untag($dopsved);
$birth="$byear-$bmonth-$bday";
$expir1org = untag($expir1org);
$expir1perfmonth = untag($expir1perfmonth);
$expir1perfyear = untag($expir1perfyear);
$expir1pertmonth = untag($expir1pertmonth);
$expir1pertyear = untag($expir1pertyear);
$expir1dol = untag($expir1dol);
$expir1obyaz = untag($expir1obyaz);
$expir2org = untag($expir2org);
$expir2perfmonth = untag($expir2perfmonth);
$expir2perfyear = untag($expir2perfyear);
$expir2pertmonth = untag($expir2pertmonth);
$expir2pertyear = untag($expir2pertyear);
$expir2dol = untag($expir2dol);
$expir2obyaz = untag($expir2obyaz);
$expir3org = untag($expir3org);
$expir3perfmonth = untag($expir3perfmonth);
$expir3perfyear = untag($expir3perfyear);
$expir3pertmonth = untag($expir3pertmonth);
$expir3pertyear = untag($expir3pertyear);
$expir3dol = untag($expir3dol);
$expir3obyaz = untag($expir3obyaz);
$expir4org = untag($expir4org);
$expir4perfmonth = untag($expir4perfmonth);
$expir4perfyear = untag($expir4perfyear);
$expir4pertmonth = untag($expir4pertmonth);
$expir4pertyear = untag($expir4pertyear);
$expir4dol = untag($expir4dol);
$expir4obyaz = untag($expir4obyaz);
$expir5org = untag($expir5org);
$expir5perfmonth = untag($expir5perfmonth);
$expir5perfyear = untag($expir5perfyear);
$expir5pertmonth = untag($expir5pertmonth);
$expir5pertyear = untag($expir5pertyear);
$expir5dol = untag($expir5dol);
$expir5obyaz = untag($expir5obyaz);
$edu1sel = untag($edu1sel);
$edu1school = untag($edu1school);
$edu1year = untag($edu1year);
$edu1fac = untag($edu1fac);
$edu1spec = untag($edu1spec);
$edu2sel = untag($edu2sel);
$edu2school = untag($edu2school);
$edu2year = untag($edu2year);
$edu2fac = untag($edu2fac);
$edu2spec = untag($edu2spec);
$edu3sel = untag($edu3sel);
$edu3school = untag($edu3school);
$edu3year = untag($edu3year);
$edu3fac = untag($edu3fac);
$edu3spec = untag($edu3spec);
$edu4sel = untag($edu4sel);
$edu4school = untag($edu4school);
$edu4year = untag($edu4year);
$edu4fac = untag($edu4fac);
$edu4spec = untag($edu4spec);
$edu5sel = untag($edu5sel);
$edu5school = untag($edu5school);
$edu5year = untag($edu5year);
$edu5fac = untag($edu5fac);
$edu5spec = untag($edu5spec);
$lang1 = untag($lang1);
$lang1uroven = untag($lang1uroven);
$lang2 = untag($lang2);
$lang2uroven = untag($lang2uroven);
$lang3 = untag($lang3);
$lang3uroven = untag($lang3uroven);
$lang4 = untag($lang4);
$lang4uroven = untag($lang4uroven);
$lang5 = untag($lang5);
$lang5uroven = untag($lang5uroven);

$date = date("Y/m/d H:i:s");
$status='ok';
$stroka='<b>В течение нескольких минут объявление будет доступно для просмотра</b>';
$sql="update $restable SET razdel='$razdel',podrazdel='$podrazdel',profecy='$profecy',zp='$zp',grafic='$grafic',zanatost='$zanatost',uslov='$uslov',comment='$comment',fio='$fio',birth='$birth',gender='$gender',civil='$civil',family='$family',prof='$prof',dopsved='$dopsved',expir1org='$expir1org',expir1perfmonth='$expir1perfmonth',expir1perfyear='$expir1perfyear',expir1pertmonth='$expir1pertmonth',expir1pertyear='$expir1pertyear',expir1dol='$expir1dol',expir1obyaz='$expir1obyaz',expir2org='$expir2org',expir2perfmonth='$expir2perfmonth',expir2perfyear='$expir2perfyear',expir2pertmonth='$expir2pertmonth',expir2pertyear='$expir2pertyear',expir2dol='$expir2dol',expir2obyaz='$expir2obyaz',expir3org='$expir3org',expir3perfmonth='$expir3perfmonth',expir3perfyear='$expir3perfyear',expir3pertmonth='$expir3pertmonth',expir3pertyear='$expir3pertyear',expir3dol='$expir3dol',expir3obyaz='$expir3obyaz',expir4org='$expir4org',expir4perfmonth='$expir4perfmonth',expir4perfyear='$expir4perfyear',expir4pertmonth='$expir4pertmonth',expir4pertyear='$expir4pertyear',expir4dol='$expir4dol',expir4obyaz='$expir4obyaz',expir5org='$expir5org',expir5perfmonth='$expir5perfmonth',expir5perfyear='$expir5perfyear',expir5pertmonth='$expir5pertmonth',expir5pertyear='$expir5pertyear',expir5dol='$expir5dol',expir5obyaz='$expir5obyaz',edu1sel='$edu1sel',edu1school='$edu1school',edu1year='$edu1year',edu1fac='$edu1fac',edu1spec='$edu1spec',edu2sel='$edu2sel',edu2school='$edu2school',edu2year='$edu2year',edu2fac='$edu2fac',edu2spec='$edu2spec',edu3sel='$edu3sel',edu3school='$edu3school',edu3year='$edu3year',edu3fac='$edu3fac',edu3spec='$edu3spec',edu4sel='$edu4sel',edu4school='$edu4school',edu4year='$edu4year',edu4fac='$edu4fac',edu4spec='$edu4spec',edu5sel='$edu5sel',edu5school='$edu5school',edu5year='$edu5year',edu5fac='$edu5fac',edu5spec='$edu5spec',lang1='$lang1',lang1uroven='$lang1uroven',lang2='$lang2',lang2uroven='$lang2uroven',lang3='$lang3',lang3uroven='$lang3uroven',lang4='$lang4',lang4uroven='$lang4uroven',lang5='$lang5',lang5uroven='$lang5uroven',period='$period',status='$status' WHERE ID='$texid'";
$result=@mysql_query($sql,$db);
echo "<center><h3>Изменения сохранены!</h3><p align=center><a href=admindr.php>Вернуться на страницу удаления</a></p><br><br>";
} //5
} //ok
echo "<center><a href=admin.php>На общую страницу администрирования</a><br><br>";
include("down.php");
?>