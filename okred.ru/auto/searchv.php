<?
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!--/***************** DO NOT REMOVE! *********************/---->
<!--/*   Author: Nevezhyn Evgeny  Date : 10/02/2003       */---->
<!--/*   nevius@bk.ru      All Rights Reserved ...        */---->
<!--/*   http://nevius.ru/                                */---->
<!--/***************** DO NOT MODIFY! *********************/---->

<head>
<?php
include("var.php");
echo"<title>����� ��������: $sitename</title>";
include("top.php");
$n = getenv('REQUEST_URI');

$p=$_GET['p'];
$d=$_GET['d'];
$bn=$_GET['bn'];
$page=$_GET['page'];
if ($ident == 'session') {$REMOTE_ADDR=$PHPSESSID;}
if ($ident != 'session') {$REMOTE_ADDR=$_SERVER['REMOTE_ADDR'];}

// ------------del old------------
$expdate = date("Y-m-d H:i:s", time()- $delperiod*86400);
$delitemdb=mysql_query("delete from $vacordertable where date < '$expdate'");
// ------------del old------------

$updres=mysql_query("update $vactable set top='0000-00-00 00:00:00' where ((top + INTERVAL 86400*$periodfortop SECOND) < now())");
$updres=mysql_query("update $vactable set bold='0000-00-00 00:00:00' where ((bold + INTERVAL 86400*$periodforbold SECOND) < now())");

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

if ($_GET['srcountry'] == '' and $_GET['srregion'] == '' and $_GET['srcitys1'] == '')
{
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
}

if (!isset($_GET['submit']) and !isset($page)) {
echo "<form name=search method=GET action=\"searchv.php?search\">";

$srregion=$_GET['srregion'];
$srcountry=$_GET['srcountry'];
$srcitys1=$_GET['srcitys1'];
$srrazdel=$_GET['srrazdel'];
$srpodrazdel=$_GET['srpodrazdel'];

if ($srcountry == '' and $srregion == '' and $srcitys1 == '')
{ //���������
if ($srcity != '')
{ // city
if (eregi("^[r]",$srcity)) {
$srcountry=@substr($srcity,1,1000);
}
if (eregi("^[p]",$srcity)) {
$srregion=@substr($srcity,1,1000);
$resultadd1 = @mysql_query("SELECT * FROM $citytable WHERE ID='$srregion' LIMIT 1");
while($myrow2=mysql_fetch_array($resultadd1)) {
$srcountry=$myrow2["razdel"];
}    
$resultadd1 = @mysql_query("SELECT * FROM $citytable WHERE razdel='$srcountry' and podrazdel = '' and categ = '' LIMIT 1");
while($myrow2=mysql_fetch_array($resultadd1)) {
$srcountry=$myrow2["ID"];
}    
}
if (eregi("^[c]",$srcity)) {
$srcitys1=@substr($srcity,1,1000);
$resultadd1 = @mysql_query("SELECT * FROM $citytable WHERE ID='$srcitys1' LIMIT 1");
while($myrow2=mysql_fetch_array($resultadd1)) {
$srcountry=$myrow2["razdel"];
$srregion=$myrow2["podrazdel"];
}    
$resultadd1 = @mysql_query("SELECT * FROM $citytable WHERE razdel='$srcountry' and podrazdel = '' and categ = '' LIMIT 1");
while($myrow2=mysql_fetch_array($resultadd1)) {
$srcountry=$myrow2["ID"];
}    
$resultadd1 = @mysql_query("SELECT * FROM $citytable WHERE podrazdel='$srregion' and categ = '' LIMIT 1");
while($myrow2=mysql_fetch_array($resultadd1)) {
$srregion=$myrow2["ID"];
}    
}
} // city
} //���������

if (isset($srregion) and $srregion != '')
{
$resultadd2 = @mysql_query("SELECT ID,podrazdel FROM $citytable WHERE ID='$srregion'");
while($myrow=mysql_fetch_array($resultadd2)) {
$regions=$myrow["podrazdel"];
}
}
$resultadd1 = @mysql_query("SELECT ID,razdel,podrazdel FROM $citytable WHERE podrazdel = '' and ID='$srcountry'");
while($myrow=mysql_fetch_array($resultadd1)) {
$countrys=$myrow["razdel"];
}
if (isset($srpodrazdel) and $srpodrazdel != '')
{
$resultadd2 = @mysql_query("SELECT * FROM $catable WHERE ID='$srpodrazdel' LIMIT 1");
while($myrow=mysql_fetch_array($resultadd2)) {
$podrazdelsh=$myrow["podrazdel"];
}
}
$resultadd1 = @mysql_query("SELECT * FROM $catable WHERE ID='$srrazdel' LIMIT 1");
while($myrow=mysql_fetch_array($resultadd1)) {
$razdelsh=$myrow["razdel"];
}

echo ("
<center><table bgcolor=$maincolor border=0 width=100% cellpadding=4 cellspacing=10 class=tbl1>
<tr bgcolor=#F9F9F9><td align=left>����� ������������:</td>
<td align=left>
<select class=for name=srrazdel size=1 onChange=location.href=location.pathname+\"?srrazdel=\"+value+\"\";>
");
if ($razdelsh=='')
{
echo ("
<option selected value=>�����</option>
");
}
if ($razdelsh != '')
{
echo ("
<option selected value=\"$srrazdel\">$razdelsh</option>
<option value=>�����</option>
");
}
$result2 = @mysql_query("SELECT * FROM $catable WHERE podrazdel = '' order by razdel");
while($myrow=mysql_fetch_array($result2)) {
$razdel1=$myrow["razdel"];
$razdel1ID=$myrow["ID"];
echo "<option value=\"$razdel1ID\">$razdel1</option>";
}
echo ("
</select></td></tr>
");
if ($srrazdel != '')
{
$result3 = @mysql_query("SELECT * FROM $catable WHERE podrazdel != '' and razdel='$razdelsh' order by podrazdel");
if (@mysql_num_rows($result3) != 0) {
echo ("
<tr bgcolor=#F9F9F9><td align=left>������:</td>
<td align=left><select class=for name=srpodrazdel size=1 onChange=location.href=location.pathname+\"?srrazdel=$srrazdel&srpodrazdel=\"+value+\"\";>
");
if ($podrazdelsh == '')
{
echo ("
<option selected value=>�����</option>
");
}
if ($podrazdelsh != '')
{
echo ("
<option selected value=\"$srpodrazdel\">$podrazdelsh</option>
<option value=>�����</option>
");
}
while($myrow=mysql_fetch_array($result3)) {
$podrazdel1=$myrow["podrazdel"];
$podrazdel1ID=$myrow["ID"];
echo "<option value=\"$podrazdel1ID\">$podrazdel1</option>";
}
echo ("
</select>
</td></tr>
");
}
}
echo ("
<tr bgcolor=#F9F9F9><td valign=top align=left>������:</td>
<td valign=top align=left>
<select class=for name=srcountry size=1 onChange=location.href=location.pathname+\"?srw=$srw&srrazdel=$srrazdel&srpodrazdel=$srpodrazdel&srcountry=\"+value+\"\";>
");
if ($countrys == '')
{
echo ("
<option selected value=>�����</option>
");
}
if ($countrys != '')
{
echo ("
<option selected value=\"$srcountry\">$countrys</option>
<option value=>�����</option>
");
}
$result2 = @mysql_query("SELECT * FROM $citytable WHERE podrazdel = '' and categ='' order by razdel");
while($myrow=mysql_fetch_array($result2)) {
$razdel1=$myrow["razdel"];
$razdel2=$myrow["ID"];
echo "<option value=\"$razdel2\">$razdel1</option>";
}
echo ("
</select></td></tr>
");
if ($srcountry != '')
{ // ������
$result1 = @mysql_query("SELECT * FROM $citytable WHERE razdel='$countrys' and podrazdel != '' and categ='' order by podrazdel");
if (@mysql_num_rows($result1) != 0)
{ // ���� ������
echo ("
<tr bgcolor=#F9F9F9><td valign=top align=left>������:</td>
<td valign=top align=left><select class=for name=srregion size=1 onChange=location.href=location.pathname+\"?srw=$srw&srrazdel=$srrazdel&srpodrazdel=$srpodrazdel&srcountry=$srcountry&srregion=\"+value+\"\";>
");
if ($regions == '')
{
echo ("
<option selected value=>�����</option>
");
}
if ($regions != '')
{
echo ("
<option selected value=\"$srregion\">$regions</option>
<option value=>�����</option>
");
}
$result3 = @mysql_query("SELECT * FROM $citytable WHERE podrazdel != '' and razdel='$countrys' and categ='' order by podrazdel");
while($myrow=mysql_fetch_array($result3)) {
$podrazdel1=$myrow["podrazdel"];
$podrazdel2=$myrow["ID"];
echo "<option value=\"$podrazdel2\">$podrazdel1</option>";
}
echo ("
</select></td></tr>
");
if ($srregion != '')
{ // ������
$result4 = @mysql_query("SELECT * FROM $citytable WHERE podrazdel = '$regions' and razdel='$countrys' and categ != '' order by categ");
if (@mysql_num_rows($result4) != 0) {
echo ("
<tr bgcolor=#F9F9F9><td valign=top align=left>�����:</td>
<td valign=top align=left><select class=for name=srcitys1 size=1 onChange=location.href=location.pathname+\"?srw=$srw&srrazdel=$srrazdel&srpodrazdel=$srpodrazdel&srcountry=$srcountry&srregion=$srregion&srcitys1=\"+value+\"\";>
<option selected value=>�����</option>
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
<tr bgcolor=#F9F9F9><td valign=top align=left>�����:</td>
<td valign=top align=left><select class=for name=srcitys1 size=1 onChange=location.href=location.pathname+\"?srw=$srw&srrazdel=$srrazdel&srpodrazdel=$srpodrazdel&srcountry=$srcountry&srregion=$srregion&srcitys1=\"+value+\"\";>
<option selected value=>�����</option>
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

if ($srcitys1 != '') {$srcitys1="$srcitys1";}
if ($srcitys1 == '' and $srregion != '') {$srcitys1="$srregion";}
if ($srcitys1 == '' and $srregion == '' and $srcountry != '') {$srcitys1="$srcountry";}
if ($srcitys1 == '' and $srregion == '' and $srcountry == '') {$srcitys1="";}

if ($srcitys1 != '')
{ // city
$qwery1c="and city = '$srcitys1'";
} // city
if ($srcitys1 == "") {$qwery1c='';}

echo ("
<tr bgcolor=#F9F9F9><td align=left>�����:</td>
<td align=left><select class=for name=srmetro size=1>
<option selected value=>�� �����</option>
");
$result5 = @mysql_query("SELECT * FROM $metrotable WHERE metro != '' $qwery1c order by metro");
while($myrow=mysql_fetch_array($result5)) {
$metro=$myrow["metro"];
echo "<option value=\"$metro\">$metro</option>";
}

echo ("
<tr bgcolor=#F9F9F9>
<td align=left>��������������� (�����):</td>
<td align=left><input type=text class=for name=sradres size=20></td>
</tr>
<tr bgcolor=#F9F9F9>
<td align=left>���������:</td>
<td align=left><input type=text class=for name=srprofecy size=20></td>
</tr>
<tr bgcolor=#F9F9F9><td align=left>�������:</td>
<td align=left><input type=text class=for name=srage size=3> ���</td></tr>
<tr bgcolor=#F9F9F9>
<td align=left>�����������:</td>
<td align=left><select class=for name=sredu size=1>
<option selected value=nnn>�����</option>
<option value=\"������\">������</option>
<option value=\"��������&nbsp;������\">��������&nbsp;������</option>
<option value=\"�������&nbsp;�����������\">�������&nbsp;�����������</option>
<option value=\"�������\">�������</option>
<option value=\"��������\">��������</option>
</select>
</td></tr>
<tr bgcolor=#F9F9F9><td align=left>��������:</td>
<td>�����&nbsp;<input type=text class=for name=srzp size=5>&nbsp;$valute</td></tr>
<tr bgcolor=#F9F9F9><td align=left>���������:</td>
<td><select class=for name=srzanatost size=1>
<option selected value=nnn>�����</option>
<option value=\"������\">������</option>
<option value=\"��&nbsp;����������������\">��&nbsp;����������������</option>
</select></td></tr>
<tr bgcolor=#F9F9F9><td align=left>������ ������:</td>
<td><select class=for name=srgrafic size=1>
<option selected value=nnn>�����</option>
<option value=\"������&nbsp;����\">������&nbsp;����</option>
<option value=\"��������&nbsp;����\">��������&nbsp;����</option>
<option value=\"���������&nbsp;������\">���������&nbsp;������</option>
<option value=\"���������&nbsp;������\">���������&nbsp;������</option>
</select></td></tr>
<tr bgcolor=#F9F9F9>
<td align=left>���:</td>
<td align=left><select class=for name=srgender size=1>
<option selected value=nnn>�����</option>
<option value=�������>�������</option>
<option value=�������>�������</option>
</select>
</td></tr>
<tr bgcolor=#F9F9F9>
<td align=left>�������� �����:</td>
<td align=left><input type=text class=for name=srcomment size=20></td>
</tr>
<tr bgcolor=#F9F9F9>
<td  align=left>����������� �� ���������:&nbsp;</td><td>
<select class=for name=per size=1>
<option selected value=30>30</option>
<option value=15>15</option>
<option value=10>10</option>
<option value=5>5</option>
<option value=3>3</option>
<option value=1>1</option>
</select> ����</td>
</tr>
<tr bgcolor=#F9F9F9>
<td align=left>���������� �������� �� ��������:&nbsp;</td><td>
<select class=for name=maxThread size=1>
<option selected value=10>10</option>
<option value=25>25</option>
<option value=50>50</option>
</select></td>
</tr>
<tr bgcolor=$maincolor>
<td colspan=2 align=center>&nbsp;</td></tr>
<tr bgcolor=$maincolor>
<td colspan=2 align=center><input type=submit value=������ name=submit class=dob></td></tr>
</table>
</form>
");
}
if (isset($_GET['submit']) or isset($page)) {

$srregion=$_GET['srregion'];
$srcountry=$_GET['srcountry'];
$srcitys1=$_GET['srcitys1'];
$srpodrazdel=$_GET['srpodrazdel'];
$srrazdel=$_GET['srrazdel'];
$srprofecy=$_GET['srprofecy'];
$srage=$_GET['srage'];
$sredu=$_GET['sredu'];
$srzp=$_GET['srzp'];
$srzanatost=$_GET['srzanatost'];
$srgrafic=$_GET['srgrafic'];
$srgender=$_GET['srgender'];
$srcomment=$_GET['srcomment'];
$srtime=$_GET['srtime'];
$maxThread=$_GET['maxThread'];
$ord=$_GET['ord'];
$srmetro=$_GET['srmetro'];

$srcomment=mb_strtolower($srcomment);
$srprofecy=mb_strtolower($srprofecy);

$lsradres='';
$lsrprofecy='';
$lsrage='';
$lsredu='';
$lsrzp='';
$lsrzanatost='';
$lsrgrafic='';
$lsrgender='';
$lsrcomment='';

if ($srpodrazdel != '') {$qwerypodrazdel="and podrazdel = $srpodrazdel";}
if ($srpodrazdel == '') {$qwerypodrazdel="";}
if ($srrazdel != '') {$qweryrazdel="and razdel = $srrazdel";}
if ($srrazdel == '') {$qweryrazdel="";}
if ($srcountry != '') {$qwerycountry="and country = $srcountry";}
if ($srcountry == '') {$qwerycountry="";}
if ($srregion != '') {$qweryregion="and region = $srregion";}
if ($srregion == '') {$qweryregion="";}
if ($srcitys1 != '') {$qwerycity="and city = $srcitys1";}
if ($srcitys1 == '') {$qwerycity="";}

if ($srmetro != '%' and $srmetro != '') {$srmetro = ereg_replace(" ","*.",$srmetro); $qwerymetro="and metro REGEXP '$srmetro'";}
if ($srmetro == '%' or $srmetro == '') {$qwerymetro='';}

if ($sradres != "nnn" and $sradres != '') {$sradres = ereg_replace(" ","*.",$sradres); $lsradres="and LOWER(adress) REGEXP '$sradres'";}
if ($srprofecy != "nnn" and $srprofecy != '') {$srprofecy = ereg_replace(" ","*.",$srprofecy); $lsrprofecy="and LOWER(profecy) REGEXP '$srprofecy'";}
if ($srcomment != "nnn" and $srcomment != '') {$srcomment = ereg_replace(" ","*.",$srcomment); $lsrcomment="and (LOWER(profecy) REGEXP '$srcomment' or LOWER(treb) REGEXP '$srcomment' or LOWER(obyaz) REGEXP '$srcomment' or LOWER(uslov) REGEXP '$srcomment' or LOWER(edu) REGEXP '$srcomment')";}
if ($srage != "nnn" and $srage != '') {$lsrage="and (agemin = '' or agemin < '$srage') and (agemax = '' or agemax > '$srage')";}
if ($sredu != "nnn" and $sredu != '') {
if ($sredu == '��������') {$lsredu="and (edu='��������' or edu='��&nbsp;�����' or edu='')";}
if ($sredu == '�������') {$lsredu="and (edu='��������' or edu='�������' or edu='��&nbsp;�����' or edu='')";}
if (eregi ('�����������',$sredu)) {$lsredu="and (edu='��������' or edu='�������' or edu='�������&nbsp;�����������' or edu='��&nbsp;�����' or edu='')";}
if (eregi ('��������',$sredu)) {$lsredu="and (edu='��������' or edu='�������' or edu='�������&nbsp;�����������' or edu='��������&nbsp;������' or edu='��&nbsp;�����' or edu='')";}
if ($sredu == '������') {$lsredu="and (edu='��������' or edu='�������' or edu='�������&nbsp;�����������' or edu='��������&nbsp;������' or edu='������' or edu='��&nbsp;�����' or edu='')";}
}
if ($srzp != "" and $srzp != 'nnn') {$lsrzp="and zp >= $srzp or zp=0";}
if ($srzanatost != "nnn" and $srzanatost != '') {
if ($srzanatost == '������') {$lsrzanatost="and (zanatost REGEXP '������' or zanatost = '' or zanatost='��&nbsp;�����')";}
if (eregi ('����������������',$srzanatost)) {$lsrzanatost="and zanatost REGEXP '��&nbsp;����������������'";}
}
if ($srgrafic != "nnn" and $srgrafic != '') {
if ($srgrafic == '������&nbsp;����') {$lsrgrafic="and (grafic = '������&nbsp;����' or grafic = '' or grafic='��&nbsp;�����')";}
if (eregi ('��������',$srgrafic)) {$lsrgrafic="and grafic = '��������&nbsp;����'";}
if (eregi ('���������',$srzanatost)) {$lsrgrafic="and grafic = '���������&nbsp;������'";}
if (eregi ('���������',$srzanatost)) {$lsrgrafic="and grafic = '���������&nbsp;������'";}
}
if ($srgender != "nnn" and $srgender != '') {
if ($srgender == '�������') {$lsrgender="and (gender REGEXP '�������' or gender = '' or gender='��&nbsp;�����')";}
if ($srgender == '�������') {$lsrgender="and (gender REGEXP '�������' or gender = '' or gender='��&nbsp;�����')";}
}
if ($per != '') {$srper="and ((now() - INTERVAL 86400*$per SECOND) < date)";}
if ($per == '') {$srper='';}
$result = @mysql_query("SELECT * FROM $vactable WHERE status='ok' $lsradres $lsrprofecy $lsrage $lsredu $lsrzp $lsrzanatost $lsrgrafic $lsrgender $lsrcomment $srper $qwerycountry $qweryregion $qwerycity $qwerypodrazdel $qweryrazdel $qwery1 $qwerymetro");
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
$line = "<ul>";
for ($k = 1; $k <= $pages; $k++) {
  if ($k != $page) {$line .= "<li><a href=\"searchv.php?srrazdel=$srrazdel&srpodrazdel=$srpodrazdel&srcountry=$srcountry&srregion=$srregion&srcitys1=$srcitys1&srmetro=$srmetro&sradres=$sradres&srprofecy=$srprofecy&srage=$srage&sredu=$sredu&srzp=$srzp&srzanatost=$srzanatost&srgrafic=$srgrafic&srgender=$srgender&srcomment=$srcomment&per=$per&maxThread=$maxThread&submit=submit&ord=$ord&page=$k\">$k</a></li>";}
  if ($k == $page) {$line .= "<li>$k </li>";}
}
$line .= "<ul>";

if ($totaltexts == 0) {echo "<br><b>�������� �� �������</b><br><br>";}
elseif ($totaltexts != 0) 
{ //2

echo ("
<p class=\"path\"> �����������  <a href=\"searchv.php?srrazdel=$srrazdel&srpodrazdel=$srpodrazdel&srcountry=$srcountry&srregion=$srregion&srcitys1=$srcitys1&srmetro=$srmetro&sradres=$sradres&srprofecy=$srprofecy&srage=$srage&sredu=$sredu&srzp=$srzp&srzanatost=$srzanatost&srgrafic=$srgrafic&srgender=$srgender&srcomment=$srcomment&per=$per&maxThread=$maxThread&submit=submit&ord=date\">�� ����</a> <a href=\"searchv.php?srrazdel=$srrazdel&srpodrazdel=$srpodrazdel&srcountry=$srcountry&srregion=$srregion&srcitys1=$srcitys1&srmetro=$srmetro&sradres=$sradres&srprofecy=$srprofecy&srage=$srage&sredu=$sredu&srzp=$srzp&srzanatost=$srzanatost&srgrafic=$srgrafic&srgender=$srgender&srcomment=$srcomment&per=$per&maxThread=$maxThread&submit=submit&ord=zp\">�� ��������</a></p>
");

echo "������� <b>$totaltexts</b> ��������</p>";

if (!isset($ord) or $ord == "") {$qweryord='date DESC';}
if (isset($ord) and $ord != "") {$qweryord=$ord;}
$result = @mysql_query("SELECT *,DATE_FORMAT(date,'%d.%m.%Y') as dateq FROM $vactable WHERE status='ok' $lsradres $lsrprofecy $lsrage $lsredu $lsrzp $lsrzanatost $lsrgrafic $lsrgender $lsrcomment $srper $qwerycountry $qweryregion $qwerycity $qwerypodrazdel $qweryrazdel $qwery1 $qwerymetro order by top DESC,$qweryord LIMIT $initialMsg, $maxThread");
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
$date=$myrow["dateq"];
$wrazdel=$myrow["razdel"];
$wpodrazdel=$myrow["podrazdel"];
$bold=$myrow["bold"];

$resultaut = @mysql_query("SELECT * FROM $autortable WHERE ID='$aid'");
while ($myrow1=mysql_fetch_array($resultaut)) {
$afirm=$myrow1["firm"];
}

$country=$myrow["country"];
$region=$myrow["region"];
$city=$myrow["city"];
$metro=$myrow["metro"];

$citytar=$city;
if ($city=='0') {$citytar=$region;}
if ($region=='0' and $city=='0') {$citytar=$country;}
$resultadd3c = @mysql_query("SELECT * FROM $citytable WHERE ID='$citytar'");
while($myrowc=mysql_fetch_array($resultadd3c)) {
$citys=$myrowc["categ"];
if ($city=='0') {$citys=$myrowc["podrazdel"];}
if ($city=='0' and $region=='0') {$citys=$myrowc["razdel"];}
}

$boldstl='';
if ($bold != '0000-00-00 00:00:00') {$boldstl="style=\"font-weight: bold;\"";}

$resultadd2 = @mysql_query("SELECT ID,podrazdel FROM $catable WHERE ID='$wpodrazdel'");
while($myrow=mysql_fetch_array($resultadd2)) {
$podrazdel1=$myrow["podrazdel"];
}
$resultadd1 = @mysql_query("SELECT ID,razdel,podrazdel FROM $catable WHERE podrazdel = '' and ID='$wrazdel'");
while($myrow=mysql_fetch_array($resultadd1)) {
$razdel1=$myrow["razdel"];
}
$selectresult = @mysql_query("SELECT * FROM $vacordertable WHERE (user = '$REMOTE_ADDR' and unit=$ID and status='basket')");
if (@mysql_num_rows($selectresult) == 0)
{$pic='add.gif';$al='p';$sst='�������� ��������';}
if (@mysql_num_rows($selectresult) != 0)
{$pic='remove.gif';$al='d';$sst='������� ��������';}

echo ("
<table width=100% border=0 class=\"vacanc\">
  <tr>
    <td height=43 class=\"vac-title\"><a href=\"linkvac.php?link=$ID\">$profecy</a></td>
    <td class=\"zp-vac\">
");

if ($zp != 0) {echo "$zp $valute";}

echo ("
</td>
    <td>
");

if ($metro != '') {echo "�.$metro";}
if ($metro == '') {echo "$citys";}

echo ("
</td>
  </tr>
  <tr valign=top class=\"company\">
    <td height=25  class=\"company\">
<a href=\"rab.php?id=$aid\">$afirm</a>
</td>
    <td>$date</td>
    <td><a href=\"searchv.php?srrazdel=$srrazdel&srpodrazdel=$srpodrazdel&srcountry=$srcountry&srregion=$srregion&srcitys1=$srcitys1&srmetro=$srmetro&sradres=$sradres&srprofecy=$srprofecy&srage=$srage&sredu=$sredu&srzp=$srzp&srzanatost=$srzanatost&srgrafic=$srgrafic&srgender=$srgender&srcomment=$srcomment&per=$per&page=$page&maxThread=$maxThread&submit=submit&ord=$ord&$al=$ID\">$sst</a></td>
  </tr>
</table>
");


} //4

echo "<div class=\"pages\">$line</div>";

} //2
}
include("down.php");
?>