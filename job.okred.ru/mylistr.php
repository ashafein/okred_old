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

<head>
<?php
include("var.php");
echo"<title>����������� ������ : $sitename</title>";
include("top.php");
?>
<h3><center><strong>����������� ������</strong></center></h3>
<?php
$sid=$_SESSION['sid'];
$id=$_SESSION['sid'];
$slogin=$_SESSION['slogin'];
$spass=$_SESSION['spass'];

$updres=mysql_query("update $restable set top='0000-00-00 00:00:00' where ((top + INTERVAL 86400*$periodfortop SECOND) < now())");
$updres=mysql_query("update $restable set bold='0000-00-00 00:00:00' where ((bold + INTERVAL 86400*$periodforbold SECOND) < now())");

$result = @mysql_query("SELECT email,pass FROM $autortable WHERE (email = '$slogin' and pass = '$spass')");
if ((!isset($slogin) or !isset($spass)) or @mysql_num_rows($result) == 0)
{
echo "<center><br><br><h3>�� �� ��������������!</h3><b><a href=autor.php>�����������</a></b>";
}
else
{ //1
if ($_SERVER[QUERY_STRING] != "delete")
{ //3
$result = @mysql_query("SELECT *,CURRENT_DATE,(YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) AS age,DATE_FORMAT(date,'%d.%m.%Y') as date,DATE_FORMAT((top + INTERVAL 86400*$periodfortop SECOND),'%d.%m.%Y') as topq,DATE_FORMAT((bold + INTERVAL 86400*$periodforbold SECOND),'%d.%m.%Y') as boldq FROM $restable WHERE aid = '$id' order by ID DESC");
$totaltexts=@mysql_num_rows($result);
if ($totaltexts == 0) {
echo "<p align=center class=tbl1>�� �� ���������� �� ������ ����������!<br><br><a href=addres.php>���������� ������</a></p>";
}
else
{ //2

$resultaut = @mysql_query("SELECT ID,category,email,pass,status,pay FROM $autortable WHERE ID=$sid");
while ($myrow1=mysql_fetch_array($resultaut)) {
$pay=$myrow1["pay"];
}
if ($paytrue == 'TRUE')
{ // �������� ������� ������
echo ("
<center>
��� ID: <b>$sid</b><br><big>�� ����� �����: <b>
");
printf("%.2f",$pay);
echo ("
 USD</b></big><br><br>
");
} // �������� ������� ������

$delline = '<br><input type=submit name=delob value="������� ����������" class=i3>';
echo "<p align=center class=tbl1>����� ����� ������: <b>$totaltexts</b></p>";
echo ("
<div align=center><form name=deltext method=post action=mylistr.php?delete>
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$maincolor><td><img src=\"picture/basket.gif\" border=0></td><td>���������</td><td>��������</td><td>���� ����.</td><td>�����</td></tr>
");
while ($myrow=mysql_fetch_array($result)) 
{ //4
$tID=$myrow["ID"];
$profecy=$myrow["profecy"];
$zp=$myrow["zp"];
$grafic=$myrow["grafic"];
$zanatost=$myrow["zanatost"];
$aid=$myrow["aid"];

if ($paytrue == 'TRUE')
{ // �������� ������� ������
$top=$myrow["top"];
$bold=$myrow["bold"];
$topq=$myrow["topq"];
$topql="<br><font color=green>��������� �������� ������ $paytopresume $valute.</font>";
if ($top != '0000-00-00 00:00:00') {$topql="<br><b>������ �� $topq</b>";}
$boldq=$myrow["boldq"];
$boldql="<br><font color=blue>��������� ��������� ������ $payboldresume $valute.</font>";
if ($bold != '0000-00-00 00:00:00') {$boldql="<br><b>�������� �� $boldq</b>";}
} // �������� ������� ������

$resultaut = @mysql_query("SELECT *,CURRENT_DATE,(YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) AS age FROM $autortable WHERE ID='$aid'");
while ($myrow1=mysql_fetch_array($resultaut)) {
$prof=$myrow1["prof"];
$gender=$myrow1["gender"];
$age=$myrow1["age"];
$category=$myrow1["category"];
}
if ($category == 'agency')
{
$age=$myrow["age"];
$gender=$myrow["gender"];
$prof=$myrow["prof"];
}
$date=$myrow["date"];
$razdel=$myrow["razdel"];
$podrazdel=$myrow["podrazdel"];
$status=$myrow["status"];
$archivedate=$myrow["archivedate"];
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
if ($status=='archive') {$statusline="<font color=blue>� ������ (� $archivedate)</font>";}
echo ("
<tr bgcolor=$maincolor>
<td valign=top width=20><input type=checkbox name=delmes[] value=$tID></td>
<td valign=top><a href=lres.php?link=$tID target=_blank><b>$profecy</b></a><br>$razdel1&nbsp;/&nbsp;$podrazdel1<br>
");
$br=0;
if ($gender == '�������') {$br=1; echo "�������&nbsp;";}
if ($gender == '�������') {$br=1; echo "�������&nbsp;";}
if ($age != 0) {$br=1; echo "$age ���(����);&nbsp";}
if ($grafic != '' and !eregi("�����",$grafic)) {if ($br==1) {echo "<br>";} $br=1; echo "$grafic";}
if ($prof != '') {if ($br==1) {echo "<br>";} echo "����.������: $prof";}
echo ("
</td>
<td valign=top>
");
if ($zp != 0) {echo "<b>$zp</b> $valute";}
elseif ($zp == 0) {echo "";}
echo ("
</td>
<td valign=top>$date<br><a href=lres.php?link=$tID target=_blank><small>���������...</small></a></td>
<td valign=top>$statusline<br>
<a href=changer.php?texid=$tID>������</a>
");
if ($category == 'agency') {echo "<br><a href=chanfoto.php?texid=$tID>����������</a>";}
echo ("
$topql$boldql
</td>
</tr>
");
} //4
echo "</table></td></tr></table>";
echo ("
$delline <input type=submit name=long value=\"�������� ���������� (������ �� ������)\" class=i3><br><br>
");

if ($paytrue == 'TRUE')
{ // �������� ������� ������
echo ("
<input type=submit value='������� ������' name=top class=i3>&nbsp;<input type=submit value='�������� ������' name=bold class=i3>
");
} // �������� ������� ������

echo ("
</form></div><p align=center class=tbl1><a href=autor.php>��������� � ��������� ������</a></p><p>
");
} //2
} //3
if ($_SERVER[QUERY_STRING] == "delete") {
$delmes=$_POST['delmes'];
$totob=count($delmes);
if (count($delmes)==0) {
	$error .= "�� ������� �� ������ ����������!<br>";}

// �������� ������� �� �����
if (isset($_POST['top'])) {
$totpricetop=$totob*$paytopresume;
$result = @mysql_query("SELECT ID,pay FROM $autortable WHERE ID=$sid");
while ($myrow=mysql_fetch_array($result)) {
$pay=$myrow["pay"];
}
if ($pay < $totpricetop)	{$error .= "�� ����� ����� ������������ ������� ��� �������� ��������� ������!<br>� ��� - $pay $valute. ��������� ��� �������� $totob ������ - $totpricetop $valute.<br>";}
}
// �������� ������� �� �����

// �������� ������� �� �����
if (isset($_POST['bold'])) {
$totpricebold=$totob*$payboldresume;
$result = @mysql_query("SELECT ID,pay FROM $autortable WHERE ID=$sid");
while ($myrow=mysql_fetch_array($result)) {
$pay=$myrow["pay"];
}
if ($pay < $totpricebold)	{$error .= "�� ����� ����� ������������ ������� ��� ��������� ��������� ������!<br>� ��� - $pay $valute. ��������� ��� ��������� $totob ������ - $totpricebold $valute.<br>";}
}
// �������� ������� �� �����

if ($error != ""){
echo "<center><h3>������</h3><font color=red>$error</font><p><a href=autor.php>��������� �����</a><p><br><br><br><br><br><br><br><br>";
}
if ($error == ""){
if (isset($_POST['delob']))
{ // del
for ($i=0;$i<count($delmes);$i++){
$res2 = @mysql_query("SELECT * FROM $restable WHERE ID=$delmes[$i]");
while($myrow=mysql_fetch_array($res2)) {
$foto1=$myrow["foto1"];
}
@unlink($upath.$photodir.$foto1);
@unlink($upath.$photodir.'s'.$foto1);
$result=@mysql_query("delete from $restable where ID=$delmes[$i]");
}
echo "<p align=center class=tbl1><h3>��������� ������ �������!</h3><a href=autor.php>��������� � ��������� ������</a></p><br><br>";
} // del
if (isset($_POST['long']))
{ // long
for ($i=0;$i<count($delmes);$i++){
$result=@mysql_query("update $restable set date=now(),archivedate='0000-00-00 00:00:00',status='wait' where ID=$delmes[$i] and status='archive'");
$result=@mysql_query("update $restable set date=now() where ID=$delmes[$i] and status != 'archive'");
}
echo "<p align=center class=tbl1><h3>��������� ������ ��������!</h3><a href=autor.php>��������� � ��������� ������</a></p><br><br>";
} // long

if (isset($_POST['top'])) 
{ //top
$result=@mysql_query("update $autortable set pay=pay-$totpricetop where ID=$sid");
for ($i=0;$i<count($delmes);$i++){
$result=@mysql_query("update $restable SET top=now() WHERE ID=$delmes[$i]");
}
echo "<br><br><h3 align=center>��������� ������ �������!</h3><br><br><a href=autor.php>��������� � ������ ������</a><br><br>";
} // top

if (isset($_POST['bold'])) 
{ //bold
$result=@mysql_query("update $autortable set pay=pay-$totpricebold where ID=$sid");
for ($i=0;$i<count($delmes);$i++){
$result=@mysql_query("update $restable SET bold=now() WHERE ID=$delmes[$i]");
}
echo "<br><br><h3 align=center>��������� ������ ��������!</h3><br><br><a href=autor.php>��������� � ������ ������</a><br><br>";
} // bold

}
}
echo ("
<center><form method=post action=\"logout.php\">
<input type=submit name=logout value=����� class=i3><br><br>
</form>
");
}//1
include("down.php");
?>