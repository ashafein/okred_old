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

$resulttitle = @mysql_query("SELECT ID,profecy,status FROM $restable WHERE ID=$link and status='ok'");
while ($myrow=@mysql_fetch_array($resulttitle)) 
{
$profecy=$myrow["profecy"];
}
echo "<title>$profecy : ������ $sitename</title>";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\"><META HTTP-EQUIV=\"Cache-Control\" CONTENT=\"No-Cache\">";

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
$delitemdb=mysql_query("delete from $resordertable where date < '$expdate'");
// ------------del old------------
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
if (isset($link) and $link != '') 
{ //link
$result = @mysql_query("SELECT *,CURRENT_DATE,(YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) AS age,DATE_FORMAT(date,'%d.%m.%Y') as date,LPAD(ID,8,'0') as vID FROM $restable WHERE ID=$link and status='ok'");
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
$resultaut = @mysql_query("SELECT *,CURRENT_DATE,(YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) AS age FROM $autortable WHERE ID='$aid'");
while ($myrow1=mysql_fetch_array($resultaut)) {
$email=$myrow1["email"];
$hidemail=$myrow1["hidemail"];
$country=$myrow["country"];
$region=$myrow["region"];
$city=$myrow1["city"];

$citytar=$city;
if ($city=='0') {$citytar=$region;}
if ($region=='0' and $city=='0') {$citytar=$country;}
$resultadd3c = @mysql_query("SELECT * FROM $citytable WHERE ID='$citytar'");
while($myrowc=mysql_fetch_array($resultadd3c)) {
$citys=$myrowc["categ"];
if ($city=='0') {$citys=$myrowc["podrazdel"];}
if ($city=='0' and $region=='0') {$citys=$myrowc["razdel"];}
}

$telephone=$myrow1["telephone"];
$adress=$myrow1["adress"];
$url=$myrow1["url"];
$firm=$myrow1["firm"];
$cfio=$myrow1["fio"];
$gender=$myrow1["gender"];
$family=$myrow1["family"];
$civil=$myrow1["civil"];
$prof=$myrow1["prof"];
$dopsved=$myrow1["dopsved"];
$age=$myrow1["age"];
$category=$myrow1["category"];
$foto1=$myrow1["foto1"];
$foto2=$myrow1["foto2"];
}
$w='a';
$fotlin="$aid";
if ($category == 'agency')
{
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
$resultadd2 = @mysql_query("SELECT ID,podrazdel FROM $catable WHERE ID='$podrazdel'");
while($myrow=mysql_fetch_array($resultadd2)) {
$podrazdel1=$myrow["podrazdel"];
}
$resultadd1 = @mysql_query("SELECT ID,razdel,podrazdel FROM $catable WHERE podrazdel = '' and ID='$razdel'");
while($myrow=mysql_fetch_array($resultadd1)) {
$razdel1=$myrow["razdel"];
}
$selectresult = @mysql_query("SELECT * FROM $resordertable WHERE (user = '$REMOTE_ADDR' and unit=$ID and status='basket')");
if (@mysql_num_rows($selectresult) == 0)
{$pic='add.gif';$al='p';$sst='�������� ��������';}
if (@mysql_num_rows($selectresult) != 0)
{$pic='remove.gif';$al='d';$sst='������� ��������';}


echo ("
  <h1 class=\"vacancy-title\">$profecy</h1>
<p class=\"company\">
");

if ($catalog=='on')
{
if ($category=='agency') {echo "<a href=agency.php?r=vac&id=$aid>$afirm</a>";}
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
    <td> �� $zp $valute</td>
    <td>$citys</td>
    <td><a href=\"linkres.php?link=$link&$al=$ID\">$sst</a></b>&nbsp;|&nbsp;<a href=orderr.php>�������� ��������</a></td>
  </tr>
</table>
<div>




   <p><strong>������������ ������:<br /></strong></p>
<table><tr><td valign=top>
");
if ($foto1 != '')
{
$fotourl=$foto1;
if (file_exists($photodir.'s'.$fotourl)) {$fotourl="s$fotourl";}
echo "<a href=\"photo.php?link=$fotlin&f=$photodir$foto1&w=$w\" target=_blank><img src=\"$photodir$fotourl\" height=$smallfotoheight alt=\"���������\" border=0></a>";
}


echo "</td><td valign=top><ul>";

if ($fio != '' and $category=='agency') {echo "<b>���</b>: $fio<br>";}
if ($cfio != '' and $category=='soisk') {echo "<b>���</b>: $cfio<br>";}
if ($gender == '�������') {echo "<b>���</b>: �������<br>";}
if ($gender == '�������') {echo "<b>���</b>: �������<br>";}
if ($age != 0) {echo "<b>�������</b>: $age ���(����)<br>";}
if ($family != '') {echo "<b>�������� ���������</b>: $family<br>";}
if ($civil != '') {echo "<b>�����������</b>: $civil<br>";}
if ($category == 'soisk')
{
if ($citys != '') {echo "<b>����� ����������</b>: $citys<br>";}
if ($telephone != '') {echo "<b>���:</b>: $telephone<br>";}
if ($email != '' and $hidemail == 'checked') {echo "<b>Email:</b> <a href=\"send.php?sendid=$aid\">�������� ������</a><br>";}
if ($email != '' and $hidemail != 'checked') {echo "<b>Email</b>: <a href=mailto:$email>$email</a><br>";}
echo "<a href=message.php?link=$aid>���������&nbsp;���������</a><br>";
}

echo ("
</ul></td></tr></table><br>
");

echo ("
   <p><strong>���� ������:�</strong></p>
");
if ($expir5org != '' or $expir5perfmonth != '' or $expir5perfyear != '' or $expir5pertmonth != '' or $expir5pertyear != '' or $expir5dol != '' or $expir5obyaz != '') 
{
echo "<br><br>$expir5perfmonth $expir5perfyear";
if ($expir5pertmonth != '' or $expir5pertyear != '') {echo " - $expir5pertmonth $expir5pertyear";}
if ($expir5org != '') {echo " &nbsp;&nbsp;<b>$expir5org</b>";}
if ($expir5dol != '') {echo " <br>���������: <b>$expir5dol</b>";}
if ($expir5obyaz != '') {$expir5obyaz = ereg_replace("\n","<br>",$expir5obyaz); echo "<br><br>$expir5obyaz";}
}
if ($expir4org != '' or $expir4perfmonth != '' or $expir4perfyear != '' or $expir4pertmonth != '' or $expir4pertyear != '' or $expir4dol != '' or $expir4obyaz != '') 
{
echo "<br><br>$expir4perfmonth $expir4perfyear";
if ($expir4pertmonth != '' or $expir4pertyear != '') {echo " - $expir4pertmonth $expir4pertyear";}
if ($expir4org != '') {echo " &nbsp;&nbsp;<b>$expir4org</b>";}
if ($expir4dol != '') {echo " <br>���������: <b>$expir4dol</b>";}
if ($expir4obyaz != '') {$expir4obyaz = ereg_replace("\n","<br>",$expir4obyaz); echo "<br><br>$expir4obyaz";}
}
if ($expir3org != '' or $expir3perfmonth != '' or $expir3perfyear != '' or $expir3pertmonth != '' or $expir3pertyear != '' or $expir3dol != '' or $expir3obyaz != '') 
{
echo "<br><br>$expir3perfmonth $expir3perfyear";
if ($expir3pertmonth != '' or $expir3pertyear != '') {echo " - $expir3pertmonth $expir3pertyear";}
if ($expir3org != '') {echo " &nbsp;&nbsp;<b>$expir3org</b>";}
if ($expir3dol != '') {echo " <br>���������: <b>$expir3dol</b>";}
if ($expir3obyaz != '') {$expir3obyaz = ereg_replace("\n","<br>",$expir3obyaz); echo "<br><br>$expir3obyaz";}
}
if ($expir2org != '' or $expir2perfmonth != '' or $expir2perfyear != '' or $expir2pertmonth != '' or $expir2pertyear != '' or $expir2dol != '' or $expir2obyaz != '') 
{
echo "<br><br>$expir2perfmonth $expir2perfyear";
if ($expir2pertmonth != '' or $expir2pertyear != '') {echo " - $expir2pertmonth $expir2pertyear";}
if ($expir2org != '') {echo " &nbsp;&nbsp;<b>$expir2org</b>";}
if ($expir2dol != '') {echo " <br>���������: <b>$expir2dol</b>";}
if ($expir2obyaz != '') {$expir2obyaz = ereg_replace("\n","<br>",$expir2obyaz); echo "<br><br>$expir2obyaz";}
}
if ($expir1org != '' or $expir1perfmonth != '' or $expir1perfyear != '' or $expir1pertmonth != '' or $expir1pertyear != '' or $expir1dol != '' or $expir1obyaz != '') 
{
echo "<br><br>$expir1perfmonth $expir1perfyear";
if ($expir1pertmonth != '' or $expir1pertyear != '') {echo " - $expir1pertmonth $expir1pertyear";}
if ($expir1org != '') {echo " &nbsp;&nbsp;<b>$expir1org</b>";}
if ($expir1dol != '') {echo " <br>���������: <b>$expir1dol</b>";}
if ($expir1obyaz != '') {$expir1obyaz = ereg_replace("\n","<br>",$expir1obyaz); echo "<br><br>$expir1obyaz";}
}

echo "<br><br>";

echo ("
   <p><strong>�����������:�</strong></p>
");
if ($edu5sel != '' or $edu5school != '' or $edu5year != '' or $edu5fac != '' or $edu5spec != '')
{
echo "<br><br><b>$edu5sel</b>";
if ($edu5year != '') {echo " $edu5year";}
if ($edu5school != '') {echo " &nbsp;&nbsp;<b>$edu5school</b>";}
if ($edu5fac != '') {echo " <br><b>���������</b>: $edu5fac";}
if ($edu5spec != '') {echo " <br><b>�������������</b>: $edu5spec";}
}
if ($edu4sel != '' or $edu4school != '' or $edu4year != '' or $edu4fac != '' or $edu4spec != '')
{
echo "<br><br><b>$edu4sel</b>";
if ($edu4year != '') {echo " $edu4year";}
if ($edu4school != '') {echo " &nbsp;&nbsp;<b>$edu4school</b>";}
if ($edu4fac != '') {echo " <br><b>���������</b>: $edu4fac";}
if ($edu4spec != '') {echo " <br><b>�������������</b>: $edu4spec";}
}
if ($edu3sel != '' or $edu3school != '' or $edu3year != '' or $edu3fac != '' or $edu3spec != '')
{
echo "<br><br><b>$edu3sel</b>";
if ($edu3year != '') {echo " $edu3year";}
if ($edu3school != '') {echo " &nbsp;&nbsp;<b>$edu3school</b>";}
if ($edu3fac != '') {echo " <br><b>���������</b>: $edu3fac";}
if ($edu3spec != '') {echo " <br><b>�������������</b>: $edu3spec";}
}
if ($edu2sel != '' or $edu2school != '' or $edu2year != '' or $edu2fac != '' or $edu2spec != '')
{
echo "<br><br><b>$edu2sel</b>";
if ($edu2year != '') {echo " $edu2year";}
if ($edu2school != '') {echo " &nbsp;&nbsp;<b>$edu2school</b>";}
if ($edu2fac != '') {echo " <br><b>���������</b>: $edu2fac";}
if ($edu2spec != '') {echo " <br><b>�������������</b>: $edu2spec";}
}
if ($edu1sel != '' or $edu1school != '' or $edu1year != '' or $edu1fac != '' or $edu1spec != '')
{
echo "<br><br><b>$edu1sel</b>";
if ($edu1year != '') {echo " $edu1year";}
if ($edu1school != '') {echo " &nbsp;&nbsp;<b>$edu1school</b>";}
if ($edu1fac != '') {echo " <br><b>���������</b>: $edu1fac";}
if ($edu1spec != '') {echo " <br><b>�������������</b>: $edu1spec";}
}

echo "<br><br>";

echo ("
   <p><strong>�������� �������:�</strong></p>
");
if ($lang5 != '' or $lang5uroven != '') 
{
echo "<br>$lang5";
if ($lang5uroven != '') {echo "&nbsp;-&nbsp;$lang5uroven";}
}
if ($lang4 != '' or $lang4uroven != '') 
{
echo "<br>$lang4";
if ($lang4uroven != '') {echo "&nbsp;-&nbsp;$lang4uroven";}
}
if ($lang3 != '' or $lang3uroven != '') 
{
echo "<br>$lang3";
if ($lang3uroven != '') {echo "&nbsp;-&nbsp;$lang3uroven";}
}
if ($lang2 != '' or $lang2uroven != '') 
{
echo "<br>$lang2";
if ($lang2uroven != '') {echo "&nbsp;-&nbsp;$lang2uroven";}
}
if ($lang1 != '' or $lang1uroven != '') 
{
echo "<br>$lang1";
if ($lang1uroven != '') {echo "&nbsp;-&nbsp;$lang1uroven";}
}

echo "<br><br>";

if ($prof != '') {
echo ("
   <p><strong>���������������� ������:�</strong></p>
$prof<br><br>
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

if ($dopsved != '') {
echo ("
   <p><strong>�������������� ��������:�</strong></p>
$dopsved<br><br>
");
}

echo ("
</div>
");

} //4



if ($pr != 'print') {
echo ("
<a href=zhaloba.php?r=res&link=$link>������������ �� ������</a><br>
");
}
if ($pr != 'print') {echo "<a href=linkres.php?link=$link&pr=print>������ ��� ������</a><br>";}
if ($pr == 'print') {echo "<a href=linkres.php?link=$link>������� ������</a><br>";}

echo "<br>";

if ($pr != 'print')
{ // noprint

$sid=$_SESSION['sid'];
$id=$_SESSION['sid'];
$slogin=$_SESSION['slogin'];
$spass=$_SESSION['spass'];

$result = @mysql_query("SELECT email,pass,category FROM $autortable WHERE (email = '$slogin' and pass = '$spass' and (category='rab' or category='agency'))");
if ((isset($slogin) and isset($spass)) and @mysql_num_rows($result) != 0)
{ // �������������

$resultres = @mysql_query("SELECT ID,profecy,aid,status FROM $vactable WHERE aid = '$sid' and status='ok'");

if (@mysql_num_rows($resultres) == 0) {
echo ("
�� �� �������� �� ����� ��������. ����� ���������� ���� �������� ���������� <a href=addvac.php>�������� ��������</a>
");
}

if (@mysql_num_rows($resultres) == 1) {
while($myrow=mysql_fetch_array($resultres)) {
$vacID=$myrow["ID"];
}
echo ("
<form name=form method=post action=sendvac.php?send ENCTYPE=multipart/form-data>
<input type=hidden name=p value=$link>
<input type=hidden name=vacID value=$vacID>
<input type=submit value=\"���������� ���� �������� ����������\" name=\"send\" class=i3>
</form>
");
}

if (@mysql_num_rows($resultres) > 1) {
echo ("
<form name=form method=post action=sendvac.php?send ENCTYPE=multipart/form-data>
<input type=hidden name=p value=$link>
<input type=hidden name=link value=$link>
<select name=vacID size=1>
");
while($myrow=mysql_fetch_array($resultres)) {
$vacID=$myrow["ID"];
$vacprofecy=$myrow["profecy"];
echo ("
<option value=\"$vacID\">$vacprofecy</option>
");
}
echo ("
</select>
<input type=submit value=\"���������� �������� �������� ����������\" name=\"send\" class=i3>
</form>
");
}

} // �������������

if ((!isset($slogin) or !isset($spass)) or @mysql_num_rows($result) == 0)
{
echo ("
��� ����������� ����� �������� ���������� <a href=autor.php>��������������� ��� ������������ ��� ���������</a>
</form>
");
}

} // noprint

// �������
if ($pr != 'print')
{ // noprint
$resultn = @mysql_query("SELECT ID,profecy,zp,status,date,country,region,city FROM $restable WHERE status='ok' and ID != '$link' and profecy REGEXP '$profecy' $qwery1 order by RAND() LIMIT 5");
$totaltextsn=@mysql_num_rows($resultn);
if ($totaltextsn != 0) {
echo ("
<br><div align=center>
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0 class=tbl1>
<tr bgcolor=$maincolor><td valign=top><b>������� ������</b></td></tr>
<tr bgcolor=$maincolor><td valign=top>
");
while($myrow=mysql_fetch_array($resultn)) {
$wid=$myrow["ID"];
$profecy=$myrow["profecy"];
$zp=$myrow["zp"];
echo "<a href=linkres.php?link=$wid><b>$profecy</b></a>";
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
$basketurl="linkres.php?link=$link";

if ($pr != 'print') {include("down.php");}
?>