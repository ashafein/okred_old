<?php
include("var.php");

$ik_payment_amount=$_POST['ik_payment_amount'];
$ik_baggage_fields=$_POST['ik_baggage_fields'];
$ik_payment_id=$_POST['ik_payment_id'];

if($ik_payment_amount && $ik_baggage_fields && $ik_payment_id)
{
	$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
	@mysql_select_db($bdname,$db);
	$sql="update `{$autortable}` SET pay=pay+{$ik_payment_amount} WHERE ID='{$ik_baggage_fields}' AND code='{$ik_payment_id}'";
	$result=@mysql_query($sql,$db);
} else {
	file_put_contents('./_error.log',date('d.m.y H:i') . "\n\nошибочный платеж :\n" . print_r($_POST,1));
}

?>