<?
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
echo "<head>";
include("var.php");
echo"<title>Добавление банера : $sitename</title>";
include("top.php");
?>
<h3><center><strong>Добавление банера</strong></center></h3>
<?php
$sid=$_SESSION['sid'];
$id=$_SESSION['sid'];
$slogin=$_SESSION['slogin'];
$spass=$_SESSION['spass'];

$maxtitle = 100;
$maxlink = 200;
$maxrek1=100;
$maxrekwidth=100;
$maxrekheight=100;
$maxtopwidth=728;
$maxtopheight=90;
$maxmenuwidth=240;
$maxmenuheight=400;
$maxrightwidth=240;
$maxrightheight=180;
$maxvacwidth=468;
$maxvacheight=60;
$maxnewwidth=468;
$maxnewheight=80;
$maxdownwidth=180;
$maxdownheight=230;
$err1 = "<p class=error>Название должно быть не длинее <b>$maxtitle</b> символов</p>";
$err2 = "<p class=error>Не заполнено обязательное поле - <b>Название</b></p>";
$err3 = "<p class=error>Не заполнено обязательное поле - <b>Местонахождение</b></p>";
$err4 = "<p class=error>Не заполнено обязательное поле - <b>Период размещения</b></p>";
$err6 = "<p class=error>Не заполнено обязательное поле - <b>Ссылка</b></p>";
$err7 = "<p class=error>Ссылка должна быть не длинее <b>$maxlink</b> символов</p>";
$err8 = "<p class=error>Адрес странички должен начинаться с <b>http://</b></p>";
$err10 = "<p class=error>Ссылка на картинку должна начинаться с <b>http://</b></p>";
$err9 = "<p class=error>Не заполнено обязательное поле - <b>Показывать на страницах</b></p>";
$err22 = "<p class=error>Фотография должна иметь расширение <b>*.jpg</b> либо <b>*.gif</b></p>";
$err23 = "<p class=error>Фотография должна иметь размер не более <b>$MAX_FILE_SIZE</b> байт!</p>";
$error = "";
if ($_FILES['file1']['name'] == 'none') {$file1 = '';}
if ($_FILES['file1']['name'] != '') {$file1 = $_FILES['file1']['name'];}
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
$result = @mysql_query("SELECT * FROM $autortable WHERE (email = '$slogin' and pass = '$spass')");
while ($myrow=mysql_fetch_array($result)) {
$afid=$myrow["ID"];
$afcountry=$myrow["country"];
$afregion=$myrow["region"];
$afcity=$myrow["city"];
$payf=$myrow["pay"];
$category=$myrow["category"];
$foto2=$myrow["foto2"];
}
if ((!isset($slogin) or !isset($spass)) or @mysql_num_rows($result) == 0)
{
echo "<p class=error><b>Вы не авторизированы!</b> <a href=autor.php>Авторизация</a></p>";
}
else
{//1
if ($promotrue != 'TRUE')
{
echo "<p class=error><b>Запрещено добавлять рекламу!</b> <a href=autor.php>Вернуться</a></p>";
}
if ($promotrue == 'TRUE')
{ //11

if ($_SERVER[QUERY_STRING] != "add") {
if (!isset($_GET['country']) or $_GET['country']=='0') {$country=$afcountry;}
if (!isset($_GET['region']) or $_GET['region']=='0') {$region=$afregion;}
if (!isset($_GET['city']) or $_GET['city']=='0') {$city=$afcity;}
}

if ($_SERVER[QUERY_STRING] == "add") {
$title=$_POST['title'];
$link=$_POST['link'];
$piclink=$_POST['piclink'];
$wheres=$_POST['wheres'];
$place=$_POST['place'];
$period=$_POST['period'];

if (strlen($title) > $maxtitle) {$error .= "$err1";}
if ($wheres != 'comp' and $title == "") {$error .= "$err2";}
if ($wheres == "") {$error .= "$err3";}
if ($wheres != 'comp' and $place == "") {$error .= "$err9";}
if ($period == "") {$error .= "$err4";}
if (strlen($link) > $maxlink) {$error .= "$err7";}
if ($wheres != 'comp' and $link == "") {$error .= "$err6";}
if ($wheres != 'comp' and !ereg("http://",$link)) {$error .= "$err8";}
if ($piclink != '' and !ereg("http://",$piclink)) {$error .= "$err10";}
if ($wheres == 'comp' and $foto2 == "") {$error .= "Вы не можете добавить рекламу в ведущие компании пока не разместите логотип фирмы";}

if ($file1 != "" and $wheres != 'comp') {
$file1 = $_FILES['file1']['name'];
$filesize1 = $_FILES['file1']['size'];
$temp1 = $_FILES['file1']['tmp_name'];
$fileres1=strtolower(basename($file1));
if ($file1 != "" and !eregi("\.jpg$",$fileres1) and !eregi("\.gif$",$fileres1)){$error .= "$err22";}
if ($filesize1 > $MAX_FILE_SIZE){$error .= "$err23";}
}

if ($wheres == 'top')
{
if ($file1 != "") {
$size = GetImageSize($temp1);
if ($size[0] > $maxtopwidth or $size[1] > $maxtopheight) {$error .= "<p class=error>Размер картинки не должен превышать <b>$maxtopwidth x $maxtopheight</b> пикселей</p>";}
}
}
if ($wheres == 'menu')
{
if ($file1 != "") {
$size = GetImageSize($temp1);
if ($size[0] > $maxmenuwidth or $size[1] > $maxmenuheight) {$error .= "<p class=error>Размер картинки не должен превышать <b>$maxmenuwidth x $maxmenuheight</b> пикселей</p>";}
}
}
if ($wheres == 'down')
{
if ($file1 != "") {
$size = GetImageSize($temp1);
if ($size[0] > $maxdownwidth or $size[1] > $maxdownheight) {$error .= "<p class=error>Размер картинки не должен превышать <b>$maxdownwidth x $maxdownheight</b> пикселей</p>";}
}
}
if ($wheres == 'right')
{
if ($file1 != "") {
$size = GetImageSize($temp1);
if ($size[0] > $maxrightwidth or $size[1] > $maxrightheight) {$error .= "<p class=error>Размер картинки не должен превышать <b>$maxrightwidth x $maxrightheight</b> пикселей</p>";}
}
}
if ($wheres == 'afterhot')
{
if ($file1 != "") {
$size = GetImageSize($temp1);
if ($size[0] > $maxnewwidth or $size[1] > $maxnewheight) {$error .= "<p class=error>Размер картинки не должен превышать <b>$maxnewwidth x $maxnewheight</b> пикселей</p>";}
}
}
if ($wheres == 'beforenew')
{
if ($file1 != "") {
$size = GetImageSize($temp1);
if ($size[0] > $maxvacwidth or $size[1] > $maxvacheight) {$error .= "<p class=error>Размер картинки не должен превышать <b>$maxvacwidth x $maxvacheight</b> пикселей</p>";}
}
}
if ($wheres == 'comp')
{
if (strlen($title) > $maxrek1) {$error .= "<p class=error>Текстовый блок должен быть не длинее <b>$maxrek1</b> символов</p>";}
if ($file1 != "") {
$size = GetImageSize($temp1);
if ($size[0] > $maxrekwidth or $size[1] > $maxrekheight) {$error .= "<p class=error>Размер картинки не должен превышать <b>$maxrekwidth x $maxrekheight</b> пикселей</p>";}
}
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
if ($city == 'all') {$totprice=$totprice*10; $allcity='1';}
if ($city != 'all') {$allcity='0';}

$totpricetop=$totprice*$period;
$result = @mysql_query("SELECT ID,pay FROM $autortable WHERE ID=$sid");
while ($myrow=mysql_fetch_array($result)) {
$pay=$myrow["pay"];
}
if ($pay < $totpricetop)	{$error .= "<p class=error>На вашем счете недостаточно средств для размещения рекламы! У вас - <b>$pay $valute</b>. Требуется для рекламы на $period дней - <b>$totpricetop $valute</b>.</p>";}
// проверка средств на счете

// город
if ($city == "") {
$resultadd1 = @mysql_query("SELECT ID,razdel,podrazdel FROM $citytable WHERE podrazdel = '' and ID='$country'");
while($myrow=mysql_fetch_array($resultadd1)) {
$countrys1=$myrow["razdel"];
}
$resultadd2 = @mysql_query("SELECT ID,podrazdel FROM $citytable WHERE ID='$region'");
while($myrow=mysql_fetch_array($resultadd2)) {
$regions1=$myrow["podrazdel"];
}
if ($region != "")
{
$result3c = @mysql_query("SELECT * FROM $citytable WHERE razdel='$countrys1' and podrazdel='$regions1' and categ != '' LIMIT 1");
if (@mysql_num_rows($result3c) != 0) {
$error .= "<p class=error>Не заполнено обязательное поле - <b>Город</b></p>";
}
}
if ($region == "")
{
$result3c = @mysql_query("SELECT * FROM $citytable WHERE razdel='$countrys1' and categ != '' LIMIT 1");
if (@mysql_num_rows($result3c) != 0) {
$error .= "<p class=error>Не заполнено обязательное поле - <b>Город</b></p>";
}
}
}
// город

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
$title = untag($title);
if ($_SERVER[QUERY_STRING] == "add" and $error == "") {
$date = date("Y/m/d");
if ($file1 != "" and $wheres != 'comp') {
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
if ($file1 != "") {$source_name1 = $promo_dir."p".$fid."_1.$fileres1";}
if($error == ""){
$dest1 = $path1.$source_name1;
if ($file1 != "") {@copy("$temp1","$dest1");$foto1="$source_name1";}
}
}
if ($file1 == '' and $piclink != '') {$source_name1="$piclink";}
if ($wheres == 'comp') 
{
$source_name1="$photodir$foto2";
if ($category == 'rab') {$link = "$siteadress/rab.php?id=$sid";}
if ($category == 'agency') {$link = "$siteadress/agency.php?id=$sid";}
}
$sql="insert into $promotable (title,link,wheres,place,period,date,foto,status,aid,country,region,city,allcity,price) values ('$title','$link','$wheres','$place','$period',now(),'$source_name1','wait','$afid','$country','$region','$city','$allcity','$totpricetop')";
$result=@mysql_query($sql,$db);
$result=@mysql_query("update $autortable set pay=pay-$totpricetop where ID=$sid");
}
}
if ($_SERVER[QUERY_STRING] != "add" or $error != "") {
$name=@str_replace(" ","&nbsp;",$name);

if ($wheres == '')
{
if ($_GET['wheres'] == '') {$wheres=$_POST['wheres'];}
elseif ($_GET['wheres'] != '') {$wheres=$_GET['wheres'];}
}
if ($place == '')
{
if ($_GET['place'] == '') {$place=$_POST['place'];}
elseif ($_GET['place'] != '') {$place=$_GET['place'];}
}
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

if (isset($city) and $city != '' and $city != 'all')
{
$resultadd3 = @mysql_query("SELECT ID,categ FROM $citytable WHERE ID='$city'");
while($myrow=mysql_fetch_array($resultadd3)) {
$citys=$myrow["categ"];
}
}
if ($city == 'all')
{
$citys='Все города';
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

if ($paytrue == 'TRUE')
{ // включены платные услуги
echo ("
На вашем счете: <b>
");
printf("%.2f",$payf);
echo " руб.</b>";
} // включены платные услуги


echo ("<br><br><div align=left>
Cтоимость рекламы вверху страницы (баннер 728x90) <b>$promopricetop руб/день</b><br>
Cтоимость рекламы в блоке \"Ведущие компании\" <b>$promopricecomp руб/день</b><br>
Стоимость рекламы в левой колонке страницы под меню <b>$promopricemenu руб/день</b><br>
Стоимость рекламы в правой колонке страницы <b>$promopriceright руб/день</b><br>
Стоимость рекламы низ страницы <b>$promopricedown руб/день</b><br>
Стоимость рекламы перед вакансиями-резюме дня <b>$promopricebeforenew руб/день</b><br>
Стоимость рекламы перед блоком новостей <b>$promopriceafterhot руб/день</b></div><br><br>
<br>
");

if ($wheres == 'top') {$totprc=$promopricetop; $limcity=$promotoplimit; $wheressh='Верх страницы'; $ogr2="<br>Размер картинки не должен превышать $maxtopwidth x $maxtopheight пикселей";}
if ($wheres == 'comp') {$totprc=$promopricecomp; $limcity=$promocomplimit; $wheressh='Ведущие компании';$ogr1="<br>Количество символов текста не должно превышать $maxrek1"; $ogr2="<br>Размер картинки не должен превышать $maxrekwidth x $maxrekheight пикселей";}
if ($wheres == 'menu') {$totprc=$promopricemenu; $limcity=$promomenulimit; $wheressh='Под меню'; $ogr2="<br>Размер картинки не должен превышать $maxmenuwidth x $maxmenuheight пикселей";}
if ($wheres == 'right') {$totprc=$promopriceright; $limcity=$promorightlimit; $wheressh='Справа страницы'; $ogr2="<br>Размер картинки не должен превышать $maxrightwidth x $maxrightheight пикселей";}
if ($wheres == 'down') {$totprc=$promopricedown; $limcity=$promodownlimit; $wheressh='Низ страницы'; $ogr2="<br>Размер картинки не должен превышать $maxdownwidth x $maxdownheight пикселей";}
if ($wheres == 'beforenew') {$totprc=$promopricebeforenew; $limcity=$promobeforenewlimit; $wheressh='Перед вакансиями-резюме дня'; $ogr2="<br>Размер картинки не должен превышать $maxvacwidth x $maxvacheight пикселей";}
if ($wheres == 'afterhot') {$totprc=$promopriceafterhot; $limcity=$promoafterhotlimit; $wheressh='Перед блоком новостей'; $ogr2="<br>Размер картинки не должен превышать $maxnewwidth x $maxnewheight пикселей";}

if ($place=='all') {$placesh='Все страницы'; $totprc=$totprc*3;}
if ($place=='index') {$placesh='Только главная';}
if ($place=='vac') {$placesh='Только вакансии';}
if ($place=='res') {$placesh='Только резюме';}
if ($place=='other') {$placesh='Остальные, кроме главной, вакансий, резюме';}

if ($city == 'all') {$totprc=$totprc*10;}

if ($totprc != '') {echo "Выбранная стоимость размещения в зависимости от места - <b>$totprc $valute/день</b>";}

if ($category == 'reklam' and $city == 'all' and $wheres != '') {
$cityzan='';
$result4 = @mysql_query("SELECT * FROM $citytable WHERE categ != '' order by categ");
while($myrow=mysql_fetch_array($result4)) {
$city4ID=$myrow["ID"];
$city4=$myrow["categ"];
$result = mysql_query("select * from $promotable where status='ok' and wheres = '$wheres' and (city = '$city4ID' or (allcity = '1' and city = '0'))");
if (mysql_num_rows($result) >= $limcity) {$cityzan .= " $city4";}
}
if ($cityzan != '') {echo "<br><br><b>Занято место для следующих городов: $cityzan</b>";}
}

echo ("
<form name=form method=post ENCTYPE=\"multipart/form-data\" action=promoadd.php?add>
<input type=hidden name=id value=$id>
<input type=hidden name=afid value=$afid>
<form name=form method=post ENCTYPE=multipart/form-data action=adminpra.php?add>
<table width=90% bgcolor=$maincolor class=tbl1>
<tr><td valign=top align=right><strong><font color=#FF0000>*</font>Страна:</strong></td>
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
<tr><td valign=top align=right><strong><font color=#FF0000>*</font>Регион:</strong></td>
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
<tr><td valign=top align=right><strong><font color=#FF0000>*</font>Город:</strong></td>
<td valign=top align=left><select name=city size=1 onChange=location.href=location.pathname+\"?country=$country&region=$region&city=\"+value+\"\";>
<option selected value=\"$city\">$citys</option>
");
if ($category == 'reklam') {echo "<option value=\"all\">Все города (x10)</option>";}
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
<tr><td valign=top align=right><strong><font color=#FF0000>*</font>Город:</strong></td>
<td valign=top align=left><select name=city size=1 onChange=location.href=location.pathname+\"?country=$country&region=$region&city=\"+value+\"\";>
<option selected value=\"$city\">$citys</option>
");
if ($category == 'reklam') {echo "<option value=\"all\">Все города (x10)</option>";}
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
<tr><td align=right valign=top>Месторасположение:<br></td>
<td align=left><select name=wheres size=1 onChange=location.href=location.pathname+\"?country=$country&region=$region&city=$city&wheres=\"+value+\"\";>
<option selected value=\"$wheres\">$wheressh</option>
");

if ($city != '' and $city != 'all')
{ // city
$qwerypromo1="and (city = '$city' or (allcity = '1' and city = '0'))";
} // city
if ($city == "" or $city == 'all') {$qwerypromo1="and city = ''";}

$result = mysql_query("select * from $promotable where status='ok' and wheres = 'top' $qwerypromo1");
if ((@mysql_num_rows($result) < $promotoplimit)) {echo "<option value=top>Верх страницы ($promopricetop $valute/день)</option>";}

if ($category == 'rab' or $category == 'agency')
{
$result = mysql_query("select * from $promotable where status='ok' and wheres = 'comp' $qwerypromo1");
if ((@mysql_num_rows($result) < $promocomplimit) or $city == 'all') {echo "<option value=comp>Ведущие компании ($promopricecomp $valute/день)</option>";}
}

$result = mysql_query("select * from $promotable where status='ok' and wheres = 'menu' $qwerypromo1");
if ((@mysql_num_rows($result) < $promomenulimit) or $city == 'all') {echo "<option value=menu>Под меню ($promopricemenu $valute/день)</option>";}

$result = mysql_query("select * from $promotable where status='ok' and wheres = 'right' $qwerypromo1");
if ((@mysql_num_rows($result) < $promorightlimit) or $city == 'all') {echo "<option value=right>Справа страницы ($promopriceright $valute/день)</option>";}

$result = mysql_query("select * from $promotable where status='ok' and wheres = 'down' $qwerypromo1");
if ((@mysql_num_rows($result) < $promodownlimit) or $city == 'all') {echo "<option value=down>Низ страницы ($promopricedown $valute/день)</option>";}

$result = mysql_query("select * from $promotable where status='ok' and wheres = 'beforenew' $qwerypromo1");
if ((@mysql_num_rows($result) < $promobeforenewlimit) or $city == 'all') {echo "<option value=beforenew>Перед вакансиями-резюме дня ($promopricebeforenew $valute/день)</option>";}

$result = mysql_query("select * from $promotable where status='ok' and wheres = 'afterhot' $qwerypromo1");
if ((@mysql_num_rows($result) < $promoafterhotlimit) or $city == 'all') {echo "<option value=afterhot>Перед блоком новостей ($promopriceafterhot $valute/день)</option>";}

echo ("
</select></td></tr>
");
if ($wheres != 'comp')
{ // не ведущие
if ($wheres != 'beforenew' and $wheres != 'afterhot')
{
echo ("
<tr><td align=right valign=top>Показывать на страницах:<br></td>
<td align=left><select name=place size=1 onChange=location.href=location.pathname+\"?country=$country&region=$region&city=$city&wheres=$wheres&place=\"+value+\"\";>
<option selected value=\"$place\">$placesh</option>
<option value=all>Все страницы (x3)</option>
<option value=index>Только главная (x2)</option>
<option value=vac>Только вакансии</option>
<option value=res>Только резюме</option>
<option value=other>Остальные, кроме главной, вакансий, резюме</option>
</select></td></tr>
");
}
if ($wheres == 'beforenew' or $wheres == 'afterhot')
{
echo ("
<input type=hidden name=place value='other'>
");
}
echo ("
<tr><td align=right>Название (подпись к картинке) либо текстовый блок:</td>
<td><input type=text name=title size=30 value=\"$title\">$ogr1</td></tr>
<tr><td align=right>Ссылка:</td>
<td><input type=text name=link size=30 value=\"$link\"></td></tr>
<tr><td align=right>Картинка:</td><td>
<input type=file name=file1 size=30>$ogr2<br><small>Если картинка не загружена, то блок будет текстовым</small></td></tr>
");
} // не ведущие

if ($wheres == 'comp')
{ // ведущие
if ($foto2 == '')
{
echo ("
<tr><td colspan=2>Вы не можете размещать рекламу в ведущих компаниях пока не добавите логотип</td></tr>
");
}
} // ведущие

echo ("
<tr><td align=right>Период размещения:</td>
<td><input type=text name=period size=30 value=\"$period\">&nbsp;дней</td></tr>
</table>
");
echo "<center><p><input type=submit value=\"Добавить\" name=\"submit\" class=i3></form>";
echo "<p align=center><a href=autor.php>Вернуться в личный раздел</a></p>";
}
else {
echo "<br><br><h3 align=center>Рекламный блок добавлен!</h3><center><br><br>После проверки информации администратором банер будет добавлен или удален.<br><br><p align=center><a href=autor.php>Вернуться в личный раздел</a></a></p><br><br>";

$txt="На сайте $siteadress - новая реклама.";
if ($mailaddrek == 'TRUE')
{mail($adminemail,"Новая реклама",$txt,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/plain; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");}

}
} //11
} //1
include("down.php");
?>