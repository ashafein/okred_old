<?php
include("var.php");
$db=@mysql_connect($bdhost,$bdlogin,$bdpass);
@mysql_select_db($bdname,$db);
unset($result);
$datenow = date("Y-m-d H:i:s");
$str="<?xml version=\"1.0\" encoding=\"utf-8\"?><source creation-time=\"$datenow GMT+2\" host=\"$siteadress\"><vacancies>";
$result = @mysql_query("SELECT * FROM $vactable WHERE status='ok' and ((now() - INTERVAL 86400*3 SECOND) < date)");
while ($myrow=@mysql_fetch_array($result)) 
{ //4
$ID=$myrow["ID"];
$profecy=$myrow["profecy"];
$profecy = ereg_replace("\n","",$profecy);
$profecy = ereg_replace("\r","",$profecy);
$zp=$myrow["zp"];
$agemin=$myrow["agemin"];
$agemax=$myrow["agemax"];
$edu=$myrow["edu"];
$gender=$myrow["gender"];
$grafic=$myrow["grafic"];
$zanatost=$myrow["zanatost"];
$treb=$myrow["treb"];
$treb = ereg_replace("\n","<br>",$treb);
$treb = ereg_replace("\"","&quot;",$treb);
$treb = ereg_replace("&","&amp;",$treb);
$treb = ereg_replace(">","&gt;",$treb);
$treb = ereg_replace("<","&lt;",$treb);
$treb = ereg_replace("'","&apos;",$treb);

$uslov=$myrow["uslov"];
$uslov = ereg_replace("\n","<br>",$uslov);
$uslov = ereg_replace("\"","&quot;",$uslov);
$uslov = ereg_replace("&","&amp;",$uslov);
$uslov = ereg_replace(">","&gt;",$uslov);
$uslov = ereg_replace("<","&lt;",$uslov);
$uslov = ereg_replace("'","&apos;",$uslov);

$obyaz=$myrow["obyaz"];
$obyaz = ereg_replace("\n","<br>",$obyaz);
$obyaz = ereg_replace("\"","&quot;",$obyaz);
$obyaz = ereg_replace("&","&amp;",$obyaz);
$obyaz = ereg_replace(">","&gt;",$obyaz);
$obyaz = ereg_replace("<","&lt;",$obyaz);
$obyaz = ereg_replace("'","&apos;",$obyaz);

$adress=$myrow["adress"];
$aid=$myrow["aid"];
$status=$myrow["status"];
$date=$myrow["date"];
$razdel=$myrow["razdel"];
$podrazdel=$myrow["podrazdel"];

$country=$myrow["country"];
$region=$myrow["region"];
$city=$myrow["city"];

$citytar=$city;
if ($city=='0') {$citytar=$region;}
if ($region=='0' and $city=='0') {$citytar=$country;}
$resultadd3c = @mysql_query("SELECT * FROM $citytable WHERE ID='$citytar'");
while($myrowc=mysql_fetch_array($resultadd3c)) {
$citys=$myrowc["categ"];
if ($city=='0') {$citys=$myrowc["podrazdel"];}
if ($city=='0' and $region=='0') {$citys=$myrowc["razdel"];}
}

if ($adress != '') {$locat="$citys, $adress";}
if ($adress == '') {$locat="$citys";}

$resultadd2 = @mysql_query("SELECT ID,podrazdel FROM $catable WHERE ID='$podrazdel'");
while($myrow=mysql_fetch_array($resultadd2)) {
$podrazdel1=$myrow["podrazdel"];
}
$resultadd1 = @mysql_query("SELECT ID,razdel,podrazdel FROM $catable WHERE podrazdel = '' and ID='$razdel'");
while($myrow=mysql_fetch_array($resultadd1)) {
$razdel1=$myrow["razdel"];
}
$resultaut = @mysql_query("SELECT * FROM $autortable WHERE ID='$aid'");
while ($myrow=mysql_fetch_array($resultaut)) {
$category=$myrow["category"];
$email=$myrow["email"];
$hidemail=$myrow["hidemail"];
$acity=$myrow["city"];
$telephone=$myrow["telephone"];
$aadress=$myrow["adress"];
$url=$myrow["url"];
$fio=$myrow["fio"];
$afirm=$myrow["firm"];
}
$str.=("
<vacancy>
  <url>$siteadress/linkvac.php?link=$ID</url>
      <creation-date>$date GMT+2</creation-date>
      <salary>$zp</salary>
      <currency>$valute</currency>
	<category>
      <industry>$razdel1</industry>
      	<specialization>$podrazdel1</specialization>
	</category>
      <job-name>$profecy</job-name>
      <employment>$zanatost</employment>
	<schedule>$grafic</schedule>
      <description>$treb</description>
      <duty>$obyaz</duty>
      <term>
          <text>$uslov</text>
      </term>
      <requirement>
        <age>$agemin-$agemax</age>
        <sex>$gender</sex>
        <education>$edu</education>
      </requirement>
      <addresses>
        <address>
          <location>$locat</location>
        </address>
      </addresses>
      <company>
        <name>$afirm</name>
        <contact-name>$fio</contact-name>
	<hr-agency>false</hr-agency>
      </company>
</vacancy>
");
} //4

$str.="</vacancies></source>";

$str_encode=iconv('windows-1251', 'utf-8', $str);
$code = "UTF-8";
$curcode = "Windows-1251";
//$str_encode=mb_convert_encoding($str, $curcode, $code);

$fp = fopen ("xml/vacancies.yvl","w");
fputs($fp,$str_encode);
echo "װאיכ סמחהאם $siteadress/xml/vacancies.yvl";
?>