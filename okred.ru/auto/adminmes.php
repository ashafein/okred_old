<?
session_start();
?>
<!--/***************** DO NOT REMOVE! *********************/---->
<!--/*   Author: Nevezhyn Evgeny  Date : 25/02/2003       */---->
<!--/*   nevius@bk.ru      All Rights Reserved ...        */---->
<!--/*   http://nevius.ru/                                */---->
<!--/***************** DO NOT MODIFY! *********************/---->

<html><head>
<?php
include("var.php");
$maxThr=10;
echo"<title>Сообщения : $sitename</title>";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\"><META HTTP-EQUIV=\"Cache-Control\" CONTENT=\"No-Cache\">";
include("top.php");
echo "<h3 align=center>Сообщения</h3>";
$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);
$sid=$_SESSION['sid'];
$slogin=$_SESSION['slogin'];
$spass=$_SESSION['spass'];
if ($_GET['link'] == '') {$link=$_POST['link'];}
elseif ($_GET['link'] != '') {$link=$_GET['link'];}
if ($_FILES['file1']['name'] == 'none') {$file1 = '';}
if ($_FILES['file1']['name'] != '') {$file1 = $_FILES['file1']['name'];}
$maxcomment = 4000;
$err3 = "Сообщение должно быть не длинее $maxcomment символов<br>";
$err5 = "Не заполнено обязательное поле - Сообщение!<br>";
$err22 = "Фотография должна иметь расширение *.jpg либо *.gif<br>";
$err23 = "Фотография должна иметь размер не более $MAX_FILE_SIZE байт!<br>";
$error="";
if ($sendmessages == 'FALSE')
{
echo "<center><br><br><h3>Личная переписка отключена</h3>";
}
if ($sendmessages == 'TRUE')
{//yes

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

if (!isset($link))
{ //all
$result = @mysql_query("SELECT ID,aid,tid,showed,date FROM $messagetable WHERE aid != '0' and tid = '0' order by showed DESC,date");
$totalThread=@mysql_num_rows($result);
if ($totalThread == 0)
{
echo "<center><br><br><b>Нет сообщений</a></b>";
}
if ($totalThread != 0)
{ //2
while ($myrow=mysql_fetch_array($result))
{
$newaid=$myrow["aid"];
$newID=$myrow["ID"];
if (!@in_array($newaid,$c2)){
$c2[] = $newaid;
$c1[] = $newID;
}
}
unset($result);
$totalThread=count($c1);
$page=$_GET['page'];
if (!isset($page)) {$page = 1;}
$numfrom = count($c1) - ($maxThr * ($page - 1));
$numto = count($c1) - ($maxThr * $page) + 1;
if ($numto < 1) {$numto = 1;}
$pages = (int) ((count($c1) + $maxThr - 1) / $maxThr);
$line = "<B>Страница:</B>&nbsp;&nbsp;<a href=\"adminmes.php?page=1\">&lt;&lt;</a>&nbsp;&nbsp;";
$ppg2=$page-1;
if ($ppg2 > 0) {$line .= "<a href=\"adminmes.php?page=$ppg2\">&lt;</a>&nbsp;&nbsp;";}
for ($k = 1; $k <= $pages; $k++) {
if (($k - $page) < 3 and ($k + 3) > $page)
{
if ($k != $page) {$line .= "<a href=\"adminmes.php?page=$k\"> <small>$k</small> </a>";}
if ($k == $page) {$line .= " <B>$k</B> ";}
}
}
$ppg=$page+1;
if ($ppg <= $pages) {$line .= "&nbsp;&nbsp;<a href=\"adminmes.php?page=$ppg\">&gt;</a>";}
$line .= "&nbsp;&nbsp;<a href=\"adminmes.php?page=$pages\">&gt;&gt;</a>";

echo ("
<table border=0 width=95% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=4 width=100% class=tbl1>
<tr bgcolor=$altcolor><td><b>Контакт</b></td><td><b>Новые</b></td><td><b>Сообщения</b></td></tr>
");
for ($i = $numfrom - 1 ; $i >= $numto - 1; $i--)
{ //i
$result = @mysql_query("SELECT ID,tid,aid,date FROM $messagetable WHERE ID = '$c1[$i]' LIMIT 1");
while ($myrow=mysql_fetch_array($result))
{ //mes
$tid=$myrow["tid"];
$aid=$myrow["aid"];
$showed=$myrow["showed"];
echo "<tr bgcolor=$maincolor><td>";

if ($aid != '0')
{ // анкета, а не администратор
echo ("
<table border=0 width=100% cellspacing=1 cellpadding=2 class=tbl1>
");
$resultank = @mysql_query("SELECT * FROM $autortable WHERE ID='$aid' LIMIT 1");
while ($myrow1=mysql_fetch_array($resultank)) 
{ //4
$ID=$myrow1["ID"];
$firm=$myrow1["firm"];
$fio=$myrow1["fio"];

$country=$myrow1["country"];
$region=$myrow1["region"];
$city=$myrow1["city"];
$citytar=$city;
if ($city=='0') {$citytar=$region;}
if ($region=='0' and $city=='0') {$citytar=$country;}
$resultadd3 = @mysql_query("SELECT * FROM $citytable WHERE ID='$citytar'");
while($myrow2=mysql_fetch_array($resultadd3)) {
$citys=$myrow2["categ"];
if ($city=='0') {$citys=$myrow2["podrazdel"];}
if ($city=='0' and $region=='0') {$citys=$myrow2["razdel"];}
}

$foto=$myrow1["foto2"];
$ankaid=$myrow1["aid"];

if ($foto == '') {$fotourl='';}
if ($foto != '') {$fotourl="<img src=$photodir$foto border=0 alt=\"$firm\" width=100>";}

echo ("
<tr bgcolor=$maincolor><td valign=top align=center width=100><table cellspacing=0 cellpadding=0 class=imagetbl><tr><td><a href=alist.php?link=$ID>$fotourl</a></td></tr></table></td>
<td valign=top align=left>
<b>$firm $fio</b><br>
Город:&nbsp;$citys<br>
</td></tr>
");    
} //4
echo "</table>";
} // анкета, а не администратор

if ($aid == '0')
{ // администратор
echo ("
<table border=0 width=100% cellspacing=1 cellpadding=2 class=tbl1>
");
echo ("
<tr bgcolor=$maincolor><td valign=top align=center><table cellspacing=0 cellpadding=0 class=imagetbl><tr><td><img src=picture/admin.jpg></td></tr></table></td>
<td valign=top align=left>
<b>Администрация сайта</b>
</td></tr>
");    
echo "</table>";

} // администратор


$result12 = @mysql_query("SELECT aid,tid FROM $messagetable WHERE (aid = '$ID' and tid = '0') or (tid = '$ID' and aid = '0')");
$totmes=@mysql_num_rows($result12);
$result12 = @mysql_query("SELECT aid,tid,showed FROM $messagetable WHERE aid = '$ID' and tid = '0' and showed=0");
$totmesnew=@mysql_num_rows($result12);

echo "</td><td>";
if ($totmesnew > 0) {echo "<font color=red><a href=adminmes.php?link=$aid>$totmesnew&nbsp;сообщ.</a></font>";}
echo "</td><td><a href=adminmes.php?link=$aid>$totmes&nbsp;сообщ.</a></td></tr>";
} // mes
} // i
echo "</table></td></tr></table><br>$line<br><br>";
} //2

} //all
else
{// link

echo "<table width=100% class=tbl1><tr><td valign=top bgcolor=#e2e2e2>";

if ($link != '0')
{ // анкета, а не администратор
echo ("
<table border=0 width=100% cellspacing=1 cellpadding=2 class=tbl1>
");
$resultank = @mysql_query("SELECT * FROM $autortable WHERE ID='$link' LIMIT 1");
while ($myrow1=mysql_fetch_array($resultank)) 
{ //4
$ID=$myrow1["ID"];
$firm=$myrow1["firm"];
$fio=$myrow1["fio"];

$country=$myrow1["country"];
$region=$myrow1["region"];
$city=$myrow1["city"];
$citytar=$city;
if ($city=='0') {$citytar=$region;}
if ($region=='0' and $city=='0') {$citytar=$country;}
$resultadd3 = @mysql_query("SELECT * FROM $citytable WHERE ID='$citytar'");
while($myrow2=mysql_fetch_array($resultadd3)) {
$citys=$myrow2["categ"];
if ($city=='0') {$citys=$myrow2["podrazdel"];}
if ($city=='0' and $region=='0') {$citys=$myrow2["razdel"];}
}

$foto=$myrow1["foto2"];
$ankaid=$myrow1["aid"];

if ($foto == '') {$fotourl='';}
if ($foto != '') {$fotourl="<img src=$photodir$foto border=0 alt=\"$firm\" width=100>";}

echo ("
<tr bgcolor=$maincolor><td valign=top align=center width=100><table cellspacing=0 cellpadding=0 class=imagetbl><tr><td><a href=alist.php?link=$ID>$fotourl</a></td></tr></table></td>
<td valign=top align=left>
<b>$firm $fio</b><br>
Город:&nbsp;$citys<br>
</td></tr>
");    
} //4
echo "</table>";
} // анкета, а не администратор

if ($link == '0')
{ // link - админ
echo ("
<table border=0 width=100% cellspacing=1 cellpadding=2 bgcolor=#ffffff class=tbl1>
");
echo ("
<tr bgcolor=$maincolor><td valign=top align=center><table cellspacing=0 cellpadding=0 class=tbl1><tr><td><img src=picture/admin.jpg></td></tr></table></td>
<td valign=top align=left>
<b>Администрация сайта</b>
</td></tr>
");    
echo "</table>";
} // link - админ

echo "</td></tr></table>";

echo "<div style=\"margin:0 0 0 5px;\">";

if (isset($_POST['submit'])){
$comment=$_POST['comment'];
$link=$_POST['link'];
if (strlen($comment) > $maxcomment) {$error .= "$err3";}
if ($comment == "") {$error .= "$err5";}
if ($file1 != "") {
$file1 = $_FILES['file1']['name'];
$filesize1 = $_FILES['file1']['size']; 
$temp1 = $_FILES['file1']['tmp_name'];
$fileres1=strtolower(basename($file1));
if ($file1 != "" and !eregi("\.jpg$",$fileres1) and !eregi("\.gif$",$fileres1)){$error .= "$err22";}
if ($filesize1 > $MAX_FILE_SIZE){$error .= "$err23";}
}
echo "<center><font color=red>$error</font></center>";
function untag ($string) {
$string = ereg_replace("<","&lt;",$string);
$string = ereg_replace(">","&gt;",$string);
$string = ereg_replace('\\\"',"&quot;",$string);
$string = ereg_replace("!","&#33;",$string);
$string = ereg_replace("\r","",$string);
$string = ereg_replace("%","&#37;",$string);
$string = ereg_replace("^ +","",$string);
$string = ereg_replace(" +$","",$string);
$string = ereg_replace(" +"," ",$string);
$string = ereg_replace("&nbsp;"," ",$string);
return $string;
}
if ($error == "") {
$comment = untag($comment);
$date = date("Y/m/d");

if ($file1 != "") {
$result1 = @mysql_query("SELECT ID FROM $messagetable order by ID DESC LIMIT 1");
while ($myrow=@mysql_fetch_array($result1)) 
{
$fid=$myrow["ID"];
}
$fid=$fid+1;
$updir=$photodir;
$path1 = $upath."$updir";
$fileres1=@substr($fileres1,-3,3);
$source_name1="";
if ($file1 != "") {$source_name1 = "mes".$fid.".$fileres1";}
if($error == ""){
$dest1 = $path1.$source_name1;
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
}} //small img
}
}
if (file_exists($photodir.'s'.$source_name1)) {$wfoto1="s$source_name1";} elseif (!file_exists($photodir.'s'.$source_name1)) {$wfoto1="$source_name1";}
$comment="$comment<br><br>Прикрепленное изображение:<br><a href=$photodir$source_name1 target=_blank><img src=$photodir$wfoto1 border=0 height=$smallfotoheight></a>";
}

$resulthas = @mysql_query("SELECT * FROM $messagetable WHERE tid='$link' and aid='0' and comment='$comment' and ((date + INTERVAL 100 SECOND) > now()) LIMIT 1");
if (@mysql_num_rows($resulthas) == 0)
{ //no
$sql="insert into $messagetable (tid,aid,comment,date,ip) values ('$link','0','$comment',now(),'$REMOTE_ADDR')";
$result=@mysql_query($sql,$db);
} //no
echo "<p align=center><b>Сообщение отправлено!</b></p><br><br>";
}
}
$result = @mysql_query("SELECT tid,aid FROM $messagetable WHERE (aid='0' and tid = $link) or (aid='$link' and tid = 0)");
$totalThread=@mysql_num_rows($result);
if ($totalThread != 0)
{ //2
$maxThr=10;
$page=$_GET['page'];
if(!isset($page)) $page = 1;
if( $totalThread <= $maxThr ) $totalPages = 1;
elseif( $totalThread % $maxThr == 0 ) $totalPages = $totalThread / $maxThr;
else $totalPages = ceil( $totalThread / $maxThr );
if( $totalThread == 0 ) $threadStart = 0;
else $threadStart = $maxThr * $page - $maxThr + 1;
if( $page == $totalPages ) $threadEnd = $totalThread;
else $threadEnd = $maxThr * $page;
$initialMsg = $maxThr * $page - $maxThr;
$pages = (int) (($totalThread + $maxThr - 1) / $maxThr);

//$line = "&nbsp;&nbsp;<a href=\"adminmes.php?link=$link&page=1\">&lt;&lt;</a>";
$ppg2=$page-1;
if ($ppg2 > 0) {$line .= "&nbsp;&nbsp;<a href=\"adminmes.php?link=$link&page=$ppg2\">&lt;</a>&nbsp;&nbsp;";}
for ($k = 1; $k <= $pages; $k++) {
if (($k - $page) < 3 and ($k + 3) > $page)
{
if ($k != $page) {$line .= "<a href=\"adminmes.php?link=$link&page=$k\"><span style=\"border: solid 1px #ffffff; background: #ffffff; color: #000000;\"><b>&nbsp;$k&nbsp;</b></span></a>";}
if ($k == $page) {$line .= " <span style=\"border: solid 1px #af2a09; background: #ff3300; color: #ffffff;\"><B>&nbsp;$k&nbsp;</B></span> ";}
}
}
$ppg=$page+1;
if ($ppg <= $pages) {$line .= "&nbsp;&nbsp;<a href=\"adminmes.php?link=$link&page=$ppg\">&gt;</a>";}
$line .= "&nbsp;&nbsp;<a href=\"adminmes.php?link=$link&page=$pages\">&gt;&gt;</a>";

echo "$line<br><br>";

echo ("
<div align=left><table border=0 width=90% bgcolor=#ffffff cellspacing=2 cellpadding=4 style=\"border: solid 1px $altcolor;\" class=tbl1>
<tr bgcolor=$maincolor>
<td align=left valign=top>
<div style=\"OVERFLOW: auto; HEIGHT: 250px; width: 100%;\">
");

$result = @mysql_query("SELECT *,DATE_FORMAT(date,'%d.%m.%Y %H:%i') as date FROM $messagetable WHERE (aid='0' and tid = $link) or (aid='$link' and tid = 0) order by date DESC LIMIT $initialMsg, $maxThr");
while ($myrow=mysql_fetch_array($result)) {
$mesID=$myrow["ID"];
$tid=$myrow["tid"];
$aid=$myrow["aid"];
$date=$myrow["date"];
$comment=$myrow["comment"];
$comment = ereg_replace("\n","<br>",$comment);
$SmiliesCodes = array("O:-)",":-)",":-(",";-)",":-P","8-)",":-D",":-[","=-O",":-*",":`(",":-X","&gt;:o",":-|",":-\\","*JOKINGLY*","]:-&gt;","[:-}","*KISSED*",":-&#33;","*TIRED*","*STOP*","*KISSING*","@}-&gt;--","*THUMBS UP*","*DRINK*","*IN LOVE*","@=","*HELP*","m/","&#37;","*OK*","*WASSUP*","*SORRY*","*BRAVO*","*ROFL*","*PARDON*","*NO*","*CRAZY*","*DONT_KNOW*","*DANCE*","*YAHOO*","*HI*","*BYE*","*YES*",";D","*WALL*","*WRITE*","*SCRATCH*");
$c = count($SmiliesCodes);
for ($i = 0; $i < $c; $i++) {
$comment = str_replace("$SmiliesCodes[$i]", '<img src=picture/s' . $i . '.gif>', $comment);
}
$date=$myrow["date"];

if ($aid != 0) {echo "<b>$firm $fio:</b>&nbsp;|&nbsp;$date<br>";}
if ($aid == 0) {echo "<b><font color=#666666>Я:</font></b>&nbsp;|&nbsp;$date<br>";}
if ($aid != 0) {echo "$comment";}
if ($aid == 0) {echo "<font color=#666666>$comment</font>";}
echo "&nbsp;[<a href=admindelmes.php?link=$mesID title='Удалить'>X</a>]";
echo ("
<br><hr width=90% size=1>
");
}
echo ("
</div>
</td>
</tr>
</table></div><br>
");
} //2

} //link

echo ("
<form name=formata method=post action=adminmes.php ENCTYPE=\"multipart/form-data\">
<input type=hidden name=link value=$link>
<div align=left><table width=90% class=tbl1>
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



  <tr><td><b>Новое сообщение:</b></td></tr>
    <tr><td>
<table cellpadding=0 cellspacing=0 class=tbl1>
  <tr><td align=center><a onmouseover="copyQ('O:-)','');" href="javascript:pasteQ();"><IMG SRC=picture/s0.gif border=0></a></td>
      <td align=center><a onmouseover="copyQ(':-)','');" href="javascript:pasteQ();"><IMG SRC=picture/s1.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ(':-(','');" href="javascript:pasteQ();"><IMG SRC=picture/s2.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ(';-)','');" href="javascript:pasteQ();"><IMG SRC=picture/s3.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ(':-P','');" href="javascript:pasteQ();"><IMG SRC=picture/s4.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ('8-)','');" href="javascript:pasteQ();"><IMG SRC=picture/s5.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ(':-D','');" href="javascript:pasteQ();"><IMG SRC=picture/s6.gif border=0></a></a></td></tr>
  <tr><td align=center><a onmouseover="copyQ(':-[','');" href="javascript:pasteQ();"><IMG SRC=picture/s7.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ('=-O','');" href="javascript:pasteQ();"><IMG SRC=picture/s8.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ(':-*','');" href="javascript:pasteQ();"><IMG SRC=picture/s9.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ(':`(','');" href="javascript:pasteQ();"><IMG SRC=picture/s10.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ(':-X','');" href="javascript:pasteQ();"><IMG SRC=picture/s11.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ('>:o','');" href="javascript:pasteQ();"><IMG SRC=picture/s12.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ(':-|','');" href="javascript:pasteQ();"><IMG SRC=picture/s13.gif border=0></a></a></td></tr>
  <tr><td align=center><a onmouseover="copyQ(':-\\','');" href="javascript:pasteQ();"><IMG SRC=picture/s14.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ('*JOKINGLY*','');" href="javascript:pasteQ();"><IMG SRC=picture/s15.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ(']:->','');" href="javascript:pasteQ();"><IMG SRC=picture/s16.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ('[:-}','');" href="javascript:pasteQ();"><IMG SRC=picture/s17.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ('*KISSED*','');" href="javascript:pasteQ();"><IMG SRC=picture/s18.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ('*TIRED*','');" href="javascript:pasteQ();"><IMG SRC=picture/s19.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ(':-!','');" href="javascript:pasteQ();"><IMG SRC=picture/s20.gif border=0></a></a></td></tr>
  <tr><td align=center><a onmouseover="copyQ('*STOP*','');" href="javascript:pasteQ();"><IMG SRC=picture/s21.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ('*KISSING*','');" href="javascript:pasteQ();"><IMG SRC=picture/s22.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ('@}->--','');" href="javascript:pasteQ();"><IMG SRC=picture/s23.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ('*THUMBS UP*','');" href="javascript:pasteQ();"><IMG SRC=picture/s24.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ('*DRINK*','');" href="javascript:pasteQ();"><IMG SRC=picture/s25.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ('*IN LOVE*','');" href="javascript:pasteQ();"><IMG SRC=picture/s26.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ('@=','');" href="javascript:pasteQ();"><IMG SRC=picture/s27.gif border=0></a></a></td></tr>
  <tr><td align=center><a onmouseover="copyQ('*HELP*','');" href="javascript:pasteQ();"><IMG SRC=picture/s28.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ('\m/','');" href="javascript:pasteQ();"><IMG SRC=picture/s29.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ('%','');" href="javascript:pasteQ();"><IMG SRC=picture/s30.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ('*OK*','');" href="javascript:pasteQ();"><IMG SRC=picture/s31.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ('*WASSUP*','');" href="javascript:pasteQ();"><IMG SRC=picture/s32.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ('*SORRY*','');" href="javascript:pasteQ();"><IMG SRC=picture/s33.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ('*BRAVO*','');" href="javascript:pasteQ();"><IMG SRC=picture/s34.gif border=0></a></a></td></tr>
  <tr><td align=center><a onmouseover="copyQ('*ROFL*','');" href="javascript:pasteQ();"><IMG SRC=picture/s35.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ('*PARDON*','');" href="javascript:pasteQ();"><IMG SRC=picture/s36.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ('*NO*','');" href="javascript:pasteQ();"><IMG SRC=picture/s37.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ('*CRAZY*','');" href="javascript:pasteQ();"><IMG SRC=picture/s38.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ('*DONT_KNOW*','');" href="javascript:pasteQ();"><IMG SRC=picture/s39.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ('*DANCE*','');" href="javascript:pasteQ();"><IMG SRC=picture/s40.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ('*YAHOO*','');" href="javascript:pasteQ();"><IMG SRC=picture/s41.gif border=0></a></a></td></tr>
  <tr><td align=center><a onmouseover="copyQ('*HI*','');" href="javascript:pasteQ();"><IMG SRC=picture/s42.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ('*BYE*','');" href="javascript:pasteQ();"><IMG SRC=picture/s43.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ('*YES*','');" href="javascript:pasteQ();"><IMG SRC=picture/s44.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ(';D','');" href="javascript:pasteQ();"><IMG SRC=picture/s45.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ('*WALL*','');" href="javascript:pasteQ();"><IMG SRC=picture/s46.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ('*WRITE*','');" href="javascript:pasteQ();"><IMG SRC=picture/s47.gif border=0></a></a></td>
      <td align=center><a onmouseover="copyQ('*SCRATCH*','');" href="javascript:pasteQ();"><IMG SRC=picture/s48.gif border=0></a></a></td></tr>
</table>
    </td>
  </tr>
<?
echo ("
<tr><td><textarea rows=8 name=comment cols=47 id=\"post\" onselect=\"setCaret(this);\" onclick=\"setCaret(this);\" onkeyup=\"setCaret(this);\"></textarea>
<br>Прикрепить изображение:<br>
<input type=file name=file1 size=30>
</td></tr>
<tr><td><br>
");
echo "<input type=submit value=\"Отправить\" name=\"submit\" class=i3><br><br></td></tr></table></form>";

echo "</div>";

} //ok
} //yes
echo "<center><a href=admin.php>На общую страницу администрирования</a><br><br>";
include("down.php");
?>