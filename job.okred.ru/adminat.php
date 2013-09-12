<?
session_start();
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
echo"<title>Добавление статьи : $sitename</title>";
include("top.php");
echo "<div class=tbl1>";
?>
<h3><center><strong>Добавление статьи</strong></center></h3>
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

$maxtitle = 100;
$maxtheme = 100;
$maxpreview = 400;
$maxitemsize = $maxitemsize * 1000;
$err1 = "Название статьи должно быть не длинее $maxtitle символов<br>";
$err2 = "Тема статьи должна быть не длинее $maxtheme символов<br>";
$err3 = "Краткое описание должно быть не длинее $maxpreview символов<br>";
$err4 = "Не заполнено обязательное поле - Название!<br>";
$err5 = "Не заполнено обязательное поле - Жанр!<br>";
$err6 = "Не заполнено обязательное поле - Текст статьи!<br>";
$err7 = "Текст статьи должен быть не длинее $maxitemsize символов!<br>";
$err9 = "Не заполнено обязательное поле - Краткое описание!<br>";
$err22 = "Фотография должна иметь расширение *.jpg либо *.gif<br>";
$err23 = "Фотография должна иметь размер не более $MAX_FILE_SIZE байт!<br>";
$error = "";
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
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
if ($_SERVER[QUERY_STRING] == "add") {

$title=$_POST['title'];
$theme=$_POST['theme'];
$preview=$_POST['preview'];
$genre=$_POST['genre'];
$text=$_POST['text'];

if (strlen($title) > $maxtitle) {$error .= "$err1";}
if (strlen($theme) > $maxtheme) {$error .= "$err2";}
if (strlen($preview) > $maxpreview) {$error .= "$err3";}
if (strlen($text) > $maxitemsize) {$error .= "$err7";}
if ($title == "") {$error .= "$err4";}
if ($genre == "") {$error .= "$err5";}
if ($text == "") {$error .= "$err6";}
if ($preview == "") {$error .= "$err9";}
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
echo "<center><font color=red>$error</font></center>";
function untag ($string) {
$string = ereg_replace('\\\"',"&quot;",$string);
$string = ereg_replace(":","&#58;",$string);
$string = ereg_replace("!","&#33;",$string);
$string = ereg_replace("%","&#37;",$string);
$string = ereg_replace("^ +","",$string);
$string = ereg_replace(" +$","",$string);
$string = ereg_replace(" +"," ",$string);
return $string;
}
$title = untag($title);
$theme = untag($theme);
$preview = untag($preview);
$text = untag($text);
if ($_SERVER[QUERY_STRING] == "add" and $error == "") {
$size=strlen($text)/1000;
if ($size < 0.01) {$size=0.01;}
$date = date("Y/m/d H:i:s");
if ($_SERVER[QUERY_STRING] == "add" and $file1 != "" or $file2 != "" or $file3 != "" or $file4 != "" or $file5 != "") {
$result1 = @mysql_query("SELECT * FROM $textable order by ID DESC LIMIT 1");
while ($myrow=@mysql_fetch_array($result1)) 
{
$fid=$myrow["ID"];
}
$fid=$fid+1;
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
if ($file1 != "") {$source_name1 = "t".$fid."_1.$fileres1";}
if ($file2 != "") {$source_name2 = "t".$fid."_2.$fileres2";}
if ($file3 != "") {$source_name3 = "t".$fid."_3.$fileres3";}
if ($file4 != "") {$source_name4 = "t".$fid."_4.$fileres4";}
if ($file5 != "") {$source_name5 = "t".$fid."_5.$fileres5";}
if($error == ""){
$dest1 = $path1.$source_name1;
$dest2 = $path1.$source_name2;
$dest3 = $path1.$source_name3;
$dest4 = $path1.$source_name4;
$dest5 = $path1.$source_name5;
if ($file1 != "") {@copy("$temp1","$dest1");$foto1=$updir."$source_name1";}
if ($file2 != "") {@copy("$temp2","$dest2");$foto2=$updir."$source_name2";}
if ($file3 != "") {@copy("$temp3","$dest3");$foto3=$updir."$source_name3";}
if ($file4 != "") {@copy("$temp4","$dest4");$foto4=$updir."$source_name4";}
if ($file5 != "") {@copy("$temp5","$dest5");$foto5=$updir."$source_name5";}
}
}
$status='ok';
$stroka='<b>В течение нескольких минут статья будет доступна для чтения</b>';
$sql="insert into $textable (title,genre,theme,size,preview,text,foto1,foto2,foto3,foto4,foto5,date,status) values ('$title','$genre','$theme','$size','$preview','$text','$source_name1','$source_name2','$source_name3','$source_name4','$source_name5',now(),'$status')";
$result=@mysql_query($sql,$db);
}
}
if ($_SERVER[QUERY_STRING] != "add" or $error != "") {
echo ("
<p><center><strong>Обязательные поля отмечены символом <font color=#FF0000>*</font></strong></p>
<form name=formata method=post ENCTYPE=multipart/form-data action=adminat.php?add>
<table width=90% bgcolor=$maincolor class=tbl1>
<tr bgcolor=$altcolor><td align=right width=60%><strong><font color=#FF0000>*</font>Название:</strong></td>
<td width=60%><input type=text name=title size=50 value=\"$title\"></td></tr>
<tr bgcolor=$altcolor><td align=right valign=top bgcolor=$maincolor><strong><font color=#FF0000>*</font>Жанр:</strong><br></td>
<td align=left><select name=genre size=1>
<option selected value=\"$genre\">$genre</option>
");
$result3 = @mysql_query("SELECT * FROM $textcatable WHERE genre != '' order by genre");
while($myrow=mysql_fetch_array($result3)) {
$genre=$myrow["genre"];
echo "<option value=\"$genre\">$genre</option>";
}
echo ("
</select></td></tr>
<tr bgcolor=$altcolor><td align=right width=60%><strong>Тема:</strong></td>
<td width=60%><input type=text name=theme size=50 value=\"$theme\"></td></tr>
<tr bgcolor=$altcolor><td align=right width=60% bgcolor=$maincolor><strong><font color=#FF0000>*</font>Краткое описание:</strong></td>
<td width=60%><textarea rows=2 name=preview cols=43>$preview</textarea></td></tr>
<tr bgcolor=$altcolor><td align=right valign=top><strong><font color=#FF0000>*</font>Текст статьи:<br><br>Для вставки в текст фотографии напишите в нужном месте сочетание ФОТОx, где x - номер фото (максимум пять фото, например ФОТО3). Обязательно заглавными буквами. После этого, в следующем поле, выберите необходимую фотографию для загрузки.</strong></td>
<td>
");

?>

<script>
//Здесь мы оперделяем какой у нас браузер это по идеи и присваиваем занчению Q true если есть выделение текста и false если нет
if (document.selection||document.getSelection) {Q=true} else {var Q=false} 
//определяем переменную
var txt=''
//функция копирования
function copyQ(Tag,Tag2) { 
//снова определяем переменную
txt='' 
//условия на браузер и присвоение переменной txt содержимого выбранного
if (document.getSelection) {txt=document.getSelection()} 
else if (document.selection) {txt=document.selection.createRange().text;} 
//здесь обрамляем в теги и переприсваиваем
txt=Tag+txt+Tag2
}

//function pasteQ(){if(document.postform.post)document.postform.post.value += txt} 
//функция setCaret я так понимаю она присваивает значению textObj текстовый формат с дублированием выделенного фрагмента это  так ?
function setCaret (textObj) { 
if (textObj.createTextRange) { 
textObj.caretPos = document.selection.createRange().duplicate(); 
} 
} 

//Функция вставки текста textObj- это то что было выделенно, а textFieldValue - это куда передаем наш выделенный текст
function insertAtCaret (textObj, textFieldValue) { 
if(document.all){ 
// Вот тут не понял немного что это за условие if (textObj.createTextRange && textObj.caretPos && !window.opera) я так думаю что это определение браузера
if (textObj.createTextRange && textObj.caretPos && !window.opera) { 
var caretPos = textObj.caretPos; //здесь присваиваем caretPos выделенный текст 
//тут навреное определяется что можно вставлять куда угодно тоесть где располагается курсор
caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ?textFieldValue + ' ' : textFieldValue; 
}else{ 
textObj.value += textFieldValue; //иначе просто добавляем последним
} 
}else{ 
//Это я думаю выборка для оперы или нет
if(textObj.selectionStart){ 
var rangeStart = textObj.selectionStart; 
var rangeEnd = textObj.selectionEnd; 
var tempStr1 = textObj.value.substring(0,rangeStart); 
var tempStr2 = textObj.value.substring(rangeEnd, textObj.value.length); 
textObj.value = tempStr1 + textFieldValue + tempStr2; 
textObj.selectionStart=textObj.selectionEnd=rangeStart+textFieldValue.length;
}else{ 
textObj.value+=textFieldValue; 
} 
} 
}

//функция вставки
function pasteQ(){
//если txt не пустой и ??? то вставляем в поле тексареа наш txt
if (txt!='' && document.getElementById('post')) 
insertAtCaret(document.getElementById("post"),txt); 
} 


function link(a){
var url = "[url="+topic_url+a+"]"+topic_title+"[/url]";
prompt('Скопируйте текст.', url);
}
</script>

      <a onmouseover="copyQ('<b>','</b>');" href="javascript:pasteQ();" title="полужирный текст" class=buten>b</a>
      <a onmouseover="copyQ('<i>','</i>');" href="javascript:pasteQ();" title="курсив" class=buten>i</a>
      <a onmouseover="copyQ('<u>','</u>');" href="javascript:pasteQ();" title="подчеркивание" class=buten>u</u>
      <a onmouseover="copyQ('<center>','</center>');" href="javascript:pasteQ();" title="" class=buten>center</a>
      <a onmouseover="copyQ('<ul>','</ul>');" href="javascript:pasteQ();" title="список" class=buten>ul</a>
      <a onmouseover="copyQ('<li>','</li>');" href="javascript:pasteQ();" title="элемент списка" class=buten>li</a>
      <a onmouseover="copyQ('&laquo;','&raquo;');" href="javascript:pasteQ();" title="кавычки" class=buten>&laquo; &raquo;</a>
      <a onmouseover="copyQ('\n<br>','\n ');" href="javascript:pasteQ();" title="перенос строки" class=buten>br</a>
      <a onmouseover="copyQ('\n<p>','\n ');" href="javascript:pasteQ();" title="абзац" class=buten>Абзац</a>
      <a onmouseover="copyQ('<a href=>','</a>');" href="javascript:pasteQ();" title="ссылка" class=buten>ссылка</a>
<?
echo ("
<textarea rows=15 name=text cols=43 style=\"height: 250px; width: 100%; padding: 5px;\" id=\"post\" onselect=\"setCaret(this);\" onclick=\"setCaret(this);\" onkeyup=\"setCaret(this);\">$text</textarea><br><small><b>Примечание:</b> html-символы не используются</small></td></tr>
");
if ($phototrue=='TRUE')
{
echo
("
<tr $altcolor><td colspan=2 valign=top>
<hr width=90% size=1><p align=justify>Вы можете разместить до пяти фотографий. Для размещения своей фотографии, нажмите кнопку \"Обзор\" и выберите фотографию.<br><b>Примечание: Фотография обязательно должна иметь расширение *.jpg либо *.gif и иметь размер не более $MAX_FILE_SIZE байт.!</b></p>
<hr width=90% size=1></td></tr>
<tr bgcolor=$altcolor><td align=center colspan=2>
<input type=hidden name=action1 value=1>
ФОТО1: <input type=file name=file1 size=30><br>
ФОТО2: <input type=file name=file2 size=30><br>
ФОТО3: <input type=file name=file3 size=30><br>
ФОТО4: <input type=file name=file4 size=30><br>
ФОТО5: <input type=file name=file5 size=30><br><br>
</td></tr>
");
}
echo ("
<tr bgcolor=$altcolor><td colspan=2>&nbsp;</td></tr>
<tr bgcolor=$altcolor><td colspan=2 align=center>
");
echo "<input type=submit value=\"Добавить\" name=\"submit\"></td></tr></table></form>";
}
else {
echo "<br><br><h3 align=center>Статья добавлена!</h3><br><br>$stroka<br><br>";
}
}// ok
echo "<center><a href=admin.php>На общую страницу администрирования</a><br><br>";
echo "</div>";
include("down.php");
?>