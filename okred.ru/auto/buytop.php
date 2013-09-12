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
echo"<title>Поднятие выделение в каталоге : $sitename</title>";
include("top.php");
?>
<h3><center><strong>Поднятие выделение в каталоге</strong></center></h3>
<?php
$sid=$_SESSION['sid'];
$id=$_SESSION['sid'];
$slogin=$_SESSION['slogin'];
$spass=$_SESSION['spass'];

$updres=mysql_query("update $autortable set top='0000-00-00 00:00:00' where ((top + INTERVAL 86400*$periodfortop SECOND) < now())");
$updres=mysql_query("update $autortable set bold='0000-00-00 00:00:00' where ((bold + INTERVAL 86400*$periodforbold SECOND) < now())");

$result = @mysql_query("SELECT email,pass FROM $autortable WHERE (email = '$slogin' and pass = '$spass')");
if ((!isset($slogin) or !isset($spass)) or @mysql_num_rows($result) == 0)
{
echo "<center><br><br><h3>Вы не авторизированы!</h3><b><a href=autor.php>Авторизация</a></b>";
}
else
{ //1
if ($_SERVER[QUERY_STRING] != "delete")
{ //3
$result = @mysql_query("SELECT *,DATE_FORMAT((top + INTERVAL 86400*$periodfortop SECOND),'%d.%m.%Y') as topq,DATE_FORMAT((bold + INTERVAL 86400*$periodforbold SECOND),'%d.%m.%Y') as boldq FROM $autortable WHERE ID = '$id' and catalog='on' order by ID DESC");
$totaltexts=@mysql_num_rows($result);
if ($totaltexts == 0) {
echo "<p align=center class=tbl1>Вы не участвуете в каталоге!<br><br><a href=buycat.php>Принять участие</a></p>";
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
 $valute</b></big><br><br>
");
} // включены платные услуги

while ($myrow=mysql_fetch_array($result)) 
{ //4
$tID=$myrow["ID"];
$top=$myrow["top"];

if ($paytrue == 'TRUE')
{ // включены платные услуги
$bold=$myrow["bold"];
$topq=$myrow["topq"];
$topql="<br><font color=green>Стоимость поднятия в каталоге $paytopcatalog $valute.</font>";
if ($top != '0000-00-00 00:00:00') {$topql="<br><b>вверху до $topq</b>";}
$boldq=$myrow["boldq"];
$boldql="<br><font color=blue>Стоимость выделения вакансии $payboldcatalog $valute.</font>";
if ($bold != '0000-00-00 00:00:00') {$boldql="<br><b>выделено до $boldq</b>";}
} // включены платные услуги

echo ("
$topql$boldql<br>
");
} //4

if ($paytrue == 'TRUE')
{ // включены платные услуги
echo ("
<input type=submit value='Поднять вверх' name=top class=i3>&nbsp;<input type=submit value='Выделить' name=bold class=i3>
");
} // включены платные услуги

echo ("
</form></div><p align=center class=tbl1><a href=autor.php>Вернуться в авторский раздел</a></p><p>
");
} //2
} //3
if ($_SERVER[QUERY_STRING] == "delete") {

// проверка средств на счете
if (isset($_POST['top'])) {
$totpricetop=$paytopcatalog;
$result = @mysql_query("SELECT ID,pay FROM $autortable WHERE ID=$sid");
while ($myrow=mysql_fetch_array($result)) {
$pay=$myrow["pay"];
}
if ($pay < $totpricetop)	{$error .= "На вашем счете недостаточно средств для поднятия вверх!<br>У вас - $pay $valute. Требуется для поднятия - $totpricetop $valute.<br>";}
}
// проверка средств на счете

// проверка средств на счете
if (isset($_POST['bold'])) {
$totpricebold=$payboldcatalog;
$result = @mysql_query("SELECT ID,pay FROM $autortable WHERE ID=$sid");
while ($myrow=mysql_fetch_array($result)) {
$pay=$myrow["pay"];
}
if ($pay < $totpricebold)	{$error .= "На вашем счете недостаточно средств для выделения!<br>У вас - $pay $valute. Требуется для выделения - $totpricebold $valute.<br>";}
}
// проверка средств на счете

if ($error != ""){
echo "<center><h3>Ошибка</h3><font color=red>$error</font><p><a href=autor.php>Вернуться назад</a><p><br><br><br><br><br><br><br><br>";
}
if ($error == ""){

if (isset($_POST['top'])) 
{ //top
$result=@mysql_query("update $autortable set pay=pay-$totpricetop,top=now() where ID=$sid");
echo "<br><br><h3 align=center>Ваша анкета поднята!</h3><br><br><a href=autor.php>Вернуться в личный раздел</a><br><br>";
} // top

if (isset($_POST['bold'])) 
{ //bold
$result=@mysql_query("update $autortable set pay=pay-$totpricebold,bold=now() where ID=$sid");
echo "<br><br><h3 align=center>Ваша анкета выделена!</h3><br><br><a href=autor.php>Вернуться в личный раздел</a><br><br>";
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