<?
session_start();
session_register("uid");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


<?php
include("var.php");
echo "<head><title>Администрирование - FAQ: $sitename</title>";
echo "<META NAME=ROBOTS CONTENT=\"NOINDEX, NOFOLLOW\">";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\">";
include("top.php");
$error = "";
$result = @mysql_query("SELECT pass FROM $admintable");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
if (!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass)
{
echo "<center><b>Вы не <a href=admin.php>авторизированы</a>!</b><br><br>";
}
else
{ // ok
if ($_GET['action'] == '') {$action=$_POST['action'];}
elseif ($_GET['action'] != '') {$action=$_GET['action'];}
echo "<center><p><strong><big>Администрирование - FAQ</strong></big>";

$new_result=mysql_query("select * from $faqnewtable ");
$new_rows=mysql_num_rows($new_result);

echo ("
<hr size=1 color=black noshade>
<table border=0><tr><td>
<a class=menu href=adminfaq.php?action=new>Новые вопросы</a> (<b><?=$new_rows?> шт.</b>) |
<a class=menu href=adminfaq.php?action=view>Просмотр информации</a> |
</td>
</tr>
</table>
<hr size=1 color=black noshade>
");


if(isset($action)=="" || !$action)
 {
//wellcome
 }
//############################################ MODELS ######################
elseif($action=="new")
 {
  echo "..:: Новые вопросы ::..<br><br>";
  // удаление
  if(@$_POST['delete'] == "on")
   {
    if (isset($_POST['id']))
     {
$id=$_POST['id'];
      $result = mysql_query("delete from $faqnewtable where idnum = '$id'");
      echo "<font color=red>Запись удачно удалена!!!</font><hr size=1><br>";
     }
   }

  echo "<table width=100% border=1 cellpadding=5 cellspacing=0 borderColor=#387ca0 borderColorDark=#ffffff borderColorLight=#387ca0>";
  echo "<tr style=\"font-weight: bold;\">";
  echo "<td width=20>№</td>";
  echo "<td width=10%>Дата / Время</td>";
  echo "<td width=10%>Автор / Email</td>";
  echo "<td width=70%>Содержание</td>";
  echo "<td width=50>&nbsp;</td>";
  echo "</tr>";

  $result = mysql_query("select * from $faqnewtable order by idnum desc");
  $rows = mysql_num_rows($result);
  if($rows>0)
   {
    for($k=0;$k<$rows;$k++)
    {
    if(($k % 2) == 0){$bgcol="#F7F8FC";}
    else{$bgcol="#EBEBEC";}
    $z=$k+1;
    $idnum=mysql_result($result, $k , "idnum");
    $datum=mysql_result($result, $k , "datum");
    $time=mysql_result($result, $k , "time");
    $name=mysql_result($result, $k , "name");
    $email=mysql_result($result, $k , "email");
    $vopros=mysql_result($result, $k , "vopros");
    echo "<tr bgcolor=".$bgcol.">";
    echo "<td valign=top>".$z."</td>";
    echo "<td valign=top><nobr>";
    echo $datum;
    echo "<br>";
    echo $time;
    echo "</nobr></td>";
    echo "<td valign=top>";
    echo $name;
    echo "<hr><a href=\"mailto:".$email."\">".$email."</a>";
    echo "</td>";
    echo "<td valign=top><b>";
    echo  $vopros;
    $ip=mysql_result($result, $k , "ip");
    $brouser=mysql_result($result, $k , "brouser");
    echo "</b><hr> IP адрес: ".$ip." <br>Браузер: ".$brouser." ";
    echo "</td>";
    echo "<form method=post class=bezots action=\"adminfaq.php\" name=dela".$k."><td valign=top align=right>";
    echo "<input type=button class=delbtn value=\"Удалить\" OnClick=\"dela".$k.".submit();\">";
    echo "<input type=hidden name=delete value=on>";
    echo "<input type=hidden name=action value=new>";
    echo "<input type=hidden name=id value=\"$idnum\">";
    echo "</form>";

    echo "</form><form method=post class=bezots action=\"adminfaq.php\" name=izmena".$k.">";
    echo "<input type=button class=izmbtn value=\"Ответить\" OnClick=\"izmena".$k.".submit();\">";
    echo "<input type=hidden name=action value=add_new>";
    echo "<input type=hidden name=id value=\"".$idnum."\">";
    echo "<input type=hidden name=datum value=\"".$datum."\">";
    echo "<input type=hidden name=time value=\"".$time."\">";
    echo "<input type=hidden name=name value=\"".$name."\">";
    echo "<input type=hidden name=email value=\"".$email."\">";
    echo "<input type=hidden name=vopros value=\"".$vopros."\">";
    echo "</td></form>";

    echo "</tr>";
   }

  echo "</table>";
  }




 }
elseif($action == "view")
 {
  echo "..:: Просмотр информации ::..<br><br>";

  // удаление ссылки
  if($_POST['delete'] == "on")
   {
    if (isset($_POST['id']))
     {
$id=$_POST['id'];
      $result = mysql_query("delete from $faqtable where idnum = '$id'");
      echo "<font color=red>Запись удачно удалена!!!</font><br><br>";
     }
   }

  $result = mysql_query("select * from $faqtable order by idnum desc");
  $rows = mysql_num_rows($result);

  echo "<table border=0 cellpadding=5 style=\"border: solid 1px gray;\">";

  echo "<tr style=\"font-weight: bold;\">";
  echo "<td width=20>№</td>";
  echo "<td width=14%>Автор / Email</td>";
  echo "<td width=20%>Вопрос</td>";
  echo "<td width=50%>Ответ</td>";
  echo "<td width=50></td>";
  echo "</tr>";

  for($k=0;$k < $rows;$k++)
   {
    if(($k % 2) == 0){$bgcol="#F7F8FC";}
    else{$bgcol="#EBEBEC";}
    $z=$k+1;
    $idnum=mysql_result($result, $k , "idnum");
    $name=mysql_result($result, $k , "name");
    $email=mysql_result($result, $k , "email");
    $vopros=mysql_result($result, $k , "vopros");
    $otvet=mysql_result($result, $k , "otvet");
    $time=mysql_result($result, $k , "time");
    $datum=mysql_result($result, $k , "datum");
    echo "<tr bgcolor=".$bgcol.">";
    echo "<td valign=top>".$z."</td>";
    echo "<td valign=top>".$name."<hr>";
    if($email!="none") echo "<a href=\"".$email."\" target=_blank class=linkz>".$email."</a>";
    echo "</td>";
    echo "<td valign=top>".$vopros."</td>";
    echo "<td valign=top>".$otvet."</td>";

    echo "<form method=post action=\"adminfaq.php\" name=dela".$k." style=\"margin: 0px; padding-bottom: 7px;\"><td valign=top align=right>";
    echo "<input style=\"width: 100px; background-color: red; color: white;\" type=button value=\"Удалить\" OnClick=\"dela".$k.".submit();\"><br>";
    echo "<input type=hidden name=delete value=on>";
    echo "<input type=hidden name=action value=view>";
    echo "<input type=hidden name=id value=".$idnum.">";
    echo "</form>";

    echo "<a href=adminfqc.php?texid=$idnum>Редактировать</a>";

    echo "</td>";
    echo "</tr>";
   }

  echo "</table>";

 }
elseif($action == "sql")
 {
  if(!isset($_POST['do']) || $_POST['do'] == "")
   {
    echo "<form>";
      echo "<a class=menu>Пожалуйста, введите свой SQL запрос:</a><br><br>";

      echo "<textarea cols=80 rows=6 name=qwery>select * from $faqtable</textarea><br>";
      echo "<input type=submit class=button value=Отправить style=\"position:relative; left:500px; top: 5px;\">";

      echo "<input type=hidden name=do value=result>";
      echo "<input type=hidden name=action value=sql>";

      echo "</form>";
      echo "<hr size=1 color=black noshade>";
      echo "<a class=menu>База данных</a><a class=menu3> ".$database."</a>
            <a class=menu>содержит следующие таблицы:</a>";
      echo "<ul><li><a>Таблица: </a><a class=menu3>$faqtable</a></li>";
      echo "</ul>";
      echo "<hr size=1 noshade color=black>";

      mysql_connect ($dbhostname , $dbusername , $dbpassword);
      @$result = mysql($database,"select * from $table_faq_main");
      $fields = mysql_num_fields($result);
      $rows = mysql_num_rows($result);

      echo "<a>Таблица </a><a class=menu3>$faqtable</a><a> содержит <b>".$fields."</b> колонок(и) и <b>".$rows."</b> записи(ей)";
            echo " и состоит из следующих полей:</a><br><table bgcolor=#ffffff border=1 cellspacing=0 cellpadding=3 bordercolor=#999999 width=100% style=\"font-size: 12px;\">";
      for($i=0; $i<$fields; $i++){
        $type  = mysql_field_type($result, $i);
        $name  = mysql_field_name($result, $i);
        $len   = mysql_field_len($result, $i);
        $flags = mysql_field_flags($result, $i);
        echo "<tr><td>".$type."</td><td>".$name."</td><td>".$len."</td><td>".$flags."</td></tr>\n";
      }
      echo "</table><hr size=1 color=black>";
   }
  elseif($_POST['do'] == "result")
   {
    mysql_connect ($dbhostname , $dbusername , $dbpassword);
    mysql_select_db($database);

    $qwery=stripSlashes($qwery);
    $result=mysql_query($qwery);

    echo "<a>Вы ввели запрос:</a> <a class=menu3>\" ".$qwery." \"</a><br><br> <a>Вот результат:</a> ";

     if ($result == 0)
      {
       echo "<a class=menu3> \" Ошибка ввода ".mysql_errno()." : ". mysql_error()." \" </a>";
      }
     elseif (mysql_num_rows($result) == 0)
      {
       echo "<a class=menu3> Запрос отработан, количество строк = 0 </a>";
      }
     else
      {
       echo "<table border=1 bordercolor=gray style=\"font-size:10px;font-family: Verdana,Arial,Helvetica;\"><thead><tr>";
       for ($i=0;$i<mysql_num_fields($result);$i++)
        {
         echo "<th style=\"padding: 5px; font-weight: bold; font-size: 12px;\">".mysql_field_name($result,$i)."</th>";
        }
         echo "</tr></thead><tbody>";

       for ($i=0; $i<mysql_num_rows($result);$i++)
        {
         echo "<tr>";
         $row_array = mysql_fetch_row($result);
         for ($j=0; $j<mysql_num_fields($result);$j++)
          {
           echo "<td style=\"padding: 5px;\">".$row_array[$j]."</td>";
          }
         echo "</tr>";
        }
         echo "</tbody></table>";

       }
        echo "<hr size=1 color=black noshade><a href=javascript:history.back(2) class=menu> << Создать еще запрос</a>";
   }
 }
elseif($action == "help")
 {
  echo "<p>


  </p>";
 }
elseif($action == "add_new")
 {

$time=$_POST['time'];
$datum=$_POST['datum'];
$vopros=$_POST['vopros'];
$otvet=$_POST['otvet'];
$name=$_POST['name'];
$email=$_POST['email'];
$vid=$_POST['vid'];
$id=$_POST['id'];

  ?>
    <form method=post action="adminfaq.php">
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
    <td><input type=hidden name="add" value="on"></td>
    <td></td>
    <td><input class=noborder type=submit value="&laquo; ok &raquo;"></td>
  </tr>
</table>
</form>

  <?
 }
elseif($action == "add_to_main")
 {
  // добавление ответа на вопрос
$time=$_POST['time'];
$datum=$_POST['datum'];
$vopros=$_POST['vopros'];
$otvet=$_POST['otvet'];
$name=$_POST['name'];
$email=$_POST['email'];
$vid=$_POST['vid'];
$id=$_POST['id'];

  if($name && $vopros  && $otvet)
     {
      $otvet = nl2br($otvet);
      if(!isset($email) || $email=="") $email="none";
      mysql_query("insert into $faqtable
                        values(null,
                        \"$time\",
                        \"$datum\",
                        \"$vopros\",
                        \"$otvet\",
                        \"$name\",
                        \"$email\")")or die(mysql_error());
      if($vid=="add")
      {
      mysql_query("delete from $faqnewtable where idnum=".$id." ") or die(mysql_error());
      }
      elseif($vid=="izm")
      {
      mysql_query("delete from $faqtable where idnum=".$id." ") or die(mysql_error());
      }
      echo "<font color=green>Информация успешно сохранена!</font>";
     }
    else
     {
      echo "Информация не может быть добавлена, вы ввели неверные данные<br><ul>";
      if(!$vopros){echo "<li>Поле \"Вопрос\" должно быть заполнено обязательно!</li>";}
      if(!$otvet) {echo "<li>Поле \"Ответ\" должно быть заполнено обязательно!</li>";}
      if(!$name)  {echo "<li>Поле \"Имя\" должно быть заполнено обязательно!</li>";}
      echo "</ul><hr size=1 color=black noshade></a><a href=javascript:history.back(2) class=menu><< Попробуйте еще раз.</a>";

     }

 }
else
 {
  echo "доступ закрыт!!!";
 }

} //ok
echo "<center><a href=admin.php>На общую страницу администрирования</a><br><br>";
include("down.php");
?>