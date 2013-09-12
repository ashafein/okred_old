<?
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!--/***************** DO NOT REMOVE! *********************/---->
<!--/*   Author: Nevezhyn Evgeny  Date : 20/05/2004       */---->
<!--/*   nevius@bk.ru      All Rights Reserved ...        */---->
<!--/*   http://nevius.ru/                                */---->
<!--/***************** DO NOT MODIFY! *********************/---->

<?php
echo "<head>";
include("var.php");
echo"<title>Продление банера : $sitename</title>";
include("top.php");
?>
<h3><center><strong>Продление банера</strong></center></h3>
<?php
if (!isset($sid) or $sid == '') {$sid=$_SESSION['sid'];}
if (!isset($slogin) or $slogin == '') {$slogin=$_SESSION['slogin'];}
if (!isset($spass) or $spass == '') {$spass=$_SESSION['spass'];}
$id=$sid;

$error = "";
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
$result = @mysql_query("SELECT * FROM $autortable WHERE (email = '$slogin' and pass = '$spass')");
while ($myrow=mysql_fetch_array($result)) {
$afid=$myrow["ID"];
}
if ((!isset($slogin) or !isset($spass)) or @mysql_num_rows($result) == 0)
{
echo "<p class=error><b>Вы не авторизированы!</b> <a href=autor.php>Авторизация</a></p>";
}
else
{//1
if ($promotrue != 'TRUE')
{
echo "<center><br><br><h3>Запрещено добавлять рекламу!</h3><b><a href=autor.php>Вернуться</a></b>";
}
if ($promotrue == 'TRUE')
{ //11
if ($_SERVER[QUERY_STRING] == "add") {
$link=$_POST['link'];
$periodold=$_POST['periodold'];

if (isset($submit)) {$period = $periodold;}
if (isset($newper30)) {$period = 30;}
if (isset($newper60)) {$period = 60;}
if (isset($newper90)) {$period = 90;}
if (isset($newper150)) {$period = 150;}
if (isset($newper365)) {$period = 365;}

$result = @mysql_query("SELECT * FROM $promotable WHERE ID='$link' and aid = '$sid'");
while ($myrow=mysql_fetch_array($result)) {
$wheres=$myrow["wheres"];
$place=$myrow["place"];
$city=$myrow["city"];
}

// проверка средств на счете
if ($wheres=='top') {$totprice=$promopricetop;}
if ($wheres=='menu') {$totprice=$promopricemenu;}
if ($wheres=='down') {$totprice=$promopricedown;}
if ($wheres=='right') {$totprice=$promopriceright;}
if ($wheres=='comp') {$totprice=$promopricecomp;}
if ($wheres=='afterhot') {$totprice=$promopriceafterhot;}
if ($wheres=='beforenew') {$totprice=$promopricebeforenew;}
if ($place=='all') {$totprice=$totprice*3;}
if ($place=='index') {$totprice=$totprice*2;}
if ($city == '1') {$totprice=$totprice*10;}

$totpricetop=$totprice*$period;

if ($period >= 150 and $period < 365) {$totpricetop=$totpricetop-$totpricetop*10/100;}
if ($period >= 365) {$totpricetop=$totpricetop-$totpricetop*20/100;}

$result = @mysql_query("SELECT ID,pay FROM $autortable WHERE ID=$sid");
while ($myrow=mysql_fetch_array($result)) {
$pay=$myrow["pay"];
}
if ($pay < $totpricetop)	{$error .= "<p class=error>На вашем счете недостаточно средств для размещения рекламы! У вас - <b>$pay $valute</b>. Требуется для рекламы на $period дней - <b>$totpricetop $valute</b>.</p>";}
// проверка средств на счете

echo "$error";
function untag ($string) {
$string = ereg_replace("<","&lt;",$string);
$string = ereg_replace(">","&gt;",$string);
$string = ereg_replace('\\\"',"&quot;",$string);
$string = ereg_replace("!","&#33;",$string);
$string = ereg_replace("\r","",$string);
$string = ereg_replace("%","&#37;",$string);
$string = ereg_replace("^ +","",$string);
$string = ereg_replace(" +$","",$string);
$string = ereg_replace(" +"," ",$string);
$string = ereg_replace("&nbsp;"," ",$string);
return $string;
}
if ($_SERVER[QUERY_STRING] == "add" and $error == "") {
$delvac=mysql_query("update $promotable set period=period+'$period' where ID='$link'");
$result=@mysql_query("update $autortable set pay=pay-$totpricetop where ID=$sid");
echo "<br><br><h3 align=center>Рекламный блок продлен!</h3><center><br><br><p align=center><a href=autor.php>Вернуться в личный раздел</a></a></p><br><br>";
}
}
if ($_SERVER[QUERY_STRING] != "add" or $error != "") {
$link=$_GET['link'];
$result = @mysql_query("SELECT * FROM $promotable WHERE ID='$link'");
while ($myrow=mysql_fetch_array($result)) {
$link=$myrow["ID"];
$period=$myrow["period"];
$wheres=$myrow["wheres"];
$place=$myrow["place"];
$city=$myrow["city"];
}

if ($paytrue == 'TRUE')
{ // включены платные услуги

$result = @mysql_query("SELECT ID,pay FROM $autortable WHERE ID=$sid");
while ($myrow=mysql_fetch_array($result)) {
$pay=$myrow["pay"];
}

echo ("
На вашем счете: <b>
");
printf("%.2f",$pay);
echo " $valute</b>";

echo ("<br><br><div align=left>
Cтоимость рекламы вверху страницы (баннер 728x90) <b>$promopricetop $valute/день</b><br>
Cтоимость рекламы в блоке \"Ведущие компании\" <b>$promopricecomp $valute/день</b><br>
Стоимость рекламы в левой колонке страницы под меню <b>$promopricemenu $valute/день</b><br>
Стоимость рекламы в правой колонке страницы <b>$promopriceright $valute/день</b><br>
Стоимость рекламы низ страницы <b>$promopricedown $valute/день</b><br>
Стоимость рекламы перед вакансиями-резюме дня <b>$promopricebeforenew $valute/день</b><br>
Стоимость рекламы перед блоком новостей <b>$promopriceafterhot $valute/день</b></div><br><br>
");
} // включены платные услуги

if ($wheres == 'top') {$totprc=$promopricetop; $wheressh='Верх страницы';}
if ($wheres == 'comp') {$totprc=$promopricecomp; $wheressh='Ведущие компании';$ogr1="<br>Количество символов текста не должно превышать $maxrek1"; $ogr2="<br>Размер картинки не должен превышать $maxrekwidth x $maxrekheight пикселей";}
if ($wheres == 'menu') {$totprc=$promopricemenu; $wheressh='Под меню';}
if ($wheres == 'right') {$totprc=$promopriceright; $wheressh='Справа страницы';}
if ($wheres == 'down') {$totprc=$promopricedown; $wheressh='Низ страницы';}
if ($wheres == 'beforenew') {$totprc=$promopricebeforenew; $wheressh='Перед вакансиями-резюме дня'; $ogr1="<br>Количество символов текста не должно превышать $maxrek1"; $ogr2="<br>Размер картинки не должен превышать $maxrekwidth x $maxrekheight пикселей";}
if ($wheres == 'afterhot') {$totprc=$promopriceafterhot; $wheressh='Перед блоком новостей'; $ogr1="<br>Количество символов текста не должно превышать $maxrek1"; $ogr2="<br>Размер картинки не должен превышать $maxrekwidth x $maxrekheight пикселей";}

if ($place=='all') {$placesh='Все страницы'; $totprc=$totprc*3;}
if ($place=='index') {$placesh='Только главная';}
if ($place=='vac') {$placesh='Только вакансии';}
if ($place=='res') {$placesh='Только резюме';}
if ($place=='other') {$placesh='Остальные, кроме главной, вакансий, резюме';}

if ($city == '1') {$totprc=$totprc*10;}

$totprcfull=$totprc*$period;
if ($period >= 150 and $period < 365) {$totprcfull=$totprc-$totprc*10/100; $diskont='- скидка 10%';}
if ($period >= 365) {$totprcfull=$totprc-$totprc*20/100; $diskont='- скидка 20%';}

if ($totprcfull != '') {echo "<!-- Стоимость продления на тот же период - <b>$totprcfull $valute</b> $diskont -->";}

$totprc30=$totprc*30;
$totprc60=$totprc*60;
$totprc90=$totprc*90;
$totalprc150=$totprc*150;
$totalprc365=$totprc*365;
$totprc150=($totprc-$totprc*10/100)*150;
$totprc365=($totprc-$totprc*20/100)*365;
$totskidka150=$totprc150*10/100;
$totskidka365=$totprc365*20/100;

echo ("
<form name=form method=post ENCTYPE=\"multipart/form-data\" action=promolong.php?add>
<input type=hidden name=link value=$link>
<input type=hidden name=periodold value=$period>
");
echo ("
<center>
");

//echo "<input type=submit value=\"Продлить на $period дней за $totprcfull $valute\" name=\"submit\" class=i3><br><br>";

echo ("
<input type=submit value=\"Продлить на 30 дней за $totprc30 $valute\" name=\"newper30\"> - Стоимость $totprc30 $valute<br><br>
<input type=submit value=\"Продлить на 60 дней за $totprc60 $valute\" name=\"newper60\"> - Стоимость $totprc60 $valute<br><br>
<input type=submit value=\"Продлить на 90 дней за $totprc90 $valute\" name=\"newper90\"> - Стоимость $totprc90 $valute<br><br>
<input type=submit value=\"Продлить на 150 дней за $totprc150 $valute\" name=\"newper150\"> - Полная стоимость $totalprc150 $valute. Ваша экономя $totskidka150 $valute (10%)<br><br>
<input type=submit value=\"Продлить на 365 дней за $totprc365 $valute\" name=\"newper365\"> - Полная стоимость $totalprc365 $valute. Ваша экономя $totskidka365 $valute (20%)<br><br>

</center></form>");
echo "<p align=center><a href=autor.php>Вернуться в личный раздел</a></p>";
}
} //11
} //1
include("down.php");
?>