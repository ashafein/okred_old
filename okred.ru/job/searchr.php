<?
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
include("var.php");
echo"<title>Поиск резюме: $sitename</title>";
include("top.php");
$n = getenv('REQUEST_URI');

$p=$_GET['p'];
$d=$_GET['d'];
$bn=$_GET['bn'];
$page=$_GET['page'];
if ($ident == 'session') {$REMOTE_ADDR=$PHPSESSID;}
if ($ident != 'session') {$REMOTE_ADDR=$_SERVER['REMOTE_ADDR'];}

// ------------del old------------
$expdate = date("Y-m-d H:i:s", time()- $delperiod*86400);
$delitemdb=mysql_query("delete from $resordertable where date < '$expdate'");
// ------------del old------------

$updres=mysql_query("update $restable set top='0000-00-00 00:00:00' where ((top + INTERVAL 86400*$periodfortop SECOND) < now())");
$updres=mysql_query("update $restable set bold='0000-00-00 00:00:00' where ((bold + INTERVAL 86400*$periodforbold SECOND) < now())");

//
// ------------basket------------
//
if (isset($p) and $p != "")
{ //additem
	$selectresult = @mysql_query("SELECT * FROM $resordertable WHERE (user = '$REMOTE_ADDR' and unit=$p and status='basket')");
	if (@mysql_num_rows($selectresult) == 0)
	{
		$sql="insert into $resordertable (user,unit,number,date,status) values ('$REMOTE_ADDR',$p,1,now(),'basket')";
		$addresult=@mysql_query($sql,$db);
	}
} //additem
elseif (isset($d) and $d != "")
{ //removeitem
	$selectresult = @mysql_query("SELECT * FROM $resordertable WHERE (user = '$REMOTE_ADDR' and unit=$d and status='basket')");
	if (@mysql_num_rows($selectresult) != 0)
	{
		$delresult=@mysql_query("delete from $resordertable where (user = '$REMOTE_ADDR' and unit=$d and status='basket')");
	}
} //removeitem
if (isset($bn) and $bn != "")
{ //count
	for ($ib=0;$ib<count($bn);$ib++){
		if (eregi("[0-9]+",$bn[$ib]) and $bn[$ib] != 0)
			{$result=@mysql_query("update $resordertable set number=$bn[$ib],date=now() WHERE ID=$mess[$ib]");}
		unset($result);
	}
} //count
//
// ------------basket------------
//

if ($_GET['srcountry'] == '' and $_GET['srregion'] == '' and $_GET['srcitys1'] == '')
{
	if ($srcity != '')
	{ // city
		if (eregi("^[r]",$srcity)) {
			$srcityshow1=@substr($srcity,1,1000);
			$qwery1="and country = '$srcityshow1'";
		}
		if (eregi("^[p]",$srcity)) {
			$srcityshow1=@substr($srcity,1,1000);
			$qwery1="and region = '$srcityshow1'";
		}
		if (eregi("^[c]",$srcity)) {
			$srcityshow1=@substr($srcity,1,1000);
			$qwery1="and city = '$srcityshow1'";
		}
	} // city
	if ($srcity == "") {$qwery1='';}
}

if (!isset($_GET['submit']) and !isset($page)) {
	echo "<form name=search method=GET action=\"searchr.php?search\">";
	$srregion=$_GET['srregion'];
	$srcountry=$_GET['srcountry'];
	$srcitys1=$_GET['srcitys1'];
	$srrazdel=$_GET['srrazdel'];
	$srpodrazdel=$_GET['srpodrazdel'];

	if ($srcountry == '' and $srregion == '' and $srcitys1 == '')
	{ //невыбрана
		if ($srcity != '')
		{ // city
			if (eregi("^[r]",$srcity)) {
				$srcountry=@substr($srcity,1,1000);
			}
			if (eregi("^[p]",$srcity)) {
				$srregion=@substr($srcity,1,1000);
				$resultadd1 = @mysql_query("SELECT * FROM $citytable WHERE ID='$srregion' LIMIT 1");
				while($myrow2=mysql_fetch_array($resultadd1)) {
					$srcountry=$myrow2["razdel"];
				}    
				$resultadd1 = @mysql_query("SELECT * FROM $citytable WHERE razdel='$srcountry' and podrazdel = '' and categ = '' LIMIT 1");
				while($myrow2=mysql_fetch_array($resultadd1)) {
					$srcountry=$myrow2["ID"];
				}    
			}
			if (eregi("^[c]",$srcity)) {
				$srcitys1=@substr($srcity,1,1000);
					$resultadd1 = @mysql_query("SELECT * FROM $citytable WHERE ID='$srcitys1' LIMIT 1");
				while($myrow2=mysql_fetch_array($resultadd1)) {
					$srcountry=$myrow2["razdel"];
					$srregion=$myrow2["podrazdel"];
				}    
				$resultadd1 = @mysql_query("SELECT * FROM $citytable WHERE razdel='$srcountry' and podrazdel = '' and categ = '' LIMIT 1");
				while($myrow2=mysql_fetch_array($resultadd1)) {
					$srcountry=$myrow2["ID"];
				}    
				$resultadd1 = @mysql_query("SELECT * FROM $citytable WHERE podrazdel='$srregion' and categ = '' LIMIT 1");
				while($myrow2=mysql_fetch_array($resultadd1)) {
					$srregion=$myrow2["ID"];
				}    
			}
		} // city
	} //невыбрана
	echo ("
<center><table bgcolor=$maincolor border=0 width=100% cellpadding=4 cellspacing=10 class=tbl1>
<tr bgcolor=#F9F9F9><td align=left>Сфера деятельности:</td>
<td align=left>
<select class=for  name=srrazdel size=1 onChange=location.href=location.pathname+\"?srrazdel=\"+value+\"\";>
<option></option>
");
	$prof_area_query = @mysql_query("SELECT * FROM $cattable order by name");
	while($prof_area_row=mysql_fetch_array($prof_area_query)) {
		echo "<option";
		if($prof_area_row["id"] == $srrazdel) echo " selected";
		echo " value='".$prof_area_row["id"]."'>".$prof_area_row["name"]."</option>";
	}
	echo ("
</select></td></tr>
");
	if ($srrazdel != '')
	{
		$prof_query = @mysql_query("SELECT * FROM $podcattable WHERE dict_prof_area_id=$srrazdel order by name");
		if (@mysql_num_rows($prof_query) != 0) {
			echo ("
<tr bgcolor=#F9F9F9><td align=left>Профессия:</td>
<td align=left><select class=for  name=srpodrazdel size=1 onChange=location.href=location.pathname+\"?srrazdel=$srrazdel&srpodrazdel=\"+value+\"\";>
<option></option>
");
			while($prof_row=mysql_fetch_array($prof_query)) {
				echo "<option";
				if($prof_row["id"] == $srpodrazdel) echo " selected";
				echo " value='".$prof_row["id"]."'>".$prof_row["name"]."</option>";
			}
			echo ("
</select>
</td></tr>
");
		}
	}
	echo ("
<tr bgcolor=#F9F9F9><td valign=top align=left>Область:</td>
<td valign=top align=left>
<select class=for  name=srcountry size=1 onChange=location.href=location.pathname+\"?srw=$srw&srrazdel=$srrazdel&srpodrazdel=$srpodrazdel&srcountry=\"+value+\"\";>
<option></option>
");
	$region_query = @mysql_query("SELECT * FROM $citytable WHERE country_ref = $country_RUS AND ISNULL(city_ref) AND region_ref > 0 ORDER BY name");
	while($region_row=mysql_fetch_array($region_query)) {
		echo "<option";
		if($region_row["id"] == $srcountry) echo " selected";
		echo " value='".$region_row["id"]."'>".$region_row["name"]."</option>";
	}
	echo ("
</select></td></tr>
");
	if ($srcountry != '')
	{ // страна
		$city_query = @mysql_query("SELECT * FROM $citytable WHERE region_ref = $srcountry AND NOT ISNULL(city_ref) ORDER BY name");
		if (@mysql_num_rows($city_query) != 0)
		{ // есть регион
			echo ("
<tr bgcolor=#F9F9F9><td valign=top align=left>Город:</td>
<td valign=top align=left><select class=for  name=srregion size=1 onChange=location.href=location.pathname+\"?srw=$srw&srrazdel=$srrazdel&srpodrazdel=$srpodrazdel&srcountry=$srcountry&srregion=\"+value+\"\";>
<option></option>
");
			while($city_row=mysql_fetch_array($city_query)) {
				echo "<option";
				if($city_row["id"] == $srregion) echo " selected";
				echo " value='".$city_row["id"]."'>".$city_row["name"]."</option>";
			}
			echo ("
</select></td></tr>
");
		} // есть регион
	} // страна
	echo ("
<tr bgcolor=#F9F9F9>
<td align=left>Должность:</td>
<td align=left><input type=text class=for  name=srprofecy size=20></td>
</tr>
<tr bgcolor=#F9F9F9><td align=left>Возраст:</td>
<td align=left>от <input type=text class=for  name=agemin size=3>&nbsp; до <input type=text class=for  name=agemax size=3> лет</td></tr>
<tr bgcolor=#F9F9F9><td align=left>Зарплата:</td>
<td><input type=text class=for  name=srzp size=5>&nbsp;$valute</td></tr>
<tr bgcolor=#F9F9F9><td align=left>Занятость:</td>
<td><select class=for  name=srzanatost size=1>
<option selected value=nnn>Не важно</option>
<option value=\"Полная\">Полная</option>
<option value=\"По&nbsp;совместительству\">По&nbsp;совместительству</option>
</select></td></tr>
<tr bgcolor=#F9F9F9><td align=left>График работы:</td>
<td><select class=for  name=srgrafic size=1>
<option selected value=nnn>Не важно</option>
<option value=\"Полный&nbsp;день\">Полный&nbsp;день</option>
<option value=\"Неполный&nbsp;день\">Неполный&nbsp;день</option>
<option value=\"Свободный&nbsp;график\">Свободный&nbsp;график</option>
<option value=\"Удаленная&nbsp;работа\">Удаленная&nbsp;работа</option>
</select></td></tr>
<tr bgcolor=#F9F9F9>
<td align=left>Пол:</td>
<td align=left><select class=for  name=srgender size=1>
<option selected value=nnn>Любой</option>
<option value=Мужской>Мужской</option>
<option value=Женский>Женский</option>
</select>
</td></tr>
<tr bgcolor=#F9F9F9>
<td align=left>Ключевые слова:</td>
<td align=left><input type=text class=for  name=srcomment size=20></td>
</tr>
<tr bgcolor=#F9F9F9>
<td colspan=2 align=left>Добавленные за последние:&nbsp;
<select class=for  name=per size=1>
<option selected value=30>30</option>
<option value=15>15</option>
<option value=10>10</option>
<option value=5>5</option>
<option value=3>3</option>
<option value=1>1</option>
</select> дней</td>
</tr>
<tr bgcolor=#F9F9F9>
<td colspan=2 align=left>Показывать резюме на странице:&nbsp;
<select class=for  name=maxThread size=1>
<option selected value=10>10</option>
<option value=25>25</option>
<option value=50>50</option>
</select></td>
</tr>
<tr bgcolor=$maincolor>
<td colspan=2 align=center>&nbsp;</td></tr>
<tr bgcolor=$maincolor>
<td colspan=2 align=center><input type=submit value=Искать name=submit class=dob></td></tr>
</table>
</form>
");
}
if (isset($_GET['submit']) or isset($page)) {

	$srregion=$_GET['srregion'];
	$srcountry=$_GET['srcountry'];
	$srcitys1=$_GET['srcitys1'];
	$srpodrazdel=$_GET['srpodrazdel'];
	$srrazdel=$_GET['srrazdel'];
	$srprofecy=$_GET['srprofecy'];
	$agemin=$_GET['agemin'];
	$agemax=$_GET['agemax'];
	$sredu=$_GET['sredu'];
	$srzp=$_GET['srzp'];
	$srzanatost=$_GET['srzanatost'];
	$srgrafic=$_GET['srgrafic'];
	$srgender=$_GET['srgender'];
	$srcomment=$_GET['srcomment'];
	$srtime=$_GET['srtime'];
	$maxThread=$_GET['maxThread'];
	$ord=$_GET['ord'];

	$srcomment=mb_strtolower($srcomment);
	$srprofecy=mb_strtolower($srprofecy);

	$lsrprofecy='';
	$lsragemin='';
	$lsragemax='';
	$lsrzp='';
	$lsrzanatost='';
	$lsrgrafic='';
	$lsrgender='';
	$lsrcomment='';

	if ($srpodrazdel != '') {$qwerypodrazdel="and podrazdel = $srpodrazdel";}
	if ($srpodrazdel == '') {$qwerypodrazdel="";}
	if ($srrazdel != '') {$qweryrazdel="and razdel = $srrazdel";}
	if ($srrazdel == '') {$qweryrazdel="";}
	if ($srcountry != '') {$qwerycountry="and country = $srcountry";}
	if ($srcountry == '') {$qwerycountry="";}
	if ($srregion != '') {$qweryregion="and region = $srregion";}
	if ($srregion == '') {$qweryregion="";}
	if ($srcitys1 != '') {$qwerycity="and city = $srcitys1";}
	if ($srcitys1 == '') {$qwerycity="";}

	if ($srprofecy != "nnn" and $srprofecy != '') {$srprofecy = ereg_replace(" ","*.",$srprofecy); $lsrprofecy="and LOWER(profecy) REGEXP '$srprofecy'";}
	if ($srcomment != '') {$srcomment = ereg_replace(" ","*.",$srcomment); $lsrcomment="and (LOWER(profecy) REGEXP '$srcomment' or LOWER(uslov) REGEXP '$srcomment' or LOWER(civil) REGEXP '$srcomment' or LOWER(edu) REGEXP '$srcomment' or LOWER(dopedu) REGEXP '$srcomment' or LOWER(languages) REGEXP '$srcomment' or LOWER(expir) REGEXP '$srcomment' or LOWER(prof) REGEXP '$srcomment' or LOWER(dopsved) REGEXP '$srcomment')";}
	if ($agemin != "nnn" and $agemin != '') {$lsragemin="and (birth = '0000-00-00' or (YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) >= '$agemin')";}
	if ($agemax != "nnn" and $agemax != '') {$lsragemax="and (birth = '0000-00-00' or (YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) <= '$agemax')";}
	if ($srzp != "" and $srzp != 'nnn') {$lsrzp="and zp <= $srzp or zp=0";}
	if ($srzanatost != "nnn" and $srzanatost != '') {
		if ($srzanatost == 'Полная') {$lsrzanatost="and zanatost REGEXP 'Полная'";}
		if (eregi ('совместительству',$srzanatost)) {$lsrzanatost="and zanatost REGEXP 'По&nbsp;совместительству'";}
	}
	if ($srgrafic != "nnn" and $srgrafic != '') {
		if ($srgrafic == 'Полный&nbsp;день') {$lsrgrafic="and (grafic = 'Полный&nbsp;день' or grafic = '' or grafic='Не&nbsp;важно')";}
		if (eregi ('Неполный',$srgrafic)) {$lsrgrafic="and (grafic = 'Неполный&nbsp;день' or grafic = '' or grafic='Не&nbsp;важно')";}
		if (eregi ('Свободный',$srzanatost)) {$lsrgrafic="and (grafic = 'Свободный&nbsp;график' or grafic = '' or grafic='Не&nbsp;важно')";}
		if (eregi ('Удаленная',$srzanatost)) {$lsrgrafic="and (grafic = 'Удаленная&nbsp;работа' or grafic = '' or grafic='Не&nbsp;важно')";}
	}
	if ($srgender != "nnn" and $srgender != '') {
		if ($srgender == 'Мужской') {$lsrgender="and gender REGEXP 'Мужской'";}
		if ($srgender == 'Женский') {$lsrgender="and gender REGEXP 'Женский'";}
	}
	if ($per != '') {$srper="and ((now() - INTERVAL 86400*$per SECOND) < date)";}
	if ($per == '') {$srper='';}
	
	if (!isset($ord) or $ord == "") {$qweryord='date DESC';}
	if (isset($ord) and $ord != "") {$qweryord=$ord;}
	if (!isset($maxThread) or $maxThread=='') {$maxThread = 10;}
	if(!isset($page)) $page = 1;
	$initialMsg = $maxThread * $page - $maxThread;
	
	$result = @mysql_query('SELECT SQL_CALC_FOUND_ROWS res.*, 
dwr.name AS region, 
dwc.name AS city, 
dpa.name AS prof_area_join, 
dp.name AS prof_join, 
u.fio AS name_user, u.prof AS prof, u.gender AS gender, u.category AS category, 
fav.id AS favourit, 
CURRENT_DATE,(YEAR(CURRENT_DATE)-YEAR(res.birth))-(RIGHT(CURRENT_DATE,5) < RIGHT(res.birth,5)) AS age, DATE_FORMAT(res.date,"%d.%m.%Y") as dateq 
FROM '.$restable.' res 
LEFT JOIN '.$citytable.' dwr ON res.region = dwr.id 
LEFT JOIN '.$citytable.' dwc ON res.city = dwc.id 
LEFT JOIN '.$cattable.' dpa ON res.razdel = dpa.id 
LEFT JOIN '.$podcattable.' dp ON res.podrazdel = dp.id 
LEFT JOIN '.$autortable.' u ON res.aid = u.id 
LEFT JOIN '.$resordertable.' fav ON res.id = fav.unit AND res.aid = fav.user AND fav.status = "basket" 
WHERE res.status="ok" '.$qweryrazdel.' '.$qwerypodrazdel.' '.$qwerycountry.' '.$qweryregion.' '.$qwerycity.' '.$lsrprofecy.' '.$lsragemin.' '.$lsragemax.' '.$lsrzp.' '.$lsrzanatost.' '.$lsrgrafic.' '.$lsrgender.' '.$lsrcomment.' '.$srper.' 
'.$qwery1.' order by top DESC,'.$qweryord.' LIMIT '.$initialMsg.', '.$maxThread);
	$result_rows = @mysql_fetch_array(@mysql_query("SELECT FOUND_ROWS()"));
	$totaltexts=$result_rows["FOUND_ROWS()"];;
	
	if( $totaltexts <= $maxThread ) $totalPages = 1;
		elseif( $totaltexts % $maxThread == 0 ) $totalPages = $totaltexts / $maxThread;
			else $totalPages = ceil( $totaltexts / $maxThread );
	if( $totaltexts == 0 ) $threadStart = 0;
		else $threadStart = $maxThread * $page - $maxThread + 1;
	if( $page == $totalPages ) $threadEnd = $totaltexts;
		else $threadEnd = $maxThread * $page;
	
	$pages = (int) (($totaltexts + $maxThread - 1) / $maxThread);
	$line = "<ul>";
	for ($k = 1; $k <= $pages; $k++) {
		if ($k != $page) {$line .= "<li><a href=\"searchr.php?srrazdel=$srrazdel&srpodrazdel=$srpodrazdel&srcountry=$srcountry&srregion=$srregion&srcitys1=$srcitys1&srprofecy=$srprofecy&agemin=$agemin&agemax=$agemax&srzp=$srzp&srzanatost=$srzanatost&srgrafic=$srgrafic&srgender=$srgender&srcomment=$srcomment&per=$per&maxThread=$maxThread&submit=submit&ord=$ord&page=$k\">$k</a></li>";}
		if ($k == $page) {$line .= "<li>$k </li>";}
	}
	$line .= "</ul>";

	if ($totaltexts == 0) {echo "<br><b>Резюме не найдены</b><br><br>";}
		elseif ($totaltexts != 0) 
		{ //2
			echo ("
<p class=\"path\"> Сортировать  <a href=\"searchr.php?srrazdel=$srrazdel&srpodrazdel=$srpodrazdel&srcountry=$srcountry&srregion=$srregion&srcitys1=$srcitys1&srprofecy=$srprofecy&agemin=$agemin&agemax=$agemax&srzp=$srzp&srzanatost=$srzanatost&srgrafic=$srgrafic&srgender=$srgender&srcomment=$srcomment&per=$per&maxThread=$maxThread&submit=submit&ord=date\">по дате</a> <a href=\"searchr.php?srrazdel=$srrazdel&srpodrazdel=$srpodrazdel&srcountry=$srcountry&srregion=$srregion&srcitys1=$srcitys1&srprofecy=$srprofecy&agemin=$agemin&agemax=$agemax&srzp=$srzp&srzanatost=$srzanatost&srgrafic=$srgrafic&srgender=$srgender&srcomment=$srcomment&per=$per&maxThread=$maxThread&submit=submit&ord=zp\">по зарплате</a></p>
");
			echo "<p>Найдено <b>$totaltexts</b> резюме</p>";
			while ($myrow=@mysql_fetch_array($result)) 
			{ //4
				$ID=$myrow["ID"];
				$profecy=$myrow["profecy"];
				$zp=$myrow["zp"];
				$grafic=$myrow["grafic"];
				$zanatost=$myrow["zanatost"];
				$aid=$myrow["aid"];

				$country=$myrow["country"];
				$region=$myrow["region"];
				$city=$myrow["city"];

				$citytar=$city;
				if (!empty($myrow["city"]))
					$citys = $myrow["city"];
				else
					$citys = $myrow["region"];

				$bold=$myrow["bold"];
				$boldstl='';
				if ($bold != '0000-00-00 00:00:00') {$boldstl="style=\"font-weight: bold;\"";}

				$prof=$myrow["prof"];
				$gender=$myrow["gender"];
				$age=$myrow["age"];
				$category=$myrow["category"];

				$date=$myrow["dateq"];
				$wrazdel=$myrow["razdel"];
				$wpodrazdel=$myrow["podrazdel"];
				$podrazdel1=$myrow["prof_join"];
				$razdel1=$myrow["prof_area_join"];
				$selectresult = $myrov["favourit"];
				if ($selectresult > 0)
					{$pic='remove.gif';$al='d';$sst='Удалить закладку';}
				else 
					{$pic='add.gif';$al='p';$sst='Добавить закладки';}
				
				echo ("
<table width=100% border=0 class=\"vacanc\">
  <tr>
    <td height=43 class=\"vac-title\"><a href=\"linkres.php?link=$ID\">$profecy</a></td>
    <td class=\"zp-vac\">
");
				if ($zp != 0) {echo "$zp $valute";}
				echo ("
</td>
    <td> $citys</td>
  </tr>
  <tr valign=top class=\"company\">
    <td height=25  class=\"company\">
");

				if ($gender == 'Мужской') {$br=1; echo "Мужчина&nbsp";}
				if ($gender == 'Женский') {$br=1; echo "Женщина&nbsp";}
				if ($age != 0) {$br=1; echo "$age лет(года)";}
				echo ("
</td>
    <td>$date</td>
    <td><a href=\"searchr.php?srrazdel=$srrazdel&srpodrazdel=$srpodrazdel&srcountry=$srcountry&srregion=$srregion&srcitys1=$srcitys1&srprofecy=$srprofecy&agemin=$agemin&agemax=$agemax&srzp=$srzp&srzanatost=$srzanatost&srgrafic=$srgrafic&srgender=$srgender&srcomment=$srcomment&per=$per&maxThread=$maxThread&submit=submit&ord=$ord&page=$page&$al=$ID\">$sst</a></td>
  </tr>
</table>
");
			} //4
		echo "<div class=\"pages\">$line</div>";
		} //2
}
include("down.php");
?>