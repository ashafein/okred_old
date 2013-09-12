<?
session_start();
session_destroy();
include("var.php");
$_SESSION['uid']='';
unset($_SESSION['uid']);
echo "<head>";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\"><META HTTP-EQUIV=\"Cache-Control\" CONTENT=\"No-Cache\">";
include("top.php");
echo "<center><br><br><b>Вы вышли из администрирования!</b><br><br>";
include("down.php");
?>