<?
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!--/***************** DO NOT REMOVE! *********************/---->
<!--/*   Author: Nevezhyn Evgeny  Date : 29/01/2007       */---->
<!--/*   nevius@bk.ru      All Rights Reserved ...        */---->
<!--/*   http://nevius.ru/                                */---->
<!--/***************** DO NOT MODIFY! *********************/---->

<head>
<?php
include("var.php");
echo"<title>�������������� �����-��������-������� : $sitename</title>";
include("top.php");
?>
<h3><center><strong>�������������� �����-��������-�������</strong></center></h3>
<?php
$result = @mysql_query("SELECT pass FROM $admintable");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
$maxsize = 100;
$err2="�� ������� �� ���� ������!<br>";
$err3="�������� �� ������!<br>";
$err4="�� ������� ������, � ������� ��������� �������!<br>";
$err5="�� ���� ������ �� ������!<br>";
$err7="�� ���� ����� �� ������!<br>";
$error = "";
if (!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass)
{
echo "<center><b>�� �� <a href=admin.php>��������������</a>!</b><br><br>";
}
else
{ // ok
if ($_SERVER[QUERY_STRING] != "del"){
echo "<form name=delreg method=post action=admincity.php?del>";
$result = @mysql_query("SELECT razdel FROM $citytable");
$totalThread = @mysql_num_rows($result);
$result = @mysql_query("SELECT * FROM $citytable WHERE podrazdel='' and categ='' order by razdel");
$totalThread1 = @mysql_num_rows($result);
while($myrow=mysql_fetch_array($result)) {
$ID=$myrow["ID"];
$razdel=$myrow["razdel"];
echo "<input type=checkbox name=delmes[] value=$ID>$razdel&nbsp;<a href=admincityc.php?id=$ID&c=r><small>(��������)</small></a><br>";
$result1 = @mysql_query("SELECT * FROM $citytable WHERE razdel='$razdel' and podrazdel != '' and categ='' order by podrazdel");
if (@mysql_num_rows($result1) != 0)
{ // ���� ������
while($myrow=mysql_fetch_array($result1)) {
$ID=$myrow["ID"];
$podrazdel=$myrow["podrazdel"];
$osn1=$myrow["osn"];
if ($osn1 == 'checked') {echo "&nbsp;&nbsp;&nbsp;&nbsp;<input type=checkbox name=delmes[] value=$ID><b>$podrazdel</b>&nbsp;<a href=admincityc.php?id=$ID&c=p><small>(��������)</small></a><br>";}
if ($osn1 != 'checked') {echo "&nbsp;&nbsp;&nbsp;&nbsp;<input type=checkbox name=delmes[] value=$ID>$podrazdel&nbsp;<a href=admincityc.php?id=$ID&c=p><small>(��������)</small></a><br>";}
$result4 = @mysql_query("SELECT * FROM $citytable WHERE razdel='$razdel' and podrazdel = '$podrazdel' and categ != '' order by categ");
while($myrow=mysql_fetch_array($result4)) {
$ID=$myrow["ID"];
$categ=$myrow["categ"];
$osn2=$myrow["osn"];
if ($osn2 == 'checked') {echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=checkbox name=delmes[] value=$ID><b>$categ</b>&nbsp;<a href=admincityc.php?id=$ID&c=c><small>(��������)</small></a><br>";}
if ($osn2 != 'checked') {echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=checkbox name=delmes[] value=$ID>$categ&nbsp;<a href=admincityc.php?id=$ID&c=c><small>(��������)</small></a><br>";}
}
}
} // ���� ������
elseif (@mysql_num_rows($result1) == 0)
{ // ��� �������
$result4 = @mysql_query("SELECT * FROM $citytable WHERE razdel='$razdel' and categ != '' order by categ");
while($myrow=mysql_fetch_array($result4)) {
$ID=$myrow["ID"];
$categ=$myrow["categ"];
$osn2=$myrow["osn"];
if ($osn2 == 'checked') {echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=checkbox name=delmes[] value=$ID><b>$categ</b>&nbsp;<a href=admincityc.php?id=$ID&c=c><small>(��������)</small></a><br>";}
if ($osn2 != 'checked') {echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=checkbox name=delmes[] value=$ID>$categ&nbsp;<a href=admincityc.php?id=$ID&c=c><small>(��������)</small></a><br>";}
}
} // ��� �������
}
if ($totalThread != 0)
{echo "<br><center><br><input type=submit value='������� ����������' name=delete><br><br>";}

echo ("
<hr width=90% size=1><p align=left>�������� �� ���� �������� ������ � ������, � ����� ���� ���������� �������. ���� ������ �� ����� ������� �� �������, �� �� ���������� ���� ������� � ����� ������� ������ ��� ��������� ������. ���� ������ ����� �������, �� � �� �� ����� ����� ������, ������� ���� �������� ���������� ��������� ��� ��������� (��������, ������, �����-���������), �� �� ������� ��� ������, �� �������� ���� �����.
<br><br>��� ���� ����� �������� �����-�� ����� ��� ������ � �������� �������� (����� ������������ � ������ � ����� �����) ����� ��������� ������ � ����� ���� ��������� ���� = (�����).<br>������:<br><i>=������=<br>�����<br>=�����-���������=</i>
</p>
");

echo "<hr width=90% size=1><b>�������� ������</b><br><br>������� �������� ����� ������. ������ ����� �������� � ����� ������:<br><textarea rows=4 name=newrazdel cols=20></textarea><br><br><center><input type=submit value='��������' name=addrazdel><br><br>";
if ($totalThread1 != 0)
{

$srrazdel=$_GET['srrazdel'];

echo ("
<hr width=90% size=1><b>�������� ������</b><br><br>������� �������� ��������. ������ ����� �������� � ����� ������:<br>
<table class=tbl1 border=0><tr><td valign=top>
<select name=selrazdel size=1>
<option selected value=>---�������� ������---</option>
");
$result2 = @mysql_query("SELECT * FROM $citytable WHERE podrazdel = '' and categ = '' order by razdel");
while($myrow=mysql_fetch_array($result2)) {
$m=$myrow["razdel"];
echo "<option value=\"$m\">$m</option>";
}
echo ("
</select></td>
<td align=left valign=top><textarea rows=10 name=newpodrazdel cols=50></textarea></td></tr>
</table>
<br><center><input type=submit value='��������' name=addto><br><br>
");

$srrazdel1show='';
if ($srrazdel != '')
{
$result2s = @mysql_query("SELECT * FROM $citytable WHERE ID='$srrazdel'");
while($myrow=mysql_fetch_array($result2s)) {
$srrazdel1show=$myrow["razdel"];
}
}

echo ("
<hr width=90% size=1><b>�������� ������</b><br><br>������� �������� �������. ������ ����� �������� � ����� ������:<br>
<table class=tbl1 border=0><tr><td valign=top>
������:<br><select name=selrazdel3 size=1 onChange=location.href=location.pathname+\"?srrazdel=\"+value+\"\";>
<option value=\"$srrazdel\">$srrazdel1show</option>
");
$result2 = @mysql_query("SELECT * FROM $citytable WHERE podrazdel = '' and categ = '' order by podrazdel");
while($myrow=mysql_fetch_array($result2)) {
$m2=$myrow["razdel"];
$m2ID=$myrow["ID"];
echo "<option value=\"$m2ID\">$m2</option>";
}
echo ("
</select><br>
");
if ($srrazdel != '')
{
$result2s = @mysql_query("SELECT * FROM $citytable WHERE ID='$srrazdel'");
while($myrow=mysql_fetch_array($result2s)) {
$srrazdel1show=$myrow["razdel"];
}
$result3 = @mysql_query("SELECT * FROM $citytable WHERE podrazdel != '' and razdel = '$srrazdel1show' and categ='' order by podrazdel");
if (@mysql_num_rows($result3) != 0) {
echo ("
<br>������:<br>
<select name=podrazdel3 size=1>
<option selected value=\"$podrazdel3\">$podrazdel3</option>
");
while($myrow=mysql_fetch_array($result3)) {
$podrazdel3=$myrow["podrazdel"];
echo "<option value=\"$podrazdel3\">$podrazdel3</option>";
}
echo ("
</select>
");
}
}
echo ("
</td>
<td align=left valign=top><textarea rows=10 name=newcateg cols=50></textarea></td></tr>
</table>
<br><center><input type=submit value='��������' name=addtocateg><br><br>
");
}
echo ("
</form>
");
}
if ($_SERVER[QUERY_STRING] == "del"){
$newrazdel=$_POST['newrazdel'];
$newpodrazdel=$_POST['newpodrazdel'];
$newcateg=$_POST['newcateg'];
$selrazdel=$_POST['selrazdel'];
$selrazdel3=$_POST['selrazdel3'];
$podrazdel3=$_POST['podrazdel3'];
$delmes=$_POST['delmes'];

if (strlen($newrazdel) > $maxsize) {$error .= "$err1";}
if (strlen($newpodrazdel) > $maxsize) {$error .= "$err1";}
if (isset($_POST['delete']) and count($delmes)==0) {
	$error .= "$err2";}
if (isset($_POST['addrazdel']) and $newrazdel=='') {
	$error .= "$err3";}
if (isset($_POST['addto']) and $selrazdel=='') {
	$error .= "$err4";}
if (isset($_POST['addto']) and $newpodrazdel=='') {
	$error .= "$err5";}
if (isset($_POST['addtocateg']) and $newcateg=='') {
	$error .= "$err7";}
if ($error != ""){
echo "<center><h3>������</h3><font color=red>$error</font><p><a href=# onClick=history.go(-1)>��������� �����</a><p><br><br><br><br><br><br><br><br>";
}
if ($error==""){
if (isset($_POST['delete']))
{
unset($result);
for ($i=0;$i<count($delmes);$i++){
$result = @mysql_query("SELECT * FROM $citytable WHERE ID=$delmes[$i]");
while($myrow=mysql_fetch_array($result)) {
$razdel=$myrow["razdel"];
$podrazdel=$myrow["podrazdel"];
$categ=$myrow["categ"];
}
if ($podrazdel=='')
{
$result=@mysql_query("delete from $citytable WHERE razdel='$razdel'");
$res1 = @mysql_query("SELECT ID,foto1,foto2,aid FROM $textable WHERE razdel=$delmes[$i]");
while ($myrow=@mysql_fetch_array($res1)) 
{
$foto1=$myrow["foto1"];
$foto2=$myrow["foto2"];
@unlink($upath.$photodir.$foto1);
@unlink($upath.$photodir.$foto2);
}
$result=@mysql_query("delete from $textable WHERE razdel=$delmes[$i]");
$result=@mysql_query("delete from $citytable WHERE razdel=$razdel");
}
if ($podrazdel!='')
{
$res1 = @mysql_query("SELECT ID,foto1,foto2,aid FROM $textable WHERE podrazdel=$delmes[$i]");
while ($myrow=@mysql_fetch_array($res1)) 
{
$foto1=$myrow["foto1"];
$foto2=$myrow["foto2"];
@unlink($upath.$photodir.$foto1);
@unlink($upath.$photodir.$foto2);
}
$result=@mysql_query("delete from $textable WHERE podrazdel=$delmes[$i]");
$result=@mysql_query("delete from $citytable WHERE podrazdel=$podrazdel");
}
$result=@mysql_query("delete from $citytable WHERE ID=$delmes[$i]");
}
echo "<center><b>��������� �������� �������!</b><br><a href=admincity.php>���������</a><p><br><br><br><br>";
}
if (isset($_POST['addrazdel']))
{
$newrazdel = split ("\n",$newrazdel);
for ($i=0; $i<count($newrazdel); $i++)
{
$newrazdel[$i] = ereg_replace("=","",$newrazdel[$i]);
$sql="insert into $citytable (razdel,podrazdel) values ('$newrazdel[$i]','')";
$result=@mysql_query($sql,$db);
}
echo "<center><b>������ ���������!</b><br><a href=admincity.php>���������</a><p><br><br><br><br>";
}
if (isset($_POST['addto']))
{
$newpodrazdel = split ("\n",$newpodrazdel);
for ($i=0; $i<count($newpodrazdel); $i++)
{
$osn='';
if (eregi("=",$newpodrazdel[$i]))
{
$newpodrazdel[$i] = ereg_replace("=","",$newpodrazdel[$i]);
$osn='checked';
}
$sql="insert into $citytable (razdel,podrazdel,osn) values ('$selrazdel','$newpodrazdel[$i]','$osn')";
$result=@mysql_query($sql,$db);
}
echo "<center><b>������� ���������!</b><br><a href=admincity.php>���������</a><p><br><br><br><br>";
}
if (isset($_POST['addtocateg']))
{
$result2s = @mysql_query("SELECT * FROM $citytable WHERE ID='$selrazdel3'");
while($myrow=mysql_fetch_array($result2s)) {
$selrazdel3=$myrow["razdel"];
}
$newcateg = split ("\n",$newcateg);
for ($i=0; $i<count($newcateg); $i++)
{
$osn='';
if (eregi("=",$newcateg[$i]))
{
$newcateg[$i] = ereg_replace("=","",$newcateg[$i]);
$osn='checked';
}
$sql="insert into $citytable (razdel,podrazdel,categ,osn) values ('$selrazdel3','$podrazdel3','$newcateg[$i]','$osn')";
$result=@mysql_query($sql,$db);
}
echo "<center><b>������ ���������!</b><br><a href=admincity.php>���������</a><p><br><br><br><br>";
}

}
}
echo "<center><a href=admin.php>�� ����� �������� �����������������</a><br><br>";
} //ok
mysql_close($db);
include("down.php");
?>