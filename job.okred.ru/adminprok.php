<?
session_start();
session_register("uid");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!--/***************** DO NOT REMOVE! *********************/---->
<!--/*   Author: Nevezhyn Evgeny  Date : 11/06/2005       */---->
<!--/*   nevius@bk.ru      All Rights Reserved ...        */---->
<!--/*   http://nevius.ru/                                */---->
<!--/***************** DO NOT MODIFY! *********************/---->

<?php
include("var.php");
echo "<head><title>����������������� - ��������� �������: $sitename</title>";
include("top.php");
$err2="<p class=error>�� ������� �� ����� �������!</p>";
$error = "";
$result = @mysql_query("SELECT pass FROM $admintable");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
if (!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass)
{
echo "<p class=error>�� �� <a href=admin.php>��������������</a>!</p><br><br>";
}
else
{ // ok
if ($_SERVER[QUERY_STRING] != "del"){
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
$maxThread=20;
$result = @mysql_query("SELECT ID,status FROM $promotable WHERE status='wait'");
$totalThread = @mysql_num_rows($result);
$mes = $totalThread;
unset($result);
$page=$_GET['page'];
if(!isset($page)) $page = 1;
if( $totalThread <= $maxThread ) $totalPages = 1;
elseif( $totalThread % $maxThread == 0 ) $totalPages = $totalThread / $maxThread;
else $totalPages = ceil( $totalThread / $maxThread );
if( $totalThread == 0 ) $threadStart = 0;
else $threadStart = $maxThread * $page - $maxThread + 1;
if( $page == $totalPages ) $threadEnd = $totalThread;
else $threadEnd = $maxThread * $page;
$initialMsg = $maxThread * $page - $maxThread;
$pages = (int) (($totalThread + $maxThread - 1) / $maxThread);
$line = "��������: |";
for ($k = 1; $k <= $pages; $k++) {
  if ($k != $page) {$line .= "<a href=\"adminprok.php?page=$k\"> $k </a>|";}
  if ($k == $page) {$line .= " $k |";}
}
echo "<p align=center class=tbl1><strong><big>����������������� - ��������� �������</strong></big><br>";
echo "(�����: <b>$totalThread</b>)</p>";
echo ("
<form name=delreg method=post action=adminprok.php?del>
<table border=0 width=95% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table width=100% border=0 cellspacing=1 cellpadding=4 class=tbl1>
<tr bgcolor=$altcolor><td></td><td><strong>�������</strong></td><td><strong>������������</strong></td><td><strong>�������� ������</strong></td><td><strong>���� ����������</strong></td><td><strong>��� �������</strong></td></tr>
");
$result = @mysql_query("SELECT *,(date + INTERVAL 86400*period SECOND) as expir,DATE_FORMAT(date,'%d.%m.%Y') as date FROM $promotable WHERE status='wait' order by wheres,ID DESC LIMIT $initialMsg, $maxThread");
while($myrow=mysql_fetch_array($result)) {
$ID=$myrow["ID"];
$title=$myrow["title"];
$foto=$myrow["foto"];
$link=$myrow["link"];
$wheres=$myrow["wheres"];
$place=$myrow["place"];
$date=$myrow["date"];
$aid=$myrow["aid"];
$status=$myrow["status"];
$expir=$myrow["expir"];

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

if ($place=='all') {$place='��� ��������';}
if ($place=='index') {$place='������ �������';}
if ($place=='vac') {$place='������ ��������';}
if ($place=='res') {$place='������ ������';}
if ($place=='other') {$place='���������, ����� �������, ��������, ������';}
if ($wheres=='top') {$where='���� ��������';}
if ($wheres=='comp') {$where='������� ��������';}
if ($wheres=='menu') {$where='��� ����';}
if ($wheres=='right') {$where='������ ��������';}
if ($wheres=='down') {$where='��� ��������';}
if ($wheres=='beforenew') {$where='����� ����������-������ ���';}
if ($wheres=='afterhot') {$where='����� ������ ��������';}
if ($wheres=='rassilka') {$where='� ��������';}
if ($aid == 0) {$wholine="<b><font color=green>�������������</font></b>";}
if ($aid != 0) {
$wholine="������������ (<a href=adminda.php?srname=$aid>$aid</a>)";
if ($status == 'wait') {$wholine .= "<br><font color=red>�� ��������</font>";}
}
echo "<tr><td bgcolor=$maincolor><input type=checkbox name=delmes[] value=$ID></td>";
if ($foto != '') {echo "<td bgcolor=$maincolor><a href=\"$link\" target=_blank><img src=\"$foto\" alt=\"$title\" border=0></a></td>";}
if ($foto == '') {echo "<td bgcolor=$maincolor><a href=\"$link\" target=_blank>$title</a></td>";}
echo "<td bgcolor=$maincolor>$where $citys</td>";
echo "<td bgcolor=$maincolor>$place</td>";
echo "<td bgcolor=$maincolor>$date<br>(�� $expir)</td>";
echo "<td bgcolor=$maincolor>$wholine</td>";
echo "</tr>";
}
echo "</table></td></tr></table>";
echo "<p align=center class=tbl1>$line</p>";
echo ("
<center>
<input type=submit value='�������� ����������' name=submit>&nbsp;&nbsp;&nbsp;
<input type=submit value='������� ����������' name=delete></form>
");
}
if ($_SERVER[QUERY_STRING] == "del"){
$delmes=$_POST['delmes'];
if (count($delmes)==0) {
	$error .= "$err2";}
if ($error != ""){
echo "<center>$error<p><a href=javascript:history.back(2);>��������� �����</a><p><br><br><br><br><br><br><br><br>";
}
if ($error==""){
unset($result);

if (isset($_POST['delete']))
{ //del
for ($i=0;$i<count($delmes);$i++){
$res1 = @mysql_query("SELECT * FROM $promotable WHERE ID=$delmes[$i]");
while ($myrow=@mysql_fetch_array($res1))
{
$foto=$myrow["foto"];
$aid=$myrow["aid"];
$price=$myrow["price"];
}
unlink($upath.$foto);
unset($res1);
$result=@mysql_query("update $autortable set pay=pay+$price where ID=$aid");
$result=@mysql_query("delete from $promotable WHERE ID=$delmes[$i]");
$res3 = @mysql_query("SELECT * FROM $autortable WHERE ID=$aid and email != ''");
while($myrow=mysql_fetch_array($res3)) {
$emailto=$myrow["email"];
$fio=$myrow["fio"];
$nameto=$myrow["firm"];
}
$txt="������������, <b>$fio</b>!<br><br>���� ������� ���� ������� � ����� <a href=$siteadress>$sitename</a>!<br><br><br>������� �� ����������� ����� ������!<br>-----------<br><a href=$siteadress>$siteadress</a><br><a href=emailto:$adminemail>$adminemail</a>";
@mail($emailto,"������� ������� � ����� $sitename",$txt,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/html; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");
}
echo "<center><b>��������� ������� �������!</b><br><a href=adminprok.php>���������</a><p><br><br><br><br>";
} //del

if (isset($_POST['submit']))
{ //del
for ($i=0;$i<count($delmes);$i++){
$res1 = @mysql_query("SELECT * FROM $promotable WHERE ID=$delmes[$i]");
while ($myrow=@mysql_fetch_array($res1))
{
$foto=$myrow["foto"];
$aid=$myrow["aid"];
$wheres=$myrow["wheres"];
$place=$myrow["place"];
$period=$myrow["period"];
}
if ($wheres=='top') {$totprice=$promopricetop;}
if ($wheres=='menu') {$totprice=$promopricemenu;}
if ($wheres=='down') {$totprice=$promopricedown;}
if ($wheres=='right') {$totprice=$promopriceright;}
if ($wheres=='comp') {$totprice=$promopricecomp;}
if ($wheres=='afterhot') {$totprice=$promopriceafterhot;}
if ($wheres=='beforenew') {$totprice=$promopricebeforenew;}
if ($place=='all') {$totprice=$totprice*3;}
if ($place=='index') {$totprice=$totprice*2;}

$result=@mysql_query("update $promotable set status='ok',date=now() WHERE ID=$delmes[$i]");
$res3 = @mysql_query("SELECT * FROM $autortable WHERE ID=$aid and email != ''");
while($myrow=mysql_fetch_array($res3)) {
$emailto=$myrow["email"];
$fio=$myrow["fio"];
$nameto=$myrow["firm"];
}
$txt="������������, <b>$fio</b>!<br><br>���� ������� ���� ��������� � ��������� �� ����� <a href=$siteadress>$sitename</a>!<br><br>������� �� ����������� ����� ������!<br>-----------<br><a href=$siteadress>$siteadress</a><br><a href=emailto:$adminemail>$adminemail</a>";
@mail($emailto,"������� ��������� - $sitename",$txt,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/html; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");
}
echo "<center><b>��������� ���������!</b><br><a href=adminprok.php>���������</a><p><br><br><br><br>";
} //del

}
}
echo "<center><a href=admin.php>�� ����� �������� �����������������</a><br><br>";
} //ok
include("down.php");
?>