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

<head>
<META NAME=ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<?php
include("var.php");
$maxThread = 20;
echo "<title>����������������� - ��������� ��������: $sitename</title>";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\">";
include("top.php");
$result = @mysql_query("SELECT pass FROM $admintable");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
$err1="�������� ������!<br>";
$err2="�� ������� �� ������ ����������!<br>";
$error = "";
if (!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass)
{
echo "<center><b>�� �� <a href=admin.php>��������������</a>!</b><br><br>";
}
else
{ // ok
echo "<center><p><strong><big>����������������� - ��������� ��������</strong></big>";
echo "<form name=delreg method=post action=adminov.php?confirm>";
if ($_SERVER[QUERY_STRING] != "confirm") 
{
$result = @mysql_query("SELECT *,DATE_FORMAT(date,'%d.%m.%Y') as date FROM $vactable WHERE status='wait' order by date DESC");
$totaltexts=@mysql_num_rows($result);
if ($totaltexts == 0 and $textconfirm == 'TRUE') {echo "<center><b>��� ���������� ��� ���������!</b>";}
elseif ($totaltexts == 0 and $textconfirm == 'FALSE') {echo "<center><b>������� ��������� ���������!</b>";}
else
{ //2
echo "<center>��� ��������� ���������� �������� �� �������� � ������� ������ \"��������\"<br>����� �������� ��� ���������: <b>$totaltexts</b><br><br>";
echo ("
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$maincolor><td><img src=\"picture/basket.gif\" border=0></td><td>���������</td><td>��������</td><td>���� ����.</td><td>�����</td></tr>
");
while ($myrow=mysql_fetch_array($result)) 
{ //4
$id=$myrow["ID"];
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
$status=$myrow["status"];
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
if ($status=='ok') {$statusline='<font color=green>��������</font>';}
if ($status=='wait') {$statusline='<font color=red>�� ��������</font>';}
echo ("
<tr bgcolor=$maincolor>
<td valign=top width=20><input type=checkbox name=confmes[] value=$id></td>
<td valign=top><a href=adminlv.php?link=$id target=_blank><b>$profecy</b></a><br>$razdel1&nbsp;/&nbsp;$podrazdel1<br>
");
$br=0;
if ($gender == '�������') {$br=1; echo "�������&nbsp;";}
if ($gender == '�������') {$br=1; echo "�������&nbsp;";}
if ($agemin != 0 and $agemax == 0) {$br=1; echo "�� $agemin ���;&nbsp";}
if ($agemin == 0 and $agemax != 0) {$br=1; echo "�� $agemax ���;&nbsp";}
if ($agemin != 0 and $agemax != 0) {$br=1; echo "�� $agemin �� $agemax ���;&nbsp";}
if ($edu != '' and $edu != '��&nbsp;�����') {$br=1; echo "����������� $edu;&nbsp";}
if ($grafic != '' and !eregi("�����",$grafic)) {echo "<br>$grafic";}
if ($br==1) {echo "<br>";}
echo ("
����������: $treb
</td>
<td valign=top><b>$zp</b> $valute</td>
<td valign=top>$date<br><a href=adminlv.php?link=$id target=_blank><small>���������...</small></a></td>
<td valign=top>
<a href=admincv.php?texid=$id>������</a>
</td>
</tr>
");
} //4
echo "</table></td></tr></table>";
echo ("
<br><center><input type=submit value='�������� ����������' name=conf>&nbsp;<input type=submit name=delete value='������� ����������'>
<br><br><input type=submit name=sendwarn value='��������� ���������� ������ � ������� ����'><br>
<textarea rows=3 name=send_mess cols=28>���� �������� �� ������������ ����������� �����. ���������� �������������� ��. � ��������� ������ ���������� ����� ������� �� ���� �����!</textarea><br><small>����������: ����������� � ��������� ����� ������������� �������������.</small>
");
} //2
echo "</form>";
}
}
if ($_SERVER[QUERY_STRING] == "confirm"){
$confmes=$_POST['confmes'];
$send_mess=$_POST['send_mess'];
if (count($confmes)==0) {
	$error .= "$err2";}
if ($error != ""){
echo "<center><h3>������</h3><font color=red>$error</font><p><a href=# onClick=history.go(-1)>��������� �����</a><p><br><br><br><br><br><br><br><br>";
}
if ($error==""){
if ($_SERVER[QUERY_STRING] == "confirm" and isset($_POST['conf'])) {
for ($i=0;$i<count($confmes);$i++){
$result=@mysql_query("update $vactable SET status='ok' WHERE ID=$confmes[$i]");
$resultsr = @mysql_query("SELECT *,DATE_FORMAT(date,'%d.%m.%Y') as date,LPAD(ID,4,'0') as nID FROM $vactable WHERE ID=$confmes[$i]");
while ($myrow2=@mysql_fetch_array($resultsr)) 
{ // while2
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
$emailto=$myrow11["email"];
$acity=$myrow11["city"];
$telephone=$myrow11["telephone"];
$aadress=$myrow11["adress"];
$url=$myrow11["url"];
$fio=$myrow11["fio"];
$afirm=$myrow11["firm"];
}

$body = ("
<div align=center><table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$altcolor><td align=center><b>�������� $nID</b></td></tr></table></td></tr></table>
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$maincolor><td valign=top colspan=2><b>������������ ���������:</b> $profecy</b>. �������� �� <font color=blue><b>$zp</b></font> $valute<br></td></tr>
<tr bgcolor=$maincolor><td align=center colspan=2><b>���������� � �������</b></td></tr>
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
<tr bgcolor=$maincolor><td align=right colspan=2><a href=$siteadress/linkvac.php?link=$ID>���������...</a></td></tr>
</table></td></tr></table></div><br>
");
}
$txt="������������!<br><br>���� �������� ���� ��������� � ��������� � ���� ���������� ����� <a href=$siteadress>$sitename</a>!<br><br>$body<br><br>������� �� ����������� ����� ������!<br><br>-----------<br>$siteadress<br>$adminemail";
mail($emailto,"�������� ��������� - $sitename",$txt,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/html; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");
}
echo "<br><br><h3 align=center>��������� �������� �������� � ��������� � ����� ����!</h3><br><br>";

if ($textconfirm == 'TRUE')
{ // confirm
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
$resultsr = @mysql_query("SELECT *,DATE_FORMAT(date,'%d.%m.%Y') as date,LPAD(ID,8,'0') as nID FROM $vactable WHERE status='ok' $lsrrazdel $lsrpodrazdel $lsrcountry $lsrregion $lsrcity $lsrprofecy $lsrage $lsredu $lsrzp $lsrzanatost $lsrgrafic $lsrgender and ID='$lastid'");
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
$acity=$myrow11["city"];
$telephone=$myrow11["telephone"];
$aadress=$myrow11["adress"];
$url=$myrow11["url"];
$fio=$myrow11["fio"];
$afirm=$myrow11["firm"];
}

$body = ("
<div align=center><table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$altcolor><td align=center><b>�������� $nID</b></td></tr></table></td></tr></table>
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$maincolor><td valign=top colspan=2><b>������������ ���������:</b> $profecy</b>. �������� �� <font color=blue><b>$zp</b></font> $valute<br></td></tr>
<tr bgcolor=$maincolor><td align=center colspan=2><b>���������� � �������</b></td></tr>
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
<tr bgcolor=$maincolor><td align=right colspan=2><a href=$siteadress/linkvac.php?link=$ID>���������...</a></td></tr>
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
$promotxt="<div align=center>";
while($myrow=mysql_fetch_array($resultprtop))
{
$ptitle=$myrow["title"];
$plink=$myrow["link"];
$pfoto=$myrow["foto"];
$promotxt .= "<table border=0 bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=1 width=100%><tr bgcolor=$maincolor><td><a href=\"$plink\" target=_blank><img src=\"cid:promo\" alt=\"$ptitle\" border=0></a></td></tr></table></td></tr></table><br>";
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
} // confirm

}
if ($_SERVER[QUERY_STRING] == "confirm" and isset($_POST['delete'])) {
for ($i=0;$i<count($confmes);$i++){
$res2 = @mysql_query("SELECT ID,aid FROM $vactable WHERE ID=$confmes[$i]");
while($myrow=mysql_fetch_array($res2)) {
$emaid=$myrow["aid"];
}
$res2 = @mysql_query("SELECT ID,email FROM $autortable WHERE ID=$emaid");
while($myrow=mysql_fetch_array($res2)) {
$emailto=$myrow["email"];
}
$result=@mysql_query("delete from $vactable where ID=$confmes[$i]");
$txt="������������!<br>�������� ���� ���������, �� ���� �������� ���� ������� �� ���� ���������� ����� <a href=$siteadress>$sitename</a>!<br>�������: �������������� ����������� �����!<br><br>� ���������,!<br>-----------<br>$siteadress<br>$adminemail";
mail($emailto,"���������� ������� - $sitename",$txt,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/html; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");
}
echo "<br><br><h3 align=center>��������� �������� �������!</h3><br><br>";
}

if ($_SERVER[QUERY_STRING] == "confirm" and isset($_POST['sendwarn'])) {
for ($i=0;$i<count($confmes);$i++){
$res2 = @mysql_query("SELECT * FROM $vactable WHERE ID=$confmes[$i]");
while($myrow=mysql_fetch_array($res2)) {
$emaid=$myrow["aid"];
}
$res2 = @mysql_query("SELECT ID,email FROM $autortable WHERE ID=$emaid");
while($myrow=mysql_fetch_array($res2)) {
$emailto=$myrow["email"];
}
$txt="������������!<br><br>$send_mess<br><br>� ���������,!<br>-----------<br>$siteadress<br>$adminemail";
@mail($emailto,"�������� �� �������� - $sitename",$txt,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/html; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");
}
echo "<br><br><h3 align=center>������ �� ��������� �������� ���������!</h3><br><br>";
}

}
} //ok
echo "<center><a href=admin.php>�� ����� �������� �����������������</a><br><br>";
include("down.php");
?>