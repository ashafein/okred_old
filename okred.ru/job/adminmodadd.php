<?
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<META NAME=ROBOTS CONTENT="NOINDEX, NOFOLLOW">
<?php
include("var.php");
echo"<title>���������� ���������� : $sitename</title>";
include("top.php");
echo "<div class=tbl1>";
?>
<h3><center><strong>���������� ����������</strong></center></h3>
<?php
$error = "";
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
$result = @mysql_query("SELECT pass,main FROM $admintable where main='main'");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
if (!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass)
{
echo "<center><b>�� �� <a href=admin.php>��������������</a>!</b><br><br>";
}
else
{ // ok
if ($_SERVER[QUERY_STRING] == "add") {
$login=$_POST['login'];
$pass=$_POST['pass'];
$comment=$_POST['comment'];
$vacconfirm=$_POST['vacconfirm'];
$vacdel=$_POST['vacdel'];
$resconfirm=$_POST['resconfirm'];
$resdel=$_POST['resdel'];
$userdel=$_POST['userdel'];
$userconfirm=$_POST['userconfirm'];
$moderadd=$_POST['moderadd'];
$catalogadd=$_POST['catalogadd'];
$mess=$_POST['mess'];
$textadd=$_POST['textadd'];
$textdel=$_POST['textdel'];
$textcomment=$_POST['textcomment'];
$faq=$_POST['faq'];
$news=$_POST['news'];
$promoadd=$_POST['promoadd'];
$promodel=$_POST['promodel'];
$promoconfirm=$_POST['promoconfirm'];

if ($pass == "") {$error .= "��������� ������ ����������!<br>";}

echo "<center><font color=red>$error</font></center>";
function untag ($string) {
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
$sql="insert into $admintable (pass,vacconfirm,vacdel,resconfirm,resdel,userdel,userconfirm,moderadd,catalogadd,mess,textadd,textdel,textcomment,faq,news,promoadd,promodel,promoconfirm) values ('$pass','$vacconfirm','$vacdel','$resconfirm','$resdel','$userdel','$userconfirm','$moderadd','$catalogadd','$mess','$textadd','$textdel','$textcomment','$faq','$news','$promoadd','$promodel','$promoconfirm')";
$result=@mysql_query($sql,$db);
}
}
if ($_SERVER[QUERY_STRING] != "add" or $error != "") {
echo ("
<form name=formata method=post ENCTYPE=multipart/form-data action=adminmodadd.php?add>
<table width=90% bgcolor=$maincolor class=tbl1>
<tr><td align=right><strong>������:</strong></td>
<td><input type=text name=pass size=50 value=\"$pass\"></td></tr>
<tr><td align=right valign=top><b>�����:</b></td><td valign=top>
<input type=checkbox name=vacconfirm value=checked $vacconfirm>��������� ��������<br>
<input type=checkbox name=resconfirm value=checked $resconfirm>��������� ������<br>
<input type=checkbox name=vacdel value=checked $vacdel>�������� ��������<br>
<input type=checkbox name=resdel value=checked $resdel>�������� ������<br>
<input type=checkbox name=userdel value=checked $userdel>�������� �������������<br>
<input type=checkbox name=userconfirm value=checked $userconfirm>��������� �������������<br>
<input type=checkbox name=catalogadd value=checked $catalogadd>���������/���������� �� �������� �������� � �������������<br>
<input type=checkbox name=moderadd value=checked $moderadd>���������� ����������<br>
<input type=checkbox name=mess value=checked $mess>��������� �������������<br>
<input type=checkbox name=textadd value=checked $textadd>�������� ������<br>
<input type=checkbox name=textdel value=checked $textdel>������� ������<br>
<input type=checkbox name=textcomment value=checked $textcomment>������� ����������� � �������<br>
<input type=checkbox name=faq value=checked $faq>FAQ<br>
<input type=checkbox name=news value=checked $news>�������<br>
<input type=checkbox name=promoadd value=checked $promoadd>�������� ��������� ����<br>
<input type=checkbox name=promodel value=checked $promodel>�������� ��������� ������<br>
<input type=checkbox name=promoconfirm value=checked $promoconfirm>�������� ��������� ����� �������������<br>
</td></tr>
<tr bgcolor=$altcolor><td colspan=2>&nbsp;</td></tr>
<tr bgcolor=$altcolor><td colspan=2 align=center>
<input type=submit value=\"��������\" name=\"submit\"></td></tr></table></form>
");
}
else {
echo "<br><br><h3 align=center>��������� ��������!</h3><br><br><center><a href=adminmodadd.php>�������� ��� ����������</a><br><br>";
}
}// ok
echo "<center><a href=admin.php>�� ����� �������� �����������������</a><br><br>";
echo "</div>";
include("down.php");
?>