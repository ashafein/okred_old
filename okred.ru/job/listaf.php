<?
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<?php
include("var.php");
echo"<title>Выбор раздела : $sitename</title>";
include("top.php");

$c=$_GET['c'];
$year=$_GET['year'];
$month=$_GET['month'];
$today=$_GET['today'];

if (!isset($c) or $c == '')
{
echo "<center><br><br><b>Выберите раздел:</b><br><br><table>";
$resultcat = @mysql_query("SELECT * FROM $afishacatable order by ID DESC");
echo "<tr><td width=10 class=caltop><b>&gt;</b></td><td width=100% align=center class=caltbl><a href=\"listaf.php?c=all\">Все</a></td></tr>";
while($myrow=mysql_fetch_array($resultcat)) {
$categ=$myrow["category"];
$categID=$myrow["ID"];
echo "<tr><td width=10 class=caltop><b>&gt;</b></td><td width=100% align=center class=caltbl><a href=\"listaf.php?c=$categID\">$categ</a></td></tr>";
}
echo "</table>";
}
else
{ //1
if ($c != 'all')
{
$resultcat = @mysql_query("SELECT * FROM $afishacatable WHERE ID='$c'");
while($myrow=mysql_fetch_array($resultcat)) {
$categ=$myrow["category"];
}
}

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

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td valign=top>

<table width="350" border="0" cellspacing="8" cellpadding="2">
  <tr>
    <td style="padding-left: 50px;">
     <?

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

      //echo "Афиша на ".$today." ".$month_rus." ".$year;
      //echo "Афиша";
     ?>
    </td>
  </tr>
<?php

$sql_date = $year."-".$month."-".$today;
if ($c != 'all') {$result = mysql_query("select * from $afishatable where category = '$categ' and (datum >= $sql_date or (datumend != '0000-00-00' and datumend >= $sql_date)) and noshow != 'checked' order by datum desc,date desc limit ".$news_num." ");}
elseif ($c == 'all') {$result = mysql_query("select * from $afishatable where (datum >= $sql_date or (datumend != '0000-00-00' and datumend >= $sql_date)) and noshow != 'checked' order by datum desc,date desc limit ".$news_num." ");}
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
if (eregi('ФОТО1',$preview) and $foto1 != ""){$preview=@str_replace('ФОТО1',"<img src=\"$afishadir$foto1\" border=0 align=left class=image>",$preview);}
}

?>

         <!-- блок Афиша -->
                <?
                   if($preview=="") {
                   echo "<tr><td class=newstbltop><font color=#555555>".$dati[2].".".$dati[1].".".$dati[0]."</font>&nbsp;&nbsp;&nbsp;
                         <a href=\"afisha.php?link=".$idnum."&year=".$dati[0]."&today=".$dati[2]."&month=".$dati[1]."\"><strong>".$title."</strong></a></td></tr>";
                         }
                   elseif($preview != "" and $detail != ""){
                         echo "<tr><td class=newstbltop><font color=#555555>".$dati[2].".".$dati[1].".".$dati[0]."</font>&nbsp;&nbsp;&nbsp;
                               <a href=\"afisha.php?link=".$idnum."&year=".$dati[0]."&today=".$dati[2]."&month=".$dati[1]."\"><strong>".$title."</strong></a></td></tr><tr><td class=newstbl><p align=justify>".$preview;
                         echo "<br><a href=\"afisha.php?link=".$idnum."&year=".$dati[0]."&today=".$dati[2]."&month=".$dati[1]."\">Подробнее</a>&nbsp;&raquo;</p></td></tr>";
                         }
                   elseif($preview != "" and $detail == "") {
                         echo "<tr><td class=newstbltop><font color=#555555>".$dati[2].".".$dati[1].".".$dati[0]."</font>&nbsp;&nbsp;&nbsp;
                               <strong>".$title."</strong></td></tr><tr><td class=newstbl><p align=justify>".$preview."</p></td></tr>";
                        }
                   echo "<tr><td height=15></td></tr>";
 }

echo "<tr><td class=newstbl align=right><a href=\"afisha.php?c=$c\">Все события</a>&nbsp;&raquo;</td></tr>";
echo "</table>";

?>

</td><td width=10></td><td valign=top>

<table width="350" border="0" cellspacing="8" cellpadding="2">
  <tr>
    <td style="padding-left: 50px;">
     <?

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

      //echo "Афиша на ".$today." ".$month_rus." ".$year;
      //echo "Афиша";
     ?>
    </td>
  </tr>
<?php

if ($c != 'all') {$result = mysql_query("select * from $reporttable WHERE category = '$categ' order by date desc limit ".$news_num." ");}
elseif ($c == 'all') {$result = mysql_query("select * from $reporttable order by date desc limit ".$news_num." ");}
       $rows = mysql_num_rows($result);

for($k=0;$k < $rows;$k++)
   {
    $preview=mysql_result($result, $k , "preview");
    $detail=mysql_result($result, $k , "detail");
    $title=mysql_result($result, $k , "title");
    $idnum=mysql_result($result, $k , "ID");
    $datum=mysql_result($result, $k , "datum");
    $foto1=mysql_result($result, $k , "foto1");
    $dati=explode("-",$datum);
if ($preview != "") {
$preview = ereg_replace("\n","<br>",$preview);
$preview = ereg_replace("     ","&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$preview);
if (eregi('ФОТО1',$preview) and $foto1 != ""){$preview=@str_replace('ФОТО1',"<img src=\"$afishadir$foto1\" border=0 align=left class=image>",$preview);}
}

?>

         <!-- блок Афиша -->
                <?
                   if($preview=="") {
                   echo "<tr><td class=reptbltop>&nbsp;&nbsp;&nbsp;
                         <a href=\"report.php?link=$idnum\"><strong>".$title."</strong></a></td></tr>";
                         }
                   elseif($preview != "" and $detail != ""){
                         echo "<tr><td class=reptbltop>&nbsp;&nbsp;&nbsp;
                               <a href=\"report.php?link=$idnum\"><strong>".$title."</strong></a></td></tr><tr><td class=reptbl><p align=justify>".$preview;
                         echo "<br><a href=\"report.php?link=$idnum\">Подробнее</a>&nbsp;&raquo;</p></td></tr>";
                         }
                   elseif($preview != "" and $detail == "") {
                         echo "<tr><td class=reptbltop>&nbsp;&nbsp;&nbsp;
                               <strong>".$title."</strong></td></tr><tr><td class=reptbl><p align=justify>".$preview."</p></td></tr>";
                        }
                   echo "<tr><td height=15></td></tr>";
 }

echo "<tr><td class=newstbl align=right><a href=\"report.php?c=$c\">Все обзоры</a>&nbsp;&raquo;</td></tr>";
echo "</table>";

echo "</td><td width=30></td></tr></table>";
} //1

include("down.php");
?>