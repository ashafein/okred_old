<?
session_start();
session_name()
?>
<head>
<?php
include("var.php");
$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);
echo "<title>�������� ������ : $sitename</title>";
include("top.php");
$maxname = 50;
$maxmail = 50;
$maxbody = 1000;
$err2 = "E-mail ������ ���� �� ������ $maxmail ��������<br>";
$err3 = "��������� ������ ���� �� ������ $maxbody ��������<br>";
$err8 = "�� ��������� ������������ ���� - E-mail!<br>";
$err5 = "�� ��������� ������������ ���� - ���������!<br>";
$err6 = "����� ��� �������� �� ���������!<br>";
$err7 = "���������� ��������� ������������ E-mail ������<br>";
$error = "";
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
if ($_GET['emailto'] == '') {$emailto=$_POST['emailto'];}
elseif ($_GET['emailto'] != '') {$emailto=$_GET['emailto'];}
if ($_GET['sendid'] == '') {$sendid=$_POST['sendid'];}
elseif ($_GET['sendid'] != '') {$sendid=$_GET['sendid'];}
if ($_SERVER[QUERY_STRING] == "send" and $emailto == '') {
$result = @mysql_query("SELECT ID,email FROM $autortable WHERE ID = $sendid");
while ($myrow=mysql_fetch_array($result)) 
{
$emailto=$myrow["email"];
}
}
$emailfrom=$_POST['emailfrom'];
$body=$_POST['body'];

if (strlen($emailfrom) > $maxmail) {$error .= "$err2";}
if (strlen($body) > $maxbody) {$error .= "$err3";}
if ($_SERVER[QUERY_STRING] == "send" and $body == "") {
	$error .= "$err5";}
if ($_SERVER[QUERY_STRING] == "send" and $emailto == "") {
	$error .= "$err6";}
if ($_SERVER[QUERY_STRING] == "send" and $emailfrom == "") {
	$error .= "$err8";}
if ($emailfrom != "" and !strpos($emailfrom,"@")) {$error .= "$err7";}
echo "<center><font color=red>$error</font></center>";
if ($_SERVER[QUERY_STRING] != "send" or $error != "") {
echo ("
<form name=sendemail method=post action=send.php?send>
<input type=hidden name=emailto value=\"$emailto\">
<input type=hidden name=sendid value=$sendid>
<center><table border=0 class=text>
<tr><td align=center colspan=2><b>�������� ������:</b></td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
<tr><td align=right valign=top><b>���������:</b></td>
<td align=left><textarea name=body cols=40 rows=8>������������!\n</textarea></td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
<tr><td align=right valign=top><b>��� email:</b></td>
<td align=left><input type=text name=emailfrom size=30></td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
<tr><td colspan=2 align=center><input type=submit value=��������� class=i3></td></tr>
<tr><td colspan=2>&nbsp;</td></tr>
</table></form>
");
}
if ($_SERVER[QUERY_STRING] == "send" and $error == "") {
if ($emailto == '') {
$result = @mysql_query("SELECT ID,email FROM $autortable WHERE ID = $sendid");
while ($myrow=mysql_fetch_array($result)) 
{
$emailto=$myrow["email"];
}
}
$body=htmlspecialchars($body);
if ($emailfrom != "") {
$bodystring="����� �������� �� ��� ������ ������� �� ������:\n$siteadress/send.php?emailto=$emailfrom\n��� ���������� �� � ���� ��������\n";}
if ($emailfrom == "") {
$bodystring="\n";}
$txt="$body\n\n-----------------\n$bodystring\n-----------------\n������ ������ ���� ���������� � ����� $siteadress ($sitename), �� ������� �� ����������������.\n� ���������,\n$siteadress\n$adminemail";
@mail($emailto,"������ � ����� $sitename",$txt,"Return-Path:$emailfrom\nMime-Version: 1.0\nContent-Type: text/plain; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");
echo "<br><br><h3 align=center>��������� ����������!<br><br>������� �� ����������� ����� ������!</h3><br><br>";
}
echo "<center><br><br><a href=index.php>��������� �� ����</a>";
include("down.php");
?>

