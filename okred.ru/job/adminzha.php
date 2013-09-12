<?
session_start();
session_register("uid");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
include("var.php");
echo "<head><title>Администрирование - Жалобы: $sitename</title>";
echo "<META NAME=ROBOTS CONTENT=\"NOINDEX, NOFOLLOW\">";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\">";
include("top.php");
$err2="жалоба не выбрана!<br>";
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
$srtext=$_GET['srtext'];
$srid=$_GET['srid'];
$page=$_GET['page'];
echo "<center><p><strong><big>Администрирование - Жалобы</strong></big><p>Выберите авторов, которых нужно удалить и нажмите на кнопку \"Удалить отмеченные\".<p>";
echo ("
<form name=sr method=get action=adminzha.php>
ID автора жалобы: <input type=text name=srtext size=30><br>
ID вакансии или резюме: <input type=text name=srid size=30><br>
<input type=submit value='Перейти' name=find>
</form>
");
$result = @mysql_query("SELECT * FROM $zhalobatable order by date DESC");
$totalThread = @mysql_num_rows($result);
$mes = $totalThread;
unset($result);
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
  if ($k != $page) {$line .= "<a href=\"adminzha.php?srid=$srid&srtext=$srtext&page=$k\"> $k </a>|";}
  if ($k == $page) {$line .= " $k |";}
}
echo "Всего жалоб: <b>$totalThread</b><br><br>";
if ($srtext == "") {$srtextqwery="";}
if ($srtext != "") {$srtextqwery="and user='$srtext'";}
if ($srid == "") {$sridqwery="";}
if ($srid != "") {$sridqwery="and num='$srid'";}
echo "<form name=delreg method=post action=adminzha.php?del>";
echo ("
<table border=0 width=90% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=2 width=100% class=tbl1>
<tr bgcolor=$altcolor><td></td><td>Категория</td><td>Номер</td><td>ID автора жалобы</td><td>Жалоба</td></tr>
");
$result = @mysql_query("SELECT * FROM $zhalobatable WHERE ID != 0 $sridqwery $srtextqwery order by date DESC LIMIT $initialMsg, $maxThread");
while($myrow=mysql_fetch_array($result)) {
$ID=$myrow["ID"];
$user=$myrow["user"];
$categ=$myrow["categ"];
if ($categ == 'res') {$catline='Резюме'; $filec='linkres.php';}
if ($categ == 'vac') {$catline='Вакансия'; $filec='linkvac.php';}
$num=$myrow["num"];
$date=$myrow["date"];
$comment=$myrow["comment"];
$ip=$myrow["ip"];

echo ("
<tr bgcolor=$maincolor>
<td><input type=checkbox name=delmes[] value=$ID></td>
<td>$catline</td>
<td><a href=$filec?link=$num>$num</a></td>
<td><a href=adminda.php?srtext=$user>$user</a><br>IP: $ip</td>
<td>$comment<br>$date</td>
</tr>
");
}
echo ("
</table></td></tr></table><br>
");

echo "<p align=center class=tbl1>$line</p>";
echo ("
<center><input type=submit value='Удалить жалобу' name=del><br><br>
<input type=submit value='Удалить жалобу + Удалить объявление' name=delob><br><br>
<input type=submit value='Удалить жалобу + Удалить объявление + Удалить пользователя' name=deluser>
</form>
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

if (isset($_POST['del']))
{ //del
for ($i=0;$i<count($delmes);$i++){
$result=@mysql_query("delete from $zhalobatable WHERE ID=$delmes[$i]");
}
echo "<center><b>Жалобы удалены!</b><br><a href=adminzha.php>Вернуться</a><p><br><br><br><br>";
} //del

if (isset($_POST['deluser']))
{ //deluser
for ($i=0;$i<count($delmes);$i++){
$res1 = @mysql_query("SELECT * FROM $zhalobatable WHERE ID=$delmes[$i]");
while ($myrow=@mysql_fetch_array($res1)) 
{
$num=$myrow["num"];
$categ=$myrow["categ"];
}
if ($categ=='res') {$res2 = @mysql_query("SELECT ID,aid FROM $restable WHERE ID=$num");}
if ($categ=='vac') {$res2 = @mysql_query("SELECT ID,aid FROM $vactable WHERE ID=$num");}
while ($myrow=@mysql_fetch_array($res2)) 
{
$aid=$myrow["aid"];
$foto1=$myrow["foto1"];
@unlink($upath.$photodir.$foto1);
@unlink($upath.$photodir.'s'.$foto1);
}
$result = @mysql_query("delete from $zhalobatable where ID=$delmes[$i]");
if ($categ=='res') {$result = @mysql_query("delete from $restable where ID=$num");}
if ($categ=='vac') {$result = @mysql_query("delete from $vactable where ID=$num");}

$res5 = @mysql_query("SELECT ID,email FROM $autortable WHERE ID=$aid");
while ($myrow=@mysql_fetch_array($res5)) 
{
$autorname=$myrow["email"];
}
$result=@mysql_query("update $forumtable SET pass=0 WHERE name='$autorname'");
unset($result);
$res1 = @mysql_query("SELECT ID,foto1,foto2 FROM $autortable WHERE ID=$aid");
while ($myrow=@mysql_fetch_array($res1)) 
{
$foto1=$myrow["foto1"];
$foto2=$myrow["foto2"];
}
@unlink($upath.$photodir.$foto1);
@unlink($upath.$photodir.$foto2);
@unlink($upath.$photodir.'s'.$foto1);
@unlink($upath.$photodir.'s'.$foto2);
$result=@mysql_query("delete from $rasvac WHERE aid=$aid");
$result=@mysql_query("delete from $rasres WHERE aid=$aid");
$result=@mysql_query("delete from $restable WHERE aid=$aid");
$result=@mysql_query("delete from $vactable WHERE aid=$aid");
$result=@mysql_query("delete from $autortable WHERE ID=$aid");
}
echo "<center><b>Пользователи удалены!</b><br><a href=adminzha.php>Вернуться</a><p><br><br><br><br>";
} //deluser

if (isset($_POST['delob']))
{ //delob
for ($i=0;$i<count($delmes);$i++){
$res1 = @mysql_query("SELECT * FROM $zhalobatable WHERE ID=$delmes[$i]");
while ($myrow=@mysql_fetch_array($res1)) 
{
$num=$myrow["num"];
$categ=$myrow["categ"];
}
if ($categ=='res') {$res2 = @mysql_query("SELECT ID,aid FROM $restable WHERE ID=$num");}
if ($categ=='vac') {$res2 = @mysql_query("SELECT ID,aid FROM $vactable WHERE ID=$num");}
while ($myrow=@mysql_fetch_array($res2)) 
{
$aid=$myrow["aid"];
$foto1=$myrow["foto1"];
@unlink($upath.$photodir.$foto1);
@unlink($upath.$photodir.'s'.$foto1);
}
$result = @mysql_query("delete from $zhalobatable where ID=$delmes[$i]");
if ($categ=='res') {$result = @mysql_query("delete from $restable where ID=$num");}
if ($categ=='vac') {$result = @mysql_query("delete from $vactable where ID=$num");}
}
echo "<center><b>Объявления удалены!</b><br><a href=adminzha.php>Вернуться</a><p><br><br><br><br>";
} //delob

}
}
} //ok
echo "<center><a href=admin.php>На общую страницу администрирования</a><br><br>";
include("down.php");
?>
