<?
session_start();
session_register("uid");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!--/***************** DO NOT REMOVE! *********************/---->
<!--/*   Author: Nevezhyn Evgeny  Date : 20/05/2004       */---->
<!--/*   nevius@bk.ru      All Rights Reserved ...        */---->
<!--/*   http://nevius.ru/                                */---->
<!--/***************** DO NOT MODIFY! *********************/---->

<head>
<?php
include("var.php");
echo"<title>Оплата : $sitename</title>";
include("top.php");
?>
<h3><center><strong>Оплата</strong></center></h3>
<?php
$result = @mysql_query("SELECT pass FROM $admintable");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
$error = "";
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
if (!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass)
{
echo "<center><b>Вы не <a href=admin.php>авторизированы</a>!</b><br><br>";
}
else
{ // ok
if ($_GET['id'] == '') {$id=$_POST['id'];}
elseif ($_GET['id'] != '') {$id=$_GET['id'];}
if (isset($id) and $id != '')
{ //firmid
if ($_SERVER[QUERY_STRING] != "add")
{ //2
$result = @mysql_query("SELECT * FROM $autortable WHERE ID='$id'");
while ($myrow=mysql_fetch_array($result)) {
$pay=$myrow["pay"];
}
echo "<center><font color=red>$error</font></center>";
} //2
if ($_SERVER[QUERY_STRING] == "add") {
$pay=$_POST['pay'];
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
if ($_SERVER[QUERY_STRING] == "add" and $error == "") {
$status='ok';
$stroka='<b>В течение нескольких минут информация будет доступна для просмотра</b>';
$result=@mysql_query("update $autortable SET pay='$pay' WHERE ID=$id");
}
}
if ($_SERVER[QUERY_STRING] != "add" or $error != "") {
echo ("
<form name=form method=post ENCTYPE=\"multipart/form-data\" action=adminpay.php?add>
<input type=hidden name=id value=\"$id\">
<table class=tbl1 width=90%>
<tr><td align=right><strong><b>На счете:</strong></td>
<td><input type=text name=pay size=30 value=\"$pay\"></td></tr>
</table>
");
echo "<center><p><input type=submit value=\"Изменить\" name=\"submit\"></form>";
}
else {
echo "<br><br><h3 align=center>Изменения сохранены!</h3><br><br>";
}
} //firmid
if (!isset($id) or $id=='')
{
echo "<center><br><br><h3>Пользователь не определен!</h3><b><a href=adminda.php>Вернуться</a></b><br><br>";
}
} //ok
echo "<br><br><center><a href=admin.php>На общую страницу администрирования</a><br><br>";
include("down.php");
?>