<?
session_start();
session_name();

include("var.php");
echo "<head><title>Жалоба : $sitename</title>";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\"><META HTTP-EQUIV=\"Cache-Control\" CONTENT=\"No-Cache\">";
include("top.php");
$sid=$_SESSION['sid'];
$id=$_SESSION['sid'];
$slogin=$_SESSION['slogin'];
$spass=$_SESSION['spass'];
$REMOTE_ADDR=$_SERVER['REMOTE_ADDR'];
$id=$sid;
$result = @mysql_query("SELECT email,pass,category FROM $autortable WHERE (email = '$slogin' and pass = '$spass')");
if ((!isset($slogin) or !isset($spass)) or @mysql_num_rows($result) == 0)
{
echo "<center><br><br><h3>Вы не авторизированы!</h3><b><a href=autor.php>Авторизация</a></b>";
}
else
{ //1

$r=$_GET['r'];
$link=$_GET['link'];

while($myrow=mysql_fetch_array($result)) {
$who=$myrow["ID"];
}
//---------------main--------------
if ($_SERVER[QUERY_STRING] != "send")
{ //nosend
//--------------step1-------------
// basketshow
if ($r != '' and $link != '')
{
echo ("
<form name=form method=post action=zhaloba.php?send ENCTYPE=multipart/form-data>
<input type=hidden name=link value=$link>
<input type=hidden name=r value=$r>
<p align=center>
Текст жалобы:<br><textarea rows=7 name=comment cols=50></textarea><br>
<input type=submit value=\"Отправить\" name=\"send\" class=i3></p>
</form>
");
}
elseif ($r =='' or $link == '')
{
echo "<p align=center><b>Объявление не определено</b></p><br><br>";
}
// basketshow
//
//--------------step1-------------
//
} //nosend
if ($_SERVER[QUERY_STRING] == "send")
{ //send
$r=$_POST['r'];
$link=$_POST['link'];
$comment=$_POST['comment'];

$sql="insert into $zhalobatable (categ,num,user,comment,date,ip) values ('$r','$link','$sid','$comment',now(),'$REMOTE_ADDR')";
$result=@mysql_query($sql,$db);

echo "<h3 align=center class=tbl1>Сообщение отправлено! В ближайшее время будут приняты необходимые меры</h3><br><br>";
} //send
//---------------main--------------
}//1
include("down.php");
?>