<?
session_start();
session_register("uid");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
include("var.php");
echo "<head><title>Администрирование - Удаление рекламы: $sitename</title>";
include("top.php");
$err2="<p class=error>Не выбрано ни одной рекламы!</p>";
$error = "";
$maxThread=$maxtext;
$result = @mysql_query("SELECT pass FROM $admintable");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
if (!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass)
{
echo "<p class=error>Вы не авторизированы!   <a href=admin.php><b>Авторизация</b></a></p><br>";
}
else
{ // ok
if ($_SERVER[QUERY_STRING] != "del"){
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
$result = @mysql_query("SELECT ID FROM $promotable");
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
  if ($k != $page) {$line .= "<a href=\"adminpro.php?page=$k\"> $k </a>|";}
  if ($k == $page) {$line .= " $k |";}
}
echo "<p align=center class=tbl1><strong><big>Администрирование - Удаление рекламы</strong></big><br>";
echo "(Всего: <b>$totalThread</b>)</p>";
echo ("
<form name=delreg method=post action=adminpro.php?del>
<table border=0 width=95% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table width=100% border=0 cellspacing=1 cellpadding=4 class=tbl1>
<tr bgcolor=$altcolor><td></td><td><strong>Реклама</strong></td><td><strong>Расположение</strong></td><td><strong>Страницы показа</strong></td><td><strong>Дата добавления</strong></td></tr>
");
$result = @mysql_query("SELECT *,DATE_FORMAT(date,'%d.%m.%Y') as date FROM $promotable order by wheres,ID DESC LIMIT $initialMsg, $maxThread");
while($myrow=mysql_fetch_array($result)) {
$ID=$myrow["ID"];
$title=$myrow["title"];
$foto=$myrow["foto"];
$link=$myrow["link"];
$wheres=$myrow["wheres"];
$place=$myrow["place"];
$date=$myrow["date"];
$period=$myrow["period"];

$country=$myrow["country"];
$region=$myrow["region"];
$city=$myrow["city"];
$citytar=$city;
if ($city=='0') {$citytar=$region;}
if ($region=='0' and $city=='0') {$citytar=$country;}
$resultadd3c = @mysql_query("SELECT * FROM $citytable WHERE ID='$citytar'");
while($myrowc=mysql_fetch_array($resultadd3c)) {
$citys=$myrowc["categ"];
if ($city=='0') {$citys=$myrowc["podrazdel"];}
if ($city=='0' and $region=='0') {$citys=$myrowc["razdel"];}
}

if ($place=='all') {$place='Все страницы';}
if ($place=='index') {$place='Только главная';}
if ($place=='vac') {$place='Только вакансии';}
if ($place=='res') {$place='Только резюме';}
if ($place=='other') {$place='Остальные, кроме главной, вакансий, резюме';}
if ($wheres=='top') {$where='Верх страницы';}
if ($wheres=='comp') {$where='Ведущие компании';}
if ($wheres=='menu') {$where='Под меню';}
if ($wheres=='right') {$where='Справа страницы';}
if ($wheres=='down') {$where='Низ страницы';}
if ($wheres=='beforenew') {$where='Перед вакансиями-резюме дня';}
if ($wheres=='afterhot') {$where='Перед блоком новостей';}
if ($wheres=='rassilka') {$where='В рассылке';}
echo "<tr><td bgcolor=$maincolor><input type=checkbox name=delmes[] value=$ID></td>";
if ($foto != '') {echo "<td bgcolor=$maincolor><a href=\"$link\" target=_blank><img src=\"$foto\" alt=\"$title\" border=0></a></td>";}
if ($foto == '') {echo "<td bgcolor=$maincolor><a href=\"$link\" target=_blank>$title</a></td>";}
echo "<td bgcolor=$maincolor>$where $citys</td>";
echo "<td bgcolor=$maincolor>$place</td>";
echo "<td bgcolor=$maincolor>$date<br>(на $period дней)</td>";
echo "</tr>";
}
echo "</table></td></tr></table>";
echo "<p align=center class=tbl1>$line</p>";
echo ("
<center><input type=submit value='Удалить отмеченные' name=submit></form>
");
}
if ($_SERVER[QUERY_STRING] == "del"){
$delmes=$_POST['delmes'];
if (count($delmes)==0) {
	$error .= "$err2";}
if ($error != ""){
echo "<center><h3>Ошибка</h3><font color=red>$error</font><p><a href=javascript:history.back(2);>Вернуться назад</a><p><br><br><br><br><br><br><br><br>";
}
if ($error==""){
unset($result);
for ($i=0;$i<count($delmes);$i++){
$res1 = @mysql_query("SELECT ID,foto FROM $promotable WHERE ID=$delmes[$i]");
while ($myrow=@mysql_fetch_array($res1))
{
$foto=$myrow["foto"];
}
unlink($upath.$promo_dir.$foto);
unset($res1);
$result=@mysql_query("delete from $promotable WHERE ID=$delmes[$i]");
}
echo "<center><b>Выбранная реклама удалена!</b><br><a href=adminpro.php>Вернуться</a><p><br><br><br><br>";
}
}
echo "<center><a href=admin.php>На общую страницу администрирования</a><br><br>";
} //ok
include("down.php");
?>