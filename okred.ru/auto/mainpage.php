<?
session_start();

$codecount = ('
<textarea rows=4 cols=40>
<a href=����.ru>��� ��������</a>
</textarea>
');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
echo "<head>";
include("var.php");
echo"<title>���������� �� ������� �������� : $sitename</title>";
include("top.php");
?>
<h3><center><strong>���������� �� ������� ��������</strong></center></h3>

<?php
$delip=mysql_query("delete from $bunsiptable where (((date + INTERVAL 86400*period SECOND) < now()) and period != '')");
$REMOTE_ADDR=$_SERVER['REMOTE_ADDR'];
$id=$_SESSION['sid'];
$slogin=$_SESSION['slogin'];
$spass=$_SESSION['spass'];
$error = "";
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
$result = @mysql_query("SELECT email,pass,category,addobyavl,statconf FROM $autortable WHERE email = '$slogin' and pass = '$spass' and statconf = 'ok'");
if ((!isset($slogin) or !isset($spass)) or @mysql_num_rows($result) == 0)
{
echo "<center><br><br><h3>�� �� �������������� ���� ��� ��������� ��������� �������!</h3><b><a href=autor.php>�����������</a></b>";
}
else
{//1
while($myrow=mysql_fetch_array($result)) {
$who=$myrow["category"];
}
$resultban = @mysql_query("SELECT * FROM $bunsiptable WHERE bunsip = '$REMOTE_ADDR'");
if (@mysql_num_rows($resultban) != 0) {
while($myrow=mysql_fetch_array($resultban)) {
$ID=$myrow["ID"];
$bunsip=$myrow["bunsip"];
$bunwhy=$myrow["why"];
}
echo "<p align=center><font color=red>������ � �������� ���������� ������� ��� ���, � ���������, ������!</font></p><blockquote><p align=justify><b>�������:</b> $bunwhy</p><br><br>";
}
elseif (@mysql_num_rows($resultban) == 0) 
{ //bunip
$resultraz = @mysql_query("SELECT email,pass,category FROM $autortable WHERE email = '$slogin' and pass = '$spass' and category = 'agency'");
if (@mysql_num_rows($resultraz) == 0)
{
echo "<center><br><br><h3>������� ����� ��������� ������ ���������!</h3><b><a href=registr.php>�����������</a></b>";
}
elseif (mysql_num_rows($resultraz) != 0) 
{ // ��������1
if ($_SERVER[QUERY_STRING] == "add") {

$url=$_POST['url'];

$result3 = @mysql_query("SELECT * FROM $mainpagetable WHERE url='$url' aid=$id");
if (@mysql_num_rows($result3) != 0) {$error .= "����� ������ ���� ��� ���������!<br>";}
if ($url == "") {$error .= "������� ����� ��������, ��� ����� �������� ��� ��� ������!<br>";}
if ($url != "" and !ereg("http://",$url)) {$error .= "����� ��������� ������ ���������� � http://! <br>";}

echo "<center><font color=red>$error</font></center>";
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

if ($_SERVER[QUERY_STRING] == "add" and $error == "") {
$sql="insert into $mainpagetable (url,aid,date,status) values ('$url','$id',now(),'wait')";
$result=@mysql_query($sql,$db);

}
}
if ($_SERVER[QUERY_STRING] != "add" or $error != "") {
?>

<p align=center>��������� ������������� �������� ��������! �� ���������� ��� ���������� ���������� �� ������� �������� ����� ��������.RU ������ �� �������� c ����������� � ����� �������� ��������� � ������ ���������� � ������, ������������ � ����� ���� ������. ����� ���������� � ��������� ������ ��������� ����� �������������� ����������� �������, ������� ������� ��������� �������� ������ ��������� ��� ������� ���������.  ������������ ������� ����������� ���������� ������ �� ���������� � ����� ��������� � � ����� �������� ��������� �� ������� �������� ������ ����� �������� ���������� ����� ������ ��� ������ �� ����� �� ������� ����� ������ ��������� ���������: �� ������� ���  �� �������� � ������������ ��������</p><br><br>

<?
echo ("
<form name=form method=post action=mainpage.php?add ENCTYPE=multipart/form-data>
<table border=0 width=740>
<tr><td>��� ������ - ������ ����� \"��������.RU\" ��� ���������� �� ����� ������ ��������</td></tr>
<tr><td><i>$codecount</i></td></tr>
<tr><td>������� URL ��������, ��� ����� ��������� ������ - ������ �� ��� ����:</td></tr>
<tr><td><input type=text name=url size=30 value=\"$url\"></td></tr>
</table>
");
echo "<center><p><input type=submit value=\"��������\" name=\"submit\" class=i3></form>";
}
else {
echo "<br><h3 align=center>������ ���������!</h3><center><br>���������� ��������� ��� �� �������� $url ������ �����:<br><br><i><b>$codecount</b></i><br><br>����� ������ �� ��� ����� ��������� �� ������ ��������� �� ������� �������� ������ �����<br><br><p align=center><a href=autor.php>��������� � ��������� ������</a></p><br><br>";
}
} // ��������1
} //bunip
}//1
include("down.php");
?>