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
if ($commenttrue == 'TRUE')
{ // commenttrue
echo"<title>Комментирование статьи : $sitename</title>";
include("top.php");
echo "<table width=100% border=0><tr><td width=50%>&nbsp;</td><td bgcolor=$altcolor align=left><b><big>Комментарии <font color=$maincolor>:.</font></big></b></td></tr></table>";
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
$maxname = 50;
$maxemail = 50;
$maxcomment = 400;
$err1 = "Имя должно быть не длинее $maxname символов<br>";
$err2 = "Email должен быть не длинее $maxemail символов<br>";
$err3 = "Комментарий должен быть не длинее $maxcomment символов<br>";
$err4 = "Не заполнено обязательное поле - Имя!<br>";
$err5 = "Не заполнено обязательное поле - Комментарий!<br>";
$err6 = "Пожалуйста проверьте правильность E-mail адреса<br>";
$err24 = "Не верный цифровой код!<br>";
$error="";
if ($_GET['ID'] == '') {$ID=$_POST['ID'];}
elseif ($_GET['ID'] != '') {$ID=$_GET['ID'];}
if (!isset($ID))
{
echo "<center><br><br><h3>Статья не выбрана!</h3><b><a href=index.php>На главную страницу</a></b><br><br>";
}
else
{//1
if (isset($_POST['submit'])){

$name=$_POST['name'];
$email=$_POST['email'];
$comment=$_POST['comment'];
$number=$_POST['number'];

if (strlen($name) > $maxname) {$error .= "$err1";}
if (strlen($email) > $maxemail) {$error .= "$err2";}
if (strlen($comment) > $maxcomment) {$error .= "$err3";}
if ($name == "") {$error .= "$err4";}
if ($comment == "") {$error .= "$err5";}
if ($email != "" and !strpos($email,"@")) {$error .= "$err6";}
if ($imgconfirm == 'TRUE' and $_COOKIE['reg_num'] != $number) {$error .= "$err24";}
echo "<center><font color=red>$error</font></center>";
function untag ($string) {
$string = ereg_replace("<","&lt;",$string);
$string = ereg_replace(">","&gt;",$string);
$string = ereg_replace('\\\"',"&quot;",$string);
$string = ereg_replace(":","&#58;",$string);
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
$name = untag($name);
$email = untag($email);
$city = untag($comment);
$date = date("Y/m/d H:i:s");
$sql="insert into $commentstable (tid,name,email,comment,date) values ('$ID','$name','$email','$comment',now())";
$result=@mysql_query($sql,$db);
}
}
$result = @mysql_query("SELECT tid,name,email,comment,date FROM $commentstable WHERE tid = $ID");
$totalcomment=@mysql_num_rows($result);
if ($totalcomment == 0) {
echo "<center><br><b>По этой статье комментариев не оставлено!</b><br><br><a href=text.php?link=$ID>Вернуться к статье</a><br><br>";
}
else
{ //2
$result = @mysql_query("SELECT ID,title,genre FROM $textable WHERE ID = $ID");
while ($myrow=@mysql_fetch_array($result)) {
$title=$myrow["title"];
$genre=$myrow["genre"];
}
$result = @mysql_query("SELECT tid,name,email,comment,date FROM $commentstable WHERE tid = $ID");
echo "<h3 align=center>$title</h3>Всего комментариев: <b>$totalcomment</b><br><br>";
while ($myrow=mysql_fetch_array($result)) {
$tid=$myrow["tid"];
$name=$myrow["name"];
$email=$myrow["email"];
$comment=$myrow["comment"];
$comment = ereg_replace("\n","<br>",$comment);
$date=$myrow["date"];
echo ("
<div align=center><table bgcolor=$bordercolor width=90% border=0>
<tr bgcolor=$altcolor><td align=left><b>Имя: </b><a href=mailto:$email>$name</a><br>Дата добавления: <i>$date</i></td></tr>
<tr bgcolor=$maincolor><td align=left><p align=justify>$comment</p></td></tr>
</table></div><br><br>
");
}
echo "<center><a href=\"text.php?g=$genre&link=$ID\">Вернуться к статье</a>";
} //2
if (!isset($_POST['submit'])){
echo ("
<h3 align=center>Оставить свой комментарий</h3>
<center><strong>Обязательные поля отмечены символом <font color=#FF0000>*</font></strong></p>
<form name=form method=post action=comment.php>
<input type=hidden name=ID value=$ID>
<table width=90% bgcolor=$maincolor>
<tr bgcolor=$altcolor><td align=right width=60%><strong><font color=#FF0000>*</font>Имя:</strong></td>
<td width=60%><input type=text name=name size=50></td></tr>
<tr bgcolor=$altcolor><td align=right width=60% bgcolor=$maincolor><strong>Email:</strong></td>
<td width=60%><input type=text name=email size=50></td></tr>
<tr bgcolor=$altcolor><td align=right width=60%><strong><font color=#FF0000>*</font>Комментарий:</strong></td>
<td width=60%><textarea rows=4 name=comment cols=43></textarea></td></tr>
");
if ($imgconfirm == 'TRUE')
{ // img conf
echo "<tr $altcolor><td align=right valign=top><font color=#FF0000>*</font>Код на картинке:&nbsp;";
echo "<img src=code.php>";
echo "</td><td><input type=text name=number size=20></td></tr>";
} // img conf
echo ("
<tr bgcolor=$altcolor><td colspan=2 align=center>
");
echo "<input type=submit value=\"Добавить\" name=\"submit\"><br><small>Пожалуйста, не нажимайте кнопку Добавить дважды!</small></td></tr></table></form>";
}
} //1
include("down.php");
} // commenttrue
?>