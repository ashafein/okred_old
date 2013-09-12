<?
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
include("var.php");
echo"<title>Добавление рекламы : $sitename</title>";
include("top.php");
echo "<div class=tbl1>";
?>
<h3><center><strong>Добавление рекламы</strong></center></h3>
<?php
if ($_FILES['file1']['name'] == 'none') {$file1 = '';}
if ($_FILES['file1']['name'] != '') {$file1 = $_FILES['file1']['name'];}
$maxtitle = 100;
$maxlink = 200;
$err1 = "<p class=error>Название должно быть не длинее <b>$maxtitle</b> символов</p>";
$err2 = "<p class=error>Не заполнено обязательное поле - <b>Название</b></p>";
$err3 = "<p class=error>Не заполнено обязательное поле - <b>Местонахождение</b></p>";
$err4 = "<p class=error>Не заполнено обязательное поле - <b>Период размещения</b></p>";
$err6 = "<p class=error>Не заполнено обязательное поле - <b>Ссылка</b></p>";
$err7 = "<p class=error>Ссылка должна быть не длинее <b>$maxlink</b> символов</p>";
$err8 = "<p class=error>Адрес странички должен начинаться с <b>http://</b>  </p>";
$err9 = "<p class=error>Не заполнено обязательное поле - <b>Показывать на страницах</b> </p>";
$err22 = "<p class=error>Фотография должна иметь расширение <b>*.jpg</b> либо <b>*.gif</b></p>";
$err23 = "<p class=error>Фотография должна иметь размер не более <b>$MAX_FILE_SIZE</b> байт!</p>";
$error = "";
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
$result = @mysql_query("SELECT pass FROM $admintable");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
if (!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass)
{
echo "<center><b>Вы не <a href=admin.php>авторизированы</a>!</b><br><br>";
}
else
{ // ok
if ($_SERVER[QUERY_STRING] == "add") {

$title=$_POST['title'];
$link=$_POST['link'];
$wheres=$_POST['wheres'];
$place=$_POST['place'];
$period=$_POST['period'];
$country=$_POST['country'];
$region=$_POST['region'];
$city=$_POST['city'];

if (strlen($title) > $maxtitle) {$error .= "$err1";}
if ($title == "") {$error .= "$err2";}
if ($wheres == "") {$error .= "$err3";}
if ($place == "") {$error .= "$err9";}
if ($period == "") {$error .= "$err4";}
if (strlen($link) > $maxlink) {$error .= "$err7";}
if ($link == "") {$error .= "$err6";}
if (!ereg("http://",$link)) {$error .= "$err8";}
if ($file1 != "") {
$file1 = $HTTP_POST_FILES['file1']['name'];
$filesize1 = $HTTP_POST_FILES['file1']['size'];
$temp1 = $HTTP_POST_FILES['file1']['tmp_name'];
$fileres1=strtolower(basename($file1));
if ($file1 != "" and !eregi("\.jpg$",$fileres1) and !eregi("\.gif$",$fileres1)){$error .= "$err22";}
if ($filesize1 > $MAX_FILE_SIZE){$error .= "$err23";}
}
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
$title = untag($title);
if ($_SERVER[QUERY_STRING] == "add" and $error == "") {
if ($file1 != "") {
$result1 = @mysql_query("SELECT * FROM $promotable order by ID DESC LIMIT 1");
while ($myrow=@mysql_fetch_array($result1))
{
$fid=$myrow["ID"];
}
$fid=$fid+1;
$updir=$promo_dir;
$path1 = $upath;
$fileres1=@substr($fileres1,-3,3);
$source_name1="";
if ($file1 != "") {$source_name1 = $updir."p".$fid."_1.$fileres1";}
if($error == ""){
$dest1 = $path1.$source_name1;
if ($file1 != "") {@copy("$temp1","$dest1");$foto1=$updir."$source_name1";}
}
}
$sql="insert into $promotable (title,link,wheres,place,period,date,foto,country,region,city,status) values ('$title','$link','$wheres','$place','$period',now(),'$source_name1','$country','$region','$city','ok')";
$result=@mysql_query($sql,$db);
}
}
if ($_SERVER[QUERY_STRING] != "add" or $error != "") {

if ($city == '')
{
if ($_GET['city'] == '') {$city=$_POST['city'];}
elseif ($_GET['city'] != '') {$city=$_GET['city'];}
}
if ($region == '')
{
if ($_GET['region'] == '') {$region=$_POST['region'];}
elseif ($_GET['region'] != '') {$region=$_GET['region'];}
}
if ($country == '')
{
if ($_GET['country'] == '') {$country=$_POST['country'];}
elseif ($_GET['country'] != '') {$country=$_GET['country'];}
}

if (isset($city) and $city != '')
{
$resultadd3 = @mysql_query("SELECT ID,categ FROM $citytable WHERE ID='$city'");
while($myrow=mysql_fetch_array($resultadd3)) {
$citys=$myrow["categ"];
}
}
if (isset($region) and $region != '')
{
$resultadd2 = @mysql_query("SELECT ID,podrazdel FROM $citytable WHERE ID='$region'");
while($myrow=mysql_fetch_array($resultadd2)) {
$regions=$myrow["podrazdel"];
}
}
$resultadd1 = @mysql_query("SELECT ID,razdel,podrazdel FROM $citytable WHERE podrazdel = '' and ID='$country'");
while($myrow=mysql_fetch_array($resultadd1)) {
$countrys=$myrow["razdel"];
}

echo ("
<p><center><strong>Все поля обязательны</strong></p>
<form name=form method=post ENCTYPE=multipart/form-data action=adminpra.php?add>
<table width=90% bgcolor=$maincolor class=tbl1>
<tr><td valign=top align=right>Страна:</td>
<td valign=top align=left>
<select name=country size=1 onChange=location.href=location.pathname+\"?razdel=$razdel&podrazdel=$podrazdel&country=\"+value+\"\";>
<option selected value=\"$country\">$countrys</option>
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
if ($country != '')
{ // страна
$result1 = @mysql_query("SELECT * FROM $citytable WHERE razdel='$countrys' and podrazdel != '' and categ='' order by podrazdel");
if (@mysql_num_rows($result1) != 0)
{ // есть регион
echo ("
<tr><td valign=top align=right>Регион:</td>
<td valign=top align=left><select name=region size=1 onChange=location.href=location.pathname+\"?razdel=$razdel&podrazdel=$podrazdel&country=$country&region=\"+value+\"\";>
<option selected value=\"$region\">$regions</option>
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
if ($region != '')
{ // регион
$result4 = @mysql_query("SELECT * FROM $citytable WHERE podrazdel = '$regions' and razdel='$countrys' and categ != '' order by categ");
if (@mysql_num_rows($result4) != 0) {
echo ("
<tr><td valign=top align=right>Город:</td>
<td valign=top align=left><select name=city size=1>
<option selected value=\"$city\">$citys</option>
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
<tr><td valign=top align=right>Город:</td>
<td valign=top align=left><select name=city size=1>
<option selected value=\"$city\">$citys</option>
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
<tr><td align=right>Название (подпись к картинке) либо текстовый блок:</td>
<td><input type=text name=title size=30 value=\"$title\"></td></tr>
<tr><td align=right>Ссылка:</td>
<td><input type=text name=link size=30 value=\"$link\"></td></tr>
<tr><td align=right valign=top>Месторасположение:<br></td>
<td align=left><select name=wheres size=1>
<option selected value=\"$wheres\">$wheres</option>
<option value=top>Верх страницы</option>
<option value=comp>Ведущие компании</option>
<option value=menu>Под меню</option>
<option value=right>Справа страницы</option>
<option value=down>Низ страницы</option>
<option value=beforenew>Перед вакансиями-резюме дня</option>
<option value=afterhot>Перед блоком новостей</option>
<option value=rassilka>В рассылке</option>
</select></td></tr>
<tr><td align=right valign=top>Показывать на страницах:<br></td>
<td align=left><select name=place size=1>
<option selected value=\"$place\">$place</option>
<option value=all>Все страницы</option>
<option value=index>Только главная</option>
<option value=vac>Только вакансии</option>
<option value=res>Только резюме</option>
<option value=other>Остальные, кроме главной, вакансий, резюме</option>
</select></td></tr>
<tr><td align=right>Период размещения:</td>
<td><select name=period size=1>
<option selected value=$period>$period</option>
<option value=10>10</option>
<option value=30>30</option>
<option value=60>60</option>
<option value=90>90</option>
</select>&nbsp;дней</td></tr>
<tr><td align=right>Картинка:</td><td>
<input type=file name=file1 size=30><br><small>Если картинка не загружена, то блок будет текстовым</small></td></tr>
</table>
<br><center><input type=submit value=\"Добавить\" name=\"submit\">
</form>
");
}
else {
echo "<br><br><h3 align=center>Реклама добавлена!</h3><br><br><center><a href=adminpra.php>Добавить еще рекламу</a><br><br>";
}
}// ok
echo "<center><a href=admin.php>На общую страницу администрирования</a><br><br>";
echo "</div>";
include("down.php");
?>