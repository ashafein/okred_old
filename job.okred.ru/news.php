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
$link=$_GET['id'];

$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);

if ($link == '') {
echo "<title>������� : $sitename</title>";
}
if ($link != '') {
$resulttl = @mysql_query("SELECT idnum,title FROM $newstable where idnum='$link'");
while($myrow=mysql_fetch_array($resulttl)) {
$title=$myrow["title"];
}
echo "<title>$title : $sitename</title>";
}

include("top.php");
$n = getenv('REQUEST_URI');
echo "<h3 align=center class=tbl1>�������</h3>";

$now_month = date("n",time());
$now_year  = date("Y",time());
$now_today = date("j", time());


//�������
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
$daylong   = date("l",mktime(1,1,1,$month,$today,$year)); //���� ������ ����� ����.
$monthlong = date("F",mktime(1,1,1,$month,$today,$year)); //�������� ������ ����.
$dayone    = date("w",mktime(1,1,1,$month,1,$year)); //���� ������ ������
$numdays   = date("t",mktime(1,1,1,$month,1,$year)); //���������� ���� � ������
$alldays   = array('��','��','��','��','��','<font color=red>��</font>','<font color=red>��</font>');
$next_year = $year + 1;
$last_year = $year - 1;
$next_month = $month + 1;
$last_month = $month - 1;
if ($today > $numdays) { $today--; }
        if($month == "1" ){$month_ru="������";}
    elseif($month == "2" ){$month_ru="�������";}
    elseif($month == "3" ){$month_ru="����";}
    elseif($month == "4" ){$month_ru="������";}
    elseif($month == "5" ){$month_ru="���";}
    elseif($month == "6" ){$month_ru="����";}
    elseif($month == "7" ){$month_ru="����";}
    elseif($month == "8" ){$month_ru="������";}
    elseif($month == "9" ){$month_ru="��������";}
    elseif($month == "10"){$month_ru="�������";}
    elseif($month == "11"){$month_ru="������";}
    elseif($month == "12"){$month_ru="�������";}

echo "<table border=0 width=95% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table width=100% border=0 cellspacing=0 cellpadding=10 class=tbl1>";

if(!isset($_GET['id']))
{

$sql_date = $year."-".$month."-".$today;

if($now_today==$today && $now_month==$month && $now_year==$year && $start_news == "on")
{
 //echo "��,��, ���� �������!";
 $result = mysql_query("select * from $newstable order by datum desc, time desc limit ".$news_num." ");
 $rows = mysql_num_rows($result);
}
else
{
$result = mysql_query("select * from $newstable where datum = '".$sql_date."' order by time desc");
$rows = mysql_num_rows($result);
}

   if($rows==0) {
       $result = mysql_query("select * from $newstable order by datum desc, time desc limit ".$news_num." ");
       $rows = mysql_num_rows($result);
       }

for($k=0;$k < $rows;$k++)
   {
    $content=mysql_result($result, $k , "content");
    $content = ereg_replace("\n","<br>",$content);
    $title=mysql_result($result, $k , "title");
    $idnum=mysql_result($result, $k , "idnum");
    $datum=mysql_result($result, $k , "datum");

    $dati=explode("-",$datum);
    $shot_content=explode("[cut]",$content);



?>

         <!-- ���� ������� -->
              <tr bgcolor=<? echo "$altcolor"; ?>>
                <td><img src=picture/spacer.gif height=1></td>
              </tr>
              <tr bgcolor=<? echo "$maincolor"; ?>>
                <td>
                <?
                   if($shot_content[0]=="") {
                   echo "<font color=green>$dati[2].$dati[1].$dati[0]</font> <a href=\"news.php?cont=long&id=$idnum&year=$dati[0]&today=$dati[2]&month=$dati[1]\"><b>$title</b></a>";
                         }
                   elseif($shot_content[0]!="" && ereg("\[cut\]",$content) ){
                         echo "<font color=green>$dati[2].$dati[1].$dati[0]</font> <a href=\"news.php?id=$idnum\"><b>$title</b></a><br>$shot_content[0]";
                         echo " <a href=\"news.php?id=$idnum\">���������</a>&nbsp;&raquo;</p>";
                         }
                   else {
                         echo "<font color=green>$dati[2].$dati[1].$dati[0]</font> <b>$title</b><br>$content";
                        }
                ?>
                </td>
              </tr>



<?
 }

}
elseif(isset($_GET['id']))
{
$id=$_GET['id'];
   echo "<!-- ���������� ������� -->
              <tr>
                <td><img src=picture/spacer.gif height=1></td>
              </tr>
              <tr>
                <td>";



   $result = mysql_query("select * from $newstable where idnum='".$id."'  limit 1");
   $rows = mysql_num_rows($result);

   if($rows > 0)
   {
    $datum   = mysql_result($result, 0 , "datum"  );
    $title   = mysql_result($result, 0 , "title"  );
    $idnum   = mysql_result($result, 0 , "idnum"  );
    $content = mysql_result($result, 0 , "content");
    $content = ereg_replace("\n","<br>",$content);
    $content = str_replace("[cut]"," ",$content);

    $dati=explode("-",$datum);

    $datun=explode("-",$datum);
        if($datun[1] == "1" || $datun[1] == "01"){$month="������";}
    elseif($datun[1] == "2" || $datun[1] == "02"){$month="�������";}
    elseif($datun[1] == "3" || $datun[1] == "03"){$month="�����";}
    elseif($datun[1] == "4" || $datun[1] == "04"){$month="������";}
    elseif($datun[1] == "5" || $datun[1] == "05"){$month="���";}
    elseif($datun[1] == "6" || $datun[1] == "06"){$month="����";}
    elseif($datun[1] == "7" || $datun[1] == "07"){$month="����";}
    elseif($datun[1] == "8" || $datun[1] == "08"){$month="�������";}
    elseif($datun[1] == "9" || $datun[1] == "09"){$month="��������";}
    elseif($datun[1] == "10"){$month="�������";}
    elseif($datun[1] == "11"){$month="������";}
    elseif($datun[1] == "12"){$month="�������";}
    ?>
      <table width=100% border=0 cellpadding=3 cellspacing=0 class=tbl1>
        <tr>
          <td align=center>
          <b><nobr><?=$datun[2]?> <?=$month?> <?=$datun[0]?></nobr></b>
          </td>
        </tr>
      </table>
     <table width=100% cellpadding=5 border=0 cellspacing=0 class=tbl1>
       <tr>
         <td class=header align=center><h3><?=$title?></h3></td>
       </tr>
       <tr>
         <td style="text-align: justify; background-color: white; padding: 15px;">
            <?=$content?>
         </td>
       </tr>
     </table><br><br>
     <table width="100%" border="0" cellspacing="0" cellpadding="3" class=tbl1>
        <tr>
     <?
     echo "<td align=center><a href=\"javascript:history.back(2);\">&laquo; �����</a></td>";
     ?>
        </tr>
      </table>


    <?
   }

 echo "</td>
     </tr>";




}
?>
</table></td></tr></table>


<?
include("down.php");
?>