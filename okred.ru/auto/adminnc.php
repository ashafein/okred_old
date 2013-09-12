<?
session_start();
session_register("uid");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
include("var.php");
echo "<head><title>Администрирование - Правка новостей: $sitename</title>";
include("top.php");
echo "<center><h3>Правка новостей</h3>";
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
$err1 = "Заполните одно из полей (заголовок, краткое описание, подробное описание)!<br>";
$err2 = "Заголовок должен быть не длинее $maxtitle символов<br>";
$err3 = "Краткое описание должно быть не длинее $maxpreview символов<br>";
$err4 = "Подробное описание должно быть не длинее $maxdetail символов<br>";
$err22 = "Фотография должна иметь расширение *.jpg либо *.gif<br>";
$err23 = "Фотография должна иметь размер не более $MAX_FILE_SIZE байт!<br>";
$err24 = "Фотография с таким именем уже есть в папке!<br>";
$error = "";
if ($_GET['id'] == '') {$id=$_POST['id'];}
elseif ($_GET['id'] != '') {$id=$_GET['id'];}
$result = @mysql_query("SELECT pass FROM $admintable");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
if (!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass)
{
echo "<center><b>Вы не <a href=admin.php>авторизированы</a>!</b><br><br>";
}
elseif (!isset($id) or $id=="")
{
echo "<center><b>Позиция не определена. Вернитесь на страницу <a href=adminnd.php>удаления!</a></b><br><br>";
}
else
{ // ok
if ($_SERVER[QUERY_STRING] != "add")
{ //2
$result = @mysql_query("SELECT * FROM $afishatable WHERE ID = '$id'");
while ($myrow=mysql_fetch_array($result)) {
$title=$myrow["title"];
$preview=$myrow["preview"];
$detail=$myrow["detail"];
$hot=$myrow["hot"];
if (!isset($_GET['zav']) or $_GET['zav']=='0') {
$zav=$myrow["zav"];
}
$autor=$myrow["autor"];
$otchet=$myrow["otchet"];
$datum=$myrow["datum"];
$time=$myrow["time"];
$noshow=$myrow["noshow"];
$datumend=$myrow["datumend"];
$category=$myrow["category"];
$source_name1=$myrow["foto1"];
$source_name2=$myrow["foto2"];
$source_name3=$myrow["foto3"];
$source_name4=$myrow["foto4"];
$source_name5=$myrow["foto5"];
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
$time=$_POST['time'];
$datumend=$_POST['datumend'];
$otchet=$_POST['otchet'];
$hot=$_POST['hot'];
$autor=$_POST['autor'];
$noshow=$_POST['noshow'];
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
echo "<center><font color=red>$error</font></center>";
if ($_SERVER[QUERY_STRING] == "add" and $error == "") {
if ($_SERVER[QUERY_STRING] == "add" and $file1 != "" or $file2 != "" or $file3 != "" or $file4 != "" or $file5 != "") {
$updir=$afishadir;
$path1 = $upath."$updir";
if ($file1 != "") {$source_name1="";}
if ($file2 != "") {$source_name2="";}
if ($file3 != "") {$source_name3="";}
if ($file4 != "") {$source_name4="";}
if ($file5 != "") {$source_name5="";}
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
if (isset($zav) and $zav != '' and $zav != '0')
{
$resultadd1 = @mysql_query("SELECT * FROM $zavtable WHERE name='$zav' LIMIT 1");
while($myrow=mysql_fetch_array($resultadd1)) {
$zav=$myrow["ID"];
}
}
$sql="update $afishatable SET category='$category',title='$title',preview='$preview',detail='$detail',hot='$hot',otchet='$otchet',date=now(),datum='$datum',time='$time',datumend='$datumend',foto1='$source_name1',foto2='$source_name2',foto3='$source_name3',foto4='$source_name4',foto5='$source_name5',zav='$zav',autor='$autor',noshow='$noshow' WHERE ID='$id'";
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
<form method=post ENCTYPE=\"multipart/form-data\" action=\"adminnc.php?add\" name=formata>
<input type=hidden name=id value=$id>
<input type=hidden name=source_name1 value=$source_name1>
<input type=hidden name=source_name2 value=$source_name2>
<input type=hidden name=source_name3 value=$source_name3>
<input type=hidden name=source_name4 value=$source_name4>
<input type=hidden name=source_name5 value=$source_name5>
<table>
<tr><td align=right valign=top>Дата события:</td>
<td valign=top><input type=text name=datum value=\"$datum\"><br><small>ГГГГ-ММ-ДД</small></td>
</tr>
<tr><td align=right valign=top>Время события:</td>
<td valign=top><input type=text name=time value=\"$time\"></td>
</tr>
<tr><td align=right valign=top>Дата окончания:</td>
<td valign=top><input type=text name=datumend value=\"$datumend\"><br><small>ГГГГ-ММ-ДД</small></td>
</tr>
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
<tr><td align=right>Заголовок:</td>
<td><input type=text size=50 name=title value=\"$title\"></td>
</tr>
<tr><td valign=top align=right>Краткое описание:</td>
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
      <a href=\"javascript: voidPutATag('<img src=$afishadir/.jpg class=image align=left alt=&#34;&#34;>','')\" title=\"картинка слева текста\" class=buten>картинка слева</a>
      <a href=\"javascript: voidPutATag('<img src=$afishadir/.jpg class=image align=right alt=&#34;&#34;>','')\" title=\"картинка справа текста\" class=buten>картинка справа</a>
</small><br>
<textarea name=preview cols=50 rows=7 wrap=physical>$preview</textarea></td></tr>
<tr><td valign=top align=right>Подробное описание:</td>
<td>
<small>
      <a href=\"javascript: voidPutATag2('<b>','</b>')\" title=\"полужирный текст\" class=buten>b</a>
      <a href=\"javascript: voidPutATag2('<i>','</i>')\" title=\"курсив\" class=buten>i</a>
      <a href=\"javascript: voidPutATag2('<u>','</u>')\" title=\"подчеркивание\" class=buten>u</u>
      <a href=\"javascript: voidPutATag2('<center>','</center>')\" title=\"\" class=buten>center</a>
      <a href=\"javascript: voidPutATag2('<ul>','</ul>')\" title=\"список\" class=buten>ul</a>
      <a href=\"javascript: voidPutATag2('<li>','</li>')\" title=\"элемент списка\" class=buten>li</a>
      <a href=\"javascript: voidPutATag2('&laquo;','&raquo;')\" title=\"кавычки\" class=buten>&laquo; &raquo;</a>
      <a href=\"javascript: voidPutATag2('\n<br>','\n ')\" title=\"перенос строки\" class=buten>br</a>
      <a href=\"javascript: voidPutATag2('\n<p>','\n ')\" title=\"абзац\" class=buten>Абзац</a>
      <a href=\"javascript: voidPutATag2('<a href=>','</a>')\" title=\"ссылка\" class=buten>ссылка</a>
      <a href=\"javascript: voidPutATag2('<img src=$afishadir/.jpg class=image align=left alt=&#34;&#34;>','')\" title=\"картинка слева текста\" class=buten>картинка слева</a>
      <a href=\"javascript: voidPutATag2('<img src=$afishadir/.jpg class=image align=right alt=&#34;&#34;>','')\" title=\"картинка справа текста\" class=buten>картинка справа</a>
</small><br>
<textarea name=detail cols=50 rows=7 wrap=physical>$detail</textarea></td></tr>
<tr><td align=right valign=top>Место проведения:</td>
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
<tr><td align=right>Автор:</td>
<td><input type=text size=50 name=autor value=\"$autor\"></td>
</tr>
<tr><td align=right>Будет отчет:</td>
<td><input type=checkbox name=otchet value=checked $otchet></td>
</tr>
<tr><td align=right>Горячая новость:</td>
<td><input type=checkbox name=hot value=checked $hot></td>
</tr>
<tr><td align=right>Не показывать на главной:</td>
<td><input type=checkbox name=noshow value=checked $noshow></td>
</tr>
<tr><td align=center colspan=2>
<input type=hidden name=action1 value=1>
ФОТО1: <input type=file name=file1 size=30><br>
ФОТО2: <input type=file name=file2 size=30><br>
ФОТО3: <input type=file name=file3 size=30><br>
ФОТО4: <input type=file name=file4 size=30><br>
ФОТО5: <input type=file name=file5 size=30><br><br>
</td></tr>
</table>
");
echo "<center><p><input type=submit value=\"Изменить\" name=\"submit\"></form>";
echo "<center><a href=adminnd.php>Вернуться на страницу удаления</a><br><br><a href=admin.php>На общую страницу администрирования</a><br><br>";
}
else {
echo "<b>Изменения сохранены!</b><br><br><a href=adminnd.php>Вернуться на страницу удаления</a><br><br><a href=admin.php>На общую страницу администрирования</a><br><br>";
}
} // ok
include("down.php");
?>