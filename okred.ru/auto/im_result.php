<?php
session_start();
?>
<html><head>
<?php
include("var.php");
echo"<title>Зачисление платежа : $sitename</title>";
include("top.php");

// Скрипт получения запросов о результате состояния операции оплаты платежной системы IntellectMoney
// Данный скринт содержит основные этапы получения и проверки статуса платежа для определения 
// совершения платежа клиетом. Только через этот механизм можно однозначно определить прошел ли
// платеж клиента в пользу счета вашего магазина или нет.

// Секретныйключ
$secretKey = $intellectmoneykey;

// чтение полученных параметров
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
$in_userField_1 = $_REQUEST["userField_1"]; // набор дополнительных полей магазина
$in_userField_2 = $_REQUEST["userField_2"]; // набор дополнительных полей магазина
$in_userField_3 = $_REQUEST["userField_3"]; // набор дополнительных полей магазина
$in_secretKey = $_REQUEST["secretKey"];		// нужен для проверки по HTTPS хотя в любом случае проверка по
											//контрольной подписи предпочтительна, по этому просто игнорируем его.
$in_hash = strtoupper($_REQUEST["hash"]);	// контрольная подпись со стороны IntellectMoney - основной способ
											// удостовериться что данные пришли именно от IntellectMoney


// Формируем строчку для последующего получения контрольной подписи из данных полученных в запросе
// ВАЖНО: для правильности подписи нужно использовать все данные полученные в запросе кроме секретного ключа
// имеено его нужно вписывать вручную (он задается выше в переменной $secretKey) и благодаря ему мы 
// подтверждаем факт что запрос пришел от IntellectMoney, а не злоумышлиника пытающегося компрометировать запрос
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
			$secretKey; // Очень ВАЖНО проверять подпись используя свой секретный ключ, а не тот что пришел в запросе
// Получаем нав вариант контрольной подписи
$my_hash = strtoupper(md5($for_hash));


// проверка корректности подписи нашей подписи и подписи пришедшей в запросе. Если они различаются, значит прошла подменна данных в ходе
// передачи данных от сервера IntellectMoney до вашего сервера.
if ($my_hash == $in_hash)
{
	$checksum = true;
}
else
{
	$checksum = false;
}

// ! ВАЖНО проверить сумму платежа и валюту по данным, хранимым в вашей базе данных по номеру заказа
// и если сумма или валюта отличаются от тех что сгенерировали вы задайте переменной checksum значение false
// здесь ваш код для сравнения значения в ваше базе и информации принятой от IntellectMoney

// Логирование данной операции для целей отладки. удалите или закомментируйте эти строки на боевой системе
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
// Логирование закончилось

// Если контрольные подписи не совпадают то пишем ошибку и выходим
if (!$checksum)
{
  echo "bad sign\n";
  exit();
}

// Символический вывод подтверждающий успешность получения информации и совпадения подписей
echo "OK\n";

// Внутренние операции по обработке платежа
if ($in_paymentStatus == 3)
{
	// Платеж принят на обработку
	// ВНИМАНИЕ это не означает что денги от клиента получены
	// но это означает что процес создания счета прошел успешно
	// здесь ваш код по обработке этого статуса. Рекомендуется просто 
	// принимать к сведенью, но НИ В КОЕМ РОДЕ не считать данный
	// статус как результат совершения платежа

}

if ($in_paymentStatus == 5)
{
	// Платеж прошел, можно отгружать товар / оказывать услугу
	// здесь ваш код по обработке этого статуса

$pay=$in_recipientAmount/30;
$sql="update $autortable SET pay=pay+'$pay' WHERE ID='$in_userName'";
$result=@mysql_query($sql,$db);

}


include("down.php");
?>