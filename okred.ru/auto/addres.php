<?
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
echo "<head>";
include("var.php");
echo"<title>Добавление резюме : $sitename</title>";
include("top.php");
?>

<SCRIPT>
function Hide(d) {document.getElementById(d).style.display = 'none';}
function Shw(d) {document.getElementById(d).style.display = 'block';}
</SCRIPT>

<?php
$delip=mysql_query("delete from $bunsiptable where (((date + INTERVAL 86400*period SECOND) < now()) and period != '')");
if ($_FILES['file1']['name'] == 'none') {$file1 = '';}
if ($_FILES['file1']['name'] != '') {$file1 = $_FILES['file1']['name'];}
$REMOTE_ADDR=$_SERVER['REMOTE_ADDR'];
$id=$_SESSION['sid'];
$slogin=$_SESSION['slogin'];
$spass=$_SESSION['spass'];
if (isset($_POST['razdel'])) {$razdel = ereg_replace("--",",",$_POST['razdel']);}
if (isset($_GET['razdel'])) {$razdel = ereg_replace("--",",",$_GET['razdel']);}
$maxzp = 8;
$maxprofecy = 50;
$maxfio = 100;
$maxcomment = 1000;
$maxuslov = 1000;
$maxciv = 30;
$maxprof = 500;
$maxdopsved = 1000;
$err1 = "Желаемая должность должна быть не длинее $maxprofecy символов<br>";
$err2 = "Зарплата должна быть не длинее $maxzp символов<br>";
$err3 = "Поле ФИО соискателя должно быть не длинее $maxfio символов<br>";
$err4 = "Текст Условий труда должен быть не длинее $maxuslov символов<br>";
$err5 = "Текст Комментариев должен быть не длинее $maxcomment символов<br>";
$err6 = "Гражданство должно быть не длинее $maxciv символов<br>";
$err115 = "Поле Проф.навыки должно быть не длинее $maxprof символов<br>";
$err116 = "Поле Дополнительные сведения должно быть не длинее $maxdopsved символов<br>";
$err7 = "Не заполнено обязательное поле - Сфера деятельности!<br>";
$err8 = "Не заполнено обязательное поле - Раздел!<br>";
$err9 = "Не заполнено обязательное поле - Желаемая должность!<br>";

$err204 = "Не заполнено обязательное поле - Дата рождения!<br>";
$err205 = "Не заполнено обязательное поле - Профессиональные навыки и знания!<br>";

$err11 = "Не заполнено обязательное поле - Период размещения!<br>";
$err12 = "Попробуйте разместить объявление чуть позже! <br>";
$err22 = "Фотография должна иметь расширение *.jpg либо *.gif<br>";
$err23 = "Фотография должна иметь размер не более $MAX_FILE_SIZE байт!<br>";
$err300 = "Не верный цифровой код!<br>";

$error = "";
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
$result = @mysql_query("SELECT email,pass,category,addobyavl FROM $autortable WHERE email = '$slogin' and pass = '$spass' and addobyavl = ''");
if ((!isset($slogin) or !isset($spass)) or @mysql_num_rows($result) == 0)
{
echo "<center><br><br><h3>Вы не авторизированы либо вам запрещено добавлять объявления!</h3><b><a href=autor.php>Авторизация</a></b>";
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
echo "<p ><font color=red>Доступ к функциям авторского раздела для вас, к сожалению, закрыт!</font></p><blockquote><p align=justify><b>Причина:</b> $bunwhy</p><br><br>";
}
elseif (@mysql_num_rows($resultban) == 0) 
{ //bunip
$resultraz = @mysql_query("SELECT email,pass,category FROM $autortable WHERE email = '$slogin' and pass = '$spass' and (category = 'soisk' or category = 'agency')");
if (@mysql_num_rows($resultraz) == 0)
{
echo "<center><br><br><h3>Резюме могут размещать только соискатели и агентства!</h3><b><a href=registr.php>Регистрация</a></b>";
}
elseif (mysql_num_rows($resultraz) != 0) 
{ // проверка1
if ($_SERVER[QUERY_STRING] == "add") {

$razdel=$_POST['razdel'];
$podrazdel=$_POST['podrazdel'];
$profecy=$_POST['profecy'];
$zp=$_POST['zp'];
$grafic=$_POST['grafic'];
$zanatost=$_POST['zanatost'];
$uslov=$_POST['uslov'];
$comment=$_POST['comment'];
$fio=$_POST['fio'];
$gender=$_POST['gender'];
$byear=$_POST['byear'];
$bmonth=$_POST['bmonth'];
$bday=$_POST['bday'];
$family=$_POST['family'];
$civil=$_POST['civil'];
$prof=$_POST['prof'];
$dopsved=$_POST['dopsved'];
$period=$_POST['period'];
$number=$_POST['number'];

$expir1org=$_POST['expir1org'];
$expir1perfmonth=$_POST['expir1perfmonth'];
$expir1perfyear=$_POST['expir1perfyear'];
$expir1pertmonth=$_POST['expir1pertmonth'];
$expir1pertyear=$_POST['expir1pertyear'];
$expir1dol=$_POST['expir1dol'];
$expir1obyaz=$_POST['expir1obyaz'];
$expir2org=$_POST['expir2org'];
$expir2perfmonth=$_POST['expir2perfmonth'];
$expir2perfyear=$_POST['expir2perfyear'];
$expir2pertmonth=$_POST['expir2pertmonth'];
$expir2pertyear=$_POST['expir2pertyear'];
$expir2dol=$_POST['expir2dol'];
$expir2obyaz=$_POST['expir2obyaz'];
$expir3org=$_POST['expir3org'];
$expir3perfmonth=$_POST['expir3perfmonth'];
$expir3perfyear=$_POST['expir3perfyear'];
$expir3pertmonth=$_POST['expir3pertmonth'];
$expir3pertyear=$_POST['expir3pertyear'];
$expir3dol=$_POST['expir3dol'];
$expir3obyaz=$_POST['expir3obyaz'];
$expir4org=$_POST['expir4org'];
$expir4perfmonth=$_POST['expir4perfmonth'];
$expir4perfyear=$_POST['expir4perfyear'];
$expir4pertmonth=$_POST['expir4pertmonth'];
$expir4pertyear=$_POST['expir4pertyear'];
$expir4dol=$_POST['expir4dol'];
$expir4obyaz=$_POST['expir4obyaz'];
$expir5org=$_POST['expir5org'];
$expir5perfmonth=$_POST['expir5perfmonth'];
$expir5perfyear=$_POST['expir5perfyear'];
$expir5pertmonth=$_POST['expir5pertmonth'];
$expir5pertyear=$_POST['expir5pertyear'];
$expir5dol=$_POST['expir5dol'];
$expir5obyaz=$_POST['expir5obyaz'];
$edu1sel=$_POST['edu1sel'];
$edu1school=$_POST['edu1school'];
$edu1year=$_POST['edu1year'];
$edu1fac=$_POST['edu1fac'];
$edu1spec=$_POST['edu1spec'];
$edu2sel=$_POST['edu2sel'];
$edu2school=$_POST['edu2school'];
$edu2year=$_POST['edu2year'];
$edu2fac=$_POST['edu2fac'];
$edu2spec=$_POST['edu2spec'];
$edu3sel=$_POST['edu3sel'];
$edu3school=$_POST['edu3school'];
$edu3year=$_POST['edu3year'];
$edu3fac=$_POST['edu3fac'];
$edu3spec=$_POST['edu3spec'];
$edu4sel=$_POST['edu4sel'];
$edu4school=$_POST['edu4school'];
$edu4year=$_POST['edu4year'];
$edu4fac=$_POST['edu4fac'];
$edu4spec=$_POST['edu4spec'];
$edu5sel=$_POST['edu5sel'];
$edu5school=$_POST['edu5school'];
$edu5year=$_POST['edu5year'];
$edu5fac=$_POST['edu5fac'];
$edu5spec=$_POST['edu5spec'];
$lang1=$_POST['lang1'];
$lang1uroven=$_POST['lang1uroven'];
$lang2=$_POST['lang2'];
$lang2uroven=$_POST['lang2uroven'];
$lang3=$_POST['lang3'];
$lang3uroven=$_POST['lang3uroven'];
$lang4=$_POST['lang4'];
$lang4uroven=$_POST['lang4uroven'];
$lang5=$_POST['lang5'];
$lang5uroven=$_POST['lang5uroven'];

$curdate = date("Y-m-d H:i:s", time());
$expdate = date("Y-m-d H:i:s", time()- 60*$antiflood);
$result3 = @mysql_query("SELECT date,ip,aid FROM $restable WHERE ip='$REMOTE_ADDR' and aid=$id and date < '$curdate' and date > '$expdate'");
if (@mysql_num_rows($result3) != 0) {$error .= "$err12";}
if (strlen($profecy) > $maxprofecy) {$error .= "$err1";}
if (strlen($zp) > $maxzp) {$error .= "$err2";}
if (strlen($fio) > $maxfio) {$error .= "$err3";}
if (strlen($uslov) > $maxuslov) {$error .= "$err4";}
if (strlen($comment) > $maxcomment) {$error .= "$err5";}
if (strlen($civil) > $maxciv) {$error .= "$err6";}
if (strlen($prof) > $maxprof) {$error .= "$err115";}
if (strlen($dopsved) > $maxdopsved) {$error .= "$err116";}
if ($razdel == "" or $razdel == '0') {$error .= "$err7";}
if (isset($podrazdel) and $podrazdel == "") {$error .= "$err8";}
if ($profecy == "") {$error .= "$err9";}

if ($who == 'agency' and ($bday == "" or $bmonth == "" or $byear == "")) {$error .= "$err204";}
if ($who == 'agency' and $prof == "") {$error .= "$err205";}

if ($period == "") {$error .= "$err11";}
if ($file1 != "") {
$file1 = $_FILES['file1']['name'];
$filesize1 = $_FILES['file1']['size']; 
$temp1 = $_FILES['file1']['tmp_name'];
$fileres1=strtolower(basename($file1));
if ($file1 != "" and !eregi("\.jpg$",$fileres1) and !eregi("\.gif$",$fileres1)){$error .= "$err22";}
if ($filesize1 > $MAX_FILE_SIZE){$error .= "$err23";}
}
if ($imgobyavlconfirm == 'TRUE' and ($_COOKIE['reg_num'] != $number or $number == '')) {$error .= "$err300";}
echo "<p ><font color=red>$error</font></p>";
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
$profecy = untag($profecy);
$zp = untag($zp);
$uslov = untag($uslov);
$comment = untag($comment);
$fio = untag($fio);
$civil = untag($civil);
$edu = untag($edu);
$dopedu = untag($dopedu);
$languages = untag($languages);
$expir = untag($expir);
$prof = untag($prof);
$dopsved = untag($dopsved);
$expir1org = untag($expir1org);
$expir1perfmonth = untag($expir1perfmonth);
$expir1perfyear = untag($expir1perfyear);
$expir1pertmonth = untag($expir1pertmonth);
$expir1pertyear = untag($expir1pertyear);
$expir1dol = untag($expir1dol);
$expir1obyaz = untag($expir1obyaz);
$expir2org = untag($expir2org);
$expir2perfmonth = untag($expir2perfmonth);
$expir2perfyear = untag($expir2perfyear);
$expir2pertmonth = untag($expir2pertmonth);
$expir2pertyear = untag($expir2pertyear);
$expir2dol = untag($expir2dol);
$expir2obyaz = untag($expir2obyaz);
$expir3org = untag($expir3org);
$expir3perfmonth = untag($expir3perfmonth);
$expir3perfyear = untag($expir3perfyear);
$expir3pertmonth = untag($expir3pertmonth);
$expir3pertyear = untag($expir3pertyear);
$expir3dol = untag($expir3dol);
$expir3obyaz = untag($expir3obyaz);
$expir4org = untag($expir4org);
$expir4perfmonth = untag($expir4perfmonth);
$expir4perfyear = untag($expir4perfyear);
$expir4pertmonth = untag($expir4pertmonth);
$expir4pertyear = untag($expir4pertyear);
$expir4dol = untag($expir4dol);
$expir4obyaz = untag($expir4obyaz);
$expir5org = untag($expir5org);
$expir5perfmonth = untag($expir5perfmonth);
$expir5perfyear = untag($expir5perfyear);
$expir5pertmonth = untag($expir5pertmonth);
$expir5pertyear = untag($expir5pertyear);
$expir5dol = untag($expir5dol);
$expir5obyaz = untag($expir5obyaz);
$edu1sel = untag($edu1sel);
$edu1school = untag($edu1school);
$edu1year = untag($edu1year);
$edu1fac = untag($edu1fac);
$edu1spec = untag($edu1spec);
$edu2sel = untag($edu2sel);
$edu2school = untag($edu2school);
$edu2year = untag($edu2year);
$edu2fac = untag($edu2fac);
$edu2spec = untag($edu2spec);
$edu3sel = untag($edu3sel);
$edu3school = untag($edu3school);
$edu3year = untag($edu3year);
$edu3fac = untag($edu3fac);
$edu3spec = untag($edu3spec);
$edu4sel = untag($edu4sel);
$edu4school = untag($edu4school);
$edu4year = untag($edu4year);
$edu4fac = untag($edu4fac);
$edu4spec = untag($edu4spec);
$edu5sel = untag($edu5sel);
$edu5school = untag($edu5school);
$edu5year = untag($edu5year);
$edu5fac = untag($edu5fac);
$edu5spec = untag($edu5spec);
$lang1 = untag($lang1);
$lang1uroven = untag($lang1uroven);
$lang2 = untag($lang2);
$lang2uroven = untag($lang2uroven);
$lang3 = untag($lang3);
$lang3uroven = untag($lang3uroven);
$lang4 = untag($lang4);
$lang4uroven = untag($lang4uroven);
$lang5 = untag($lang5);
$lang5uroven = untag($lang5uroven);

if ($_SERVER[QUERY_STRING] == "add" and $error == "") {
$date = date("Y/m/d H:i:s");
$birth="$byear-$bmonth-$bday";
if ($_SERVER[QUERY_STRING] == "add" and $file1 != "") {
$result1 = @mysql_query("SELECT ID FROM $restable order by ID DESC LIMIT 1");
while ($myrow=@mysql_fetch_array($result1)) 
{
$fid=$myrow["ID"];
}
$fid=$fid+1;
$updir=$photodir;
$path1 = $upath."$updir";
$fileres1=@substr($fileres1,-3,3);
$source_name1="";
if ($file1 != "") {$source_name1 = "p".$fid."_1.$fileres1";}
if($error == ""){
$dest1 = $path1.$source_name1;
if ($file1 != "") {
@copy("$temp1","$dest1");$foto1=$updir."$source_name1";
if (function_exists('ImageTypes')) {
if ((ImageTypes() & IMG_JPG and $fileres1=='jpg') or (ImageTypes() & IMG_GIF and $fileres1=='gif'))
{ //small img
if ($fileres1=='jpg') {$image = ImageCreateFromJPEG($foto1);}
if ($fileres1=='gif') {$image = ImageCreateFromGIF($foto1);}
$width = imagesx($image) ;
$height = imagesy($image) ;
$new_height = $smallfotoheight; 
$new_width = ($new_height * $width) / $height ;
$thumb = imagecreate($new_width,$new_height);
$thumb = ImageCreateTrueColor($new_width,$new_height);
imagecopyresized($thumb,$image,0,0,0,0,$new_width,$new_height,$width,$height);
if ($fileres1=='jpg') {ImageJPEG($thumb, $updir.'s'.$source_name1);}
if ($fileres1=='gif') {ImageGIF($thumb, $updir.'s'.$source_name1);}
}} //small img
}
}
}
if ($textconfirm=='TRUE') {$status='wait';$stroka='<b>После проверки объявления администратором оно будет опубликовано.</b>';}
elseif ($textconfirm=='FALSE') {$status='ok';$stroka='<b>В течение нескольких минут объявление будет доступно для просмотра</b>';}
if ($who == 'soisk')
{
$resultaut = @mysql_query("SELECT * FROM $autortable WHERE ID='$id'");
while ($myrow1=mysql_fetch_array($resultaut)) {
$country=$myrow1["country"];
$region=$myrow1["region"];
$city=$myrow1["city"];
$birth=$myrow1["birth"];
$gender=$myrow1["gender"];
}
}
$sql="insert into $restable (razdel,podrazdel,profecy,zp,grafic,zanatost,uslov,country,region,city,comment,fio,birth,gender,family,civil,expir1org,expir1perfmonth,expir1perfyear,expir1pertmonth,expir1pertyear,expir1dol,expir1obyaz,expir2org,expir2perfmonth,expir2perfyear,expir2pertmonth,expir2pertyear,expir2dol,expir2obyaz,expir3org,expir3perfmonth,expir3perfyear,expir3pertmonth,expir3pertyear,expir3dol,expir3obyaz,expir4org,expir4perfmonth,expir4perfyear,expir4pertmonth,expir4pertyear,expir4dol,expir4obyaz,expir5org,expir5perfmonth,expir5perfyear,expir5pertmonth,expir5pertyear,expir5dol,expir5obyaz,edu1sel,edu1school,edu1year,edu1fac,edu1spec,edu2sel,edu2school,edu2year,edu2fac,edu2spec,edu3sel,edu3school,edu3year,edu3fac,edu3spec,edu4sel,edu4school,edu4year,edu4fac,edu4spec,edu5sel,edu5school,edu5year,edu5fac,edu5spec,lang1,lang1uroven,lang2,lang2uroven,lang3,lang3uroven,lang4,lang4uroven,lang5,lang5uroven,prof,dopsved,period,aid,date,status,foto1,ip,category) values ('$razdel','$podrazdel','$profecy','$zp','$grafic','$zanatost','$uslov','$country','$region','$city','$comment','$fio','$birth','$gender','$family','$civil','$expir1org','$expir1perfmonth','$expir1perfyear','$expir1pertmonth','$expir1pertyear','$expir1dol','$expir1obyaz','$expir2org','$expir2perfmonth','$expir2perfyear','$expir2pertmonth','$expir2pertyear','$expir2dol','$expir2obyaz','$expir3org','$expir3perfmonth','$expir3perfyear','$expir3pertmonth','$expir3pertyear','$expir3dol','$expir3obyaz','$expir4org','$expir4perfmonth','$expir4perfyear','$expir4pertmonth','$expir4pertyear','$expir4dol','$expir4obyaz','$expir5org','$expir5perfmonth','$expir5perfyear','$expir5pertmonth','$expir5pertyear','$expir5dol','$expir5obyaz','$edu1sel','$edu1school','$edu1year','$edu1fac','$edu1spec','$edu2sel','$edu2school','$edu2year','$edu2fac','$edu2spec','$edu3sel','$edu3school','$edu3year','$edu3fac','$edu3spec','$edu4sel','$edu4school','$edu4year','$edu4fac','$edu4spec','$edu5sel','$edu5school','$edu5year','$edu5fac','$edu5spec','$lang1','$lang1uroven','$lang2','$lang2uroven','$lang3','$lang3uroven','$lang4','$lang4uroven','$lang5','$lang5uroven','$prof','$dopsved','$period','$id',now(),'$status','$source_name1','$REMOTE_ADDR','$who')";
$result=@mysql_query($sql,$db);

if ($textconfirm == 'FALSE')
{ // no confirm
$result1 = @mysql_query("SELECT ID FROM $restable order by ID DESC LIMIT 1");
while ($myrow=@mysql_fetch_array($result1)) 
{
$lastid=$myrow["ID"];
}
$resl = @mysql_query("SELECT name,status FROM $rassilka WHERE name='admin'");
while ($myrow=mysql_fetch_array($resl)) 
{
$rstatus=$myrow["status"];
}
if ($rstatus == 'on')
{ //ras

function XMail( $from, $to, $subj, $text, $filename) { 
    $f         = fopen($filename,"rb"); 
    $un        = strtoupper(uniqid(time())); 
    $head      = "From: $from\n"; 
    $head     .= "To: $to\n"; 
    $head     .= "Subject: $subj\n"; 
    $head     .= "X-Mailer: PHPMail Tool\n"; 
    $head     .= "Reply-To: $from\n"; 
    $head     .= "Mime-Version: 1.0\n"; 
    $head     .= "Content-Type:multipart/mixed;"; 
    $head     .= "boundary=\"----------".$un."\"\n\n"; 
    $zag       = "------------".$un."\nContent-Type:text/html;charset=windows-1251\n"; 
    $zag      .= "Content-Transfer-Encoding: 8bit\n\n$text\n\n"; 

    $zag      .= "------------".$un."\n"; 
    $zag      .= "Content-Type: application/octet-stream;"; 
    $zag      .= "name=\"".basename($filename)."\"\n"; 
    $zag      .= "Content-Transfer-Encoding:base64\n";
    $zag      .= "Content-ID: <promo>\n";
    $zag      .= "Content-Disposition:attachment;";
    $zag      .= "filename=\"".basename($filename)."\"\n\n"; 
    $zag      .= chunk_split(base64_encode(fread($f,filesize($filename))))."\n"; 
     
    return @mail("$to", "$subj", $zag, $head); 
} 

$result = mysql_query("SELECT * FROM $rasres");
if (mysql_num_rows($result) != 0)
{ //has
while ($myrow=mysql_fetch_array($result)) 
{ //while
$srprofecy=$myrow["srprofecy"];
$agemin=$myrow["agemin"];
$agemax=$myrow["agemax"];
$srzp=$myrow["srzp"];
$srgender=$myrow["srgender"];
$srgrafic=$myrow["srgrafic"];
$srzanatost=$myrow["srzanatost"];
$srcountry=$myrow["srcountry"];
$srregion=$myrow["srregion"];
$srcity=$myrow["srcity"];
$razdel=$myrow["razdel"];
$podrazdel=$myrow["podrazdel"];
$autoraid=$myrow["aid"];
$lsrrazdel='';
$lsrpodrazdel='';
$lsrcountry='';
$lsrregion='';
$lsrcity='';
$lsrprofecy='';
$lsragemin='';
$lsragemax='';
$lsrzp='';
$lsrzanatost='';
$lsrgrafic='';
$lsrgender='';
$lsrcomment='';
if ($podrazdel != '' and $podrazdel != '0' and $podrazdel != '%')
{
$lsrpodrazdel="and podrazdel = $podrazdel";
}
if ($razdel != '' and $razdel != '0' and $razdel != '%')
{
$lsrrazdel="and razdel = $razdel";
}
if ($srcountry != "0" and $srcountry != '') {$lsrcountry="and country = '$srcountry'";}
if ($srregion != "0" and $srregion != '') {$lsrregion="and region = '$srregion'";}
if ($srcity != "0" and $srcity != '') {$lsrcity="and city = '$srcity'";}
if ($srprofecy != "%" and $srprofecy != '') {$srprofecy = ereg_replace(" ","*.",$srprofecy); $lsrprofecy="and profecy REGEXP '$srprofecy'";}
if ($agemin != "0" and $agemin != '') {$lsragemin="and (birth = '0000-00-00' or (YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) >= $agemin)";}
if ($agemax != "0" and $agemax != '') {$lsragemax="and (birth = '0000-00-00' or (YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) <= $agemax)";}
if ($srzp != "" and $srzp != '%' and $srzp != 0) {$lsrzp="and (zp <= $srzp or zp=0)";}
if ($srzanatost != "%" and $srzanatost != '') {
if ($srzanatost == 'Полная') {$lsrzanatost="and (zanatost REGEXP 'Полная' or zanatost = '' or zanatost REGEXP 'важно')";}
if (eregi ('совместительству',$srzanatost)) {$lsrzanatost="and (zanatost REGEXP 'совместительству' or zanatost = '' or zanatost REGEXP 'важно')";}
}
if ($srgrafic != "%" and $srgrafic != '') {
if ($srgrafic == 'Полный&nbsp;день') {$lsrgrafic="and (grafic REGEXP 'Полный&nbsp;день' or grafic = '' or grafic REGEXP 'важно')";}
if (eregi ('Неполный',$srgrafic)) {$lsrgrafic="and (grafic REGEXP 'Неполный' or grafic = '' or grafic REGEXP 'важно')";}
if (eregi ('Свободный',$srzanatost)) {$lsrgrafic="and (grafic REGEXP 'Свободный' or grafic = '' or grafic REGEXP 'важно')";}
if (eregi ('Удаленная',$srzanatost)) {$lsrgrafic="and (grafic REGEXP 'Удаленная' or grafic = '' or grafic REGEXP 'важно')";}
}
if ($srgender != "%" and $srgender != '') {
if ($srgender == 'Мужской') {$lsrgender="and gender REGEXP 'Мужской'";}
if ($srgender == 'Женский') {$lsrgender="and gender REGEXP 'Женский'";}
}
$resultsr = @mysql_query("SELECT *,CURRENT_DATE,(YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) AS age,DATE_FORMAT(date,'%d.%m.%Y') as date,LPAD(ID,4,'0') as nID FROM $restable WHERE status='ok' $lsrcountry $lsrregion $lsrcity $lsrrazdel $lsrpodrazdel $lsrprofecy $lsragemin $lsragemax $lsrzp $lsrzanatost $lsrgrafic $lsrgender and ID='$lastid'");
if (mysql_num_rows($resultsr) != 0)
{ // есть совпадение
while ($myrow2=@mysql_fetch_array($resultsr)) 
{ // while2

if ($rasfull == 'FALSE')
{ // short
$ID=$myrow2["ID"];
$profecy=$myrow2["profecy"];
$zp=$myrow2["zp"];
$grafic=$myrow2["grafic"];
$zanatost=$myrow2["zanatost"];
$aid=$myrow2["aid"];
$resultaut = @mysql_query("SELECT *,CURRENT_DATE,(YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) AS age FROM $autortable WHERE ID='$aid'");
while ($myrow11=mysql_fetch_array($resultaut)) {
$prof=$myrow11["prof"];
$gender=$myrow11["gender"];
$age=$myrow11["age"];
$category=$myrow11["category"];
}
if ($category == 'agency')
{
$age=$myrow2["age"];
$gender=$myrow2["gender"];
$prof=$myrow2["prof"];
}
$date=$myrow2["date"];
$razdel=$myrow2["razdel"];
$podrazdel=$myrow2["podrazdel"];
$resultadd2 = @mysql_query("SELECT ID,podrazdel FROM $catable WHERE ID='$podrazdel'");
while($myrow3=mysql_fetch_array($resultadd2)) {
$podrazdel1=$myrow3["podrazdel"];
}
$resultadd1 = @mysql_query("SELECT ID,razdel,podrazdel FROM $catable WHERE podrazdel = '' and ID='$razdel'");
while($myrow3=mysql_fetch_array($resultadd1)) {
$razdel1=$myrow3["razdel"];
}
$body=("
<a href=$siteadress/linkres.php?link=$ID><b>$profecy</b></a>
");
if ($zp != 0) {$body .="&nbsp;-&nbsp;\$$zp";}
$body .="<br>";
$br=0;
$br=0;
if ($gender == 'Мужской') {$br=1; $body .="Мужчина&nbsp";}
if ($gender == 'Женский') {$br=1; $body .="Женщина&nbsp";}
if ($age != 0 and $age != 0) {$br=1; $body .="$age лет(года);&nbsp";}
if ($grafic != '' and !eregi("важно",$grafic)) {if ($br==1) {$body .="<br>";} $br=1; $body .="$grafic";}
if ($prof != '') {if ($br==1) {$body .="<br>";} $body .="Проф.навыки: $prof";}
$body .= ("
<br><a href=$siteadress/linkres.php?link=$ID>Подробнее...</a><br><br>
");
} // short

if ($rasfull == 'TRUE')
{ // full
$ID=$myrow2["ID"];
$nID=$myrow2["nID"];
$profecy=$myrow2["profecy"];
$zp=$myrow2["zp"];
$grafic=$myrow2["grafic"];
$zanatost=$myrow2["zanatost"];
$uslov=$myrow2["uslov"];
$comment=$myrow2["comment"];
$aid=$myrow2["aid"];
$date=$myrow2["date"];
$razdel=$myrow2["razdel"];
$podrazdel=$myrow2["podrazdel"];
$resultaut = @mysql_query("SELECT *,CURRENT_DATE,(YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) AS age FROM $autortable WHERE ID='$aid'");
while ($myrow11=mysql_fetch_array($resultaut)) {
$email=$myrow11["email"];
$country=$myrow1["country"];
$region=$myrow1["region"];
$city=$myrow11["city"];

$citytar=$city;
if ($city=='0') {$citytar=$region;}
if ($region=='0' and $city=='0') {$citytar=$country;}
$resultadd3c = @mysql_query("SELECT * FROM $citytable WHERE ID='$citytar'");
while($myrowc=mysql_fetch_array($resultadd3c)) {
$citys=$myrowc["categ"];
if ($city=='0') {$citys=$myrowc["podrazdel"];}
if ($city=='0' and $region=='0') {$citys=$myrowc["razdel"];}
}

$telephone=$myrow11["telephone"];
$adress=$myrow11["adress"];
$url=$myrow11["url"];
$firm=$myrow11["firm"];
$cfio=$myrow11["fio"];
$gender=$myrow11["gender"];
$family=$myrow11["family"];
$civil=$myrow11["civil"];
$prof=$myrow11["prof"];
$dopsved=$myrow11["dopsved"];
$age=$myrow11["age"];
$category=$myrow11["category"];
$foto1=$myrow11["foto1"];
$foto2=$myrow11["foto2"];
}
$w='a';
if ($category == 'agency')
{
$w='r';
$age=$myrow2["age"];
$fio=$myrow2["fio"];
$gender=$myrow2["gender"];
$family=$myrow2["family"];
$civil=$myrow2["civil"];
$prof=$myrow2["prof"];
$dopsved=$myrow2["dopsved"];
$foto1=$myrow2["foto1"];
}
$resultadd2 = @mysql_query("SELECT ID,podrazdel FROM $catable WHERE ID='$podrazdel'");
while($myrow13=mysql_fetch_array($resultadd2)) {
$podrazdel1=$myrow13["podrazdel"];
}
$resultadd1 = @mysql_query("SELECT ID,razdel,podrazdel FROM $catable WHERE podrazdel = '' and ID='$razdel'");
while($myrow13=mysql_fetch_array($resultadd1)) {
$razdel1=$myrow13["razdel"];
}
$body = ("
<div ><table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$altcolor><td ><b>Резюме $nID</b></td></tr></table></td></tr></table>
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$maincolor><td valign=top colspan=2><b>Желаемая должность:</b> $profecy</b>.
");
if ($zp != 0) {$body .= "Зарплата от <font color=blue><b>$zp</b></font> $valute";}
$body .= ("
</td></tr>
");
$body .= ("
<tr bgcolor=$maincolor><td  colspan=2><b>Персональные данные</b></td></tr>
<tr bgcolor=$maincolor><td valign=top colspan=2 width=100%>
");
if ($fio != '' and $category=='agency') {$body .= "<b>ФИО</b>: $fio<br>";}
if ($cfio != '' and $category=='soisk') {$body .= "<b>ФИО</b>: $cfio<br>";}
if ($gender == 'Мужской') {$body .= "<b>Пол</b>: Мужской<br>";}
if ($gender == 'Женский') {$body .= "<b>Пол</b>: Женский<br>";}
if ($age != 0) {$body .= "<b>Возраст</b>: $age лет(года)<br>";}
if ($family != '') {$body .= "<b>Семейное положение</b>: $family<br>";}
if ($civil != '') {$body .= "<b>Гражданство</b>: $civil<br>";}
if ($category == 'soisk')
{
if ($citys != '') {$body .= "<b>Город проживания</b>: $citys<br>";}
}
$body .= "</td></tr><tr bgcolor=$maincolor><td colspan=2><b>&nbsp;Условия труда:</b></td></tr>";
if ($zanatost != '' and !eregi("важно",$zanatost)) {$body .= "<tr bgcolor=$maincolor><td>Занятость:</td><td>$zanatost</td></tr>";}
if ($zanatost != '' and eregi("важно",$zanatost)) {$body .= "<tr bgcolor=$maincolor><td>Занятость:</td><td>Любая</td></tr>";}
if ($grafic != '' and !eregi("важно",$grafic)) {$body .= "<tr bgcolor=$maincolor><td>График&nbsp;работы:</td><td>$grafic</td></tr>";}
if ($grafic != '' and eregi("важно",$grafic)) {$body .= "<tr bgcolor=$maincolor><td>График&nbsp;работы:</td><td>Любой</td></tr>";}
if ($uslov != '') {$body .= "<tr bgcolor=$maincolor><td valign=top>Условия:</td><td>$uslov</td></tr>";}
if ($prof != '')
{
$prof = ereg_replace("\n","<br>",$prof);
$body .= "<tr bgcolor=$maincolor><td colspan=2><b>&nbsp;Профессиональные навыки и знания:</b></td></tr>";
$body .= "<tr bgcolor=$maincolor><td colspan=2><p align=justify>$prof</p></td></tr>";
}
if ($dopsved != '')
{
$dopsved = ereg_replace("\n","<br>",$dopsved);
$body .= "<tr bgcolor=$maincolor><td colspan=2><b>&nbsp;Дополнительные сведения:</b></td></tr>";
$body .= "<tr bgcolor=$maincolor><td colspan=2><p align=justify>$dopsved</p></td></tr>";
}
if ($comment != '')
{
$comment = ereg_replace("\n","<br>",$comment);
$body .= "<tr bgcolor=$maincolor><td colspan=2><b>&nbsp;Дополнительная информация:</b></td></tr>";
$body .= "<tr bgcolor=$maincolor><td colspan=2><p align=justify>$comment</p></td></tr>";
}
$body .= ("
<tr bgcolor=$maincolor><td align=right colspan=2><a href=$siteadress/linkres.php?link=$ID>Подробнее...</a></td></tr>
</table></td></tr></table></div><br>
");
} // full

} //while2
$resultb = mysql_query("SELECT * FROM $rasres where aid='$autoraid'");
while ($myrow4=mysql_fetch_array($resultb)) 
{$txt=$myrow4["txt"];}

//<!-- рекламный блок рассылки -->

$promotxt='';

 $resultprtop = mysql_query("select * from $promotable where wheres = 'rassilka' order by RAND() limit 1");
 $rows = mysql_num_rows($resultprtop);
if($rows != 0)
{
$promotxt="<div >";
while($myrow=mysql_fetch_array($resultprtop))
{
$ptitle=$myrow["title"];
$plink=$myrow["link"];
$pfoto=$myrow["foto"];
$promotxt .= "<table border=0 bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=1 width=100%><tr bgcolor=$maincolor><td><a href=\"$plink\" target=_blank><img src=\"cid:promo\" alt=\"$ptitle\" border=0></a></td></tr></table></td></tr></table><br>";
}
$promotxt .= "</div>";
}


//<!-- рекламный блок рассылки -->


$body = $txt.$body;
$resultras = mysql_query("UPDATE $rasres SET txt='$body',sum=sum+1 WHERE aid='$autoraid'");
} // есть совпадение
} //while
} //has

$resultsend = mysql_query("SELECT * FROM $rasres WHERE sum >= $sendcount");
if (mysql_num_rows($resultsend) != 0)
{ //send
$txttop="Здравствуйте!<br>Это письмо отправлено Вам в связи с вашей подпиской на новые резюме сайта <a href=$siteadress>$sitename</a><br><br>Список последних $sendcount резюме:<br><br>";
$txtdown = "<br>Спасибо за пользование нашим сайтом!<br><a href=$siteadress>$sitename</a>";
while ($myrow=mysql_fetch_array($resultsend)) 
{ //while3
$said=$myrow["aid"];
$hID=$myrow["ID"];
$txtbody=$myrow["txt"];
$bodyfull=$promotxt.$txttop.$txtbody.$txtdown;
$resl2 = @mysql_query("SELECT email,ID FROM $autortable WHERE ID='$said'");
while ($myrow5=mysql_fetch_array($resl2)) 
{
$rassemail=$myrow5["email"];
}
Xmail($adminemail,$rassemail,"Новые резюме на сайте $sitename",$bodyfull,"$promo_dir$pfoto");
$resultdel = mysql_query("UPDATE $rasres SET sum=0,txt='' WHERE ID = '$hID'");
} //while3
} //send

} //ras
} // no confirm

}
}
if ($_SERVER[QUERY_STRING] != "add" or $error != "") {

if ($_GET['razdel'] == '') {$razdel=$_POST['razdel'];}
elseif ($_GET['razdel'] != '') {$razdel=$_GET['razdel'];}
if ($_GET['podrazdel'] == '') {$podrazdel=$_POST['podrazdel'];}
elseif ($_GET['podrazdel'] != '') {$podrazdel=$_GET['podrazdel'];}

if (isset($podrazdel) and $podrazdel != '')
{
$resultadd2 = @mysql_query("SELECT * FROM $catable WHERE ID='$podrazdel' LIMIT 1");
while($myrow=mysql_fetch_array($resultadd2)) {
$podrazdelsh=$myrow["podrazdel"];
}
}
$resultadd1 = @mysql_query("SELECT * FROM $catable WHERE ID='$razdel' LIMIT 1");
while($myrow=mysql_fetch_array($resultadd1)) {
$razdelsh=$myrow["razdel"];
}

?>

<form name=form method=post action=addres.php?add ENCTYPE=multipart/form-data>

<p class="red_text">Обязательные поля отмечены символом *</p><br>
  <ul class="tabs"> 	
<li><a href="#pojel" name="pojel">Пожелания к работе</a></a></li>     
<li><a href="#obr"  name="obr">Образование</a></li> 	
<li><a href="#opit" name="opit">Опыт работы</a></li> 	
<li><a href="#dopinfo" name="dopinfo">Дополнительная информация</a></li> 
</ul>  
<div class="panes"> 	
    
<?
echo ("
");
echo ("
<div>
<h2 class=\"sozd\"><a name=pojel></a>Пожелания к работе</h2>
<p>
<table border=0 width=800 cellpadding=4 cellspacing=10>
<tr bgcolor=$maincolor><td align=left width=300><font color=#FF0000>*</font>Сфера деятельности:</td>
<td align=left width=500>
<select class=for name=razdel size=1 onChange=location.href=location.pathname+\"?razdel=\"+value+\"\";>
<option selected value=\"$razdel\">$razdelsh</option>
");
$result2 = @mysql_query("SELECT * FROM $catable WHERE podrazdel = '' order by razdel");
while($myrow=mysql_fetch_array($result2)) {
$razdel1ID=$myrow["ID"];
$razdel1=$myrow["razdel"];
$razdel11 = ereg_replace(",","--",$razdel1);
echo "<option value=\"$razdel1ID\">$razdel1</option>";
}
echo ("
</select></td></tr>
");
if ($razdel != '')
{
$result3 = @mysql_query("SELECT * FROM $catable WHERE podrazdel != '' and razdel='$razdelsh' order by podrazdel");
if (@mysql_num_rows($result3) != 0) {
echo ("
<tr bgcolor=$maincolor><td align=left><font color=#FF0000>*</font>Раздел:</td>
<td align=left><select class=for name=podrazdel size=1>
<option selected value=\"$podrazdel\">$podrazdelsh</option>
");
while($myrow=mysql_fetch_array($result3)) {
$podrazdel=$myrow["podrazdel"];
$podrazdelID=$myrow["ID"];
echo "<option value=\"$podrazdelID\">$podrazdel</option>";
}
echo ("
</select></td></tr>
");
}
elseif (@mysql_num_rows($result3) == 0) {
echo "<input type=hidden name=podrazdel value=0>";
}
}
echo ("
<tr bgcolor=$maincolor><td align=left valign=top><font color=#FF0000>*</font>Желаемая должность:</td>
<td><input type=text class=for name=profecy size=30 value=\"$profecy\"></td></tr>
<tr bgcolor=$maincolor><td align=left>Желаемая зарплата:</td>
<td>От&nbsp;<input type=text class=for name=zp size=8 value=\"$zp\">&nbsp;$valute</td></tr>
<tr bgcolor=$maincolor><td align=left>Занятость:</td>
<td><select class=for name=zanatost size=1>
<option selected value=\"$zanatost\">$zanatost</option>
<option value=\"Не&nbsp;важно\">Не&nbsp;важно</option>
<option value=\"Полная\">Полная</option>
<option value=\"По&nbsp;совместительству\">По&nbsp;совместительству</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=left>График работы:</td>
<td><select class=for name=grafic size=1>
<option selected value=\"$grafic\">$grafic</option>
<option value=\"Не&nbsp;важно\">Не&nbsp;важно</option>
<option value=\"Полный&nbsp;день\">Полный&nbsp;день</option>
<option value=\"Неполный&nbsp;день\">Неполный&nbsp;день</option>
<option value=\"Свободный&nbsp;график\">Свободный&nbsp;график</option>
<option value=\"Удаленная&nbsp;работа\">Удаленная&nbsp;работа</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=left valign=top>Условия труда:<br>(не более 1000 симв.)</td>
<td><textarea class=arria rows=3 name=uslov cols=28>$uslov</textarea></td></tr>
</table></p>
<table width=100% border=0 class=navig>
  <tr>
    <td></td>
     <td><div class=\"apShag\"><a href=\"#obr\" class=dob>Далее</a></div></td>
  </tr>
</table>

</div>

<div class=\"les\">
<h2 class=\"sozd\"><a name=obr></a>Образование</h2>

<p>
<table width=800 cellpadding=4 cellspacing=10>
<tr bgcolor=$maincolor><td align=left valign=top width=300>Образование:</td>
<td align=left width=500><select class=for name=edu1sel size=1>
<option selected value=\"$edu1sel\">$edu1sel</option>
<option value=\"Среднее\">Среднее</option>
<option value=\"Среднее-специальное\">Среднее-специальное</option>
<option value=\"Неполное&nbsp;высшее\">Неполное&nbsp;высшее</option>
<option value=\"Высшее\">Высшее</option>
<option value=\"МВА\">МВА</option>
<option value=\"Курсы&nbsp;переподготовки\">Курсы&nbsp;переподготовки</option>
<option value=\"Второе&nbsp;высшее\">Второе&nbsp;высшее</option>
<option value=\"Докторантура\">Докторантура</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=left>Учебное заведение:</td>
<td align=left><input type=text class=for name=edu1school size=30 value=\"$edu1school\"></td></tr>
<tr bgcolor=$maincolor><td align=left>Окончил(а) в:</td>
<td align=left><input type=text class=for name=edu1year size=5 value=\"$edu1year\"> году</td></tr>
<tr bgcolor=$maincolor><td align=left>Факультет:</td>
<td align=left><input type=text class=for name=edu1fac size=30 value=\"$edu1fac\"></td></tr>
<tr bgcolor=$maincolor><td align=left>Специальность:</td>
<td align=left><input type=text class=for name=edu1spec size=30 value=\"$edu1spec\"></td></tr>
</table>
");

$lastedu=1;
if ($edu2sel != '' or $edu2school != '' or $edu2year != '' or $edu2fac != '' or $edu2spec != '') 
{
$style2table='';
$style1but="style=\"display : none;\"";
$lastedu=2;
}
elseif ($edu2sel == '' and $edu2school == '' and $edu2year == '' and $edu2fac == '' and $edu2spec == '') 
{
$style2table="style=\"display : none;\"";
$style1but='';
$lastedu=1;
}
if ($edu3sel != '' or $edu3school != '' or $edu3year != '' or $edu3fac != '' or $edu3spec != '') 
{
$style3table='';
$style2but="style=\"display : none;\"";
$lastedu=3;
}
elseif ($edu3sel == '' and $edu3school == '' and $edu3year == '' and $edu3fac == '' and $edu3spec == '') 
{
$style3table="style=\"display : none;\"";
$style2but="style=\"display : none;\"";
}
if ($edu4sel != '' or $edu4school != '' or $edu4year != '' or $edu4fac != '' or $edu4spec != '') 
{
$style4table='';
$style3but="style=\"display : none;\"";
$lastedu=4;
}
elseif ($edu4sel == '' and $edu4school == '' and $edu4year == '' and $edu4fac == '' and $edu4spec == '') 
{
$style4table="style=\"display : none;\"";
$style3but="style=\"display : none;\"";
}
if ($edu5sel != '' or $edu5school != '' or $edu5year != '' or $edu5fac != '' or $edu5spec != '') 
{
$style5table='';
$style4but="style=\"display : none;\"";
}
elseif ($edu5sel == '' and $edu5school == '' and $edu5year == '' and $edu5fac == '' and $edu5spec == '') 
{
$style5table="style=\"display : none;\"";
$style4but="style=\"display : none;\"";
}
if ($lastedu == 1) {$style1but="";}
if ($lastedu == 2) {$style2but="";}
if ($lastedu == 3) {$style3but="";}
if ($lastedu == 4) {$style4but="";}

echo ("
<div id=but1 $style1but>
<input name=submit type=button class=i3 value=\"Добавить учебное заведение\" onclick=\"Hide('but1');Shw('edu2');Shw('but2');\">
</div>

<div id=edu2 $style2table>
<table width=800 cellpadding=4 cellspacing=10>
<tr bgcolor=$maincolor><td colspan=2><br></td></tr>
<tr bgcolor=$maincolor><td align=left valign=top width=300>Образование:</td>
<td align=left width=500><select class=for name=edu2sel size=1>
<option selected value=\"$edu2sel\">$edu2sel</option>
<option value=\"Среднее\">Среднее</option>
<option value=\"Среднее-специальное\">Среднее-специальное</option>
<option value=\"Неполное&nbsp;высшее\">Неполное&nbsp;высшее</option>
<option value=\"Высшее\">Высшее</option>
<option value=\"МВА\">МВА</option>
<option value=\"Курсы&nbsp;переподготовки\">Курсы&nbsp;переподготовки</option>
<option value=\"Второе&nbsp;высшее\">Второе&nbsp;высшее</option>
<option value=\"Докторантура\">Докторантура</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=left>Учебное заведение:</td>
<td align=left><input type=text class=for name=edu2school size=30 value=\"$edu2school\"></td></tr>
<tr bgcolor=$maincolor><td align=left>Окончил(а) в:</td>
<td align=left><input type=text class=for name=edu2year size=5 value=\"$edu2year\"> году</td></tr>
<tr bgcolor=$maincolor><td align=left>Факультет:</td>
<td align=left><input type=text class=for name=edu2fac size=30 value=\"$edu2fac\"></td></tr>
<tr bgcolor=$maincolor><td align=left>Специальность:</td>
<td align=left><input type=text class=for name=edu2spec size=30 value=\"$edu2spec\"></td></tr>
<tr bgcolor=$maincolor><td colspan=2><br></td></tr>
</table>
</div>

<div id=but2 $style2but>
<input name=submit type=button class=i3 value=\"Добавить учебное заведение\" onclick=\"Hide('but2');Shw('edu3');Shw('but3');\">
</div>

<div id=edu3 $style3table>
<table width=800 cellpadding=4 cellspacing=10>
<tr bgcolor=$maincolor><td align=left valign=top width=300>Образование:</td>
<td align=left width=500><select class=for name=edu3sel size=1>
<option selected value=\"$edu3sel\">$edu3sel</option>
<option value=\"Среднее\">Среднее</option>
<option value=\"Среднее-специальное\">Среднее-специальное</option>
<option value=\"Неполное&nbsp;высшее\">Неполное&nbsp;высшее</option>
<option value=\"Высшее\">Высшее</option>
<option value=\"МВА\">МВА</option>
<option value=\"Курсы&nbsp;переподготовки\">Курсы&nbsp;переподготовки</option>
<option value=\"Второе&nbsp;высшее\">Второе&nbsp;высшее</option>
<option value=\"Докторантура\">Докторантура</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=left>Учебное заведение:</td>
<td align=left><input type=text class=for name=edu3school size=30 value=\"$edu3school\"></td></tr>
<tr bgcolor=$maincolor><td align=left>Окончил(а) в:</td>
<td align=left><input type=text class=for name=edu3year size=5 value=\"$edu3year\"> году</td></tr>
<tr bgcolor=$maincolor><td align=left>Факультет:</td>
<td align=left><input type=text class=for name=edu3fac size=30 value=\"$edu3fac\"></td></tr>
<tr bgcolor=$maincolor><td align=left>Специальность:</td>
<td align=left><input type=text class=for name=edu3spec size=30 value=\"$edu3spec\"></td></tr>
<tr bgcolor=$maincolor><td colspan=2><br></td></tr>
</table>
</div>

<div id=but3 $style3but>
<input name=submit type=button class=i3 value=\"Добавить учебное заведение\" onclick=\"Hide('but3');Shw('edu4');Shw('but4');\">
</div>

<div id=edu4 $style4table>
<table width=800 cellpadding=4 cellspacing=10>
<tr bgcolor=$maincolor><td align=left valign=top width=300>Образование:</td>
<td align=left width=500><select class=for name=edu4sel size=1>
<option selected value=\"$edu4sel\">$edu4sel</option>
<option value=\"Среднее\">Среднее</option>
<option value=\"Среднее-специальное\">Среднее-специальное</option>
<option value=\"Неполное&nbsp;высшее\">Неполное&nbsp;высшее</option>
<option value=\"Высшее\">Высшее</option>
<option value=\"МВА\">МВА</option>
<option value=\"Курсы&nbsp;переподготовки\">Курсы&nbsp;переподготовки</option>
<option value=\"Второе&nbsp;высшее\">Второе&nbsp;высшее</option>
<option value=\"Докторантура\">Докторантура</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=left>Учебное заведение:</td>
<td align=left><input type=text class=for name=edu4school size=30 value=\"$edu4school\"></td></tr>
<tr bgcolor=$maincolor><td align=left>Окончил(а) в:</td>
<td align=left><input type=text class=for name=edu4year size=5 value=\"$edu4year\"> году</td></tr>
<tr bgcolor=$maincolor><td align=left>Факультет:</td>
<td align=left><input type=text class=for name=edu4fac size=30 value=\"$edu4fac\"></td></tr>
<tr bgcolor=$maincolor><td align=left>Специальность:</td>
<td align=left><input type=text class=for name=edu4spec size=30 value=\"$edu4spec\"></td></tr>
<tr bgcolor=$maincolor><td colspan=2><br></td></tr>
</table>
</div>

<div id=but4 $style4but>
<input name=submit type=button class=i3 value=\"Добавить учебное заведение\" onclick=\"Hide('but4');Shw('edu5');\">
</div>

<div id=edu5 $style5table>
<table width=800 cellpadding=4 cellspacing=10>
<tr bgcolor=$maincolor><td align=left valign=top width=300>Образование:</td>
<td align=left width=500><select class=for name=edu5sel size=1>
<option selected value=\"$edu5sel\">$edu5sel</option>
<option value=\"Среднее\">Среднее</option>
<option value=\"Среднее-специальное\">Среднее-специальное</option>
<option value=\"Неполное&nbsp;высшее\">Неполное&nbsp;высшее</option>
<option value=\"Высшее\">Высшее</option>
<option value=\"МВА\">МВА</option>
<option value=\"Курсы&nbsp;переподготовки\">Курсы&nbsp;переподготовки</option>
<option value=\"Второе&nbsp;высшее\">Второе&nbsp;высшее</option>
<option value=\"Докторантура\">Докторантура</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=left>Учебное заведение:</td>
<td align=left><input type=text class=for name=edu5school size=30 value=\"$edu5school\"></td></tr>
<tr bgcolor=$maincolor><td align=left>Окончил(а) в:</td>
<td align=left><input type=text class=for name=edu5year size=5 value=\"$edu5year\"> году</td></tr>
<tr bgcolor=$maincolor><td align=left>Факультет:</td>
<td align=left><input type=text class=for name=edu5fac size=30 value=\"$edu5fac\"></td></tr>
<tr bgcolor=$maincolor><td align=left>Специальность:</td>
<td align=left><input type=text class=for name=edu5spec size=30 value=\"$edu5spec\"></td></tr>
<tr bgcolor=$maincolor><td colspan=2><br></td></tr>
</table>
</div>

<h2 class=\"sozd\">Знание иностранных языков</h2>

<p><table width=800 cellpadding=4 cellspacing=10>
<tr bgcolor=$maincolor><td align=left valign=top width=300>Выберите язык:</td>
<td align=left width=500><select class=for name=lang1 size=1>
<option selected value=\"$lang1\">$lang1</option>
<option value=\"Английский\">Английский</option>
<option value=\"Немецкий\">Немецкий</option>
<option value=\"Французский\">Французский</option>
<option value=\"Испанский\">Испанский</option>
<option value=\"Китайский\">Китайский</option>
<option value=\"Итальянский\">Итальянский</option>
<option value=\"Арабский\">Арабский</option>
<option value=\"Иврит\">Иврит</option>
<option value=\"Корейский\">Корейский</option>
<option value=\"Турецкий\">Турецкий</option>
<option value=\"Финский\">Финский</option>
<option value=\"Шведский\">Шведский</option>
<option value=\"Японский\">Японский</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=left valign=top>Уровень знаний:</td>
<td align=left><select class=for name=lang1uroven size=1>
<option selected value=\"$lang1uroven\">$lang1uroven</option>
<option value=\"Элементарный&nbsp;(Elementary)\">Элементарный&nbsp;(Elementary)</option>
<option value=\"Ниже&nbsp;среднего&nbsp;(Pre-Intermediate)\">Ниже&nbsp;среднего&nbsp;(Pre-Intermediate)</option>
<option value=\"Средний&nbsp;(Intermediate)\">Средний&nbsp;(Intermediate)</option>
<option value=\"Выше&nbsp;среднего&nbsp;(Upper-Intermediate)\">Выше&nbsp;среднего&nbsp;(Upper-Intermediate)</option>
<option value=\"Высший&nbsp;(Advanced)\">Высший&nbsp;(Advanced)</option>
</select></td></tr>
</table>
");

$lastlang=1;
if ($lang2 != '' or $lang2uroven != '') 
{
$style2lang='';
$style1butlan="style=\"display : none;\"";
$lastlang=2;
}
elseif ($lang2 == '' and $lang2uroven == '') 
{
$style2lang="style=\"display : none;\"";
$style1butlan='';
$lastlang=1;
}
if ($lang3 != '' or $lang3uroven != '') 
{
$style3lang='';
$style2butlan="style=\"display : none;\"";
$lastlang=3;
}
elseif ($lang3 == '' and $lang3uroven == '') 
{
$style3lang="style=\"display : none;\"";
$style2butlan="style=\"display : none;\"";
}
if ($lang4 != '' or $lang4uroven != '') 
{
$style4lang='';
$style3butlan="style=\"display : none;\"";
$lastlang=4;
}
elseif ($lang4 == '' and $lang4uroven == '') 
{
$style4lang="style=\"display : none;\"";
$style3butlan="style=\"display : none;\"";
}
if ($lang5 != '' or $lang5uroven != '') 
{
$style5lang='';
$style4butlan="style=\"display : none;\"";
}
elseif ($lang5 == '' and $lang5uroven == '') 
{
$style5lang="style=\"display : none;\"";
$style4butlan="style=\"display : none;\"";
}
if ($lastlang == 1) {$style1butlan="";}
if ($lastlang == 2) {$style2butlan="";}
if ($lastlang == 3) {$style3butlan="";}
if ($lastlang == 4) {$style4butlan="";}

echo ("
<div id=butlan1 $style1butlan>
<input name=submit type=button class=i3 value=\"Добавить ещё языки\" onclick=\"Hide('butlan1');Shw('dlang2');Shw('butlan2');\">
</div>

<div id=dlang2 $style2lang>
<table width=800 cellpadding=4 cellspacing=10>
<tr bgcolor=$maincolor><td colspan=2><br></td></tr>
<tr bgcolor=$maincolor><td align=left valign=top width=300>Выберите язык:</td>
<td align=left width=500><select class=for name=lang2 size=1>
<option selected value=\"$lang2\">$lang2</option>
<option value=\"Английский\">Английский</option>
<option value=\"Немецкий\">Немецкий</option>
<option value=\"Французский\">Французский</option>
<option value=\"Испанский\">Испанский</option>
<option value=\"Китайский\">Китайский</option>
<option value=\"Итальянский\">Итальянский</option>
<option value=\"Арабский\">Арабский</option>
<option value=\"Иврит\">Иврит</option>
<option value=\"Корейский\">Корейский</option>
<option value=\"Турецкий\">Турецкий</option>
<option value=\"Финский\">Финский</option>
<option value=\"Шведский\">Шведский</option>
<option value=\"Японский\">Японский</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=left valign=top>Уровень знаний:</td>
<td align=left><select class=for name=lang2uroven size=1>
<option selected value=\"$lang2uroven\">$lang2uroven</option>
<option value=\"Элементарный&nbsp;(Elementary)\">Элементарный&nbsp;(Elementary)</option>
<option value=\"Ниже&nbsp;среднего&nbsp;(Pre-Intermediate)\">Ниже&nbsp;среднего&nbsp;(Pre-Intermediate)</option>
<option value=\"Средний&nbsp;(Intermediate)\">Средний&nbsp;(Intermediate)</option>
<option value=\"Выше&nbsp;среднего&nbsp;(Upper-Intermediate)\">Выше&nbsp;среднего&nbsp;(Upper-Intermediate)</option>
<option value=\"Высший&nbsp;(Advanced)\">Высший&nbsp;(Advanced)</option>
</select></td></tr>
</table>
</div>

<div id=butlan2 $style2butlan>
<input name=submit type=button class=i3 value=\"Добавить ещё языки\" onclick=\"Hide('butlan2');Shw('dlang3');Shw('butlan3');\">
</div>

<div id=dlang3 $style3lang>
<table width=800 cellpadding=4 cellspacing=10>
<tr bgcolor=$maincolor><td colspan=2><br></td></tr>
<tr bgcolor=$maincolor><td align=left valign=top width=300>Выберите язык:</td>
<td align=left width=500><select class=for name=lang3 size=1>
<option selected value=\"$lang3\">$lang3</option>
<option value=\"Английский\">Английский</option>
<option value=\"Немецкий\">Немецкий</option>
<option value=\"Французский\">Французский</option>
<option value=\"Испанский\">Испанский</option>
<option value=\"Китайский\">Китайский</option>
<option value=\"Итальянский\">Итальянский</option>
<option value=\"Арабский\">Арабский</option>
<option value=\"Иврит\">Иврит</option>
<option value=\"Корейский\">Корейский</option>
<option value=\"Турецкий\">Турецкий</option>
<option value=\"Финский\">Финский</option>
<option value=\"Шведский\">Шведский</option>
<option value=\"Японский\">Японский</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=left valign=top>Уровень знаний:</td>
<td align=left><select class=for name=lang3uroven size=1>
<option selected value=\"$lang3uroven\">$lang3uroven</option>
<option value=\"Элементарный&nbsp;(Elementary)\">Элементарный&nbsp;(Elementary)</option>
<option value=\"Ниже&nbsp;среднего&nbsp;(Pre-Intermediate)\">Ниже&nbsp;среднего&nbsp;(Pre-Intermediate)</option>
<option value=\"Средний&nbsp;(Intermediate)\">Средний&nbsp;(Intermediate)</option>
<option value=\"Выше&nbsp;среднего&nbsp;(Upper-Intermediate)\">Выше&nbsp;среднего&nbsp;(Upper-Intermediate)</option>
<option value=\"Высший&nbsp;(Advanced)\">Высший&nbsp;(Advanced)</option>
</select></td></tr>
</table>
</div>

<div id=butlan3 $style3butlan>
<input name=submit type=button class=i3 value=\"Я знаю еще иностранные языки\" onclick=\"Hide('butlan3');Shw('dlang4');Shw('butlan4');\">
</div>

<div id=dlang4 $style4lang>
<table width=800 cellpadding=4 cellspacing=10>
<tr bgcolor=$maincolor><td colspan=2><br></td></tr>
<tr bgcolor=$maincolor><td align=left valign=top width=300>Выберите язык:</td>
<td align=left width=500><select class=for name=lang4 size=1>
<option selected value=\"$lang4\">$lang4</option>
<option value=\"Английский\">Английский</option>
<option value=\"Немецкий\">Немецкий</option>
<option value=\"Французский\">Французский</option>
<option value=\"Испанский\">Испанский</option>
<option value=\"Китайский\">Китайский</option>
<option value=\"Итальянский\">Итальянский</option>
<option value=\"Арабский\">Арабский</option>
<option value=\"Иврит\">Иврит</option>
<option value=\"Корейский\">Корейский</option>
<option value=\"Турецкий\">Турецкий</option>
<option value=\"Финский\">Финский</option>
<option value=\"Шведский\">Шведский</option>
<option value=\"Японский\">Японский</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=left valign=top>Уровень знаний:</td>
<td align=left><select class=for name=lang4uroven size=1>
<option selected value=\"$lang4uroven\">$lang4uroven</option>
<option value=\"Элементарный&nbsp;(Elementary)\">Элементарный&nbsp;(Elementary)</option>
<option value=\"Ниже&nbsp;среднего&nbsp;(Pre-Intermediate)\">Ниже&nbsp;среднего&nbsp;(Pre-Intermediate)</option>
<option value=\"Средний&nbsp;(Intermediate)\">Средний&nbsp;(Intermediate)</option>
<option value=\"Выше&nbsp;среднего&nbsp;(Upper-Intermediate)\">Выше&nbsp;среднего&nbsp;(Upper-Intermediate)</option>
<option value=\"Высший&nbsp;(Advanced)\">Высший&nbsp;(Advanced)</option>
</select></td></tr>
</table>
</div>

<div id=butlan4 $style4butlan>
<input name=submit type=button class=i3 value=\"Я знаю еще иностранные языки\" onclick=\"Hide('butlan4');Shw('dlang5');\">
</div>

<div id=dlang5 $style5lang>
<table width=800 cellpadding=4 cellspacing=10>
<tr bgcolor=$maincolor><td colspan=2><br></td></tr>
<tr bgcolor=$maincolor><td align=left valign=top width=300>Выберите язык:</td>
<td align=left width=500><select class=for name=lang5 size=1>
<option selected value=\"$lang5\">$lang5</option>
<option value=\"Английский\">Английский</option>
<option value=\"Немецкий\">Немецкий</option>
<option value=\"Французский\">Французский</option>
<option value=\"Испанский\">Испанский</option>
<option value=\"Китайский\">Китайский</option>
<option value=\"Итальянский\">Итальянский</option>
<option value=\"Арабский\">Арабский</option>
<option value=\"Иврит\">Иврит</option>
<option value=\"Корейский\">Корейский</option>
<option value=\"Турецкий\">Турецкий</option>
<option value=\"Финский\">Финский</option>
<option value=\"Шведский\">Шведский</option>
<option value=\"Японский\">Японский</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=left valign=top>Уровень знаний:</td>
<td align=left><select class=for name=lang5uroven size=1>
<option selected value=\"$lang5uroven\">$lang5uroven</option>
<option value=\"Элементарный&nbsp;(Elementary)\">Элементарный&nbsp;(Elementary)</option>
<option value=\"Ниже&nbsp;среднего&nbsp;(Pre-Intermediate)\">Ниже&nbsp;среднего&nbsp;(Pre-Intermediate)</option>
<option value=\"Средний&nbsp;(Intermediate)\">Средний&nbsp;(Intermediate)</option>
<option value=\"Выше&nbsp;среднего&nbsp;(Upper-Intermediate)\">Выше&nbsp;среднего&nbsp;(Upper-Intermediate)</option>
<option value=\"Высший&nbsp;(Advanced)\">Высший&nbsp;(Advanced)</option>
</select></td></tr>
</table>
</div>


</p> 		</p>  



<table width=100% border=0 class=\"navig\">
  <tr>
    <td><div class=\"shag\"><a href=\"#pojel\">Назад</a></div></td>
     <td><div class=\"apShag\"><a href=\"#opit\">Далее</a></div></td>
  </tr>
</table>

</div>

<div class=\"les\">
<h2 class=\"sozd\">Опыт работы</h2>

<p>
<table width=800 cellpadding=4 cellspacing=10>
<tr bgcolor=$maincolor><td align=left width=300>Организация:</td>
<td align=left width=500><input type=text class=for name=expir1org size=30 value=\"$expir1org\"></td></tr>
<tr bgcolor=$maincolor><td align=left>Период работы:</td>
<td align=left>с <select class=for name=expir1perfmonth size=1>
<option selected value=\"$expir1perfmonth\">$expir1perfmonth</option>
<option value=\"январь\">январь</option>
<option value=\"февраль\">февраль</option>
<option value=\"март\">март</option>
<option value=\"апрель\">апрель</option>
<option value=\"май\">май</option>
<option value=\"июнь\">июнь</option>
<option value=\"июль\">июль</option>
<option value=\"август\">август</option>
<option value=\"сентябрь\">сентябрь</option>
<option value=\"октябрь\">октябрь</option>
<option value=\"ноябрь\">ноябрь</option>
<option value=\"декабрь\">декабрь</option>
</select> <input type=text class=for name=expir1perfyear size=4 value=\"$expir1perfyear\">&nbsp;&nbsp;&nbsp;&nbsp;
по <select class=for name=expir1pertmonth size=1>
<option selected value=\"$expir1pertmonth\">$expir1pertmonth</option>
<option value=\"наст.время\">наст.время</option>
<option value=\"январь\">январь</option>
<option value=\"февраль\">февраль</option>
<option value=\"март\">март</option>
<option value=\"апрель\">апрель</option>
<option value=\"май\">май</option>
<option value=\"июнь\">июнь</option>
<option value=\"июль\">июль</option>
<option value=\"август\">август</option>
<option value=\"сентябрь\">сентябрь</option>
<option value=\"октябрь\">октябрь</option>
<option value=\"ноябрь\">ноябрь</option>
<option value=\"декабрь\">декабрь</option>
</select> <input type=text class=for name=expir1pertyear size=4 value=\"$expir1pertyear\"><br>

</td></tr>
<tr bgcolor=$maincolor><td align=left>Занимаемая должность:</td>
<td align=left><input type=text class=for name=expir1dol size=30 value=\"$expir1dol\"></td></tr>
<tr bgcolor=$maincolor><td align=left>Ваши обязанности:</td>
<td align=left><textarea class=arria rows=5 name=expir1obyaz cols=40>$expir1obyaz</textarea><br>
<br><small>Кратко опишите ваши обязанности за время работы в данной организации</small>
</td></tr>
</table>
");

$lastexpir=1;
if ($expir2org != '' or $expir2perfmonth != '' or $expir2perfyear != '' or $expir2pertmonth != '' or $expir2pertyear != '' or $expir2dol != '' or $expir2obyaz != '') 
{
$style2expir='';
$style1butexp="style=\"display : none;\"";
$lastexpir=2;
}
elseif ($expir2org == '' and $expir2perfmonth == '' and $expir2perfyear == '' and $expir2pertmonth == '' and $expir2pertyear == '' and $expir2dol == '' and $expir2obyaz == '') 
{
$style2expir="style=\"display : none;\"";
$style1butexp='';
$lastexpir=1;
}
if ($expir3org != '' or $expir3perfmonth != '' or $expir3perfyear != '' or $expir3pertmonth != '' or $expir3pertyear != '' or $expir3dol != '' or $expir3obyaz != '') 
{
$style3expir='';
$style2butexp="style=\"display : none;\"";
$lastexpir=3;
}
elseif ($expir3org == '' and $expir3perfmonth == '' and $expir3perfyear == '' and $expir3pertmonth == '' and $expir3pertyear == '' and $expir3dol == '' and $expir3obyaz == '') 
{
$style3expir="style=\"display : none;\"";
$style2butexp="style=\"display : none;\"";
}
if ($expir4org != '' or $expir4perfmonth != '' or $expir4perfyear != '' or $expir4pertmonth != '' or $expir4pertyear != '' or $expir4dol != '' or $expir4obyaz != '') 
{
$style4expir='';
$style3butexp="style=\"display : none;\"";
$lastexpir=4;
}
elseif ($expir4org == '' and $expir4perfmonth == '' and $expir4perfyear == '' and $expir4pertmonth == '' and $expir4pertyear == '' and $expir4dol == '' and $expir4obyaz == '') 
{
$style4expir="style=\"display : none;\"";
$style3butexp="style=\"display : none;\"";
}
if ($expir5org != '' or $expir5perfmonth != '' or $expir5perfyear != '' or $expir5pertmonth != '' or $expir5pertyear != '' or $expir5dol != '' or $expir5obyaz != '') 
{
$style5expir='';
$style4butexp="style=\"display : none;\"";
}
elseif ($expir5org == '' and $expir5perfmonth == '' and $expir5perfyear == '' and $expir5pertmonth == '' and $expir5pertyear == '' and $expir5dol == '' and $expir5obyaz == '') 
{
$style5expir="style=\"display : none;\"";
$style4butexp="style=\"display : none;\"";
}
if ($lastexpir == 1) {$style1butexp="";}
if ($lastexpir == 2) {$style2butexp="";}
if ($lastexpir == 3) {$style3butexp="";}
if ($lastexpir == 4) {$style4butexp="";}

echo ("
<div id=butexp1 $style1butexp>
<input name=submit type=button class=i3 value=\"Добавить новое место работы\" onclick=\"Hide('butexp1');Shw('expir2');Shw('butexp2');\">
</div>

<div id=expir2 $style2expir>
<table width=800 cellpadding=4 cellspacing=10>
<tr bgcolor=$maincolor><td colspan=2><br></td></tr>
<tr bgcolor=$maincolor><td align=left width=300>Организация:</td>
<td align=left  width=500><input type=text class=for name=expir2org size=30 value=\"$expir2org\"></td></tr>
<tr bgcolor=$maincolor><td align=left>Период работы:</td>
<td align=left>с <select class=for name=expir2perfmonth size=1>
<option selected value=\"$expir2perfmonth\">$expir2perfmonth</option>
<option value=\"январь\">январь</option>
<option value=\"февраль\">февраль</option>
<option value=\"март\">март</option>
<option value=\"апрель\">апрель</option>
<option value=\"май\">май</option>
<option value=\"июнь\">июнь</option>
<option value=\"июль\">июль</option>
<option value=\"август\">август</option>
<option value=\"сентябрь\">сентябрь</option>
<option value=\"октябрь\">октябрь</option>
<option value=\"ноябрь\">ноябрь</option>
<option value=\"декабрь\">декабрь</option>
</select> <input type=text class=for name=expir2perfyear size=4 value=\"$expir2perfyear\">&nbsp;&nbsp;&nbsp;&nbsp;
по <select class=for name=expir2pertmonth size=1>
<option selected value=\"$expir2pertmonth\">$expir2pertmonth</option>
<option value=\"наст.время\">наст.время</option>
<option value=\"январь\">январь</option>
<option value=\"февраль\">февраль</option>
<option value=\"март\">март</option>
<option value=\"апрель\">апрель</option>
<option value=\"май\">май</option>
<option value=\"июнь\">июнь</option>
<option value=\"июль\">июль</option>
<option value=\"август\">август</option>
<option value=\"сентябрь\">сентябрь</option>
<option value=\"октябрь\">октябрь</option>
<option value=\"ноябрь\">ноябрь</option>
<option value=\"декабрь\">декабрь</option>
</select> <input type=text class=for name=expir2pertyear size=4 value=\"$expir2pertyear\"><br>

</td></tr>
<tr bgcolor=$maincolor><td align=left>Занимаемая должность:</td>
<td align=left><input type=text class=for name=expir2dol size=30 value=\"$expir2dol\"></td></tr>
<tr bgcolor=$maincolor><td align=left>Ваши обязанности:</td>
<td align=left><textarea class=arria rows=5 name=expir2obyaz cols=40>$expir2obyaz</textarea><br>
<br><small>Кратко опишите ваши обязанности за время работы в данной организации</small>
</td></tr>
</table>
</div>

<div id=butexp2 $style2butexp>
<input name=submit type=button class=i3 value=\"Добавить новое место работы\" onclick=\"Hide('butexp2');Shw('expir3');Shw('butexp3');\">
</div>

<div id=expir3 $style3expir>
<table width=800 cellpadding=4 cellspacing=10>
<tr bgcolor=$maincolor><td colspan=2><br></td></tr>
<tr bgcolor=$maincolor><td align=left width=300>Организация:</td>
<td align=left width=500><input type=text class=for name=expir3org size=30 value=\"$expir3org\"></td></tr>
<tr bgcolor=$maincolor><td align=left>Период работы:</td>
<td align=left>с <select class=for name=expir3perfmonth size=1>
<option selected value=\"$expir3perfmonth\">$expir3perfmonth</option>
<option value=\"январь\">январь</option>
<option value=\"февраль\">февраль</option>
<option value=\"март\">март</option>
<option value=\"апрель\">апрель</option>
<option value=\"май\">май</option>
<option value=\"июнь\">июнь</option>
<option value=\"июль\">июль</option>
<option value=\"август\">август</option>
<option value=\"сентябрь\">сентябрь</option>
<option value=\"октябрь\">октябрь</option>
<option value=\"ноябрь\">ноябрь</option>
<option value=\"декабрь\">декабрь</option>
</select> <input type=text class=for name=expir3perfyear size=4 value=\"$expir3perfyear\">&nbsp;&nbsp;&nbsp;&nbsp;
по <select class=for name=expir3pertmonth size=1>
<option selected value=\"$expir3pertmonth\">$expir3pertmonth</option>
<option value=\"наст.время\">наст.время</option>
<option value=\"январь\">январь</option>
<option value=\"февраль\">февраль</option>
<option value=\"март\">март</option>
<option value=\"апрель\">апрель</option>
<option value=\"май\">май</option>
<option value=\"июнь\">июнь</option>
<option value=\"июль\">июль</option>
<option value=\"август\">август</option>
<option value=\"сентябрь\">сентябрь</option>
<option value=\"октябрь\">октябрь</option>
<option value=\"ноябрь\">ноябрь</option>
<option value=\"декабрь\">декабрь</option>
</select> <input type=text class=for name=expir3pertyear size=4 value=\"$expir3pertyear\"><br>

</td></tr>
<tr bgcolor=$maincolor><td align=left>Занимаемая должность:</td>
<td align=left><input type=text class=for name=expir3dol size=30 value=\"$expir3dol\"></td></tr>
<tr bgcolor=$maincolor><td align=left>Ваши обязанности:</td>
<td align=left><textarea class=arria rows=5 name=expir3obyaz cols=40>$expir3obyaz</textarea><br>
<br><small>Кратко опишите ваши обязанности за время работы в данной организации</small>
</td></tr>
</table>
</div>

<div id=butexp3 $style3butexp>
<input name=submit type=button class=i3 value=\"Добавить новое место работы (можно еще 2)\" onclick=\"Hide('butexp3');Shw('expir4');Shw('butexp4');\">
</div>

<div id=expir4 $style4expir>
<table width=800 cellpadding=4 cellspacing=10>
<tr bgcolor=$maincolor><td colspan=2><br></td></tr>
<tr bgcolor=$maincolor><td align=left width=300>Организация:</td>
<td align=left width=500><input type=text class=for name=expir4org size=30 value=\"$expir4org\"></td></tr>
<tr bgcolor=$maincolor><td align=left>Период работы:</td>
<td align=left>с <select class=for name=expir4perfmonth size=1>
<option selected value=\"$expir4perfmonth\">$expir4perfmonth</option>
<option value=\"январь\">январь</option>
<option value=\"февраль\">февраль</option>
<option value=\"март\">март</option>
<option value=\"апрель\">апрель</option>
<option value=\"май\">май</option>
<option value=\"июнь\">июнь</option>
<option value=\"июль\">июль</option>
<option value=\"август\">август</option>
<option value=\"сентябрь\">сентябрь</option>
<option value=\"октябрь\">октябрь</option>
<option value=\"ноябрь\">ноябрь</option>
<option value=\"декабрь\">декабрь</option>
</select> <input type=text class=for name=expir4perfyear size=4 value=\"$expir4perfyear\">&nbsp;&nbsp;&nbsp;&nbsp;
по <select class=for name=expir4pertmonth size=1>
<option selected value=\"$expir4pertmonth\">$expir4pertmonth</option>
<option value=\"наст.время\">наст.время</option>
<option value=\"январь\">январь</option>
<option value=\"февраль\">февраль</option>
<option value=\"март\">март</option>
<option value=\"апрель\">апрель</option>
<option value=\"май\">май</option>
<option value=\"июнь\">июнь</option>
<option value=\"июль\">июль</option>
<option value=\"август\">август</option>
<option value=\"сентябрь\">сентябрь</option>
<option value=\"октябрь\">октябрь</option>
<option value=\"ноябрь\">ноябрь</option>
<option value=\"декабрь\">декабрь</option>
</select> <input type=text class=for name=expir4pertyear size=4 value=\"$expir4pertyear\"><br>

</td></tr>
<tr bgcolor=$maincolor><td align=left>Занимаемая должность:</td>
<td align=left><input type=text class=for name=expir4dol size=30 value=\"$expir4dol\"></td></tr>
<tr bgcolor=$maincolor><td align=left>Ваши обязанности:</td>
<td align=left><textarea class=arria rows=5 name=expir4obyaz cols=40>$expir4obyaz</textarea><br>
<br><small>Кратко опишите ваши обязанности за время работы в данной организации</small>
</td></tr>
</table>
</div>

<div id=butexp4 $style4butexp>
<input name=submit type=button class=i3 value=\"Добавить новое место работы (можно еще 1)\" onclick=\"Hide('butexp4');Shw('expir5');\">
</div>

<div id=expir5 $style5expir>
<table width=800 cellpadding=4 cellspacing=10>
<tr bgcolor=$maincolor><td colspan=2><br></td></tr>
<tr bgcolor=$maincolor><td align=left width=300>Организация:</td>
<td align=left width=500><input type=text class=for name=expir5org size=30 value=\"$expir5org\"></td></tr>
<tr bgcolor=$maincolor><td align=left>Период работы:</td>
<td align=left>с <select class=for name=expir5perfmonth size=1>
<option selected value=\"$expir5perfmonth\">$expir5perfmonth</option>
<option value=\"январь\">январь</option>
<option value=\"февраль\">февраль</option>
<option value=\"март\">март</option>
<option value=\"апрель\">апрель</option>
<option value=\"май\">май</option>
<option value=\"июнь\">июнь</option>
<option value=\"июль\">июль</option>
<option value=\"август\">август</option>
<option value=\"сентябрь\">сентябрь</option>
<option value=\"октябрь\">октябрь</option>
<option value=\"ноябрь\">ноябрь</option>
<option value=\"декабрь\">декабрь</option>
</select> <input type=text class=for name=expir5perfyear size=4 value=\"$expir5perfyear\">&nbsp;&nbsp;&nbsp;&nbsp;
по <select class=for name=expir5pertmonth size=1>
<option selected value=\"$expir5pertmonth\">$expir5pertmonth</option>
<option value=\"наст.время\">наст.время</option>
<option value=\"январь\">январь</option>
<option value=\"февраль\">февраль</option>
<option value=\"март\">март</option>
<option value=\"апрель\">апрель</option>
<option value=\"май\">май</option>
<option value=\"июнь\">июнь</option>
<option value=\"июль\">июль</option>
<option value=\"август\">август</option>
<option value=\"сентябрь\">сентябрь</option>
<option value=\"октябрь\">октябрь</option>
<option value=\"ноябрь\">ноябрь</option>
<option value=\"декабрь\">декабрь</option>
</select> <input type=text class=for name=expir5pertyear size=4 value=\"$expir5pertyear\"><br>
</td></tr>
<tr bgcolor=$maincolor><td align=left>Занимаемая должность:</td>
<td align=left><input type=text class=for name=expir5dol size=30 value=\"$expir5dol\"></td></tr>
<tr bgcolor=$maincolor><td align=left>Ваши обязанности:</td>
<td align=left><textarea class=arria rows=5 name=expir5obyaz cols=40>$expir5obyaz</textarea><br>
<br><small>Кратко опишите ваши обязанности за время работы в данной организации</small>
</td></tr>
<tr bgcolor=$maincolor><td colspan=2><br></td></tr>
</table>
</div>

</p>
<table width=100% border=0 class=\"navig\">
  <tr>
    <td><div class=\"shag\"><a href=\"#obr\">Назад</a></div></td>
     <td><div class=\"apShag\"><a href=\"#dopinfo\">Далее</a></div></td>
  </tr>
</table>  


</div>

<div class=\"les\">
<h2 class=\"sozd\">Дополнительная информация</h2>

<p><table width=800 cellpadding=4 cellspacing=10>
");
if ($who=='agency') {
echo ("
<tr bgcolor=$maincolor><td align=left><font color=#FF0000>*</font>ФИО соискателя:</td>
<td align=left><input type=text class=for name=fio size=30 value=\"$fio\"></td></tr>
<tr bgcolor=$maincolor><td align=left valign=top><font color=#FF0000>*</font>Дата рождения:</td>
<td align=left><select class=for name=bday size=1>
        <option selected value=$bday>$bday</option>
        <option    value=01>01</option>
        <option    value=02>02</option>
        <option    value=03>03</option>
        <option    value=04>04</option>
        <option    value=05>05</option>
        <option    value=06>06</option>
        <option    value=07>07</option>
        <option    value=08>08</option>
        <option    value=09>09</option>
        <option    value=10>10</option>
        <option    value=11>11</option>
        <option    value=12>12</option>
        <option    value=13>13</option>
        <option    value=14>14</option>
        <option    value=15>15</option>
        <option    value=16>16</option>
        <option    value=17>17</option>
        <option    value=18>18</option>
        <option    value=19>19</option>
        <option    value=20>20</option>
        <option    value=21>21</option>
        <option    value=22>22</option>
        <option    value=23>23</option>
        <option    value=24>24</option>
        <option    value=25>25</option>
        <option    value=26>26</option>
        <option    value=27>27</option>
        <option    value=28>28</option>
        <option    value=29>29</option>
        <option    value=30>30</option>
        <option    value=31>31</option>
</select>&nbsp;
<select class=for name=bmonth size=1>
        <option selected value=$bmonth>$bmonth</option>
        <option value=01>01</option>
        <option value=02>02</option>
        <option value=03>03</option>
        <option value=04>04</option>
        <option value=05>05</option>
        <option value=06>06</option>
        <option value=07>07</option>
        <option value=08>08</option>
        <option value=09>09</option>
        <option value=10>10</option>
        <option value=11>11</option>
        <option value=12>12</option>
</select>&nbsp;
<select class=for name=byear size=1>
        <option selected value=$byear>$byear</option>
        <option value=1900>1900</option>
        <option value=1901>1901</option>
        <option value=1902>1902</option>
        <option value=1903>1903</option>
        <option value=1904>1904</option>
        <option value=1905>1905</option>
        <option value=1906>1906</option>
        <option value=1907>1907</option>
        <option value=1908>1908</option>
        <option value=1909>1909</option>
        <option value=1910>1910</option>
        <option value=1911>1911</option>
        <option value=1912>1912</option>
        <option value=1913>1913</option>
        <option value=1914>1914</option>
        <option value=1915>1915</option>
        <option value=1916>1916</option>
        <option value=1917>1917</option>
        <option value=1918>1918</option>
        <option value=1919>1919</option>
        <option value=1920>1920</option>
        <option value=1921>1921</option>
        <option value=1922>1922</option>
        <option value=1923>1923</option>
        <option value=1924>1924</option>
        <option value=1925>1925</option>
        <option value=1926>1926</option>
        <option value=1927>1927</option>
        <option value=1928>1928</option>
        <option value=1929>1929</option>
        <option value=1930>1930</option>
        <option value=1931>1931</option>
        <option value=1932>1932</option>
        <option value=1933>1933</option>
        <option   value=1934>1934</option>
        <option   value=1935>1935</option>
        <option   value=1936>1936</option>
        <option   value=1937>1937</option>
        <option   value=1938>1938</option>
        <option   value=1939>1939</option>
        <option   value=1940>1940</option>
        <option   value=1941>1941</option>
        <option   value=1942>1942</option>
        <option   value=1943>1943</option>
        <option   value=1944>1944</option>
        <option   value=1945>1945</option>
        <option   value=1946>1946</option>
        <option   value=1947>1947</option>
        <option   value=1948>1948</option>
        <option   value=1949>1949</option>
        <option   value=1950>1950</option>
        <option   value=1951>1951</option>
        <option   value=1952>1952</option>
        <option   value=1953>1953</option>
        <option   value=1954>1954</option>
        <option   value=1955>1955</option>
        <option   value=1956>1956</option>
        <option   value=1957>1957</option>
        <option   value=1958>1958</option>
        <option   value=1959>1959</option>
        <option   value=1960>1960</option>
        <option   value=1961>1961</option>
        <option   value=1962>1962</option>
        <option   value=1963>1963</option>
        <option   value=1964>1964</option>
        <option   value=1965>1965</option>
        <option   value=1966>1966</option>
        <option   value=1967>1967</option>
        <option   value=1968>1968</option>
        <option   value=1969>1969</option>
        <option   value=1970>1970</option>
        <option   value=1971>1971</option>
        <option   value=1972>1972</option>
        <option   value=1973>1973</option>
        <option   value=1974>1974</option>
        <option   value=1975>1975</option>
        <option   value=1976>1976</option>
        <option   value=1977>1977</option>
        <option   value=1978>1978</option>
        <option   value=1979>1979</option>
        <option   value=1980>1980</option>
        <option   value=1981>1981</option>
        <option   value=1982>1982</option>
        <option   value=1983>1983</option>
        <option   value=1984>1984</option>
        <option   value=1985>1985</option>
        <option   value=1986>1986</option>
        <option   value=1987>1987</option>
        <option   value=1988>1988</option>
        <option   value=1989>1989</option>
        <option   value=1990>1990</option>
        <option   value=1991>1991</option>
        <option   value=1992>1992</option>
        <option   value=1993>1993</option>
        <option   value=1994>1994</option>
        <option   value=1995>1995</option>
        <option   value=1996>1996</option>
        <option   value=1997>1997</option>
        <option   value=1998>1998</option>
        <option   value=1999>1999</option>
        <option   value=2000>2000</option>
</select><br><small>день&nbsp;&nbsp;&nbsp;месяц&nbsp;&nbsp;&nbsp;год</small></td></tr>
<tr bgcolor=$maincolor><td align=left>Пол:</td>
<td align=left><select class=for name=gender size=1>
<option selected value=\"$gender\">$gender</option>
<option value=\"Мужской\">Мужской</option>
<option value=\"Женский\">Женский</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=left>Семейное положение:</td>
<td align=left><select class=for name=family size=1>
<option selected value=\"$family\">$family</option>
<option value=\"Не&nbsp;состою&nbsp;в&nbsp;браке,&nbsp;детей&nbsp;нет\">Не&nbsp;состою&nbsp;в&nbsp;браке,&nbsp;детей&nbsp;нет</option>
<option value=\"Не&nbsp;состою&nbsp;в&nbsp;браке,&nbsp;дети&nbsp;есть\">Не&nbsp;состою&nbsp;в&nbsp;браке,&nbsp;дети&nbsp;есть</option>
<option value=\"Состою&nbsp;в&nbsp;браке,&nbsp;детей&nbsp;нет\">Состою&nbsp;в&nbsp;браке,&nbsp;детей&nbsp;нет</option>
<option value=\"Состою&nbsp;в&nbsp;браке,&nbsp;дети&nbsp;есть\">Состою&nbsp;в&nbsp;браке,&nbsp;дети&nbsp;есть</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=left>Гражданство:</td>
<td align=left><input type=text class=for name=civil size=30 value=\"$civil\"></td></tr>
<tr bgcolor=$maincolor><td align=left valign=top><font color=#FF0000>*</font>Профессиональные навыки и знания:</td>
<td align=left><textarea class=arria rows=7 name=prof cols=50>$prof</textarea><br><small>Эта информация будет отображаться в кратком резюме.</small></td></tr>
<tr bgcolor=$maincolor><td align=left valign=top>Дополнительные сведения:</td>
<td align=left><textarea class=arria rows=7 name=dopsved cols=50>$dopsved</textarea><br><small>Ваши увлечения, занятия в свободное время, круг интересов и т.п.</small></td></tr>
<tr bgcolor=$maincolor><td colspan=2 valign=top>
Вы можете также разместить фотографию соискателя. Для размещения фотографии, нажмите кнопку \"Обзор\" и выберите фотографию.<br><b>Примечание: Фотография обязательно должна иметь расширение *.jpg либо *.gif и иметь размер не более $MAX_FILE_SIZE байт.!</b></p>
</td></tr>
<tr bgcolor=$maincolor><td colspan=2>
Фото: <input type=file name=file1 size=30><br><br>
</td></tr>
");
}
echo ("
<tr bgcolor=$maincolor><td align=left valign=top>Дополнительная информация:<br>(не более 1000 симв.)</td>
<td align=left><textarea class=arria rows=7 name=comment cols=50>$comment</textarea></td></tr>
<tr bgcolor=$maincolor><td align=left><font color=#FF0000>*</font>Период размещения:</td>
<td align=left><select class=for name=period size=1>
<option selected value=$period>$period</option>
<option value=10>10</option>
<option value=30>30</option>
<option value=60>60</option>
<option value=90>90</option>
</select>&nbsp;дней</td></tr>
");
if ($imgobyavlconfirm == 'TRUE')
{ // img conf
echo "<tr bgcolor=$maincolor><td align=left valign=top><font color=#FF0000>*</font>Код на картинке:&nbsp;";
echo "<img src=code.php>";
echo "</td><td align=left><input type=text class=for name=number size=20></td></tr>";
} // img conf
echo ("
</table>

</p>

<table width=100% border=0 class=\"navig\">
  <tr>
    <td><div class=\"shag\"><a href=\"#opit\">Назад</a></div></td>
     <td><div class=\"apShag\"><input type=submit value=\"Опубликовать\" name=\"submit\" class=dob id=dobpadd></div></td>
  </tr>
</table>  


</div>
");
echo "</form></div>";
}
else {
echo "<br><h1>Ваше резюме добавлено!</h1><br>$stroka<br><br><p ><a href=autor.php>Вернуться в авторский раздел</a></p><br><br>";
$txt="На сайте $siteadress - новое резюме.";
if ($mailadditem == 'TRUE')
{mail($adminemail,"Новое резюме",$txt,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/plain; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");}
}
} // проверка1
} //bunip
}//1
?>

<script> $(function() {	$("ul.tabs").tabs("div.panes > div");});</script>

<?
include("down.php");
?>