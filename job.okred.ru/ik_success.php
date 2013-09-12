<?php
session_start();
?>
<html><head>
<?php
include("var.php");
echo"<title>Платеж зачислен на счет : $sitename</title>";
include("top.php");

$ik_payment_amount=$_POST['ik_payment_amount'];
$ik_baggage_fields=$_POST['ik_baggage_fields'];

echo "<p align=center>Платеж зачислен на счет<br/>Сумма зачисления: $ik_payment_amount<br>ID пользователя: $ik_baggage_fields<br/><a href=autor.php>Вернуться в личный раздел</a></p>";
include("down.php");
?>