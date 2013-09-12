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
echo"<title>Добавленные резюме : $sitename</title>";
include("top.php");
?>
<h3><center><strong>Добавленные резюме</strong></center></h3>
<?php
$sid=$_SESSION['sid'];
$id=$_SESSION['sid'];
$slogin=$_SESSION['slogin'];
$spass=$_SESSION['spass'];

$updres=mysql_query("update $restable set top='0000-00-00 00:00:00' where ((top + INTERVAL 86400*$periodfortop SECOND) < now())");
$updres=mysql_query("update $restable set bold='0000-00-00 00:00:00' where ((bold + INTERVAL 86400*$periodforbold SECOND) < now())");

$result = @mysql_query("SELECT email,pass FROM $autortable WHERE (email = '$slogin' and pass = '$spass')");
if ((!isset($slogin) or !isset($spass)) or @mysql_num_rows($result) == 0)
{
echo "<center><br><br><h3>Вы не авторизированы!</h3><b><a href=autor.php>Авторизация</a></b>";
}
else
{ //1
if ($_SERVER[QUERY_STRING] != "delete")
{ //3
$result = @mysql_query("SELECT *,CURRENT_DATE,(YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) AS age,DATE_FORMAT(date,'%d.%m.%Y') as date,DATE_FORMAT((top + INTERVAL 86400*$periodfortop SECOND),'%d.%m.%Y') as topq,DATE_FORMAT((bold + INTERVAL 86400*$periodforbold SECOND),'%d.%m.%Y') as boldq FROM $restable WHERE aid = '$id' order by ID DESC");
$totaltexts=@mysql_num_rows($result);
if ($totaltexts == 0) {
echo "<p align=center class=tbl1>Вы не разместили ни одного объявления!<br><br><a href=addres.php>Разместить резюме</a></p>";
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
echo "<p align=center class=tbl1>Всего ваших резюме: <b>$totaltexts</b></p>";
echo ("
<div align=center><form name=deltext method=post action=mylistr.php?delete>
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$maincolor><td><img src=\"picture/basket.gif\" border=0></td><td>Должность</td><td>Зарплата</td><td>Дата публ.</td><td>Опции</td></tr>
");
while ($myrow=mysql_fetch_array($result)) 
{ //4
$tID=$myrow["ID"];
$profecy=$myrow["profecy"];
$zp=$myrow["zp"];
$grafic=$myrow["grafic"];
$zanatost=$myrow["zanatost"];
$aid=$myrow["aid"];

if ($paytrue == 'TRUE')
{ // включены платные услуги
$top=$myrow["top"];
$bold=$myrow["bold"];
$topq=$myrow["topq"];
$topql="<br><font color=green>Стоимость поднятия резюме $paytopresume $valute.</font>";
if ($top != '0000-00-00 00:00:00') {$topql="<br><b>вверху до $topq</b>";}
$boldq=$myrow["boldq"];
$boldql="<br><font color=blue>Стоимость выделения резюме $payboldresume $valute.</font>";
if ($bold != '0000-00-00 00:00:00') {$boldql="<br><b>выделено до $boldq</b>";}
} // включены платные услуги

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
$date=$myrow["date"];
$razdel=$myrow["razdel"];
$podrazdel=$myrow["podrazdel"];
$status=$myrow["status"];
$archivedate=$myrow["archivedate"];
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
<td valign=top><a href=lres.php?link=$tID target=_blank><b>$profecy</b></a><br>$razdel1&nbsp;/&nbsp;$podrazdel1<br>
");
$br=0;
if ($gender == 'Мужской') {$br=1; echo "Мужчина&nbsp;";}
if ($gender == 'Женский') {$br=1; echo "Женщина&nbsp;";}
if ($age != 0) {$br=1; echo "$age лет(года);&nbsp";}
if ($grafic != '' and !eregi("важно",$grafic)) {if ($br==1) {echo "<br>";} $br=1; echo "$grafic";}
if ($prof != '') {if ($br==1) {echo "<br>";} echo "Проф.навыки: $prof";}
echo ("
</td>
<td valign=top>
");
if ($zp != 0) {echo "<b>$zp</b> $valute";}
elseif ($zp == 0) {echo "";}
echo ("
</td>
<td valign=top>$date<br><a href=lres.php?link=$tID target=_blank><small>Подробнее...</small></a></td>
<td valign=top>$statusline<br>
<a href=changer.php?texid=$tID>Правка</a>
");
if ($category == 'agency') {echo "<br><a href=chanfoto.php?texid=$tID>Фотографии</a>";}
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
<input type=submit value='Поднять резюме' name=top class=i3>&nbsp;<input type=submit value='Выделить резюме' name=bold class=i3>
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
$totpricetop=$totob*$paytopresume;
$result = @mysql_query("SELECT ID,pay FROM $autortable WHERE ID=$sid");
while ($myrow=mysql_fetch_array($result)) {
$pay=$myrow["pay"];
}
if ($pay < $totpricetop)	{$error .= "На вашем счете недостаточно средств для поднятия выбранных резюме!<br>У вас - $pay $valute. Требуется для поднятия $totob резюме - $totpricetop $valute.<br>";}
}
// проверка средств на счете

// проверка средств на счете
if (isset($_POST['bold'])) {
$totpricebold=$totob*$payboldresume;
$result = @mysql_query("SELECT ID,pay FROM $autortable WHERE ID=$sid");
while ($myrow=mysql_fetch_array($result)) {
$pay=$myrow["pay"];
}
if ($pay < $totpricebold)	{$error .= "На вашем счете недостаточно средств для выделения выбранных резюме!<br>У вас - $pay $valute. Требуется для выделения $totob резюме - $totpricebold $valute.<br>";}
}
// проверка средств на счете

if ($error != ""){
echo "<center><h3>Ошибка</h3><font color=red>$error</font><p><a href=autor.php>Вернуться назад</a><p><br><br><br><br><br><br><br><br>";
}
if ($error == ""){
if (isset($_POST['delob']))
{ // del
for ($i=0;$i<count($delmes);$i++){
$res2 = @mysql_query("SELECT * FROM $restable WHERE ID=$delmes[$i]");
while($myrow=mysql_fetch_array($res2)) {
$foto1=$myrow["foto1"];
}
@unlink($upath.$photodir.$foto1);
@unlink($upath.$photodir.'s'.$foto1);
$result=@mysql_query("delete from $restable where ID=$delmes[$i]");
}
echo "<p align=center class=tbl1><h3>Выбранные резюме удалены!</h3><a href=autor.php>Вернуться в авторский раздел</a></p><br><br>";
} // del
if (isset($_POST['long']))
{ // long
for ($i=0;$i<count($delmes);$i++){
$result=@mysql_query("update $restable set date=now(),archivedate='0000-00-00 00:00:00',status='wait' where ID=$delmes[$i] and status='archive'");
$result=@mysql_query("update $restable set date=now() where ID=$delmes[$i] and status != 'archive'");
}
echo "<p align=center class=tbl1><h3>Выбранные резюме продлены!</h3><a href=autor.php>Вернуться в авторский раздел</a></p><br><br>";
} // long

if (isset($_POST['top'])) 
{ //top
$result=@mysql_query("update $autortable set pay=pay-$totpricetop where ID=$sid");
for ($i=0;$i<count($delmes);$i++){
$result=@mysql_query("update $restable SET top=now() WHERE ID=$delmes[$i]");
}
echo "<br><br><h3 align=center>Выбранные резюме подняты!</h3><br><br><a href=autor.php>Вернуться в личный раздел</a><br><br>";
} // top

if (isset($_POST['bold'])) 
{ //bold
$result=@mysql_query("update $autortable set pay=pay-$totpricebold where ID=$sid");
for ($i=0;$i<count($delmes);$i++){
$result=@mysql_query("update $restable SET bold=now() WHERE ID=$delmes[$i]");
}
echo "<br><br><h3 align=center>Выбранные резюме выделены!</h3><br><br><a href=autor.php>Вернуться в личный раздел</a><br><br>";
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