<?
session_start();
session_register("uid");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META NAME=ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<?php
include("var.php");
$maxThread = 20;
echo "<title>Администрирование - Удаление вакансий: $sitename</title>";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\">";
include("top.php");

$updres=mysql_query("update $vactable set top='0000-00-00 00:00:00' where ((top + INTERVAL 86400*$periodfortop SECOND) < now())");
$updres=mysql_query("update $vactable set bold='0000-00-00 00:00:00' where ((bold + INTERVAL 86400*$periodforbold SECOND) < now())");

$result = @mysql_query("SELECT pass FROM $admintable");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
$err1="Неверный пароль!<br>";
$err2="Не выбрано ни одного объявления!<br>";
$error = "";
if (!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass)
{
echo "<center><b>Вы не <a href=admin.php>авторизированы</a>!</b><br><br>";
}
else
{ // ok
if ($_SERVER[QUERY_STRING] != "del"){
$srname=$_GET['srname'];
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
$result = @mysql_query("SELECT ID,date FROM $vactable");
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
  if ($k != $page) {$line .= "<a href=\"admindv.php?srname=$srname&page=$k\"> $k </a>|";}
  if ($k == $page) {$line .= " $k |";}
}
echo "<center><p><strong><big>Администрирование - Удаление вакансий</strong></big>";
echo ("
<form name=sr method=get action=admindv.php>
Строка для поиска (по номеру или профессии): <input type=text name=srname size=10>&nbsp;<input type=submit name=submit value='Найти'></form><br><br>
");
echo "<form name=delreg method=post action=admindv.php?del>";
if ($srname != "") {$srname = ereg_replace(" ","*.",$srname); $qwery2="and (ID = '$srname' or profecy REGEXP '$srname')";}
if (!isset($srname) or $srname == "") {$qwery2='';}
$result = @mysql_query("SELECT *,DATE_FORMAT(date,'%d.%m.%Y') as date,DATE_FORMAT((top + INTERVAL 86400*$periodfortop SECOND),'%d.%m.%Y') as topq,DATE_FORMAT((bold + INTERVAL 86400*$periodforbold SECOND),'%d.%m.%Y') as boldq FROM $vactable WHERE ID != '' $qwery2 order by ID DESC LIMIT $initialMsg, $maxThread");
$totaltexts=@mysql_num_rows($result);
if ($totaltexts == 0) {echo "<center><b>Вакансий пока нет!</b>";}
else
{ //2
echo "<center>Для удаления вакансий пометьте их галочкой и нажмите кнопку \"Удалить отмеченные\"<br>Всего вакансий: <b>$totaltexts</b><br><br>";
echo ("
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$maincolor><td><img src=\"picture/basket.gif\" border=0></td><td>Должность</td><td>Зарплата</td><td>Дата публ.</td><td>Опции</td></tr>
");
while ($myrow=mysql_fetch_array($result)) 
{ //4
$id=$myrow["ID"];
$profecy=$myrow["profecy"];
$zp=$myrow["zp"];
$agemin=$myrow["agemin"];
$agemax=$myrow["agemax"];
$edu=$myrow["edu"];
$gender=$myrow["gender"];
$grafic=$myrow["grafic"];
$zanatost=$myrow["zanatost"];
$treb=$myrow["treb"];
$aid=$myrow["aid"];
$status=$myrow["status"];
$archivedate=$myrow["archivedate"];
$date=$myrow["date"];
$razdel=$myrow["razdel"];
$podrazdel=$myrow["podrazdel"];
$top=$myrow["top"];
$bold=$myrow["bold"];
$topq=$myrow["topq"];
$topql='';
if ($top != '0000-00-00 00:00:00') {$topql="<br><b>вверху до $topq</b>";}
$boldq=$myrow["boldq"];
$boldql='';
if ($bold != '0000-00-00 00:00:00') {$boldql="<br><b>выделено до $topq</b>";}

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
<td valign=top><a href=adminlv.php?link=$id target=_blank><b>$profecy</b></a><br>$razdel1&nbsp;/&nbsp;$podrazdel1<br>
");
$br=0;
if ($gender == 'Мужской') {$br=1; echo "Мужчина&nbsp;";}
if ($gender == 'Женский') {$br=1; echo "Женщина&nbsp;";}
if ($agemin != 0 and $agemax == 0) {$br=1; echo "от $agemin лет;&nbsp";}
if ($agemin == 0 and $agemax != 0) {$br=1; echo "до $agemax лет;&nbsp";}
if ($agemin != 0 and $agemax != 0) {$br=1; echo "от $agemin до $agemax лет;&nbsp";}
if ($edu != '' and $edu != 'Не&nbsp;важно') {$br=1; echo "образование $edu;&nbsp";}
if ($grafic != '' and !eregi("важно",$grafic)) {echo "<br>$grafic";}
if ($br==1) {echo "<br>";}
echo ("
Требования: $treb
</td>
<td valign=top><b>$zp</b> $valute</td>
<td valign=top>$date$topql$boldql<br><a href=adminlv.php?link=$id target=_blank><small>Подробнее...</small></a></td>
<td valign=top>
<a href=admincv.php?texid=$id>Правка</a>
</td>
</tr>
");
} //4
echo "</table></td></tr></table>";
echo "<center>$line<p>";
echo ("
<center><input type=submit value='Удалить отмеченные' name=submit><br><br>
<input type=submit name=long value=\"Обновить отмеченные\"><br><br>
<input type=submit value='Поднять вакансии' name=top>&nbsp;<input type=submit value='Выделить вакансии' name=bold>
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
$result=@mysql_query("delete from $vactable where ID=$confmes[$i]");
}
echo "<h3 align=center>Выбранные вакансии удалены!</h3><br><br>";
} //del

if (isset($_POST['top']))
{ //top
for ($i=0;$i<count($confmes);$i++){
$result=@mysql_query("update $vactable set top=now() where ID=$confmes[$i]");
}
echo "<h3 align=center>Выбранные вакансии подняты!</h3><br><br>";
} //top
if (isset($_POST['bold']))
{ //bold
for ($i=0;$i<count($confmes);$i++){
$result=@mysql_query("update $vactable set bold=now() where ID=$confmes[$i]");
}
echo "<h3 align=center>Выбранные вакансии выделены!</h3><br><br>";
} //bold

if (isset($_POST['long']))
{ // long
for ($i=0;$i<count($confmes);$i++){
$result=@mysql_query("update $vactable set date=now(),archivedate='0000-00-00 00:00:00',status='ok' where ID=$confmes[$i]");
}
echo "<h3 align=center>Выбранные вакансии продлены!</h3><br><br>";
} // long

}
}
} //ok
echo "<center><a href=admin.php>На общую страницу администрирования</a><br><br>";
include("down.php");
?>