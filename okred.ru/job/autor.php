<?
session_start();
$_SESSION["spass"] = "";
$_SESSION["slogin"] = "";
$_SESSION["sid"] = "";
include("var.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?
if ($_POST['remme'] == 'checked')
{
$alogin=$_POST['alogin'];
$apass=$_POST['apass'];
$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);
// удаление неподтвержденных регистраций
$delold=mysql_query("delete from $autortable where status='wait' and ((date + INTERVAL 86400*$delnotconfirm SECOND) < now())");
// удаление неподтвержденных регистраций
if ($_SERVER[QUERY_STRING] == "autor") {
$resultaut1 = @mysql_query("SELECT ID,email,fio,pass,status,category FROM $autortable WHERE (email = '$alogin' and pass = '$apass' and status = 'user')");
if (@mysql_num_rows($resultaut1) != 0) {
if (!isset($_SESSION['spass'])) {setcookie("spass",$apass,time()+864000);}
if (!isset($_SESSION['slogin'])) {setcookie("slogin",$alogin,time()+864000);}
$resultaut = @mysql_query("SELECT ID,email,fio,pass,status,category FROM $autortable WHERE (email = '$alogin' and pass = '$apass' and status = 'user')");
while ($myrow=mysql_fetch_array($resultaut)) {
$aid=$myrow["ID"];
if ($_POST['remme'] == 'checked') {setcookie("sid",$aid,time()+864000);}
}
}
}
}

echo "<head><title>Личный кабинет : $sitename</title>";
include("top.php");
// удаление неподтвержденных регистраций
$delold=mysql_query("delete from $autortable where status='wait' and ((date + INTERVAL 86400*$delnotconfirm SECOND) < now())");
// удаление неподтвержденных регистраций
echo "<div align=left class=tbl1><h3>Личный кабинет</h3>";
$delip=mysql_query("delete from $bunsiptable where (((date + INTERVAL 86400*period SECOND) < now()) and period != '')");
$err1 = "Не заполнено обязательное поле - Email!<br>";
$err2 = "Не заполнено обязательное поле - Пароль!<br>";
$err3 = "Неправильный пароль или email! Проверьте правильность ввода пароля и email (с учетом регистра)<br>";
$err6 = "Вы не авторизированы!<br>";
$err4 = ("
<blockquote><p align=left>
<b>Ошибка авторизации: </b><font color=red>Регистрация не подтверждена!</font><br><br>
После того, как вы зарегистрировались, на ваш email адрес было выслано письмо с подтверждением регистрации. Воспользуйтесь ссылкой в этом письме, чтобы подтвердить регистрацию.<br><br>
<form name=repeat method=post action=\"sendconf.php\">
<input class=for type=submit value=\"Выслать повторно\" name=\"submit\" class=i3>
</form>
</p>
");
$error = "";
$active=1;
if ($_SERVER[QUERY_STRING] == "autor") {
$alogin=$_POST['alogin'];
$apass=$_POST['apass'];
if ($alogin == "") {$error .= "$err1";}
if ($apass == "") {$error .= "$err2";}
$result = @mysql_query("SELECT ID,email,pass,category FROM $autortable WHERE ((email = '$alogin' and pass = '$apass') or (ID = '$id' and pass = '$apass'))");
if (@mysql_num_rows($result) == 0) {$error .= "$err3";}
unset($result);
$result = @mysql_query("SELECT ID,email,pass,status FROM $autortable WHERE (status = 'wait' and ((email = '$alogin' and pass = '$apass') or (ID = '$id' and pass = '$apass')))");
if (@mysql_num_rows($result) != 0) {$active=0; $error .= "$err4";}
unset($result);
echo "<left><font color=red>$error</font></left>";
}
if (($_SERVER[QUERY_STRING] != "autor" and (!isset($_SESSION['spass']) or $_SESSION['spass'] == '') and (!isset($_SESSION['slogin']) or $_SESSION['slogin'] == '')) or $error != "") {
if ($active==1)
{ //active
echo ("

<form method=post action=\"autor.php?autor\">
<table>
<tr><td align=left><strong>E-mail:</strong></td>
<td><input class=for type=text name=\"alogin\" size=30><td></tr>
<tr><td align=left valign=top><strong>Пароль:</strong></td>
<td><input class=for type=password name=\"apass\" size=30>&nbsp;&nbsp;<small><a href=recpass.php>Напомнить пароль</a></small></td></tr>
</table>
<left><p><input class=for type=submit value=Войти name=\"submit\" class=i3>
<br><br><a href=registr.php>Регистрация</a><br><br>
</form>
");
} //active
}
if (($_SERVER[QUERY_STRING] == "autor" and $error == "") or (isset($_SESSION['spass']) and $_SESSION['spass'] != '' and isset($_SESSION['slogin']) and $_SESSION['slogin'] != '' and $error == "")) {
if (!isset($_SESSION['spass'])) {$_SESSION['spass']=$apass;}
if (!isset($_SESSION['slogin'])) {$_SESSION['slogin']=$alogin;}
$slogin=$_SESSION['slogin'];
$spass=$_SESSION['spass'];

$result = @mysql_query("SELECT ID,category,email,pass,status,pay FROM $autortable WHERE (email = '$slogin' and pass = '$spass')");
while ($myrow=mysql_fetch_array($result)) {
$category=$myrow["category"];
$addobyavl=$myrow["addobyavl"];
$pay=$myrow["pay"];
$catalog=$myrow["catalog"];
if ($catalog == 'off') {$catline="<font color=red>Не участвует</font>";}
if ($catalog == 'on') {$catline="<font color=green>Участвует</font>";}
}
$result = @mysql_query("SELECT ID,category,email,pass,status,pay FROM $autortable WHERE (email = '$alogin' and pass = '$apass')");
$totalprofiles=@mysql_num_rows($result);
while ($myrow=mysql_fetch_array($result)) {
$_SESSION['sid']=$myrow["ID"];
$pay=$myrow["pay"];
$category=$myrow["category"];
$addobyavl=$myrow["addobyavl"];
}
$sid=$_SESSION['sid'];
if ($category=='soisk') {$categ='Соискатель';}
if ($category=='rab') {$categ='Работодатель';}
if ($category=='agency') {$categ='Агентство';}
if ($category=='user') {$categ='Пользователь';}
if ($category=='freelanc') {$categ='Фрилансер';}

if ($paytrue == 'TRUE')
{ // включены платные услуги
echo ("
<left>
Ваш ID: <b>$sid</b><br><big>На вашем счете: <b>
");
printf("%.2f",$pay);
echo ("
 $valute</b></big><br><br>
<table cellpadding=4 cellspacing=4 width=100% class=tbl1>
<tr bgcolor=$altcolor><td colspan=2><h3>Пополнение счета</h3></td></tr>
");

if ($wmzpurse != 'Zxxxxxxxxxxxx')
{
echo ("
<tr><td valign=top><b>WebMoney</b><br><img src=picture/paywm.gif border=0></td>
<td valign=top><form name=pay method=POST action=\"pay.php\" >

<input class=for type=submit value=\"Пополнить счет\" class=dob >
</form>
</td></tr>
<tr bgcolor=$altcolor><td colspan=2></td></tr>
");
}

if ($qiwipay != '')
{ // QIWI

echo ("
<tr><td valign=top><b>QIWI</b><br><a href=\"http://qiwi.ru\" target=\"_blank\"><img alt=\"Платежная система QIWI\" src=\"picture/qiwi.jpg\" border=0></a></td>
<td valign=top><a href=qiwi_pay.php target=_blank>Пополнить балланс</a></td></tr>
<tr bgcolor=$altcolor><td colspan=2></td></tr>
");
} // QIWI

if ($interkassa != '')
{ // interkassa
srand((double)microtime()*1000000);
$code=md5(uniqid(rand()));
$code=@substr($code,1,12);
$result=@mysql_query("UPDATE `{$autortable}` SET code='{$code}' WHERE ID={$sid}",$db);
echo ("
<tr><td valign=top><b>Interkassa</b><br><a href=\"http://www.interkassa.com/\" target=\"_blank\"><img style=\"border: 0;margin: 0;padding: 0;\" alt=\"Платежная система Interkassa\" src=\"https://interkassa.com/img/ik/interkassa_logo.gif\"></a></td>
<td valign=top>
");
?>

<form name="payment" action="http://www.interkassa.com/lib/payment.php" method="post" target="_top">
<input class=for type="hidden" name="ik_shop_id" value="<? echo "$interkassa";?>">
<input class=for type="text" name="ik_payment_amount"> USD
<input class=for type="hidden" name="ik_payment_id" value="<? echo "$code";?>">
<input class=for type="hidden" name="ik_payment_desc" value="Пополнение счета">
<input class=for type="hidden" name="ik_success_url" value="<? echo "$siteadress/ik_success.php";?>">
<input class=for type="hidden" name="ik_success_method" value="POST">
<input class=for type="hidden" name="ik_fail_url" value="<? echo "$siteadress/ik_fail.php";?>">
<input class=for type="hidden" name="ik_fail_method" value="POST">
<input class=for type="hidden" name="ik_status_url" value="<? echo "$siteadress/ik_confirm.php";?>">
<input class=for type="hidden" name="ik_status_method" value="POST">
<input class=for type="hidden" name="ik_paysystem_alias" value="">
<input class=for type="hidden" name="ik_baggage_fields" value="<? echo "$sid";?>">
<input class=for type="submit" name="process" value="Оплатить" class=dob>
</form>
</td></tr>
<tr bgcolor=<? echo "$altcolor";?>><td colspan=2></td></tr>

<?
} // interkassa

if ($sprypay != '')
{ // sprypay
srand((double)microtime()*1000000);
$code=md5(uniqid(rand()));
$code=@substr($code,1,12);
echo ("
<tr><td valign=top><b>SpryPay</b><br><a href=\"http://sprypay.ru\" target=\"_blank\"><img style=\"border: 0;margin: 0;padding: 0;\" alt=\"Платежная система SpryPay\" src=\"http://www.sprypay.ru/templates/users/images/sprypay.button.png\"></a></td>
<td valign=top>
");
?>

<FORM accept-charset=windows-1251 method=post action=http://sprypay.ru/sppi/ target=_blank tooltip=" ( откроется в новом окне )">
<input class=for value="<? echo "$sprypay";?>" type=hidden name=spShopId>
<input class=for value="<? echo "$code";?>" type=hidden name=spShopPaymentId>
<input class=for value="usd" type=hidden name=spCurrency>
<input class=for value="Пополнение счета" type=hidden name=spPurpose>
<input class=for value="100" type=text name=spAmount size=20> USD
<input class=for value="<? echo "$sid";?>" type=hidden name=spUserDataUserId>
<input class=for value="" type=hidden name=spSelectedPS>
<input class=for value="" type=hidden name=spForbidden>
<input class=for value="" type=hidden name=spIpnUrl>
<input class=for value=1 type=hidden name=spIpnMethod>
<input class=for value="<? echo "$siteadress/spry_success.php";?>" type=hidden name=spSuccessUrl>
<input class=for value=1 type=hidden name=spSuccessMethod>
<input class=for value="<? echo "$siteadress/spry_fail.php";?>" type=hidden name=spFailUrl>
<input class=for value=1 type=hidden name=spFailMethod>
<input class=for value=оплатить type=submit class=dob>
</FORM></td></tr>
<tr bgcolor=<? echo "$altcolor";?>><td colspan=2></td></tr>

<?
} // sprypay

if ($intellectmoney != '')
{ // intellect money
echo ("
<tr><td valign=top><b>Intellect Money</b><br><a href=\"http://www.intellectmoney.ru/\" target=\"_blank\"><img style=\"border: 0;margin: 0;padding: 0;\" alt=\"Платежная система IntellectMoney\" src=\"https://intellectmoney.ru/common/img/uploaded/banners/003cb5/88x31_2.gif\"></a></td>
<td valign=top>
");
$eshopId = $intellectmoney;	
srand((double)microtime()*1000000);
$code=md5(uniqid(rand()));
$code=@substr($code,1,12);
$orderId = $code; //от заказа к заказу значения orderId должны различаться
// назначение платежа (не более 255 символов)
$serviceName = "Зачисление на счет #" . $sid;
// сумма платежа (разделение суммы возможно как точкой '.' так и запяной ',')
// $recipientAmount = "1.99";
// валюта платежа (RUR или TST)
$recipientCurrency = "RUR";
/////////////////////////////////////////////////////////
// НЕ ОБЯЗАТЛЬНЫЕ параметры
// Ссылка на страницу на вашем сайте, куда перейдет пользователь после успешной оплаты (ВАЖНО: не факт что проплата прошла)
$successUrl = "$siteadress/im_success.php";
// Ссылка на страницу на вашем сайте, куда перейдет пользователь если откажется от платежа
$failUrl = "$siteadress//im_fail.php";
// Если вам известно имя плательщика, можно его передать
$userName = $sid;
// Если вам извесен E-mail пользователя его можно передать
$userEmail = '';
// Дополнительные переменные, которые нужно вернуть после возврата на сайт магазина
$userField_1 = $sid;
$userField_2 = 'поле2';
$userField_3 = 'поле3';
// форма для перехода на страницу оплаты товара
print "<form method='post' action='https://merchant.intellectmoney.ru/ru/' >".
	"<input class=for id='orderId' type='hidden' value='$orderId' name='orderId'/>".
	"<input class=for id='eshopId' type='hidden' value='$eshopId' name='eshopId'/>".
	"<input class=for id='serviceName' type='hidden' value='$serviceName' name='serviceName'/>".
	"<input class=for type='hidden' value='$recipientCurrency' name='recipientCurrency'/>".
	"<input class=for type='hidden' value='$successUrl' name='successUrl'/>".
	"<input class=for type='hidden' value='$failUrl' name='failUrl'/>".
	"<input class=for id='userName' type='hidden' value='$userName' name='userName'/>".
	"<input class=for id='userEmail' type='hidden' value='$userEmail' name='userEmail'/>".
	"<input class=for id='userField_1' type='hidden' value='$userField_1' name='userField_1'/>".
	"<input class=for id='userField_2' type='hidden' value='$userField_2' name='userField_2'/>".
	"<input class=for id='userField_3' type='hidden' value='$userField_3' name='userField_3'/>".
	"<input class=for id='recipientAmount' type='text' size='20' value='1000' name='recipientAmount'/> руб.".
	"<input class=for type=submit value='Оплатить' class=dob/><br/>".
	"</form>";
echo ("
</td></tr>
<tr bgcolor=$altcolor><td colspan=2></td></tr>
");
} //intellect money

if ($pokazunid != '')
{
echo ("
<tr><td valign=top><b>SMS</b></td>
<td valign=top>
Для оплаты счета с помощью СМС отправьте короткое сообщение следующего содержания:<br>
<font color=green><b>prefix $sid</b></font> на короткий номер <b>0000</b><br>
Стоимость сообщения <font color=red><b>4 $valute</b></font>
</td></tr>
<tr bgcolor=$altcolor><td colspan=2></td></tr>
");
}
echo ("
</table><br>
");

} // включены платные услуги

echo ("
<left>
Вы зарегистрированы как <b>$categ</b><br><br>
<a href=regchan.php>Изменить регистрационные данные</a><br><br>
");
if ($category == 'soisk' or $category == 'agency' or $category == 'user') {
echo "<a href=orderv.php>Просмотр отобранных вакансий</a><br><br>";
echo "<a href=subsv.php>Подписка на новые вакансии</a><br><br>";
}
if ($category == 'rab' or $category == 'agency' or $category == 'user') {
echo "<a href=orderr.php>Просмотр отобранных резюме</a><br><br>";
echo "<a href=subsr.php>Подписка на новые резюме</a><br><br>";
}

if ($category != 'user' and $category != 'freelanc')
{ //no user
echo ("
В настоящее время на сайте добавлено:<br><br>
");
if ($category == 'rab' or $category == 'agency')
{
echo "Участие в каталоге организаций: $catline<br>";
if ($paytrue == 'TRUE')
{ // включены платные услуги
echo "<a href=buycat.php>Включить/исключить из каталога организаций</a><br>";
if ($catalog == 'on') {echo "<a href=buytop.php>Поднятие/выделение в каталоге организаций</a><br>";}
} // включены платные услуги
echo "<br>";

$result = @mysql_query("SELECT aid,status FROM $vactable WHERE aid = '$sid' and status='ok'");
$totaltexts1=@mysql_num_rows($result);
$result = @mysql_query("SELECT aid,status FROM $vactable WHERE aid = '$sid' and status='wait'");
$totalwait1=@mysql_num_rows($result);
$totaltextsb = $totaltexts1 + $totalwait1;
echo ("
Вакансий: <b>$totaltexts1</b><br>
Ожидают очереди на добавление: <b>$totalwait1</b><br><br>
");
}
if ($category == 'soisk' or $category == 'agency')
{
$result = @mysql_query("SELECT aid,status FROM $restable WHERE aid = '$sid' and status='ok'");
$totaltexts2=@mysql_num_rows($result);
$result = @mysql_query("SELECT aid,status FROM $restable WHERE aid = '$sid' and status='wait'");
$totalwait2=@mysql_num_rows($result);
$totaltextss = $totaltexts2 + $totalwait2;
echo ("
Резюме: <b>$totaltexts2</b><br>
Ожидают очереди на добавление: <b>$totalwait2</b><br><br>
");
}
} // no user
$resultban = @mysql_query("SELECT * FROM $bunsiptable WHERE bunsip = '$REMOTE_ADDR'");
if (@mysql_num_rows($resultban) != 0) {
while($myrow=mysql_fetch_array($resultban)) {
$ID=$myrow["ID"];
$bunsip=$myrow["bunsip"];
$bunwhy=$myrow["why"];
}
echo "<p align=left><font color=red>Доступ к функциям авторского раздела для вас, к сожалению, закрыт!</font></p><blockquote><p align=justify><b>Причина:</b> $bunwhy</p><br><br>";
}
elseif (@mysql_num_rows($resultban) == 0) {
if ($category != 'user')
{ // no user
if ($category == 'rab' or $category == 'agency')
{
echo ("
<a href=mylistv.php>Просмотр вакансий</a> ($totaltextsb)<br><br>
");
if ($addobyavl != 'no') {echo "<a href=addvac.php>Добавить вакансию</a><br><br>";}
if ($addobyavl == 'no') { echo "<font color=red>Запрещено добавлять вакансии</font><br><br>";}

}
if ($category == 'soisk' or $category == 'agency')
{
echo ("
<a href=mylistr.php>Просмотр резюме</a> ($totaltextss)<br><br>
");
if ($addobyavl != 'no') { echo "<a href=addres.php>Добавить резюме</a><br><br>";}
if ($addobyavl == 'no') { echo "<font color=red>Запрещено добавлять резюме</font><br><br>";}
}
} // no user


// реклама
if ($promotrue == 'TRUE')
{
if ($category == 'rab' or $category == 'agency' or $category == 'user' or $category == 'reklam')
{
echo "<a href=promoadd.php>Добавить рекламный блок (баннер)</a><br />Вы, как <b>$categ</b> можете рекламироваться на нашем сайте на выделенных для рекламы местах.<br><br>";
echo "<a href=promodel.php>Удалить/продлить рекламный блок</a><br>";
// реклама
$resultrek = @mysql_query("SELECT *,(date + INTERVAL 86400*period SECOND) as expir,DATE_FORMAT(date,'%d.%m.%Y') as date FROM $promotable where aid=$sid and status='ok' order by wheres,ID DESC");
while($myrow=mysql_fetch_array($resultrek)) {
$wheres=$myrow["wheres"];
$place=$myrow["place"];
$date=$myrow["date"];
$expir=$myrow["expir"];
if ($place=='all') {$place='Все страницы';}
if ($place=='index') {$place='Только главная';}
if ($place=='vac') {$place='Только вакансии';}
if ($place=='res') {$place='Только резюме';}
if ($place=='other') {$place='Остальные, кроме главной, вакансий, резюме';}
if ($wheres=='top') {$where='Верх страницы';}
if ($wheres=='comp') {$where='Ведущие компании';}
if ($wheres=='menu') {$where='Левая колонка';}
if ($wheres=='left') {$where='Правая колонка';}
if ($wheres=='down') {$where='Низ страницы';}
if ($wheres=='beforenew') {$where='Перед вакансиями-резюме дня';}
if ($wheres=='afterhot') {$where='Перед блоком новостей';}
if ($wheres=='rassilka') {$where='В рассылке';}
echo "<br />Оплачено $where - $place до $expir";
}

$resultrek = @mysql_query("SELECT *,(date + INTERVAL 86400*period SECOND) as expir,DATE_FORMAT(date,'%d.%m.%Y') as date FROM $promotable where aid=$sid and status='wait' order by wheres,ID DESC");
if (@mysql_num_rows($resultrek) != 0) {
while($myrow=mysql_fetch_array($resultrek)) {
$wheres=$myrow["wheres"];
$place=$myrow["place"];
$date=$myrow["date"];
$expir=$myrow["expir"];
if ($place=='all') {$place='Все страницы';}
if ($place=='index') {$place='Только главная';}
if ($place=='vac') {$place='Только вакансии';}
if ($place=='res') {$place='Только резюме';}
if ($place=='other') {$place='Остальные, кроме главной, вакансий, резюме';}
if ($wheres=='top') {$where='Верх страницы';}
if ($wheres=='comp') {$where='Ведущие компании';}
if ($wheres=='menu') {$where='Левая колонка';}
if ($wheres=='left') {$where='Правая колонка';}
if ($wheres=='down') {$where='Низ страницы';}
if ($wheres=='beforenew') {$where='Перед вакансиями-резюме дня';}
if ($wheres=='afterhot') {$where='Перед блоком новостей';}
if ($wheres=='rassilka') {$where='В рассылке';}
echo "<br />Оплачено $where - $place - <font color=red>На модерации</font><br><br>";
}
}
}
}
// реклама

}

// сообщения
if ($sendmessages == 'TRUE')
{
$result123 = @mysql_query("SELECT aid,tid,showed FROM $messagetable WHERE tid = '$sid' and showed=0");
$totmesnewtop=@mysql_num_rows($result123);
if ($totmesnewtop > 0) {echo "<a href=message.php><b>Сообщения&nbsp;($totmesnewtop)</b></a><br><br>";}
if ($totmesnewtop == 0) {echo "<a href=message.php>Сообщения</a><br><br>";}
}
// сообщения

echo ("
<left><form method=post action=\"logout.php\">
<input class=for type=submit name=logout value=Выход class=i3><br><br>
</form>
");
}
echo "</div>";
include("down.php");
?>