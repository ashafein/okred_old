<?
session_start();
session_register("uid");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
include("var.php");
echo "<head><title>����������������� - ���������� ������ : $sitename</title>";
include("top.php");
echo "<center><h3>���������� ������</h3>";
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
$result = @mysql_query("SELECT pass FROM $admintable");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
if (!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass)
{
echo "<center><b>�� �� <a href=admin.php>��������������</a>!</b><br><br>";
}
else
{ // ok
if ($_SERVER[QUERY_STRING] == "add")
{ // add
$title=$_POST['title'];
$preview=$_POST['preview'];
$detail=$_POST['detail'];
$zav=$_POST['zav'];
$category=$_POST['category'];
$datum=$_POST['datum'];
$aid=$_POST['aid'];
$hot=$_POST['hot'];
$autor=$_POST['autor'];
$sendno=$_POST['sendno'];

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
$date = date("Y/m/d");
$stroka='<b>����� ��������</b>';
if ($_SERVER[QUERY_STRING] == "add" and $file1 != "" or $file2 != "" or $file3 != "" or $file4 != "" or $file5 != "" or $file6 != "" or $file7 != "" or $file8 != "" or $file9 != "" or $file10 != "") {
$updir=$afishadir;
$path1 = $upath."$updir";
$source_name1="";
$source_name2="";
$source_name3="";
$source_name4="";
$source_name5="";
$source_name6="";
$source_name7="";
$source_name8="";
$source_name9="";
$source_name10="";
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
if (isset($aid) and $aid != '' and $aid != '0')
{
$resultadd1 = @mysql_query("SELECT ID,title,datum FROM $afishatable WHERE title='$aid' LIMIT 1");
while($myrow=mysql_fetch_array($resultadd1)) {
$aid=$myrow["ID"];
}
}
$sql="insert into $reporttable (category,title,preview,detail,date,datum,foto1,foto2,foto3,foto4,foto5,foto6,foto7,foto8,foto9,foto10,aid,hot,zav,autor) values ('$category','$title','$preview','$detail',now(),'$datum','$source_name1','$source_name2','$source_name3','$source_name4','$source_name5','$source_name6','$source_name7','$source_name8','$source_name9','$source_name10','$aid','$hot','$zav','$autor')";
$result=@mysql_query($sql,$db);

// rassilka

$sql="update $rassilka SET afisha=afisha+1 WHERE name='admin'";
$result=@mysql_query($sql,$db);
$resl = @mysql_query("SELECT name,status FROM $rassilka WHERE name='admin'");
while ($myrow=mysql_fetch_array($resl)) 
{
$rstatus=$myrow["status"];
}
if ($rstatus == 'on')
{ //ras
$resl1 = @mysql_query("SELECT name,afisha FROM $rassilka WHERE name='admin' and afisha >= $afisha_sendcount");
$totalr = @mysql_num_rows($resl1);
if ($totalr != 0)
{ //full

$now_month = date("n",time());
$now_year  = date("Y",time());
$now_today = date("j", time());

//�������
if (isset($_GET['month'])) {
   $month = $_GET['month'];
   $month = ereg_replace ("[[:space:]]", "", $month);
   $month = ereg_replace ("[[:punct:]]", "", $month);
   $month = ereg_replace ("[[:alpha:]]", "", $month);
   if ($month < 1) { $month = 12; }
   if ($month > 12) { $month = 1; }
   }

if (isset($_GET['year'])) {
   $year = $_GET['year'];
   $year = ereg_replace ("[[:space:]]", "", $year);
   $year = ereg_replace ("[[:punct:]]", "", $year);
   $year = ereg_replace ("[[:alpha:]]", "", $year);
   if ($year < 1990) { $year = 1990; }
   if ($year > 2035) { $year = 2035; }
   }

if (isset($_GET['today'])) {
   $today = $_GET['today'];
   $today = ereg_replace ("[[:space:]]", "", $today);
   $today = ereg_replace ("[[:punct:]]", "", $today);
   $today = ereg_replace ("[[:alpha:]]", "", $today);
   }

$month = (isset($month)) ? $month : date("n",time());
$year  = (isset($year)) ? $year : date("Y",time());
$today = (isset($today))? $today : date("j", time());
$daylong   = date("l",mktime(1,1,1,$month,$today,$year)); //���� ������ ����� ����.
$monthlong = date("F",mktime(1,1,1,$month,$today,$year)); //�������� ������ ����.
$dayone    = date("w",mktime(1,1,1,$month,1,$year)); //���� ������ ������
$numdays   = date("t",mktime(1,1,1,$month,1,$year)); //���������� ���� � ������
$alldays   = array('��','��','��','��','��','<font color=red>��</font>','<font color=red>��</font>');
$next_year = $year + 1;
$last_year = $year - 1;
$next_month = $month + 1;
$last_month = $month - 1;
if ($today > $numdays) { $today--; }
        if($month == "1" ){$month_ru="������";}
    elseif($month == "2" ){$month_ru="�������";}
    elseif($month == "3" ){$month_ru="����";}
    elseif($month == "4" ){$month_ru="������";}
    elseif($month == "5" ){$month_ru="���";}
    elseif($month == "6" ){$month_ru="����";}
    elseif($month == "7" ){$month_ru="����";}
    elseif($month == "8" ){$month_ru="������";}
    elseif($month == "9" ){$month_ru="��������";}
    elseif($month == "10"){$month_ru="�������";}
    elseif($month == "11"){$month_ru="������";}
    elseif($month == "12"){$month_ru="�������";}

        if($month == "1" ){$month_rus="������";}
    elseif($month == "2" ){$month_rus="�������";}
    elseif($month == "3" ){$month_rus="�����";}
    elseif($month == "4" ){$month_rus="������";}
    elseif($month == "5" ){$month_rus="���";}
    elseif($month == "6" ){$month_rus="����";}
    elseif($month == "7" ){$month_rus="����";}
    elseif($month == "8" ){$month_rus="�������";}
    elseif($month == "9" ){$month_rus="��������";}
    elseif($month == "10"){$month_rus="�������";}
    elseif($month == "11"){$month_rus="������";}
    elseif($month == "12"){$month_rus="�������";}

$sql_date = $year."-".$month."-".$today;
$body = '<p align=justify class=text>';

       $result = mysql_query("select * from $reporttable order by date desc LIMIT $sendcount");
       $rows = mysql_num_rows($result);

for($k=0;$k < $rows;$k++)
   {
    $preview=mysql_result($result, $k , "preview");
    $detail=mysql_result($result, $k , "detail");
    $title=mysql_result($result, $k , "title");
    $idnum=mysql_result($result, $k , "ID");
    $datum=mysql_result($result, $k , "date");
    $foto1=mysql_result($result, $k , "foto1");
    $dati=explode("-",$datum);
if ($preview != "") {
$preview = ereg_replace("\n","<br>",$preview);
$preview = ereg_replace("     ","&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$preview);
if (eregi('����1',$preview) and $foto1 != ""){$preview=@str_replace('����1',"",$preview);}
if (ereg('<img',$preview))
{
$rf = $preview;
$s = strpos($rf, "<img", 0);
$rf = substr($rf, $s); 
$s = strpos($rf, ">");
$rf = substr($rf, 0, $s+1);
$preview = ereg_replace($rf,"",$preview);
}
}

if($preview=="")
{
$body .= "$dati[2].$dati[1].$dati[0]&nbsp;&nbsp;&nbsp;<br><big><b>$title</b></big><br><br>";
}
elseif($preview != "" and $detail != "")
{
$body .= "$dati[2].$dati[1].$dati[0]&nbsp;&nbsp;&nbsp;<br><big><b>$title</b></big><br>$preview<br><a href=\"$siteadress/report.php?link=$idnum\">���������</a>&nbsp;&raquo;<br><br>";
}
elseif($preview != "" and $detail == "")
{
$body .= "$dati[2].$dati[1].$dati[0]&nbsp;&nbsp;&nbsp;<br><big><b>$title</b></big><br>$preview<br><br>";
}
 }
$body .= "<a href=$siteadress/report.php>���������� ��� ������</a>&nbsp;&raquo;</p>";


$resl2 = @mysql_query("SELECT email,vac FROM $emailr WHERE email != '' and vac = 'on'");
while ($myrow=mysql_fetch_array($resl2)) 
{
$rassemail=$myrow["email"];
$txtdown = "<table width=100% border=0 class=text><tr><td><small>$sitename<br><a href=$siteadress>$siteadress</a></small></td><td align=right valign=top><a href=\"$siteadress/unsubscr.php?email=$rassemail\"><small>����������</small></a></td></tr></table>";
$txt=$body.$txtdown;
@mail($rassemail,"$title - $sitename",$txt,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/html; charset=windows-1251\nContent-Transfer-Encoding:8bit\n",'-f$adminemail');
}
$sql1="update $rassilka SET afisha=0 WHERE name='admin'";
$resl3=@mysql_query($sql1,$db);
} //full
} //ras

// rassilka
}
} // add
if ($_SERVER[QUERY_STRING] != "add" or $error != "") 
{ // form
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
<form name=formata method=post ENCTYPE=\"multipart/form-data\" action=\"adminrep.php?add\">
<table>
<tr><td align=right valign=top>� �����������:</td>
<td align=left><select name=aid size=1>
<option selected value=\"$aid\">$aid</option>
<option value=></option>
");
$result4 = @mysql_query("SELECT ID,title,datum FROM $afishatable WHERE title != '' order by datum DESC");
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
<P><input type=\"submit\" value=\"��������\">
</form><br>
<a href=admin.php>�� ����� �������� �����������������</a>
");
} //form
else {
echo "<center><br><br>$stroka<br><br><a href=adminrep.php>�������� ��� �����</a><br><br><a href=admin.php>�� ����� �������� �����������������</a><br><br>";
}
} // ok
include("down.php");
?>