<?php 
$paysum=4;
$smsid=$_GET['smsid'];
$msg=$_GET['msg'];
echo "smsid:$smsid\n";
echo "status:reply\n";
echo "content-type:text/plan\n";
echo "\n";
$msg=substr($_GET['msg'],7,1000); // xxxxxx ID
echo "Vasha SMS poluchena. Spasibo za uchastie.\n";

include("var.php");
@$db=mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);

// зачисление на счет
$result=@mysql_query("update $autortable SET pay=pay+'$paysum' WHERE ID='$msg'");
// зачисление на счет
?>
