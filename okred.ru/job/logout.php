<?
session_start();
session_destroy();
include("var.php");
$_SESSION['spass']='';
$_SESSION['slogin']='';
$_SESSION['sid']='';
unset($_SESSION['spass']);
unset($_SESSION['slogin']);
unset($_SESSION['sid']);
setcookie("spass", 'false', time() - 1);
setcookie("slogin", 'false', time() - 1);
setcookie("sid", 'false', time() - 1);

include("top.php");
echo "<center><br><br><b>Вы вышли из авторского раздела!</b><br><br>";
include("down.php");
?>