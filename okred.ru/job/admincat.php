<?
session_start();
session_register("uid");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
include("var.php");
echo "<head><title>Администрирование - Каталог агентств/работодателей: $sitename</title>";
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
$result = @mysql_query("SELECT * FROM $autortable WHERE category='agency' or category='rab' order by date DESC");
$totalThread = @mysql_num_rows($result);
$mes = $totalThread;
unset($result);
$page=$_GET['page'];
if(!isset($page) or $page == '') $page = 1;
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
  if ($k != $page) {$line .= "<a href=\"admincat.php?srcateg=$srcateg&page=$k\"> $k </a>|";}
  if ($k == $page) {$line .= " $k |";}
}
echo "<center><p><strong><big>Администрирование - Каталог агентств/работодателей</strong></big><p>Выберите авторов, которых нужно удалить и нажмите на кнопку \"Удалить отмеченные\".<p>";
echo "Всего участников: <b>$totalThread</b><br><br>";
$srcateg=$_GET['srcateg'];
if ($srcateg=='nnn') {$srcategv='Все';}
if ($srcateg=='soisk') {$srcategv='Соискатель';}
if ($srcateg=='rab') {$srcategv='Работодатель';}
if ($srcateg=='agency') {$srcategv='Агентство';}
if ($srcateg=='user') {$srcategv='Пользователь';}
echo ("
<form name=sr method=get action=admincat.php>
Отобразить категорию:&nbsp;
<select name=category size=1 onChange=location.href=location.pathname+\"?srcateg=\"+value+\"\";>
<option selected value=$srcateg>$srcategv</option>
<option value=nnn>Все</option>
<option value=rab>Работодатель</option>
<option value=agency>Агентство</option>
</select>
</form>
");
echo "<form name=delreg method=post action=admincat.php?del>";
if ($srcateg == '' or $srcateg == 'nnn') {$result = @mysql_query("SELECT *,CURRENT_DATE,(YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) AS age FROM $autortable WHERE category='agency' or category='rab' order by category, date DESC LIMIT $initialMsg, $maxThread");}
if ($srcateg != '' and $srcateg != 'nnn') {$result = @mysql_query("SELECT *,CURRENT_DATE,(YEAR(CURRENT_DATE)-YEAR(birth)) - (RIGHT(CURRENT_DATE,5)<RIGHT(birth,5)) AS age FROM $autortable WHERE category = '$srcateg' order by date DESC LIMIT $initialMsg, $maxThread");}
while($myrow=mysql_fetch_array($result)) {
$ID=$myrow["ID"];
$login=$myrow["login"];
$pass=$myrow["pass"];
$email=$myrow["email"];
$date=$myrow["date"];
$ip=$myrow["ip"];
$ustatus=$myrow["status"];
$category=$myrow["category"];
$catalog=$myrow["catalog"];
if ($catalog == 'off') {$catline="<font color=red>Не участвует</font>";}
if ($catalog == 'on') {$catline="<font color=green>Участвует</font>";}
if ($category == 'rab')
{ //rab
$res = @mysql_query("SELECT ID,aid FROM $vactable WHERE aid='$ID'");
$totalautortexts1 = @mysql_num_rows($res);
$res = @mysql_query("SELECT ID,aid FROM $restable WHERE aid='$ID'");
$totalautortexts2 = @mysql_num_rows($res);
unset($res);
$totalautortexts = $totalautortexts1 + $totalautortexts2;
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

$telephone=$myrow["telephone"];
$adress=$myrow["adress"];
$url=$myrow["url"];
$fio=$myrow["fio"];
$firm=$myrow["firm"];
if ($category=='soisk') {$categ='Соискатель';}
if ($category=='rab') {$categ='Работодатель';}
if ($category=='agency') {$categ='Агентство';}
if ($category=='user') {$categ='Пользователь';}
echo ("
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$altcolor><td  colspan=2><b>$categ</b>&nbsp;/&nbsp;<b>$catline</b></td></tr>
<tr bgcolor=$maincolor><td valign=top>
");
echo "<b>Пароль</b>: $pass<br>";
if ($firm != '') {echo "<b>Организация</b>: $firm<br>";}
if ($citys != '' or $adress != '') {echo "<b>Местонахождение</b>: $citys $adress<br>";}
if ($telephone != '') {echo "<b>Тел:</b>: $telephone<br>";}
if ($email != '') {echo "<b>Email</b>: <a href=mailto:$email>$email</a><br>";}
if ($url != '') {echo "<b>URL</b>: <a href=$url target=_blank>$url</a><br>";}
if ($fio != '') {echo "<b>Контактное лицо</b>: $fio<br>";}
echo "<b>IP</b>: $ip<br>";
echo "<b>Добавлено объявлений</b>: $totalautortexts<br>";
echo "<b>Дата регистрации</b>: $date<br>";
echo "</td></tr>";
echo ("
</tr><tr bgcolor=$maincolor><td  colspan=2><input type=checkbox name=delmes[] value=$ID>&nbsp;<font color=green>Отметить</font></td></tr>
</table></td></tr></table><br>
");
} //rab

if ($category == 'agency')
{ //agency
$res = @mysql_query("SELECT ID,aid FROM $vactable WHERE aid='$ID'");
$totalautortexts1 = @mysql_num_rows($res);
$res = @mysql_query("SELECT ID,aid FROM $restable WHERE aid='$ID'");
$totalautortexts2 = @mysql_num_rows($res);
unset($res);
$totalautortexts = $totalautortexts1 + $totalautortexts2;
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

$telephone=$myrow["telephone"];
$adress=$myrow["adress"];
$url=$myrow["url"];
$fio=$myrow["fio"];
$firm=$myrow["firm"];
if ($category=='soisk') {$categ='Соискатель';}
if ($category=='rab') {$categ='Работодатель';}
if ($category=='agency') {$categ='Агентство';}
if ($category=='user') {$categ='Пользователь';}
echo ("
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$altcolor><td  colspan=2><b>$categ</b>&nbsp;/&nbsp;<b>$catline</b></td></tr>
<tr bgcolor=$maincolor><td valign=top>
");
echo "<b>Пароль</b>: $pass<br>";
if ($firm != '') {echo "<b>Название агентства</b>: $firm<br>";}
if ($citys != '' or $adress != '') {echo "<b>Местонахождение</b>: $citys $adress<br>";}
if ($telephone != '') {echo "<b>Тел:</b>: $telephone<br>";}
if ($email != '') {echo "<b>Email</b>: <a href=mailto:$email>$email</a><br>";}
if ($url != '') {echo "<b>URL</b>: <a href=$url target=_blank>$url</a><br>";}
if ($fio != '') {echo "<b>Контактное лицо</b>: $fio<br>";}
echo "<b>IP</b>: $ip<br>";
echo "<b>Добавлено объявлений</b>: $totalautortexts<br>";
echo "<b>Дата регистрации</b>: $date<br>";
echo "</td></tr>";
echo ("
</tr><tr bgcolor=$maincolor><td  colspan=2><input type=checkbox name=delmes[] value=$ID>&nbsp;<font color=green>Отметить</font></td></tr>
</table></td></tr></table><br>
");
} //agency


}
echo "<p align=center class=tbl1>$line</p>";
echo ("
<center><input type=submit value='Исключить из каталога' name=delete>&nbsp;<input type=submit value='Включить в каталог' name=add></form>
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
if (isset($_POST['delete']))
{ //del
for ($i=0;$i<count($delmes);$i++){
$result=@mysql_query("update $autortable set catalog='off' WHERE ID=$delmes[$i]");
}
echo "<center><b>Отмеченные пользователи исключены из каталога!</b><br><a href=admincat.php>Вернуться</a><p><br><br><br><br>";
} //del
if (isset($_POST['add']))
{ //add
for ($i=0;$i<count($delmes);$i++){
$result=@mysql_query("update $autortable set catalog='on' WHERE ID=$delmes[$i]");
}
echo "<center><b>Отмеченные пользователи включены в каталог!</b><br><a href=admincat.php>Вернуться</a><p><br><br><br><br>";
} //add
}
}
} //ok
echo "<center><a href=admin.php>На общую страницу администрирования</a><br><br>";
include("down.php");
?>