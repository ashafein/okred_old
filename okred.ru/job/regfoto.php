<?
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
include("var.php");
echo"<title>Управление фотографиями : $sitename</title>";
include("top.php");
echo "<div class=tbl1>";
?>
<h3><center><strong>Управление фотографиями</strong></center></h3>
<?php
if ($_FILES['file1']['name'] == 'none') {$file1 = '';}
if ($_FILES['file1']['name'] != '') {$file1 = $_FILES['file1']['name'];}
if ($_FILES['file2']['name'] == 'none') {$file2 = '';}
if ($_FILES['file2']['name'] != '') {$file2 = $_FILES['file2']['name'];}
$sid=$_SESSION['sid'];
$id=$_SESSION['sid'];
$slogin=$_SESSION['slogin'];
$spass=$_SESSION['spass'];
$err22 = "Фотография должна иметь расширение *.jpg либо *.gif<br>";
$err23 = "Фотография должна иметь размер не более $MAX_FILE_SIZE байт.<br>";
$err4 = "Не указан путь к фотографии.<br>";
$error = "";
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
$result = @mysql_query("SELECT email,pass,category FROM $autortable WHERE (email = '$slogin' and pass = '$spass')");
if ((!isset($slogin) or !isset($spass)) or @mysql_num_rows($result) == 0){
	echo "<center><br><br><h3>Вы не авторизированы!</h3><b><a href=autor.php>Авторизация</a></b>";}
else
	{//0
		while($myrow=mysql_fetch_array($result)) {
			$who=$myrow["category"];
		}
		if ($_SERVER[QUERY_STRING] != "add")
		{ //2
			$result = @mysql_query("SELECT ID,foto1,foto2 FROM $autortable WHERE ID = '$id'");
			while ($myrow=mysql_fetch_array($result)) {
				$foto1=$myrow["foto1"];
				$foto2=$myrow["foto2"];
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
			if (isset($_POST['upload']) and $file1 == "" and $file2 == "") {$error .= "$err4";}
			echo "<center><font color=red>$error</font></center>";
			if ($_SERVER[QUERY_STRING] == "add" and $error == "") {
				if (isset($_POST['upload'])) {
					$fid=$id;
					$updir=$photodir;
					$path1 = $upath."$updir";
					$fileres1=@substr($fileres1,-3,3);
					$fileres2=@substr($fileres2,-3,3);
					$source_name1="";
					$source_name2="";
					if ($file1 != "") {$source_name1 = "a".$fid."_1.$fileres1";}
					if ($file2 != "") {$source_name2 = "a".$fid."_2.$fileres2";}
					if($error == ""){
						$dest1 = $path1.$source_name1;
						$dest2 = $path1.$source_name2;
						if ($file1 != "") {
							@copy("$temp1","$dest1");$foto1=$updir."$source_name1";
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
								}
							} //small img
							$sql="update $autortable SET foto1='$source_name1' WHERE ID='$id'";
							$result=@mysql_query($sql,$db);
						}
						if ($file2 != "") {
							@copy("$temp2","$dest2");$foto2=$updir."$source_name2";
							if (function_exists('ImageTypes')) {
								if ((ImageTypes() & IMG_JPG and $fileres2=='jpg') or (ImageTypes() & IMG_GIF and $fileres2=='gif'))
								{ //small img
									if ($fileres2=='jpg') {$image = ImageCreateFromJPEG($foto2);}
									if ($fileres2=='gif') {$image = ImageCreateFromGIF($foto2);}
									$width = imagesx($image) ;
									$height = imagesy($image) ;
									if ($height > $smalllogoheight) {$new_height = $smalllogoheight;}
										elseif ($height <= $smalllogoheight) {$new_height = $height;}
									$new_width = ($new_height * $width) / $height ;
									$thumb = imagecreate($new_width,$new_height);
									$thumb = ImageCreateTrueColor($new_width,$new_height);
									imagecopyresized($thumb,$image,0,0,0,0,$new_width,$new_height,$width,$height);
									if ($fileres2=='jpg') {ImageJPEG($thumb, $updir.'s'.$source_name2);}
									if ($fileres2=='gif') {ImageGIF($thumb, $updir.'s'.$source_name2);}
								}
							} //small img
						$sql="update $autortable SET foto2='$source_name2' WHERE ID='$id'";
						$result=@mysql_query($sql,$db);
						}
					}
				}
				if (isset($_POST['delete1']) or isset($_POST['delete2'])) {
					unset($result);
					if (isset($_POST['delete1'])) {@unlink($upath.$photodir.$foto1);
						@unlink($upath.$photodir.'s'.$foto1);
						$sql="update $autortable SET foto1='' WHERE ID='$id'";
						$result=@mysql_query($sql,$db);
					}
					if (isset($_POST['delete2'])) {
						@unlink($upath.$photodir.$foto2);
						@unlink($upath.$photodir.'s'.$foto2);
						$sql="update $autortable SET foto2='' WHERE ID='$id'";
						$result=@mysql_query($sql,$db);
					}
				}
			}
		}
		if ($_SERVER[QUERY_STRING] != "add" or $error != "") {
			$foto1upl="Фото : <input type=file name=file1 size=30><br>";
			$foto2upl="Логотип: <input type=file name=file2 size=30><br>";
			$foto1line="";
			$foto2line="";
			if ($foto1 != ""){
				$foto1line="<td align=center><a href=$photodir$foto1 target=_blank><img src=$photodir$foto1 border=0 height=150></a><br><input type=submit name=delete1 value=Удалить class=i3></td>";
				$foto1upl="";
			}
			if ($foto2 != ""){
				$foto2line="<td align=center><a href=$photodir$foto2 target=_blank><img src=$photodir$foto2 border=0 height=150></a><br><input type=submit name=delete2 value=Удалить class=i3></td>";
				$foto2upl="";
			}
			echo ("
<form name=form method=post ENCTYPE=\"multipart/form-data\" action=regfoto.php?add>
<input type=hidden name=id value=$id>
<input type=hidden name=foto1 value=$foto1>
<input type=hidden name=foto2 value=$foto2>
<table width=90%>
<tr>$foto1line
$foto2line
</tr>
<tr><td align=center colspan=6>&nbsp;</td></tr>
<tr><td align=center colspan=6>
");
			if ($who == 'soisk' or $who=='freelanc') {echo "$foto1upl";}
			if ($who == 'agency' or $who == 'rab') {echo "$foto2upl";}
			echo ("
</td></tr>
</table>
");
			echo "<center><p><input type=submit value=\"Загрузить\" name=\"upload\" class=i3></form>";
			echo "<p align=center><a href=autor.php>Вернуться в личный раздел</a></p>";
		}
		else {
			echo "<br><br><h3 align=center>Изменения сохранены!</h3><center><br><br><a href=regfoto.php>К редактированию фотографий</a><p align=center><a href=autor.php>Вернуться в личный раздел</a></p><br><br>";
		}
		echo ("
<center><form method=post action=\"logout.php\">
<input type=submit name=logout value=Выход class=i3><br><br>
</form>
");
} //1
echo "</div>";
include("down.php");
?>