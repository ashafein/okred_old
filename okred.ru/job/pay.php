<?
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!--/***************** DO NOT REMOVE! *********************/---->
<!--/*   Author: Nevezhyn Evgeny  Date : 10/01/2003       */---->
<!--/*   nevius@bk.ru      All Rights Reserved ...        */---->
<!--/*   http://nevius.ru/                                */---->
<!--/***************** DO NOT MODIFY! *********************/---->

<?php
echo "<head>";
include("var.php");
echo "<title>Пополнение счета : $sitename</title>";
include("top.php");
$sid=$_SESSION['sid'];
$slogin=$_SESSION['slogin'];
$spass=$_SESSION['spass'];
$result = @mysql_query("SELECT email,pass FROM $autortable WHERE email = '$slogin' and pass = '$spass'");
if ((!isset($slogin) or !isset($spass)) or @mysql_num_rows($result) == 0)
{
echo "<left><br><br><h3>Вы не авторизированы</h3><b><a href=autor.php>Авторизация</a></b>";
}
else
{//1
?>

<h3 align=left><? echo "Пополнение счета";?></h3>

<form id=pay name=pay method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp">

<p align=left>
<b><? echo "Заплатить";?></b>:&nbsp;<input type=text name="LMI_PAYMENT_AMOUNT" size=15 > WMZ<br>
Укажите нужную сумму<br><br>
</p>

	<input type="hidden" name="LMI_PAYMENT_DESC" value="payprior">
	<input type="hidden" name="userID" value="<? echo "$sid";?>">
        <input type="hidden" name="LMI_RESULT_URL" value="<? echo "$siteadress";?>/payconf.php">
	<input type="hidden" name="LMI_PAYMENT_NO" value="1">
	<input type="hidden" name="LMI_PAYEE_PURSE" value="<? echo "$wmzpurse";?>">
	<input type="hidden" name="LMI_SIM_MODE" value="0">
<p align=left>	
	<input type="submit" class=dob value="<? echo "Пополнить";?>">
</p>
</form>

<?
echo "<left><br><br><a href=autor.php>Вернуться в личный раздел</a>";
}//1

include("down.php");
?>