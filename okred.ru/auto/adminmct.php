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
<?php
include("var.php");
echo"<title>Редактирование разделов : $sitename</title>";
include("top.php");
?>
<h3><center><strong>Редактирование разделов</strong></center></h3>
<?php
$result = @mysql_query("SELECT pass FROM $admintable");
while($myrow=mysql_fetch_array($result)) {
$adminpass=$myrow["pass"];
}
$maxsize = 100;
$err2="Не выбран ни один раздел!<br>";
$err3="Ни один раздел не введен!<br>";
$error = "";
if (!isset($_SESSION['uid']) or $_SESSION['uid'] != $adminpass)
{
echo "<center><b>Вы не <a href=admin.php>авторизированы</a>!</b><br><br>";
}
else
{ // ok
if ($_SERVER[QUERY_STRING] != "del"){
echo "<form name=delreg method=post action=adminmct.php?del>";
$result = @mysql_query("SELECT ID,genre FROM $textcatable");
$totalThread = @mysql_num_rows($result);
while($myrow=mysql_fetch_array($result)) {
$ID=$myrow["ID"];
$genre=$myrow["genre"];
echo "<input type=checkbox name=delmes[] value=$ID>$genre&nbsp;<a href=admincrt.php?id=$ID&c=r><small>(Изменить)</small></a><br>";
}
if ($totalThread != 0)
{echo "<br><center><input type=submit value='Удалить отмеченные' name=delete><br><br>";}
echo "<hr width=90% size=1><b>Создать раздел</b><br><br>Введите название нового раздела. Каждый раздел начинать с новой строки:<br><textarea rows=4 name=newrazdel cols=20></textarea><br><br><center><input type=submit value='Создать разделы' name=addrazdel><br><br>";
echo ("
</form>
");
}
if ($_SERVER[QUERY_STRING] == "del"){
$delete=$_POST['delete'];
$delmes=$_POST['delmes'];
$addrazdel=$_POST['addrazdel'];
$newrazdel=$_POST['newrazdel'];
if (isset($delete) and count($delmes)==0) {
	$error .= "$err2";}
if (isset($addrazdel) and $newrazdel=='') {
	$error .= "$err3";}
if ($error != ""){
echo "<center><h3>Ошибка</h3><font color=red>$error</font><p><a href=# onClick=history.go(-1)>Вернуться назад</a><p><br><br><br><br><br><br><br><br>";
}
if ($error==""){
if (isset($delete))
{
unset($result);
for ($i=0;$i<count($delmes);$i++){
$result = @mysql_query("SELECT * FROM $textcatable WHERE ID=$delmes[$i]");
while($myrow=mysql_fetch_array($result)) {
$genre=$myrow["genre"];
}
$result=@mysql_query("delete from $textcatable WHERE genre='$genre'");
$res1 = @mysql_query("SELECT ID,foto1,foto2,foto3,foto4,foto5,aid FROM $textable WHERE genre=$delmes[$i]");
while ($myrow=@mysql_fetch_array($res1)) 
{
$foto1=$myrow["foto1"];
$foto2=$myrow["foto2"];
$foto3=$myrow["foto3"];
$foto4=$myrow["foto4"];
$foto5=$myrow["foto5"];
@unlink($upath.$photodir.$foto1);
@unlink($upath.$photodir.$foto2);
@unlink($upath.$photodir.$foto3);
@unlink($upath.$photodir.$foto4);
@unlink($upath.$photodir.$foto5);
}
$result=@mysql_query("delete from $textable WHERE genre=$delmes[$i]");
}
echo "<center><b>Выбранные разделы удалены!</b><br><a href=adminmct.php>Вернуться</a><p><br><br><br><br>";
}
if (isset($addrazdel))
{
$newrazdel = split ("\n",$newrazdel);
for ($i=0; $i<count($newrazdel); $i++)
{
$newrazdel[$i]=trim($newrazdel[$i]);
$sql="insert into $textcatable (genre) values ('$newrazdel[$i]')";
$result=@mysql_query($sql,$db);
}
echo "<center><b>Разделы созданы!</b><br><a href=adminmct.php>Вернуться</a><p><br><br><br><br>";
}
}
}
echo "<center><a href=admin.php>На общую страницу администрирования</a><br><br>";
} //ok
include("down.php");
?>