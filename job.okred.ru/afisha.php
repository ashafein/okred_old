<?
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<?php
include("var.php");

$link=$_GET['link'];
$year=$_GET['year'];
$month=$_GET['month'];
$today=$_GET['today'];

if(!isset($link)) {echo"<title>����� ������� : $sitename</title>";}
if(isset($link)) {
$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);
$maxname = 50;
$maxemail = 50;
$maxcomment = 400;
$err1 = "$t18 - $t68 (< $maxname)<br>";
$err2 = "$t20 - $t68 (< $maxemail)<br>";
$err3 = "$t145 - $t68 (< $maxcomment)<br>";
$err4 = "$t18 - $t69!<br>";
$err5 = "$t145 - $t69!<br>";
$err6 = "$t167<br>";
$result = @mysql_query("SELECT ID,title FROM $afishatable WHERE ID = '$link'");
while ($myrow=mysql_fetch_array($result))
{
$title=$myrow["title"];
}
echo"<title>$title : $sitename</title>";
}
include("top.php");

echo "<b>������:</b> ";
$resultcat = @mysql_query("SELECT * FROM $afishacatable order by ID DESC");
while($myrow=mysql_fetch_array($resultcat)) {
$categ=$myrow["category"];
$categID=$myrow["ID"];
echo "<a href=\"listaf.php?c=$categID\">$categ</a>&nbsp;|&nbsp;";
}
echo "<br><br>";
?>


<table width="100%" border="0" cellspacing="8" cellpadding="2">
  <tr><td><b>�����</b></td></tr>
  <tr>
    <td>
     <?

        if($month == "1" ){$month_rus="������";}
    elseif($month == "2" ){$month_rus="�������";}
    elseif($month == "3" ){$month_rus="�����";}
    elseif($month == "4" ){$month_rus="������";}
    elseif($month == "5" ){$month_rus="���";}
    elseif($month == "6" ){$month_rus="����";}
    elseif($month == "7" ){$month_rus="����";}
    elseif($month == "8" ){$month_rus="�������";}
    elseif($month == "9" ){$month_rus="��������";}
    elseif($month == "10"){$month_rus="�������";}
    elseif($month == "11"){$month_rus="������";}
    elseif($month == "12"){$month_rus="�������";}

      //echo "����� �� ".$today." ".$month_rus." ".$year;
      //echo "�����";
     ?>
    </td>
  </tr>
<?php

if(!isset($link))
{

$sql_date = $year."-".$month."-".$today;

if($now_today==$today && $now_month==$month && $now_year==$year && $start_news == "on")
{
 //echo "�������!";
 $result = mysql_query("select * from $afishatable order by datum desc,date desc limit ".$news_num." ");
 $rows = mysql_num_rows($result);
}
elseif($now_today==$today && $now_month==$month && $now_year==$year && $start_news == "off" and eregi('today',$n))
{
 //echo "�������!";
 $result = mysql_query("select * from $afishatable where (datum = '".$sql_date."' or (datum <= '".$sql_date."' and datumend != '0000-00-00' and datumend >= '".$sql_date."')) order by datum desc,date desc limit ".$news_num." ");
 $rows = mysql_num_rows($result);
}
elseif($now_today==$today && $now_month==$month && $now_year==$year && $start_news == "off" and !eregi('today',$n))
{
 //echo "�������!";
 $result = mysql_query("select * from $afishatable where (datum = '".$sql_date."' or (datumend != '0000-00-00' and datumend >= '".$sql_date."')) order by datum desc,date desc limit ".$news_num." ");
 $rows = mysql_num_rows($result);
}
else
{
$result = mysql_query("select * from $afishatable where (datum = '".$sql_date."' or (datum < '".$sql_date."' and datumend != '0000-00-00' and datumend >= '".$sql_date."')) order by date desc");
$rows = mysql_num_rows($result);
}

   if($rows==0) {
       $result = mysql_query("select * from $afishatable where (datum >= '".$sql_date."' or (datum < '".$sql_date."' and datumend != '0000-00-00' and datumend >= '".$sql_date."')) order by datum desc,date desc limit ".$news_num." ");
       $rows = mysql_num_rows($result);
       }

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
if (eregi('����1',$preview) and $foto1 != ""){$preview=@str_replace('����1',"<img src=\"$afishadir$foto1\" border=0 align=left class=image>",$preview);}
}

?>

         <!-- ���� ����� -->
<?
if($preview=="") {
echo "<tr><td class=newstbltop><font color=#555555>$dati[2].$dati[1].$dati[0]";
if ($datumend != '0000-00-00') {$datumend=explode("-",$datumend);echo "&nbsp;-&nbsp;$datumend[2].$datumend[1].$datumend[0]";}
echo "</font>&nbsp;&nbsp;&nbsp;<a href=\"afisha.php?link=".$idnum."&year=".$dati[0]."&today=".$dati[2]."&month=".$dati[1]."\"><strong>".$title."</strong></a></td></tr>";
}
elseif($preview != "" and $detail != ""){
echo "<tr><td class=newstbltop><font color=#555555>$dati[2].$dati[1].$dati[0]";
if ($datumend != '0000-00-00') {$datumend=explode("-",$datumend);echo "&nbsp;-&nbsp;$datumend[2].$datumend[1].$datumend[0]";}
echo "</font>&nbsp;&nbsp;&nbsp;<a href=\"afisha.php?link=".$idnum."&year=".$dati[0]."&today=".$dati[2]."&month=".$dati[1]."\"><strong>".$title."</strong></a></td></tr><tr><td class=newstbl><p align=justify>".$preview;
echo "<br><a href=\"afisha.php?link=".$idnum."&year=".$dati[0]."&today=".$dati[2]."&month=".$dati[1]."\">���������</a>&nbsp;&raquo;</p></td></tr>";
}
elseif($preview != "" and $detail == "") {
echo "<tr><td class=newstbltop><font color=#555555>$dati[2].$dati[1].$dati[0]";
if ($datumend != '0000-00-00') {$datumend=explode("-",$datumend);echo "&nbsp;-&nbsp;$datumend[2].$datumend[1].$datumend[0]";}
echo "</font>&nbsp;&nbsp;&nbsp;<strong>".$title."</strong></td></tr><tr><td class=newstbl><p align=justify>".$preview."</p></td></tr>";
}
echo "<tr><td height=15></td></tr>";
 }

}
elseif(isset($link) && $link != "")
{

   echo "<!-- ���������� ����� -->
              <tr>
                <td class=newstbl>";



   $result = mysql_query("select *,DATE_FORMAT(date,'%d.%m.%Y') as date from $afishatable where ID='".$link."'  limit 1");
   $rows = mysql_num_rows($result);

   if($rows > 0)
   {
while ($myrow=@mysql_fetch_array($result)) 
{
$date=$myrow["date"];
}
    $datum   = mysql_result($result, 0 , "datum"  );
    $datumend   = mysql_result($result, 0 , "datumend"  );
    $zav   = mysql_result($result, 0 , "zav"  );
    $autor   = mysql_result($result, 0 , "autor"  );
    $time   = mysql_result($result, 0 , "time"  );
    $otchet   = mysql_result($result, 0 , "otchet"  );
    $title   = mysql_result($result, 0 , "title"  );
    $idnum   = mysql_result($result, 0 , "ID"  );
    $detail = mysql_result($result, 0 , "detail");
    $foto1=mysql_result($result, 0 , "foto1");
    $foto2=mysql_result($result, 0 , "foto2");
    $foto3=mysql_result($result, 0 , "foto3");
    $foto4=mysql_result($result, 0 , "foto4");
    $foto5=mysql_result($result, 0 , "foto5");
if ($detail != "") {
$detail = ereg_replace("\n","<br>",$detail);
$detail = ereg_replace("     ","&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$detail);
if (eregi('����1',$detail) and $foto1 != ""){$detail=@str_replace('����1',"<img src=\"$afishadir$foto1\" border=0 align=left class=image>",$detail);}
if (eregi('����2',$detail) and $foto2 != ""){$detail=@str_replace('����2',"<img src=\"$afishadir$foto2\" border=0 align=left class=image>",$detail);}
if (eregi('����3',$detail) and $foto3 != ""){$detail=@str_replace('����3',"<img src=\"$afishadir$foto3\" border=0 align=right class=image>",$detail);}
if (eregi('����4',$detail) and $foto4 != ""){$detail=@str_replace('����4',"<img src=\"$afishadir$foto4\" border=0 align=left class=image>",$detail);}
if (eregi('����5',$detail) and $foto5 != ""){$detail=@str_replace('����5',"<img src=\"$afishadir$foto5\" border=0 align=right class=image>",$detail);}
}

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

    $datunend=explode("-",$datumend);
        if($datunend[1] == "1" || $datunend[1] == "01"){$monthend="������";}
    elseif($datunend[1] == "2" || $datunend[1] == "02"){$monthend="�������";}
    elseif($datunend[1] == "3" || $datunend[1] == "03"){$monthend="�����";}
    elseif($datunend[1] == "4" || $datunend[1] == "04"){$monthend="������";}
    elseif($datunend[1] == "5" || $datunend[1] == "05"){$monthend="���";}
    elseif($datunend[1] == "6" || $datunend[1] == "06"){$monthend="����";}
    elseif($datunend[1] == "7" || $datunend[1] == "07"){$monthend="����";}
    elseif($datunend[1] == "8" || $datunend[1] == "08"){$monthend="�������";}
    elseif($datunend[1] == "9" || $datunend[1] == "09"){$monthend="��������";}
    elseif($datunend[1] == "10"){$monthend="�������";}
    elseif($datunend[1] == "11"){$monthend="������";}
    elseif($datunend[1] == "12"){$monthend="�������";}

    ?>
      <table width=100% border=0 cellpadding=3 cellspacing=0>
        <tr>
          <td>
<?
echo ("
<h3>$title</h3>
<p align=justify class=text><big>$datun[2] $month
");
if ($datumend != '0000-00-00') {$datiend=explode("-",$datumend); echo "- $datiend[2]"; if ($monthend != '$month') {echo " $monthend";}}
echo ("
 $datun[0]&nbsp;&nbsp;$time</big>
");
if ($zav != '' and $zav != '0')
{
$resultadd1 = @mysql_query("SELECT * FROM $zavtable WHERE ID='$zav' LIMIT 1");
while($myrow=mysql_fetch_array($resultadd1)) {
$zav=$myrow["name"];
$zavID=$myrow["ID"];
}
echo "<br><a href=zav.php?link=$zavID>$zav</a>";
}
echo ("
</p>
<p align=justify class=text>$detail</p>
");
$resultrep = @mysql_query("SELECT * FROM $reporttable WHERE aid='$link'");
if (mysql_num_rows($resultrep) != 0) {
while($myrow=mysql_fetch_array($resultrep)) {
$repID=$myrow["ID"];
}
echo "<p align=left class=text><b><a href=report.php?link=$repID>�������� ����� � �����������</a>&nbsp;&raquo;</b></p>";
}
if (mysql_num_rows($resultrep) == 0 and $otchet != '')
{
echo "<p align=left class=text><b>��������� ����� � �����������!</b></p>";
}
echo ("
<p align=right class=text>$date
");
if ($autor != '') {echo "<br>$autor";}

echo "</p>";

// ������
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
$sql="insert into $afishacommentstable (tid,name,email,comment,date,categ) values ('$link','$name','$email','$comment',now(),'afisha')";
$result=@mysql_query($sql,$db);
}
}
$result = @mysql_query("SELECT * FROM $afishacommentstable WHERE tid = $link and categ='afisha'");
$totalcomment=@mysql_num_rows($result);
if ($totalcomment == 0) {
echo "<center><br>$t146!<br><br>";
}
else
{ //2
$result = @mysql_query("SELECT * FROM $afishacommentstable WHERE tid = $link and categ='afisha'");
echo "<b>����� �������</b>: $totalcomment<br><br>";
while ($myrow=mysql_fetch_array($result)) {
$tid=$myrow["tid"];
$name=$myrow["name"];
$email=$myrow["email"];
$comment=$myrow["comment"];
$comment = ereg_replace("\n","<br>",$comment);
$date=$myrow["date"];
echo ("
<div align=left><table class=tbl1 bgcolor=$bordercolor width=90% border=0>
<tr bgcolor=$maincolor><td align=left><b>$t18: </b><a href=mailto:$email>$name</a><br>$t23: <i>$date</i></td></tr>
<tr bgcolor=$maincolor><td align=left><p align=justify>$comment</p></td></tr>
</table></div><br><br>
");
}
} //2
if (!isset($_POST['submit'])){
echo ("
<h3 align=center>$t148</h3>
<center><strong>$t60</strong></p>
<form name=form method=post action=afisha.php>
<input type=hidden name=link value=$link>
<table class=tbl1 width=90% bgcolor=$maincolor>
<tr bgcolor=$maincolor><td align=right width=60%><strong><font color=#FF0000>*</font>���:</strong></td>
<td width=60%><input type=text name=name size=50></td></tr>
<tr bgcolor=$maincolor><td align=right width=60% bgcolor=$maincolor><strong>E-mail:</strong></td>
<td width=60%><input type=text name=email size=50></td></tr>
<tr bgcolor=$maincolor><td align=right width=60%><strong><font color=#FF0000>*</font>���������:</strong></td>
<td width=60%><textarea rows=4 name=comment cols=43></textarea></td></tr>
<tr bgcolor=$maincolor><td colspan=2 align=center>
");
echo "<input type=submit value=\"���������\" name=\"submit\"></td></tr></table></form>";
}
// ������

?>
          </td>
        </tr>
      </table><br>

    <?
   }

 echo "</td>
     </tr>";




}
?>
</table>


<?
include("down.php");
?>