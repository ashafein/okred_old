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
echo "<head><title>����������������� - �������� ������������: $sitename</title>";
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
$result = @mysql_query("SELECT * FROM $autortable order by date DESC");
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
  if ($k != $page) {$line .= "<a href=\"adminda.php?srname=$srname&srcateg=$srcateg&page=$k\"> $k </a>|";}
  if ($k == $page) {$line .= " $k |";}
}
echo "<center><p><strong><big>����������������� - �������� ������������</strong></big><p>�������� �������, ������� ����� ������� � ������� �� ������ \"������� ����������\".<p>";
$srcateg=$_GET['srcateg'];
$srname=$_GET['srname'];
if ($srcateg=='nnn') {$srcategv='���';}
if ($srcateg=='soisk') {$srcategv='����������';}
if ($srcateg=='rab') {$srcategv='������������';}
if ($srcateg=='agency') {$srcategv='���������';}
if ($srcateg=='user') {$srcategv='������������';}
if ($srcateg=='freelanc') {$srcategv='���������';}
echo ("
<form name=sr method=get action=adminda.php>
���������� ���������:&nbsp;
<select name=category size=1 onChange=location.href=location.pathname+\"?srcateg=\"+value+\"\";>
<option selected value=$srcateg>$srcategv</option>
<option value=nnn>���</option>
<option value=soisk>����������</option>
<option value=rab>������������</option>
<option value=agency>���������</option>
");

if ($freelanc == 'TRUE') {echo "<option value=freelanc>���������</option>";}

echo ("
<option value=user>������������</option>
</select><br>
������ ��� ������: <input type=text name=srname size=10>&nbsp;<input type=submit name=submit value='�����'></form><br><br>
</form>
");
echo "<form name=delreg method=post action=adminda.php?del>";
if ($srname != "") {$srname = ereg_replace(" ","*.",$srname); $qwery2="and (ID = '$srname' or city REGEXP '$srname' or fio REGEXP '$srname' or firm REGEXP '$srname' or telephone REGEXP '$srname' or adress REGEXP '$srname')";}
if (!isset($srname) or $srname == "") {$qwery2='';}
if ($srcateg == '' or $srcateg == 'nnn') {$result = @mysql_query("SELECT *,CURRENT_DATE,(YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) AS age FROM $autortable WHERE ID != '' $qwery2 order by date DESC LIMIT $initialMsg, $maxThread");}
if ($srcateg != '' and $srcateg != 'nnn') {$result = @mysql_query("SELECT *,CURRENT_DATE,(YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) AS age FROM $autortable WHERE category = '$srcateg' $qwery2 order by date DESC LIMIT $initialMsg, $maxThread");}
$totmes = @mysql_num_rows($result);
echo "����� �������: <b>$totmes</b><br><br>";
while($myrow=mysql_fetch_array($result)) {
$ID=$myrow["ID"];
$pass=$myrow["pass"];
$email=$myrow["email"];
$date=$myrow["date"];
$ip=$myrow["ip"];
$ustatus=$myrow["status"];
$category=$myrow["category"];
$pay=$myrow["pay"];
if ($category == 'soisk')
{ //soisk
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
$fio=$myrow["fio"];
$gender=$myrow["gender"];
$family=$myrow["family"];
$civil=$myrow["civil"];
$age=$myrow["age"];
$foto1=$myrow["foto1"];
$foto2=$myrow["foto2"];
if ($category=='soisk') {$categ='����������';}
if ($category=='rab') {$categ='������������';}
if ($category=='agency') {$categ='���������';}
if ($category=='user') {$categ='������������';}
echo ("
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$altcolor><td  colspan=2><b>$categ</b></td></tr>
<tr bgcolor=$maincolor><td valign=top>
");
if ($foto1 != '')
{
if ($foto1 != "") {$fotourl=$foto1;}
if (file_exists($photodir.'s'.$fotourl)) {$fotourl="s$fotourl";}
echo "<a href=\"photo.php?link=$ID&f=$photodir$foto1&w=a\" target=_blank><img src=\"$photodir$fotourl\" height=$smallfotoheight alt=\"���������\" border=0></a>";
}
elseif ($foto1 == '')
{
echo "<img src=picture/showphoto.gif alt=\"��� ����������\" border=0>";
}
echo "</td><td valign=top width=100%>";
echo "<b>������</b>: $pass<br>";
if ($fio != '') {echo "<b>���</b>: $fio<br>";}
if ($gender == '�������') {echo "<b>���</b>: �������<br>";}
if ($gender == '�������') {echo "<b>���</b>: �������<br>";}
if ($age != 0) {echo "<b>�������</b>: $age ���(����)<br>";}
if ($family != '') {echo "<b>�������� ���������</b>: $family<br>";}
if ($civil != '') {echo "<b>�����������</b>: $civil<br>";}
if ($citys != '') {echo "<b>����� ����������</b>: $citys<br>";}
if ($telephone != '') {echo "<b>���:</b>: $telephone<br>";}
if ($email != '') {echo "<b>Email</b>: <a href=mailto:$email>$email</a><br>";}
echo "<b>IP</b>: $ip<br>";
echo "<b>��������� ����������</b>: $totalautortexts<br>";
echo "<b>���� �����������</b>: $date<br>";
echo "</td></tr>";
echo ("
</tr>
<tr bgcolor=$maincolor><td  colspan=2><input type=checkbox name=delmes[] value=$ID>&nbsp;<font color=green>��������</font>&nbsp;/&nbsp;<a href=admincfr.php?id=$ID>������</a></td></tr>
<tr bgcolor=$maincolor><td  colspan=2>�� �����: <b>$pay</b> $valute &nbsp;/&nbsp;<a href=adminpay.php?id=$ID>����������</a></td></tr>
</table></td></tr></table><br>
");
} //soisk

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
<tr bgcolor=$altcolor><td  colspan=2><b>$categ</b></td></tr>
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
</tr><tr bgcolor=$maincolor><td  colspan=2><input type=checkbox name=delmes[] value=$ID>&nbsp;<font color=green>��������</font>&nbsp;/&nbsp;<a href=admincfr.php?id=$ID>������</a></td></tr>
<tr bgcolor=$maincolor><td  colspan=2>�� �����: <b>$pay</b> $valute &nbsp;/&nbsp;<a href=adminpay.php?id=$ID>����������</a></td></tr>
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
$addobyavl=$myrow["addobyavl"];
if ($category=='soisk') {$categ='����������';}
if ($category=='rab') {$categ='������������';}
if ($category=='agency') {$categ='���������';}
if ($category=='user') {$categ='������������';}
echo ("
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$altcolor><td  colspan=2><b>$categ</b></td></tr>
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
if ($addobyavl=='no') {echo "<b><font color=red>��������� ��������� ����������</font></b><br>";}
echo "<b>���� �����������</b>: $date<br>";
echo "</td></tr>";
echo ("
</tr><tr bgcolor=$maincolor><td  colspan=2><input type=checkbox name=delmes[] value=$ID>&nbsp;<font color=green>��������</font>&nbsp;/&nbsp;<a href=admincfr.php?id=$ID>������</a></td></tr>
</table></td></tr></table><br>
");
} //agency

if ($category == 'freelanc')
{ //freelanc
$res = @mysql_query("SELECT ID,aid FROM $portfoliotable WHERE aid='$ID'");
$totalautortexts1 = @mysql_num_rows($res);
$res = @mysql_query("SELECT ID,aid FROM $nagradtable WHERE aid='$ID'");
$totalautortexts2 = @mysql_num_rows($res);
unset($res);
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
$fio=$myrow["fio"];
$gender=$myrow["gender"];
$family=$myrow["family"];
$civil=$myrow["civil"];
$age=$myrow["age"];
$foto1=$myrow["foto1"];
$foto2=$myrow["foto2"];
$categ='���������';
echo ("
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$altcolor><td  colspan=2><b>$categ</b></td></tr>
<tr bgcolor=$maincolor><td valign=top>
");
if ($foto1 != '')
{
if ($foto1 != "") {$fotourl=$foto1;}
if (file_exists($photodir.'s'.$fotourl)) {$fotourl="s$fotourl";}
echo "<a href=\"photo.php?link=$ID&f=$photodir$foto1&w=a\" target=_blank><img src=\"$photodir$fotourl\" height=$smallfotoheight alt=\"���������\" border=0></a>";
}
elseif ($foto1 == '')
{
echo "<img src=picture/showphoto.gif alt=\"��� ����������\" border=0>";
}
echo "</td><td valign=top width=100%>";
echo "<b>������</b>: $pass<br>";
if ($fio != '') {echo "<b>���</b>: $fio<br>";}
if ($gender == '�������') {echo "<b>���</b>: �������<br>";}
if ($gender == '�������') {echo "<b>���</b>: �������<br>";}
if ($age != 0) {echo "<b>�������</b>: $age ���(����)<br>";}
if ($family != '') {echo "<b>�������� ���������</b>: $family<br>";}
if ($civil != '') {echo "<b>�����������</b>: $civil<br>";}
if ($citys != '') {echo "<b>����� ����������</b>: $citys<br>";}
if ($telephone != '') {echo "<b>���:</b>: $telephone<br>";}
if ($email != '') {echo "<b>Email</b>: <a href=mailto:$email>$email</a><br>";}
echo "<b>IP</b>: $ip<br>";
echo "<b>��������� ���������/������</b>: $totalautortexts1/$totalautortexts2<br>";
echo "<b>���� �����������</b>: $date<br>";
echo "</td></tr>";
echo ("
</tr>
<tr bgcolor=$maincolor><td  colspan=2><input type=checkbox name=delmes[] value=$ID>&nbsp;<font color=green>��������</font>&nbsp;/&nbsp;<a href=admincfr.php?id=$ID>������</a></td></tr>
<tr bgcolor=$maincolor><td  colspan=2>�� �����: <b>$pay</b> $valute &nbsp;/&nbsp;<a href=adminpay.php?id=$ID>����������</a></td></tr>
</table></td></tr></table><br>
");
} //freelanc

if ($category == 'user')
{ //user
if ($category=='soisk') {$categ='����������';}
if ($category=='rab') {$categ='������������';}
if ($category=='agency') {$categ='���������';}
if ($category=='user') {$categ='������������';}
echo ("
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$altcolor><td  colspan=2><b>$categ</b></td></tr>
<tr bgcolor=$maincolor><td valign=top>
");
echo "<b>Email</b>: $email<br>";
echo "<b>������</b>: $pass<br>";
echo "<b>IP</b>: $ip<br>";
echo "<b>���� �����������</b>: $date<br>";
echo "</td></tr>";
echo ("
</tr><tr bgcolor=$maincolor><td  colspan=2><input type=checkbox name=delmes[] value=$ID>&nbsp;<font color=green>��������</font>&nbsp;/&nbsp;<a href=admincfr.php?id=$ID>������</a></td></tr>
</table></td></tr></table><br>
");
} //user

}
echo "<table border=0 width=90%><tr><td><table width=100% border=0 class=tbl1><tr bgcolor=$maincolor><td align=left><input type=checkbox name=ban value=yes>&nbsp;����������� ����������� ���� ������� � �������</td></tr></table></td></tr></table>";
echo "<p align=center class=tbl1>$line</p>";
echo ("
<center><input type=submit value='������� ����������' name=submit><br><br>
<input type=submit value='��������� ���������� ���������� ����������' name=addyes><br><br>
<input type=submit value='��������� ���������� ���������� ����������' name=addno><br><br>
<input type=text name=paynew size=30>$valute&nbsp;<input type=submit value='��������� ���������� �� ����' name=payto><br><br>
</form>
");
}
if ($_SERVER[QUERY_STRING] == "del"){
$delmes=$_POST['delmes'];
$ban=$_POST['ban'];
$paynew=$_POST['paynew'];
if (count($delmes)==0) {
	$error .= "$err2";}
if ($error != ""){
echo "<center><h3>������</h3><font color=red>$error</font><p><a href=# onClick=history.go(-1)>��������� �����</a><p><br><br><br><br><br><br><br><br>";
}
if ($error==""){
unset($result);
if (isset($_POST['submit']))
{ // del
for ($i=0;$i<count($delmes);$i++){
$result = @mysql_query("delete from $vactable where aid=$delmes[$i]");
unset($result);
$res1 = @mysql_query("SELECT * FROM $restable WHERE aid=$delmes[$i]");
while ($myrow=@mysql_fetch_array($res1)) 
{
$foto1=$myrow["foto1"];
}
@unlink($upath.$photodir.$foto1);
@unlink($upath.$photodir.'s'.$foto1);
$result = @mysql_query("delete from $restable where aid=$delmes[$i]");
$res5 = @mysql_query("SELECT ID,email FROM $autortable WHERE ID=$delmes[$i]");
while ($myrow=@mysql_fetch_array($res5)) 
{
$autorname=$myrow["email"];
}
$result=@mysql_query("update $forumtable SET pass=0 WHERE name='$autorname'");
unset($result);
if (@$ban=='yes')
{
$resultbun = @mysql_query("SELECT ID,ip FROM $autortable WHERE ID=$delmes[$i]");
while($myrow=mysql_fetch_array($resultbun)) {
$ip=$myrow["ip"];
}
unset($result);
$sql="insert into $bunsiptable (bunsip) values ('$ip')";
$result=@mysql_query($sql,$db);
}
$res1 = @mysql_query("SELECT ID,foto1,foto2 FROM $autortable WHERE ID=$delmes[$i]");
while ($myrow=@mysql_fetch_array($res1)) 
{
$foto1=$myrow["foto1"];
$foto2=$myrow["foto2"];
}
@unlink($upath.$photodir.$foto1);
@unlink($upath.$photodir.$foto2);
@unlink($upath.$photodir.'s'.$foto1);
@unlink($upath.$photodir.'s'.$foto2);
$result=@mysql_query("delete from $rasvac WHERE aid=$delmes[$i]");
$result=@mysql_query("delete from $rasres WHERE aid=$delmes[$i]");
$result=@mysql_query("delete from $autortable WHERE ID=$delmes[$i]");
}
echo "<center><b>������������ ������!</b><br><a href=adminda.php>���������</a><p><br><br><br><br>";
} //del

if (isset($_POST['addyes']))
{ // addyes
for ($i=0;$i<count($delmes);$i++){
$result=@mysql_query("update $autortable set addobyavl='' WHERE ID=$delmes[$i]");
}
echo "<center><b>������������� ��������� ���������� ����������!</b><br><a href=adminda.php>���������</a><p><br><br><br><br>";
} //addyes

if (isset($_POST['addno']))
{ // addno
for ($i=0;$i<count($delmes);$i++){
$result=@mysql_query("update $autortable set addobyavl='no' WHERE ID=$delmes[$i]");
}
echo "<center><b>������������� ��������� ���������� ����������!</b><br><a href=adminda.php>���������</a><p><br><br><br><br>";
} //addno

if (isset($_POST['payto']))
{ // addno
for ($i=0;$i<count($delmes);$i++){
$result=@mysql_query("update $autortable set pay=pay+'$paynew' WHERE ID=$delmes[$i]");
}
echo "<center><b>��������� ������������� ��������� �� ���� ����� $paynew $valute!</b><br><a href=adminda.php>���������</a><p><br><br><br><br>";
} //addno

}
}
} //ok
echo "<center><a href=admin.php>�� ����� �������� �����������������</a><br><br>";
include("down.php");
?>