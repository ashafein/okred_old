<?
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!--/***************** DO NOT REMOVE! *********************/---->
<!--/*   Author: Nevezhyn Evgeny  Date : 01/06/2003       */---->
<!--/*   nevius@bk.ru      All Rights Reserved ...        */---->
<!--/*   http://nevius.ru/                                */---->
<!--/***************** DO NOT MODIFY! *********************/---->

<head>
<?php
include("var.php");
echo"<title>��������� � ������� ����������� : $sitename</title>";
include("top.php");
?>
<h3><center><strong>��������� � ������� �����������</strong></center></h3>
<?php
@$db=mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);
$sid=$_SESSION['sid'];
$slogin=$_SESSION['slogin'];
$spass=$_SESSION['spass'];
$id=$sid;
$result = @mysql_query("SELECT email,pass,category FROM $autortable WHERE (email = '$slogin' and pass = '$spass')");
if ((!isset($slogin) or !isset($spass)) or @mysql_num_rows($result) == 0)
{
echo "<center><br><br><h3>�� �� ��������������!</h3><b><a href=autor.php>�����������</a></b>";
}
else
{ //1
if ($_SERVER[QUERY_STRING] != "delete")
{ //3
$result = @mysql_query("SELECT * FROM $autortable WHERE ID=$sid");
while ($myrow=mysql_fetch_array($result)) {
$pay=$myrow["pay"];
$catalog=$myrow["catalog"];
if ($catalog == 'off') {$catalogtruesh="�� ���������";}
if ($catalog == 'on') {$catalogtruesh="���������";}
}

if ($paytrue == 'TRUE')
{ // �������� ������� ������
echo ("
<center>
��� ID: <b>$sid</b><br><big>�� ����� �����: <b>
");
printf("%.2f",$pay);
echo ("
 $valute</b></big><br><br>
");
} // �������� ������� ������

echo ("
<form name=delete_form method=post action=buycat.php?delete>
<input type=hidden name=catalogtrueold value=$catalog>
��������� ��������� � �������: <b>$paycatalog</b> $valute<br><br>
<select name=catalogtrue size=1>
<option selected value=\"$catalogtrue\">$catalogtruesh</option>
<option value=\"on\">��������</option>
<option value=\"off\">���������</option>
</select> 
<input type=submit value='���������' name=buy class=i3>
");

echo "</form><p align=center><a href=autor.php>��������� � ��������� ������</a></p><p>";
} //3
if ($_SERVER[QUERY_STRING] == "delete") {
$catalogtrue=$_POST['catalogtrue'];
$catalogtrueold=$_POST['catalogtrueold'];

// �������� ������� �� �����
if (isset($_POST['buy']) and $catalogtrue=='on' and $catalogtrueold != 'on') {
$totpricetop=$paycatalog;
$result = @mysql_query("SELECT ID,pay FROM $autortable WHERE ID=$sid");
while ($myrow=mysql_fetch_array($result)) {
$pay=$myrow["pay"];
}
if ($pay < $totpricetop)	{$error .= "�� ����� ����� ������������ ������� ��� ��������� �������!<br>� ��� - $pay $valute. ��������� ��� ��������� - $totpricetop $valute<br>";}
}
// �������� ������� �� �����

if ($catalogtrue == "") {$error .= "�������� �� �����";}
if ($catalogtrue=='on' and $catalogtrueold == 'on') {$error .= "������� ��� ��������";}

if ($error != ""){
echo "<center><h3>������</h3><font color=red>$error</font><p><a href=# onClick=history.go(-1)>��������� �����</a><p><br><br><br><br><br><br><br><br>";
}
if ($error == ""){

if (isset($_POST['buy'])) 
{ //buy
$result=@mysql_query("update $autortable set pay=pay-$totpricetop,catalog='$catalogtrue' where ID=$sid");
echo "<br><br><h3 align=center>��������� ���������!</h3><br><br><a href=autor.php>��������� � ������ ������</a><br><br>";
} //buy

}
}
}//1
include("down.php");
?>