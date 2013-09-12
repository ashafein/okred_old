<?
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
echo "<head>";
include("var.php");
$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);

$link=$_GET['link'];
$pr=$_GET['pr'];

$resulttitle = @mysql_query("SELECT ID,profecy,status FROM $restable WHERE ID=$link and status='ok'");
while ($myrow=@mysql_fetch_array($resulttitle))
	$profecy=$myrow["profecy"];
echo "<title>$profecy : Резюме $sitename</title>";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\"><META HTTP-EQUIV=\"Cache-Control\" CONTENT=\"No-Cache\">";

if ($pr != 'print')
	include("top.php");
if ($pr == 'print') {
	echo ("
<SCRIPT language=\"JavaScript1.2\">
<!--
function doPrint()
{
if (window.print)
	{
		window.print();
	}
	else
	{
		alert('Press Ctrl+P. Please, update your browser...');
	}
}
-->
</SCRIPT>
<body onLoad = doPrint()>
");
	echo "$sitename - $siteadress<br>";
}

$p=$_GET['p'];
$d=$_GET['d'];
$bn=$_GET['bn'];
if ($ident == 'session')
	$REMOTE_ADDR=$PHPSESSID;
if ($ident != 'session')
	$REMOTE_ADDR=$_SERVER['REMOTE_ADDR'];
$n = getenv('REQUEST_URI');
// ------------del old------------
$expdate = date("Y-m-d H:i:s", time()- $delperiod*86400);
$delitemdb=mysql_query("delete from $resordertable where date < '$expdate'");
// ------------del old------------
//
// ------------basket------------
//
if (isset($p) and $p != ""){ //additem
	$selectresult = @mysql_query("SELECT * FROM $resordertable WHERE (user = '$REMOTE_ADDR' and unit=$p and status='basket')");
	if (@mysql_num_rows($selectresult) == 0){
		$sql="insert into $resordertable (user,unit,number,date,status) values ('$REMOTE_ADDR',$p,1,now(),'basket')";
		$addresult=@mysql_query($sql,$db);
	}
} //additem
elseif (isset($d) and $d != ""){ //removeitem
	$selectresult = @mysql_query("SELECT * FROM $resordertable WHERE (user = '$REMOTE_ADDR' and unit=$d and status='basket')");
	if (@mysql_num_rows($selectresult) != 0)
		$delresult=@mysql_query("delete from $resordertable where (user = '$REMOTE_ADDR' and unit=$d and status='basket')");
} //removeitem
if (isset($bn) and $bn != "")//count
	for ($ib=0;$ib<count($bn);$ib++){
		if (eregi("[0-9]+",$bn[$ib]) and $bn[$ib] != 0)
			$result=@mysql_query("update $resordertable set number=$bn[$ib],date=now() WHERE ID=$mess[$ib]");
		unset($result);
	}
//
// ------------basket------------
//
if (isset($link) and $link != ''){ //link
	$result = @mysql_query('SELECT res.*,
dpa.name AS prof_area_name,
dp.name AS prof_name,
dwr.name AS region_name,
dwc.name AS city_name,
u.fio AS ufio, u.email AS uemail, u.hidemail AS uhidemail, u.city AS ucity_id, u.telephone AS utelephone, u.url AS uurl, u.firm AS ufirm, u.gender AS ugender, u.family AS ufamily, u.civil AS ucivil, u.prof AS uprof, u.dopsved AS udopsved, u.category AS ucategory, u.foto1 AS ufoto1, u.foto2 AS ufoto2,
fav.id AS favourit,
CURRENT_DATE,(YEAR(CURRENT_DATE)-YEAR(res.birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(res.birth,5)) AS age,DATE_FORMAT(res.date,"%d.%m.%Y") as date,LPAD(res.id,8,"0") as vID 
FROM '.$restable.' res 
LEFT JOIN '.$cattable.' dpa ON res.razdel = dpa.id
LEFT JOIN '.$podcattable.' dp ON res.podrazdel = dp.id
LEFT JOIN '.$citytable.' dwr ON res.region = dwr.id
LEFT JOIN '.$citytable.' dwc ON res.city = dwc.id
LEFT JOIN '.$autortable.' u ON res.aid = u.id
LEFT JOIN '.$resordertable.' fav ON res.id = fav.unit AND fav.status = "basket"
WHERE res.id='.$link.' and res.status="ok"');
	if (@mysql_num_rows($result) == 0)
		echo "<center>Объявление не определено!<br><br><a href=# onClick=history.go(-1)>Вернуться назад</a><br><br>";
	else { //ok
		while ($myrow=@mysql_fetch_array($result)){ //4
			$vID=$myrow["vID"];
			$ID=$myrow["ID"];
			$profecy=$myrow["profecy"];
			$zp=$myrow["zp"];
			$grafic=$myrow["grafic"];
			$zanatost=$myrow["zanatost"];
			$uslov=$myrow["uslov"];
			$comment=$myrow["comment"];
			$aid=$myrow["aid"];
			$date=$myrow["date"];
			$razdel=$myrow["razdel"];
			$podrazdel=$myrow["podrazdel"];
			$expir1org=$myrow["expir1org"];
			$expir1perfmonth=$myrow["expir1perfmonth"];
			$expir1perfyear=$myrow["expir1perfyear"];
			$expir1pertmonth=$myrow["expir1pertmonth"];
			$expir1pertyear=$myrow["expir1pertyear"];
			$expir1dol=$myrow["expir1dol"];
			$expir1obyaz=$myrow["expir1obyaz"];
			$expir2org=$myrow["expir2org"];
			$expir2perfmonth=$myrow["expir2perfmonth"];
			$expir2perfyear=$myrow["expir2perfyear"];
			$expir2pertmonth=$myrow["expir2pertmonth"];
			$expir2pertyear=$myrow["expir2pertyear"];
			$expir2dol=$myrow["expir2dol"];
			$expir2obyaz=$myrow["expir2obyaz"];
			$expir3org=$myrow["expir3org"];
			$expir3perfmonth=$myrow["expir3perfmonth"];
			$expir3perfyear=$myrow["expir3perfyear"];
			$expir3pertmonth=$myrow["expir3pertmonth"];
			$expir3pertyear=$myrow["expir3pertyear"];
			$expir3dol=$myrow["expir3dol"];
			$expir3obyaz=$myrow["expir3obyaz"];
			$expir4org=$myrow["expir4org"];
			$expir4perfmonth=$myrow["expir4perfmonth"];
			$expir4perfyear=$myrow["expir4perfyear"];
			$expir4pertmonth=$myrow["expir4pertmonth"];
			$expir4pertyear=$myrow["expir4pertyear"];
			$expir4dol=$myrow["expir4dol"];
			$expir4obyaz=$myrow["expir4obyaz"];
			$expir5org=$myrow["expir5org"];
			$expir5perfmonth=$myrow["expir5perfmonth"];
			$expir5perfyear=$myrow["expir5perfyear"];
			$expir5pertmonth=$myrow["expir5pertmonth"];
			$expir5pertyear=$myrow["expir5pertyear"];
			$expir5dol=$myrow["expir5dol"];
			$expir5obyaz=$myrow["expir5obyaz"];
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
			$email=$myrow["email"];
			$hidemail=$myrow["hidemail"];
			$country=$myrow["country"];
			$region=$myrow["region"];
			$city=$myrow["users_city_id"];
			$citytar=$city;
			$citys=$myrow['city_name'];
			if ($city < 1){
				$citytar=$region;
				$citys=$myrow['region_name'];
				if ($region <1){
					$citytar=$country_RUS;
					$citys='Россия';
				}
			}
			$telephone=$myrow["utelephone"];
			$adress=$myrow["audress"];
			$url=$myrow["uurl"];
			$firm=$myrow["ufirm"];
			$cfio=$myrow["ufio"];
			$gender=$myrow["ugender"];
			$family=$myrow["ufamily"];
			$civil=$myrow["ucivil"];
			$prof=$myrow["uprof"];
			$dopsved=$myrow["udopsved"];
			$age=$myrow["age"];
			$category=$myrow["ucategory"];
			$foto1=$myrow["ufoto1"];
			$foto2=$myrow["ufoto2"];
			$w='a';
			$fotlin="$aid";
			if ($category == 'agency'){
				$w='r';
				$fotlin="$ID";
				$age=$myrow["age"];
				$fio=$myrow["fio"];
				$gender=$myrow["gender"];
				$family=$myrow["family"];
				$civil=$myrow["civil"];
				$prof=$myrow["prof"];
				$dopsved=$myrow["dopsved"];
				$foto1=$myrow["foto1"];
			}
			$podrazdel1=$myrow["prof_name"];
			$razdel1=$myrow["prof_area_name"];
			if ($myrow['favourit'] > 0){
				$pic='remove.gif';
				$al='d';
				$sst='Удалить закладку';
			}else{
				$pic='add.gif';
				$al='p';
				$sst='Добавить закладку';
			}
			echo ("
  <h1 class=\"vacancy-title\">$profecy</h1>
<p class=\"company\">
");

			if ($catalog=='on')
				if ($category=='agency')
					echo "<a href=agency.php?r=vac&id=$aid>$afirm</a>";
				echo ("
</p>

<table width=100% border=0 class=\"vac-info\">
  <tr>
    <td> Уровень зарплаты </td>
    <td> Регион </td>
    <td> Отметить </td>
  </tr>
  <tr  class=\"vac-info2\">
    <td> от $zp $valute</td>
    <td>$citys</td>
    <td><a href=\"linkres.php?link=$link&$al=$ID\">$sst</a></b>&nbsp;|&nbsp;<a href=orderr.php>Просмотр закладок</a></td>
  </tr>
</table>
<div>
   <p><strong>Персональные данные:<br /></strong></p>
<table><tr><td valign=top>
");
			if ($foto1 != ''){
				$fotourl=$foto1;
				if (file_exists($photodir.'s'.$fotourl))
					$fotourl="s$fotourl";
				echo "<a href=\"photo.php?link=$fotlin&f=$photodir$foto1&w=$w\" target=_blank><img src=\"$photodir$fotourl\" height=$smallfotoheight alt=\"Увеличить\" border=0></a>";
			}
			echo "</td><td valign=top><ul>";
			if ($fio != '' and $category=='agency')
				echo "<b>ФИО</b>: $fio<br>";
			if ($cfio != '' and $category=='soisk')
				echo "<b>ФИО</b>: $cfio<br>";
			if ($gender == 'Мужской')
				echo "<b>Пол</b>: Мужской<br>";
			if ($gender == 'Женский')
				echo "<b>Пол</b>: Женский<br>";
			if ($age != 0)
				echo "<b>Возраст</b>: $age лет(года)<br>";
			if ($family != '')
				echo "<b>Семейное положение</b>: $family<br>";
			if ($civil != '')
				echo "<b>Гражданство</b>: $civil<br>";
			if ($category == 'soisk'){
				if ($citys != '')
					echo "<b>Город проживания</b>: $citys<br>";
				if ($telephone != '')
					echo "<b>Тел:</b>: $telephone<br>";
				if ($email != '' and $hidemail == 'checked')
					echo "<b>Email:</b> <a href=\"send.php?sendid=$aid\">Написать письмо</a><br>";
				if ($email != '' and $hidemail != 'checked')
					echo "<b>Email</b>: <a href=mailto:$email>$email</a><br>";
				echo "<a href=message.php?link=$aid>Отправить&nbsp;сообщение</a><br>";
			}
			echo ("
</ul></td></tr></table><br>
");
			echo ("
   <p><strong>Опыт работы: </strong></p>
");
			if ($expir5org != '' or $expir5perfmonth != '' or $expir5perfyear != '' or $expir5pertmonth != '' or $expir5pertyear != '' or $expir5dol != '' or $expir5obyaz != ''){
				echo "<br><br>$expir5perfmonth $expir5perfyear";
				if ($expir5pertmonth != '' or $expir5pertyear != '')
					echo " - $expir5pertmonth $expir5pertyear";
				if ($expir5org != '')
					echo " &nbsp;&nbsp;<b>$expir5org</b>";
				if ($expir5dol != '')
					echo " <br>Должность: <b>$expir5dol</b>";
				if ($expir5obyaz != ''){
					$expir5obyaz = ereg_replace("\n","<br>",$expir5obyaz);
					echo "<br><br>$expir5obyaz";
				}
			}
			if ($expir4org != '' or $expir4perfmonth != '' or $expir4perfyear != '' or $expir4pertmonth != '' or $expir4pertyear != '' or $expir4dol != '' or $expir4obyaz != ''){
				echo "<br><br>$expir4perfmonth $expir4perfyear";
				if ($expir4pertmonth != '' or $expir4pertyear != '')
					echo " - $expir4pertmonth $expir4pertyear";
				if ($expir4org != '')
					echo " &nbsp;&nbsp;<b>$expir4org</b>";
				if ($expir4dol != '')
					echo " <br>Должность: <b>$expir4dol</b>";
				if ($expir4obyaz != ''){
					$expir4obyaz = ereg_replace("\n","<br>",$expir4obyaz);
					echo "<br><br>$expir4obyaz";
				}
			}
			if ($expir3org != '' or $expir3perfmonth != '' or $expir3perfyear != '' or $expir3pertmonth != '' or $expir3pertyear != '' or $expir3dol != '' or $expir3obyaz != ''){
				echo "<br><br>$expir3perfmonth $expir3perfyear";
				if ($expir3pertmonth != '' or $expir3pertyear != '')
					echo " - $expir3pertmonth $expir3pertyear";
				if ($expir3org != '')
					echo " &nbsp;&nbsp;<b>$expir3org</b>";
				if ($expir3dol != '')
					echo " <br>Должность: <b>$expir3dol</b>";
				if ($expir3obyaz != ''){
					$expir3obyaz = ereg_replace("\n","<br>",$expir3obyaz);
					echo "<br><br>$expir3obyaz";
				}
			}
			if ($expir2org != '' or $expir2perfmonth != '' or $expir2perfyear != '' or $expir2pertmonth != '' or $expir2pertyear != '' or $expir2dol != '' or $expir2obyaz != ''){
				echo "<br><br>$expir2perfmonth $expir2perfyear";
				if ($expir2pertmonth != '' or $expir2pertyear != '')
					echo " - $expir2pertmonth $expir2pertyear";
				if ($expir2org != '')
					echo " &nbsp;&nbsp;<b>$expir2org</b>";
				if ($expir2dol != '')
					echo " <br>Должность: <b>$expir2dol</b>";
				if ($expir2obyaz != ''){
					$expir2obyaz = ereg_replace("\n","<br>",$expir2obyaz);
					echo "<br><br>$expir2obyaz";
				}
			}
			if ($expir1org != '' or $expir1perfmonth != '' or $expir1perfyear != '' or $expir1pertmonth != '' or $expir1pertyear != '' or $expir1dol != '' or $expir1obyaz != ''){
				echo "<br><br>$expir1perfmonth $expir1perfyear";
				if ($expir1pertmonth != '' or $expir1pertyear != '')
					echo " - $expir1pertmonth $expir1pertyear";
				if ($expir1org != '')
					echo " &nbsp;&nbsp;<b>$expir1org</b>";
				if ($expir1dol != '')
					echo " <br>Должность: <b>$expir1dol</b>";
				if ($expir1obyaz != ''){
					$expir1obyaz = ereg_replace("\n","<br>",$expir1obyaz);
					echo "<br><br>$expir1obyaz";
				}
			}
			echo "<br><br>";
			echo "<p><strong>Образование: </strong></p>";
			if ($edu5sel != '' or $edu5school != '' or $edu5year != '' or $edu5fac != '' or $edu5spec != ''){
				echo "<br><br><b>$edu5sel</b>";
				if ($edu5year != '')
					echo " $edu5year";
				if ($edu5school != '')
					echo " &nbsp;&nbsp;<b>$edu5school</b>";
				if ($edu5fac != '')
					echo " <br><b>Факультет</b>: $edu5fac";
				if ($edu5spec != '')
					echo " <br><b>Специальность</b>: $edu5spec";
			}
			if ($edu4sel != '' or $edu4school != '' or $edu4year != '' or $edu4fac != '' or $edu4spec != ''){
				echo "<br><br><b>$edu4sel</b>";
				if ($edu4year != '')
					echo " $edu4year";
				if ($edu4school != '')
					echo " &nbsp;&nbsp;<b>$edu4school</b>";
				if ($edu4fac != '')
					echo " <br><b>Факультет</b>: $edu4fac";
				if ($edu4spec != '')
					echo " <br><b>Специальность</b>: $edu4spec";
			}
			if ($edu3sel != '' or $edu3school != '' or $edu3year != '' or $edu3fac != '' or $edu3spec != ''){
				echo "<br><br><b>$edu3sel</b>";
				if ($edu3year != '')
					echo " $edu3year";
				if ($edu3school != '')
					echo " &nbsp;&nbsp;<b>$edu3school</b>";
				if ($edu3fac != '')
					echo " <br><b>Факультет</b>: $edu3fac";
				if ($edu3spec != '')
					echo " <br><b>Специальность</b>: $edu3spec";
			}
			if ($edu2sel != '' or $edu2school != '' or $edu2year != '' or $edu2fac != '' or $edu2spec != ''){
				echo "<br><br><b>$edu2sel</b>";
				if ($edu2year != '')
					echo " $edu2year";
				if ($edu2school != '')
					echo " &nbsp;&nbsp;<b>$edu2school</b>";
				if ($edu2fac != '')
					echo " <br><b>Факультет</b>: $edu2fac";
				if ($edu2spec != '')
					echo " <br><b>Специальность</b>: $edu2spec";
			}
			if ($edu1sel != '' or $edu1school != '' or $edu1year != '' or $edu1fac != '' or $edu1spec != ''){
				echo "<br><br><b>$edu1sel</b>";
				if ($edu1year != '')
					echo " $edu1year";
				if ($edu1school != '')
					echo " &nbsp;&nbsp;<b>$edu1school</b>";
				if ($edu1fac != '')
					echo " <br><b>Факультет</b>: $edu1fac";
				if ($edu1spec != '')
					echo " <br><b>Специальность</b>: $edu1spec";
			}
			echo "<br><br>";
			echo "<p><strong>Владение языками: </strong></p>";
			if ($lang5 != '' or $lang5uroven != ''){
				echo "<br>$lang5";
				if ($lang5uroven != '')
					echo "&nbsp;-&nbsp;$lang5uroven";
			}
			if ($lang4 != '' or $lang4uroven != ''){
				echo "<br>$lang4";
				if ($lang4uroven != '')
					echo "&nbsp;-&nbsp;$lang4uroven";
			}
			if ($lang3 != '' or $lang3uroven != ''){
				echo "<br>$lang3";
				if ($lang3uroven != '')
					echo "&nbsp;-&nbsp;$lang3uroven";
			}
			if ($lang2 != '' or $lang2uroven != ''){
				echo "<br>$lang2";
				if ($lang2uroven != '')
					echo "&nbsp;-&nbsp;$lang2uroven";
			}
			if ($lang1 != '' or $lang1uroven != ''){
				echo "<br>$lang1";
				if ($lang1uroven != '')
					echo "&nbsp;-&nbsp;$lang1uroven";
			}
			echo "<br><br>";
			if ($prof != '')
				echo ("
<p><strong>Профессиональные навыки: </strong></p>
$prof<br><br>
");
			if ($uslov != '')
				echo ("
   <p><strong>Условия: </strong></p>
$uslov<br><br>
");
			if ($zanatost != '')
				echo ("
   <p><strong>Тип занятости: </strong></p>
$zanatost $grafic<br><br>
");
			if ($dopsved != '')
				echo ("
   <p><strong>Дополнительные сведения: </strong></p>
$dopsved<br><br>
");
			echo "</div>";
		} //4
		if ($pr != 'print')
			echo "<a href=zhaloba.php?r=res&link=$link>Пожаловаться на резюме</a><br>";
		if ($pr != 'print')
			echo "<a href=linkres.php?link=$link&pr=print>Версия для печати</a><br>";
		if ($pr == 'print')
			echo "<a href=linkres.php?link=$link>Обычная версия</a><br>";
		echo "<br>";
		if ($pr != 'print'){ // noprint
			$sid=$_SESSION['sid'];
			$id=$_SESSION['sid'];
			$slogin=$_SESSION['slogin'];
			$spass=$_SESSION['spass'];
			$result = @mysql_query("SELECT email,pass,category FROM $autortable WHERE (email = '$slogin' and pass = '$spass' and (category='rab' or category='agency'))");
			if ((isset($slogin) and isset($spass)) and @mysql_num_rows($result) != 0){ // авторизирован
				$resultres = @mysql_query("SELECT ID,profecy,aid,status FROM $vactable WHERE aid = '$sid' and status='ok'");
				if (@mysql_num_rows($resultres) == 0)
					echo "Вы не добавили ни одной вакансии. Чтобы предложить свою вакансию соискателю <a href=addvac.php>добавьте вакансию</a>";
				if (@mysql_num_rows($resultres) == 1){
					while($myrow=mysql_fetch_array($resultres))
						$vacID=$myrow["ID"];
					echo ("
<form name=form method=post action=sendvac.php?send ENCTYPE=multipart/form-data>
<input type=hidden name=p value=$link>
<input type=hidden name=vacID value=$vacID>
<input type=submit value=\"Предложить свою вакансию соискателю\" name=\"send\" class=i3>
</form>
");
				}
				if (@mysql_num_rows($resultres) > 1){
					echo ("
<form name=form method=post action=sendvac.php?send ENCTYPE=multipart/form-data>
<input type=hidden name=p value=$link>
<input type=hidden name=link value=$link>
<select name=vacID size=1>
");
					while($myrow=mysql_fetch_array($resultres)){
						$vacID=$myrow["ID"];
						$vacprofecy=$myrow["profecy"];
						echo "<option value=\"$vacID\">$vacprofecy</option>";
						echo ("
</select>
<input type=submit value=\"Предложить выбраную вакансию соискателю\" name=\"send\" class=i3>
</form>
");
					}
				}
			} // авторизирован
			if ((!isset($slogin) or !isset($spass)) or @mysql_num_rows($result) == 0){
				echo ("
Для предложения своей вакансии соискателю <a href=autor.php>авторизируйтесь как работодатель или агентство</a>
</form>
");
			}
		} // noprint
// похожие
		if ($pr != 'print'){ // noprint
			$resultn = @mysql_query("SELECT ID,profecy,zp,status,date,country,region,city FROM $restable WHERE status='ok' and ID != '$link' and profecy REGEXP '$profecy' $qwery1 order by RAND() LIMIT 5");
			$totaltextsn=@mysql_num_rows($resultn);
			if ($totaltextsn != 0) {
				echo ("
<br><div align=center>
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0 class=tbl1>
<tr bgcolor=$maincolor><td valign=top><b>Похожие резюме</b></td></tr>
<tr bgcolor=$maincolor><td valign=top>
");
				while($myrow=mysql_fetch_array($resultn)) {
					$wid=$myrow["ID"];
					$profecy=$myrow["profecy"];
					$zp=$myrow["zp"];
					echo "<a href=linkres.php?link=$wid><b>$profecy</b></a>";
					if ($zp != 0)
						echo "<font color=#777777>&nbsp;-&nbsp;$zp $valute</font>";
					echo "<br>";
				}
				echo ("
</td></tr>
</table></div><br>
");
			}
		} // noprint
//похожие
	} // ok
} // link
$basketurl="linkres.php?link=$link";
if ($pr != 'print')
	include("down.php");
?>