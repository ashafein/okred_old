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
echo "<head><title>����������������� - ������� ��������/�������������: $sitename</title>";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\">";
include("top.php");
$err2="������������ �� ������!<br>";
$error = "";
$maxThread = 20;
$result = @mysql_query("SELECT pass FROM $admintable");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
if (!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass)
{
echo "<center><b>�� �� <a href=admin.php>��������������</a>!</b><br><br>";
}
else
{ // ok
if ($_SERVER[QUERY_STRING] != "del"){
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
$result = @mysql_query("SELECT * FROM $autortable WHERE category='agency' or category='rab' order by date DESC");
$totalThread = @mysql_num_rows($result);
$mes = $totalThread;
unset($result);
$page=$_GET['page'];
if(!isset($page) or $page == '') $page = 1;
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
  if ($k != $page) {$line .= "<a href=\"admincat.php?srcateg=$srcateg&page=$k\"> $k </a>|";}
  if ($k == $page) {$line .= " $k |";}
}
echo "<center><p><strong><big>����������������� - ������� ��������/�������������</strong></big><p>�������� �������, ������� ����� ������� � ������� �� ������ \"������� ����������\".<p>";
echo "����� ����������: <b>$totalThread</b><br><br>";
$srcateg=$_GET['srcateg'];
if ($srcateg=='nnn') {$srcategv='���';}
if ($srcateg=='soisk') {$srcategv='����������';}
if ($srcateg=='rab') {$srcategv='������������';}
if ($srcateg=='agency') {$srcategv='���������';}
if ($srcateg=='user') {$srcategv='������������';}
echo ("
<form name=sr method=get action=admincat.php>
���������� ���������:&nbsp;
<select name=category size=1 onChange=location.href=location.pathname+\"?srcateg=\"+value+\"\";>
<option selected value=$srcateg>$srcategv</option>
<option value=nnn>���</option>
<option value=rab>������������</option>
<option value=agency>���������</option>
</select>
</form>
");
echo "<form name=delreg method=post action=admincat.php?del>";
if ($srcateg == '' or $srcateg == 'nnn') {$result = @mysql_query("SELECT *,CURRENT_DATE,(YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) AS age FROM $autortable WHERE category='agency' or category='rab' order by category, date DESC LIMIT $initialMsg, $maxThread");}
if ($srcateg != '' and $srcateg != 'nnn') {$result = @mysql_query("SELECT *,CURRENT_DATE,(YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) AS age FROM $autortable WHERE category = '$srcateg' order by date DESC LIMIT $initialMsg, $maxThread");}
while($myrow=mysql_fetch_array($result)) {
$ID=$myrow["ID"];
$login=$myrow["login"];
$pass=$myrow["pass"];
$email=$myrow["email"];
$date=$myrow["date"];
$ip=$myrow["ip"];
$ustatus=$myrow["status"];
$category=$myrow["category"];
$catalog=$myrow["catalog"];
if ($catalog == 'off') {$catline="<font color=red>�� ���������</font>";}
if ($catalog == 'on') {$catline="<font color=green>���������</font>";}
if ($category == 'rab')
{ //rab
$res = @mysql_query("SELECT ID,aid FROM $vactable WHERE aid='$ID'");
$totalautortexts1 = @mysql_num_rows($res);
$res = @mysql_query("SELECT ID,aid FROM $restable WHERE aid='$ID'");
$totalautortexts2 = @mysql_num_rows($res);
unset($res);
$totalautortexts = $totalautortexts1 + $totalautortexts2;
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

$telephone=$myrow["telephone"];
$adress=$myrow["adress"];
$url=$myrow["url"];
$fio=$myrow["fio"];
$firm=$myrow["firm"];
if ($category=='soisk') {$categ='����������';}
if ($category=='rab') {$categ='������������';}
if ($category=='agency') {$categ='���������';}
if ($category=='user') {$categ='������������';}
echo ("
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$altcolor><td  colspan=2><b>$categ</b>&nbsp;/&nbsp;<b>$catline</b></td></tr>
<tr bgcolor=$maincolor><td valign=top>
");
echo "<b>������</b>: $pass<br>";
if ($firm != '') {echo "<b>�����������</b>: $firm<br>";}
if ($citys != '' or $adress != '') {echo "<b>���������������</b>: $citys $adress<br>";}
if ($telephone != '') {echo "<b>���:</b>: $telephone<br>";}
if ($email != '') {echo "<b>Email</b>: <a href=mailto:$email>$email</a><br>";}
if ($url != '') {echo "<b>URL</b>: <a href=$url target=_blank>$url</a><br>";}
if ($fio != '') {echo "<b>���������� ����</b>: $fio<br>";}
echo "<b>IP</b>: $ip<br>";
echo "<b>��������� ����������</b>: $totalautortexts<br>";
echo "<b>���� �����������</b>: $date<br>";
echo "</td></tr>";
echo ("
</tr><tr bgcolor=$maincolor><td  colspan=2><input type=checkbox name=delmes[] value=$ID>&nbsp;<font color=green>��������</font></td></tr>
</table></td></tr></table><br>
");
} //rab

if ($category == 'agency')
{ //agency
$res = @mysql_query("SELECT ID,aid FROM $vactable WHERE aid='$ID'");
$totalautortexts1 = @mysql_num_rows($res);
$res = @mysql_query("SELECT ID,aid FROM $restable WHERE aid='$ID'");
$totalautortexts2 = @mysql_num_rows($res);
unset($res);
$totalautortexts = $totalautortexts1 + $totalautortexts2;
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

$telephone=$myrow["telephone"];
$adress=$myrow["adress"];
$url=$myrow["url"];
$fio=$myrow["fio"];
$firm=$myrow["firm"];
if ($category=='soisk') {$categ='����������';}
if ($category=='rab') {$categ='������������';}
if ($category=='agency') {$categ='���������';}
if ($category=='user') {$categ='������������';}
echo ("
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$altcolor><td  colspan=2><b>$categ</b>&nbsp;/&nbsp;<b>$catline</b></td></tr>
<tr bgcolor=$maincolor><td valign=top>
");
echo "<b>������</b>: $pass<br>";
if ($firm != '') {echo "<b>�������� ���������</b>: $firm<br>";}
if ($citys != '' or $adress != '') {echo "<b>���������������</b>: $citys $adress<br>";}
if ($telephone != '') {echo "<b>���:</b>: $telephone<br>";}
if ($email != '') {echo "<b>Email</b>: <a href=mailto:$email>$email</a><br>";}
if ($url != '') {echo "<b>URL</b>: <a href=$url target=_blank>$url</a><br>";}
if ($fio != '') {echo "<b>���������� ����</b>: $fio<br>";}
echo "<b>IP</b>: $ip<br>";
echo "<b>��������� ����������</b>: $totalautortexts<br>";
echo "<b>���� �����������</b>: $date<br>";
echo "</td></tr>";
echo ("
</tr><tr bgcolor=$maincolor><td  colspan=2><input type=checkbox name=delmes[] value=$ID>&nbsp;<font color=green>��������</font></td></tr>
</table></td></tr></table><br>
");
} //agency


}
echo "<p align=center class=tbl1>$line</p>";
echo ("
<center><input type=submit value='��������� �� ��������' name=delete>&nbsp;<input type=submit value='�������� � �������' name=add></form>
");
}
if ($_SERVER[QUERY_STRING] == "del"){
$delmes=$_POST['delmes'];
if (count($delmes)==0) {
	$error .= "$err2";}
if ($error != ""){
echo "<center><h3>������</h3><font color=red>$error</font><p><a href=# onClick=history.go(-1)>��������� �����</a><p><br><br><br><br><br><br><br><br>";
}
if ($error==""){
unset($result);
if (isset($_POST['delete']))
{ //del
for ($i=0;$i<count($delmes);$i++){
$result=@mysql_query("update $autortable set catalog='off' WHERE ID=$delmes[$i]");
}
echo "<center><b>���������� ������������ ��������� �� ��������!</b><br><a href=admincat.php>���������</a><p><br><br><br><br>";
} //del
if (isset($_POST['add']))
{ //add
for ($i=0;$i<count($delmes);$i++){
$result=@mysql_query("update $autortable set catalog='on' WHERE ID=$delmes[$i]");
}
echo "<center><b>���������� ������������ �������� � �������!</b><br><a href=admincat.php>���������</a><p><br><br><br><br>";
} //add
}
}
} //ok
echo "<center><a href=admin.php>�� ����� �������� �����������������</a><br><br>";
include("down.php");
?>