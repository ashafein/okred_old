<?php
session_start();
?>
<html><head>
<?php
include("var.php");
echo"<title>���������� ������� : $sitename</title>";
include("top.php");

// ������ ��������� �������� � ���������� ��������� �������� ������ ��������� ������� IntellectMoney
// ������ ������ �������� �������� ����� ��������� � �������� ������� ������� ��� ����������� 
// ���������� ������� �������. ������ ����� ���� �������� ����� ���������� ���������� ������ ��
// ������ ������� � ������ ����� ������ �������� ��� ���.

// �������������
$secretKey = $intellectmoneykey;

// ������ ���������� ����������
$in_eshopId = $_REQUEST["eshopId"];
$in_orderId = $_REQUEST["orderId"];
$in_serviceName = $_REQUEST["serviceName"];
$in_eshopAccount = $_REQUEST["eshopAccount"];
$in_recipientAmount = $_REQUEST["recipientAmount"];
$in_recipientCurrency = $_REQUEST["recipientCurrency"];
$in_paymentStatus = $_REQUEST["paymentStatus"];
$in_userName = $_REQUEST["userName"];
$in_userEmail = $_REQUEST["userEmail"];
$in_paymentData = $_REQUEST["paymentData"];
$in_userField_1 = $_REQUEST["userField_1"]; // ����� �������������� ����� ��������
$in_userField_2 = $_REQUEST["userField_2"]; // ����� �������������� ����� ��������
$in_userField_3 = $_REQUEST["userField_3"]; // ����� �������������� ����� ��������
$in_secretKey = $_REQUEST["secretKey"];		// ����� ��� �������� �� HTTPS ���� � ����� ������ �������� ��
											//����������� ������� ���������������, �� ����� ������ ���������� ���.
$in_hash = strtoupper($_REQUEST["hash"]);	// ����������� ������� �� ������� IntellectMoney - �������� ������
											// �������������� ��� ������ ������ ������ �� IntellectMoney


// ��������� ������� ��� ������������ ��������� ����������� ������� �� ������ ���������� � �������
// �����: ��� ������������ ������� ����� ������������ ��� ������ ���������� � ������� ����� ���������� �����
// ������ ��� ����� ��������� ������� (�� �������� ���� � ���������� $secretKey) � ��������� ��� �� 
// ������������ ���� ��� ������ ������ �� IntellectMoney, � �� ������������� ����������� ���������������� ������
$for_hash = $in_eshopId."::".
			$in_orderId."::".
			$in_serviceName."::".
			$in_eshopAccount."::".
			$in_recipientAmount."::".
			$in_recipientCurrency."::".
			$in_paymentStatus."::".
			$in_userName."::".
			$in_userEmail."::".
			$in_paymentData."::".
			$secretKey; // ����� ����� ��������� ������� ��������� ���� ��������� ����, � �� ��� ��� ������ � �������
// �������� ��� ������� ����������� �������
$my_hash = strtoupper(md5($for_hash));


// �������� ������������ ������� ����� ������� � ������� ��������� � �������. ���� ��� �����������, ������ ������ �������� ������ � ����
// �������� ������ �� ������� IntellectMoney �� ������ �������.
if ($my_hash == $in_hash)
{
	$checksum = true;
}
else
{
	$checksum = false;
}

// ! ����� ��������� ����� ������� � ������ �� ������, �������� � ����� ���� ������ �� ������ ������
// � ���� ����� ��� ������ ���������� �� ��� ��� ������������� �� ������� ���������� checksum �������� false
// ����� ��� ��� ��� ��������� �������� � ���� ���� � ���������� �������� �� IntellectMoney

// ����������� ������ �������� ��� ����� �������. ������� ��� ��������������� ��� ������ �� ������ �������
$f=@fopen(dirname(__FILE__) . "/orders.txt","a+") or
          die("error");
fputs($f,	date("d:m:Y h:i:s").
			" orderId: $in_orderId;".
			" Amount: $in_recipientAmount;".
			" Date: $in_paymentData;".
			" Currency: $in_recipientCurrency;".
			" Status: $in_paymentStatus;".
			" Checksum: ".($checksum==true?1:0)."\n"
	);
fclose($f);
// ����������� �����������

// ���� ����������� ������� �� ��������� �� ����� ������ � �������
if (!$checksum)
{
  echo "bad sign\n";
  exit();
}

// ������������� ����� �������������� ���������� ��������� ���������� � ���������� ��������
echo "OK\n";

// ���������� �������� �� ��������� �������
if ($in_paymentStatus == 3)
{
	// ������ ������ �� ���������
	// �������� ��� �� �������� ��� ����� �� ������� ��������
	// �� ��� �������� ��� ������ �������� ����� ������ �������
	// ����� ��� ��� �� ��������� ����� �������. ������������� ������ 
	// ��������� � ��������, �� �� � ���� ���� �� ������� ������
	// ������ ��� ��������� ���������� �������

}

if ($in_paymentStatus == 5)
{
	// ������ ������, ����� ��������� ����� / ��������� ������
	// ����� ��� ��� �� ��������� ����� �������

$pay=$in_recipientAmount/30;
$sql="update $autortable SET pay=pay+'$pay' WHERE ID='$in_userName'";
$result=@mysql_query($sql,$db);

}


include("down.php");
?>