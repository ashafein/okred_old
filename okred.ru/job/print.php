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
echo"<title>Версия для печати : $sitename</title>";
@$db=mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);

$ID=$_GET['ID'];

if (!isset($ID))
{
echo "<center><br><br><h3>Статья не выбрана!</h3><b><a href=index.php>На главную страницу</a></b><br><br>";
}
else
{//1
$result = @mysql_query("SELECT * FROM $textable WHERE ID = $ID and status='ok'");
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
<p align=right>$date</p>
<hr width=100% size=1>
<p align=left>$sitename<br><a href=$siteadress>$siteadress</a></p>
");
} //2
} //1
?>
