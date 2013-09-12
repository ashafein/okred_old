<?
session_start();
session_register("uid");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
include("var.php");
echo "<head><title>Администрирование - Удаление/правка отчетов: $sitename</title>";
include("top.php");
echo "<center><h3>Удаление отчетов</h3>";
$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);
$err1="Не выбрано ни одной новости!<br>";
$maxThread = 20;
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
if ($_SERVER[QUERY_STRING] != "del"){
$srname=$_GET['srname'];
$page=$_GET['page'];
if ($srname != "") {$srname = ereg_replace(" ","*.",$srname); $qwery2="and title REGEXP '$srname' or preview REGEXP '$srname' or detail REGEXP '$srname' or category REGEXP '$srname'";}
if (!isset($srname) or $srname == "") {$qwery2='';}
$result = @mysql_query("SELECT * FROM $reporttable WHERE ID != 0 $qwery2");
$totalThread = @mysql_num_rows($result);
$mes = $totalThread;
unset($result);
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
  if ($k != $page) {$line .= "<a href=\"adminzd.php?srname=$srname&page=$k\"> $k </a>|";}
  if ($k == $page) {$line .= " $k |";}
}
$result = @mysql_query("SELECT * FROM $reporttable WHERE ID != 0 $qwery2 order by date DESC LIMIT $initialMsg, $maxThread");
$totaltexts=@mysql_num_rows($result);
echo ("
<form name=sr method=get action=adminzd.php>
Строка: <input type=text name=srname size=10>&nbsp;<input type=submit name=submit value='Найти'></form><br><br>
");
echo "<form name=delete_form method=post action=adminrd.php?del>";
if ($totaltexts == 0) {echo "<center><b>Отчет не найден!</b><br><br><a href=admin.php>На общую страницу администрирования</a>";}
else
{ //2
echo "<center>Для удаления позиций пометьте их галочкой и нажмите кнопку \"Удалить\"<br>Всего отчетов найдено: <b>$totalThread</b>&nbsp;Показано: <b>$totaltexts</b><br><br>";
echo ("
<script type=text/javascript>
<!--
function SelectAll() {
  for (var i = 0; i < document.delete_form.elements.length; i++) {
    if( document.delete_form.elements[i].name.substr( 0, 6 ) == 'delmes') {
      document.delete_form.elements[i].checked =
        !(document.delete_form.elements[i].checked);
    }
  }
}
//-->
</script>
<table border=0 width=95% bgcolor=$bordercolor cellspacing=0 cellpadding=0><tr><td><table border=0 cellspacing=1 cellpadding=4 width=100%>
<tr bgcolor=$altcolor><td><input type=checkbox name=allmess value='' onClick=\"SelectAll()\"></td><td><b>Правка</b></td><td><b>№</b></td><td><b>Заголовок</b></td><td><b>Описание</b></td><td><b>Дата</b></td>
");
echo "</tr>";
while ($myrow=mysql_fetch_array($result)) 
{ //4
$ID=$myrow["ID"];
$title=$myrow["title"];
$preview=$myrow["preview"];
$foto1=$myrow["foto1"];
if ($preview != "") {
$preview = ereg_replace("\n","<br>",$preview);
if (eregi('ФОТО1',$preview) and $foto1 != ""){$preview=@str_replace('ФОТО1',"<img src=\"$afishadir$foto1\" border=0 align=left>",$preview);}
}
if (strlen($preview) > 200) {$preview=@substr($preview,0,200).'...';}
$date=$myrow["date"];
$datum=$myrow["datum"];
$hot=$myrow["hot"];
$category=$myrow["category"];
echo ("
<tr bgcolor=$maincolor>
<td><input type=checkbox name=delmes[] value=$ID></td>
<td><a href=adminrc.php?id=$ID>Правка</a></td>
<td>$ID</td>
<td>
");
if ($hot == 'checked') {echo "<b>$title</b>";}
if ($hot != 'checked') {echo "$title";}
echo ("
<br><small>$category</small>
</td>
<td>
Дата: $datum<br>
");
echo ("
$preview</td>
<td>$date</td>
</tr>
");    
} //4
echo "</table></td></tr></table><br><center>$line<p>";
echo ("
<hr width=90% size=1>
<center>
<input type=submit value='Удалить отмеченные' name=delete></form><br>
<a href=admin.php>На общую страницу администрирования</a>
");
}//2
}
if ($_SERVER[QUERY_STRING] == "del"){
$delmes=$_POST['delmes'];
if (isset($_POST['delete']))
{ //del
if (count($delmes)==0) {
	$error .= "$err1";}
if ($error != ""){
echo "<center><h3>Ошибка</h3><font color=red>$error</font><p><a href=# onClick=history.go(-1)>Вернуться назад</a><p><br><br><br><br>";
}
if ($error==""){
unset($result);
if (isset($_POST['delete']))
{ //del in
for ($i=0;$i<count($delmes);$i++){
$res1 = @mysql_query("SELECT * FROM $reporttable WHERE ID=$delmes[$i]");
while ($myrow=@mysql_fetch_array($res1)) 
{
$foto1=$myrow["foto1"];
$foto2=$myrow["foto2"];
$foto3=$myrow["foto3"];
$foto4=$myrow["foto4"];
$foto5=$myrow["foto5"];
$foto6=$myrow["foto6"];
$foto7=$myrow["foto7"];
$foto8=$myrow["foto8"];
$foto9=$myrow["foto9"];
$foto10=$myrow["foto10"];
}
@unlink($upath.$afishadir.$foto1);
@unlink($upath.$afishadir.$foto2);
@unlink($upath.$afishadir.$foto3);
@unlink($upath.$afishadir.$foto4);
@unlink($upath.$afishadir.$foto5);
@unlink($upath.$afishadir.$foto6);
@unlink($upath.$afishadir.$foto7);
@unlink($upath.$afishadir.$foto8);
@unlink($upath.$afishadir.$foto9);
@unlink($upath.$afishadir.$foto10);
$result=@mysql_query("delete from $reporttable WHERE ID=$delmes[$i]");
unset($result);
}
echo "<center><b>Выбранные отчеты удалены!</b><br><br><a href=adminrd.php>Вернуться на страницу удаления</a><br><br><a href=admin.php>На общую страницу администрирования</a><br><br><br><br>";
} //del in
}
} //del
}
} // ok
include("down.php");
?>