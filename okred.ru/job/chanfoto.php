<?
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<?php
include("var.php");
echo"<title>���������� ������������ : $sitename</title>";
include("top.php");
echo "<div class=tbl1>";
?>
<h3><center><strong>���������� ������������</strong></center></h3>
<?php
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
$sid=$_SESSION['sid'];
$id=$_SESSION['sid'];
$slogin=$_SESSION['slogin'];
$spass=$_SESSION['spass'];
$REMOTE_ADDR=$_SERVER['REMOTE_ADDR'];
$err22 = "���������� ������ ����� ���������� *.jpg ���� *.gif<br>";
$err23 = "���������� ������ ����� ������ �� ����� $MAX_FILE_SIZE ����.<br>";
$err4 = "�� ������ ���� � ����������.<br>";
$error = "";
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
if ($_GET['texid'] == '') {$texid=$_POST['texid'];}
elseif ($_GET['texid'] != '') {$texid=$_GET['texid'];}

$result = @mysql_query("SELECT email,pass FROM $autortable WHERE (email = '$slogin' and pass = '$spass')");
if ((!isset($slogin) or !isset($spass)) or @mysql_num_rows($result) == 0)
{
if (isset($texid) and isset($r) and $r != '')
{echo "<center><br><br><h3>�� �� ��������������!</h3><b><a href=autor.php>�����������</a></b>";}
if (!isset($texid) or !isset($r) or $r == '')
{echo "<center><br><br><h3>���������� �� ����������!</h3><b><a href=autor.php>�����������</a></b>";}
}
else
{//0
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
if ($_SERVER[QUERY_STRING] != "add")
{ //2
$result = @mysql_query("SELECT ID,foto1,aid,status FROM $restable WHERE ID = '$texid'");
while ($myrow=mysql_fetch_array($result)) {
$foto1=$myrow["foto1"];
}
echo "<center><font color=red>$error</font></center>";
} //2
if ($_SERVER[QUERY_STRING] == "add") {
if ($file1 != "") {
$file1 = $_FILES['file1']['name'];
$filesize1 = $_FILES['file1']['size']; 
$temp1 = $_FILES['file1']['tmp_name'];
$fileres1=strtolower(basename($file1));
if ($file1 != "" and !eregi("\.jpg$",$fileres1) and !eregi("\.gif$",$fileres1)){$error .= "$err22";}
if ($filesize1 > $MAX_FILE_SIZE){$error .= "$err23";}
}
if ($file2 != "") {
$file2 = $_FILES['file2']['name'];
$filesize2 = $_FILES['file2']['size']; 
$temp2 = $_FILES['file2']['tmp_name'];
$fileres2=strtolower(basename($file2));
if ($file2 != "" and !eregi("\.jpg$",$fileres2) and !eregi("\.gif$",$fileres2)){$error .= "$err22";}
if ($filesize2 > $MAX_FILE_SIZE){$error .= "$err23";}
}
if ($file3 != "") {
$file3 = $_FILES['file3']['name'];
$filesize3 = $_FILES['file3']['size']; 
$temp3 = $_FILES['file3']['tmp_name'];
$fileres3=strtolower(basename($file3));
if ($file3 != "" and !eregi("\.jpg$",$fileres3) and !eregi("\.gif$",$fileres3)){$error .= "$err22";}
if ($filesize3 > $MAX_FILE_SIZE){$error .= "$err23";}
}
if ($file4 != "") {
$file4 = $_FILES['file4']['name'];
$filesize4 = $_FILES['file4']['size']; 
$temp4 = $_FILES['file4']['tmp_name'];
$fileres4=strtolower(basename($file4));
if ($file4 != "" and !eregi("\.jpg$",$fileres4) and !eregi("\.gif$",$fileres4)){$error .= "$err22";}
if ($filesize4 > $MAX_FILE_SIZE){$error .= "$err23";}
}
if ($file5 != "") {
$file5 = $_FILES['file5']['name'];
$filesize5 = $_FILES['file5']['size']; 
$temp5 = $_FILES['file5']['tmp_name'];
$fileres5=strtolower(basename($file5));
if ($file5 != "" and !eregi("\.jpg$",$fileres5) and !eregi("\.gif$",$fileres5)){$error .= "$err22";}
if ($filesize5 > $MAX_FILE_SIZE){$error .= "$err23";}
}
if (isset($upload) and $file1 == "" and $file2 == "" and $file3 == "" and $file4 == "" and $file5 == "") {$error .= "$err4";}
echo "<center><font color=red>$error</font></center>";
if ($_SERVER[QUERY_STRING] == "add" and $error == "") {
if ($textconfirm=='TRUE') {$status='wait';$stroka='<b>����� �������� ��������� ��������������� ���������� ����� ��������� � ���� �����.</b>';}
elseif ($textconfirm=='FALSE') {$status='ok';$stroka='<b>� ������� ���������� ����� ��������� ������� � ����</b>';}
if (isset($upload)) {
$fid=$texid;
$updir=$photodir;
$path1 = $upath."$updir";
$fileres1=@substr($fileres1,-3,3);
$fileres2=@substr($fileres2,-3,3);
$fileres3=@substr($fileres3,-3,3);
$fileres4=@substr($fileres4,-3,3);
$fileres5=@substr($fileres5,-3,3);
$source_name1="";
$source_name2="";
$source_name3="";
$source_name4="";
$source_name5="";
if ($file1 != "") {$source_name1 = "p".$fid."_1.$fileres1";}
if ($file2 != "") {$source_name2 = "p".$fid."_2.$fileres2";}
if ($file3 != "") {$source_name3 = "p".$fid."_3.$fileres3";}
if ($file4 != "") {$source_name4 = "p".$fid."_4.$fileres4";}
if ($file5 != "") {$source_name5 = "p".$fid."_5.$fileres5";}
if($error == ""){
$dest1 = $path1.$source_name1;
$dest2 = $path1.$source_name2;
$dest3 = $path1.$source_name3;
$dest4 = $path1.$source_name4;
$dest5 = $path1.$source_name5;
if ($file1 != "") {@copy("$temp1","$dest1");$foto1=$updir."$source_name1";
if (function_exists('ImageTypes')) {
if ((ImageTypes() & IMG_JPG and $fileres1=='jpg') or (ImageTypes() & IMG_GIF and $fileres1=='gif'))
{ //small img
if ($fileres1=='jpg') {$image = ImageCreateFromJPEG($foto1);}
if ($fileres1=='gif') {$image = ImageCreateFromGIF($foto1);}
$width = imagesx($image) ;
$height = imagesy($image) ;
$new_height = $smallfotoheight; 
$new_width = ($new_height * $width) / $height ;
$thumb = imagecreate($new_width,$new_height);
$thumb = ImageCreateTrueColor($new_width,$new_height);
imagecopyresized($thumb,$image,0,0,0,0,$new_width,$new_height,$width,$height);
if ($fileres1=='jpg') {ImageJPEG($thumb, $updir.'s'.$source_name1);}
if ($fileres1=='gif') {ImageGIF($thumb, $updir.'s'.$source_name1);}
}} //small img
$sql="update $restable SET foto1='$source_name1',status='$status' WHERE ID='$texid'";
$result=@mysql_query($sql,$db);
}
if ($file2 != "") {@copy("$temp2","$dest2");$foto2=$updir."$source_name2";
if (function_exists('ImageTypes')) {
if ((ImageTypes() & IMG_JPG and $fileres2=='jpg') or (ImageTypes() & IMG_GIF and $fileres2=='gif'))
{ //small img
if ($fileres2=='jpg') {$image = ImageCreateFromJPEG($foto2);}
if ($fileres2=='gif') {$image = ImageCreateFromGIF($foto2);}
$width = imagesx($image) ;
$height = imagesy($image) ;
$new_height = $smallfotoheight; 
$new_width = ($new_height * $width) / $height ;
$thumb = imagecreate($new_width,$new_height);
$thumb = ImageCreateTrueColor($new_width,$new_height);
imagecopyresized($thumb,$image,0,0,0,0,$new_width,$new_height,$width,$height);
if ($fileres2=='jpg') {ImageJPEG($thumb, $updir.'s'.$source_name2);}
if ($fileres2=='gif') {ImageGIF($thumb, $updir.'s'.$source_name2);}
}} //small img
$sql="update $restable SET foto2='$source_name2',status='$status' WHERE ID='$texid'";
$result=@mysql_query($sql,$db);
}
if ($file3 != "") {@copy("$temp3","$dest3");$foto3=$updir."$source_name3";
if (function_exists('ImageTypes')) {
if ((ImageTypes() & IMG_JPG and $fileres3=='jpg') or (ImageTypes() & IMG_GIF and $fileres3=='gif'))
{ //small img
if ($fileres3=='jpg') {$image = ImageCreateFromJPEG($foto3);}
if ($fileres3=='gif') {$image = ImageCreateFromGIF($foto3);}
$width = imagesx($image) ;
$height = imagesy($image) ;
$new_height = $smallfotoheight; 
$new_width = ($new_height * $width) / $height ;
$thumb = imagecreate($new_width,$new_height);
$thumb = ImageCreateTrueColor($new_width,$new_height);
imagecopyresized($thumb,$image,0,0,0,0,$new_width,$new_height,$width,$height);
if ($fileres3=='jpg') {ImageJPEG($thumb, $updir.'s'.$source_name3);}
if ($fileres3=='gif') {ImageGIF($thumb, $updir.'s'.$source_name3);}
}} //small img
$sql="update $restable SET foto3='$source_name3',status='$status' WHERE ID='$texid'";
$result=@mysql_query($sql,$db);
}
if ($file4 != "") {@copy("$temp4","$dest4");$foto4=$updir."$source_name4";
if (function_exists('ImageTypes')) {
if ((ImageTypes() & IMG_JPG and $fileres4=='jpg') or (ImageTypes() & IMG_GIF and $fileres4=='gif'))
{ //small img
if ($fileres4=='jpg') {$image = ImageCreateFromJPEG($foto4);}
if ($fileres4=='gif') {$image = ImageCreateFromGIF($foto4);}
$width = imagesx($image) ;
$height = imagesy($image) ;
$new_height = $smallfotoheight; 
$new_width = ($new_height * $width) / $height ;
$thumb = imagecreate($new_width,$new_height);
$thumb = ImageCreateTrueColor($new_width,$new_height);
imagecopyresized($thumb,$image,0,0,0,0,$new_width,$new_height,$width,$height);
if ($fileres4=='jpg') {ImageJPEG($thumb, $updir.'s'.$source_name4);}
if ($fileres4=='gif') {ImageGIF($thumb, $updir.'s'.$source_name4);}
}} //small img
$sql="update $restable SET foto4='$source_name4',status='$status' WHERE ID='$texid'";
$result=@mysql_query($sql,$db);
}
if ($file5 != "") {@copy("$temp5","$dest5");$foto5=$updir."$source_name5";
if (function_exists('ImageTypes')) {
if ((ImageTypes() & IMG_JPG and $fileres5=='jpg') or (ImageTypes() & IMG_GIF and $fileres5=='gif'))
{ //small img
if ($fileres5=='jpg') {$image = ImageCreateFromJPEG($foto5);}
if ($fileres5=='gif') {$image = ImageCreateFromGIF($foto5);}
$width = imagesx($image) ;
$height = imagesy($image) ;
$new_height = $smallfotoheight; 
$new_width = ($new_height * $width) / $height ;
$thumb = imagecreate($new_width,$new_height);
$thumb = ImageCreateTrueColor($new_width,$new_height);
imagecopyresized($thumb,$image,0,0,0,0,$new_width,$new_height,$width,$height);
if ($fileres5=='jpg') {ImageJPEG($thumb, $updir.'s'.$source_name5);}
if ($fileres5=='gif') {ImageGIF($thumb, $updir.'s'.$source_name5);}
}} //small img
$sql="update $restable SET foto5='$source_name5',status='$status' WHERE ID='$texid'";
$result=@mysql_query($sql,$db);
}
}
}
if (isset($_POST['delete1']) or isset($_POST['delete2']) or isset($_POST['delete3']) or isset($_POST['delete4']) or isset($_POST['delete5'])) {
unset($result);
if (isset($_POST['delete1'])) {@unlink($upath.$photodir.$foto1);
@unlink($upath.$photodir.'s'.$foto1);
$sql="update $restable SET foto1='',status='$status' WHERE ID='$texid'";
$result=@mysql_query($sql,$db);
}
if (isset($_POST['delete2'])) {@unlink($upath.$photodir.$foto2);
@unlink($upath.$photodir.'s'.$foto2);
$sql="update $restable SET foto2='',status='$status' WHERE ID='$texid'";
$result=@mysql_query($sql,$db);
}
if (isset($_POST['delete3'])) {@unlink($upath.$photodir.$foto3);
@unlink($upath.$photodir.'s'.$foto3);
$sql="update $restable SET foto3='',status='$status' WHERE ID='$texid'";
$result=@mysql_query($sql,$db);
}
if (isset($_POST['delete4'])) {@unlink($upath.$photodir.$foto4);
@unlink($upath.$photodir.'s'.$foto4);
$sql="update $restable SET foto4='',status='$status' WHERE ID='$texid'";
$result=@mysql_query($sql,$db);
}
if (isset($_POST['delete5'])) {@unlink($upath.$photodir.$foto5);
@unlink($upath.$photodir.'s'.$foto5);
$sql="update $restable SET foto5='',status='$status' WHERE ID='$texid'";
$result=@mysql_query($sql,$db);
}
}
}
}
if ($_SERVER[QUERY_STRING] != "add" or $error != "") {
$foto1upl="���� 1: <input type=file name=file1 size=30><br>";
$foto2upl="���� 2: <input type=file name=file2 size=30><br>";
$foto3upl="���� 3: <input type=file name=file3 size=30><br>";
$foto4upl="���� 4: <input type=file name=file4 size=30><br>";
$foto5upl="���� 5: <input type=file name=file5 size=30><br>";
$foto1line="";
$foto2line="";
$foto3line="";
$foto4line="";
$foto5line="";
if ($foto1 != "")
{$foto1line="<td align=center><a href=$photodir$foto1 target=_blank><img src=$domenmainurl/$photodir$foto1 border=0 height=150></a><br><input type=submit name=delete1 value=������� class=i3></td>";
$foto1upl="";
}
if ($foto2 != "")
{$foto2line="<td align=center><a href=$photodir$foto2 target=_blank><img src=$domenmainurl/$photodir$foto2 border=0 height=150></a><br><input type=submit name=delete2 value=������� class=i3></td>";
$foto2upl="";
}
if ($foto3 != "")
{$foto3line="<td align=center><a href=$photodir$foto3 target=_blank><img src=$domenmainurl/$photodir$foto3 border=0 height=150></a><br><input type=submit name=delete3 value=������� class=i3></td>";
$foto3upl="";
}
if ($foto4 != "")
{$foto4line="<td align=center><a href=$photodir$foto4 target=_blank><img src=$domenmainurl/$photodir$foto4 border=0 height=150></a><br><input type=submit name=delete4 value=������� class=i3></td>";
$foto4upl="";
}
if ($foto5 != "")
{$foto5line="<td align=center><a href=$photodir$foto5 target=_blank><img src=$domenmainurl/$photodir$foto5 border=0 height=150></a><br><input type=submit name=delete5 value=������� class=i3></td>";
$foto5upl="";
}
echo ("
<form name=form method=post ENCTYPE=\"multipart/form-data\" action=chanfoto.php?add>
<input type=hidden name=id value=$id>
<input type=hidden name=texid value=$texid>
<input type=hidden name=foto1 value=$foto1>
<input type=hidden name=foto2 value=$foto2>
<input type=hidden name=foto3 value=$foto3>
<input type=hidden name=foto4 value=$foto4>
<input type=hidden name=foto5 value=$foto5>
<table width=90%>
<tr>$foto1line
</tr>
<tr><td align=center colspan=6>&nbsp;</td></tr>
<tr><td align=center colspan=6>
$foto1upl
</td></tr>
</table>
");
echo "<center><p><input type=submit value=\"���������\" name=\"upload\" class=i3></form>";
echo "<p align=center><a href=autor.php>��������� � ������ ������</a></p>";
}
else {
echo "<br><br><h3 align=center>��������� ���������!</h3><center><br><br>$stroka<br><br><a href=chanfoto.php?texid=$texid>� �������������� ����������</a><br><br><p align=center><a href=autor.php>��������� � ������ ������</a></p><br><br>";
$txt="�� ����� $siteadress - �������� ���������� � ������ #$texid";
if ($mailchange == 'TRUE')
{@mail($adminemail,"��������� ����������",$txt,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/plain; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");}
}
echo ("
<center><form method=post action=\"logout.php\">
<input type=submit name=logout value=����� class=i3><br><br>
</form>
");
} //bunip
} //1
echo "</div>";
include("down.php");
?>