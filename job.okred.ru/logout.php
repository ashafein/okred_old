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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?
echo "<head>";
echo "<META HTTP-EQUIV=\"Expires\" Content=\"Mon, 28 Mar 1999 00:00:01 GMT\"><META HTTP-EQUIV=\"Cache-Control\" CONTENT=\"No-Cache\">";
include("top.php");
echo "<center><br><br><b>Вы вышли из авторского раздела!</b><br><br>";
include("down.php");
?>