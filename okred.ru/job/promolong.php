<?
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!--/***************** DO NOT REMOVE! *********************/---->
<!--/*   Author: Nevezhyn Evgeny  Date : 20/05/2004       */---->
<!--/*   nevius@bk.ru      All Rights Reserved ...        */---->
<!--/*   http://nevius.ru/                                */---->
<!--/***************** DO NOT MODIFY! *********************/---->

<?php
echo "<head>";
include("var.php");
echo"<title>��������� ������ : $sitename</title>";
include("top.php");
?>
<h3><center><strong>��������� ������</strong></center></h3>
<?php
if (!isset($sid) or $sid == '') {$sid=$_SESSION['sid'];}
if (!isset($slogin) or $slogin == '') {$slogin=$_SESSION['slogin'];}
if (!isset($spass) or $spass == '') {$spass=$_SESSION['spass'];}
$id=$sid;

$error = "";
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
$result = @mysql_query("SELECT * FROM $autortable WHERE (email = '$slogin' and pass = '$spass')");
while ($myrow=mysql_fetch_array($result)) {
$afid=$myrow["ID"];
}
if ((!isset($slogin) or !isset($spass)) or @mysql_num_rows($result) == 0)
{
echo "<p class=error><b>�� �� ��������������!</b> <a href=autor.php>�����������</a></p>";
}
else
{//1
if ($promotrue != 'TRUE')
{
echo "<center><br><br><h3>��������� ��������� �������!</h3><b><a href=autor.php>���������</a></b>";
}
if ($promotrue == 'TRUE')
{ //11
if ($_SERVER[QUERY_STRING] == "add") {
$link=$_POST['link'];
$periodold=$_POST['periodold'];

if (isset($submit)) {$period = $periodold;}
if (isset($newper30)) {$period = 30;}
if (isset($newper60)) {$period = 60;}
if (isset($newper90)) {$period = 90;}
if (isset($newper150)) {$period = 150;}
if (isset($newper365)) {$period = 365;}

$result = @mysql_query("SELECT * FROM $promotable WHERE ID='$link' and aid = '$sid'");
while ($myrow=mysql_fetch_array($result)) {
$wheres=$myrow["wheres"];
$place=$myrow["place"];
$city=$myrow["city"];
}

// �������� ������� �� �����
if ($wheres=='top') {$totprice=$promopricetop;}
if ($wheres=='menu') {$totprice=$promopricemenu;}
if ($wheres=='down') {$totprice=$promopricedown;}
if ($wheres=='right') {$totprice=$promopriceright;}
if ($wheres=='comp') {$totprice=$promopricecomp;}
if ($wheres=='afterhot') {$totprice=$promopriceafterhot;}
if ($wheres=='beforenew') {$totprice=$promopricebeforenew;}
if ($place=='all') {$totprice=$totprice*3;}
if ($place=='index') {$totprice=$totprice*2;}
if ($city == '1') {$totprice=$totprice*10;}

$totpricetop=$totprice*$period;

if ($period >= 150 and $period < 365) {$totpricetop=$totpricetop-$totpricetop*10/100;}
if ($period >= 365) {$totpricetop=$totpricetop-$totpricetop*20/100;}

$result = @mysql_query("SELECT ID,pay FROM $autortable WHERE ID=$sid");
while ($myrow=mysql_fetch_array($result)) {
$pay=$myrow["pay"];
}
if ($pay < $totpricetop)	{$error .= "<p class=error>�� ����� ����� ������������ ������� ��� ���������� �������! � ��� - <b>$pay $valute</b>. ��������� ��� ������� �� $period ���� - <b>$totpricetop $valute</b>.</p>";}
// �������� ������� �� �����

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
if ($_SERVER[QUERY_STRING] == "add" and $error == "") {
$delvac=mysql_query("update $promotable set period=period+'$period' where ID='$link'");
$result=@mysql_query("update $autortable set pay=pay-$totpricetop where ID=$sid");
echo "<br><br><h3 align=center>��������� ���� �������!</h3><center><br><br><p align=center><a href=autor.php>��������� � ������ ������</a></a></p><br><br>";
}
}
if ($_SERVER[QUERY_STRING] != "add" or $error != "") {
$link=$_GET['link'];
$result = @mysql_query("SELECT * FROM $promotable WHERE ID='$link'");
while ($myrow=mysql_fetch_array($result)) {
$link=$myrow["ID"];
$period=$myrow["period"];
$wheres=$myrow["wheres"];
$place=$myrow["place"];
$city=$myrow["city"];
}

if ($paytrue == 'TRUE')
{ // �������� ������� ������

$result = @mysql_query("SELECT ID,pay FROM $autortable WHERE ID=$sid");
while ($myrow=mysql_fetch_array($result)) {
$pay=$myrow["pay"];
}

echo ("
�� ����� �����: <b>
");
printf("%.2f",$pay);
echo " $valute</b>";

echo ("<br><br><div align=left>
C�������� ������� ������ �������� (������ 728x90) <b>$promopricetop $valute/����</b><br>
C�������� ������� � ����� \"������� ��������\" <b>$promopricecomp $valute/����</b><br>
��������� ������� � ����� ������� �������� ��� ���� <b>$promopricemenu $valute/����</b><br>
��������� ������� � ������ ������� �������� <b>$promopriceright $valute/����</b><br>
��������� ������� ��� �������� <b>$promopricedown $valute/����</b><br>
��������� ������� ����� ����������-������ ��� <b>$promopricebeforenew $valute/����</b><br>
��������� ������� ����� ������ �������� <b>$promopriceafterhot $valute/����</b></div><br><br>
");
} // �������� ������� ������

if ($wheres == 'top') {$totprc=$promopricetop; $wheressh='���� ��������';}
if ($wheres == 'comp') {$totprc=$promopricecomp; $wheressh='������� ��������';$ogr1="<br>���������� �������� ������ �� ������ ��������� $maxrek1"; $ogr2="<br>������ �������� �� ������ ��������� $maxrekwidth x $maxrekheight ��������";}
if ($wheres == 'menu') {$totprc=$promopricemenu; $wheressh='��� ����';}
if ($wheres == 'right') {$totprc=$promopriceright; $wheressh='������ ��������';}
if ($wheres == 'down') {$totprc=$promopricedown; $wheressh='��� ��������';}
if ($wheres == 'beforenew') {$totprc=$promopricebeforenew; $wheressh='����� ����������-������ ���'; $ogr1="<br>���������� �������� ������ �� ������ ��������� $maxrek1"; $ogr2="<br>������ �������� �� ������ ��������� $maxrekwidth x $maxrekheight ��������";}
if ($wheres == 'afterhot') {$totprc=$promopriceafterhot; $wheressh='����� ������ ��������'; $ogr1="<br>���������� �������� ������ �� ������ ��������� $maxrek1"; $ogr2="<br>������ �������� �� ������ ��������� $maxrekwidth x $maxrekheight ��������";}

if ($place=='all') {$placesh='��� ��������'; $totprc=$totprc*3;}
if ($place=='index') {$placesh='������ �������';}
if ($place=='vac') {$placesh='������ ��������';}
if ($place=='res') {$placesh='������ ������';}
if ($place=='other') {$placesh='���������, ����� �������, ��������, ������';}

if ($city == '1') {$totprc=$totprc*10;}

$totprcfull=$totprc*$period;
if ($period >= 150 and $period < 365) {$totprcfull=$totprc-$totprc*10/100; $diskont='- ������ 10%';}
if ($period >= 365) {$totprcfull=$totprc-$totprc*20/100; $diskont='- ������ 20%';}

if ($totprcfull != '') {echo "<!-- ��������� ��������� �� ��� �� ������ - <b>$totprcfull $valute</b> $diskont -->";}

$totprc30=$totprc*30;
$totprc60=$totprc*60;
$totprc90=$totprc*90;
$totalprc150=$totprc*150;
$totalprc365=$totprc*365;
$totprc150=($totprc-$totprc*10/100)*150;
$totprc365=($totprc-$totprc*20/100)*365;
$totskidka150=$totprc150*10/100;
$totskidka365=$totprc365*20/100;

echo ("
<form name=form method=post ENCTYPE=\"multipart/form-data\" action=promolong.php?add>
<input type=hidden name=link value=$link>
<input type=hidden name=periodold value=$period>
");
echo ("
<center>
");

//echo "<input type=submit value=\"�������� �� $period ���� �� $totprcfull $valute\" name=\"submit\" class=i3><br><br>";

echo ("
<input type=submit value=\"�������� �� 30 ���� �� $totprc30 $valute\" name=\"newper30\"> - ��������� $totprc30 $valute<br><br>
<input type=submit value=\"�������� �� 60 ���� �� $totprc60 $valute\" name=\"newper60\"> - ��������� $totprc60 $valute<br><br>
<input type=submit value=\"�������� �� 90 ���� �� $totprc90 $valute\" name=\"newper90\"> - ��������� $totprc90 $valute<br><br>
<input type=submit value=\"�������� �� 150 ���� �� $totprc150 $valute\" name=\"newper150\"> - ������ ��������� $totalprc150 $valute. ���� ������� $totskidka150 $valute (10%)<br><br>
<input type=submit value=\"�������� �� 365 ���� �� $totprc365 $valute\" name=\"newper365\"> - ������ ��������� $totalprc365 $valute. ���� ������� $totskidka365 $valute (20%)<br><br>

</center></form>");
echo "<p align=center><a href=autor.php>��������� � ������ ������</a></p>";
}
} //11
} //1
include("down.php");
?>