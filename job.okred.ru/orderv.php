<?
session_start();
session_name()
?>
<!--/***************** DO NOT REMOVE! *********************/---->
<!--/*   Author: Nevezhyn Evgeny  Date : 01/09/2004       */---->
<!--/*   nevius@bk.ru      All Rights Reserved ...        */---->
<!--/*   http://nevius.ru/                                */---->
<!--/***************** DO NOT MODIFY! *********************/---->

<?php
include("var.php");
echo "<head><title>�������� : $sitename</title>";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\"><META HTTP-EQUIV=\"Cache-Control\" CONTENT=\"No-Cache\">";
$pr=$_GET['pr'];
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
}
$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);

$view=$_GET['view'];
$p=$_GET['p'];
$d=$_GET['d'];
$bn=$_GET['bn'];
if ($ident == 'session') {$REMOTE_ADDR=$PHPSESSID;}
if ($ident != 'session') {$REMOTE_ADDR=$_SERVER['REMOTE_ADDR'];}

$sid=$_SESSION['sid'];
$id=$_SESSION['sid'];
$slogin=$_SESSION['slogin'];
$spass=$_SESSION['spass'];

$result = @mysql_query("SELECT email,pass,category FROM $autortable WHERE (email = '$slogin' and pass = '$spass')");
if ((!isset($slogin) or !isset($spass)) or @mysql_num_rows($result) == 0)
{
echo "<left><br><br><h3>�� �� ��������������!</h3><b><a href=autor.php>�����������</a></b>";
}
else
{ //1
while($myrow=mysql_fetch_array($result)) {
$who=$myrow["category"];
}
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
//---------------main--------------
//
if ($_SERVER[QUERY_STRING] != "send")
{ //nosend
//--------------step1-------------
// basketshow
if ($pr != 'print') {
echo ("
<table border=0 width=100%  cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1><tr bgcolor=$maincolor><td>���������� ��������&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>
");
if ($view != 'full') {echo "<a href=orderv.php?view=full>���������&nbsp;��������</a>";}
if ($view == 'full') {echo "<a href=orderv.php>�������&nbsp;���</a>";}
echo ("
&nbsp;/&nbsp;<a href=orderv.php?view=$view&pr=print target=_blank>������</a></b></td></tr></table></td></tr></table><br>
");
}
$basketselectresult = @mysql_query("SELECT * FROM $vacordertable WHERE (user = '$REMOTE_ADDR' and status='basket') order by ID DESC");
if (@mysql_num_rows($basketselectresult) != 0)
{
if ($view != 'full')
{ // short
echo ("
<table border=0 width=100%  cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$maincolor><td><a href=orderv.php><img src=\"picture/basket.gif\" alt=\"��������\" border=0></a></td><td>���������</td><td>��������</td><td>���� ����.</td></tr>
");
$bpos=0;
while ($myrow=mysql_fetch_array($basketselectresult)) 
{
$unitID=$myrow["ID"];
$unit=$myrow["unit"];
$number=$myrow["number"];
$result = @mysql_query("SELECT *,DATE_FORMAT(date,'%d.%m.%Y') as date FROM $vactable WHERE ID=$unit and status='ok'");
while ($myrow=@mysql_fetch_array($result)) 
{ //4
$ID=$myrow["ID"];
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
$selectresult = @mysql_query("SELECT * FROM $vacordertable WHERE (user = '$REMOTE_ADDR' and unit=$ID and status='basket')");
if (@mysql_num_rows($selectresult) == 0)
{$pic='add.gif';$al='p';$sst='�������� ��������';}
if (@mysql_num_rows($selectresult) != 0)
{$pic='remove.gif';$al='d';$sst='������� ��������';}
echo ("
<tr bgcolor=$maincolor>
<td valign=top width=20><a href=\"orderv.php?$al=$ID\"><img src=\"picture/$pic\" alt=\"$sst\" border=0></a></td>
<td valign=top><a href=linkvac.php?link=$ID><b>$profecy</b></a><br>
");
$br=0;
if ($gender == '�������') {$br=1; echo "�������&nbsp";}
if ($gender == '�������') {$br=1; echo "�������&nbsp";}
if ($agemin != 0 and $agemax == 0) {$br=1; echo "�� $agemin ���;&nbsp";}
if ($agemin == 0 and $agemax != 0) {$br=1; echo "�� $agemax ���;&nbsp";}
if ($agemin != 0 and $agemax != 0) {$br=1; echo "�� $agemin �� $agemax ���;&nbsp";}
if ($edu != '' and $edu != '��&nbsp;�����') {$br=1; echo "����������� $edu;&nbsp";}
if ($grafic != '' and !eregi("�����",$grafic)) {echo "<br>$grafic";}
if ($br==1) {echo "<br>";}
echo ("
����������: $treb
</td>
<td valign=top><b>\$$zp</b></td>
<td valign=top>$date<br><a href=linkvac.php?link=$ID><small>���������...</small></a></td>
</tr>
");
} //4
}
echo "</table></td></tr></table>";
} //short 

if ($view == 'full')
{ // full
$bpos=0;
while ($myrow=mysql_fetch_array($basketselectresult)) 
{
$unitID=$myrow["ID"];
$unit=$myrow["unit"];
$number=$myrow["number"];
$result = @mysql_query("SELECT *,DATE_FORMAT(date,'%d.%m.%Y') as date,LPAD(ID,8,'0') as ID FROM $vactable WHERE ID=$unit and status='ok'");
while ($myrow=@mysql_fetch_array($result)) 
{ //4
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

echo ("
<table border=0 width=100%  cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$altcolor><td align=left><b>�������� $ID</b></td></tr></table></td></tr></table>
<table border=0 width=100%  cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$maincolor><td valign=top colspan=2><a href=listvac.php?r=$razdel>$razdel1</a> : <a href=listvac.php?r=$razdel&c=$podrazdel>$podrazdel1</a></td></tr>
<tr bgcolor=$maincolor><td valign=top colspan=2><b>������������ ���������:</b> $profecy</b>. �������� �� <font color=blue><b>$zp</b></font> $valute<br></td></tr>
<tr bgcolor=$maincolor><td align=left colspan=2><b>���������� � �������</b></td></tr>
");
if ($agemin != 0 and $agemax == 0) {echo "<tr bgcolor=$maincolor><td>�������:</td><td>�� $agemin ���</td></tr>";}
if ($agemin == 0 and $agemax != 0) {echo "<tr bgcolor=$maincolor><td>�������:</td><td>�� $agemax ���</td></tr>";}
if ($agemin != 0 and $agemax != 0) {echo "<tr bgcolor=$maincolor><td>�������:</td><td>�� $agemin �� $agemax ���</td></tr>";}
if ($gender == '�������') {echo "<tr bgcolor=$maincolor><td>���:</td><td>�������</td></tr>";}
if ($gender == '�������') {echo "<tr bgcolor=$maincolor><td>���:</td><td>�������</td></tr>";}
if ($edu != '' and !eregi("�����",$edu)) {echo "<tr bgcolor=$maincolor><td>�����������:</td><td>$edu</td></tr>";}
if ($edu != '' and eregi("�����",$edu)) {echo "<tr bgcolor=$maincolor><td>�����������:</td><td>�����</td></tr>";}
if ($zanatost != '' and !eregi("�����",$zanatost)) {echo "<tr bgcolor=$maincolor><td>���������:</td><td>$zanatost</td></tr>";}
if ($zanatost != '' and eregi("�����",$zanatost)) {echo "<tr bgcolor=$maincolor><td>���������:</td><td>�����</td></tr>";}
if ($grafic != '' and !eregi("�����",$grafic)) {echo "<tr bgcolor=$maincolor><td>������&nbsp;������:</td><td>$grafic</td></tr>";}
if ($grafic != '' and eregi("�����",$grafic)) {echo "<tr bgcolor=$maincolor><td>������&nbsp;������:</td><td>�����</td></tr>";}
if ($stage != '') {echo "<tr bgcolor=$maincolor><td>���� ������:</td><td>$stage</td></tr>";}
if ($treb != '') {echo "<tr bgcolor=$maincolor><td valign=top>����������:</td><td>$treb</td></tr>";}
if ($obyaz != '') {echo "<tr bgcolor=$maincolor><td valign=top>�����������:</td><td>$obyaz</td></tr>";}
if ($uslov != '') {echo "<tr bgcolor=$maincolor><td valign=top>�������:</td><td>$uslov</td></tr>";}
if ($citys != '' or $adress !='') {echo "<tr bgcolor=$maincolor><td valign=top>�����&nbsp;������:</td><td>$citys $adress</td></tr>";}
if ($firm != '') {echo "<tr bgcolor=$maincolor><td valign=top>����������� (����� ������):</td><td valign=top>$firm</td></tr>";}
echo ("
<tr bgcolor=$maincolor><td align=left colspan=2><b>���������� ����������</b></td></tr>
");
if ($category=='rab' and $afirm != '') {echo "<tr bgcolor=$maincolor><td valign=top>�����������:</td><td>$afirm</td></tr>";}
if ($category=='agency' and $afirm != '') {echo "<tr bgcolor=$maincolor><td valign=top>�������� ���������:</td><td>$afirm</td></tr>";}
if ($acitys != '') {echo "<tr bgcolor=$maincolor><td valign=top>�����:</td><td>$acitys</td></tr>";}
if ($aadress != '') {echo "<tr bgcolor=$maincolor><td valign=top>�����:</td><td>$aadress</td></tr>";}
if ($telephone != '') {echo "<tr bgcolor=$maincolor><td valign=top>�������:</td><td>$telephone</td></tr>";}
if ($email != '' and $hidemail == 'checked') {echo "<tr bgcolor=$maincolor><td valign=top>Email:</td><td><a href=\"send.php?sendid=$aid\">�������� ������</a></td></tr>";}
if ($email != '' and $hidemail != 'checked') {echo "<tr bgcolor=$maincolor><td valign=top>Email:</td><td><a href=mailto:$email>$email</a></td></tr>";}
if ($url != '') {echo "<tr bgcolor=$maincolor><td valign=top>URL:</td><td><a href=$url target=_blank>$url</a></td></tr>";}
echo ("
<tr bgcolor=$maincolor><td align=right colspan=2><b><a href=\"orderv.php?view=$view&$al=$ID\">$sst</a></b></td></tr>
</table></td></tr></table><br><br>
");
} //4
}
} // full 

$result = @mysql_query("SELECT email,pass,category FROM $autortable WHERE (email = '$slogin' and pass = '$spass' and (category='soisk' or category='agency'))");
if ((isset($slogin) and isset($spass)) and @mysql_num_rows($result) != 0)
{ // �������������

$resultres = @mysql_query("SELECT ID,profecy,aid,status FROM $restable WHERE aid = '$sid' and status='ok'");

if (@mysql_num_rows($resultres) == 0) {
echo ("
<p align=left>
�� �� �������� �� ������ ������. ����� ��������� ���� ������ �� �������� <a href=addres.php>�������� ������</a>
</p>
");
}

if (@mysql_num_rows($resultres) == 1) {
while($myrow=mysql_fetch_array($resultres)) {
$resID=$myrow["ID"];
}
echo ("
<form name=form method=post action=orderv.php?send ENCTYPE=multipart/form-data>
<p align=left>
<input type=hidden name=resID value=$resID>
<input type=submit value=\"��������� ���� ������ �� ��� ��������\" name=\"send\" class=i3>
</p>
</form>
");
}

if (@mysql_num_rows($resultres) > 1) {
echo ("
<form name=form method=post action=orderv.php?send ENCTYPE=multipart/form-data>
<p align=left>
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
</p>
</form>
");
}

} // �������������

if ((!isset($slogin) or !isset($spass)) or @mysql_num_rows($result) == 0)
{
echo ("
<p align=left>
��� �������� ����� ������ �� �������� <a href=autor.php>��������������� ��� ���������� ��� ���������</a>
</p>
");
}

}
elseif (@mysql_num_rows($basketselectresult) == 0)
{
echo "<p align=left><b>�������� ���</b></p><br><br>";
}
// basketshow
//
//--------------step1-------------
//
} //nosend
if ($_SERVER[QUERY_STRING] == "send")
{ //send

$resID=$_POST['resID'];

$body='';
$txtdown = "<br>������� �� ����������� ����� ������!<br><a href=$siteadress>$sitename</a>";
$resultaut = @mysql_query("SELECT *,CURRENT_DATE,(YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) AS age FROM $autortable WHERE ID='$id'");
while ($myrow1=mysql_fetch_array($resultaut)) {
$email=$myrow1["email"];
$hidemail=$myrow["hidemail"];
$country=$myrow1["country"];
$region=$myrow1["region"];
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
$edu=$myrow1["edu"];
$dopedu=$myrow1["dopedu"];
$languages=$myrow1["languages"];
$expir=$myrow1["expir"];
$prof=$myrow1["prof"];
$dopsved=$myrow1["dopsved"];
$age=$myrow1["age"];
$category=$myrow1["category"];
$foto1=$myrow1["foto1"];
}

$resultres = @mysql_query("SELECT *,CURRENT_DATE,(YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) AS age,DATE_FORMAT(date,'%d.%m.%Y') as date,LPAD(ID,8,'0') as vID FROM $restable WHERE ID=$resID and status='ok' LIMIT 1");
if (@mysql_num_rows($resultres) != 0)
{ // ������
while ($myrow=@mysql_fetch_array($resultres)) 
{
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
}
$resultadd2 = @mysql_query("SELECT ID,podrazdel FROM $catable WHERE ID='$podrazdel'");
while($myrow=mysql_fetch_array($resultadd2)) {
$podrazdel1=$myrow["podrazdel"];
}
$resultadd1 = @mysql_query("SELECT ID,razdel,podrazdel FROM $catable WHERE podrazdel = '' and ID='$razdel'");
while($myrow=mysql_fetch_array($resultadd1)) {
$razdel1=$myrow["razdel"];
}
$body .= ("
<div align=left>
<table border=0 width=100%  cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$altcolor><td align=left><b>������ $vID</b></td></tr></table></td></tr></table>
<table border=0 width=100%  cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$maincolor><td valign=top colspan=2><b>�������� ���������:</b> $profecy</b>.
");
if ($zp != 0) {$body .= "�������� �� <font color=blue><b>$zp</b></font> $valute";}
$body .= ("
</td></tr>
");
$body .= "</td></tr><tr bgcolor=$maincolor><td colspan=2><b>&nbsp;������� �����:</b></td></tr>";
if ($zanatost != '' and !eregi("�����",$zanatost)) {$body .= "<tr bgcolor=$maincolor><td>���������:</td><td>$zanatost</td></tr>";}
if ($zanatost != '' and eregi("�����",$zanatost)) {$body .= "<tr bgcolor=$maincolor><td>���������:</td><td>�����</td></tr>";}
if ($grafic != '' and !eregi("�����",$grafic)) {$body .= "<tr bgcolor=$maincolor><td>������&nbsp;������:</td><td>$grafic</td></tr>";}
if ($grafic != '' and eregi("�����",$grafic)) {$body .= "<tr bgcolor=$maincolor><td>������&nbsp;������:</td><td>�����</td></tr>";}
if ($uslov != '') {$body .= "<tr bgcolor=$maincolor><td valign=top>�������:</td><td>$uslov</td></tr>";}
if ($comment != '')
{
$comment = ereg_replace("\n","<br>",$comment);
$body .= "<tr bgcolor=$maincolor><td colspan=2><b>&nbsp;����������� � ������:</b></td></tr>";
$body .= "<tr bgcolor=$maincolor><td colspan=2><a align=justify>$comment</p></td></tr>";
}
$body .= "</table></td></tr></table></div><br>";
} // ������

$body .= ("
<div align=left>
<table border=0 width=100%  cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
");
$body .= ("
<tr bgcolor=$maincolor><td align=left colspan=2><b>������������ ������</b></td></tr>
<tr bgcolor=$maincolor><td valign=top>
");
if ($foto1 != '')
{
$fotourl=$foto1;
if (file_exists($photodir.'s'.$fotourl)) {$fotourl="s$fotourl";}
$body .= "<a href=\"$siteadress/photo.php?link=$ID&f=$photodir$fotourl&w=$w\" target=_blank><img src=\"$siteadress/$photodir$fotourl\" height=$smallfotoheight alt=\"���������\" border=0></a>";
}
elseif ($foto1 == '')
{
$body .= "<img src=$siteadress/picture/showphoto.gif alt=\"��� ����������\" border=0>";
}
$body .= "</td><td valign=top width=100%>";
if ($cfio != '') {$body .= "<b>���</b>: $cfio<br>";}
if ($gender == '�������') {$body .= "<b>���</b>: �������<br>";}
if ($gender == '�������') {$body .= "<b>���</b>: �������<br>";}
if ($age != 0) {$body .= "<b>�������</b>: $age ���(����)<br>";}
if ($family != '') {$body .= "<b>�������� ���������</b>: $family<br>";}
if ($civil != '') {$body .= "<b>�����������</b>: $civil<br>";}
if ($citys != '') {$body .= "<b>����� ����������</b>: $citys<br>";}
if ($telephone != '') {$body .= "<b>���:</b>: $telephone<br>";}
if ($email != '' and $hidemail != 'checked') {$body .= "<b>Email</b>: <a href=mailto:$email>$email</a><br>";}
if ($email != '' and $hidemail == 'checked') {$body .= "<b>Email</b>: ����� ������������� (������� �� ����, ����� ��������� ������)<br>";}
$body .= "</td></tr>";

$body .= "<tr bgcolor=$maincolor><td colspan=2><b>&nbsp;���� ������:</b>";
if ($expir5org != '' or $expir5perfmonth != '' or $expir5perfyear != '' or $expir5pertmonth != '' or $expir5pertyear != '' or $expir5dol != '' or $expir5obyaz != '') 
{
$body .= "<br><br>$expir5perfmonth $expir5perfyear";
if ($expir5pertmonth != '' or $expir5pertyear != '') {$body .= " - $expir5pertmonth $expir5pertyear";}
if ($expir5org != '') {$body .= " &nbsp;&nbsp;<b>$expir5org</b>";}
if ($expir5dol != '') {$body .= " <br>���������: <b>$expir5dol</b>";}
if ($expir5obyaz != '') {$expir5obyaz = ereg_replace("\n","<br>",$expir5obyaz); $body .= "<br><br>$expir5obyaz";}
}
if ($expir4org != '' or $expir4perfmonth != '' or $expir4perfyear != '' or $expir4pertmonth != '' or $expir4pertyear != '' or $expir4dol != '' or $expir4obyaz != '') 
{
$body .= "<br><br>$expir4perfmonth $expir4perfyear";
if ($expir4pertmonth != '' or $expir4pertyear != '') {$body .= " - $expir4pertmonth $expir4pertyear";}
if ($expir4org != '') {$body .= " &nbsp;&nbsp;<b>$expir4org</b>";}
if ($expir4dol != '') {$body .= " <br>���������: <b>$expir4dol</b>";}
if ($expir4obyaz != '') {$expir4obyaz = ereg_replace("\n","<br>",$expir4obyaz); $body .= "<br><br>$expir4obyaz";}
}
if ($expir3org != '' or $expir3perfmonth != '' or $expir3perfyear != '' or $expir3pertmonth != '' or $expir3pertyear != '' or $expir3dol != '' or $expir3obyaz != '') 
{
$body .= "<br><br>$expir3perfmonth $expir3perfyear";
if ($expir3pertmonth != '' or $expir3pertyear != '') {$body .= " - $expir3pertmonth $expir3pertyear";}
if ($expir3org != '') {$body .= " &nbsp;&nbsp;<b>$expir3org</b>";}
if ($expir3dol != '') {$body .= " <br>���������: <b>$expir3dol</b>";}
if ($expir3obyaz != '') {$expir3obyaz = ereg_replace("\n","<br>",$expir3obyaz); $body .= "<br><br>$expir3obyaz";}
}
if ($expir2org != '' or $expir2perfmonth != '' or $expir2perfyear != '' or $expir2pertmonth != '' or $expir2pertyear != '' or $expir2dol != '' or $expir2obyaz != '') 
{
$body .= "<br><br>$expir2perfmonth $expir2perfyear";
if ($expir2pertmonth != '' or $expir2pertyear != '') {$body .= " - $expir2pertmonth $expir2pertyear";}
if ($expir2org != '') {$body .= " &nbsp;&nbsp;<b>$expir2org</b>";}
if ($expir2dol != '') {$body .= " <br>���������: <b>$expir2dol</b>";}
if ($expir2obyaz != '') {$expir2obyaz = ereg_replace("\n","<br>",$expir2obyaz); $body .= "<br><br>$expir2obyaz";}
}
if ($expir1org != '' or $expir1perfmonth != '' or $expir1perfyear != '' or $expir1pertmonth != '' or $expir1pertyear != '' or $expir1dol != '' or $expir1obyaz != '') 
{
$body .= "<br><br>$expir1perfmonth $expir1perfyear";
if ($expir1pertmonth != '' or $expir1pertyear != '') {$body .= " - $expir1pertmonth $expir1pertyear";}
if ($expir1org != '') {$body .= " &nbsp;&nbsp;<b>$expir1org</b>";}
if ($expir1dol != '') {$body .= " <br>���������: <b>$expir1dol</b>";}
if ($expir1obyaz != '') {$expir1obyaz = ereg_replace("\n","<br>",$expir1obyaz); $body .= "<br><br>$expir1obyaz";}
}
$body .= "</td></tr>";

if ($prof != '')
{
$prof = ereg_replace("\n","<br>",$prof);
$body .= "<tr bgcolor=$maincolor><td colspan=2><b>&nbsp;���������������� ������ � ������:</b></td></tr>";
$body .= "<tr bgcolor=$maincolor><td colspan=2><a align=justify>$prof</p></td></tr>";
}

$body .= "<tr bgcolor=$maincolor><td colspan=2><b>&nbsp;�����������:</b>";
if ($edu5sel != '' or $edu5school != '' or $edu5year != '' or $edu5fac != '' or $edu5spec != '')
{
$body .= "<br><br><b>$edu5sel</b>";
if ($edu5year != '') {$body .= " $edu5year";}
if ($edu5school != '') {$body .= " &nbsp;&nbsp;<b>$edu5school</b>";}
if ($edu5fac != '') {$body .= " <br><b>���������</b>: $edu5fac";}
if ($edu5spec != '') {$body .= " <br><b>�������������</b>: $edu5spec";}
}
if ($edu4sel != '' or $edu4school != '' or $edu4year != '' or $edu4fac != '' or $edu4spec != '')
{
$body .= "<br><br><b>$edu4sel</b>";
if ($edu4year != '') {$body .= " $edu4year";}
if ($edu4school != '') {$body .= " &nbsp;&nbsp;<b>$edu4school</b>";}
if ($edu4fac != '') {$body .= " <br><b>���������</b>: $edu4fac";}
if ($edu4spec != '') {$body .= " <br><b>�������������</b>: $edu4spec";}
}
if ($edu3sel != '' or $edu3school != '' or $edu3year != '' or $edu3fac != '' or $edu3spec != '')
{
$body .= "<br><br><b>$edu3sel</b>";
if ($edu3year != '') {$body .= " $edu3year";}
if ($edu3school != '') {$body .= " &nbsp;&nbsp;<b>$edu3school</b>";}
if ($edu3fac != '') {$body .= " <br><b>���������</b>: $edu3fac";}
if ($edu3spec != '') {$body .= " <br><b>�������������</b>: $edu3spec";}
}
if ($edu2sel != '' or $edu2school != '' or $edu2year != '' or $edu2fac != '' or $edu2spec != '')
{
$body .= "<br><br><b>$edu2sel</b>";
if ($edu2year != '') {$body .= " $edu2year";}
if ($edu2school != '') {$body .= " &nbsp;&nbsp;<b>$edu2school</b>";}
if ($edu2fac != '') {$body .= " <br><b>���������</b>: $edu2fac";}
if ($edu2spec != '') {$body .= " <br><b>�������������</b>: $edu2spec";}
}
if ($edu1sel != '' or $edu1school != '' or $edu1year != '' or $edu1fac != '' or $edu1spec != '')
{
$body .= "<br><br><b>$edu1sel</b>";
if ($edu1year != '') {$body .= " $edu1year";}
if ($edu1school != '') {$body .= " &nbsp;&nbsp;<b>$edu1school</b>";}
if ($edu1fac != '') {$body .= " <br><b>���������</b>: $edu1fac";}
if ($edu1spec != '') {$body .= " <br><b>�������������</b>: $edu1spec";}
}
$body .= "</td></tr>";

$body .= "<tr bgcolor=$maincolor><td colspan=2><b>&nbsp;������ ����������� ������:</b>";
if ($lang5 != '' or $lang5uroven != '') 
{
$body .= "<br>$lang5";
if ($lang5uroven != '') {$body .= "&nbsp;-&nbsp;$lang5uroven";}
}
if ($lang4 != '' or $lang4uroven != '') 
{
$body .= "<br>$lang4";
if ($lang4uroven != '') {$body .= "&nbsp;-&nbsp;$lang4uroven";}
}
if ($lang3 != '' or $lang3uroven != '') 
{
$body .= "<br>$lang3";
if ($lang3uroven != '') {$body .= "&nbsp;-&nbsp;$lang3uroven";}
}
if ($lang2 != '' or $lang2uroven != '') 
{
$body .= "<br>$lang2";
if ($lang2uroven != '') {$body .= "&nbsp;-&nbsp;$lang2uroven";}
}
if ($lang1 != '' or $lang1uroven != '') 
{
$body .= "<br>$lang1";
if ($lang1uroven != '') {$body .= "&nbsp;-&nbsp;$lang1uroven";}
}
$body .= "</td></tr>";

if ($dopsved != '')
{
$dopsved = ereg_replace("\n","<br>",$dopsved);
$body .= "<tr bgcolor=$maincolor><td colspan=2><b>&nbsp;�������������� ��������:</b></td></tr>";
$body .= "<tr bgcolor=$maincolor><td colspan=2><a align=justify>$dopsved</p></td></tr>";
}
$body .= ("
<tr bgcolor=$maincolor><td colspan=2><a href=$siteadress/linkres.php?link=$resID>�������� ������</a></td></tr>
</table></td></tr></table></div>
");

$basketselectresult = @mysql_query("SELECT * FROM $vacordertable WHERE (user = '$REMOTE_ADDR' and status='basket') order by ID DESC");
if (@mysql_num_rows($basketselectresult) != 0)
{ //s2
while ($myrow=mysql_fetch_array($basketselectresult)) 
{ //s3
$unitID=$myrow["ID"];
$unit=$myrow["unit"];
$number=$myrow["number"];
$result = @mysql_query("SELECT ID,aid,profecy FROM $vactable WHERE ID=$unit and status='ok'");
while ($myrow=@mysql_fetch_array($result)) 
{ //s4
$vacID=$myrow["ID"];
$vacaid=$myrow["aid"];
$vacprofecy=$myrow["profecy"];
$txttop = ("
������������!<br>
�� ���� �������� <a href=\"$siteadress/linkvac.php?link=$vacID\"><b>$vacprofecy</b></a><br>
����������� �� ����� <a href=$siteadress>$sitename</a> ���������� ������������ ������ ����������.<br><br>
");
$resultaut = @mysql_query("SELECT ID,email FROM $autortable WHERE ID='$vacaid'");
while ($myrow=mysql_fetch_array($resultaut)) 
{ //s5
$vacemail=$myrow["email"];
$rastext = $txttop.$body.$txtdown;
mail($vacemail,"������ �� ���� �������� � ����� $sitename",$rastext,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/html; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");
} //s5
} //s4
} //s3
} //s2
echo "<h3 align=left class=tbl1>������ ���������� ����������!</h3><br><br>";
} //send
//---------------main--------------
echo "<p align=left class=tbl1><a href=autor.php>��������� � ��������� ������</a></p>";
}//1
if ($pr != 'print') {include("down.php");}
?>