<?
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
include("var.php");
echo"<title>Изменение регистрационных данных : $sitename</title>";
?>

<SCRIPT>
function Hide(d) {document.getElementById(d).style.display = 'none';}
function Shw(d) {document.getElementById(d).style.display = 'block';}
</SCRIPT>

<?
include("top.php");
echo "<div class=tbl1>";
?>
<h3><left><strong>Изменение регистрационных данных</strong></left></h3>
<?php
$maxname = 50;
$maxemail = 100;
$maxpass = 20;
$maxcity = 50;
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
$err6 = "Город должен быть не длинее $maxcity символов<br>";
$err7 = "Гражданство должно быть не длинее $maxciv символов<br>";
$err8 = "Адрес должен быть не длинее $maxadress символов<br>";
$err9 = "Телефон должен быть не длинее $maxtelephone символов<br>";
$err10 = "Адрес сайта должен быть не длинее $maxurl символов<br>";
$err115 = "Поле Проф.навыки должно быть не длинее $maxprof символов<br>";
$err116 = "Поле Дополнительные сведения должно быть не длинее $maxdopsved символов<br>";
$err12 = "Не заполнено обязательное поле - E-mail!<br>";
$err13 = "Не заполнено обязательное поле - Пароль!<br>";
$err14 = "Не заполнено обязательное поле - Подтверждение пароля<br>";
$err15 = "Не заполнено обязательное поле - Город!<br>";
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
$err20 = "Участник с таким email-адресом уже зарегистрирован, выберите другой!<br>";
$err21 = "Поле Направления деятельности должно быть не длинее $maxdeyat символов<br>";
$err22 = "Извините, но Вам нельзя регистрироваться на этом сайте! <br>";
$err23 = "Пароль не должен содержать пробелов! <br>";
$err24 = "Не верный цифровой код!<br>";
$err25 = "Адрес странички должен начинаться с http://! <br>";
$error = "";
$sid=$_SESSION['sid'];
$id=$_SESSION['sid'];
$slogin=$_SESSION['slogin'];
$spass=$_SESSION['spass'];
$result = @mysql_query("SELECT ID,category,email,pass FROM $autortable WHERE (email = '$slogin' and pass = '$spass')");
if ((!isset($slogin) or !isset($spass)) or @mysql_num_rows($result) == 0)
{
	echo "<left><br><br><h3>Вы не авторизированы!</h3><b><a href=autor.php>Авторизация</a></b>";
}
else
{//1
	if ($_SERVER[QUERY_STRING] != "add")
	{ //2
		$result = @mysql_query("SELECT *,(YEAR(birth)) AS byear,(MONTH(birth)) AS bmonth,(DAYOFMONTH(birth)) AS bday FROM $autortable WHERE ID='$id'");
		while ($myrow=mysql_fetch_array($result)) {
			$ID=$myrow["ID"];
			if (!isset($_GET['category']) or $_GET['category'] == '') {$category=$myrow["category"];}
			$email=$myrow["email"];
			if (!isset($_GET['country']) or $_GET['country']=='0') {
				$country=$myrow["country"];
			}
			if (!isset($_GET['region']) or $_GET['region']=='0') {
				$region=$myrow["region"];
			}
			$city=$myrow["city"];
			$telephone=$myrow["telephone"];
			$adress=$myrow["adress"];
			$url=$myrow["url"];
			$fio=$myrow["fio"];
			$firm=$myrow["firm"];
			$gender=$myrow["gender"];
			$byear=$myrow["byear"];
			$bmonth=$myrow["bmonth"];
			$bday=$myrow["bday"];
			$family=$myrow["family"];
			$civil=$myrow["civil"];
			$prof=$myrow["prof"];
			$dopsved=$myrow["dopsved"];
			$deyat=$myrow["deyat"];
			$foto1=$myrow["foto1"];
			$foto2=$myrow["foto2"];
			$pass=$myrow["pass"];
			$hidemail=$myrow["hidemail"];

			$edu1sel=$myrow["edu1sel"];
			$edu1school=$myrow["edu1school"];
			$edu1year=$myrow["edu1year"];
			$edu1fac=$myrow["edu1fac"];
			$edu1spec=$myrow["edu1spec"];
			$edu2sel=$myrow["edu2sel"];
			$edu2school=$myrow["edu2school"];
			$edu2year=$myrow["edu2year"];
			$edu2fac=$myrow["edu2fac"];
			$edu2spec=$myrow["edu2spec"];
			$edu3sel=$myrow["edu3sel"];
			$edu3school=$myrow["edu3school"];
			$edu3year=$myrow["edu3year"];
			$edu3fac=$myrow["edu3fac"];
			$edu3spec=$myrow["edu3spec"];
			$edu4sel=$myrow["edu4sel"];
			$edu4school=$myrow["edu4school"];
			$edu4year=$myrow["edu4year"];
			$edu4fac=$myrow["edu4fac"];
			$edu4spec=$myrow["edu4spec"];
			$edu5sel=$myrow["edu5sel"];
			$edu5school=$myrow["edu5school"];
			$edu5year=$myrow["edu5year"];
			$edu5fac=$myrow["edu5fac"];
			$edu5spec=$myrow["edu5spec"];
			$lang1=$myrow["lang1"];
			$lang1uroven=$myrow["lang1uroven"];
			$lang2=$myrow["lang2"];
			$lang2uroven=$myrow["lang2uroven"];
			$lang3=$myrow["lang3"];
			$lang3uroven=$myrow["lang3uroven"];
			$lang4=$myrow["lang4"];
			$lang4uroven=$myrow["lang4uroven"];
			$lang5=$myrow["lang5"];
			$lang5uroven=$myrow["lang5uroven"];
		}
	echo "<left><font color=red>$error</font></left>";
	} //2
	if ($_SERVER[QUERY_STRING] == "add") 
	{
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

		$result = @mysql_query("SELECT email,ID FROM $autortable WHERE email = '$email' and ID != '$id'");
		if (@mysql_num_rows($result) != 0) {$error .= "$err20";}
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

		echo "<left><font color=red>$error</font></left>";
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

		if ($_SERVER[QUERY_STRING] == "add" and $error == "") {
			$date = date("Y/m/d H:i:s");
			$birth="$byear-$bmonth-$bday";
			$sql="update $autortable SET email='$email',country='$country',region='$region',city='$city',telephone='$telephone',adress='$adress',url='$url',fio='$fio',firm='$firm',birth='$birth',gender='$gender',family='$family',civil='$civil',prof='$prof',dopsved='$dopsved',deyat='$deyat',date=now(),pass='$pass',hidemail='$hidemail',edu1sel='$edu1sel',edu1school='$edu1school',edu1year='$edu1year',edu1fac='$edu1fac',edu1spec='$edu1spec',edu2sel='$edu2sel',edu2school='$edu2school',edu2year='$edu2year',edu2fac='$edu2fac',edu2spec='$edu2spec',edu3sel='$edu3sel',edu3school='$edu3school',edu3year='$edu3year',edu3fac='$edu3fac',edu3spec='$edu3spec',edu4sel='$edu4sel',edu4school='$edu4school',edu4year='$edu4year',edu4fac='$edu4fac',edu4spec='$edu4spec',edu5sel='$edu5sel',edu5school='$edu5school',edu5year='$edu5year',edu5fac='$edu5fac',edu5spec='$edu5spec',lang1='$lang1',lang1uroven='$lang1uroven',lang2='$lang2',lang2uroven='$lang2uroven',lang3='$lang3',lang3uroven='$lang3uroven',lang4='$lang4',lang4uroven='$lang4uroven',lang5='$lang5',lang5uroven='$lang5uroven' WHERE ID=$id";
			$result=@mysql_query($sql,$db);
			$_SESSION['slogin']=$email;
			$_SESSION['spass']=$pass;
			echo "<br><br><h3 align=left>Изменения сохранены!</h3><p align=left><a href=autor.php>Вернуться в авторский раздел</a></p><br><br>";
		}
	}
	if ($_SERVER[QUERY_STRING] != "add" or $error != "") {
		echo ("
<form name=form method=post ENCTYPE=\"multipart/form-data\" action=regchan.php?add>
<input type=hidden name=id value=$id>
");
		if ($category == '')
		{
			if ($_GET['category'] == '') {$category=$_POST['category'];}
				elseif ($_GET['category'] != '') {$category=$_GET['category'];}
		}
		if ($category=='soisk') {$categ='Соискатель';}
		if ($category=='rab') {$categ='Работодатель';}
		if ($category=='agency') {$categ='Агентство';}
		if ($category=='user') {$categ='Пользователь';}

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
		echo ("
<p class=star>Обязательные поля отмечены символом <font color=#FF0000>*</font></p><br>
");
		if (!isset($category))
		{
			echo ("
<blockquote><p align=justify>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Укажите в качестве кого вы хотите зарегистрироваться. Если вы соискатель, то после регистрации сможете добавлять, редактировать, изменять свои резюме. Если вы работодатель, то после регистрации сможете добавлять, редактировать, изменять вакансии. Кадровые агентства могут делать и то и другое. Постарайтесь указать как можно больше сведений о себе.<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Если вы не собираетесь добавлять вакансии или резюме, но хотите иметь доступ к таким функциям, как добавление закладок, подписка на рассылку, то зарегистрируйтесь как \"Пользователь\"</p></blockquote>
");
		}
		echo ("
<table width=100%>
<tr><td align=left>Вы зарегистрированы как </td>
<td><b>$categ</b></td></tr>
");
		if (!empty($category))
		{ //categ
			echo ("
<tr><td valign=top align=left><strong><font color=#FF0000>*</font>Регион:</strong></td>
<td valign=top align=left>
<select class=for name=country size=1 onChange=location.href=location.pathname+\"?id=$id&country=\"+value+\"\";>
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
			if (!empty($country))
			{ // регион
				$result1 = @mysql_query("SELECT id, name FROM $citytable WHERE region_ref = $country AND NOT ISNULL(city_ref) ORDER BY name");
				if (@mysql_num_rows($result1) != 0)
				{ // есть город
					echo ("
<tr><td valign=top align=left><strong><font color=#FF0000>*</font>Город:</strong></td>
<td valign=top align=left><select class=for name=region size=1>
<option></option>
");
					while($myrow=mysql_fetch_array($result1)) {
						$city_name=$myrow["name"];
						$city_id=$myrow["id"];
						echo "<option";
						if ($city_id == $city) echo " selected";
						echo " value=\"$city_id\">$city_name</option>";
					}
					echo ("
</select></td></tr>
");
				} // есть город
			} // регион

			if ($category == 'agency') {
				echo ("
<tr><td align=left><font color=#FF0000>*</font>Название агентства:</td>
<td><input type=text class=for name=firm size=30 value=\"$firm\"></td></tr>
<tr><td align=left valign=top><font color=#FF0000>*</font>Направления деятельности:</td>
<td><textarea class=arria rows=7 name=deyat cols=50>$deyat</textarea></td></tr>
");
			}
			if ($category == 'rab') {
				echo ("
<tr><td align=left><font color=#FF0000>*</font>Название фирмы (если есть):</td>
<td><input type=text class=for name=firm size=30 value=\"$firm\"></td></tr>
<tr><td align=left valign=top><font color=#FF0000>*</font>Направления деятельности:</td>
<td><textarea class=arria rows=7 name=deyat cols=50>$deyat</textarea></td></tr>
");
			}
			if ($category != 'user') {
				echo ("
<tr><td align=left><font color=#FF0000>*</font>Контактное лицо:</td>
<td><input type=text class=for name=fio size=30 value=\"$fio\"></td></tr>
");
			}
			if ($category=='soisk') {
				echo ("
<tr><td align=left valign=top><font color=#FF0000>*</font>Дата рождения:</td>
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
<tr bgcolor=$maincolor><td align=left>Пол:</td>
<td><select class=for name=gender size=1>
<option selected value=\"$gender\">$gender</option>
<option value=\"Мужской\">Мужской</option>
<option value=\"Женский\">Женский</option>
</select></td></tr>
<tr><td align=left>Семейное положение:</td>
<td><select class=for name=family size=1>
<option selected value=\"$family\">$family</option>
<option value=\"Не&nbsp;состою&nbsp;в&nbsp;браке,&nbsp;детей&nbsp;нет\">Не&nbsp;состою&nbsp;в&nbsp;браке,&nbsp;детей&nbsp;нет</option>
<option value=\"Не&nbsp;состою&nbsp;в&nbsp;браке,&nbsp;дети&nbsp;есть\">Не&nbsp;состою&nbsp;в&nbsp;браке,&nbsp;дети&nbsp;есть</option>
<option value=\"Состою&nbsp;в&nbsp;браке,&nbsp;детей&nbsp;нет\">Состою&nbsp;в&nbsp;браке,&nbsp;детей&nbsp;нет</option>
<option value=\"Состою&nbsp;в&nbsp;браке,&nbsp;дети&nbsp;есть\">Состою&nbsp;в&nbsp;браке,&nbsp;дети&nbsp;есть</option>
</select></td></tr>
<tr><td align=left>Гражданство:</td>
<td><input type=text class=for name=civil size=30 value=\"$civil\"></td></tr>
<tr><td align=left valign=top><font color=#FF0000>*</font>Профессиональные навыки и знания:</td>
<td><textarea class=arria rows=7 name=prof cols=50>$prof</textarea><br><small>Эта информация будет отображаться в кратком резюме.</small></td></tr>
<tr><td align=left valign=top>Дополнительные сведения:</td>
<td><textarea class=arria rows=7 name=dopsved cols=50>$dopsved</textarea><br><small>Ваши увлечения, занятия в свободное время, круг интересов и т.п.</small></td></tr>
");
			}
			if ($category != 'user') {
				echo ("
<tr><td align=left>
");
				if ($category=='rab' or $category == 'agency') {echo "<font color=#FF0000>*</font>";}
				echo ("
Телефон:</td>
<td><input type=text class=for name=telephone size=30 value=\"$telephone\"></td></tr>
");
			}
			if ($category=='rab' or $category == 'agency') {
				echo ("
<tr><td align=left><font color=#FF0000>*</font>Адрес:</td>
<td><input type=text class=for name=adress size=30 value=\"$adress\"></td></tr>
<tr><td align=left>URL:</td>
<td><input type=text class=for name=url size=30 value=\"$url\"></td></tr>
<tr bgcolor=$maincolor><td colspan=2 valign=top align=left>
 <a href=regfoto.php>Управление фотографиями</a>
</td></tr>
<tr bgcolor=$maincolor><td align=left colspan=2>
");
				if ($foto2 != '')
				{
					$fotourl=$foto2;
					if (file_exists($photodir.'s'.$fotourl)) {$fotourl="s$fotourl"; $height=$smalllogoheight;}
					if (!file_exists($photodir.'s'.$fotourl)) {
						$PicSrc=$photodir.$fotourl;
						$ar=GetImageSize($PicSrc);
						$w=$ar[0];
						$h=$ar[1];
						if ($h > $smalllogoheight) {$height=$smalllogoheight;}
						if ($h <= $smalllogoheight) {$height=$h;}
					}
					echo "<img src=\"$photodir$fotourl\" height=$height alt=\"$firm\" border=0>";
				}
				echo ("
</td></tr>
");
			}
			if ($category=='soisk') {
				echo ("
<tr bgcolor=$maincolor><td colspan=2 valign=top align=left>
 <a href=regfoto.php>Управление фотографиями</a>
</td></tr>
<tr bgcolor=$maincolor><td align=left colspan=2>
");
				if ($foto1 != "") {if (file_exists($photodir.'s'.$foto1)) {$wfoto1="s$foto1";} elseif (!file_exists($photodir.'s'.$foto1)) {$wfoto1="$foto1";} echo "<img src=\"$photodir$wfoto1\" height=$smallfotoheight alt=\"\" border=0> &nbsp;";}
				echo ("
</td></tr>
");
			}
			echo ("
<tr><td align=left valign=top><font color=#FF0000>*</font>E-mail адрес:<br></td>
<td><input type=text class=for name=email size=20 value=\"$email\">&ensp;&ensp;<input type=checkbox name=hidemail value=checked $hidemail>&ensp;Скрыть E-mail</td></tr>
<tr><td align=left><font color=#FF0000>*</font>Пароль:</td>
<td><input type=password class=for name=pass size=20 value=\"$pass\"></td></tr>
<tr><td align=left><font color=#FF0000>*</font>Подтверждение пароля:</td>
<td><input type=password class=for name=passr size=20 value=\"$pass\"></td></tr>
</table>
");
			echo "<p align=left><a href=autor.php>Вернуться в личный раздел</a></p>";
			echo "<left><p><input type=submit value=\"Сохранить\" name=\"submit\" class=dob id=dobpadd ></form>";
		}
	}
} //1
echo "</div>";
include("down.php");
?>