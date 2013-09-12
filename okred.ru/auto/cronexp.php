<?php
include("var.php");
echo "<html><head>";
$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);

$result = @mysql_query("SELECT * FROM $mainpagetable");
while ($myrow=mysql_fetch_array($result)) 
{ //4
$ID=$myrow["ID"];
$url=$myrow["url"];

$ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, $url);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $respar = curl_exec($ch); 

if (ereg("$siteadress","$respar"))
{
$result1=@mysql_query("update $mainpagetable SET checked='ok' WHERE ID=$ID");
}
if (!ereg("$siteadress","$respar"))
{
$result1=@mysql_query("update $mainpagetable SET checked='' WHERE ID=$ID");
}

} //4

?>
