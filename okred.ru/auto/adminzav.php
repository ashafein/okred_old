<?
session_start();
session_register("uid");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
include("var.php");
echo "<head><title>Администрирование - Добавление учреждения: $sitename</title>";
include("top.php");
echo "<center><h3>Добавление учреждения</h3>";
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
$maxtitle = 1000;
$maxpreview = 5000;
$maxdetail = 10000;
$err1 = "Укажите название заведения!<br>";
$err22 = "Фотография должна иметь расширение *.jpg либо *.gif<br>";
$err23 = "Фотография должна иметь размер не более $MAX_FILE_SIZE байт!<br>";
$err24 = "Фотография с таким именем уже есть в папке!<br>";
$error = "";
$result = @mysql_query("SELECT pass FROM $admintable");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
if (!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass)
{
echo "<center><b>Вы не <a href=admin.php>авторизированы</a>!</b><br><br>";
}
else
{ // ok
if ($_SERVER[QUERY_STRING] == "add")
{ // add
$name=$_POST['name'];
$comment=$_POST['comment'];
$category=$_POST['category'];
$email=$_POST['email'];
$telephone=$_POST['telephone'];
$adress=$_POST['adress'];
$url=$_POST['url'];

if ($name == "") {$error .= "$err1";}
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
echo "<center><font color=red>$error</font></center>";
if ($_SERVER[QUERY_STRING] == "add" and $error == "") {
$date = date("Y/m/d");
$stroka='<b>Заведение добавлено</b>';
if ($_SERVER[QUERY_STRING] == "add" and $file1 != "" or $file2 != "" or $file3 != "" or $file4 != "" or $file5 != "") {
$updir=$afishadir;
$path1 = $upath."$updir";
$source_name1="";
$source_name2="";
$source_name3="";
$source_name4="";
$source_name5="";
if ($file1 != "") {$source_name1 = "$fileres1";}
if ($file2 != "") {$source_name2 = "$fileres2";}
if ($file3 != "") {$source_name3 = "$fileres3";}
if ($file4 != "") {$source_name4 = "$fileres4";}
if ($file5 != "") {$source_name5 = "$fileres5";}
if($error == ""){
$dest1 = $path1.$source_name1;
$dest2 = $path1.$source_name2;
$dest3 = $path1.$source_name3;
$dest4 = $path1.$source_name4;
$dest5 = $path1.$source_name5;
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
}
}
$sql="insert into $zavtable (name,comment,category,email,telephone,adress,url,date,foto1,foto2,foto3,foto4,foto5) values ('$name','$comment','$category','$email','$telephone','$adress','$url',now(),'$source_name1','$source_name2','$source_name3','$source_name4','$source_name5')";
$result=@mysql_query($sql,$db);
}
} // add
if ($_SERVER[QUERY_STRING] != "add" or $error != "") 
{ // form
echo ("
<script language=\"JavaScript\">
 <!--

function voidPutATag(Tag,Tag2)
{
document.formata.comment.focus();
sel = document.selection.createRange();
sel.text = Tag+sel.text+Tag2;
document.formata.comment.focus();
}

 //-->
</script>
<form name=formata method=post ENCTYPE=\"multipart/form-data\" action=\"adminzav.php?add\">
<table>
<tr><td align=right valign=top>Раздел:</td>
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
<tr><td align=right>Название:</td>
<td><input type=text size=50 name=name value=\"$name\"></td>
</tr>
<tr><td valign=top align=right>Описание:</td>
<td><small>
      <a href=\"javascript: voidPutATag('<b>','</b>')\" title=\"полужирный текст\" class=buten>b</a>
      <a href=\"javascript: voidPutATag('<i>','</i>')\" title=\"курсив\" class=buten>i</a>
      <a href=\"javascript: voidPutATag('<u>','</u>')\" title=\"подчеркивание\" class=buten>u</u>
      <a href=\"javascript: voidPutATag('<center>','</center>')\" title=\"\" class=buten>center</a>
      <a href=\"javascript: voidPutATag('<ul>','</ul>')\" title=\"список\" class=buten>ul</a>
      <a href=\"javascript: voidPutATag('<li>','</li>')\" title=\"элемент списка\" class=buten>li</a>
      <a href=\"javascript: voidPutATag('&laquo;','&raquo;')\" title=\"кавычки\" class=buten>&laquo; &raquo;</a>
      <a href=\"javascript: voidPutATag('\n<br>','\n ')\" title=\"перенос строки\" class=buten>br</a>
      <a href=\"javascript: voidPutATag('\n<p>','\n ')\" title=\"абзац\" class=buten>Абзац</a>
      <a href=\"javascript: voidPutATag('<a href=>','</a>')\" title=\"ссылка\" class=buten>ссылка</a>
</small><br>
<textarea name=comment cols=50 rows=7 wrap=physical>$comment</textarea></td></tr>
<tr><td align=right>Телефон:</td>
<td><input type=text name=telephone size=30 value=\"$telephone\"></td></tr>
<tr><td align=right>Адрес:</td>
<td><input type=text name=adress size=30 value=\"$adress\"></td></tr>
<tr><td align=right>Email:</td>
<td><input type=text name=email size=30 value=\"$email\"></td></tr>
<tr><td align=right>URL:</td>
<td><input type=text name=url size=30 value=\"$url\"></td></tr>
<tr><td align=center colspan=2>
<input type=hidden name=action1 value=1>
ФОТО1: <input type=file name=file1 size=30><br>
ФОТО2: <input type=file name=file2 size=30><br>
ФОТО3: <input type=file name=file3 size=30><br>
ФОТО4: <input type=file name=file4 size=30><br>
ФОТО5: <input type=file name=file5 size=30><br><br>
</td></tr>
</table>
<P><input type=\"submit\" value=\"Добавить\">
</form><br>
<a href=admin.php>На общую страницу администрирования</a>
");
} //form
else {
echo "<center><br><br>$stroka<br><br><a href=adminzav.php>Добавить еще учреждение</a><br><br><a href=admin.php>На общую страницу администрирования</a><br><br>";
}
} // ok
include("down.php");
?>