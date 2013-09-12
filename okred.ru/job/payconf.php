<form method="POST" action="<Result URL>">

	<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="<? echo "$_POST['LMI_PAYMENT_AMOUNT']";?>">
	<input type="hidden" name="userID" value="<? echo "$_POST['userID']";?>">
</form>


<?php
include("var.php");
$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);

//if ($_POST['LMI_PAYEE_PURSE'] == '$wmzpurse')
//{
$LMI_PAYMENT_AMOUNT=$_POST['LMI_PAYMENT_AMOUNT'];
$userID=$_POST['userID'];
$sql="update $autortable SET pay=pay+'$LMI_PAYMENT_AMOUNT' WHERE ID='$userID'";
$result=@mysql_query($sql,$db);
//}

?>