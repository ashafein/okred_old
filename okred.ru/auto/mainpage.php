<?
session_start();

$codecount = ('
<textarea rows=4 cols=40>
<a href=сайт.ru>код счетчика</a>
</textarea>
');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
echo "<head>";
include("var.php");
echo"<title>Размещение на главной странице : $sitename</title>";
include("top.php");
?>
<h3><center><strong>Размещение на главной странице</strong></center></h3>

<?php
$delip=mysql_query("delete from $bunsiptable where (((date + INTERVAL 86400*period SECOND) < now()) and period != '')");
$REMOTE_ADDR=$_SERVER['REMOTE_ADDR'];
$id=$_SESSION['sid'];
$slogin=$_SESSION['slogin'];
$spass=$_SESSION['spass'];
$error = "";
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
$result = @mysql_query("SELECT email,pass,category,addobyavl,statconf FROM $autortable WHERE email = '$slogin' and pass = '$spass' and statconf = 'ok'");
if ((!isset($slogin) or !isset($spass)) or @mysql_num_rows($result) == 0)
{
echo "<center><br><br><h3>Вы не авторизированы либо вам запрещено добавлять рекламу!</h3><b><a href=autor.php>Авторизация</a></b>";
}
else
{//1
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
$resultraz = @mysql_query("SELECT email,pass,category FROM $autortable WHERE email = '$slogin' and pass = '$spass' and category = 'agency'");
if (@mysql_num_rows($resultraz) == 0)
{
echo "<center><br><br><h3>Рекламу могут размещать только агентства!</h3><b><a href=registr.php>Регистрация</a></b>";
}
elseif (mysql_num_rows($resultraz) != 0) 
{ // проверка1
if ($_SERVER[QUERY_STRING] == "add") {

$url=$_POST['url'];

$result3 = @mysql_query("SELECT * FROM $mainpagetable WHERE url='$url' aid=$id");
if (@mysql_num_rows($result3) != 0) {$error .= "Такая ссылка вами уже добавлена!<br>";}
if ($url == "") {$error .= "Введите адрес страницы, где будет размещен наш код банера!<br>";}
if ($url != "" and !ereg("http://",$url)) {$error .= "Адрес странички должен начинаться с http://! <br>";}

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
return $string;
}

if ($_SERVER[QUERY_STRING] == "add" and $error == "") {
$sql="insert into $mainpagetable (url,aid,date,status) values ('$url','$id',now(),'wait')";
$result=@mysql_query($sql,$db);

}
}
if ($_SERVER[QUERY_STRING] != "add" or $error != "") {
?>

<p align=center>Уважаемые представители кадровых агентств! Мы предлагаем Вам БЕСПЛАТНОЕ размещение на главной странице сайта Вакансия.RU ссылки на страницу c информацией о Вашем кадровом агентстве с Вашими вакансиями и резюме, размещенными в нашей базе данных. Показ информации о вакансиях Вашего агентства будет осуществляться посетителям региона, котором имеются свободные вакансии Вашего агентства или филиала агентства.  Единственное условие бесплатного размещения ссылки на информацию о Ваших вакансиях и о Вашем кадровом агентстве на главной странице нашего сайта является размещение нашей ссылки или кнопки на одной из страниц сайта Вашего кадрового агентства: на главной или  на странице с партнерскими ссылками</p><br><br>

<?
echo ("
<form name=form method=post action=mainpage.php?add ENCTYPE=multipart/form-data>
<table border=0 width=740>
<tr><td>Код кнопки - ссылки сайта \"Вакансия.RU\" для размещения на сайте вашего агентсва</td></tr>
<tr><td><i>$codecount</i></td></tr>
<tr><td>Укажите URL страницы, где будет размещена кнопка - ссылка на наш сайт:</td></tr>
<tr><td><input type=text name=url size=30 value=\"$url\"></td></tr>
</table>
");
echo "<center><p><input type=submit value=\"Добавить\" name=\"submit\" class=i3></form>";
}
else {
echo "<br><h3 align=center>Ссылка добавлена!</h3><center><br>Разместите следующий код на странице $url вашего сайта:<br><br><i><b>$codecount</b></i><br><br>Когда ссылка на нас будет ращмещена вы будете добавлены на главную страницу нашего сайта<br><br><p align=center><a href=autor.php>Вернуться в авторский раздел</a></p><br><br>";
}
} // проверка1
} //bunip
}//1
include("down.php");
?>