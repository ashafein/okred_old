<?
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
echo "<head>";
include("var.php");
echo "<title>Каталог работодателей : $sitename</title>";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\"><META HTTP-EQUIV=\"Cache-Control\" CONTENT=\"No-Cache\">";
include("top.php");

$updres=mysql_query("update $autortable set top='0000-00-00 00:00:00' where ((top + INTERVAL 86400*$periodfortop SECOND) < now())");
$updres=mysql_query("update $autortable set bold='0000-00-00 00:00:00' where ((bold + INTERVAL 86400*$periodforbold SECOND) < now())");

// ------------del old------------
$expdate = date("Y-m-d H:i:s", time()- $delperiod*86400);
$delitemdb=mysql_query("delete from $vacordertable where date < '$expdate'");
// ------------del old------------
//

$a=$_GET['a'];
$id=$_GET['id'];
$r=$_GET['r'];
$p=$_GET['p'];
$d=$_GET['d'];
$bn=$_GET['bn'];
if ($ident == 'session') {$REMOTE_ADDR=$PHPSESSID;}
if ($ident != 'session') {$REMOTE_ADDR=$_SERVER['REMOTE_ADDR'];}

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

// ------------basket------------
//
if (isset($p) and $p != "")
{ //additem
$selectresult = @mysql_query("SELECT * FROM $vacordertable WHERE (user = '$REMOTE_ADDR' and unit=$p and status='basket')");
if (@mysql_num_rows($selectresult) == 0)
{
$sql="insert into $vacordertable (user,unit,number,date,status) values ('$REMOTE_ADDR',$p,1,now(),'basket')";
$addresult=@mysql_query($sql,$db);
}
} //additem
elseif (isset($d) and $d != "")
{ //removeitem
$selectresult = @mysql_query("SELECT * FROM $vacordertable WHERE (user = '$REMOTE_ADDR' and unit=$d and status='basket')");
if (@mysql_num_rows($selectresult) != 0)
{
$delresult=@mysql_query("delete from $vacordertable where (user = '$REMOTE_ADDR' and unit=$d and status='basket')");
}
} //removeitem
if (isset($bn) and $bn != "")
{ //count
for ($ib=0;$ib<count($bn);$ib++){
if (eregi("[0-9]+",$bn[$ib]) and $bn[$ib] != 0)
{$result=@mysql_query("update $vacordertable set number=$bn[$ib],date=now() WHERE ID=$mess[$ib]");}
unset($result);
}
} //count
//
// ------------basket------------
//
if (!isset($id) or $id == '')
{ //3
echo "<h3 align=left>Каталог работодателей</h3>";
echo ("
<small><left>
<a href=\"rab.php\" title=\"Показать все\">*</a>&nbsp;
<a href=\"rab.php?a=a\">A</a>&nbsp;
<a href=\"rab.php?a=b\">B</a>&nbsp;
<a href=\"rab.php?a=c\">C</a>&nbsp;
<a href=\"rab.php?a=d\">D</a>&nbsp;
<a href=\"rab.php?a=e\">E</a>&nbsp;
<a href=\"rab.php?a=f\">F</a>&nbsp;
<a href=\"rab.php?a=g\">G</a>&nbsp;
<a href=\"rab.php?a=h\">H</a>&nbsp;
<a href=\"rab.php?a=i\">I</a>&nbsp;
<a href=\"rab.php?a=j\">J</a>&nbsp;
<a href=\"rab.php?a=k\">K</a>&nbsp;
<a href=\"rab.php?a=l\">L</a>&nbsp;
<a href=\"rab.php?a=m\">M</a>&nbsp;
<a href=\"rab.php?a=n\">N</a>&nbsp;
<a href=\"rab.php?a=o\">O</a>&nbsp;
<a href=\"rab.php?a=p\">P</a>&nbsp;
<a href=\"rab.php?a=q\">Q</a>&nbsp;
<a href=\"rab.php?a=r\">R</a>&nbsp;
<a href=\"rab.php?a=s\">S</a>&nbsp;
<a href=\"rab.php?a=t\">T</a>&nbsp;
<a href=\"rab.php?a=u\">U</a>&nbsp;
<a href=\"rab.php?a=v\">V</a>&nbsp;
<a href=\"rab.php?a=w\">W</a>&nbsp;
<a href=\"rab.php?a=x\">X</a>&nbsp;
<a href=\"rab.php?a=y\">Y</a>&nbsp;
<a href=\"rab.php?a=z\">Z</a>&nbsp;
<a href=\"rab.php?a=num\">0-9</a><br>
<a href=\"rab.php?a=а\">А</a>&nbsp;
<a href=\"rab.php?a=б\">Б</a>&nbsp;
<a href=\"rab.php?a=в\">В</a>&nbsp;
<a href=\"rab.php?a=г\">Г</a>&nbsp;
<a href=\"rab.php?a=д\">Д</a>&nbsp;
<a href=\"rab.php?a=е\">Е</a>&nbsp;
<a href=\"rab.php?a=ж\">Ж</a>&nbsp;
<a href=\"rab.php?a=з\">З</a>&nbsp;
<a href=\"rab.php?a=и\">И</a>&nbsp;
<a href=\"rab.php?a=к\">К</a>&nbsp;
<a href=\"rab.php?a=л\">Л</a>&nbsp;
<a href=\"rab.php?a=м\">М</a>&nbsp;
<a href=\"rab.php?a=н\">Н</a>&nbsp;
<a href=\"rab.php?a=о\">О</a>&nbsp;
<a href=\"rab.php?a=п\">П</a>&nbsp;
<a href=\"rab.php?a=р\">Р</a>&nbsp;
<a href=\"rab.php?a=с\">С</a>&nbsp;
<a href=\"rab.php?a=т\">Т</a>&nbsp;
<a href=\"rab.php?a=у\">У</a>&nbsp;
<a href=\"rab.php?a=ф\">Ф</a>&nbsp;
<a href=\"rab.php?a=х\">Х</a>&nbsp;
<a href=\"rab.php?a=ц\">Ц</a>&nbsp;
<a href=\"rab.php?a=ч\">Ч</a>&nbsp;
<a href=\"rab.php?a=ш\">Ш</a>&nbsp;
<a href=\"rab.php?a=щ\">Щ</a>&nbsp;
<a href=\"rab.php?a=э\">Э</a>&nbsp;
<a href=\"rab.php?a=ю\">Ю</a>&nbsp;
<a href=\"rab.php?a=я\">Я</a>&nbsp;
</left></small><br><left>
</div>
");
if (isset($a) and $a != '' and $a != 'num') {$abcline="and LOWER(firm) REGEXP '^$a'";}
elseif (isset($a) and $a != '' and $a == 'num') {$abcline="and firm REGEXP '^[0-9]'";}
else {$abcline="";}

$srtext=$_GET['srtext'];
$srtext=mb_strtolower($srtext);
if ($srtext != '') {$qwerytext="and LOWER(firm) REGEXP '$srtext'";}
if ($srtext == '') {$qwerytext="";}

$result = @mysql_query("SELECT * FROM $autortable WHERE category = 'rab' and catalog='on' $qwery1 $abcline $qwerytext");
$totaltexts=@mysql_num_rows($result);
if (!isset($maxThread) or $maxThread=='') {$maxThread = 20;}
if(!isset($page)) $page = 1;
if( $totaltexts <= $maxThread ) $totalPages = 1;
elseif( $totaltexts % $maxThread == 0 ) $totalPages = $totaltexts / $maxThread;
else $totalPages = ceil( $totaltexts / $maxThread );
if( $totaltexts == 0 ) $threadStart = 0;
else $threadStart = $maxThread * $page - $maxThread + 1;
if( $page == $totalPages ) $threadEnd = $totaltexts;
else $threadEnd = $maxThread * $page;
$initialMsg = $maxThread * $page - $maxThread;
$pages = (int) (($totaltexts + $maxThread - 1) / $maxThread);
$line = "Страница: |";
for ($k = 1; $k <= $pages; $k++) {
  if ($k != $page) {$line .= "<a href=\"rab.php?page=$k&a=$a&srtext=$srtext\"> $k </a>|";}
  if ($k == $page) {$line .= " $k |";}
}
$resultfr = @mysql_query("SELECT * FROM $autortable WHERE category = 'rab' and catalog='on' $qwery1 $abcline $qwerytext order by top DESC,firm LIMIT $initialMsg, $maxThread");
while($myrow=mysql_fetch_array($resultfr)) {
$ID=$myrow["ID"];
$country=$myrow["country"];
$region=$myrow["region"];
$city=$myrow["city"];

$bold=$myrow["bold"];
$boldstl='';
if ($bold != '0000-00-00 00:00:00') {$boldstl="style=\"font-weight: bold;\"";}

$citytar=$city;
if ($city=='0') {$citytar=$region;}
if ($region=='0' and $city=='0') {$citytar=$country;}
$resultadd3c = @mysql_query("SELECT * FROM $citytable WHERE ID='$citytar'");
while($myrowc=mysql_fetch_array($resultadd3c)) {
$citys=$myrowc["categ"];
if ($city=='0') {$citys=$myrowc["podrazdel"];}
if ($city=='0' and $region=='0') {$citys=$myrowc["razdel"];}
}

$firm=$myrow["firm"];
$fio=$myrow["fio"];
$deyat=$myrow["deyat"];
$email=$myrow["email"];
$hidemail=$myrow["hidemail"];
$telephone=$myrow["telephone"];
$url=$myrow["url"];
$adress=$myrow["adress"];
$date=$myrow["date"];
$foto2=$myrow["foto2"];
$vac = @mysql_query("SELECT ID,aid FROM $vactable WHERE aid='$ID'");
$totalvac = @mysql_num_rows($vac);
echo ("
<table border=0 width=100%  cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=4 width=100% class=tbl1>
<tr bgcolor=$maincolor><td colspan=2 $boldstl>
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
echo "<img src=\"$photodir$fotourl\" height=$height alt=\"$firm\" border=0><br>";
}
echo ("
<b>$firm</b></td></tr>
<tr bgcolor=$maincolor><td width=30%>Местонахождение:</td><td>$citys
");
if ($adress != '') {echo "&nbsp$adress";}
echo "</td></tr>";
if ($telephone != '') {echo "<tr bgcolor=$maincolor><td>Телефон:</td><td>$telephone</td></tr>";}
if ($email != '' and $hidemail != 'checked') {echo "<tr bgcolor=$maincolor><td>Email:</td><td><a href=mailto:$email>$email</a></td></tr>";}
if ($email != '' and $hidemail == 'checked') {echo "<tr bgcolor=$maincolor><td>Email:</td><td><a href=\"send.php?sendid=$ID\">Написать письмо</a></td></tr>";}
if ($url != '') {echo "<tr bgcolor=$maincolor><td>URL:</td><td><a href=$url>$url</a></td></tr>";}
if ($fio != '') {echo "<tr bgcolor=$maincolor><td>Контактное лицо:</td><td>$fio</td></tr>";}
if ($deyat != '') {echo "<tr bgcolor=$maincolor><td colspan=2>Направления деятельности:<br>$deyat</td></tr>";}
echo ("
<tr bgcolor=$maincolor><td colspan=2><a href=rab.php?id=$ID>Вакансии</a> ($totalvac)</td></tr>
</table></td></tr></table><br>
");    
}
echo "<p align=left class=tbl1>$line<br><br>";
} //3
elseif (isset($id) and $id != '')
{ //1
$resultfr = @mysql_query("SELECT * FROM $autortable WHERE ID=$id");
while($myrow=mysql_fetch_array($resultfr)) {
$ID=$myrow["ID"];
$country=$myrow["country"];
$region=$myrow["region"];
$city=$myrow["city"];
$catalog=$myrow["catalog"];

$citytar=$city;
if ($city=='0') {$citytar=$region;}
if ($region=='0' and $city=='0') {$citytar=$country;}
$resultadd3c = @mysql_query("SELECT * FROM $citytable WHERE ID='$citytar'");
while($myrowc=mysql_fetch_array($resultadd3c)) {
$citys=$myrowc["categ"];
if ($city=='0') {$citys=$myrowc["podrazdel"];}
if ($city=='0' and $region=='0') {$citys=$myrowc["razdel"];}
}

$firm=$myrow["firm"];
$fio=$myrow["fio"];
$deyat=$myrow["deyat"];
$email=$myrow["email"];
$hidemail=$myrow["hidemail"];
$telephone=$myrow["telephone"];
$url=$myrow["url"];
$adress=$myrow["adress"];
$date=$myrow["date"];
$vac = @mysql_query("SELECT ID,aid FROM $vactable WHERE aid='$ID'");
$totalvac = @mysql_num_rows($vac);
}

if ($catalog == 'on')
{ //cat
echo ("
<table border=0 width=100%  cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=4 width=100% class=tbl1>
<td colspan=2>
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
echo "<img src=\"$photodir$fotourl\" height=$height alt=\"$firm\" border=0><br>";
}
echo ("
<b>$firm</b></td></tr>
<tr bgcolor=$maincolor><td width=30%>Местонахождение:</td><td>$citys
");
if ($adress != '') {echo "&nbsp$adress";}

if ($adress != '')
{ 
//map

echo ("
<SCRIPT language=JavaScript>
function Hide(d) {document.getElementById(d).style.display = 'none';}
function Shw(d) {document.getElementById(d).style.display = 'block';}
</SCRIPT>
");

// google map
echo "<div id=\"gm1\"><a style=\"cursor: pointer;\" onclick=\"Hide('googlemap');Hide('gm1');Shw('gm2');\">Скрыть карту Google map</a><br></div>";
echo "<div id=\"gm2\" style=\"display : none;\"><a style=\"cursor: pointer;\" onclick=\"Shw('googlemap');Hide('gm2');Shw('gm1');\">Показать карту Google map</a><br></div>";
$googlemap_city=trim($citys);
$googlemap_city=ereg_replace(' ','+',$googlemap_city);
$googlemap_city=iconv('windows-1251', 'utf-8', $googlemap_city);
$googlemap_city=rawurlencode($googlemap_city);
$googlemap_city=ereg_replace('%2B','+',$googlemap_city);
$googlemap_adress=trim($adress);
$googlemap_adress=ereg_replace(' ','+',$googlemap_adress);
$googlemap_adress=iconv('windows-1251', 'utf-8', $googlemap_adress);
$googlemap_adress=rawurlencode($googlemap_adress);
$googlemap_adress=ereg_replace('%2B','+',$googlemap_adress);
echo "<div id=\"googlemap\"><iframe width=\"650\" height=\"350\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"http://maps.google.ru/maps?f=q&amp;source=s_q&amp;hl=ru&amp;geocode=&amp;q=$googlemap_city,$googlemap_adress&amp;ie=UTF8&amp;hq=&amp;hnear=$googlemap_adress,$googlemap_city&amp;z=14&amp;output=embed\"></iframe><br /></div>";
echo "<br>";
// google map

// yandex map
/*
if ($yandexapikey != '')
{
?>

<script src="http://api-maps.yandex.ru/1.1/index.xml?key=<? echo "$yandexapikey";?>" type="text/javascript"></script>

    <script type="text/javascript">
    var map, geoResult;
 
    window.onload = function () {
    	map = new YMaps.Map(document.getElementById("YMapsID"));
    	map.setleft(new YMaps.GeoPoint(37.64, 55.76), 10);
    	map.addControl(new YMaps.TypeControl());
    	document.getElementById('YMapsID').style.display = 'none';
    }
 
    function showAddress (value) {
    	document.getElementById('YMapsID').style.display = '';
    	document.getElementById('ym1').style.display = 'none';
    	document.getElementById('ym2').style.display = '';
    	map.removeOverlay(geoResult);
    	var geocoder = new YMaps.Geocoder(value, {results: 1, boundedBy: map.getBounds()});
 
    	YMaps.Events.observe(geocoder, geocoder.Events.Load, function () {
    		if (this.length()) {
    			geoResult = this.get(0);
    			map.addOverlay(geoResult);
    			map.setBounds(geoResult.getBounds());
    		}else {
    			alert("Ничего не найдено")
    		}
    	});
    }
 
    </script>

<?
$citys=trim($citys);
echo ("
<div id=\"ym2\" style=\"display : none;\"><a style=\"cursor: pointer;\" onclick=\"Hide('YMapsID');Hide('ym2');Shw('ym1');\">Скрыть карту Яндекс</a><br></div>
<div id=\"YMapsID\" style=\"width:450px;height:350px\"></div>
<a id=\"ym1\" href=\"javascript:showAddress('$citys, $adress')\">Смотреть на Яндекс.Карте</a><br>
");
echo "<br>";
}*/
// yandex map

//map
}

echo "</td></tr>";
if ($telephone != '') {echo "<tr bgcolor=$maincolor><td>Телефон:</td><td>$telephone</td></tr>";}
if ($email != '' and $hidemail != 'checked') {echo "<tr bgcolor=$maincolor><td>Email:</td><td><a href=mailto:$email>$email</a></td></tr>";}
if ($email != '' and $hidemail == 'checked') {echo "<tr bgcolor=$maincolor><td>Email:</td><td><a href=\"send.php?sendid=$aid\">Написать письмо</a></td></tr>";}
if ($url != '') {echo "<tr bgcolor=$maincolor><td>URL:</td><td><a href=$url>$url</a></td></tr>";}
if ($fio != '') {echo "<tr bgcolor=$maincolor><td>Контактное лицо:</td><td>$fio</td></tr>";}
if ($deyat != '') {echo "<tr bgcolor=$maincolor><td colspan=2>Направления деятельности:<br>$deyat</td></tr>";}
echo ("
<tr bgcolor=$maincolor><td colspan=2>
");
$result = @mysql_query("SELECT tid,status FROM $rabcommentstable WHERE tid = $link and status='ok'");
$totalcomment=@mysql_num_rows($result);
if ($totalcomment != 0) {echo "<a href=comcom.php?texid=$link>Отзывы о компании</a></b>&nbsp;<small>($totalcomment)</small>";}
if ($totalcomment == 0) {echo "<a href=comcom.php?texid=$link>Отзывы о компании</a>&nbsp;<small>($totalcomment)</small>";}
echo ("
</td></tr>
</table></td></tr></table><br>
");    
} //cat
if ($catalog != 'on')
{ //no cat
echo "<p align=left><b>Работодатель не включен в каталог организаций</b></p>";
} //no cat
echo "<h3>Вакансии работодателя</h3>";
$result = @mysql_query("SELECT * FROM $vactable WHERE aid='$id' and status='ok' order by date DESC");
$totaltexts=@mysql_num_rows($result);
if (!isset($maxThread) or $maxThread=='') {$maxThread = 10;}
if(!isset($page)) $page = 1;
if( $totaltexts <= $maxThread ) $totalPages = 1;
elseif( $totaltexts % $maxThread == 0 ) $totalPages = $totaltexts / $maxThread;
else $totalPages = ceil( $totaltexts / $maxThread );
if( $totaltexts == 0 ) $threadStart = 0;
else $threadStart = $maxThread * $page - $maxThread + 1;
if( $page == $totalPages ) $threadEnd = $totaltexts;
else $threadEnd = $maxThread * $page;
$initialMsg = $maxThread * $page - $maxThread;
$pages = (int) (($totaltexts + $maxThread - 1) / $maxThread);
$line = "Страница: |";
for ($k = 1; $k <= $pages; $k++) {
  if ($k != $page) {$line .= "<a href=\"rab.php?id=$id&page=$k\"> $k </a>|";}
  if ($k == $page) {$line .= " $k |";}
}
if ($totaltexts == 0) {
echo "<left><b>Нет объявлений!</b><br><br>";
}
else
{ //2
echo "<table border=0 width=90% cellspacing=0 cellpadding=0 class=tbl1><tr><td><a href=orderv.php><b>Просмотр закладок</b></a></td></tr></table><br>";
echo ("
<table border=0 width=90%  cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$maincolor><td><a href=orderv.php><img src=\"picture/basket.gif\" alt=\"Закладки\" border=0></a></td><td>Должность</td><td>Зарплата</td><td>Дата публ.</td></tr>
");
$result = @mysql_query("SELECT *,DATE_FORMAT(date,'%d.%m.%Y') as date FROM $vactable WHERE status='ok' and aid='$id' order by date DESC LIMIT $initialMsg, $maxThread");
while ($myrow=@mysql_fetch_array($result)) 
{ //4
$tID=$myrow["ID"];
$profecy=$myrow["profecy"];
$zp=$myrow["zp"];
$agemin=$myrow["agemin"];
$agemax=$myrow["agemax"];
$edu=$myrow["edu"];
$gender=$myrow["gender"];
$grafic=$myrow["grafic"];
$zanatost=$myrow["zanatost"];
$treb=$myrow["treb"];
$aid=$myrow["aid"];
$date=$myrow["date"];
$razdel=$myrow["razdel"];
$podrazdel=$myrow["podrazdel"];
$resultadd2 = @mysql_query("SELECT ID,podrazdel FROM $catable WHERE ID='$podrazdel'");
while($myrow=mysql_fetch_array($resultadd2)) {
$podrazdel1=$myrow["podrazdel"];
}
$resultadd1 = @mysql_query("SELECT ID,razdel,podrazdel FROM $catable WHERE podrazdel = '' and ID='$razdel'");
while($myrow=mysql_fetch_array($resultadd1)) {
$razdel1=$myrow["razdel"];
}
$selectresult = @mysql_query("SELECT * FROM $vacordertable WHERE (user = '$REMOTE_ADDR' and unit=$tID and status='basket')");
if (@mysql_num_rows($selectresult) == 0)
{$pic='add.gif';$al='p';$sst='Добавить закладку';}
if (@mysql_num_rows($selectresult) != 0)
{$pic='remove.gif';$al='d';$sst='Удалить закладку';}
echo ("
<tr bgcolor=$maincolor>
<td valign=top width=20><a href=\"rab.php?id=$id&page=$page&$al=$tID\"><img src=\"picture/$pic\" alt=\"$sst\" border=0></a></td>
<td valign=top><a href=linkvac.php?link=$tID><b>$profecy</b></a><br>$razdel1&nbsp;/&nbsp;$podrazdel1<br>
");
$br=0;
if ($gender == 'Мужской') {$br=1; echo "Мужчина&nbsp";}
if ($gender == 'Женский') {$br=1; echo "Женщина&nbsp";}
if ($agemin != 0 and $agemax == 0) {$br=1; echo "от $agemin лет;&nbsp";}
if ($agemin == 0 and $agemax != 0) {$br=1; echo "до $agemax лет;&nbsp";}
if ($agemin != 0 and $agemax != 0) {$br=1; echo "от $agemin до $agemax лет;&nbsp";}
if ($edu != '' and !eregi("важно",$edu)) {$br=1; echo "образование $edu;&nbsp";}
if ($grafic != '' and !eregi("важно",$grafic)) {echo "<br>$grafic";}
if ($br==1) {echo "<br>";}
echo ("
Требования: $treb
</td>
<td valign=top><b>$zp</b> $valute</td>
<td valign=top>$date<br><a href=linkvac.php?link=$tID><small>Подробнее...</small></a></td>
</tr>
");
} //4

echo ("
</table></td></tr></table><p align=left class=tbl1>$line<br><br>
");
} //2
} //1
include("down.php");
?>