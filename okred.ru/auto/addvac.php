<?
session_start();
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
echo"<title>���������� �������� : $sitename</title>";
include("top.php");
echo "<div class=tbl1>";
?>
<h1>���������� ��������</h1>
<?php
$delip=mysql_query("delete from $bunsiptable where (((date + INTERVAL 86400*period SECOND) < now()) and period != '')");
$REMOTE_ADDR=$_SERVER['REMOTE_ADDR'];
$id=$_SESSION['sid'];
$slogin=$_SESSION['slogin'];
$spass=$_SESSION['spass'];
if (isset($_POST['razdel'])) {$razdel = ereg_replace("--",",",$_POST['razdel']);}
if (isset($_GET['razdel'])) {$razdel = ereg_replace("--",",",$_GET['razdel']);}
$maxmage = 3;
$maxzp = 8;
$maxprofecy = 50;
$maxcomment = 1000;
$maxstage = 50;
$maxcity = 50;
$maxfirm = 100;
$maxadress = 200;
$err1 = "������������ ��������� ������ ���� �� ������ $maxprofecy ��������<br>";
$err2 = "������� ������ ���� �� ������ $maxmage ��������<br>";
$err3 = "�������� ������ ���� �� ������ $maxzp ��������<br>";
$err4 = "���� ������ ������ ���� �� ������ $maxstage ��������<br>";
$err5 = "����� ���������� ������ ���� �� ������ $maxcomment ��������<br>";
$err6 = "����� ������������ ������ ���� �� ������ $maxcomment ��������<br>";
$err7 = "����� ������� ������ ���� �� ������ $maxcomment ��������<br>";
$err8 = "�������� ����������� ������ ���� �� ������ $maxfirm ��������<br>";
$err9 = "����� ������ ���� �� ������ $maxcity ��������<br>";
$err10 = "���� ��������������� ������ ���� �� ������ $maxadress ��������<br>";
$err11 = "�� ��������� ������������ ���� - ����� ������������!<br>";
$err12 = "�� ��������� ������������ ���� - ������!<br>";
$err13 = "�� ��������� ������������ ���� - ������������ ���������!<br>";
$err14 = "�� ��������� ������������ ���� - ����������!<br>";
$err15 = "�� ��������� ������������ ���� - �������� ��...!<br>";
$err16 = "�� ��������� ������������ ���� - �����!<br>";
$err17 = "�� ��������� ������������ ���� - ������ ����������!<br>";

$err19 = "���������� ���������� ���������� ���� �����! <br>";
$err300 = "�� ������ �������� ���!<br>";

$error = "";
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
$result = @mysql_query("SELECT email,pass,category,addobyavl,country,region,city FROM $autortable WHERE email = '$slogin' and pass = '$spass' and addobyavl=''");
if ((!isset($slogin) or !isset($spass)) or @mysql_num_rows($result) == 0)
{
echo "<br><br><h3>�� �� �������������� ���� ��� ��������� ��������� ����������!</h3><b><a href=autor.php>�����������</a></b>";
}
else
{//1
while($myrow=mysql_fetch_array($result)) {
$who=$myrow["category"];
$afcountry=$myrow["country"];
$afregion=$myrow["region"];
$afcity=$myrow["city"];
}
$resultban = @mysql_query("SELECT * FROM $bunsiptable WHERE bunsip = '$REMOTE_ADDR'");
if (@mysql_num_rows($resultban) != 0) {
while($myrow=mysql_fetch_array($resultban)) {
$ID=$myrow["ID"];
$bunsip=$myrow["bunsip"];
$bunwhy=$myrow["why"];
}
echo "<p><font color=red>������ � �������� ���������� ������� ��� ���, � ���������, ������!</font></p><blockquote><p align=justify><b>�������:</b> $bunwhy</p><br><br>";
}
elseif (@mysql_num_rows($resultban) == 0) 
{ //bunip
$resultraz = @mysql_query("SELECT email,pass,category FROM $autortable WHERE email = '$slogin' and pass = '$spass' and (category = 'rab' or category = 'agency')");
if (@mysql_num_rows($resultraz) == 0)
{
echo "<br><br><h3>�������� ����� ��������� ������ ������������ � ���������!</h3><b><a href=registr.php>�����������</a></b>";
}
elseif (mysql_num_rows($resultraz) != 0) 
{ // ��������1

if ($_SERVER[QUERY_STRING] != "add") {
if (!isset($_GET['country']) or $_GET['country']=='0') {$country=$afcountry;}
if (!isset($_GET['region']) or $_GET['region']=='0') {$region=$afregion;}
$city=$afcity;
}

if ($_SERVER[QUERY_STRING] == "add") {

$razdel=$_POST['razdel'];
$podrazdel=$_POST['podrazdel'];
$profecy=$_POST['profecy'];
$agemin=$_POST['agemin'];
$agemax=$_POST['agemax'];
$edu=$_POST['edu'];
$zp=$_POST['zp'];
$gender=$_POST['gender'];
$grafic=$_POST['grafic'];
$zanatost=$_POST['zanatost'];
$stage=$_POST['stage'];
$treb=$_POST['treb'];
$obyaz=$_POST['obyaz'];
$uslov=$_POST['uslov'];
$city=$_POST['city'];
$region=$_POST['region'];
$country=$_POST['country'];
$adress=$_POST['adress'];
$firm=$_POST['firm'];
$period=$_POST['period'];
$number=$_POST['number'];
$metro=$_POST['metro'];

$curdate = date("Y-m-d H:i:s", time());
$expdate = date("Y-m-d H:i:s", time()- 60*$antiflood);
$result3 = @mysql_query("SELECT date,ip,aid FROM $vactable WHERE ip='$REMOTE_ADDR' and aid=$id and date < '$curdate' and date > '$expdate'");
//if (@mysql_num_rows($result3) != 0) {$error .= "$err19";}
if (strlen($profecy) > $maxprofecy) {$error .= "$err1";}
if (strlen($agemin) > $maxmage or strlen($agemax) > $maxmage) {$error .= "$err2";}
if (strlen($zp) > $maxzp) {$error .= "$err3";}
if (strlen($stage) > $maxstage) {$error .= "$err4";}
if (strlen($treb) > $maxcomment) {$error .= "$err5";}
if (strlen($obyaz) > $maxcomment) {$error .= "$err6";}
if (strlen($uslov) > $maxcomment) {$error .= "$err7";}
if (strlen($firm) > $maxfirm) {$error .= "$err8";}
if (strlen($citynew) > $maxcity) {$error .= "$err9";}
if (strlen($adress) > $maxadress) {$error .= "$err10";}
if ($razdel == "" or $razdel == '0' ) {$error .= "$err11";}
if (isset($podrazdel) and $podrazdel == "") {$error .= "$err12";}
if ($profecy == "") {$error .= "$err13";}
if ($treb == "") {$error .= "$err14";}
if ($zp == "") {$error .= "$err15";}
if ($period == "") {$error .= "$err17";}
if ($imgobyavlconfirm == 'TRUE' and $_COOKIE['reg_num'] != $number) {$error .= "$err300";}

// �����
if ($city == "") {
$resultadd1 = @mysql_query("SELECT ID,razdel,podrazdel FROM $citytable WHERE podrazdel = '' and ID='$country'");
while($myrow=mysql_fetch_array($resultadd1)) {
$countrys1=$myrow["razdel"];
}
$resultadd2 = @mysql_query("SELECT ID,podrazdel FROM $citytable WHERE ID='$region'");
while($myrow=mysql_fetch_array($resultadd2)) {
$regions1=$myrow["podrazdel"];
}
if ($region != "")
{
$result3c = @mysql_query("SELECT * FROM $citytable WHERE razdel='$countrys1' and podrazdel='$regions1' and categ != '' LIMIT 1");
if (@mysql_num_rows($result3c) != 0) {
$error .= "�� ��������� ������������ ���� - �����<br>";
}
}
if ($region == "")
{
$result3c = @mysql_query("SELECT * FROM $citytable WHERE razdel='$countrys1' and categ != '' LIMIT 1");
if (@mysql_num_rows($result3c) != 0) {
$error .= "�� ��������� ������������ ���� - �����<br>";
}
}
}
// �����

echo "<font color=red>$error</font>";
function untag ($string) {
$string = ereg_replace("<","&lt;",$string);
$string = ereg_replace(">","&gt;",$string);
$string = ereg_replace('\\\"',"&quot;",$string);
$string = ereg_replace(":","&#58;",$string);
$string = ereg_replace("!","&#33;",$string);
$string = ereg_replace("\r","",$string);
$string = ereg_replace("%","&#37;",$string);
$string = ereg_replace("^ +","",$string);
$string = ereg_replace(" +$","",$string);
$string = ereg_replace(" +"," ",$string);
return $string;
}
$profecy = untag($profecy);
$agemin = untag($agemin);
$agemax = untag($agemax);
$zp = untag($zp);
$treb = untag($treb);
$uslov = untag($uslov);
$obyaz = untag($obyaz);
if ($_SERVER[QUERY_STRING] == "add" and $error == "") {
if ($textconfirm=='TRUE') {$status='wait';$stroka='<b>����� �������� ���������� ��������������� ��� ����� ��������� � ����� ����.</b>';}
elseif ($textconfirm=='FALSE') {$status='ok';$stroka='<b>� ������� ���������� ����� ���������� ����� �������� ��� ���������</b>';}
$sql="insert into $vactable (razdel,podrazdel,profecy,agemin,agemax,edu,zp,gender,grafic,zanatost,stage,treb,obyaz,uslov,country,region,city,adress,firm,period,aid,date,status,ip,category,metro) values ('$razdel','$podrazdel','$profecy','$agemin','$agemax','$edu','$zp','$gender','$grafic','$zanatost','$stage','$treb','$obyaz','$uslov','$country','$region','$city','$adress','$firm','$period','$id',now(),'$status','$REMOTE_ADDR','$who','$metro')";
$result=@mysql_query($sql,$db);

if ($textconfirm == 'FALSE')
{ // no confirm
$result1 = @mysql_query("SELECT ID FROM $vactable order by ID DESC LIMIT 1");
while ($myrow=@mysql_fetch_array($result1)) 
{
$lastid=$myrow["ID"];
}
$resl = @mysql_query("SELECT name,status FROM $rassilka WHERE name='admin'");
while ($myrow=mysql_fetch_array($resl)) 
{
$rstatus=$myrow["status"];
}
if ($rstatus == 'on')
{ //ras

function XMail( $from, $to, $subj, $text, $filename) { 
    $f         = fopen($filename,"rb"); 
    $un        = strtoupper(uniqid(time())); 
    $head      = "From: $from\n"; 
    $head     .= "To: $to\n"; 
    $head     .= "Subject: $subj\n"; 
    $head     .= "X-Mailer: PHPMail Tool\n"; 
    $head     .= "Reply-To: $from\n"; 
    $head     .= "Mime-Version: 1.0\n"; 
    $head     .= "Content-Type:multipart/mixed;"; 
    $head     .= "boundary=\"----------".$un."\"\n\n"; 
    $zag       = "------------".$un."\nContent-Type:text/html;charset=windows-1251\n"; 
    $zag      .= "Content-Transfer-Encoding: 8bit\n\n$text\n\n"; 

    $zag      .= "------------".$un."\n"; 
    $zag      .= "Content-Type: application/octet-stream;"; 
    $zag      .= "name=\"".basename($filename)."\"\n"; 
    $zag      .= "Content-Transfer-Encoding:base64\n";
    $zag      .= "Content-ID: <promo>\n";
    $zag      .= "Content-Disposition:attachment;";
    $zag      .= "filename=\"".basename($filename)."\"\n\n"; 
    $zag      .= chunk_split(base64_encode(fread($f,filesize($filename))))."\n"; 
     
    return @mail("$to", "$subj", $zag, $head); 
} 

$result = mysql_query("SELECT * FROM $rasvac");
if (mysql_num_rows($result) != 0)
{ //has
while ($myrow=mysql_fetch_array($result)) 
{ //while
$srprofecy=$myrow["srprofecy"];
$srage=$myrow["srage"];
$sredu=$myrow["sredu"];
$srzp=$myrow["srzp"];
$srgender=$myrow["srgender"];
$srgrafic=$myrow["srgrafic"];
$srzanatost=$myrow["srzanatost"];
$srcountry=$myrow["srcountry"];
$srregion=$myrow["srregion"];
$srcity=$myrow["srcity"];
$razdel=$myrow["razdel"];
$podrazdel=$myrow["podrazdel"];
$autoraid=$myrow["aid"];
$lsrrazdel='';
$lsrpodrazdel='';
$lsrcountry='';
$lsrregion='';
$lsrcity='';
$lsrprofecy='';
$lsrage='';
$lsredu='';
$lsrzp='';
$lsrzanatost='';
$lsrgrafic='';
$lsrgender='';
$lsrcomment='';
if ($podrazdel != '' and $podrazdel != '0' and $podrazdel != '%')
{
$lsrpodrazdel="and podrazdel = $podrazdel";
}
if ($razdel != '' and $razdel != '0' and $razdel != '%')
{
$lsrrazdel="and razdel = $razdel";
}
if ($srcountry != "0" and $srcountry != '') {$lsrcountry="and country = '$srcountry'";}
if ($srregion != "0" and $srregion != '') {$lsrregion="and region = '$srregion'";}
if ($srcity != "0" and $srcity != '') {$lsrcity="and city = '$srcity'";}
if ($srprofecy != "%" and $srprofecy != '') {$srprofecy = ereg_replace(" ","*.",$srprofecy); $lsrprofecy="and profecy REGEXP '$srprofecy'";}
if ($srage != "%" and $srage != '' and $srage != 0) {$lsrage="and (agemin = '' or agemin < '$srage') and (agemax = '' or agemax > '$srage')";}
if ($sredu != "%" and $sredu != '') {
if ($sredu == '��������') {$lsredu="and (edu='��������' or edu='��&nbsp;�����' or edu='')";}
if ($sredu == '�������') {$lsredu="and (edu='��������' or edu='�������' or edu='��&nbsp;�����' or edu='')";}
if (eregi ('�����������',$sredu)) {$lsredu="and (edu='��������' or edu='�������' or edu='�������&nbsp;�����������' or edu='��&nbsp;�����' or edu='')";}
if (eregi ('��������',$sredu)) {$lsredu="and (edu='��������' or edu='�������' or edu='�������&nbsp;�����������' or edu='��������&nbsp;������' or edu='��&nbsp;�����' or edu='')";}
if ($sredu == '������') {$lsredu="and (edu='��������' or edu='�������' or edu='�������&nbsp;�����������' or edu='��������&nbsp;������' or edu='������' or edu='��&nbsp;�����' or edu='')";}
}
if ($srzp != "" and $srzp != '%') {$lsrzp="and (zp >= $srzp or zp=0)";}
if ($srzanatost != "%" and $srzanatost != '') {
if ($srzanatost == '������') {$lsrzanatost="and (zanatost REGEXP '������' or zanatost = '' or zanatost='��&nbsp;�����')";}
if (eregi ('����������������',$srzanatost)) {$lsrzanatost="and zanatost REGEXP '��&nbsp;����������������'";}
}
if ($srgrafic != "%" and $srgrafic != '') {
if ($srgrafic == '������&nbsp;����') {$lsrgrafic="and (grafic REGEXP '������&nbsp;����' or grafic = '' or grafic='��&nbsp;�����')";}
if (eregi ('��������',$srgrafic)) {$lsrgrafic="and (grafic REGEXP '��������' or grafic = '' or grafic='��&nbsp;�����')";}
if (eregi ('���������',$srzanatost)) {$lsrgrafic="and (grafic REGEXP '���������' or grafic = '' or grafic='��&nbsp;�����')";}
if (eregi ('���������',$srzanatost)) {$lsrgrafic="and (grafic REGEXP '���������' or grafic = '' or grafic='��&nbsp;�����')";}
}
if ($srgender != "%" and $srgender != '') {
if ($srgender == '�������') {$lsrgender="and (gender REGEXP '�������' or gender = '' or gender='��&nbsp;�����')";}
if ($srgender == '�������') {$lsrgender="and (gender REGEXP '�������' or gender = '' or gender='��&nbsp;�����')";}
}
$resultsr = @mysql_query("SELECT *,DATE_FORMAT(date,'%d.%m.%Y') as date,LPAD(ID,4,'0') as nID FROM $vactable WHERE status='ok' $lsrrazdel $lsrpodrazdel $lsrcountry $lsrregion $lsrcity $lsrprofecy $lsrage $lsredu $lsrzp $lsrzanatost $lsrgrafic $lsrgender and ID='$lastid'");
if (mysql_num_rows($resultsr) != 0)
{ // ���� ����������
while ($myrow2=@mysql_fetch_array($resultsr)) 
{ // while2

if ($rasfull == 'FALSE')
{ // short
$ID=$myrow2["ID"];
$profecy=$myrow2["profecy"];
$zp=$myrow2["zp"];
$agemin=$myrow2["agemin"];
$agemax=$myrow2["agemax"];
$edu=$myrow2["edu"];
$gender=$myrow2["gender"];
$grafic=$myrow2["grafic"];
$zanatost=$myrow2["zanatost"];
$treb=$myrow2["treb"];
$aid=$myrow2["aid"];
$date=$myrow2["date"];
$razdel=$myrow2["razdel"];
$podrazdel=$myrow2["podrazdel"];
$resultadd2 = @mysql_query("SELECT ID,podrazdel FROM $catable WHERE ID='$podrazdel'");
while($myrow3=mysql_fetch_array($resultadd2)) {
$podrazdel1=$myrow3["podrazdel"];
}
$resultadd1 = @mysql_query("SELECT ID,razdel,podrazdel FROM $catable WHERE podrazdel = '' and ID='$razdel'");
while($myrow3=mysql_fetch_array($resultadd1)) {
$razdel1=$myrow3["razdel"];
}
$body=("
<a href=$siteadress/linkvac.php?link=$ID><b>$profecy</b></a>&nbsp;-&nbsp;\$$zp<br>
");
$br=0;
if ($gender == '�������') {$br=1; $body .="�������&nbsp";}
if ($gender == '�������') {$br=1; $body .="�������&nbsp";}
if ($agemin != 0 and $agemax == 0) {$br=1; $body .="�� $agemin ���;&nbsp";}
if ($agemin == 0 and $agemax != 0) {$br=1; $body .="�� $agemax ���;&nbsp";}
if ($agemin != 0 and $agemax != 0) {$br=1; $body .="�� $agemin �� $agemax ���;&nbsp";}
if ($edu != '' and !eregi("�����",$edu)) {$br=1; $body .="����������� $edu;&nbsp";}
if ($br==1) {$body .="<br>";}
$body .= ("
����������: $treb
<br><a href=$siteadress/linkvac.php?link=$ID>���������...</a><br><br>
");
} // short

if ($rasfull == 'TRUE')
{ // full
$ID=$myrow2["ID"];
$nID=$myrow2["nID"];
$profecy=$myrow2["profecy"];
$agemin=$myrow2["agemin"];
$agemax=$myrow2["agemax"];
$edu=$myrow2["edu"];
$zp=$myrow2["zp"];
$gender=$myrow2["gender"];
$grafic=$myrow2["grafic"];
$zanatost=$myrow2["zanatost"];
$stage=$myrow2["stage"];
$treb=$myrow2["treb"];
$obyaz=$myrow2["obyaz"];
$uslov=$myrow2["uslov"];
$country=$myrow2["country"];
$region=$myrow2["region"];
$city=$myrow2["city"];

$citytar=$city;
if ($city=='0') {$citytar=$region;}
if ($region=='0' and $city=='0') {$citytar=$country;}
$resultadd3c = @mysql_query("SELECT * FROM $citytable WHERE ID='$citytar'");
while($myrowc=mysql_fetch_array($resultadd3c)) {
$citys=$myrowc["categ"];
if ($city=='0') {$citys=$myrowc["podrazdel"];}
if ($city=='0' and $region=='0') {$citys=$myrowc["razdel"];}
}

$adress=$myrow2["adress"];
$firm=$myrow2["firm"];
$aid=$myrow2["aid"];
$date=$myrow2["date"];
$razdel=$myrow2["razdel"];
$podrazdel=$myrow2["podrazdel"];
$resultadd2 = @mysql_query("SELECT ID,podrazdel FROM $catable WHERE ID='$podrazdel'");
while($myrow13=mysql_fetch_array($resultadd2)) {
$podrazdel1=$myrow13["podrazdel"];
}
$resultadd1 = @mysql_query("SELECT ID,razdel,podrazdel FROM $catable WHERE podrazdel = '' and ID='$razdel'");
while($myrow13=mysql_fetch_array($resultadd1)) {
$razdel1=$myrow13["razdel"];
}
$resultaut = @mysql_query("SELECT * FROM $autortable WHERE ID='$aid'");
while ($myrow11=mysql_fetch_array($resultaut)) {
$category=$myrow11["category"];
$email=$myrow11["email"];
$country=$myrow1["country"];
$region=$myrow1["region"];
$city=$myrow11["city"];
$telephone=$myrow11["telephone"];
$aadress=$myrow11["adress"];
$url=$myrow11["url"];
$fio=$myrow11["fio"];
$afirm=$myrow11["firm"];
}

$body = ("
<div ><table border=0 width=100%  cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$altcolor><td ><b>�������� $nID</b></td></tr></table></td></tr></table>
<table border=0 width=90%  cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$maincolor><td valign=top colspan=2><b>������������ ���������:</b> $profecy</b>. �������� �� <font color=blue><b>$zp</b></font> $valute<br></td></tr>
<tr bgcolor=$maincolor><td  colspan=2><b>���������� � �������</b></td></tr>
");
if ($agemin != 0 and $agemax == 0) {$body .= "<tr bgcolor=$maincolor><td>�������:</td><td>�� $agemin ���</td></tr>";}
if ($agemin == 0 and $agemax != 0) {$body .= "<tr bgcolor=$maincolor><td>�������:</td><td>�� $agemax ���</td></tr>";}
if ($agemin != 0 and $agemax != 0) {$body .= "<tr bgcolor=$maincolor><td>�������:</td><td>�� $agemin �� $agemax ���</td></tr>";}
if ($gender == '�������') {$body .= "<tr bgcolor=$maincolor><td>���:</td><td>�������</td></tr>";}
if ($gender == '�������') {$body .= "<tr bgcolor=$maincolor><td>���:</td><td>�������</td></tr>";}
if ($edu != '' and !eregi("�����",$edu)) {$body .= "<tr bgcolor=$maincolor><td>�����������:</td><td>$edu</td></tr>";}
if ($edu != '' and eregi("�����",$edu)) {$body .= "<tr bgcolor=$maincolor><td>�����������:</td><td>�����</td></tr>";}
if ($zanatost != '' and !eregi("�����",$zanatost)) {$body .= "<tr bgcolor=$maincolor><td>���������:</td><td>$zanatost</td></tr>";}
if ($zanatost != '' and eregi("�����",$zanatost)) {$body .= "<tr bgcolor=$maincolor><td>���������:</td><td>�����</td></tr>";}
if ($grafic != '' and !eregi("�����",$grafic)) {$body .= "<tr bgcolor=$maincolor><td>������&nbsp;������:</td><td>$grafic</td></tr>";}
if ($grafic != '' and eregi("�����",$grafic)) {$body .= "<tr bgcolor=$maincolor><td>������&nbsp;������:</td><td>�����</td></tr>";}
if ($stage != '') {$body .= "<tr bgcolor=$maincolor><td>���� ������:</td><td>$stage</td></tr>";}
if ($treb != '') {$body .= "<tr bgcolor=$maincolor><td valign=top>����������:</td><td>$treb</td></tr>";}
if ($obyaz != '') {$body .= "<tr bgcolor=$maincolor><td valign=top>�����������:</td><td>$obyaz</td></tr>";}
if ($uslov != '') {$body .= "<tr bgcolor=$maincolor><td valign=top>�������:</td><td>$uslov</td></tr>";}
if ($citys != '' or $adress !='') {$body .= "<tr bgcolor=$maincolor><td valign=top>�����&nbsp;������:</td><td>$citys $adress</td></tr>";}
if ($firm != '') {$body .= "<tr bgcolor=$maincolor><td valign=top>����������� (����� ������):</td><td valign=top>$firm</td></tr>";}
$body .= ("
<tr bgcolor=$maincolor><td align=left width=40% colspan=2><a href=$siteadress/linkvac.php?link=$ID>���������...</a></td></tr>
</table></td></tr></table></div><br>
");
} // full

} //while2
$resultb = mysql_query("SELECT * FROM $rasvac where aid='$autoraid'");
while ($myrow4=mysql_fetch_array($resultb)) 
{$txt=$myrow4["txt"];}

//<!-- ��������� ���� �������� -->

$promotxt='';

 $resultprtop = mysql_query("select * from $promotable where wheres = 'rassilka' order by RAND() limit 1");
 $rows = mysql_num_rows($resultprtop);
if($rows != 0)
{
$promotxt="<div >";
while($myrow=mysql_fetch_array($resultprtop))
{
$ptitle=$myrow["title"];
$plink=$myrow["link"];
$pfoto=$myrow["foto"];
$promotxt .= "<table border=0  cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=1 width=100%><tr bgcolor=$maincolor><td><a href=\"$plink\" target=_blank><img src=\"cid:promo\" alt=\"$ptitle\" border=0></a></td></tr></table></td></tr></table><br>";
}
$promotxt .= "</div>";
}


//<!-- ��������� ���� �������� -->

$body = $txt.$body;
$resultras = mysql_query("UPDATE $rasvac SET txt='$body',sum=sum+1 WHERE aid='$autoraid'");
} // ���� ����������
} //while
} //has

$resultsend = mysql_query("SELECT * FROM $rasvac WHERE sum >= $sendcount");
if (mysql_num_rows($resultsend) != 0)
{ //send
$txttop="������������!<br>��� ������ ���������� ��� � ����� � ����� ��������� �� ����� �������� ����� <a href=$siteadress>$sitename</a><br><br>������ ��������� $sendcount ��������:<br><br>";
$txtdown = "<br>������� �� ����������� ����� ������!<br><a href=$siteadress>$sitename</a>";
while ($myrow=mysql_fetch_array($resultsend)) 
{ //while3
$said=$myrow["aid"];
$hID=$myrow["ID"];
$txtbody=$myrow["txt"];
$bodyfull=$promotxt.$txttop.$txtbody.$txtdown;
$resl2 = @mysql_query("SELECT email,ID FROM $autortable WHERE ID='$said'");
while ($myrow5=mysql_fetch_array($resl2)) 
{
$rassemail=$myrow5["email"];
}
Xmail($adminemail,$rassemail,"����� �������� �� ����� $sitename",$bodyfull,"$promo_dir$pfoto");
$resultdel = mysql_query("UPDATE $rasvac SET sum=0,txt='' WHERE ID = '$hID'");
} //while3
} //send

} //ras
} // no confirm

}
}
if ($_SERVER[QUERY_STRING] != "add" or $error != "") {

if ($_GET['razdel'] == '') {$razdel=$_POST['razdel'];}
elseif ($_GET['razdel'] != '') {$razdel=$_GET['razdel'];}
if ($_GET['podrazdel'] == '') {$podrazdel=$_POST['podrazdel'];}
elseif ($_GET['podrazdel'] != '') {$podrazdel=$_GET['podrazdel'];}

if ($city == '')
{
if ($_GET['city'] == '') {$city=$_POST['city'];}
elseif ($_GET['city'] != '') {$city=$_GET['city'];}
}
if ($region == '')
{
if ($_GET['region'] == '') {$region=$_POST['region'];}
elseif ($_GET['region'] != '') {$region=$_GET['region'];}
}
if ($country == '')
{
if ($_GET['country'] == '') {$country=$_POST['country'];}
elseif ($_GET['country'] != '') {$country=$_GET['country'];}
}

if (isset($city) and $city != '')
{
$resultadd3 = @mysql_query("SELECT ID,categ FROM $citytable WHERE ID='$city'");
while($myrow=mysql_fetch_array($resultadd3)) {
$citys=$myrow["categ"];
}
}
if (isset($region) and $region != '')
{
$resultadd2 = @mysql_query("SELECT ID,podrazdel FROM $citytable WHERE ID='$region'");
while($myrow=mysql_fetch_array($resultadd2)) {
$regions=$myrow["podrazdel"];
}
}
$resultadd1 = @mysql_query("SELECT ID,razdel,podrazdel FROM $citytable WHERE podrazdel = '' and ID='$country'");
while($myrow=mysql_fetch_array($resultadd1)) {
$countrys=$myrow["razdel"];
}

if (isset($podrazdel) and $podrazdel != '')
{
$resultadd2 = @mysql_query("SELECT * FROM $catable WHERE ID='$podrazdel' LIMIT 1");
while($myrow=mysql_fetch_array($resultadd2)) {
$podrazdelsh=$myrow["podrazdel"];
}
}
$resultadd1 = @mysql_query("SELECT * FROM $catable WHERE ID='$razdel' LIMIT 1");
while($myrow=mysql_fetch_array($resultadd1)) {
$razdelsh=$myrow["razdel"];
}

echo ("
<form name=form method=post action=addvac.php?add ENCTYPE=multipart/form-data>

<blockquote><p align=justify>���������� ������ ��������� ���������� ������. ���������� �������� ������ �������� � ����� �������, ���� �������� ����������:<br>
<li>� �����-������� �������, ����� <br>
<li>������������� ���������� � ���������� ����� ������� ��� <br>
<li>����������� �������� ������ ������, �� ��������� � �����������<br>
<li>��������� � ���������� ����������� ����� <br>
<li>� ������ ��������� ���������������� ������, ������, ������� ������������, ������ �������� � ��.<br><br>
������ �������� ���������� ��������� � ������ ������ � �� ����� ����� ����� ��������� � ������� ���������� �� ���� �����.
</p></blockquote><br>
<p class=star>������������ ���� �������� �������� <font color=#FF0000>*</font></p>   
<table border=0 width=90%  cellspacing=0 cellpadding=0><tr><td>
<table cellspacing=1 cellpadding=4 width=100%>
<tr bgcolor=$maincolor><td align=left width=40%><font color=#FF0000>*</font>����� ������������:</td>
<td align=left width=40%>
<select class=for name=razdel size=1 onChange=location.href=location.pathname+\"?razdel=\"+value+\"\";>
<option selected value=\"$razdel\">$razdelsh</option>
");
$result2 = @mysql_query("SELECT * FROM $catable WHERE podrazdel = '' order by razdel");
while($myrow=mysql_fetch_array($result2)) {
$razdel1=$myrow["razdel"];
$razdel1ID=$myrow["ID"];
$razdel11 = ereg_replace(",","--",$razdel1);
echo "<option value=\"$razdel1ID\">$razdel1</option>";
}
echo ("
</select></td></tr>
");
if ($razdel != '')
{
$result3 = @mysql_query("SELECT * FROM $catable WHERE podrazdel != '' and razdel='$razdelsh' order by podrazdel");
if (@mysql_num_rows($result3) != 0) {
echo ("
<tr bgcolor=$maincolor><td align=left width=40%><font color=#FF0000>*</font>������:</td>
<td align=left width=40%><select class=for name=podrazdel size=1 onChange=location.href=location.pathname+\"?razdel=$razdel&podrazdel=\"+value+\"\";>
<option selected value=\"$podrazdel\">$podrazdelsh</option>
");
while($myrow=mysql_fetch_array($result3)) {
$podrazdel1=$myrow["podrazdel"];
$podrazdelID=$myrow["ID"];
echo "<option value=\"$podrazdelID\">$podrazdel1</option>";
}
echo ("
</select></td></tr>
");
}
elseif (@mysql_num_rows($result3) == 0) {
echo "<input type=hidden name=podrazdel value=0>";
}
}
echo ("
<tr bgcolor=$maincolor><td valign=top align=left><font color=#FF0000>*</font>������:</td>
<td valign=top align=left>
<select class=for name=country size=1 onChange=location.href=location.pathname+\"?razdel=$razdel&podrazdel=$podrazdel&country=\"+value+\"\";>
<option selected value=\"$country\">$countrys</option>
");
$result2 = @mysql_query("SELECT * FROM $citytable WHERE podrazdel = '' and categ='' order by razdel");
while($myrow=mysql_fetch_array($result2)) {
$razdel1=$myrow["razdel"];
$razdel2=$myrow["ID"];
echo "<option value=\"$razdel2\">$razdel1</option>";
}
echo ("
</select></td></tr>
");
if ($country != '')
{ // ������
$result1 = @mysql_query("SELECT * FROM $citytable WHERE razdel='$countrys' and podrazdel != '' and categ='' order by podrazdel");
if (@mysql_num_rows($result1) != 0)
{ // ���� ������
echo ("
<tr bgcolor=$maincolor><td valign=top align=left><font color=#FF0000>*</font>������:</td>
<td valign=top align=left><select class=for name=region size=1 onChange=location.href=location.pathname+\"?razdel=$razdel&podrazdel=$podrazdel&country=$country&region=\"+value+\"\";>
<option selected value=\"$region\">$regions</option>
");
$result3 = @mysql_query("SELECT * FROM $citytable WHERE podrazdel != '' and razdel='$countrys' and categ='' order by podrazdel");
while($myrow=mysql_fetch_array($result3)) {
$podrazdel1=$myrow["podrazdel"];
$podrazdel2=$myrow["ID"];
echo "<option value=\"$podrazdel2\">$podrazdel1</option>";
}
echo ("
</select></td></tr>
");
if ($region != '')
{ // ������
$result4 = @mysql_query("SELECT * FROM $citytable WHERE podrazdel = '$regions' and razdel='$countrys' and categ != '' order by categ");
if (@mysql_num_rows($result4) != 0) {
echo ("
<tr bgcolor=$maincolor><td valign=top align=left><font color=#FF0000>*</font>�����:</td>
<td valign=top align=left><select class=for name=city size=1 onChange=location.href=location.pathname+\"?razdel=$razdel&podrazdel=$podrazdel&country=$country&region=$region&city=\"+value+\"\";>
<option selected value=\"$city\">$citys</option>
");
while($myrow=mysql_fetch_array($result4)) {
$categ=$myrow["categ"];
$categ2=$myrow["ID"];
echo "<option value=\"$categ2\">$categ</option>";
}
echo ("
</select></td></tr>
");
}
} // ������
} // ���� ������
elseif (@mysql_num_rows($result1) == 0)
{ // ��� �������
$result4 = @mysql_query("SELECT * FROM $citytable WHERE podrazdel = '$regions' and razdel='$countrys' and categ != '' order by categ");
if (@mysql_num_rows($result4) != 0) {
echo ("
<tr bgcolor=$maincolor><td valign=top align=left><font color=#FF0000>*</font>�����:</td>
<td valign=top align=left><select class=for name=city size=1 onChange=location.href=location.pathname+\"?razdel=$razdel&podrazdel=$podrazdel&country=$country&region=$region&city=\"+value+\"\";>
<option selected value=\"$city\">$citys</option>
");
while($myrow=mysql_fetch_array($result4)) {
$categ=$myrow["categ"];
$categ2=$myrow["ID"];
echo "<option value=\"$categ2\">$categ</option>";
}
echo ("
</select></td></tr>
");
}
} // ��� �������
} // ������

if ($city != '') {$srcity="$city";}
if ($city == '' and $region != '') {$srcity="$region";}
if ($city == '' and $region == '' and $country != '') {$srcity="$country";}
if ($city == '' and $region == '' and $country == '') {$srcity="";}

if ($srcity != '')
{ // city
$qwery1="and city = '$srcity'";
} // city
if ($srcity == "") {$qwery1='';}

$result5 = @mysql_query("SELECT * FROM $metrotable WHERE metro != '' $qwery1 order by metro");
if (@mysql_num_rows($result5) != 0) {
echo ("
<tr bgcolor=$maincolor><td align=left width=40%>�����:</td>
<td align=left width=40%><select class=for name=metro size=1>
<option selected value=\"$metro\">$metro</option>
");
while($myrow=mysql_fetch_array($result5)) {
$metro=$myrow["metro"];
echo "<option value=\"$metro\">$metro</option>";
}
echo ("
</select></td></tr>
");
}

echo ("
<tr bgcolor=$maincolor><td align=left width=40% valign=top><font color=#FF0000>*</font>������������ ���������:</td>
<td><input type=text name=profecy size=30 value=\"$profecy\"></td></tr>
<tr bgcolor=$maincolor><td align=left width=40%>�������:</td>
<td>��&nbsp;<input type=text name=agemin size=5 value=\"$agemin\">&nbsp;��&nbsp;<input type=text name=agemax size=5 value=\"$agemax\">&nbsp;���</td></tr>
<tr bgcolor=$maincolor><td align=left width=40%>�����������:</td>
<td><select class=for name=edu size=1>
<option selected value=\"$edu\">$edu</option>
<option value=\"��&nbsp;�����\">��&nbsp;�����</option>
<option value=\"������\">������</option>
<option value=\"��������&nbsp;������\">��������&nbsp;������</option>
<option value=\"�������&nbsp;�����������\">�������&nbsp;�����������</option>
<option value=\"�������\">�������</option>
<option value=\"��������\">��������</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=left width=40%><font color=#FF0000>*</font>��������:</td>
<td>��&nbsp;<input type=text name=zp size=5 value=\"$zp\">&nbsp;$valute</td></tr>
<tr bgcolor=$maincolor><td align=left width=40%>���:</td>
<td><select class=for name=gender size=1>
<option selected value=\"$gender\">$gender</option>
<option value=\"��&nbsp;�����\">��&nbsp;�����</option>
<option value=\"�������\">�������</option>
<option value=\"�������\">�������</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=left width=40%>���������:</td>
<td><select class=for name=zanatost size=1>
<option selected value=\"$zanatost\">$zanatost</option>
<option value=\"��&nbsp;�����\">��&nbsp;�����</option>
<option value=\"������\">������</option>
<option value=\"��&nbsp;����������������\">��&nbsp;����������������</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=left width=40%>������ ������:</td>
<td><select class=for name=grafic size=1>
<option selected value=\"$grafic\">$grafic</option>
<option value=\"��&nbsp;�����\">��&nbsp;�����</option>
<option value=\"������&nbsp;����\">������&nbsp;����</option>
<option value=\"��������&nbsp;����\">��������&nbsp;����</option>
<option value=\"���������&nbsp;������\">���������&nbsp;������</option>
<option value=\"���������&nbsp;������\">���������&nbsp;������</option>
</select></td></tr>
<tr bgcolor=$maincolor><td align=left width=40%>���� ������:</td>
<td><input type=text name=stage size=30 value=\"$stage\"></td></tr>
<tr bgcolor=$maincolor><td align=left width=40% valign=top><font color=#FF0000>*</font>����������:</td>
<td><textarea class=arria rows=3 name=treb cols=28 class=arria>$treb</textarea></td></tr>
<tr bgcolor=$maincolor><td align=left width=40% valign=top>�����������:</td>
<td><textarea class=arria rows=3 name=obyaz cols=28>$obyaz</textarea></td></tr>
<tr bgcolor=$maincolor><td align=left width=40% valign=top>�������:</td>
<td><textarea class=arria rows=3 name=uslov cols=28>$uslov</textarea></td></tr>
<tr bgcolor=$maincolor><td align=left width=40%>���������������:</td>
<td><input type=text name=adress size=30 value=\"$adress\"></td></tr>
");
if ($who == 'agency')
{
echo ("
<tr bgcolor=$maincolor><td align=left width=40%>�����������(�����):</td>
<td><input type=text name=firm size=30 value=\"$firm\"></td></tr>
");
}
echo ("
<tr bgcolor=$maincolor><td align=left width=40%><font color=#FF0000>*</font>������ ����������:</td>
<td><select class=for name=period size=1>
<option selected value=$period>$period</option>
<option value=10>10</option>
<option value=30>30</option>
<option value=60>60</option>
<option value=90>90</option>
</select>&nbsp;����</td></tr>
");
if ($imgobyavlconfirm == 'TRUE')
{ // img conf
echo "<tr><td align=left width=40% valign=top><font color=#FF0000>*</font>��� �� ��������:&nbsp;";
echo "<img src=code.php>";
echo "</td><td><input type=text name=number size=20 class=for></td></tr>";
} // img conf
echo ("
</table></td></tr></table>
");
echo "<p><input type=submit value=\"����������\" name=\"submit\" class=dob ></form>";
}
else {
echo "<br><h3 >�������� ���������!</h3><br>$stroka<br><br><p ><a href=autor.php>��������� � ��������� ������</a></p><br><br>";
$txt="�� ����� $siteadress - ����� ��������.";
if ($mailadditem == 'TRUE')
{mail($adminemail,"����� �������� �� �����",$txt,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/plain; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");}
}
} // ��������1
} //bunip
}//1
echo "</div>";
include("down.php");
?>