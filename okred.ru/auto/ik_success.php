<?php
session_start();
?>
<html><head>
<?php
include("var.php");
echo"<title>������ �������� �� ���� : $sitename</title>";
include("top.php");

$ik_payment_amount=$_POST['ik_payment_amount'];
$ik_baggage_fields=$_POST['ik_baggage_fields'];

echo "<p align=center>������ �������� �� ����<br/>����� ����������: $ik_payment_amount<br>ID ������������: $ik_baggage_fields<br/><a href=autor.php>��������� � ������ ������</a></p>";
include("down.php");
?>