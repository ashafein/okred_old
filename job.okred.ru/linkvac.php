<?
session_start();
session_name()
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
$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);

$link=$_GET['link'];
$pr=$_GET['pr'];

$resulttitle = @mysql_query("SELECT ID,profecy,treb,uslov,status FROM $vactable WHERE ID=$link and status='ok'");
while ($myrow=@mysql_fetch_array($resulttitle)) 
{
$profecy=$myrow["profecy"];
$treb=$myrow["treb"];
}
echo "<title>$profecy : �������� $sitename</title>";
echo "<META NAME=\"description\" CONTENT=\"$treb\">";

if ($pr != 'print') {include("top.php");}
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
if ($ident == 'session') {$REMOTE_ADDR=$PHPSESSID;}
if ($ident != 'session') {$REMOTE_ADDR=$_SERVER['REMOTE_ADDR'];}
$n = getenv('REQUEST_URI');
// ------------del old------------
$expdate = date("Y-m-d H:i:s", time()- $delperiod*86400);
$delitemdb=mysql_query("delete from $vacordertable where date < '$expdate'");
// ------------del old------------
//
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
if (isset($link) and $link != '') 
{ //link
$result = @mysql_query("SELECT *,DATE_FORMAT(date,'%d.%m.%Y') as date,LPAD(ID,8,'0') as vID FROM $vactable WHERE ID=$link and status='ok'");
if (@mysql_num_rows($result) == 0) {
echo "<center>���������� �� ����������!<br><br><a href=# onClick=history.go(-1)>��������� �����</a><br><br>";
}
else
{ //ok
while ($myrow=@mysql_fetch_array($result)) 
{ //4
$vID=$myrow["vID"];
$ID=$myrow["ID"];
$profecy=$myrow["profecy"];
$agemin=$myrow["agemin"];
$agemax=$myrow["agemax"];
$edu=$myrow["edu"];
$zp=$myrow["zp"];
$gender=$myrow["gender"];
$grafic=$myrow["grafic"];
$zanatost=$myrow["zanatost"];
$stage=$myrow["stage"];
$treb=$myrow["treb"];
$obyaz=$myrow["obyaz"];
$uslov=$myrow["uslov"];
$uslov = ereg_replace("\n","<br>",$uslov);
$obyaz = ereg_replace("\n","<br>",$obyaz);
$treb = ereg_replace("\n","<br>",$treb);

$country=$myrow["country"];
$region=$myrow["region"];
$city=$myrow["city"];

$citytar=$city;
if ($city=='0') {$citytar=$region;}
if ($region=='0' and $city=='0') {$citytar=$country;}
$resultadd3c = @mysql_query("SELECT * FROM $citytable WHERE ID='$citytar'");
while($myrowc=mysql_fetch_array($resultadd3c)) {
$citys=$myrowc["categ"];
if ($city=='0') {$citys=$myrowc["podrazdel"];}
if ($city=='0' and $region=='0') {$citys=$myrowc["razdel"];}
}

$adress=$myrow["adress"];
$metro=$myrow["metro"];
$firm=$myrow["firm"];
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

$selectresult = @mysql_query("SELECT * FROM $vacordertable WHERE (user = '$REMOTE_ADDR' and unit=$ID and status='basket')");
if (@mysql_num_rows($selectresult) == 0)
{$pic='add.gif';$al='p';$sst='�������� ��������';}
if (@mysql_num_rows($selectresult) != 0)
{$pic='remove.gif';$al='d';$sst='������� ��������';}

$resultaut = @mysql_query("SELECT * FROM $autortable WHERE ID='$aid'");
while ($myrow=mysql_fetch_array($resultaut)) {
$category=$myrow["category"];
$email=$myrow["email"];
$catalog=$myrow["catalog"];
$hidemail=$myrow["hidemail"];
$acountry=$myrow["country"];
$aregion=$myrow["region"];
$acity=$myrow["city"];

$citytar=$acity;
if ($acity=='0') {$citytar=$aregion;}
if ($aregion=='0' and $acity=='0') {$citytar=$acountry;}
$resultadd3c = @mysql_query("SELECT * FROM $citytable WHERE ID='$citytar'");
while($myrowc=mysql_fetch_array($resultadd3c)) {
$acitys=$myrowc["categ"];
if ($acity=='0') {$acitys=$myrowc["podrazdel"];}
if ($acity=='0' and $aregion=='0') {$acitys=$myrowc["razdel"];}
}

$telephone=$myrow["telephone"];
$aadress=$myrow["adress"];
$url=$myrow["url"];
$fio=$myrow["fio"];
$afirm=$myrow["firm"];
}

} //4
 
echo ("
  <h1 class=\"vacancy-title\">$profecy</h1>
<p class=\"company\">
");

if ($catalog=='on')
{
if ($category=='rab') {echo "<a href=rab.php?id=$aid>$afirm</a>";}
if ($category=='agency') {echo "<a href=agency.php?r=vac&id=$aid>$afirm</a>";}
}
if ($catalog != 'on')
{
echo "$afirm";
}


echo ("
</p>

<table width=100% border=0 class=\"vac-info\">
  <tr>
    <td> ������� �������� </td>
    <td> ������ </td>
    <td> �������� </td>
  </tr>
  <tr  class=\"vac-info2\">
    <td> $zp $valute</td>
    <td>$citys</td>
    <td><a href=\"linkvac.php?link=$link&$al=$ID\">$sst</a></b>&nbsp;|&nbsp;<a href=orderv.php>�������� ��������</a></td>
  </tr>
</table>
<div>

   <p><strong>����������:<br /></strong></p>
  <ul>

");

if ($agemin != 0 and $agemax == 0) {echo "<li>������� �� $agemin ���</li>";}
if ($agemin == 0 and $agemax != 0) {echo "<li>������� �� $agemax ���</li>";}
if ($agemin != 0 and $agemax != 0) {echo "<li>������� �� $agemin �� $agemax ���</li>";}
if ($gender == '�������') {echo "<li>��� �������</li>";}
if ($gender == '�������') {echo "<li>��� �������</li>";}
if ($edu != '' and !eregi("�����",$edu)) {echo "<li>����������� $edu</li>";}
if ($edu != '' and eregi("�����",$edu)) {echo "<li>����������� �����</li>";}
if ($stage != '') {echo "<li>���� ������ $stage</li>";}
if ($treb != '') {echo "<li>$treb</li>";}

echo ("
</ul><br>
");

if ($obyaz != '') {
echo ("
   <p><strong>�����������:�</strong></p>
$obyaz<br><br>
");
}

if ($uslov != '') {
echo ("
   <p><strong>�������:�</strong></p>
$uslov<br><br>
");
}

if ($zanatost != '') {
echo ("
   <p><strong>��� ���������:�</strong></p>
$zanatost $grafic<br><br>
");
}

echo ("

   <p><strong>���������� ����������:�</strong></p>
<ul>
");

if ($acitys != '') {echo "<li>�����: $acitys</li>";}
if ($metro != '') {echo "<li>�����: $metro</li>";}
if ($aadress != '') {echo "<li>�����: $aadress";}
if ($telephone != '') {echo "<li>�������: $telephone</li>";}
if ($email != '' and $hidemail == 'checked') {echo "<li>Email: <a href=\"send.php?sendid=$aid\">�������� ������</a></li><li><a href=message.php?link=$aid>���������&nbsp;���������</a></li>";}
if ($email != '' and $hidemail != 'checked') {echo "<li>Email: <a href=mailto:$email>$email</a></li><li><a href=message.php?link=$aid>���������&nbsp;���������</a></li>";}
if ($url != '') {echo "<li>URL: <a href=$url target=_blank>$url</a></li>";}

echo "</ul><br><br>";

if ($aadress != '')
{ 
//map

echo ("
<SCRIPT language=JavaScript>
function Hide(d) {document.getElementById(d).style.display = 'none';}
function Shw(d) {document.getElementById(d).style.display = 'block';}
</SCRIPT>
");

// google map
echo "<div id=\"gm1\"><a style=\"cursor: pointer;\" onclick=\"Hide('googlemap');Hide('gm1');Shw('gm2');\">������ ����� Google map</a><br></div>";
echo "<div id=\"gm2\" style=\"display : none;\"><a style=\"cursor: pointer;\" onclick=\"Shw('googlemap');Hide('gm2');Shw('gm1');\">�������� ����� Google map</a><br></div>";
$googlemap_city=trim($acitys);
$googlemap_city=ereg_replace(' ','+',$googlemap_city);
$googlemap_city=iconv('windows-1251', 'utf-8', $googlemap_city);
$googlemap_city=rawurlencode($googlemap_city);
$googlemap_city=ereg_replace('%2B','+',$googlemap_city);
$googlemap_adress=trim($aadress);
$googlemap_adress=ereg_replace(' ','+',$googlemap_adress);
$googlemap_adress=iconv('windows-1251', 'utf-8', $googlemap_adress);
$googlemap_adress=rawurlencode($googlemap_adress);
$googlemap_adress=ereg_replace('%2B','+',$googlemap_adress);
echo "<div id=\"googlemap\"><iframe width=\"450\" height=\"350\" frameborder=\"0\" scrolling=\"no\" marginheight=\"0\" marginwidth=\"0\" src=\"http://maps.google.ru/maps?f=q&amp;source=s_q&amp;hl=ru&amp;geocode=&amp;q=$googlemap_city,$googlemap_adress&amp;ie=UTF8&amp;hq=&amp;hnear=$googlemap_adress,$googlemap_city&amp;z=14&amp;output=embed\"></iframe><br /></div>";
echo "<br>";
// google map

// yandex map
if ($yandexapikey != '')
{
?>

<script src="http://api-maps.yandex.ru/1.1/index.xml?key=<? echo "$yandexapikey";?>" type="text/javascript"></script>

    <script type="text/javascript">
    var map, geoResult;
 
    window.onload = function () {
    	map = new YMaps.Map(document.getElementById("YMapsID"));
    	map.setCenter(new YMaps.GeoPoint(37.64, 55.76), 10);
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
    			alert("������ �� �������")
    		}
    	});
    }
 
    </script>

<?
$acitys=trim($acitys);
echo ("
<div id=\"ym2\" style=\"display : none;\"><a style=\"cursor: pointer;\" onclick=\"Hide('YMapsID');Hide('ym2');Shw('ym1');\">������ ����� ������</a><br></div>
<div id=\"YMapsID\" style=\"width:450px;height:350px\"></div>
<a id=\"ym1\" href=\"javascript:showAddress('$acitys, $aadress')\">�������� �� ������.�����</a><br>
");
echo "<br>";
}
// yandex map

//map
}


echo ("
</div>
");

//echo "<div class=\"otkl\"><a href=\"#\"></a></div>";



if ($pr != 'print') {
echo ("
<a href=zhaloba.php?r=vac&link=$link>������������ �� ��������</a><br>
");
}
if ($pr != 'print') {echo "<a href=linkvac.php?link=$link&pr=print>������ ��� ������</a><br>";}
if ($pr == 'print') {echo "<a href=linkvac.php?link=$link>������� ������</a><br>";}
if ($pr != 'print') {
echo ("
<a href=listvac.php?r=$razdel&c=$podrazdel>� ������ ��������</a><br><br>
");
}

if ($pr != 'print')
{ // noprint

$sid=$_SESSION['sid'];
$id=$_SESSION['sid'];
$slogin=$_SESSION['slogin'];
$spass=$_SESSION['spass'];

$result = @mysql_query("SELECT email,pass,category FROM $autortable WHERE (email = '$slogin' and pass = '$spass' and (category='soisk' or category='agency'))");
if ((isset($slogin) and isset($spass)) and @mysql_num_rows($result) != 0)
{ // �������������

$resultres = @mysql_query("SELECT ID,profecy,aid,status FROM $restable WHERE aid = '$sid' and status='ok'");

if (@mysql_num_rows($resultres) == 0) {
echo ("
�� �� �������� �� ������ ������. ����� ��������� ���� ������ �� �������� <a href=addres.php>�������� ������</a>
");
}

if (@mysql_num_rows($resultres) == 1) {
while($myrow=mysql_fetch_array($resultres)) {
$resID=$myrow["ID"];
}
echo ("
<form name=form method=post action=sendres.php?send ENCTYPE=multipart/form-data>
<input type=hidden name=p value=$link>
<input type=hidden name=resID value=$resID>
<input type=submit value=\"��������� ���� ������ �� ��� ��������\" name=\"send\" class=i3>
</form>
");
}

if (@mysql_num_rows($resultres) > 1) {
echo ("
<form name=form method=post action=sendres.php?send ENCTYPE=multipart/form-data>
<input type=hidden name=p value=$link>
<input type=hidden name=link value=$link>
<select name=resID size=1>
");
while($myrow=mysql_fetch_array($resultres)) {
$resID=$myrow["ID"];
$resprofecy=$myrow["profecy"];
echo ("
<option value=\"$resID\">$resprofecy</option>
");
}
echo ("
</select>
<input type=submit value=\"��������� �������� ������ �� ��� ��������\" name=\"send\" class=i3>
</form>
");
}

} // �������������

if ((!isset($slogin) or !isset($spass)) or @mysql_num_rows($result) == 0)
{
echo ("
��� �������� ����� ������ �� �������� <a href=autor.php>��������������� ��� ���������� ��� ���������</a>
</form>
");
}

} // noprint

// �������
if ($pr != 'print')
{ // noprint
$resultn = @mysql_query("SELECT ID,profecy,zp,status,date,country,region,city FROM $vactable WHERE status='ok' and ID != '$link' and profecy REGEXP '$profecy' $qwery1 order by RAND() LIMIT 5");
$totaltextsn=@mysql_num_rows($resultn);
if ($totaltextsn != 0) {
echo ("
<br><div align=center>
<table border=0 width=100% cellspacing=0 cellpadding=0 class=tbl1>
<tr ><td valign=top><b>������� ��������</b></td></tr>
<tr ><td valign=top>
");  
while($myrow=mysql_fetch_array($resultn)) {
$wid=$myrow["ID"];
$profecy=$myrow["profecy"];
$zp=$myrow["zp"];
echo "<a href=linkvac.php?link=$wid><b>$profecy</b></a>";
if ($zp != 0) {echo "<font color=#777777>&nbsp;-&nbsp;$zp $valute</font>";}
echo "<br>";
}
echo ("
</td></tr>
</table></div><br>
");
}
} // noprint
// �������

} // ok
} // link
$basketurl="linkvac.php?link=$link";

if ($pr != 'print') {include("down.php");}
?>