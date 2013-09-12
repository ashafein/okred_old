<?
session_start();
session_register("uid");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<!--/***************** DO NOT REMOVE! *********************/---->
<!--/*   Author: Nevezhyn Evgeny  Date : 01/06/2003       */---->
<!--/*   nevius@bk.ru      All Rights Reserved ...        */---->
<!--/*   http://nevius.ru/                                */---->
<!--/***************** DO NOT MODIFY! *********************/---->

<?php
include("var.php");
echo "<head><title>Администрирование - Правка статьи: $sitename</title>";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\">";
include("top.php");
$error = "";
$result = @mysql_query("SELECT pass FROM $admintable");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
if ($_GET['texid'] == '') {$texid=$_POST['texid'];}
elseif ($_GET['texid'] != '') {$texid=$_GET['texid'];}
if (!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass)
{
if (isset($texid))
{echo "<center><b>Вы не <a href=admin.php>авторизированы</a>!</b><br><br>";}
if (!isset($texid))
{echo "<center><br><br><h3>Вопрос не определен!</h3><b><a href=adminfaq.php>На страницу удаления</a></b>";}
}
else
{ // ok
if ($_SERVER[QUERY_STRING] != "change")
{ //1
$result = @mysql_query("SELECT * FROM $faqtable WHERE idnum='$texid'");
if (mysql_num_rows($result) == 0) {
	$error .= "Статья не определена";}
while ($myrow=mysql_fetch_array($result)) 
{ //4
$time=$myrow["time"];
$datum=$myrow["datum"];
$vopros=$myrow["vopros"];
$otvet=$myrow["otvet"];
$name=$myrow["name"];
$email=$myrow["email"];
}
echo "<center><font color=red>$error</font></center>";
} //1
if ($_SERVER[QUERY_STRING] == "change")
{ //6
echo "<center><font color=red>$error</font></center>";
} //6
if (($_SERVER[QUERY_STRING] != "change" and $error == "") or ($_SERVER[QUERY_STRING] == "change" and $error != ""))
{ //3
echo "<p><strong>Изменение вопроса</strong><form name=form1 method=post ENCTYPE=multipart/form-data action=adminfqc.php?change><input type=hidden name=texid value=\"$texid\">";
if ($_SERVER[QUERY_STRING] != "change" or $error != "")
{ //4

  ?>
<table cellpadding=5 cellspacing=0 border=0  bgcolor=#F0F0F0 class=contur>
  <tr>
    <td></td>
    <td></td>
    <td><b>Ответ на вопрос:</b><hr></td>
  </tr>
  <tr>
    <td align=right valign=top>Вопрос задан:</td>
    <td></td>
    <td>Время: <?=$time?> / Число: <?=$datum?><hr></td>
  </tr>
    <input TYPE=hidden name=time value="<?=$time?>">
    <input TYPE=hidden name=datum value="<?=$datum?>">
    <input TYPE=hidden name=id value="<?=$id?>">
    <? if(!isset($vid)) $vid="add"; ?>
     <input TYPE=hidden name=vid value="<?=$vid?>">
    <input TYPE=hidden name=action value="add_to_main">
  <tr>
    <td width=141 align=right>Имя:</td>
    <td width=5></td>
    <td><input class=noborder type=text name=name size=30 MAXLENGTH=60 value="<?=$name?>"></td>
  </tr>
  <tr>
    <td align=right>Email:</td>
    <td></td>
    <td><input class=noborder type=text name=email size=30 MAXLENGTH=100 value="<?=$email?>"></td>
  </tr>
  <tr>
    <td valign=top align=right>Вопрос:</td>
    <td></td>
    <td><textarea name=vopros MAXLENGTH=700 class=noborder style="height: 50px; width: 400px; padding: 3px;"><?=$vopros?></textarea></td>
  </tr>
  <tr>
    <td valign=top align=right>Ответ:</td>
    <td></td>
    <td><textarea name=otvet MAXLENGTH=700 class=noborder style="height: 100px; width: 400px; padding: 3px;"><?
     if(isset($otvet)){
        echo $otvet;
        }
     ?></textarea></td>
  </tr>
  <tr>
    <td><input type=submit value="Сохранить" name="submit" class=i3></td>
    <td></td>
    <td></td>
  </tr>
</table>

  <?

echo "<p></form>";
echo "<p align=center><a href=adminfaq.php>Вернуться назад</a></p>";
} //4
} //3

if ($_SERVER[QUERY_STRING] == "change" and $error == "") 
{ //5

$vopros=$_POST['vopros'];
$otvet=$_POST['otvet'];
$name=$_POST['name'];
$email=$_POST['email'];

function untag ($string) {
$string = ereg_replace("<","&lt;",$string);
$string = ereg_replace(">","&gt;",$string);
$string = ereg_replace('\\\"',"&quot;",$string);
$string = ereg_replace(":","&#58;",$string);
$string = ereg_replace("!","&#33;",$string);
$string = ereg_replace("\r","",$string);
$string = ereg_replace("\n","<br>",$string);
$string = ereg_replace("%","&#37;",$string);
$string = ereg_replace("^ +","",$string);
$string = ereg_replace(" +$","",$string);
$string = ereg_replace(" +"," ",$string);
return $string;
}
$sql="update $faqtable SET name='$name',email='$email',vopros='$vopros',otvet='$otvet' WHERE idnum='$texid'";
$result=@mysql_query($sql,$db);
echo "<center><h3>Изменения сохранены!</h3><p align=center><a href=adminfaq.php>Вернуться назад</a></p><br><br>";
} //5
} //ok
echo "<center><a href=admin.php>На общую страницу администрирования</a><br><br>";
include("down.php");
?>