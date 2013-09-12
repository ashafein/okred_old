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
echo"<title>Управление фотографиями : $sitename</title>";
include("top.php");
?>
<h3><center><strong>Управление фотографиями</strong></center></h3>
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
if ($_GET['texid'] == '') {$texid=$_POST['texid'];}
elseif ($_GET['texid'] != '') {$texid=$_GET['texid'];}
$err22 = "Фотография должна иметь расширение *.jpg либо *.gif<br>";
$err23 = "Фотография должна иметь размер не более $MAX_FILE_SIZE байт.<br>";
$err4 = "Не указан путь к фотографии.<br>";
$error = "";
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
$result = @mysql_query("SELECT pass FROM $admintable");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
if (!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass)
{
if (isset($texid))
{echo "<center><b>Вы не <a href=admin.php>авторизированы</a>!</b><br><br>";}
if (!isset($texid))
{echo "<center><br><br><h3>Объявление не определено!</h3><b><a href=admin.php>Вернуться</a></b>";}
}
else
{ // ok
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
if (isset($_POST['upload']) and $file1 == "" and $file2 == "" and $file3 == "" and $file4 == "" and $file5 == "") {$error .= "$err4";}
echo "<center><font color=red>$error</font></center>";
if ($_SERVER[QUERY_STRING] == "add" and $error == "") {
$status='ok';
if (isset($_POST['upload'])) {
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
}
}
if (isset($_POST['delete1']) or isset($_POST['delete2']) or isset($_POST['delete3']) or isset($_POST['delete4']) or isset($_POST['delete5'])) {
unset($result);
if (isset($delete1)) {@unlink($upath.$photodir.$foto1);
@unlink($upath.$photodir.'s'.$foto1);
$sql="update $restable SET foto1='',status='$status' WHERE ID='$texid'";
$result=@mysql_query($sql,$db);
}
if (isset($delete2)) {@unlink($upath.$photodir.$foto2);
@unlink($upath.$photodir.'s'.$foto2);
$sql="update $restable SET foto2='',status='$status' WHERE ID='$texid'";
$result=@mysql_query($sql,$db);
}
if (isset($delete3)) {@unlink($upath.$photodir.$foto3);
@unlink($upath.$photodir.'s'.$foto3);
$sql="update $restable SET foto3='',status='$status' WHERE ID='$texid'";
$result=@mysql_query($sql,$db);
}
if (isset($delete4)) {@unlink($upath.$photodir.$foto4);
@unlink($upath.$photodir.'s'.$foto4);
$sql="update $restable SET foto4='',status='$status' WHERE ID='$texid'";
$result=@mysql_query($sql,$db);
}
if (isset($delete5)) {@unlink($upath.$photodir.$foto5);
@unlink($upath.$photodir.'s'.$foto5);
$sql="update $restable SET foto5='',status='$status' WHERE ID='$texid'";
$result=@mysql_query($sql,$db);
}
}
}
}
if ($_SERVER[QUERY_STRING] != "add" or $error != "") {
$foto1upl="Фото : <input type=file name=file1 size=30><br>";
$foto1line="";
if ($foto1 != "")
{$foto1line="<td align=center><a href=$photodir$foto1 target=_blank><img src=$photodir$foto1 border=0 height=150></a><br><input type=submit name=delete1 value=Удалить class=i3></td>";
$foto1upl="";
}
echo ("
<form name=form method=post ENCTYPE=\"multipart/form-data\" action=admincf.php?add>
<input type=hidden name=id value=$id>
<input type=hidden name=r value=$r>
<input type=hidden name=texid value=$texid>
<input type=hidden name=foto1 value=$foto1>
<table width=90%>
<tr>$foto1line
</tr>
<tr><td align=center colspan=6>&nbsp;</td></tr>
<tr><td align=center colspan=6>
$foto1upl
</td></tr>
</table>
");
echo "<center><p><input type=submit value=\"Загрузить\" name=\"upload\"></form>";
echo "<p align=center><a href=admin.php>На страницу администрирования</a></p>";
}
else {
echo "<br><br><h3 align=center>Изменения сохранены!</h3><center><br><br><a href=admin.php>Вернуться</a><br><br>";
}
} //ok
echo "<center><a href=admin.php>На общую страницу администрирования</a><br><br>";
include("down.php");
?>