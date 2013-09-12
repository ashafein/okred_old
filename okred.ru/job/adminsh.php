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
<META NAME=ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<?php
include("var.php");
$maxThread = 20;
echo "<title>Администрирование - Просмотр статьи: $sitename</title>";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\">";
include("top.php");
$result = @mysql_query("SELECT pass FROM $admintable");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
$err1="Неверный пароль!<br>";
$error = "";
if (!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass)
{
echo "<center><b>Вы не <a href=admin.php>авторизированы</a>!</b><br><br>";
}
else
{ // ok
if ($_GET['ID'] == '') {$ID=$_POST['ID'];}
elseif ($_GET['ID'] != '') {$ID=$_GET['ID'];}
if (!isset($ID))
{
echo "<center><br><br><h3>Статья не выбрана!</h3><b><a href=admin.php>На страницу администрирования</a></b><br><br>";
}
else
{//1
echo "<center><p><strong><big>Администрирование - Просмотр статей</strong></big>";
echo "<form name=delreg method=post action=adminsh.php?confirm>";
if ($_SERVER[QUERY_STRING] != "confirm") 
{
$result = @mysql_query("SELECT * FROM $textable WHERE ID = $ID");
$totaltexts=@mysql_num_rows($result);
if (@mysql_num_rows($result) == 0) {
echo "<center>Cтатья не определена!<br><br><a href=index.php>На главную страницу</a><br><br>";
}
else
{ //2
while ($myrow=mysql_fetch_array($result)) 
{ //4
$ID=$myrow["ID"];
$title=$myrow["title"];
$genre=$myrow["genre"];
$text=$myrow["text"];
$text = ereg_replace("\n","<br>",$text);
$date=$myrow["date"];
$foto1=$myrow["foto1"];
$foto2=$myrow["foto2"];
$foto3=$myrow["foto3"];
$foto4=$myrow["foto4"];
$foto5=$myrow["foto5"];
} //4
if (eregi('ФОТО1',$text) and $foto1 != ""){$text=@str_replace('ФОТО1',"<a href=$photodir$foto1 target=_blank><img src=$photodir$foto1 border=0 width=300 align=left></a>",$text);}
if (eregi('ФОТО2',$text) and $foto2 != ""){$text=@str_replace('ФОТО2',"<a href=$photodir$foto2 target=_blank><img src=$photodir$foto2 border=0 width=300 align=left></a>",$text);}
if (eregi('ФОТО3',$text) and $foto3 != ""){$text=@str_replace('ФОТО3',"<a href=$photodir$foto3 target=_blank><img src=$photodir$foto3 border=0 width=300 align=left></a>",$text);}
if (eregi('ФОТО4',$text) and $foto4 != ""){$text=@str_replace('ФОТО4',"<a href=$photodir$foto4 target=_blank><img src=$photodir$foto4 border=0 width=300 align=left></a>",$text);}
if (eregi('ФОТО5',$text) and $foto1 != ""){$text=@str_replace('ФОТО5',"<a href=$photodir$foto5 target=_blank><img src=$photodir$foto5 border=0 width=300 align=left></a>",$text);}
echo ("
<h3 align=center>$title</h3>
<p align=justify>$text</p>
<p align=right><b>$sitename</b><br>$date</p>
<hr width=100% size=1>
");
echo "<input type=hidden name=ID value=$ID><center><input type=submit name=delete value='Удалить статью'>";
} //2
echo "</form>";
}
}
if ($_SERVER[QUERY_STRING] == "confirm"){
if ($error != ""){
echo "<center><h3>Ошибка</h3><font color=red>$error</font><p><a href=# onClick=history.go(-1)>Вернуться назад</a><p><br><br><br><br><br><br><br><br>";
}
if ($error==""){
if ($_SERVER[QUERY_STRING] == "confirm" and isset($_POST['deletef1'])) {
$res1 = @mysql_query("SELECT ID,foto1,foto2,foto3,foto4,foto5,aid FROM $textable WHERE ID=$ID");
while ($myrow=@mysql_fetch_array($res1)) 
{
$foto1=$myrow["foto1"];
}
@unlink($upath.$photodir.$foto1);
$resultf=@mysql_query("update $textable SET foto1='' WHERE ID=$ID");
echo "<br><br><h3 align=center>Фото удалена!</h3><br><br><p align=center><a href=adminsh.php?ID=$ID>К статье</a></p><br><br>";
}
if ($_SERVER[QUERY_STRING] == "confirm" and isset($_POST['deletef2'])) {
$res1 = @mysql_query("SELECT ID,foto1,foto2,foto3,foto4,foto5,aid FROM $textable WHERE ID=$ID");
while ($myrow=@mysql_fetch_array($res1)) 
{
$foto2=$myrow["foto2"];
}
@unlink($upath.$photodir.$foto2);
$resultf=@mysql_query("update $textable SET foto2='' WHERE ID=$ID");
echo "<br><br><h3 align=center>Фото удалена!</h3><br><br><p align=center><a href=adminsh.php?ID=$ID>К статье</a></p><br><br>";
}
if ($_SERVER[QUERY_STRING] == "confirm" and isset($_POST['deletef3'])) {
$res1 = @mysql_query("SELECT ID,foto1,foto2,foto3,foto4,foto5,aid FROM $textable WHERE ID=$ID");
while ($myrow=@mysql_fetch_array($res1)) 
{
$foto3=$myrow["foto3"];
}
@unlink($upath.$photodir.$foto3);
$resultf=@mysql_query("update $textable SET foto3='' WHERE ID=$ID");
echo "<br><br><h3 align=center>Фото удалена!</h3><br><br><p align=center><a href=adminsh.php?ID=$ID>К статье</a></p><br><br>";
}
if ($_SERVER[QUERY_STRING] == "confirm" and isset($_POST['deletef4'])) {
$res1 = @mysql_query("SELECT ID,foto1,foto2,foto3,foto4,foto5,aid FROM $textable WHERE ID=$ID");
while ($myrow=@mysql_fetch_array($res1)) 
{
$foto4=$myrow["foto4"];
}
@unlink($upath.$photodir.$foto4);
$resultf=@mysql_query("update $textable SET foto4='' WHERE ID=$ID");
echo "<br><br><h3 align=center>Фото удалена!</h3><br><br><p align=center><a href=adminsh.php?ID=$ID>К статье</a></p><br><br>";
}
if ($_SERVER[QUERY_STRING] == "confirm" and isset($_POST['deletef5'])) {
$res1 = @mysql_query("SELECT ID,foto1,foto2,foto3,foto4,foto5,aid FROM $textable WHERE ID=$ID");
while ($myrow=@mysql_fetch_array($res1)) 
{
$foto5=$myrow["foto5"];
}
@unlink($upath.$photodir.$foto5);
$resultf=@mysql_query("update $textable SET foto5='' WHERE ID=$ID");
echo "<br><br><h3 align=center>Фото удалена!</h3><br><br><p align=center><a href=adminsh.php?ID=$ID>К статье</a></p><br><br>";
}
if ($_SERVER[QUERY_STRING] == "confirm" and isset($_POST['delete'])) {
$res3 = @mysql_query("SELECT ID,aid FROM $textable WHERE ID=$ID");
while($myrow=mysql_fetch_array($res3)) {
$aid=$myrow["aid"];
}
$res1 = @mysql_query("SELECT ID,foto1,foto2,foto3,foto4,foto5,aid FROM $textable WHERE ID=$ID");
while ($myrow=@mysql_fetch_array($res1)) 
{
$foto1=$myrow["foto1"];
$foto2=$myrow["foto2"];
$foto3=$myrow["foto3"];
$foto4=$myrow["foto4"];
$foto5=$myrow["foto5"];
}
@unlink($upath.$photodir.$foto1);
@unlink($upath.$photodir.$foto2);
@unlink($upath.$photodir.$foto3);
@unlink($upath.$photodir.$foto4);
@unlink($upath.$photodir.$foto5);
unset($res1);
$result=@mysql_query("delete from $textable where ID=$ID");
echo "<br><br><h3 align=center>Статья удалена!</h3><br><br><br>";
}
}
} //1
} //ok
echo "<center><a href=admin.php>На общую страницу администрирования</a><br><br>";
include("down.php");
?>