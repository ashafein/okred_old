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
<?php
include("var.php");
echo"<title>�������������� �������� : $sitename</title>";
include("top.php");
?>
<h3><center><strong>�������������� ��������</strong></center></h3>
<?php
$result = @mysql_query("SELECT pass FROM $admintable");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
$maxsize = 100;
$err2="�� ������� �� ���� ����� ������������!<br>";
$err3="����� ������������ �� �������!<br>";
$err4="�� ������� ����� ������������, � ������� ��������� �������!<br>";
$err5="�� ���� ������ �� ������!<br>";
$error = "";
if (!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass)
{
echo "<center><b>�� �� <a href=admin.php>��������������</a>!</b><br><br>";
}
else
{ // ok
if ($_SERVER[QUERY_STRING] != "del"){
echo "<form name=delreg method=post action=adminmc.php?del>";
$result = @mysql_query("SELECT razdel FROM $catable");
$totalThread = @mysql_num_rows($result);
$result = @mysql_query("SELECT * FROM $catable WHERE podrazdel='' order by razdel");
$totalThread1 = @mysql_num_rows($result);
while($myrow=mysql_fetch_array($result)) {
$ID=$myrow["ID"];
$razdel=$myrow["razdel"];
echo "<input type=checkbox name=delmes[] value=$ID>$razdel&nbsp;<a href=admincro.php?id=$ID&c=r><small>(��������)</small></a><br>";
$result1 = @mysql_query("SELECT * FROM $catable WHERE razdel='$razdel' and podrazdel != '' order by podrazdel");
while($myrow=mysql_fetch_array($result1)) {
$ID=$myrow["ID"];
$podrazdel=$myrow["podrazdel"];
echo "&nbsp;&nbsp;&nbsp;&nbsp;<input type=checkbox name=delmes[] value=$ID>$podrazdel&nbsp;<a href=admincro.php?id=$ID&c=p><small>(��������)</small></a><br>";
}
}
if ($totalThread != 0)
{echo "<br><center><input type=submit value='������� ����������' name=delete><br><br>";}
echo "<hr width=90% size=1><b>������� ����� ������������</b><br><br>������� �������� ����� ����� ������������. ������ ����� �������� � ����� ������:<br><textarea rows=10 name=newrazdel cols=50></textarea><br><br><center><input type=submit value='�������' name=addrazdel><br><br>";
if ($totalThread1 != 0)
{
echo ("
<hr width=90% size=1><b>������� ������</b><br><br>������� �������� ��������. ������ ������ �������� � ����� ������:<br>
<table border=0><tr><td valign=top>
<select name=selrazdel size=1>
<option selected value=>---�������� ����� ������������---</option>
");
$result2 = @mysql_query("SELECT * FROM $catable WHERE podrazdel = '' order by razdel");
while($myrow=mysql_fetch_array($result2)) {
$m=$myrow["razdel"];
echo "<option value=\"$m\">$m</option>";
}
echo ("
</select></td>
<td align=left valign=top><textarea rows=10 name=newpodrazdel cols=50></textarea></td></tr>
</table>
<br><center><input type=submit value='�������' name=addto><br><br>
");
}
echo ("
</form>
");
}
if ($_SERVER[QUERY_STRING] == "del"){
$newrazdel=$_POST['newrazdel'];
$newpodrazdel=$_POST['newpodrazdel'];
$delete=$_POST['delete'];
$delmes=$_POST['delmes'];
$addrazdel=$_POST['addrazdel'];
$addto=$_POST['addto'];
$selrazdel=$_POST['selrazdel'];
if (strlen($newrazdel) > $maxsize) {$error .= "$err1";}
if (strlen($newpodrazdel) > $maxsize) {$error .= "$err1";}
if (isset($delete) and count($delmes)==0) {
	$error .= "$err2";}
if (isset($addrazdel) and $newrazdel=='') {
	$error .= "$err3";}
if (isset($addto) and $selrazdel=='') {
	$error .= "$err4";}
if (isset($addto) and $newpodrazdel=='') {
	$error .= "$err5";}
if ($error != ""){
echo "<center><h3>������</h3><font color=red>$error</font><p><a href=# onClick=history.go(-1)>��������� �����</a><p><br><br><br><br><br><br><br><br>";
}
if ($error==""){
if (isset($delete))
{
unset($result);
for ($i=0;$i<count($delmes);$i++){
$result = @mysql_query("SELECT * FROM $catable WHERE ID=$delmes[$i]");
while($myrow=mysql_fetch_array($result)) {
$razdel=$myrow["razdel"];
$podrazdel=$myrow["podrazdel"];
}
if ($podrazdel=='')
{
$result=@mysql_query("delete from $catable WHERE razdel=$razdel");
}
if ($podrazdel!='')
{
$result=@mysql_query("delete from $catable WHERE podrazdel=$podrazdel");
}
$result=@mysql_query("delete from $catable WHERE ID=$delmes[$i]");
}
echo "<center><b>��������� ��������� �������!</b><br><a href=adminmc.php>���������</a><p><br><br><br><br>";
}
if (isset($addrazdel))
{
$newrazdel = split ("\n",$newrazdel);
for ($i=0; $i<count($newrazdel); $i++)
{
$newrazdel[$i]=trim($newrazdel[$i]);
$sql="insert into $catable (razdel,podrazdel) values ('$newrazdel[$i]','')";
$result=@mysql_query($sql,$db);
}
echo "<center><b>����� ������������ �������!</b><br><a href=adminmc.php>���������</a><p><br><br><br><br>";
}
if (isset($addto))
{
$newpodrazdel = split ("\n",$newpodrazdel);
for ($i=0; $i<count($newpodrazdel); $i++)
{
$newpodrazdel[$i]=trim($newpodrazdel[$i]);
$sql="insert into $catable (razdel,podrazdel) values ('$selrazdel','$newpodrazdel[$i]')";
$result=@mysql_query($sql,$db);
}
echo "<center><b>������� �������!</b><br><a href=adminmc.php>���������</a><p><br><br><br><br>";
}
}
}
echo "<center><a href=admin.php>�� ����� �������� �����������������</a><br><br>";
} //ok
include("down.php");
?>