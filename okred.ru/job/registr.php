<?
session_start();
$_SESSION["spass"]="";
$_SESSION["slogin"]="";
$_SESSION["sid"]="";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
echo "<head>";
include("var.php");
echo"<title>Регистрация : $sitename</title>";
include("top.php");
// удаление неподтвержденных регистраций
$delold=mysql_query("delete from $autortable where status='wait' and ((date + INTERVAL 86400*$delnotconfirm SECOND) < now())");
// удаление неподтвержденных регистраций
?>

<SCRIPT>
function Hide(d) {document.getElementById(d).style.display = 'none';}
function Shw(d) {document.getElementById(d).style.display = 'block';}
</SCRIPT>

<div class=tbl1>
<h3 align=left><strong>Регистрация</strong></left></h3>
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
$err2 = "E-mail должен быть не длинее $maxemail символов<br>";
$err3 = "Пароль должен быть не длинее $maxpass символов<br>";
$err4 = "Название фирмы должно быть не длинее $maxfirm символов<br>";
$err5 = "Поле Контактное лицо должно быть не длинее $maxfio символов<br>";
$err7 = "Гражданство должно быть не длинее $maxciv символов<br>";
$err8 = "Адрес должен быть не длинее $maxadress символов<br>";
$err9 = "Телефон должен быть не длинее $maxtelephone символов<br>";
$err10 = "Адрес сайта должен быть не длинее $maxurl символов<br>";
$err115 = "Поле Проф.навыки должно быть не длинее $maxprof символов<br>";
$err116 = "Поле Дополнительные сведения должно быть не длинее $maxdopsved символов<br>";

$err12 = "Не заполнено обязательное поле - E-mail!<br>";
$err13 = "Не заполнено обязательное поле - Пароль!<br>";
$err14 = "Не заполнено обязательное поле - Подтверждение пароля<br>";
$err16 = "Не заполнено обязательное поле - Название агентства!<br>";
$err17 = "Не заполнено обязательное поле - Телефон!<br>";

$err201 = "Не заполнено обязательное поле - Направления деятельности!<br>";
$err202 = "Не заполнено обязательное поле - Название фирмы!<br>";
$err203 = "Не заполнено обязательное поле - Контактное лицо!<br>";
$err204 = "Не заполнено обязательное поле - Дата рождения!<br>";
$err205 = "Не заполнено обязательное поле - Профессиональные навыки и знания!<br>";
$err208 = "Не заполнено обязательное поле - Адрес!<br>";

$err18 = "Пожалуйста введите пароль заново. Текст полей Пароль и Подтверждение пароля должен быть одинаков<br>";
$err19 = "Пожалуйста проверьте правильность E-mail адреса<br>";
$err20 = "Участник с таким email-адресом уже зарегистрирован, выберите другой!<br><br>";
$err21 = "Поле Направления деятельности должно быть не длинее $maxdeyat символов<br>";
$err22 = "Извините, но Вам нельзя регистрироваться на этом сайте! <br>";
$err23 = "Пароль не должен содержать пробелов! <br>";
$err24 = "Не верный цифровой код!<br>";
$err25 = "Адрес странички должен начинаться с http://! <br>";
$err26 = "Фотография должна иметь расширение *.jpg либо *.gif<br>";
$err27 = "Фотография должна иметь размер не более $MAX_FILE_SIZE байт!<br>";
$error = "";
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
if ($_SERVER[QUERY_STRING] == "add")
{
	$number=$_POST['number'];
	$category=$_POST['category'];
	$email=$_POST['email'];
	$country=$country_RUS;
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
				$error .= "Не заполнено обязательное поле - Город<br>";
			}
		}
		if ($region == "")
		{
			$result3c = @mysql_query("SELECT * FROM $citytable WHERE razdel='$countrys1' and categ != '' LIMIT 1");
			if (@mysql_num_rows($result3c) != 0) {
				$error .= "Не заполнено обязательное поле - Город<br>";
			}
		}
	}
// город

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
						}
					} //small img
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
						}
					} //small img
				}
			}
		}
		if ($regconfirm == 'TRUE')
		{ // confirm
			srand((double)microtime()*1000000);
			$code=md5(uniqid(rand()));
			$code=@substr($code,1,12);
			$sql="insert into $autortable (category,email,country,region,city,telephone,adress,url,fio,firm,birth,gender,family,civil,prof,dopsved,deyat,date,foto1,foto2,pass,ip,status,code,hidemail,edu1sel,edu1school,edu1year,edu1fac,edu1spec,edu2sel,edu2school,edu2year,edu2fac,edu2spec,edu3sel,edu3school,edu3year,edu3fac,edu3spec,edu4sel,edu4school,edu4year,edu4fac,edu4spec,edu5sel,edu5school,edu5year,edu5fac,edu5spec,lang1,lang1uroven,lang2,lang2uroven,lang3,lang3uroven,lang4,lang4uroven,lang5,lang5uroven) values ('$category','$email','$country','$region','$city','$telephone','$adress','$url','$fio','$firm','$birth','$gender','$family','$civil','$prof','$dopsved','$deyat',now(),'$source_name1','$source_name2','$pass','$REMOTE_ADDR','wait','$code','$hidemail','$edu1sel','$edu1school','$edu1year','$edu1fac','$edu1spec','$edu2sel','$edu2school','$edu2year','$edu2fac','$edu2spec','$edu3sel','$edu3school','$edu3year','$edu3fac','$edu3spec','$edu4sel','$edu4school','$edu4year','$edu4fac','$edu4spec','$edu5sel','$edu5school','$edu5year','$edu5fac','$edu5spec','$lang1','$lang1uroven','$lang2','$lang2uroven','$lang3','$lang3uroven','$lang4','$lang4uroven','$lang5','$lang5uroven')";
			$codetxt="Здравствуйте!<br>Это письмо выслано вам в связи с регистрацией на сайте <a href=$siteadress>$sitename</a><br><br>Для завершения регистрации необходимо пройти по ссылке:<br><br><a href=\"$siteadress/confirm.php?login=$email&code=$code\">$siteadress/confirm.php?login=$email&code=$code</a><br><br>либо зайти на страницу <a href=\"$siteadress/confirm.php\">$siteadress/confirm.php</a> и ввести следующие данные:<br>E-mail: $email<br>Код активации: $code<br><br>Если вы не имеете понятия о чем идет речь, то просто удалите это письмо.<br><br>Спасибо за пользование нашим сайтом!<br><br>С уважением,<br>$sitename<br><a href=mailto:$adminemail>$adminemail</a><br><a href=$siteadress>$siteadress</a>";
			mail($email,"Подтверждение регистрации",$codetxt,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/html; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");
			$reglineafter="<p align=left>На ваш email-адрес выслано письмо с подтверждением регистрации!</p><br><br>";
		} // confirm
		elseif ($regconfirm != 'TRUE')
		{ //no confirm reg
			$sql="insert into $autortable (category,email,country,region,city,telephone,adress,url,fio,firm,birth,gender,family,civil,prof,dopsved,deyat,date,foto1,foto2,pass,ip,status,hidemail,edu1sel,edu1school,edu1year,edu1fac,edu1spec,edu2sel,edu2school,edu2year,edu2fac,edu2spec,edu3sel,edu3school,edu3year,edu3fac,edu3spec,edu4sel,edu4school,edu4year,edu4fac,edu4spec,edu5sel,edu5school,edu5year,edu5fac,edu5spec,lang1,lang1uroven,lang2,lang2uroven,lang3,lang3uroven,lang4,lang4uroven,lang5,lang5uroven) values ('$category','$email','$country','$region','$city','$telephone','$adress','$url','$fio','$firm','$birth','$gender','$family','$civil','$prof','$dopsved','$deyat',now(),'$source_name1','$source_name2','$pass','$REMOTE_ADDR','user','$hidemail','$edu1sel','$edu1school','$edu1year','$edu1fac','$edu1spec','$edu2sel','$edu2school','$edu2year','$edu2fac','$edu2spec','$edu3sel','$edu3school','$edu3year','$edu3fac','$edu3spec','$edu4sel','$edu4school','$edu4year','$edu4fac','$edu4spec','$edu5sel','$edu5school','$edu5year','$edu5fac','$edu5spec','$lang1','$lang1uroven','$lang2','$lang2uroven','$lang3','$lang3uroven','$lang4','$lang4uroven','$lang5','$lang5uroven')";
			if ($category=='rab' or $category=='agency') {
				$reglineafter="<p align=left>Выберите дальнейшее действие:<br><br>";
				$reglineafter=$reglineafter."<a href=addvac.php>Добавить вакансию</a><br><br>";
			}
			if ($category=='soisk' or $category=='agency') {
				$reglineafter="<p align=left><b><big>Теперь вы можете добавить резюме!</big></b><br><br>";
				if ($category=='soisk') {$reglineafter.="Через несколько секунд вы попадете в раздел добавления резюме. Если этого не произошло перейдите по ссылке ниже:<br><br>";}
				$reglineafter=$reglineafter."<a href=addres.php>Добавить резюме</a><br><br>";
			}
			$reglineafter=$reglineafter."<a href=autor.php>В личный раздел</a></p>";
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
	if ($category=='soisk') {$categ='Соискатель';}
	if ($category=='rab') {$categ='Работодатель';}
	if ($category=='agency') {$categ='Агентство';}
	if ($category=='user') {$categ='Пользователь';}

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
<p class=star>Обязательные поля отмечены символом <font color=#FF0000>*</font></p>
	");
	if (!isset($category))
	{
		echo ("
<blockquote><p align=justify>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Укажите в качестве кого вы хотите зарегистрироваться</b>:<br>
<li>Если вы соискатель, то после регистрации сможете добавлять, редактировать, изменять свои резюме.<br>
<li>Если вы работодатель, то после регистрации сможете добавлять, редактировать, изменять вакансии.<br>
<li>Кадровые агентства могут делать и то и другое.<br>
<li>Если вы не собираетесь добавлять вакансии или резюме, но хотите иметь доступ к таким функциям, как добавление закладок, подписка на рассылку, то зарегистрируйтесь как \"Пользователь\".
</p>
</blockquote>
	");
	}
	echo ("
<table width=100%>
<tr><td align=left width=40%><font color=#FF0000>*</font>Зарегистрироваться как:</td>
<td><select class=for name=category size=1 onChange=location.href=location.pathname+\"?category=\"+value+\"\";>
<option selected value=\"$category\">$categ</option>
<option value=soisk>Соискатель</option>
<option value=rab>Работодатель</option>
<option value=agency>Агентство</option>
<option value=user>Пользователь</option>
</select></td></tr>
");
	if (isset($category) and $category != '')
	{ //categ
		echo ("
<tr><td valign=top align=left><font color=#FF0000>*</font>Регион:</td>
<td valign=top align=left>
<select class=for name=region size=1 onChange=location.href=location.pathname+\"?category=$category&country=\"+value+\"\";>
<option></option>
");
		$result2 = @mysql_query("SELECT id, name FROM $citytable WHERE country_ref = $country_RUS AND ISNULL(city_ref) AND region_ref > 0 ORDER BY name");
			while($myrow=mysql_fetch_array($result2)) {
				$region_name=$myrow["name"];
				$region_id=$myrow["id"];
				echo "<option";
				if ($region_id == $country) echo " selected";
				echo " value=\"$region_id\">$region_name</option>";
			}
		echo ("
</select></td></tr>
");
		if ($country != '')
		{ // область
			$result1 = @mysql_query("SELECT id, name FROM $citytable WHERE region_ref = $country AND NOT ISNULL(city_ref) ORDER BY name");
			if (@mysql_num_rows($result1) != 0)
			{ // есть город
				echo ("
<tr><td valign=top align=left><font color=#FF0000>*</font>Город:</td>
<td valign=top align=left><select class=for name=city size=1>
<option></option>
");
				while($myrow=mysql_fetch_array($result1)) {
						$city_name=$myrow["name"];
						$city_id=$myrow["id"];
						echo "<option value=\"$city_id\">$city_name</option>";
					}
				echo ("
</select></td></tr>
");
			} // есть город
		} // регион
		if ($category == 'agency') {
			echo ("
<tr><td align=left width=40%><font color=#FF0000>*</font>Название агентства:</td>
<td><input type=text class=for name=firm size=30 value=\"$firm\"></td></tr>
<tr><td align=left width=40% valign=top><font color=#FF0000>*</font>Направления деятельности:</td>
<td><textarea class=arria rows=7 name=deyat cols=50>$deyat</textarea></td></tr>
");
		}
		if ($category == 'rab') {
			echo ("
<tr><td align=left width=40%><font color=#FF0000>*</font>Название фирмы (если есть):</td>
<td><input type=text class=for name=firm size=30 value=\"$firm\"></td></tr>
<tr><td align=left width=40% valign=top><font color=#FF0000>*</font>Направления деятельности:</td>
<td><textarea class=arria rows=7 name=deyat cols=50>$deyat</textarea></td></tr>
");
		}
		if ($category != 'user') {
			echo ("
<tr><td align=left width=40%><font color=#FF0000>*</font>Контактное лицо:</td>
<td><input type=text class=for name=fio size=30 value=\"$fio\"></td></tr>
");
		}
		if ($category=='soisk') {
			echo ("
<tr><td align=left width=40% valign=top><font color=#FF0000>*</font>Дата рождения:</td>
<td><select class=for name=bday size=1>
<option></option>
");
		for ($i = 1; $i < 32; $i++) {
			echo "<option";
			if ($i == $bday) echo " selected";
			echo " value=$i>".str_pad("$i", 2, "0", STR_PAD_LEFT)."</option>";
		}
		echo ("
</select>&nbsp;
<select class=for name=bmonth size=1>
<option></option>
");
		for ($i = 1; $i < 13; $i++) {
			echo "<option";
			if ($i == $bmonth) echo " selected";
			echo " value=$i>".str_pad("$i", 2, "0", STR_PAD_LEFT)."</option>";
		}
		echo ("
</select>&nbsp;
<select class=for name=byear size=1>
<option></option>
");
		for ($i = 1940; $i <= date('Y'); $i++) {
			echo "<option";
			if ($i == $byear) echo " selected";
			echo " value=$i>".$i."</option>";
		}
		echo ("
</select><br><small>день&nbsp;&nbsp;&nbsp;месяц&nbsp;&nbsp;&nbsp;год</small></td></tr>
<tr><td align=left width=40%>Пол:</td>
<td><select class=for name=gender size=1>
<option selected value=\"$gender\">$gender</option>
<option value=\"Мужской\">Мужской</option>
<option value=\"Женский\">Женский</option>
</select></td></tr>
<tr><td align=left width=40%>Семейное положение:</td>
<td><select class=for name=family size=1>
<option selected value=\"$family\">$family</option>
<option value=\"Не&nbsp;состою&nbsp;в&nbsp;браке,&nbsp;детей&nbsp;нет\">Не&nbsp;состою&nbsp;в&nbsp;браке,&nbsp;детей&nbsp;нет</option>
<option value=\"Не&nbsp;состою&nbsp;в&nbsp;браке,&nbsp;дети&nbsp;есть\">Не&nbsp;состою&nbsp;в&nbsp;браке,&nbsp;дети&nbsp;есть</option>
<option value=\"Состою&nbsp;в&nbsp;браке,&nbsp;детей&nbsp;нет\">Состою&nbsp;в&nbsp;браке,&nbsp;детей&nbsp;нет</option>
<option value=\"Состою&nbsp;в&nbsp;браке,&nbsp;дети&nbsp;есть\">Состою&nbsp;в&nbsp;браке,&nbsp;дети&nbsp;есть</option>
</select></td></tr>
<tr><td align=left width=40%>Гражданство:</td>
<td><input type=text class=for name=civil size=30 value=\"$civil\"></td></tr>
<tr><td align=left width=40% valign=top><font color=#FF0000>*</font>Профессиональные навыки и знания:</td>
<td><textarea class=arria rows=7 name=prof cols=50>$prof</textarea><br>
<p>
<small>Эта информация будет отображаться в кратком резюме.</small></p></td></tr>
<tr><td align=left width=40% valign=top>Дополнительные сведения:</td>
<td><textarea class=arria rows=7 name=dopsved cols=50>$dopsved</textarea><br><small>Ваши увлечения, занятия в свободное время, круг интересов и т.п.</small></td></tr>
");
		}
		if ($category != 'user') {
			echo ("
<tr><td align=left width=40%>
");
			if ($category=='rab' or $category == 'agency') {echo "<font color=#FF0000>*</font>";}
			echo ("
Телефон:</td>
<td><input type=text class=for name=telephone size=30 value=\"$telephone\"></td></tr>
");
		}
		if ($category=='rab' or $category == 'agency') {
			echo ("
<tr><td align=left width=40%><font color=#FF0000>*</font>Адрес:</td>
<td><input type=text class=for name=adress size=30 value=\"$adress\"><br><small>для правильного отображения фирмы на карте заполните поле в формате: Улица, дом/корпус</small></td></tr>
<tr><td align=left width=40%>URL:</td>
<td><input type=text class=for name=url size=30 value=\"$url\"></td></tr>
<tr><td align=left colspan=2>
Логотип : <input type=file name=file2 size=30><br><br>
</td></tr>
");
		}
		if ($category=='soisk') {
			echo ("
<tr ><td >Загрузить фото:</td><td> <input type=file name=file1 size=30>
</td></tr>
");
		}
		echo ("
<tr><td align=left width=40% valign=top><font color=#FF0000>*</font>E-mail адрес:<br></td>
<td><input type=text class=for name=email size=20 value=\"$email\">&ensp;&ensp;<input type=checkbox name=hidemail value=checked $hidemail>&ensp;Скрыть E-mail</td>
</tr>
<tr><td align=left width=40%><font color=#FF0000>*</font>Пароль:</td>
<td><input type=password name=pass size=20 class=for></td></tr>
<tr><td align=left width=40%><font color=#FF0000>*</font>Подтверждение пароля:</td>
<td><input type=password name=passr size=20 class=for></td></tr>
");
		if ($imgconfirm == 'TRUE')
		{ // img conf
			echo "<tr><td align=left width=40% valign=top>&ensp;<font color=#FF0000>*</font>Код на картинке:&nbsp;";
			echo "<img src=code.php>";
			echo "</td><td><input type=text class=for name=number size=20></td></tr>";
		} // img conf
	} //categ
	echo "</table><p><input type=submit value=\"Регистрация\" name=\"submit\" class=dob id=dobpadd></form>";
}
else 
{
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
	echo "<br><br><h3 align=left>Спасибо за регистрацию на сайте $sitename!</h3><br><br>$reglineafter<br><br>";
	$txt="На сайте зарегистрировался новый пользователь";
	if ($mailregistr == 'TRUE')
		{mail($adminemail,"Регистрация",$txt,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/plain; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");}
}
echo "</div>";
include("down.php");
?>