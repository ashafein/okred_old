<?
session_start();
?>
<!--/***************** DO NOT REMOVE! *********************/---->
<!--/*   Author: Nevezhyn Evgeny  Date : 11/06/2005       */---->
<!--/*   nevius@bk.ru      All Rights Reserved ...        */---->
<!--/*   http://nevius.ru/                                */---->
<!--/***************** DO NOT MODIFY! *********************/---->

<?php
echo "<head>";
include("var.php");
echo"<title>Добавление менеджера : $sitename</title>";
include("top.php");
// удаление неподтвержденных регистраций
$delold=mysql_query("delete from $autortable where status='wait' and ((date + INTERVAL 86400*$delnotconfirm SECOND) < now())");
// удаление неподтвержденных регистраций
?>
<h3 align=center><strong>Добавление менеджера</strong></center></h3>
<form name="form" method="post" ENCTYPE="multipart/form-data" action="adminma.php?add">
<?php
$uu=$_SESSION['uid'];
$result = @mysql_query("SELECT * FROM $admintable where pass = '$uu'");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
$userconfirm=$myrow["userconfirm"];
$moderadd=$myrow["moderadd"];
$catalogadd=$myrow["catalogadd"];
$mess=$myrow["mess"];
$textadd=$myrow["textadd"];
$textdel=$myrow["textdel"];
$textcomment=$myrow["textcomment"];
$faq=$myrow["faq"];
$news=$myrow["news"];
$promoadd=$myrow["promoadd"];
$promodel=$myrow["promodel"];
$promoconfirm=$myrow["promoconfirm"];
$main=$myrow["main"];
}
if ((!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass) and ($main != 'main' or $moderadd != 'checked'))
{
echo "<center><b>Вы не <a href=admin.php>авторизированы</a>!</b><br><br>";
}
else
{ // ok
if ($ident == 'session') {$REMOTE_ADDR=$PHPSESSID;}
if ($ident != 'session') {$REMOTE_ADDR=$_SERVER['REMOTE_ADDR'];}
$delip=mysql_query("delete from $bunsiptable where (((date + INTERVAL 86400*period SECOND) < now()) and period != '')");
$delwaiter=mysql_query("delete from $autortable where (((date + INTERVAL 86400*10 SECOND) < now()) and status = 'wait')");
$maxname = 50;
$maxemail = 100;
$maxpass = 20;
$maxfirm = 100;
$maxfio = 100;
$maxtelephone = 100;
$err2 = "E-mail должен быть не длинее $maxemail символов<br>";
$err3 = "Пароль должен быть не длинее $maxpass символов<br>";
$err5 = "Поле Контактное лицо должно быть не длинее $maxfio символов<br>";
$err9 = "Телефон должен быть не длинее $maxtelephone символов<br>";

$err12 = "Не заполнено обязательное поле - E-mail!<br>";
$err13 = "Не заполнено обязательное поле - Пароль!<br>";
$err14 = "Не заполнено обязательное поле - Подтверждение пароля<br>";
$err16 = "Не заполнено обязательное поле - Название агентства!<br>";
$err17 = "Не заполнено обязательное поле - Телефон!<br>";

$err203 = "Не заполнено обязательное поле - Контактное лицо!<br>";

$err18 = "Пожалуйста введите пароль заново. Текст полей Пароль и Подтверждение пароля должен быть одинаков<br>";
$err19 = "Пожалуйста проверьте правильность E-mail адреса<br>";
$err20 = "Участник с таким email-адресом уже зарегистрирован, выберите другой!<br>";
$err21 = "Поле Направления деятельности должно быть не длинее $maxdeyat символов<br>";
$err22 = "Извините, но Вам нельзя регистрироваться на этом сайте! <br>";
$err23 = "Пароль не должен содержать пробелов! <br>";
$err24 = "Не верный цифровой код!<br>";
$error = "";
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
if ($_SERVER[QUERY_STRING] == "add") {

$number=$_POST['number'];
$category=$_POST['category'];
$email=$_POST['email'];
$country=$_POST['country'];
$region=$_POST['region'];
$city=$_POST['city'];
$telephone=$_POST['telephone'];
$mobtel=$_POST['mobtel'];
$rabtel=$_POST['rabtel'];
$fax=$_POST['fax'];
$comandirovka=$_POST['comandirovka'];
$adress=$_POST['adress'];
$url=$_POST['url'];
$fio=$_POST['fio'];
$firm=$_POST['firm'];
$gender=$_POST['gender'];
$byear=$_POST['byear'];
$bmonth=$_POST['bmonth'];
$bday=$_POST['bday'];
$family=$_POST['family'];
$civil=$_POST['civil'];
$prof=$_POST['prof'];
$dopsved=$_POST['dopsved'];
$deyat=$_POST['deyat'];
$foto1=$_POST['foto1'];
$foto2=$_POST['foto2'];
$pass=$_POST['pass'];
$passr=$_POST['passr'];
$hidemail=$_POST['hidemail'];
$inn=$_POST['inn'];
$userID=$_POST['userID'];

if (strlen($email) > $maxemail) {$error .= "$err2";}
if (strlen($pass) > $maxpass) {$error .= "$err3";}
if (strlen($passr) > $maxpass) {$error .= "$err3";}
if (strlen($fio) > $maxfio) {$error .= "$err5";}
if (strlen($telephone) > $maxtelephone) {$error .= "$err9";}
if ($email == "") {$error .= "$err12";}
if ($pass == "") {$error .= "$err13";}
if ($passr == "") {$error .= "$err14";}

if ($fio == "") {$error .= "$err203";}
if ($userID == "") {$error .= "Главный работодатель не выбран!<br>";}

if ($pass != $passr) {$error .= "$err18";}
$result = @mysql_query("SELECT email FROM $autortable WHERE email = '$email'");
if (@mysql_num_rows($result) != 0) {$error .= "$err20";}
unset($result);
$result = @mysql_query("SELECT bunsip FROM $bunsiptable WHERE bunsip = '$REMOTE_ADDR'");
if (@mysql_num_rows($result) != 0) {$error .= "$err22";}
unset($result);
if (!strpos($email,"@")) {$error .= "$err19";}
if (strpos($pass," ")) {$error .= "$err23";}
if (strpos($passr," ")) {$error .= "$err23";}

echo "<center><font color=red>$error</font></center>";
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
$string = ereg_replace("&nbsp;"," ",$string);
return $string;
}

$tel=$_POST['tel'];
if ($rabtel == $tel) {$rabtel = '';}
if ($fax == $tel) {$fax = '';}

$email = untag($email);
$pass = untag($pass);
$firm = untag($firm);
$adress = untag($adress);
$telephone = untag($telephone);
$url = untag($url);
$fio = untag($fio);
$civil = untag($civil);
$prof = untag($prof);
$dopsved = untag($dopsved);
$deyat = untag($deyat);
if ($_SERVER[QUERY_STRING] == "add" and $error == "") {
$date = date("Y/m/d H:i:s");
$sql="insert into $autortable (category,email,country,region,city,telephone,adress,url,fio,firm,birth,gender,family,civil,prof,dopsved,deyat,date,foto1,foto2,pass,ip,status,hidemail,mobtel,rabtel,fax,comandirovka,inn,moder,statconf) values ('moder','$email','$country','$region','$city','$telephone','$adress','$url','$fio','$firm','$birth','$gender','$family','$civil','$prof','$dopsved','$deyat',now(),'$source_name1','$source_name2','$pass','$REMOTE_ADDR','user','$hidemail','$mobtel','$rabtel','$fax','$comandirovka','$inn','$userID','ok',)";
$result=@mysql_query($sql,$db);
}
}
if ($_SERVER[QUERY_STRING] != "add" or $error != "") {
echo ("
<p align=center>Обязательные поля отмечены символом <font color=#FF0000>*</font></p>
");

$resultadd1 = @mysql_query("SELECT ID,firm FROM $autortable WHERE ID='$userID' LIMIT 1");
while($myrow=mysql_fetch_array($resultadd1)) {
$userIDsh=$myrow["firm"];
}
echo ("
<input type=hidden name=tel value=\"$tel\">
<table width=740>
<tr><td align=right><font color=#FF0000>*</font>Главный работодатель:</td>
<td><select name=userID>
<option selected value=$userID>$userIDsh</option>
");

$resultadd1 = @mysql_query("SELECT ID,firm,category FROM $autortable WHERE category='rab' order by firm");
while($myrow=mysql_fetch_array($resultadd1)) {
$rID=$myrow["ID"];
$rfirm=$myrow["firm"];
echo "<option value=$rID>$rfirm</option>";
}
echo ("
</select>
</td></tr>
<tr><td align=right><font color=#FF0000>*</font>Контактное лицо:</td>
<td><input type=text name=fio size=30 value=\"$fio\"></td></tr>
<tr><td align=right>Должность:</td>
<td><input type=text name=prof size=30 value=\"$prof\"></td></tr>
");
if ($telephone == '') {$telephone = $tel;}
if ($mobtel == '') {$mobtel = $tel;}
if ($rabtel == '') {$rabtel = $tel;}
if ($fax == '') {$fax = $tel;}
echo ("
<tr><td align=right>Рабочий телефон:</td>
<td><input type=text name=rabtel size=30 value=\"$rabtel\"></td></tr>
<tr><td align=right>Факс:</td>
<td><input type=text name=fax size=30 value=\"$fax\"></td></tr>
<tr><td align=right valign=top><font color=#FF0000>*</font>E-mail адрес:<br></td>
<td><input type=text name=email size=30 value=\"$email\"><br><input type=checkbox name=hidemail value=checked $hidemail>Скрыть E-mail</td></tr>
<tr><td align=right><font color=#FF0000>*</font>Пароль:</td>
<td><input type=password name=pass size=30></td></tr>
<tr><td align=right><font color=#FF0000>*</font>Подтверждение пароля:</td>
<td><input type=password name=passr size=30></td></tr>
");
echo "</table><center><p><input type=submit value=\"Регистрация\" name=\"submit\" class=i3></form>";
}
else {
unset($result);
echo "<br><br><h3 align=center>Менеджер добавлен!</h3><br><br>$reglineafter<br><br>";
}
}//1
echo "<center><a href=admin.php>На общую страницу администрирования</a><br><br>";
include("down.php");
?>