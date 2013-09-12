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
echo"<title>FAQ : $sitename</title>";
include("top.php");
$n = getenv('REQUEST_URI');
echo "<h3 align=center>FAQ</h3>";
$new=$_GET['new'];
$add=$_POST['add'];
$question=$_GET['question'];
?>

<table width=100% border=0>
  <tr>
    <td align=center  class=header>
      <h3><a href="faq.php">Вопрос-Ответ</a>
<?      if(isset($new)){echo "» Новый вопрос";} ?>
<?      if(isset($add)){echo "» <a href=faq.php?new>Новый вопрос</a>";} ?>
      </h3>
    </td>
  </tr>
</table>

<hr>
<table width=100% cellpadding=10 border=0 cellspacing=0>
  <tr>
    <td>


<?
if(!ereg("\?",$REQUEST_URI))
{
?>
<!-- список вопросов -->
<table cellpadding=5 cellspacing=0 border=0 width=100%>
<?
  $result = mysql_query("select * from $faqtable order by idnum desc");
  $rows = mysql_num_rows($result);

  for($k=0;$k < $rows;$k++)
   {
    if(($k % 2) == 0){$bgcol=$color1;}
    else{$bgcol=$color2;}
    $z=$k+1;
    $vopros=mysql_result($result, $k , "vopros");
    $idnum=mysql_result($result, $k , "idnum");
    echo "<tr bgcolor=".$bgcol.">
            <td width=14 valign=top>
              ".$z.")
            </td>
            <td>
              <a href=\"faq.php?question=".$idnum."\">
              ".$vopros."
              </a>
            </td>
          </tr>";
   }
?>
</table>
<hr>
 <table width=100% cellpadding=5 border=0 cellspacing=0>
  <tr>
    <td align=right>
     <div class=contur style="width: 120px; text-align: center; padding: 2px; background-color: #F7F8FC;"><a href="faq.php?new=go">Задать вопрос</a></div>
    </td>
  </tr>
</table>
<?
}
if(isset($question))
{
 $qresult = mysql_query("select * from $faqtable where idnum='".$question."' ");
 $qrows   = mysql_num_rows($qresult);

 if($qrows > 0)
 {
  $name=mysql_result  ($qresult, 0 , "name"  );
  $email=mysql_result ($qresult, 0 , "email" );
  $vopros=mysql_result($qresult, 0 , "vopros");
  $otvet=mysql_result ($qresult, 0 , "otvet" );
  $time=mysql_result  ($qresult, 0 , "time"  );
  $datum=mysql_result ($qresult, 0 , "datum" );
  ?>
   <table width=100% cellpadding=5 border=0 cellspacing=0>
     <tr>
       <td class=jcontent><b>Вопрос:</b> <br> <?=$vopros?></td>
     </tr>
     <tr>
       <td class=jcontent><b>Ответ:</b> <br> <?=$otvet?></td>
     </tr>
   </table>
   <hr><a href=javascript:history.back(2)><center><< На предыдущую страницу</center></a>
  <?
 }
 else
 {
  echo "<p align=center>Error 404, Набран неправильный адрес!!!</p>";
 }

}
if(isset($new) and $new=='go'){
?>

<!-- forma -->
<form method=post action="faq.php?add=go">
<table cellpadding=5 cellspacing=0 border=0 width=100%>
  <tr>
    <td></td>
    <td></td>
    <td>Задать вопрос</td>
  </tr>
  <tr>
    <td width=60 align=right>Имя:</td>
    <td width=5></td>
    <td><input class=noborder type=text name=name size=30 MAXLENGTH=60></td>
  </tr>
  <tr>
    <td align=right>Email:</td>
    <td></td>
    <td><input class=noborder type=text name=email size=30 MAXLENGTH=100></td>
  </tr>
  <tr>
    <td valign=top align=right>Вопрос:</td>
    <td></td>
    <td><textarea name=content MAXLENGTH=700 class=noborder style="height: 70px; width: 70%; padding: 3px;"></textarea></td>
  </tr>
  <tr>
    <td><input type=hidden name="add" value="on"></td>
    <td></td>
    <td><input class=noborder type=submit value="&laquo; ok &raquo;"></td>
  </tr>
</table>
</form>


<?
}
elseif(isset($add))
{
  $name=$_POST['name'];
  $email=$_POST['email'];
  $content=$_POST['content'];

  if(isset($name) && $name!="" && isset($content) && $content!="")
  {

  //cutter!!!
  $name=substr($name,0,60);
  $email=substr($email,0,100);
  $content=substr($content,0,700);

  $name=htmlspecialchars($name);
  $email=htmlspecialchars($email);
  $content=htmlspecialchars($content);

  $ip=getenv("REMOTE_ADDR")."::".getenv("HTTP_X_FORWARDED_FOR");

   $year=date('Y');
   $month=date('m');
   $day=date('d');
   $datum = $year."-".$month."-".$day;

  $time=date('H:i');
  $brouser=getenv("HTTP_USER_AGENT");

        mysql_query("insert into $faqnewtable values(null,
            \"$time\",
            \"$datum\",
            \"$content\",
            \"$name\",
            \"$email\",
            \"$ip\",
            \"$brouser\")")or die(mysql_error());


//отправка всего этого на почту :)

$mt="<head><meta http-equiv='Content-Type' content='text/html; charset=windows-1251'></head>\n";

$mt.="<body bgcolor=white>\n";
$mt.="<b>Вопрос с сайта</b><hr size=1>";
$mt.="<table width=600 border=0 cellpadding=10 cellspacing=0>";
$mt.="<tr><td>ФИО:     </td><td>".$name."</td></tr>";
$mt.="<tr><td>E-mail:  </td><td>".$email."</td></tr>";
$mt.="<tr><td>Вопрос:  </td><td>".$content."</td></tr>";
$mt.="</table><hr size=1>";
$mt.="</body>\n";
$mt.="</html>\n";

mail($adminemail,"Вопрос с сайта",$mt,"From: $adminemail\nReturn-Path:$adminemail\nMime-Version: 1.0\nContent-Type: text/plain; charset=windows-1251\nContent-Transfer-Encoding:8bit\n");

//echo $mt;

//конец отправки


  echo "<p align=center>Спасибо! <br>
        Ваш вопрос будет рассмотрен и после проверки<br> администратором
        будет добавлен на сайт.</p>";
  }
  else
  {
    echo "<table align=center border=0>
           <tr><td class=content align=center style=\"color: red;\">";
    echo "Вопрос не может быть добавлен:<hr size=1>";
    echo "</td>
          </tr>
          <tr>
          <td class=content>
          <ul>";
    if(!isset($name) || $name==""){echo "<li>Поле \"<b>Имя</b>\" должно быть заполнено!</li>";}
    if(!isset($content) || $content==""){echo "<li>Поле \"<b>Вопрос</b>\" должно быть заполнено!</li>";}
    echo "</ul>";
    echo "</td></tr>
               <tr><td class=content>";
    echo "<hr><a href=javascript:history.back(2)><center><< Исправить</center></a>";
    echo "</td></tr></table>";
  }


}
?>
    </td>
  </tr>
</table>


<?
include("down.php");
?>