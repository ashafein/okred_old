<?
session_start();
session_register("uid");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
include("var.php");
echo "<head><title>����������������� - ������ ������: $sitename</title>";
include("top.php");
echo "<center><h3>������ ������</h3>";
$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);
if ($_FILES['file1']['name'] == 'none') {$file1 = '';}
if ($_FILES['file1']['name'] != '') {$file1 = $_FILES['file1']['name'];}
if ($_FILES['file2']['name'] == 'none') {$file2 = '';}
if ($_FILES['file2']['name'] != '') {$file2 = $_FILES['file2']['name'];}
if ($_FILES['file3']['name'] == 'none') {$file3 = '';}
if ($_FILES['file3']['name'] != '') {$file3 = $_FILES['file3']['name'];}
if ($_FILES['file4']['name'] == 'none') {$file4 = '';}
if ($_FILES['file4']['name'] != '') {$file4 = $_FILES['file4']['name'];}
if ($_FILES['file5']['name'] == 'none') {$file5 = '';}
if ($_FILES['file5']['name'] != '') {$file5 = $_FILES['file5']['name'];}
if ($_FILES['file6']['name'] == 'none') {$file6 = '';}
if ($_FILES['file6']['name'] != '') {$file6 = $_FILES['file6']['name'];}
if ($_FILES['file7']['name'] == 'none') {$file7 = '';}
if ($_FILES['file7']['name'] != '') {$file7 = $_FILES['file7']['name'];}
if ($_FILES['file8']['name'] == 'none') {$file8 = '';}
if ($_FILES['file8']['name'] != '') {$file8 = $_FILES['file8']['name'];}
if ($_FILES['file9']['name'] == 'none') {$file9 = '';}
if ($_FILES['file9']['name'] != '') {$file9 = $_FILES['file9']['name'];}
if ($_FILES['file10']['name'] == 'none') {$file10 = '';}
if ($_FILES['file10']['name'] != '') {$file10 = $_FILES['file10']['name'];}
$maxtitle = 1000;
$maxpreview = 5000;
$maxdetail = 10000;
$err1 = "��������� ���� �� ����� (���������, ������� ��������, ��������� ��������)!<br>";
$err2 = "��������� ������ ���� �� ������ $maxtitle ��������<br>";
$err3 = "������� �������� ������ ���� �� ������ $maxpreview ��������<br>";
$err4 = "��������� �������� ������ ���� �� ������ $maxdetail ��������<br>";
$err22 = "���������� ������ ����� ���������� *.jpg ���� *.gif<br>";
$err23 = "���������� ������ ����� ������ �� ����� $MAX_FILE_SIZE ����!<br>";
$err24 = "���������� � ����� ������ ��� ���� � �����!<br>";
$error = "";
if ($_GET['id'] == '') {$id=$_POST['id'];}
elseif ($_GET['id'] != '') {$id=$_GET['id'];}
$result = @mysql_query("SELECT pass FROM $admintable");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
if (!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass)
{
echo "<center><b>�� �� <a href=admin.php>��������������</a>!</b><br><br>";
}
elseif (!isset($id) or $id=="")
{
echo "<center><b>������� �� ����������. ��������� �� �������� <a href=adminrd.php>��������!</a></b><br><br>";
}
else
{ // ok
if ($_SERVER[QUERY_STRING] != "add")
{ //2
$result = @mysql_query("SELECT * FROM $reporttable WHERE ID = '$id'");
while ($myrow=mysql_fetch_array($result)) {
$title=$myrow["title"];
$preview=$myrow["preview"];
$detail=$myrow["detail"];
$hot=$myrow["hot"];
if (!isset($_GET['zav']) or $_GET['zav']=='0') {
$zav=$myrow["zav"];
}
$autor=$myrow["autor"];
$datum=$myrow["datum"];
$category=$myrow["category"];
$source_name1=$myrow["foto1"];
$source_name2=$myrow["foto2"];
$source_name3=$myrow["foto3"];
$source_name4=$myrow["foto4"];
$source_name5=$myrow["foto5"];
$source_name6=$myrow["foto6"];
$source_name7=$myrow["foto7"];
$source_name8=$myrow["foto8"];
$source_name9=$myrow["foto9"];
$source_name10=$myrow["foto10"];
$resultadd1 = @mysql_query("SELECT ID,name FROM $zavtable WHERE ID='$zav'");
while($myrow=mysql_fetch_array($resultadd1)) {
$zav=$myrow["name"];
}
}
echo "<center><font color=red>$error</font></center>";
} //2
if ($_SERVER[QUERY_STRING] == "add") {
$title=$_POST['title'];
$preview=$_POST['preview'];
$detail=$_POST['detail'];
$zav=$_POST['zav'];
$category=$_POST['category'];
$datum=$_POST['datum'];
$aid=$_POST['aid'];
$hot=$_POST['hot'];
$autor=$_POST['autor'];
$update=$_POST['update'];

if ($title == "" and $preview == "" and $detail == "") {$error .= "$err1";}
if ($file1 != "") {
$file1 = $_FILES['file1']['name'];
$filesize1 = $_FILES['file1']['size']; 
$temp1 = $_FILES['file1']['tmp_name'];
$fileres1=strtolower(basename($file1));
if ($file1 != "" and !eregi("\.jpg$",$fileres1) and !eregi("\.gif$",$fileres1)){$error .= "$err22";}
if ($filesize1 > $MAX_FILE_SIZE){$error .= "$err23";}
if (file_exists($afishadir.$fileres1)) {$error .= "$err24";}
}
if ($file2 != "") {
$file2 = $_FILES['file2']['name'];
$filesize2 = $_FILES['file2']['size']; 
$temp2 = $_FILES['file2']['tmp_name'];
$fileres2=strtolower(basename($file2));
if ($file2 != "" and !eregi("\.jpg$",$fileres2) and !eregi("\.gif$",$fileres2)){$error .= "$err22";}
if ($filesize2 > $MAX_FILE_SIZE){$error .= "$err23";}
if (file_exists($afishadir.$fileres2)) {$error .= "$err24";}
}
if ($file3 != "") {
$file3 = $_FILES['file3']['name'];
$filesize3 = $_FILES['file3']['size']; 
$temp3 = $_FILES['file3']['tmp_name'];
$fileres3=strtolower(basename($file3));
if ($file3 != "" and !eregi("\.jpg$",$fileres3) and !eregi("\.gif$",$fileres3)){$error .= "$err22";}
if ($filesize3 > $MAX_FILE_SIZE){$error .= "$err23";}
if (file_exists($afishadir.$fileres3)) {$error .= "$err24";}
}
if ($file4 != "") {
$file4 = $_FILES['file4']['name'];
$filesize4 = $_FILES['file4']['size']; 
$temp4 = $_FILES['file4']['tmp_name'];
$fileres4=strtolower(basename($file4));
if ($file4 != "" and !eregi("\.jpg$",$fileres4) and !eregi("\.gif$",$fileres4)){$error .= "$err22";}
if ($filesize4 > $MAX_FILE_SIZE){$error .= "$err23";}
if (file_exists($afishadir.$fileres4)) {$error .= "$err24";}
}
if ($file5 != "") {
$file5 = $_FILES['file5']['name'];
$filesize5 = $_FILES['file5']['size']; 
$temp5 = $_FILES['file5']['tmp_name'];
$fileres5=strtolower(basename($file5));
if ($file5 != "" and !eregi("\.jpg$",$fileres5) and !eregi("\.gif$",$fileres5)){$error .= "$err22";}
if ($filesize5 > $MAX_FILE_SIZE){$error .= "$err23";}
if (file_exists($afishadir.$fileres5)) {$error .= "$err24";}
}
if ($file6 != "") {
$file6 = $_FILES['file6']['name'];
$filesize6 = $_FILES['file6']['size']; 
$temp6 = $_FILES['file6']['tmp_name'];
$fileres6=strtolower(basename($file6));
if ($file6 != "" and !eregi("\.jpg$",$fileres6) and !eregi("\.gif$",$fileres6)){$error .= "$err29";}
if ($filesize6 > $MAX_FILE_SIZE){$error .= "$err30";}
if (file_exists($afishadir.$fileres6)) {$error .= "$err24";}
}
if ($file7 != "") {
$file7 = $_FILES['file7']['name'];
$filesize7 = $_FILES['file7']['size']; 
$temp7 = $_FILES['file7']['tmp_name'];
$fileres7=strtolower(basename($file7));
if ($file7 != "" and !eregi("\.jpg$",$fileres7) and !eregi("\.gif$",$fileres7)){$error .= "$err29";}
if ($filesize7 > $MAX_FILE_SIZE){$error .= "$err30";}
if (file_exists($afishadir.$fileres7)) {$error .= "$err24";}
}
if ($file8 != "") {
$file8 = $_FILES['file8']['name'];
$filesize8 = $_FILES['file8']['size']; 
$temp8 = $_FILES['file8']['tmp_name'];
$fileres8=strtolower(basename($file8));
if ($file8 != "" and !eregi("\.jpg$",$fileres8) and !eregi("\.gif$",$fileres8)){$error .= "$err29";}
if ($filesize8 > $MAX_FILE_SIZE){$error .= "$err30";}
if (file_exists($afishadir.$fileres8)) {$error .= "$err24";}
}
if ($file9 != "") {
$file9 = $_FILES['file9']['name'];
$filesize9 = $_FILES['file9']['size']; 
$temp9 = $_FILES['file9']['tmp_name'];
$fileres9=strtolower(basename($file9));
if ($file9 != "" and !eregi("\.jpg$",$fileres9) and !eregi("\.gif$",$fileres9)){$error .= "$err29";}
if ($filesize9 > $MAX_FILE_SIZE){$error .= "$err30";}
if (file_exists($afishadir.$fileres9)) {$error .= "$err24";}
}
if ($file10 != "") {
$file10 = $_FILES['file10']['name'];
$filesize10 = $_FILES['file10']['size']; 
$temp10 = $_FILES['file10']['tmp_name'];
$fileres10=strtolower(basename($file10));
if ($file10 != "" and !eregi("\.jpg$",$fileres10) and !eregi("\.gif$",$fileres10)){$error .= "$err29";}
if ($filesize10 > $MAX_FILE_SIZE){$error .= "$err30";}
if (file_exists($afishadir.$fileres10)) {$error .= "$err24";}
}
echo "<center><font color=red>$error</font></center>";
if ($_SERVER[QUERY_STRING] == "add" and $error == "") {
if ($_SERVER[QUERY_STRING] == "add" and $file1 != "" or $file2 != "" or $file3 != "" or $file4 != "" or $file5 != "" or $file6 != "" or $file7 != "" or $file8 != "" or $file9 != "" or $file10 != "") {
$updir=$afishadir;
$path1 = $upath."$updir";
if ($file1 != "") {$source_name1="";}
if ($file2 != "") {$source_name2="";}
if ($file3 != "") {$source_name3="";}
if ($file4 != "") {$source_name4="";}
if ($file5 != "") {$source_name5="";}
if ($file6 != "") {$source_name6="";}
if ($file7 != "") {$source_name7="";}
if ($file8 != "") {$source_name8="";}
if ($file9 != "") {$source_name9="";}
if ($file10 != "") {$source_name10="";}
if ($file1 != "") {$source_name1 = "$fileres1";}
if ($file2 != "") {$source_name2 = "$fileres2";}
if ($file3 != "") {$source_name3 = "$fileres3";}
if ($file4 != "") {$source_name4 = "$fileres4";}
if ($file5 != "") {$source_name5 = "$fileres5";}
if ($file6 != "") {$source_name6 = "$fileres6";}
if ($file7 != "") {$source_name7 = "$fileres7";}
if ($file8 != "") {$source_name8 = "$fileres8";}
if ($file9 != "") {$source_name9 = "$fileres9";}
if ($file10 != "") {$source_name10 = "$fileres10";}
if($error == ""){
$dest1 = $path1.$source_name1;
$dest2 = $path1.$source_name2;
$dest3 = $path1.$source_name3;
$dest4 = $path1.$source_name4;
$dest5 = $path1.$source_name5;
$dest6 = $path1.$source_name6;
$dest7 = $path1.$source_name7;
$dest8 = $path1.$source_name8;
$dest9 = $path1.$source_name9;
$dest10 = $path1.$source_name10;
if ($file1 != "") {
@copy("$temp1","$dest1");$foto1=$updir."$source_name1";
}
if ($file2 != "") {
@copy("$temp2","$dest2");$foto2=$updir."$source_name2";
}
if ($file3 != "") {
@copy("$temp3","$dest3");$foto3=$updir."$source_name3";
}
if ($file4 != "") {
@copy("$temp4","$dest4");$foto4=$updir."$source_name4";
}
if ($file5 != "") {
@copy("$temp5","$dest5");$foto5=$updir."$source_name5";
}
if ($file6 != "") {
@copy("$temp6","$dest6");$foto6=$updir."$source_name6";
}
if ($file7 != "") {
@copy("$temp7","$dest7");$foto7=$updir."$source_name7";
}
if ($file8 != "") {
@copy("$temp8","$dest8");$foto8=$updir."$source_name8";
}
if ($file9 != "") {
@copy("$temp9","$dest9");$foto9=$updir."$source_name9";
}
if ($file10 != "") {
@copy("$temp10","$dest10");$foto10=$updir."$source_name10";
}
}
}
if (isset($zav) and $zav != '' and $zav != '0')
{
$resultadd1 = @mysql_query("SELECT * FROM $zavtable WHERE name='$zav' LIMIT 1");
while($myrow=mysql_fetch_array($resultadd1)) {
$zav=$myrow["ID"];
}
}
if ($update == 'checked') {$sql="update $reporttable SET category='$category',title='$title',preview='$preview',detail='$detail',hot='$hot',date=now(),datum='$datum',foto1='$source_name1',foto2='$source_name2',foto3='$source_name3',foto4='$source_name4',foto5='$source_name5',foto6='$source_name6',foto7='$source_name7',foto8='$source_name8',foto9='$source_name9',foto10='$source_name10',zav='$zav',autor='$autor' WHERE ID='$id'";}
elseif ($update != 'checked') {$sql="update $reporttable SET category='$category',title='$title',preview='$preview',detail='$detail',hot='$hot',datum='$datum',foto1='$source_name1',foto2='$source_name2',foto3='$source_name3',foto4='$source_name4',foto5='$source_name5',foto6='$source_name6',foto7='$source_name7',foto8='$source_name8',foto9='$source_name9',foto10='$source_name10',zav='$zav',autor='$autor' WHERE ID='$id'";}
$result=@mysql_query($sql,$db);
}
}
if ($_SERVER[QUERY_STRING] != "add" or $error != "") {
echo ("
<script language=\"JavaScript\">
 <!--

function voidPutATag(Tag,Tag2)
{
document.formata.preview.focus();
sel = document.selection.createRange();
sel.text = Tag+sel.text+Tag2;
document.formata.preview.focus();
}

function voidPutATag2(Tag,Tag2)
{
document.formata.detail.focus();
sel = document.selection.createRange();
sel.text = Tag+sel.text+Tag2;
document.formata.detail.focus();
}

 //-->
</script>
<form method=post ENCTYPE=\"multipart/form-data\" action=\"adminrc.php?add\" name=formata>
<input type=hidden name=id value=$id>
<input type=hidden name=source_name1 value=$source_name1>
<input type=hidden name=source_name2 value=$source_name2>
<input type=hidden name=source_name3 value=$source_name3>
<input type=hidden name=source_name4 value=$source_name4>
<input type=hidden name=source_name5 value=$source_name5>
<input type=hidden name=source_name6 value=$source_name6>
<input type=hidden name=source_name7 value=$source_name7>
<input type=hidden name=source_name8 value=$source_name8>
<input type=hidden name=source_name9 value=$source_name9>
<input type=hidden name=source_name10 value=$source_name10>
<table>
<tr><td align=right valign=top>� �����������:</td>
<td align=left><select name=aid size=1>
<option selected value=\"$aid\">$aid</option>
<option value=></option>
");
$result4 = @mysql_query("SELECT ID,title,datum FROM $newstable WHERE title != '' order by datum DESC");
while($myrow=mysql_fetch_array($result4)) {
$aid1=$myrow["title"];
$datum1=$myrow["datum"];
echo "<option value=\"$aid1\">$aid1($datum1)</option>";
}
echo ("
</select></td></tr>
<tr><td align=right valign=top>���� �������:</td>
<td valign=top><input type=text name=datum value=\"$datum\"><br><small>����-��-��</small></td>
</tr>
<tr><td align=right valign=top>������:</td>
<td align=left><select name=category size=1>
<option selected value=\"$category\">$category</option>
");
$result3 = @mysql_query("SELECT * FROM $afishacatable WHERE category != '' order by ID DESC");
while($myrow=mysql_fetch_array($result3)) {
$category=$myrow["category"];
echo "<option value=\"$category\">$category</option>";
}
echo ("
</select></td></tr>
<tr><td align=right>���������:</td>
<td><input type=text size=50 name=title value=\"$title\"></td>
</tr>
<tr><td valign=top align=right>������� ��������:</td>
<td><small>
      <a href=\"javascript: voidPutATag('<b>','</b>')\" title=\"���������� �����\" class=buten>b</a>
      <a href=\"javascript: voidPutATag('<i>','</i>')\" title=\"������\" class=buten>i</a>
      <a href=\"javascript: voidPutATag('<u>','</u>')\" title=\"�������������\" class=buten>u</u>
      <a href=\"javascript: voidPutATag('<center>','</center>')\" title=\"\" class=buten>center</a>
      <a href=\"javascript: voidPutATag('<ul>','</ul>')\" title=\"������\" class=buten>ul</a>
      <a href=\"javascript: voidPutATag('<li>','</li>')\" title=\"������� ������\" class=buten>li</a>
      <a href=\"javascript: voidPutATag('&laquo;','&raquo;')\" title=\"�������\" class=buten>&laquo; &raquo;</a>
      <a href=\"javascript: voidPutATag('\n<br>','\n ')\" title=\"������� ������\" class=buten>br</a>
      <a href=\"javascript: voidPutATag('\n<p>','\n ')\" title=\"�����\" class=buten>�����</a>
      <a href=\"javascript: voidPutATag('<a href=>','</a>')\" title=\"������\" class=buten>������</a>
      <a href=\"javascript: voidPutATag('<img src=$afishadir/.jpg class=image align=left alt=&#34;&#34;>','')\" title=\"�������� ����� ������\" class=buten>�������� �����</a>
      <a href=\"javascript: voidPutATag('<img src=$afishadir/.jpg class=image align=right alt=&#34;&#34;>','')\" title=\"�������� ������ ������\" class=buten>�������� ������</a>
</small><br>
<textarea name=preview cols=50 rows=7 wrap=physical>$preview</textarea></td></tr>
<tr><td valign=top align=right>��������� ��������:</td>
<td>
<small>
      <a href=\"javascript: voidPutATag2('<b>','</b>')\" title=\"���������� �����\" class=buten>b</a>
      <a href=\"javascript: voidPutATag2('<i>','</i>')\" title=\"������\" class=buten>i</a>
      <a href=\"javascript: voidPutATag2('<u>','</u>')\" title=\"�������������\" class=buten>u</u>
      <a href=\"javascript: voidPutATag2('<center>','</center>')\" title=\"\" class=buten>center</a>
      <a href=\"javascript: voidPutATag2('<ul>','</ul>')\" title=\"������\" class=buten>ul</a>
      <a href=\"javascript: voidPutATag2('<li>','</li>')\" title=\"������� ������\" class=buten>li</a>
      <a href=\"javascript: voidPutATag2('&laquo;','&raquo;')\" title=\"�������\" class=buten>&laquo; &raquo;</a>
      <a href=\"javascript: voidPutATag2('\n<br>','\n ')\" title=\"������� ������\" class=buten>br</a>
      <a href=\"javascript: voidPutATag2('\n<p>','\n ')\" title=\"�����\" class=buten>�����</a>
      <a href=\"javascript: voidPutATag2('<a href=>','</a>')\" title=\"������\" class=buten>������</a>
      <a href=\"javascript: voidPutATag2('<img src=$afishadir/.jpg class=image align=left alt=&#34;&#34;>','')\" title=\"�������� ����� ������\" class=buten>�������� �����</a>
      <a href=\"javascript: voidPutATag2('<img src=$afishadir/.jpg class=image align=right alt=&#34;&#34;>','')\" title=\"�������� ������ ������\" class=buten>�������� ������</a>
</small><br>
<textarea name=detail cols=50 rows=7 wrap=physical>$detail</textarea></td></tr>
<tr><td align=right valign=top>����� ����������:</td>
<td align=left><select name=zav size=1>
<option selected value=\"$zav\">$zav</option>
<option value=></option>
");
$result4 = @mysql_query("SELECT ID,name FROM $zavtable WHERE name != '' order by name");
while($myrow=mysql_fetch_array($result4)) {
$zav1=$myrow["name"];
echo "<option value=\"$zav1\">$zav1</option>";
}
echo ("
</select></td></tr>
<tr><td align=right>�����:</td>
<td><input type=text size=50 name=autor value=\"$autor\"></td>
</tr>
<tr><td align=right>������� �����:</td>
<td><input type=checkbox name=hot value=checked $hot></td>
<tr><td align=right>�������� ����:</td>
<td><input type=checkbox name=update value=checked $update></td>
</tr>
<tr><td align=center colspan=2>
<input type=hidden name=action1 value=1>
����1: <input type=file name=file1 size=30><br>
����2: <input type=file name=file2 size=30><br>
����3: <input type=file name=file3 size=30><br>
����4: <input type=file name=file4 size=30><br>
����5: <input type=file name=file5 size=30><br>
����6: <input type=file name=file6 size=30><br>
����7: <input type=file name=file7 size=30><br>
����8: <input type=file name=file8 size=30><br>
����9: <input type=file name=file9 size=30><br>
����10: <input type=file name=file10 size=30><br>
<br>
</td></tr>
</table>
");
echo "<center><p><input type=submit value=\"��������\" name=\"submit\"></form>";
echo "<center><a href=adminrd.php>��������� �� �������� ��������</a><br><br><a href=admin.php>�� ����� �������� �����������������</a><br><br>";
}
else {
echo "<b>��������� ���������!</b><br><br><a href=adminrd.php>��������� �� �������� ��������</a><br><br><a href=admin.php>�� ����� �������� �����������������</a><br><br>";
}
} // ok
include("down.php");
?>