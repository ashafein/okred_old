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
<?php
include("var.php");
echo"<title>Добавленные вакансии : $sitename</title>";
include("top.php");
?>
<h3><center><strong>Добавленные вакансии</strong></center></h3>
<?php
$sid=$_SESSION['sid'];
$id=$_SESSION['sid'];
$slogin=$_SESSION['slogin'];
$spass=$_SESSION['spass'];

$updres=mysql_query("update $vactable set top='0000-00-00 00:00:00' where ((top + INTERVAL 86400*$periodfortop SECOND) < now())");
$updres=mysql_query("update $vactable set bold='0000-00-00 00:00:00' where ((bold + INTERVAL 86400*$periodforbold SECOND) < now())");

$result = @mysql_query("SELECT email,pass FROM $autortable WHERE (email = '$slogin' and pass = '$spass')");
if ((!isset($slogin) or !isset($spass)) or @mysql_num_rows($result) == 0)
{
echo "<center><br><br><h3>Вы не авторизированы!</h3><b><a href=autor.php>Авторизация</a></b>";
}
else
{ //1
if ($_SERVER[QUERY_STRING] != "delete")
{ //3
$result = @mysql_query("SELECT *,DATE_FORMAT(date,'%d.%m.%Y') as date,DATE_FORMAT((top + INTERVAL 86400*$periodfortop SECOND),'%d.%m.%Y') as topq,DATE_FORMAT((bold + INTERVAL 86400*$periodforbold SECOND),'%d.%m.%Y') as boldq FROM $vactable WHERE aid = '$id' order by ID DESC");
$totaltexts=@mysql_num_rows($result);
if ($totaltexts == 0) {
echo "<p align=center class=tbl1>Вы не разместили ни одного объявления!<br><br><a href=addvac.php>Разместить вакансию</a></p>";
}
else
{ //2

$resultaut = @mysql_query("SELECT ID,category,email,pass,status,pay FROM $autortable WHERE ID=$sid");
while ($myrow1=mysql_fetch_array($resultaut)) {
$pay=$myrow1["pay"];
}
if ($paytrue == 'TRUE')
{ // включены платные услуги
echo ("
<center>
Ваш ID: <b>$sid</b><br><big>На вашем счете: <b>
");
printf("%.2f",$pay);
echo ("
 USD</b></big><br><br>
");
} // включены платные услуги

$delline = '<br><input type=submit name=delob value="Удалить отмеченные" class=i3>';
echo "<p align=center class=tbl1>Всего ваших вакансий: <b>$totaltexts</b></p>";
echo ("
<div align=center><form name=deltext method=post action=mylistv.php?delete>
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$maincolor><td><img src=\"picture/basket.gif\" border=0></td><td>Должность</td><td>Зарплата</td><td>Дата публ.</td><td>Опции</td></tr>
");
while ($myrow=mysql_fetch_array($result)) 
{ //4
$tID=$myrow["ID"];
$profecy=$myrow["profecy"];
$zp=$myrow["zp"];
$agemin=$myrow["agemin"];
$agemax=$myrow["agemax"];
$edu=$myrow["edu"];
$gender=$myrow["gender"];
$grafic=$myrow["grafic"];
$zanatost=$myrow["zanatost"];
$treb=$myrow["treb"];
$aid=$myrow["aid"];
$status=$myrow["status"];
$archivedate=$myrow["archivedate"];
$date=$myrow["date"];
$razdel=$myrow["razdel"];
$podrazdel=$myrow["podrazdel"];
$top=$myrow["top"];

if ($paytrue == 'TRUE')
{ // включены платные услуги
$bold=$myrow["bold"];
$topq=$myrow["topq"];
$topql="<br><font color=green>Стоимость поднятия вакансии $paytopvacancy $valute.</font>";
if ($top != '0000-00-00 00:00:00') {$topql="<br><b>вверху до $topq</b>";}
$boldq=$myrow["boldq"];
$boldql="<br><font color=blue>Стоимость выделения вакансии $payboldvacancy $valute.</font>";
if ($bold != '0000-00-00 00:00:00') {$boldql="<br><b>выделено до $boldq</b>";}
} // включены платные услуги

$resultadd2 = @mysql_query("SELECT ID,podrazdel FROM $catable WHERE ID='$podrazdel'");
while($myrow=mysql_fetch_array($resultadd2)) {
$podrazdel1=$myrow["podrazdel"];
}
$resultadd1 = @mysql_query("SELECT ID,razdel,podrazdel FROM $catable WHERE podrazdel = '' and ID='$razdel'");
while($myrow=mysql_fetch_array($resultadd1)) {
$razdel1=$myrow["razdel"];
}
if ($status=='ok') {$statusline='<font color=green>Доступна</font>';}
if ($status=='wait') {$statusline='<font color=red>На проверке</font>';}
if ($status=='archive') {$statusline="<font color=blue>В архиве (с $archivedate)</font>";}
echo ("
<tr bgcolor=$maincolor>
<td valign=top width=20><input type=checkbox name=delmes[] value=$tID></td>
<td valign=top><a href=lvac.php?link=$tID target=_blank><b>$profecy</b></a><br>$razdel1&nbsp;/&nbsp;$podrazdel1<br>
");
$br=0;
if ($gender == 'Мужской') {$br=1; echo "Мужчина&nbsp;";}
if ($gender == 'Женский') {$br=1; echo "Женщина&nbsp;";}
if ($agemin != 0 and $agemax == 0) {$br=1; echo "от $agemin лет;&nbsp";}
if ($agemin == 0 and $agemax != 0) {$br=1; echo "до $agemax лет;&nbsp";}
if ($agemin != 0 and $agemax != 0) {$br=1; echo "от $agemin до $agemax лет;&nbsp";}
if ($edu != '' and $edu != 'Не&nbsp;важно') {$br=1; echo "образование $edu;&nbsp";}
if ($grafic != '' and !eregi("важно",$grafic)) {echo "<br>$grafic";}
if ($br==1) {echo "<br>";}
echo ("
Требования: $treb
</td>
<td valign=top><b>$zp</b> $valute</td>
<td valign=top>$date<br><a href=lvac.php?link=$tID target=_blank><small>Подробнее...</small></a></td>
<td valign=top>$statusline<br>
");
if ($changetext == 'TRUE') {echo "<br><a href=changev.php?texid=$tID>Правка</a>";}
echo ("
$topql$boldql
</td>
</tr>
");
} //4
echo "</table></td></tr></table>";
echo ("
$delline <input type=submit name=long value=\"Обновить отмеченные (убрать из архива)\" class=i3><br><br>
");

if ($paytrue == 'TRUE')
{ // включены платные услуги
echo ("
<input type=submit value='Поднять вакансии' name=top class=i3>&nbsp;<input type=submit value='Выделить вакансии' name=bold class=i3>
");
} // включены платные услуги

echo ("
</form></div><p align=center class=tbl1><a href=autor.php>Вернуться в авторский раздел</a></p><p>
");
} //2
} //3
if ($_SERVER[QUERY_STRING] == "delete") {
$delmes=$_POST['delmes'];
$totob=count($delmes);
if (count($delmes)==0) {
	$error .= "Не выбрано ни одного объявления!<br>";}

// проверка средств на счете
if (isset($_POST['top'])) {
$totpricetop=$totob*$paytopvacancy;
$result = @mysql_query("SELECT ID,pay FROM $autortable WHERE ID=$sid");
while ($myrow=mysql_fetch_array($result)) {
$pay=$myrow["pay"];
}
if ($pay < $totpricetop)	{$error .= "На вашем счете недостаточно средств для поднятия выбранных вакансий!<br>У вас - $pay $valute. Требуется для поднятия $totob вакансий - $totpricetop $valute.<br>";}
}
// проверка средств на счете

// проверка средств на счете
if (isset($_POST['bold'])) {
$totpricebold=$totob*$payboldvacancy;
$result = @mysql_query("SELECT ID,pay FROM $autortable WHERE ID=$sid");
while ($myrow=mysql_fetch_array($result)) {
$pay=$myrow["pay"];
}
if ($pay < $totpricebold)	{$error .= "На вашем счете недостаточно средств для выделения выбранных вакансий!<br>У вас - $pay $valute. Требуется для выделения $totob вакансий - $totpricebold $valute.<br>";}
}
// проверка средств на счете

if ($error != ""){
echo "<center><h3>Ошибка</h3><font color=red>$error</font><p><a href=autor.php>Вернуться назад</a><p><br><br><br><br><br><br><br><br>";
}
if ($error == ""){
if (isset($_POST['delob']))
{ // del
for ($i=0;$i<count($delmes);$i++){
$result=@mysql_query("delete from $vactable where ID=$delmes[$i]");
}
echo "<p align=center class=tbl1><h3>Выбранные вакансии удалены!</h3><a href=autor.php>Вернуться в авторский раздел</a></p><br><br>";
} // del
if (isset($_POST['long']))
{ // long
for ($i=0;$i<count($delmes);$i++){
$result=@mysql_query("update $vactable set date=now(),archivedate='0000-00-00 00:00:00',status='wait' where ID=$delmes[$i] and status='archive'");
$result=@mysql_query("update $vactable set date=now() where ID=$delmes[$i] and status != 'archive'");
}
echo "<p align=center class=tbl1><h3>Выбранные вакансии продлены!</h3><a href=autor.php>Вернуться в авторский раздел</a></p><br><br>";
} // long

if (isset($_POST['top'])) 
{ //top
$result=@mysql_query("update $autortable set pay=pay-$totpricetop where ID=$sid");
for ($i=0;$i<count($delmes);$i++){
$result=@mysql_query("update $vactable SET top=now() WHERE ID=$delmes[$i]");
}
echo "<br><br><h3 align=center>Выбранные вакансии подняты!</h3><br><br><a href=autor.php>Вернуться в личный раздел</a><br><br>";
} // top

if (isset($_POST['bold'])) 
{ //bold
$result=@mysql_query("update $autortable set pay=pay-$totpricebold where ID=$sid");
for ($i=0;$i<count($delmes);$i++){
$result=@mysql_query("update $vactable SET bold=now() WHERE ID=$delmes[$i]");
}
echo "<br><br><h3 align=center>Выбранные вакансии выделены!</h3><br><br><a href=autor.php>Вернуться в личный раздел</a><br><br>";
} // bold

}
}
echo ("
<center><form method=post action=\"logout.php\">
<input type=submit name=logout value=Выход class=i3><br><br>
</form>
");
}//1
include("down.php");
?>