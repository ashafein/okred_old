<?
session_start();
session_register("uid");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<?php
include("var.php");
echo"<title>�������������� ������� ����� : $sitename</title>";
include("top.php");
echo "<h3 align=center>�������������� ������� �����</h3>";
$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);
$result = @mysql_query("SELECT pass FROM $admintable");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
$maxsize = 100;
$err2="�� ������� �� ����� �������!<br>";
$err3="������� �� �������!<br>";
$error = "";
if (!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass)
{
echo "<center><b>�� �� <a href=admin.php>��������������</a>!</b><br><br>";
}
else
{ // ok
if ($_SERVER[QUERY_STRING] != "del"){
echo "<form name=delreg method=post action=adminmet.php?del><p align=left>";

$region=$_GET['region'];
$country=$_GET['country'];
$city=$_GET['city'];
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

echo ("
<table>
<tr><td valign=top align=right>������:</td>
<td valign=top align=left>
<select name=country size=1 onChange=location.href=location.pathname+\"?country=\"+value+\"\";>
");
if ($countrys == '')
{
echo ("
<option selected value=></option>
");
}
if ($countrys != '')
{
echo ("
<option selected value=\"$country\">$countrys</option>
<option value=>�� �����</option>
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
if ($country != '')
{ // ������
$result1 = @mysql_query("SELECT * FROM $citytable WHERE razdel='$countrys' and podrazdel != '' and categ='' order by podrazdel");
if (@mysql_num_rows($result1) != 0)
{ // ���� ������
echo ("
<tr><td valign=top align=right>������:</td>
<td valign=top align=left><select name=region size=1 onChange=location.href=location.pathname+\"?category=$category&country=$country&region=\"+value+\"\";>
");
if ($regions == '')
{
echo ("
<option selected value=>�� �����</option>
");
}
if ($regions != '')
{
echo ("
<option selected value=\"$region\">$regions</option>
<option value=>�� �����</option>
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
if ($region != '')
{ // ������
$result4 = @mysql_query("SELECT * FROM $citytable WHERE podrazdel = '$regions' and razdel='$countrys' and categ != '' order by categ");
if (@mysql_num_rows($result4) != 0) {
echo ("
<tr><td valign=top align=right>�����:</td>
<td valign=top align=left><select name=city size=1 onChange=location.href=location.pathname+\"?country=$country&region=$region&city=\"+value+\"\";>
");
if ($citys == '')
{
echo ("
<option selected value=>�� �����</option>
");
}
if ($citys != '')
{
echo ("
<option selected value=\"$srcity\">$citys</option>
<option value=>�� �����</option>
");
}
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
} // ����� ������
elseif (@mysql_num_rows($result1) == 0)
{ // ��� �������
$result4 = @mysql_query("SELECT * FROM $citytable WHERE podrazdel = '$regions' and razdel='$countrys' and categ != '' order by categ");
if (@mysql_num_rows($result4) != 0) {
echo ("
<tr><td valign=top align=right>�����:</td>
<td valign=top align=left><select name=city size=1 onChange=location.href=location.pathname+\"?country=$country&region=$region&city=\"+value+\"\";>
");
if ($citys == '')
{
echo ("
<option selected value=>�� �����</option>
");
}
if ($citys != '')
{
echo ("
<option selected value=\"$srcity\">$citys</option>
<option value=>�� �����</option>
");
}
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
echo ("
</table><p align=left>
");

if ($city != '') {$srcity="$city";}
if ($city == '' and $region != '') {$srcity="$region";}
if ($city == '' and $region == '' and $country != '') {$srcity="$country";}
if ($city == '' and $region == '' and $country == '') {$srcity="";}

if ($srcity != '')
{ // city
$qwery1="and city = '$srcity'";
} // city
if ($srcity == "") {$qwery1='';}

$result = @mysql_query("SELECT * FROM $metrotable WHERE ID != 0 $qwery1 order by metro");
$totalThread1 = @mysql_num_rows($result);
while($myrow=mysql_fetch_array($result)) {
$ID=$myrow["ID"];
$metro=$myrow["metro"];
echo "<input type=checkbox name=delmes[] value=$ID>$metro&nbsp;<a href=admincr2.php?id=$ID><small>(������)</small></a><br>";
}
if ($totalThread1 != 0)
{echo "<br><center><input type=submit value=\"������� ����������\" name=delete><br><br>";}
echo "</p><hr width=90% size=1>���������� ������� �����<br><textarea rows=4 name=newmetro cols=20></textarea><br><br><center><input type=submit value=\"��������\" name=addmetro><br><br>";
echo ("
<input type=hidden name=srcity value=\"$srcity\">
</form>
");
}
if ($_SERVER[QUERY_STRING] == "del"){
$delmes=$_POST['delmes'];
$newmetro=$_POST['newmetro'];
$srcity=$_POST['srcity'];
if (isset($_POST['delete']) and count($delmes)==0) {
	$error .= "$err2";}
if (isset($_POST['addmetro']) and $newmetro=='') {
	$error .= "$err3";}
if ($error != ""){
echo "<center><h3>������</h3><font color=red>$error</font><p><a href=# onClick=history.go(-1)>���������</a><p><br><br><br><br><br><br><br><br>";
}
if ($error==""){
if (isset($_POST['delete']))
{
unset($result);
for ($i=0;$i<count($delmes);$i++){
$result=@mysql_query("delete from $metrotable WHERE ID=$delmes[$i]");
}
echo "<center><b>��������� ������� �������!</b><br><a href=adminmet.php>��������� �� �������� �������</a><p><br><br><br><br>";
}
if (isset($_POST['addmetro']))
{
$newmetro = split ("\n",$newmetro);
for ($i=0; $i<count($newmetro); $i++)
{
$newmetro[$i]=trim($newmetro[$i]);
$sql="insert into $metrotable (metro,city) values ('$newmetro[$i]','$srcity')";
$result=@mysql_query($sql,$db);
}
echo "<center><b>������� ���������!</b><br><a href=adminmet.php>��������� �� �������� �������</a><p><br><br><br><br>";
}
}
}
} //ok
echo "<center><a href=admin.php>�� ����� �������� �����������������</a><br><br>";
include("down.php");
?>