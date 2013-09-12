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
echo "<title>Администрирование - Удаление резюме: $sitename</title>";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\">";
include("top.php");

$updres=mysql_query("update $restable set top='0000-00-00 00:00:00' where ((top + INTERVAL 86400*$periodfortop SECOND) < now())");
$updres=mysql_query("update $restable set bold='0000-00-00 00:00:00' where ((bold + INTERVAL 86400*$periodforbold SECOND) < now())");

$result = @mysql_query("SELECT pass FROM $admintable");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
$err2="Не выбрано ни одного объявления!<br>";
$error = "";
if (!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass)
{
echo "<center><b>Вы не <a href=admin.php>авторизированы</a>!</b><br><br>";
}
else
{ // ok
if ($_SERVER[QUERY_STRING] != "del"){
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
$srname=$_GET['srname'];
$result = @mysql_query("SELECT ID,date FROM $restable");
$totalThread = @mysql_num_rows($result);
$mes = $totalThread;
unset($result);
$page=$_GET['page'];
if(!isset($page)) $page = 1;
if( $totalThread <= $maxThread ) $totalPages = 1;
elseif( $totalThread % $maxThread == 0 ) $totalPages = $totalThread / $maxThread;
else $totalPages = ceil( $totalThread / $maxThread );
if( $totalThread == 0 ) $threadStart = 0;
else $threadStart = $maxThread * $page - $maxThread + 1;
if( $page == $totalPages ) $threadEnd = $totalThread;
else $threadEnd = $maxThread * $page;
$initialMsg = $maxThread * $page - $maxThread;
$pages = (int) (($totalThread + $maxThread - 1) / $maxThread);
$line = "Страница: |";
for ($k = 1; $k <= $pages; $k++) {
  if ($k != $page) {$line .= "<a href=\"admindr.php?srname=$srname&page=$k\"> $k </a>|";}
  if ($k == $page) {$line .= " $k |";}
}
echo "<center><p><strong><big>Администрирование - Удаление резюме</strong></big>";
echo ("
<form name=sr method=get action=admindr.php>
Строка для поиска (по номеру или профессии): <input type=text name=srname size=10>&nbsp;<input type=submit name=submit value='Найти'></form><br><br>
");
echo "<form name=delreg method=post action=admindr.php?del>";
if ($srname != "") {$srname = ereg_replace(" ","*.",$srname); $qwery2="and (ID = '$srname' or profecy REGEXP '$srname')";}
if (!isset($srname) or $srname == "") {$qwery2='';}
$result = @mysql_query("SELECT *,CURRENT_DATE,(YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) AS age,DATE_FORMAT(date,'%d.%m.%Y') as date,DATE_FORMAT((top + INTERVAL 86400*$periodfortop SECOND),'%d.%m.%Y') as topq,DATE_FORMAT((bold + INTERVAL 86400*$periodforbold SECOND),'%d.%m.%Y') as boldq FROM $restable WHERE ID != '' $qwery2 order by ID DESC LIMIT $initialMsg, $maxThread");
$totaltexts=@mysql_num_rows($result);
if ($totaltexts == 0) {echo "<center><b>Объявлений пока нет!</b>";}
else
{ //2
echo "<center>Для удаления резюме пометьте их галочкой и нажмите кнопку \"Удалить отмеченные\"<br>Всего резюме: <b>$totaltexts</b><br><br>";
echo ("
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$maincolor><td><img src=\"picture/basket.gif\" border=0></td><td>Должность</td><td>Зарплата</td><td>Дата публ.</td><td>Опции</td></tr>
");
while ($myrow=mysql_fetch_array($result)) 
{ //4
$id=$myrow["ID"];
$profecy=$myrow["profecy"];
$zp=$myrow["zp"];
$grafic=$myrow["grafic"];
$zanatost=$myrow["zanatost"];
$aid=$myrow["aid"];
$top=$myrow["top"];
$bold=$myrow["bold"];
$topq=$myrow["topq"];
$topql='';
if ($top != '0000-00-00 00:00:00') {$topql="<br><b>вверху до $topq</b>";}
$boldq=$myrow["boldq"];
$boldql='';
if ($bold != '0000-00-00 00:00:00') {$boldql="<br><b>выделено до $topq</b>";}

$resultaut = @mysql_query("SELECT *,CURRENT_DATE,(YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) AS age FROM $autortable WHERE ID='$aid'");
while ($myrow1=mysql_fetch_array($resultaut)) {
$prof=$myrow1["prof"];
$gender=$myrow1["gender"];
$age=$myrow1["age"];
$category=$myrow1["category"];
}
if ($category == 'agency')
{
$age=$myrow["age"];
$gender=$myrow["gender"];
$prof=$myrow["prof"];
}
$date=$myrow["date"];
$razdel=$myrow["razdel"];
$podrazdel=$myrow["podrazdel"];
$status=$myrow["status"];
$archivedate=$myrow["archivedate"];
$resultadd2 = @mysql_query("SELECT ID,podrazdel FROM $catable WHERE ID='$podrazdel'");
while($myrow=mysql_fetch_array($resultadd2)) {
$podrazdel1=$myrow["podrazdel"];
}
$resultadd1 = @mysql_query("SELECT ID,razdel,podrazdel FROM $catable WHERE podrazdel = '' and ID='$razdel'");
while($myrow=mysql_fetch_array($resultadd1)) {
$razdel1=$myrow["razdel"];
}
if ($status=='ok') {$statusline='<font color=green>Доступна</font>';}
if ($status=='wait') {$statusline='<font color=red>На проверке</font>';}
if ($status=='archive') {$statusline='<font color=blue>В архиве (с $archivedate)</font>';}
echo ("
<tr bgcolor=$maincolor>
<td valign=top width=20><input type=checkbox name=confmes[] value=$id></td>
<td valign=top><a href=adminlr.php?link=$id target=_blank><b>$profecy</b></a><br>$razdel1&nbsp;/&nbsp;$podrazdel1<br>
");
$br=0;
if ($gender == 'Мужской') {$br=1; echo "Мужчина&nbsp;";}
if ($gender == 'Женский') {$br=1; echo "Женщина&nbsp;";}
if ($age != 0) {$br=1; echo "$age лет(года);&nbsp";}
if ($grafic != '' and !eregi("важно",$grafic)) {if ($br==1) {echo "<br>";} $br=1; echo "$grafic";}
if ($prof != '') {if ($br==1) {echo "<br>";} echo "Проф.навыки: $prof";}
echo ("
</td>
<td valign=top>
");
if ($zp != 0) {echo "<b>$zp</b> $valute";}
elseif ($zp == 0) {echo "";}
echo ("
</td>
<td valign=top>$date$topql$boldql<br><a href=adminlr.php?link=$id target=_blank><small>Подробнее...</small></a></td>
<td valign=top>
<a href=admincr.php?texid=$id>Правка</a>
");
if ($category == 'agency') {echo "<br><a href=admincf.php?texid=$id>Фотографии</a>";}
echo ("
</td>
</tr>
");
} //4
echo "</table></td></tr></table>";
echo "<center>$line<p>";
echo ("
<center><input type=submit value='Удалить отмеченные' name=submit><br><br>
<input type=submit name=long value=\"Обновить отмеченные\"><br><br>
<input type=submit value='Поднять резюме' name=top>&nbsp;<input type=submit value='Выделить резюме' name=bold>
</form>
");
}//2
}
if ($_SERVER[QUERY_STRING] == "del"){
$confmes=$_POST['confmes'];
if (count($confmes)==0) {
	$error .= "$err2";}
if ($error != ""){
echo "<center><h3>Ошибка</h3><font color=red>$error</font><p><a href=# onClick=history.go(-1)>Вернуться назад</a><p><br><br><br><br><br><br><br><br>";
}
if ($error==""){
unset($result);
if (isset($_POST['submit']))
{ //del
for ($i=0;$i<count($confmes);$i++){
unset($result);
$res2 = @mysql_query("SELECT * FROM $restable WHERE ID=$confmes[$i]");
while($myrow=mysql_fetch_array($res2)) {
$foto1=$myrow["foto1"];
}
@unlink($upath.$photodir.$foto1);
@unlink($upath.$photodir.'s'.$foto1);
$result=@mysql_query("delete from $restable where ID=$confmes[$i]");
}
echo "<br><br><h3 align=center>Выбранные резюме удалены!</h3><br><br>";
} //del

if (isset($_POST['top']))
{ //top
for ($i=0;$i<count($confmes);$i++){
$result=@mysql_query("update $restable set top=now() where ID=$confmes[$i]");
}
echo "<h3 align=center>Выбранные резюме подняты!</h3><br><br>";
} //top
if (isset($_POST['bold']))
{ //bold
for ($i=0;$i<count($confmes);$i++){
$result=@mysql_query("update $restable set bold=now() where ID=$confmes[$i]");
}
echo "<h3 align=center>Выбранные резюме выделены!</h3><br><br>";
} //bold

if (isset($_POST['long']))
{ // long
for ($i=0;$i<count($confmes);$i++){
$result=@mysql_query("update $restable set date=now(),archivedate='0000-00-00 00:00:00',status='ok' where ID=$confmes[$i]");
}
echo "<h3 align=center>Выбранные резюме продлены!</h3><br><br>";
} // long

}
}
} //ok
echo "<center><a href=admin.php>На общую страницу администрирования</a><br><br>";
include("down.php");
?>