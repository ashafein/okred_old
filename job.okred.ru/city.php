<?
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
echo "<head>";
include("var.php");
echo"<title>����� ������: $sitename</title>";
include("top.php");

echo ("
<h3>����� ������</h3>
");

$countrys='--- �������� ������ ---';
$regions='--- �������� ������� ---';
$citys='--- �������� ����� ---';

$city=$_GET['city'];
$region=$_GET['region'];
$country=$_GET['country'];

if (isset($city) and $city != '')
{
$resultadd3 = @mysql_query("SELECT ID,categ FROM $citytable WHERE ID='$city'");
while($myrow=mysql_fetch_array($resultadd3)) {
$citys=$myrow["categ"];
}
}
if (isset($region))
{
if ($region != '')
{
$resultadd2 = @mysql_query("SELECT ID,podrazdel FROM $citytable WHERE ID='$region'");
while($myrow=mysql_fetch_array($resultadd2)) {
$regions=$myrow["podrazdel"];
}
}
if ($region == '') {$regions='��� �������';}
}
if (isset($country))
{
if ($country != '')
{
$resultadd1 = @mysql_query("SELECT ID,razdel,podrazdel FROM $citytable WHERE podrazdel = '' and ID='$country'");
while($myrow=mysql_fetch_array($resultadd1)) {
$countrys=$myrow["razdel"];
}
}
if ($country == '') {$countrys='��� ������';}
}

echo ("
<form name=form method=post ENCTYPE=\"multipart/form-data\" action=index.php?selcity>
<table class=tbl1 width=90%>
<tr><td valign=top align=right>������:</td>
<td valign=top align=left>
<input type=hidden name=city value=\"$city\">
<input type=hidden name=region value=\"$region\">
<select class=for name=country size=1 onChange=location.href=location.pathname+\"?razdel=$razdel&podrazdel=$podrazdel&country=\"+value+\"\";>
<option selected value=\"$country\">$countrys</option>
<option value=>��� ������</option>
");
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
<tr><td valign=top align=right><strong><font color=#FF0000>*</font>������:</strong></td>
<td valign=top align=left><select name=region size=1 onChange=location.href=location.pathname+\"?razdel=$razdel&podrazdel=$podrazdel&country=$country&region=\"+value+\"\";>
<option selected value=\"$region\">$regions</option>
<option value=>��� �������</option>
");
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
<tr><td valign=top align=right><strong><font color=#FF0000>*</font>�����:</strong></td>
<td valign=top align=left><select name=city size=1>
<option selected value=\"$city\">$citys</option>
<option value=>��� ������</option>
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
<tr><td valign=top align=right><strong><font color=#FF0000>*</font>�����:</strong></td>
<td valign=top align=left><select name=city size=1>
<option selected value=\"$city\">$citys</option>
<option value=>��� ������</option>
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
echo ("
</table>
");
echo "<!--<p><input type=submit value=\"�����\" name=\"submit\" class=dob>--></form>";
include("down.php");
?>