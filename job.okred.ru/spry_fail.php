<?php
session_start();
?>
<html><head>
<?php
include("var.php");
echo"<title>Ошибка платежа : $sitename</title>";
include("top.php");
echo "<p align=center>Платеж не был зачислен<br/><br/><a href=autor.php>Вернуться в личный раздел</a></p>";
include("down.php");
?>