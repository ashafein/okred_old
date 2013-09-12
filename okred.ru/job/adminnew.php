<?
session_start();
session_register("uid");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
include("var.php");
echo "<head><title>Администрирование - Добавление афиши: $sitename</title>";
include("top.php");
echo "<center><h3>Добавление афиши</h3>";
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
$date = date("Y/m/d");
$stroka='<b>Новость добавлена</b>';
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
if (isset($zav) and $zav != '' and $zav != '0')
{
$resultadd1 = @mysql_query("SELECT * FROM $zavtable WHERE name='$zav' LIMIT 1");
while($myrow=mysql_fetch_array($resultadd1)) {
$zav=$myrow["ID"];
}
}
$sql="insert into $afishatable (category,title,preview,detail,date,datum,time,datumend,foto1,foto2,foto3,foto4,foto5,otchet,hot,zav,autor,noshow) values ('$category','$title','$preview','$detail',now(),'$datum','$time','$datumend','$source_name1','$source_name2','$source_name3','$source_name4','$source_name5','$otchet','$hot','$zav','$autor','$noshow')";
$result=@mysql_query($sql,$db);

// rassilka
if ($sendno != 'checked')
{ // sendno

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

//очистка
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
$daylong   = date("l",mktime(1,1,1,$month,$today,$year)); //день недели текст англ.
$monthlong = date("F",mktime(1,1,1,$month,$today,$year)); //название месяца англ.
$dayone    = date("w",mktime(1,1,1,$month,1,$year)); //день недели цифрой
$numdays   = date("t",mktime(1,1,1,$month,1,$year)); //количество дней в месяце
$alldays   = array('Пн','Вт','Ср','Чт','Пт','<font color=red>Сб</font>','<font color=red>Вс</font>');
$next_year = $year + 1;
$last_year = $year - 1;
$next_month = $month + 1;
$last_month = $month - 1;
if ($today > $numdays) { $today--; }
        if($month == "1" ){$month_ru="январь";}
    elseif($month == "2" ){$month_ru="февраль";}
    elseif($month == "3" ){$month_ru="март";}
    elseif($month == "4" ){$month_ru="апрель";}
    elseif($month == "5" ){$month_ru="май";}
    elseif($month == "6" ){$month_ru="июнь";}
    elseif($month == "7" ){$month_ru="июль";}
    elseif($month == "8" ){$month_ru="август";}
    elseif($month == "9" ){$month_ru="сентябрь";}
    elseif($month == "10"){$month_ru="октябрь";}
    elseif($month == "11"){$month_ru="ноябрь";}
    elseif($month == "12"){$month_ru="декабрь";}

        if($month == "1" ){$month_rus="января";}
    elseif($month == "2" ){$month_rus="февраля";}
    elseif($month == "3" ){$month_rus="марта";}
    elseif($month == "4" ){$month_rus="апреля";}
    elseif($month == "5" ){$month_rus="мая";}
    elseif($month == "6" ){$month_rus="июня";}
    elseif($month == "7" ){$month_rus="июля";}
    elseif($month == "8" ){$month_rus="августа";}
    elseif($month == "9" ){$month_rus="сентября";}
    elseif($month == "10"){$month_rus="октября";}
    elseif($month == "11"){$month_rus="ноября";}
    elseif($month == "12"){$month_rus="декабря";}

$sql_date = $year."-".$month."-".$today;
$body = '<p align=justify>';

       $result = mysql_query("select * from $afishatable where (datum >= '".$sql_date."' or (datumend != '0000-00-00' and datumend >= '".$sql_date."')) and noshow != 'checked' order by date desc LIMIT $sendcount");
       $rows = mysql_num_rows($result);

for($k=0;$k < $rows;$k++)
   {
    $preview=mysql_result($result, $k , "preview");
    $detail=mysql_result($result, $k , "detail");
    $title=mysql_result($result, $k , "title");
    $idnum=mysql_result($result, $k , "ID");
    $datum=mysql_result($result, $k , "datum");
    $datumend=mysql_result($result, $k , "datumend");
    $foto1=mysql_result($result, $k , "foto1");
    $dati=explode("-",$datum);
if ($preview != "") {
$preview = ereg_replace("\n","<br>",$preview);
$preview = ereg_replace("     ","&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$preview);
if (eregi('ФОТО1',$preview) and $foto1 != ""){$preview=@str_replace('ФОТО1',"",$preview);}
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
$body .= "$dati[2].$dati[1].$dati[0]&nbsp;&nbsp;&nbsp;<br><big><b>$title</b></big><br>$preview<br><a href=\"$siteadress/afisha.php?link=$idnum&year=$dati[0]&today=$dati[2]&month=$dati[1]\">Подробнее</a>&nbsp;&raquo;<br><br>";
}
elseif($preview != "" and $detail == "")
{
$body .= "$dati[2].$dati[1].$dati[0]&nbsp;&nbsp;&nbsp;<br><big><b>$title</b></big><br>$preview<br><br>";
}
 }
$body .= "<a href=$siteadress/afisha.php>Посмотреть все события</a>&nbsp;&raquo;</p>";


$resl2 = @mysql_query("SELECT email FROM $emailr WHERE email != ''");
while ($myrow=mysql_fetch_array($resl2)) 
{
$rassemail=$myrow["email"];
$txtdown = "<table width=100% border=0 class=text><tr><td><small>$sitename<br><a href=$siteadress>$siteadress</a></small></td><td align=right valign=top><a href=\"$siteadress/unsubscr.php?email=$rassemail\"><small>отписАться</small></a></td></tr></table>";
$txt=$body.$txtdown;
@mail($rassemail,"$title - $sitename",$txt,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/html; charset=windows-1251\nContent-Transfer-Encoding:8bit\n",'-f$adminemail');
}
$sql1="update $rassilka SET afisha=0 WHERE name='admin'";
$resl3=@mysql_query($sql1,$db);
} //full
} //ras

} // sendno
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
<form name=formata method=post ENCTYPE=\"multipart/form-data\" action=\"adminnew.php?add\">
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
<tr><td align=right>Не участвовать в рассылке:</td>
<td><input type=checkbox name=sendno value=checked></td>
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
<P><input type=\"submit\" value=\"Добавить\">
</form><br>
<a href=admin.php>На общую страницу администрирования</a>
");
} //form
else {
echo "<center><br><br>$stroka<br><br><a href=adminnew.php>Добавить еще новость</a><br><br><a href=admin.php>На общую страницу администрирования</a><br><br>";
}
} // ok
include("down.php");
?>