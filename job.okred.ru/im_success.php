<?php
session_start();
?>
<html><head>
<?php
include("var.php");
echo"<title>Платеж зачислен на счет : $sitename</title>";
include("top.php");
echo "<p align=center>Платеж зачислен на счет<br/><br/><a href=autor.php>Вернуться в личный раздел</a></p>";
include("down.php");
?>