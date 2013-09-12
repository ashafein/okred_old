<?
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!--/***************** DO NOT REMOVE! *********************/---->
<!--/*   Author: Nevezhyn Evgeny  Date : 25/02/2003       */---->
<!--/*   nevius@bk.ru      All Rights Reserved ...        */---->
<!--/*   http://nevius.ru/                                */---->
<!--/***************** DO NOT MODIFY! *********************/---->

<head>
<?php
include("var.php");
echo"<title>Отзывы о компании : $sitename</title>";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\"><META HTTP-EQUIV=\"Cache-Control\" CONTENT=\"No-Cache\">";
include("top.php");
echo "<h3 align=center>Отзывы о компании</h3>";
$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);
$maxcomment = 4000;
$err3 = "Комментарий должен быть не длинее $maxcomment символов<br>";
$err5 = "Не заполнено обязательное поле - Комментарий!<br>";
$error="";

if ($_GET['texid'] == '') {$texid=$_POST['texid'];}
elseif ($_GET['texid'] != '') {$texid=$_GET['texid'];}

if (!isset($texid))
{
echo "<center><br><br><h3>Компания не выбрана!</h3><b><a href=index.php>На главную страницу</a></b><br><br>";
}
else
{//1

$resultank = @mysql_query("SELECT * FROM $autortable WHERE ID='$texid' LIMIT 1");
while ($myrow1=mysql_fetch_array($resultank)) 
{ //4
$ID=$myrow1["ID"];
$firm=$myrow1["firm"];

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

if ($foto == '') {$fotourl='<img src=picture/nofoto.jpg alt="Нет фотографии" border=0>';}
if ($foto != '') {$fotourl="<img src=$photodir$foto border=0 alt=\"$firm\" width=100>";}

echo ("
<table border=0 width=100% cellspacing=2 cellpadding=4 class=tbl1>
<tr bgcolor=$maincolor><td valign=top align=center width=100><table cellspacing=0 cellpadding=0 class=imagetbl><tr><td>$fotourl</td></tr></table></td>
<td valign=top align=left>
<b>$firm</b><br>
Город:&nbsp;$citys<br>
</td></tr></table>
");    
} //4

if (isset($_POST['submit'])){
$comment=$_POST['comment'];
$number=$_POST['number'];
$ankID=$_POST['ankID'];
if (strlen($comment) > $maxcomment) {$error .= "$err3";}
if ($comment == "") {$error .= "$err5";}
if ($imgconfirm == 'TRUE' and  ($number == '' or $_COOKIE['reg_num'] != $number)) {$error .= "Неверный цифровой код!";}
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
$status='ok';$stroka='<b>В течение нескольких минут информация будет доступна для просмотра</b>';
$sql="insert into $rabcommentstable (tid,aid,comment,date,ip,status) values ('$texid','$ankID','$comment','$date','$REMOTE_ADDR','$status')";
$result=@mysql_query($sql,$db);
echo "<p align=center><b>Отзыв добавлен</b><br><br>$stroka</p>";
$txt="На сайте $sitename новый отзыв\n\nСообщение: $comment\nIP автора: $REMOTE_ADDR";
mail("$adminemail", "Новый отзыв о компании", $txt,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/plain; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");
}
}
$result = @mysql_query("SELECT tid,status FROM $rabcommentstable WHERE tid = $texid and status='ok'");
$totalThread=@mysql_num_rows($result);
if ($totalThread == 0) {
echo "<center><br><b>По этой компании не было отзывов!</b><br><br>";
}
else
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

$line = "<B>Страница:</B>&nbsp;&nbsp;<a href=\"comcom.php?texid=$texid&page=1\">&lt;&lt;</a>&nbsp;&nbsp;";
$ppg2=$page-1;
if ($ppg2 > 0) {$line .= "<a href=\"comcom.php?texid=$texid&page=$ppg2\">&lt;</a>&nbsp;&nbsp;";}
for ($k = 1; $k <= $pages; $k++) {
if (($k - $page) < 3 and ($k + 3) > $page)
{
if ($k != $page) {$line .= "<a href=\"comcom.php?texid=$texid&page=$k\"> <small>$k</small> </a>";}
if ($k == $page) {$line .= " <B>$k</B> ";}
}
}
$ppg=$page+1;
if ($ppg <= $pages) {$line .= "&nbsp;&nbsp;<a href=\"comcom.php?texid=$texid&page=$ppg\">&gt;</a>";}
$line .= "&nbsp;&nbsp;<a href=\"comcom.php?texid=$texid&page=$pages\">&gt;&gt;</a>";

$result = @mysql_query("SELECT * FROM $rabcommentstable WHERE tid = $texid and status='ok' order by date DESC LIMIT $initialMsg, $maxThr");
echo "<br><center>Всего отзывов: <b>$totalThread</b><br><br>";
while ($myrow=mysql_fetch_array($result)) {
$tid=$myrow["tid"];
$name=$myrow["login"];
$aid=$myrow["aid"];
$comment=$myrow["comment"];
$comment = ereg_replace("\n","<br>",$comment);
$SmiliesCodes = array("O:-)",":-)",":-(",";-)",":-P","8-)",":-D",":-[","=-O",":-*",":`(",":-X","&gt;:o",":-|",":-\\","*JOKINGLY*","]:-&gt;","[:-}","*KISSED*",":-&#33;","*TIRED*","*STOP*","*KISSING*","@}-&gt;--","*THUMBS UP*","*DRINK*","*IN LOVE*","@=","*HELP*","m/","&#37;","*OK*","*WASSUP*","*SORRY*","*BRAVO*","*ROFL*","*PARDON*","*NO*","*CRAZY*","*DONT_KNOW*","*DANCE*","*YAHOO*","*HI*","*BYE*","*YES*",";D","*WALL*","*WRITE*","*SCRATCH*");
$c = count($SmiliesCodes);
for ($i = 0; $i < $c; $i++) {
$comment = str_replace("$SmiliesCodes[$i]", '<img src=picture/s' . $i . '.gif>', $comment);
}
$date=$myrow["date"];

if ($aid == $texid) {$bgcolor=$bgcolor1;}
if ($aid != $texid) {$bgcolor=$maincolor;}

echo ("
<div align=center><table border=0 width=100% cellspacing=2 cellpadding=4 style=\"border: solid 1px $altcolor;\" class=tbl1>
<tr bgcolor=$bgcolor>
<td align=left valign=top><p align=justify>$comment</p></td>
<td width=150 align=center><table cellspacing=0 cellpadding=0 class=tbl1 width=100%><tr><td align=center>
");

// анкета
$result12 = @mysql_query("SELECT * FROM $autortable WHERE ID = '$aid' and status='ok'");
if (@mysql_num_rows($result12) == 0)
{
echo "<b>Пользователь</b>";
}
if (@mysql_num_rows($result12) != 0)
{
while ($myrow=mysql_fetch_array($result12)) 
{
$ankID1=$myrow["ID"];
$firm1=$myrow["firm"];

$country1=$myrow["country"];
$region1=$myrow["region"];
$city1=$myrow["city"];
$citytar1=$city1;
if ($city1=='0') {$citytar1=$region1;}
if ($region1=='0' and $city1=='0') {$citytar1=$country1;}
$resultadd3 = @mysql_query("SELECT * FROM $citytable WHERE ID='$citytar1'");
while($myrow2=mysql_fetch_array($resultadd3)) {
$citys1=$myrow2["categ"];
if ($city1=='0') {$citys1=$myrow2["podrazdel"];}
if ($city1=='0' and $region1=='0') {$citys1=$myrow2["razdel"];}
}

$foto1=$myrow["foto2"];
}

if ($foto1 == '') {$fotourl='<img src=picture/nofoto.jpg alt="Нет фотографии" border=0>';}
if ($foto1 != '') {$fotourl="<img src=$photodir$foto1 border=0 alt=\"$firm1\" width=100>";}

echo ("
<b>$firm1</b><br>
");
echo "$fotourl<br>";
echo ("
$citys1
");    
}
// анкета

echo ("
</td></tr></table></td>
</tr>
</table></div><br>
");
}
echo "<p align=center>$line</p>";
} //2
if (!isset($_POST['submit'])){

$sid=$_SESSION['sid'];
$slogin=$_SESSION['slogin'];
$spass=$_SESSION['spass'];

$result = @mysql_query("SELECT email,pass FROM $autortable WHERE (email = '$slogin' and pass = '$spass')");
if ((!isset($slogin) or !isset($spass)) or @mysql_num_rows($result) == 0)
{
echo "<center><br><br><h3>Вы не авторизированы! Чтобы добавить новый отзыв необходимо авторизироваться</h3><b><a href=autor.php>Авторизация</a></b><br><br>";
}
else
{//ok
echo ("
<h3 align=center>Оставить комментарий</h3>
<center><strong>Обязательные поля отмечены символом <font color=#FF0000>*</font></strong></p>
<form name=formata method=post action=comcom.php>
<input type=hidden name=texid value=$texid>
<input type=hidden name=ankID value=$sid>
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

<?
echo ("
<table width=90% class=tbl1>
");
?>
  <tr>
    <td></td><td>
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
<tr><td align=right width=60%><strong><font color=#FF0000>*</font>Комментарий:</strong></td>
<td width=60%><textarea rows=8 name=comment cols=47 id=\"post\" onselect=\"setCaret(this);\" onclick=\"setCaret(this);\" onkeyup=\"setCaret(this);\"></textarea></td></tr>
");
if ($imgconfirm == 'TRUE')
{ // img conf
echo ("
<tr><td align=right valign=top><font color=#FF0000>*</font><b>Код на картинке</b>:&nbsp;
<img src=code.php>
</td><td><input type=text name=number size=20></td></tr>
");
} // img conf
echo ("
<tr><td colspan=2 align=center>
");
echo "<input type=submit value=\"Добавить\" name=\"submit\" class=i3><br><small>Пожалуйста, не нажимайте кнопку Добавить дважды!</small></td></tr></table></form>";
} //ok
}
} //1
include("down.php");
?>