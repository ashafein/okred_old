<?
session_start();
session_register("uid");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
include("var.php");
echo "<head><title>Администрирование - Удаление подписчиков: $sitename</title>";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\">";
include("top.php");
$err2="Пользователь не выбран!<br>";
$error = "";
$maxThread = 20;
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
if ($_SERVER[QUERY_STRING] != "del"){
$n = getenv('REQUEST_URI');
$n = ereg_replace("\?.*$","",$n);
$result = @mysql_query("SELECT * FROM $rasres");
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
  if ($k != $page) {$line .= "<a href=\"admindsr.php?page=$k\"> $k </a>|";}
  if ($k == $page) {$line .= " $k |";}
}
echo "<center><p><strong><big>Администрирование - Удаление подписчиков</strong></big><p>Выберите авторов, которых нужно удалить и нажмите на кнопку \"Удалить отмеченные\".<p>";
echo "Всего подписчиков: <b>$totalThread</b><br><br>";
echo "<form name=delreg method=post action=admindsr.php?del>";
$result = @mysql_query("SELECT * FROM $rasres order by ID DESC LIMIT $initialMsg, $maxThread");
while($myrow=mysql_fetch_array($result)) 
{
$ID=$myrow["ID"];
$aid=$myrow["aid"];
$lsrprofecy=$myrow["srprofecy"];
if ($lsrprofecy == '') {$lsrprofecy='Любая';}
$lsrage=$myrow["srage"];
if ($lsrage == '0') {$lsrage='Любой';}
$lsredu=$myrow["sredu"];
if ($lsredu == '%') {$lsredu='Любое';}
$lsrzp=$myrow["srzp"];
if ($lsrzp == '0') {$lsrzp='Любая';}
$lsrgender=$myrow["srgender"];
if ($lsrgender == '%') {$lsrgender='Любой';}
$lsrgrafic=$myrow["srgrafic"];
if ($lsrgrafic == '%') {$lsrgrafic='Любой';}
$lsrzanatost=$myrow["srzanatost"];
if ($lsrzanatost == '%') {$lsrzanatost='Любая';}
$lsrcity=$myrow["srcity"];
if ($lsrcity == '%' or $lsrcity == '') {$lsrcity='Любой';}
$lrazdel=$myrow["razdel"];
if ($lrazdel == '%' or $lrazdel == '0') {$lrazdel='Любая';}
if ($lrazdel != '%' and $lrazdel != '0') {
$resultadd1 = mysql_query("SELECT ID,razdel,podrazdel FROM $catable WHERE podrazdel = '' and ID='$lrazdel'");
while($myrow1=mysql_fetch_array($resultadd1)) {
$lrazdel=$myrow1["razdel"];
}
}
$lpodrazdel=$myrow["podrazdel"];
if ($lpodrazdel == '%' or $lpodrazdel == '0' or $lpodrazdel == '') {$lpodrazdel='Любой';}
if ($lpodrazdel != '%' and $lpodrazdel != '0') {
$resultadd2 = mysql_query("SELECT ID,podrazdel FROM $catable WHERE ID='$lpodrazdel'");
while($myrow1=mysql_fetch_array($resultadd2)) {
$lpodrazdel=$myrow1["podrazdel"];
}
}
$resultaa = @mysql_query("SELECT * FROM $autortable WHERE ID='$aid'");
while($myrow2=mysql_fetch_array($resultaa)) {
$autID=$myrow2["ID"];
$email=$myrow2["email"];
$date=$myrow2["date"];
$category=$myrow2["category"];
if ($category=='soisk') {$categ='Соискатель';}
if ($category=='rab') {$categ='Работодатель';}
if ($category=='agency') {$categ='Агентство';}
if ($category=='user') {$categ='Пользователь';}
}
echo ("
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$maincolor>
<td align=top><input type=checkbox name=delmes[] value=$ID>&nbsp;<font color=green>Отметить</font></td>
<td align=top><b>$categ</b><br>ID:&nbsp;$autID&nbsp;&nbsp;Email:&nbsp;<a href=mailto:$email>$email</a><br>Дата регистрации: $date</td>
<td align=top>
Сфера деятельности: <b>$lrazdel</b><br>
Раздел: <b>$lpodrazdel</b><br>
Город: <b>$lsrcity</b><br>
Должность: <b>$lsrprofecy</b><br>
Возраст: <b>$lsrage</b><br>
Образование: <b>$lsredu</b><br>
Зарплата: <b>$lsrzp</b><br>
Занятость: <b>$lsrzanatost</b><br>
График работы: <b>$lsrgrafic</b><br>
Пол: <b>$lsrgender</b>
</td></tr>
</table></td></tr></table><br>
");
}
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
echo "<center><h3>Ошибка</h3><font color=red>$error</font><p><a href=# onClick=history.go(-1)>Вернуться назад</a><p><br><br><br><br><br><br><br><br>";
}
if ($error==""){
unset($result);
for ($i=0;$i<count($delmes);$i++){
$result = @mysql_query("delete from $rasres where ID=$delmes[$i]");
}
echo "<center><b>Подписка удалена!</b><br><a href=admindsr.php>Вернуться</a><p><br><br><br><br>";
}
}
} //ok
echo "<center><a href=admin.php>На общую страницу администрирования</a><br><br>";
include("down.php");
?>