<?
session_start();
session_register("spass");
session_register("slogin");
session_register("sid");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!--/***************** DO NOT REMOVE! *********************/---->
<!--/*   Author: Nevezhyn Evgeny  Date : 11/06/2005       */---->
<!--/*   nevius@bk.ru      All Rights Reserved ...        */---->
<!--/*   http://nevius.ru/                                */---->
<!--/***************** DO NOT MODIFY! *********************/---->

<?php
echo "<head>";
include("var.php");
echo"<title>����������� : $sitename</title>";
include("top.php");
// �������� ���������������� �����������
$delold=mysql_query("delete from $autortable where status='wait' and ((date + INTERVAL 86400*$delnotconfirm SECOND) < now())");
// �������� ���������������� �����������
?>

<SCRIPT>
function Hide(d) {document.getElementById(d).style.display = 'none';}
function Shw(d) {document.getElementById(d).style.display = 'block';}
</SCRIPT>

<div class=tbl1>
<h3 align=left><strong>�����������</strong></left></h3>
<form name="form" method="post" ENCTYPE="multipart/form-data" action="registr.php?add">
<?php
if ($_FILES['file1']['name'] == 'none') {$file1 = '';}
if ($_FILES['file1']['name'] != '') {$file1 = $_FILES['file1']['name'];}
if ($_FILES['file2']['name'] == 'none') {$file2 = '';}
if ($_FILES['file2']['name'] != '') {$file2 = $_FILES['file2']['name'];}
if ($ident == 'session') {$REMOTE_ADDR=$PHPSESSID;}
if ($ident != 'session') {$REMOTE_ADDR=$_SERVER['REMOTE_ADDR'];}
$delip=mysql_query("delete from $bunsiptable where (((date + INTERVAL 86400*period SECOND) < now()) and period != '')");
$delwaiter=mysql_query("delete from $autortable where (((date + INTERVAL 86400*10 SECOND) < now()) and status = 'wait')");
$maxname = 50;
$maxemail = 100;
$maxpass = 20;
$maxfirm = 100;
$maxfio = 100;
$maxadress = 200;
$maxtelephone = 100;
$maxurl = 100;
$maxciv = 30;
$maxprof = 500;
$maxdopsved = 1000;
$maxdeyat = 1000;
$err2 = "E-mail ������ ���� �� ������ $maxemail ��������<br>";
$err3 = "������ ������ ���� �� ������ $maxpass ��������<br>";
$err4 = "�������� ����� ������ ���� �� ������ $maxfirm ��������<br>";
$err5 = "���� ���������� ���� ������ ���� �� ������ $maxfio ��������<br>";
$err7 = "����������� ������ ���� �� ������ $maxciv ��������<br>";
$err8 = "����� ������ ���� �� ������ $maxadress ��������<br>";
$err9 = "������� ������ ���� �� ������ $maxtelephone ��������<br>";
$err10 = "����� ����� ������ ���� �� ������ $maxurl ��������<br>";
$err115 = "���� ����.������ ������ ���� �� ������ $maxprof ��������<br>";
$err116 = "���� �������������� �������� ������ ���� �� ������ $maxdopsved ��������<br>";

$err12 = "�� ��������� ������������ ���� - E-mail!<br>";
$err13 = "�� ��������� ������������ ���� - ������!<br>";
$err14 = "�� ��������� ������������ ���� - ������������� ������<br>";
$err16 = "�� ��������� ������������ ���� - �������� ���������!<br>";
$err17 = "�� ��������� ������������ ���� - �������!<br>";

$err201 = "�� ��������� ������������ ���� - ����������� ������������!<br>";
$err202 = "�� ��������� ������������ ���� - �������� �����!<br>";
$err203 = "�� ��������� ������������ ���� - ���������� ����!<br>";
$err204 = "�� ��������� ������������ ���� - ���� ��������!<br>";
$err205 = "�� ��������� ������������ ���� - ���������������� ������ � ������!<br>";
$err208 = "�� ��������� ������������ ���� - �����!<br>";

$err18 = "���������� ������� ������ ������. ����� ����� ������ � ������������� ������ ������ ���� ��������<br>";
$err19 = "���������� ��������� ������������ E-mail ������<br>";
$err20 = "�������� � ����� email-������� ��� ���������������, �������� ������!<br><br>";
$err21 = "���� ����������� ������������ ������ ���� �� ������ $maxdeyat ��������<br>";
$err22 = "��������, �� ��� ������ ���������������� �� ���� �����! <br>";
$err23 = "������ �� ������ ��������� ��������! <br>";
$err24 = "�� ������ �������� ���!<br>";
$err25 = "����� ��������� ������ ���������� � http://! <br>";
$err26 = "���������� ������ ����� ���������� *.jpg ���� *.gif<br>";
$err27 = "���������� ������ ����� ������ �� ����� $MAX_FILE_SIZE ����!<br>";
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

if (strlen($email) > $maxemail) {$error .= "$err2";}
if (strlen($pass) > $maxpass) {$error .= "$err3";}
if (strlen($passr) > $maxpass) {$error .= "$err3";}
if (strlen($firm) > $maxfirm) {$error .= "$err4";}
if (strlen($fio) > $maxfio) {$error .= "$err5";}
if (strlen($civil) > $maxciv) {$error .= "$err7";}
if (strlen($adress) > $maxadress) {$error .= "$err8";}
if (strlen($telephone) > $maxtelephone) {$error .= "$err9";}
if (strlen($url) > $maxurl) {$error .= "$err10";}
if (strlen($prof) > $maxprof) {$error .= "$err115";}
if (strlen($dopsved) > $maxdopsved) {$error .= "$err116";}
if (strlen($deyat) > $maxdeyat) {$error .= "$err21";}
if ($email == "") {$error .= "$err12";}
if ($pass == "") {$error .= "$err13";}
if ($passr == "") {$error .= "$err14";}
if ($category=='agency' and $firm == "") {$error .= "$err16";}
if (($category=='agency' or $category=='rab') and $telephone == "") {$error .= "$err17";}

if (($category=='agency' or $category=='rab') and $deyat == "") {$error .= "$err201";}
if ($category=='rab' and $firm == "") {$error .= "$err202";}
if ($category != 'user' and $fio == "") {$error .= "$err203";}
if (($category == 'soisk') and ($bday == "" or $bmonth == "" or $byear == "")) {$error .= "$err204";}
if (($category == 'soisk') and $prof == "") {$error .= "$err205";}
if (($category=='agency' or $category=='rab') and $adress == "") {$error .= "$err208";}

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
if ($url != "" and !ereg("http://",$url)) {$error .= "$err25";}

// �����
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
$error .= "�� ��������� ������������ ���� - �����<br>";
}
}
if ($region == "")
{
$result3c = @mysql_query("SELECT * FROM $citytable WHERE razdel='$countrys1' and categ != '' LIMIT 1");
if (@mysql_num_rows($result3c) != 0) {
$error .= "�� ��������� ������������ ���� - �����<br>";
}
}
}
// �����

if ($imgconfirm == 'TRUE' and ($_COOKIE['reg_num'] != $number or $number == '')) {$error .= "$err24";}
if ($file1 != "") {
$file1 = $_FILES['file1']['name'];
$filesize1 = $_FILES['file1']['size']; 
$temp1 = $_FILES['file1']['tmp_name'];
$fileres1=strtolower(basename($file1));
if ($file1 != "" and !eregi("\.jpg$",$fileres1) and !eregi("\.gif$",$fileres1)){$error .= "$err26";}
if ($filesize1 > $MAX_FILE_SIZE){$error .= "$err27";}
}
if ($file2 != "") {
$file2 = $_FILES['file2']['name'];
$filesize2 = $_FILES['file2']['size']; 
$temp2 = $_FILES['file2']['tmp_name'];
$fileres2=strtolower(basename($file2));
if ($file2 != "" and !eregi("\.jpg$",$fileres2) and !eregi("\.gif$",$fileres2)){$error .= "$err26";}
if ($filesize2 > $MAX_FILE_SIZE){$error .= "$err27";}
}
echo "<p align=left><font color=red>$error</font></p>";
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

if ($_SERVER[QUERY_STRING] == "add" and $error == "" and $regconfirm != 'TRUE' and $category=='soisk') {echo "<meta HTTP-EQUIV=\"Refresh\" CONTENT=\"3; URL=addres.php\">";}
if ($_SERVER[QUERY_STRING] == "add" and $error == "") {
$date = date("Y/m/d H:i:s");
$birth="$byear-$bmonth-$bday";
if ($_SERVER[QUERY_STRING] == "add" and $file1 != "" or $file2 != "") {
$result1 = @mysql_query("SELECT ID FROM $autortable order by ID DESC LIMIT 1");
while ($myrow=@mysql_fetch_array($result1)) 
{
$fid=$myrow["ID"];
}
$fid=$fid+1;
$updir=$photodir;
$path1 = $upath."$updir";
$fileres1=@substr($fileres1,-3,3);
$fileres2=@substr($fileres2,-3,3);
$source_name1="";
$source_name2="";
if ($file1 != "") {$source_name1 = "a".$fid."_1.$fileres1";}
if ($file2 != "") {$source_name2 = "a".$fid."_2.$fileres2";}
if($error == ""){
$dest1 = $path1.$source_name1;
$dest2 = $path1.$source_name2;
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
if ($file2 != "") {
@copy("$temp2","$dest2");$foto2=$updir."$source_name2";
if (function_exists('ImageTypes')) {
if ((ImageTypes() & IMG_JPG and $fileres2=='jpg') or (ImageTypes() & IMG_GIF and $fileres2=='gif'))
{ //small img
if ($fileres2=='jpg') {$image = ImageCreateFromJPEG($foto2);}
if ($fileres2=='gif') {$image = ImageCreateFromGIF($foto2);}
$width = imagesx($image) ;
$height = imagesy($image) ;
if ($height > $smalllogoheight) {$new_height = $smalllogoheight;}
elseif ($height <= $smalllogoheight) {$new_height = $height;}
$new_width = ($new_height * $width) / $height ;
$thumb = imagecreate($new_width,$new_height);
$thumb = ImageCreateTrueColor($new_width,$new_height);
imagecopyresized($thumb,$image,0,0,0,0,$new_width,$new_height,$width,$height);
if ($fileres2=='jpg') {ImageJPEG($thumb, $updir.'s'.$source_name2);}
if ($fileres2=='gif') {ImageGIF($thumb, $updir.'s'.$source_name2);}
}} //small img
}
}
}
if ($regconfirm == 'TRUE')
{ // confirm
srand((double)microtime()*1000000);
$code=md5(uniqid(rand()));
$code=@substr($code,1,12);
$sql="insert into $autortable (category,email,country,region,city,telephone,adress,url,fio,firm,birth,gender,family,civil,prof,dopsved,deyat,date,foto1,foto2,pass,ip,status,code,hidemail,edu1sel,edu1school,edu1year,edu1fac,edu1spec,edu2sel,edu2school,edu2year,edu2fac,edu2spec,edu3sel,edu3school,edu3year,edu3fac,edu3spec,edu4sel,edu4school,edu4year,edu4fac,edu4spec,edu5sel,edu5school,edu5year,edu5fac,edu5spec,lang1,lang1uroven,lang2,lang2uroven,lang3,lang3uroven,lang4,lang4uroven,lang5,lang5uroven) values ('$category','$email','$country','$region','$city','$telephone','$adress','$url','$fio','$firm','$birth','$gender','$family','$civil','$prof','$dopsved','$deyat',now(),'$source_name1','$source_name2','$pass','$REMOTE_ADDR','wait','$code','$hidemail','$edu1sel','$edu1school','$edu1year','$edu1fac','$edu1spec','$edu2sel','$edu2school','$edu2year','$edu2fac','$edu2spec','$edu3sel','$edu3school','$edu3year','$edu3fac','$edu3spec','$edu4sel','$edu4school','$edu4year','$edu4fac','$edu4spec','$edu5sel','$edu5school','$edu5year','$edu5fac','$edu5spec','$lang1','$lang1uroven','$lang2','$lang2uroven','$lang3','$lang3uroven','$lang4','$lang4uroven','$lang5','$lang5uroven')";
$codetxt="������������!<br>��� ������ ������� ��� � ����� � ������������ �� ����� <a href=$siteadress>$sitename</a><br><br>��� ���������� ����������� ���������� ������ �� ������:<br><br><a href=\"$siteadress/confirm.php?login=$email&code=$code\">$siteadress/confirm.php?login=$email&code=$code</a><br><br>���� ����� �� �������� <a href=\"$siteadress/confirm.php\">$siteadress/confirm.php</a> � ������ ��������� ������:<br>E-mail: $email<br>��� ���������: $code<br><br>���� �� �� ������ ������� � ��� ���� ����, �� ������ ������� ��� ������.<br><br>������� �� ����������� ����� ������!<br><br>� ���������,<br>$sitename<br><a href=mailto:$adminemail>$adminemail</a><br><a href=$siteadress>$siteadress</a>";
mail($email,"������������� �����������",$codetxt,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/html; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");
$reglineafter="<p align=left>�� ��� email-����� ������� ������ � �������������� �����������!</p><br><br>";
} // confirm
elseif ($regconfirm != 'TRUE')
{ //no confirm reg
$sql="insert into $autortable (category,email,country,region,city,telephone,adress,url,fio,firm,birth,gender,family,civil,prof,dopsved,deyat,date,foto1,foto2,pass,ip,status,hidemail,edu1sel,edu1school,edu1year,edu1fac,edu1spec,edu2sel,edu2school,edu2year,edu2fac,edu2spec,edu3sel,edu3school,edu3year,edu3fac,edu3spec,edu4sel,edu4school,edu4year,edu4fac,edu4spec,edu5sel,edu5school,edu5year,edu5fac,edu5spec,lang1,lang1uroven,lang2,lang2uroven,lang3,lang3uroven,lang4,lang4uroven,lang5,lang5uroven) values ('$category','$email','$country','$region','$city','$telephone','$adress','$url','$fio','$firm','$birth','$gender','$family','$civil','$prof','$dopsved','$deyat',now(),'$source_name1','$source_name2','$pass','$REMOTE_ADDR','user','$hidemail','$edu1sel','$edu1school','$edu1year','$edu1fac','$edu1spec','$edu2sel','$edu2school','$edu2year','$edu2fac','$edu2spec','$edu3sel','$edu3school','$edu3year','$edu3fac','$edu3spec','$edu4sel','$edu4school','$edu4year','$edu4fac','$edu4spec','$edu5sel','$edu5school','$edu5year','$edu5fac','$edu5spec','$lang1','$lang1uroven','$lang2','$lang2uroven','$lang3','$lang3uroven','$lang4','$lang4uroven','$lang5','$lang5uroven')";
if ($category=='rab' or $category=='agency') {
$reglineafter="<p align=left>�������� ���������� ��������:<br><br>";
$reglineafter=$reglineafter."<a href=addvac.php>�������� ��������</a><br><br>";
}
if ($category=='soisk' or $category=='agency') {
$reglineafter="<p align=left><b><big>������ �� ������ �������� ������!</big></b><br><br>";
if ($category=='soisk') {$reglineafter.="����� ��������� ������ �� �������� � ������ ���������� ������. ���� ����� �� ��������� ��������� �� ������ ����:<br><br>";}
$reglineafter=$reglineafter."<a href=addres.php>�������� ������</a><br><br>";
}

$reglineafter=$reglineafter."<a href=autor.php>� ������ ������</a></p>";
} //no confirm reg
$result=@mysql_query($sql,$db);
}
}
if ($_SERVER[QUERY_STRING] != "add" or $error != "") {
if ($category == '')
{
if ($_GET['category'] == '') {$category=$_POST['category'];}
elseif ($_GET['category'] != '') {$category=$_GET['category'];}
}
if ($category=='soisk') {$categ='����������';}
if ($category=='rab') {$categ='������������';}
if ($category=='agency') {$categ='���������';}
if ($category=='user') {$categ='������������';}

if ($_GET['city'] == '') {$city=$_POST['city'];}
elseif ($_GET['city'] != '') {$city=$_GET['city'];}
if ($_GET['region'] == '') {$region=$_POST['region'];}
elseif ($_GET['region'] != '') {$region=$_GET['region'];}
if ($_GET['country'] == '') {$country=$_POST['country'];}
elseif ($_GET['country'] != '') {$country=$_GET['country'];}

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
<p class=star>������������ ���� �������� �������� <font color=#FF0000>*</font></p>
");
if (!isset($category))
{
echo ("
<blockquote><p align=justify>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>������� � �������� ���� �� ������ ������������������</b>:<br>
<li>���� �� ����������, �� ����� ����������� ������� ���������, �������������, �������� ���� ������.<br>
<li>���� �� ������������, �� ����� ����������� ������� ���������, �������������, �������� ��������.<br>
<li>�������� ��������� ����� ������ � �� � ������.<br>
<li>���� �� �� ����������� ��������� �������� ��� ������, �� ������ ����� ������ � ����� ��������, ��� ���������� ��������, �������� �� ��������, �� ����������������� ��� \"������������\".
</p>
</blockquote>
");
}
echo ("
<table width=100%>
<tr><td align=left width=40%><font color=#FF0000>*</font>������������������ ���:</td>
<td><select class=for name=category size=1 onChange=location.href=location.pathname+\"?category=\"+value+\"\";>
<option selected value=\"$category\">$categ</option>
<option value=soisk>����������</option>
<option value=rab>������������</option>
<option value=agency>���������</option>
<option value=user>������������</option>
</select></td></tr>
");
if (isset($category) and $category != '')
{ //categ

echo ("
<tr><td valign=top align=left><font color=#FF0000>*</font>������:</td>
<td valign=top align=left>
<select class=for name=country size=1 onChange=location.href=location.pathname+\"?category=$category&country=\"+value+\"\";>
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
{ // ������
$result1 = @mysql_query("SELECT * FROM $citytable WHERE razdel='$countrys' and podrazdel != '' and categ='' order by podrazdel");
if (@mysql_num_rows($result1) != 0)
{ // ���� ������
echo ("
<tr><td valign=top align=left><font color=#FF0000>*</font>������:</td>
<td valign=top align=left><select class=for name=region size=1 onChange=location.href=location.pathname+\"?category=$category&country=$country&region=\"+value+\"\";>
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
{ // ������
$result4 = @mysql_query("SELECT * FROM $citytable WHERE podrazdel = '$regions' and razdel='$countrys' and categ != '' order by categ");
if (@mysql_num_rows($result4) != 0) {
echo ("
<tr><td valign=top align=left><font color=#FF0000>*</font>�����:</td>
<td valign=top align=left><select class=for name=city size=1>
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
} // ������
} // ���� ������
elseif (@mysql_num_rows($result1) == 0)
{ // ��� �������
$result4 = @mysql_query("SELECT * FROM $citytable WHERE podrazdel = '$regions' and razdel='$countrys' and categ != '' order by categ");
if (@mysql_num_rows($result4) != 0) {
echo ("
<tr><td valign=top align=left><font color=#FF0000>*</font>�����:</td>
<td valign=top align=left><select class=for name=city size=1>
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
} // ��� �������
} // ������

if ($category == 'agency') {
echo ("
<tr><td align=left width=40%><font color=#FF0000>*</font>�������� ���������:</td>
<td><input type=text class=for name=firm size=30 value=\"$firm\"></td></tr>
<tr><td align=left width=40% valign=top><font color=#FF0000>*</font>����������� ������������:</td>
<td><textarea class=arria rows=7 name=deyat cols=50>$deyat</textarea></td></tr>
");
}
if ($category == 'rab') {
echo ("
<tr><td align=left width=40%><font color=#FF0000>*</font>�������� ����� (���� ����):</td>
<td><input type=text class=for name=firm size=30 value=\"$firm\"></td></tr>
<tr><td align=left width=40% valign=top><font color=#FF0000>*</font>����������� ������������:</td>
<td><textarea class=arria rows=7 name=deyat cols=50>$deyat</textarea></td></tr>
");
}
if ($category != 'user') {
echo ("
<tr><td align=left width=40%><font color=#FF0000>*</font>���������� ����:</td>
<td><input type=text class=for name=fio size=30 value=\"$fio\"></td></tr>
");
}
if ($category=='soisk') {
echo ("
<tr><td align=left width=40% valign=top><font color=#FF0000>*</font>���� ��������:</td>
<td><select class=for name=bday size=1>
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
</select><br><small>����&nbsp;&nbsp;&nbsp;�����&nbsp;&nbsp;&nbsp;���</small></td></tr>
<tr><td align=left width=40%>���:</td>
<td><select class=for name=gender size=1>
<option selected value=\"$gender\">$gender</option>
<option value=\"�������\">�������</option>
<option value=\"�������\">�������</option>
</select></td></tr>
<tr><td align=left width=40%>�������� ���������:</td>
<td><select class=for name=family size=1>
<option selected value=\"$family\">$family</option>
<option value=\"��&nbsp;������&nbsp;�&nbsp;�����,&nbsp;�����&nbsp;���\">��&nbsp;������&nbsp;�&nbsp;�����,&nbsp;�����&nbsp;���</option>
<option value=\"��&nbsp;������&nbsp;�&nbsp;�����,&nbsp;����&nbsp;����\">��&nbsp;������&nbsp;�&nbsp;�����,&nbsp;����&nbsp;����</option>
<option value=\"������&nbsp;�&nbsp;�����,&nbsp;�����&nbsp;���\">������&nbsp;�&nbsp;�����,&nbsp;�����&nbsp;���</option>
<option value=\"������&nbsp;�&nbsp;�����,&nbsp;����&nbsp;����\">������&nbsp;�&nbsp;�����,&nbsp;����&nbsp;����</option>
</select></td></tr>
<tr><td align=left width=40%>�����������:</td>
<td><input type=text class=for name=civil size=30 value=\"$civil\"></td></tr>
<tr><td align=left width=40% valign=top><font color=#FF0000>*</font>���������������� ������ � ������:</td>
<td><textarea class=arria rows=7 name=prof cols=50>$prof</textarea><br>
<p>
<small>��� ���������� ����� ������������ � ������� ������.</small></p></td></tr>
<tr><td align=left width=40% valign=top>�������������� ��������:</td>
<td><textarea class=arria rows=7 name=dopsved cols=50>$dopsved</textarea><br><small>���� ���������, ������� � ��������� �����, ���� ��������� � �.�.</small></td></tr>
");
}
  
if ($category != 'user') {
echo ("
<tr><td align=left width=40%>
");
if ($category=='rab' or $category == 'agency') {echo "<font color=#FF0000>*</font>";}
echo ("
�������:</td>
<td><input type=text class=for name=telephone size=30 value=\"$telephone\"></td></tr>
");
}
if ($category=='rab' or $category == 'agency') {
echo ("
<tr><td align=left width=40%><font color=#FF0000>*</font>�����:</td>
<td><input type=text class=for name=adress size=30 value=\"$adress\"><br><small>��� ����������� ����������� ����� �� ����� ��������� ���� � �������: �����, ���/������</small></td></tr>
<tr><td align=left width=40%>URL:</td>
<td><input type=text class=for name=url size=30 value=\"$url\"></td></tr>

<tr><td align=left colspan=2>
������� : <input type=file name=file2 size=30><br><br>
</td></tr>
");
}
if ($category=='soisk') {
echo ("

<tr ><td >��������� ����:</td><td> <input type=file name=file1 size=30>
</td></tr>
");
}
echo ("
<tr><td align=left width=40% valign=top><font color=#FF0000>*</font>E-mail �����:<br></td>
<td><input type=text class=for name=email size=20 value=\"$email\">&ensp;&ensp;<input type=checkbox name=hidemail value=checked $hidemail>&ensp;������ E-mail</td>

</tr>
<tr><td align=left width=40%><font color=#FF0000>*</font>������:</td>
<td><input type=password name=pass size=20 class=for></td></tr>
<tr><td align=left width=40%><font color=#FF0000>*</font>������������� ������:</td>
<td><input type=password name=passr size=20 class=for></td></tr>
");
if ($imgconfirm == 'TRUE')
{ // img conf
echo "<tr><td align=left width=40% valign=top>&ensp;<font color=#FF0000>*</font>��� �� ��������:&nbsp;";
echo "<img src=code.php>";
echo "</td><td><input type=text class=for name=number size=20></td></tr>";
} // img conf
} //categ
echo "</table><p><input type=submit value=\"�����������\" name=\"submit\" class=dob id=dobpadd></form>";
}
else {
unset($result);
if ($regconfirm != 'TRUE')
{ //no confirm
$result = @mysql_query("SELECT ID,email,pass FROM $autortable WHERE (email = '$email' and pass='$pass')");
while ($myrow=mysql_fetch_array($result)) {
$_SESSION['sid']=$myrow["ID"];
}
$_SESSION['slogin']=$email;
$_SESSION['spass']=$pass;
} //no confirm
echo "<br><br><h3 align=left>������� �� ����������� �� ����� $sitename!</h3><br><br>$reglineafter<br><br>";
$txt="�� ����� ����������������� ����� ������������";
if ($mailregistr == 'TRUE')
{mail($adminemail,"�����������",$txt,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/plain; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");}
}
echo "</div>";
include("down.php");
?>