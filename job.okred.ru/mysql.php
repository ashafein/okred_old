<!--
# Внимание!!! Запустите этот файл только один раз!!!
# После запуска файла и создания базы данных и таблиц
# удалите этот файл с сервера!
-->

<?php
include("var.php");
if ($_SERVER[QUERY_STRING] != "create"){
echo ("
<h3 align=center>Лицензионное соглашение</h3>
<blockquote><p align=justify>
Лицензия на использование полной(платной) версии скрипта <b>\"Работа Professional Nevius\"</b>:<br><br>
1. Всеми авторскими правами владеет автор - Невежин Евгений.<br><br>
2. Вы можете использовать данную версию в течение неограниченного периода времени.<br><br>
3. Вам НЕ разрешается копировать, распространять, передавать данную версию скрипта кому-либо. Запрещается опубликовывать, передавать, продавать код скрипта или часть кода скрипта.<br><br>
4. Автор не несет ответсвенности за любой вред, причиненный данным скриптом.<br><br>
5. Покупка и использование полной версии скрипта \"Работа Professional Nevius\" свидетельствует о вашем согласии с условиями данной лицензии. Если вы не согласны с условиями данной лицензии, то должны удалить все файлы скрипта \"Работа Professional Nevius\" с компьютера и отказаться от его дальнейшего использования.<br><br>
Спасибо за использование скрипта \"Работа Professional Nevius\"!<br><br>
Невежин Евгений,<br>
email: nevius@bk.ru<br>
http://nevius.ru<br>
</p>
<form name=confirm method=post action=mysql.php?create>
<center><input type=submit value='Принять условия' name=ok>
");
}
//
if ($_SERVER[QUERY_STRING] == "create"){
$db = mysql_connect($bdhost,$bdlogin,$bdpass) or die("Подключение к базе данных не состоялось!");
if (!mysql_select_db($bdname,$db))
{
mysql_create_db($bdname,$db);
}
mysql_select_db($bdname,$db) or die("Не удалось выбрать базу данных!");

mysql_query("drop TABLE IF EXISTS $admintable");

//Таблица для списка категорий
mysql_query("CREATE TABLE $catable
(
ID INT(9) UNSIGNED NOT NULL auto_increment,
razdel VARCHAR(100) NOT NULL,
podrazdel VARCHAR(100) NOT NULL,
PRIMARY KEY(ID)
)");

//Таблица для списка стран/регионов/городов
mysql_query("CREATE TABLE $citytable
(
ID INT(9) UNSIGNED NOT NULL auto_increment,
razdel VARCHAR(100) NOT NULL,
podrazdel VARCHAR(100) NOT NULL,
categ VARCHAR(100) NOT NULL,
osn VARCHAR(10) NOT NULL,
PRIMARY KEY(ID)
)");

//Таблица для списка станций метро
mysql_query("CREATE TABLE $metrotable
(
ID SMALLINT UNSIGNED NOT NULL auto_increment,
city INT(4) NOT NULL,
metro VARCHAR(100) NOT NULL,
PRIMARY KEY(ID)
)");

//Таблица для регистрации пользователей
mysql_query("CREATE TABLE $autortable
(
ID INT(9) UNSIGNED NOT NULL auto_increment,
category VARCHAR(20) NOT NULL,
email VARCHAR(50) NOT NULL,
country INT(4) NOT NULL,
region INT(4) NOT NULL,
city INT(4) NOT NULL,
telephone TEXT NOT NULL,
adress TEXT NOT NULL,
url VARCHAR(50) NOT NULL,
fio VARCHAR(100) NOT NULL,
firm VARCHAR(100) NOT NULL,
birth date NOT NULL,
gender VARCHAR(10) NOT NULL,
civil VARCHAR(30) NOT NULL,
family VARCHAR(30) NOT NULL,
prof TEXT NOT NULL,
dopsved TEXT NOT NULL,
deyat TEXT NOT NULL,
date datetime NOT NULL default '0000-00-00 00:00:00',
pass VARCHAR(20) NOT NULL,
foto1 VARCHAR(30) NOT NULL,
foto2 VARCHAR(30) NOT NULL,
status VARCHAR(15) NOT NULL,
code VARCHAR(20) NOT NULL,
catalog VARCHAR(3) NOT NULL default 'off',
ip VARCHAR(30) NOT NULL,
hidemail VARCHAR(10) NOT NULL,
addobyavl VARCHAR(15) NOT NULL,
pay FLOAT(9) NOT NULL,
top datetime NOT NULL,
bold datetime NOT NULL,
edu1sel VARCHAR(50) NOT NULL,
edu1school VARCHAR(100) NOT NULL,
edu1year VARCHAR(10) NOT NULL,
edu1fac VARCHAR(50) NOT NULL,
edu1spec VARCHAR(100) NOT NULL,
edu2sel VARCHAR(50) NOT NULL,
edu2school VARCHAR(100) NOT NULL,
edu2year VARCHAR(10) NOT NULL,
edu2fac VARCHAR(50) NOT NULL,
edu2spec VARCHAR(100) NOT NULL,
edu3sel VARCHAR(50) NOT NULL,
edu3school VARCHAR(100) NOT NULL,
edu3year VARCHAR(10) NOT NULL,
edu3fac VARCHAR(50) NOT NULL,
edu3spec VARCHAR(100) NOT NULL,
edu4sel VARCHAR(50) NOT NULL,
edu4school VARCHAR(100) NOT NULL,
edu4year VARCHAR(10) NOT NULL,
edu4fac VARCHAR(50) NOT NULL,
edu4spec VARCHAR(100) NOT NULL,
edu5sel VARCHAR(50) NOT NULL,
edu5school VARCHAR(100) NOT NULL,
edu5year VARCHAR(10) NOT NULL,
edu5fac VARCHAR(50) NOT NULL,
edu5spec VARCHAR(100) NOT NULL,
lang1 VARCHAR(30) NOT NULL,
lang1uroven VARCHAR(40) NOT NULL,
lang2 VARCHAR(30) NOT NULL,
lang2uroven VARCHAR(40) NOT NULL,
lang3 VARCHAR(30) NOT NULL,
lang3uroven VARCHAR(40) NOT NULL,
lang4 VARCHAR(30) NOT NULL,
lang4uroven VARCHAR(40) NOT NULL,
lang5 VARCHAR(30) NOT NULL,
lang5uroven VARCHAR(40) NOT NULL,
PRIMARY KEY(ID)
)");

//Таблица для резюме
mysql_query("CREATE TABLE $restable
(
ID INT(9) UNSIGNED NOT NULL auto_increment,
razdel INT(4) NOT NULL,
podrazdel INT(4) NOT NULL,
profecy VARCHAR(100) NOT NULL,
grafic VARCHAR(30) NOT NULL,
zanatost VARCHAR(30) NOT NULL,
zp INT(8) NOT NULL,
uslov TEXT NOT NULL,
country INT(4) NOT NULL,
region INT(4) NOT NULL,
city INT(4) NOT NULL,
comment TEXT NOT NULL,
fio VARCHAR(100) NOT NULL,
birth date NOT NULL,
gender VARCHAR(10) NOT NULL,
civil VARCHAR(30) NOT NULL,
family VARCHAR(30) NOT NULL,
expir1org VARCHAR(100) NOT NULL,
expir1perfmonth VARCHAR(10) NOT NULL,
expir1perfyear VARCHAR(4) NOT NULL,
expir1pertmonth VARCHAR(15) NOT NULL,
expir1pertyear VARCHAR(4) NOT NULL,
expir1dol VARCHAR(100) NOT NULL,
expir1obyaz TEXT NOT NULL,
expir2org VARCHAR(100) NOT NULL,
expir2perfmonth VARCHAR(10) NOT NULL,
expir2perfyear VARCHAR(4) NOT NULL,
expir2pertmonth VARCHAR(15) NOT NULL,
expir2pertyear VARCHAR(4) NOT NULL,
expir2dol VARCHAR(100) NOT NULL,
expir2obyaz TEXT NOT NULL,
expir3org VARCHAR(100) NOT NULL,
expir3perfmonth VARCHAR(10) NOT NULL,
expir3perfyear VARCHAR(4) NOT NULL,
expir3pertmonth VARCHAR(15) NOT NULL,
expir3pertyear VARCHAR(4) NOT NULL,
expir3dol VARCHAR(100) NOT NULL,
expir3obyaz TEXT NOT NULL,
expir4org VARCHAR(100) NOT NULL,
expir4perfmonth VARCHAR(10) NOT NULL,
expir4perfyear VARCHAR(4) NOT NULL,
expir4pertmonth VARCHAR(15) NOT NULL,
expir4pertyear VARCHAR(4) NOT NULL,
expir4dol VARCHAR(100) NOT NULL,
expir4obyaz TEXT NOT NULL,
expir5org VARCHAR(100) NOT NULL,
expir5perfmonth VARCHAR(10) NOT NULL,
expir5perfyear VARCHAR(4) NOT NULL,
expir5pertmonth VARCHAR(15) NOT NULL,
expir5pertyear VARCHAR(4) NOT NULL,
expir5dol VARCHAR(100) NOT NULL,
expir5obyaz TEXT NOT NULL,
edu1sel VARCHAR(50) NOT NULL,
edu1school VARCHAR(100) NOT NULL,
edu1year VARCHAR(10) NOT NULL,
edu1fac VARCHAR(50) NOT NULL,
edu1spec VARCHAR(100) NOT NULL,
edu2sel VARCHAR(50) NOT NULL,
edu2school VARCHAR(100) NOT NULL,
edu2year VARCHAR(10) NOT NULL,
edu2fac VARCHAR(50) NOT NULL,
edu2spec VARCHAR(100) NOT NULL,
edu3sel VARCHAR(50) NOT NULL,
edu3school VARCHAR(100) NOT NULL,
edu3year VARCHAR(10) NOT NULL,
edu3fac VARCHAR(50) NOT NULL,
edu3spec VARCHAR(100) NOT NULL,
edu4sel VARCHAR(50) NOT NULL,
edu4school VARCHAR(100) NOT NULL,
edu4year VARCHAR(10) NOT NULL,
edu4fac VARCHAR(50) NOT NULL,
edu4spec VARCHAR(100) NOT NULL,
edu5sel VARCHAR(50) NOT NULL,
edu5school VARCHAR(100) NOT NULL,
edu5year VARCHAR(10) NOT NULL,
edu5fac VARCHAR(50) NOT NULL,
edu5spec VARCHAR(100) NOT NULL,
lang1 VARCHAR(30) NOT NULL,
lang1uroven VARCHAR(40) NOT NULL,
lang2 VARCHAR(30) NOT NULL,
lang2uroven VARCHAR(40) NOT NULL,
lang3 VARCHAR(30) NOT NULL,
lang3uroven VARCHAR(40) NOT NULL,
lang4 VARCHAR(30) NOT NULL,
lang4uroven VARCHAR(40) NOT NULL,
lang5 VARCHAR(30) NOT NULL,
lang5uroven VARCHAR(40) NOT NULL,
prof TEXT NOT NULL,
dopsved TEXT NOT NULL,
period VARCHAR(4) NOT NULL,
aid INT(9) NOT NULL,
foto1 VARCHAR(30) NOT NULL,
date datetime NOT NULL default '0000-00-00 00:00:00',
status VARCHAR(15) NOT NULL,
dayof VARCHAR(3) NOT NULL,
ip VARCHAR(30) NOT NULL,
category VARCHAR(20) NOT NULL,
top datetime NOT NULL,
bold datetime NOT NULL,
archivedate datetime NOT NULL,
PRIMARY KEY(id)
)");

//Таблица для вакансий
mysql_query("CREATE TABLE $vactable
(
ID INT(9) UNSIGNED NOT NULL auto_increment,
razdel INT(4) NOT NULL,
podrazdel INT(4) NOT NULL,
profecy VARCHAR(100) NOT NULL,
agemin INT(3) NOT NULL,
agemax INT(3) NOT NULL,
edu VARCHAR(30) NOT NULL,
zp INT(8) NOT NULL,
gender VARCHAR(10) NOT NULL,
grafic VARCHAR(30) NOT NULL,
zanatost VARCHAR(30) NOT NULL,
stage VARCHAR(30) NOT NULL,
treb TEXT NOT NULL,
obyaz TEXT NOT NULL,
uslov TEXT NOT NULL,
country INT(4) NOT NULL,
region INT(4) NOT NULL,
city INT(4) NOT NULL,
metro VARCHAR(50) NOT NULL,
adress TEXT NOT NULL,
firm VARCHAR(100) NOT NULL,
period VARCHAR(4) NOT NULL,
aid INT(9) NOT NULL,
date datetime NOT NULL default '0000-00-00 00:00:00',
status VARCHAR(15) NOT NULL,
dayof VARCHAR(3) NOT NULL,
ip VARCHAR(30) NOT NULL,
category VARCHAR(20) NOT NULL,
top datetime NOT NULL,
bold datetime NOT NULL,
archivedate datetime NOT NULL,
PRIMARY KEY(id)
)");

//Таблица для IP-адресов пользователей, запрещенных к регистрации
mysql_query("CREATE TABLE $bunsiptable
(
ID INT(9) UNSIGNED NOT NULL auto_increment,
bunsip VARCHAR(30) NOT NULL,
why TEXT NOT NULL,
date datetime NOT NULL default '0000-00-00 00:00:00',
period VARCHAR(4) NOT NULL,
PRIMARY KEY(ID)
)");

//Таблица для параметоров рассылки
mysql_query("CREATE TABLE $rassilka
(
ID INT(9) UNSIGNED NOT NULL auto_increment,
name VARCHAR(10) NOT NULL,
status VARCHAR(10) NOT NULL,
date date NOT NULL,
vac INT(3) NOT NULL,
res INT(3) NOT NULL,
PRIMARY KEY(ID)
)");

//Таблица для подписки на вакансии
mysql_query("CREATE TABLE $rasvac
(
ID INT(9) UNSIGNED NOT NULL auto_increment,
razdel INT(4) NOT NULL,
podrazdel INT(4) NOT NULL,
srprofecy VARCHAR(100) NOT NULL,
srcountry INT(4) NOT NULL,
srregion INT(4) NOT NULL,
srcity INT(4) NOT NULL,
srage INT(3) NOT NULL,
sredu VARCHAR(30) NOT NULL,
srzp INT(8) NOT NULL,
srgrafic VARCHAR(30) NOT NULL,
srzanatost VARCHAR(30) NOT NULL,
srgender VARCHAR(10) NOT NULL,
txt text NOT NULL,
sum INT(2) NOT NULL,
aid INT(9) NOT NULL,
date datetime NOT NULL default '0000-00-00 00:00:00',
PRIMARY KEY(ID)
)");

//Таблица для подписки на резюме
mysql_query("CREATE TABLE $rasres
(
ID INT(9) UNSIGNED NOT NULL auto_increment,
razdel INT(4) NOT NULL,
podrazdel INT(4) NOT NULL,
srprofecy VARCHAR(100) NOT NULL,
srcountry INT(4) NOT NULL,
srregion INT(4) NOT NULL,
srcity INT(4) NOT NULL,
agemin INT(3) NOT NULL,
agemax INT(3) NOT NULL,
srzp INT(8) NOT NULL,
srgrafic VARCHAR(30) NOT NULL,
srzanatost VARCHAR(30) NOT NULL,
srgender VARCHAR(10) NOT NULL,
txt text NOT NULL,
sum INT(2) NOT NULL,
aid INT(9) NOT NULL,
date datetime NOT NULL default '0000-00-00 00:00:00',
PRIMARY KEY(ID)
)");

//Таблица для комментариев к фирмам
mysql_query("CREATE TABLE $rabcommentstable
(
ID INT(9) UNSIGNED NOT NULL auto_increment,
tid INT(9) NOT NULL,
aid INT(9) NOT NULL,
comment TEXT NOT NULL,
date date NOT NULL,
ip VARCHAR(30) NOT NULL,
status VARCHAR(15) NOT NULL,
PRIMARY KEY(ID)
)");

//Таблица для вопросов FAQ
mysql_query("CREATE TABLE $faqnewtable
(
idnum INT(9) UNSIGNED NOT NULL auto_increment,
time varchar(5) NOT NULL,
datum date NOT NULL,
vopros text NOT NULL,
name varchar(60) NOT NULL,
email varchar(100) NOT NULL,
ip text NOT NULL,
brouser text NOT NULL,
primary key(idnum)
)");

//Таблица для FAQ
mysql_query("CREATE TABLE $faqtable
(
idnum INT(9) UNSIGNED NOT NULL auto_increment,
time varchar(5) NOT NULL,
datum date NOT NULL,
vopros text NOT NULL,
otvet text NOT NULL,
name varchar(60) NOT NULL,
email varchar(100) NOT NULL,
primary key(idnum)
)");

//Таблица для новостей сайта
mysql_query("CREATE TABLE $newstable
(
idnum INT(9) UNSIGNED NOT NULL auto_increment,
time varchar(5) NOT NULL,
datum date NOT NULL,
title text NOT NULL,
content text NOT NULL,
visible varchar(3) default 'on' NOT NULL,
ip text NOT NULL,
brouser text NOT NULL,
primary key(idnum)
)");

//Таблица для сообщений форума
mysql_query("CREATE TABLE $forumtable
(
rootID INT(9) UNSIGNED NOT NULL auto_increment,
parentID INT(9) UNSIGNED NOT NULL,
name TEXT NOT NULL,
tema TEXT NOT NULL,
comment TEXT NOT NULL,
email VARCHAR(40) NOT NULL,
date datetime NOT NULL default '0000-00-00 00:00:00',
lastdate datetime NOT NULL default '0000-00-00 00:00:00',
rew VARCHAR(3) NOT NULL,
pass VARCHAR(1) NOT NULL,
ip VARCHAR(30) NOT NULL,
count INT(9) NOT NULL,
PRIMARY KEY(rootID)
)");

//Таблица для списка категорий статей
mysql_query("CREATE TABLE $textcatable
(
ID INT(9) UNSIGNED NOT NULL auto_increment,
genre VARCHAR(100) NOT NULL,
PRIMARY KEY(ID)
)");

//Таблица для базы статей
mysql_query("CREATE TABLE $textable
(
ID INT(9) UNSIGNED NOT NULL auto_increment,
title VARCHAR(50) NOT NULL,
genre VARCHAR(40) NOT NULL,
theme VARCHAR(100) NOT NULL,
autor VARCHAR(50) NOT NULL,
aid INT(9) NOT NULL,
size DOUBLE(16,2) NOT NULL,
preview TEXT NOT NULL,
text TEXT NOT NULL,
foto1 VARCHAR(30) NOT NULL,
foto2 VARCHAR(30) NOT NULL,
foto3 VARCHAR(30) NOT NULL,
foto4 VARCHAR(30) NOT NULL,
foto5 VARCHAR(30) NOT NULL,
date datetime NOT NULL default '0000-00-00 00:00:00',
reiting INT(9) NOT NULL,
sum INT(9) NOT NULL,
status VARCHAR(15) NOT NULL,
ip VARCHAR(30) NOT NULL,
PRIMARY KEY(ID)
)");

//Таблица для комментариев к статьям
mysql_query("CREATE TABLE $commentstable
(
ID INT(9) UNSIGNED NOT NULL auto_increment,
tid INT(9) NOT NULL,
name VARCHAR(50) NOT NULL,
email VARCHAR(50) NOT NULL,
comment TEXT NOT NULL,
date datetime NOT NULL default '0000-00-00 00:00:00',
PRIMARY KEY(ID)
)");

//Таблица для заполнения корзины вакансий
mysql_query("CREATE TABLE $vacordertable
(
ID INT(10) UNSIGNED NOT NULL auto_increment,
user VARCHAR(50) NOT NULL,
unit INT(10) NOT NULL,
number INT(4) NOT NULL,
date datetime NOT NULL,
status VARCHAR(15) NOT NULL,
PRIMARY KEY(ID)
)");

//Таблица для заполнения корзины резюме
mysql_query("CREATE TABLE $resordertable
(
ID INT(10) UNSIGNED NOT NULL auto_increment,
user VARCHAR(50) NOT NULL,
unit INT(10) NOT NULL,
number INT(4) NOT NULL,
date datetime NOT NULL,
status VARCHAR(15) NOT NULL,
PRIMARY KEY(ID)
)");

//Таблица для защиты от накрутки голосов
mysql_query("CREATE TABLE votetable
(
aid INT(9) NOT NULL,
ip VARCHAR(30) NOT NULL,
date datetime NOT NULL,
PRIMARY KEY(aid)
)");

//Таблица для блоков рекламы
mysql_query("CREATE TABLE $promotable
(
ID INT(10) UNSIGNED NOT NULL auto_increment,
title text NOT NULL,
link text NOT NULL,
wheres varchar(10) NOT NULL,
place varchar(10) NOT NULL,
period VARCHAR(4) NOT NULL,
date datetime NOT NULL default '0000-00-00 00:00:00',
visible varchar(3) default 'on' NOT NULL,
foto VARCHAR(30) NOT NULL,
country INT(4) NOT NULL,
region INT(4) NOT NULL,
city INT(4) NOT NULL,
allcity INT(2) NOT NULL,
aid INT(9) NOT NULL,
status VARCHAR(15) NOT NULL,
pay FLOAT(9) NOT NULL,
price FLOAT(9) NOT NULL,
PRIMARY KEY(ID)
)");

//Таблица для сообщений
mysql_query("CREATE TABLE $messagetable
(
ID INT(9) UNSIGNED NOT NULL auto_increment,
tid INT(9) NOT NULL,
aid INT(9) NOT NULL,
comment TEXT NOT NULL,
showed INT(1) NOT NULL,
date datetime NOT NULL,
ip VARCHAR(30) NOT NULL,
PRIMARY KEY(ID)
)");

//Таблица для жалоб
mysql_query("CREATE TABLE $zhalobatable
(
ID INT(9) UNSIGNED NOT NULL auto_increment,
categ VARCHAR(10) NOT NULL,
num INT(9) NOT NULL,
user INT(9) NOT NULL,
comment TEXT NOT NULL,
date datetime NOT NULL default '0000-00-00 00:00:00',
ip VARCHAR(20) NOT NULL,
PRIMARY KEY(ID)
)");

//Таблица для пароля администратора
mysql_query("CREATE TABLE $admintable
(
ID INT(9) UNSIGNED NOT NULL auto_increment,
pass VARCHAR(30) NOT NULL,
PRIMARY KEY(ID)
)");

//Таблица для афиши
mysql_query("CREATE TABLE $afishatable
(
ID INT(10) UNSIGNED NOT NULL auto_increment,
category TEXT NOT NULL,
title TEXT NOT NULL,
preview TEXT NOT NULL,
detail TEXT NOT NULL,
datum date NOT NULL,
time VARCHAR(100) NOT NULL,
datumend date NOT NULL,
date datetime NOT NULL,
foto1 VARCHAR(50) NOT NULL,
foto2 VARCHAR(50) NOT NULL,
foto3 VARCHAR(50) NOT NULL,
foto4 VARCHAR(50) NOT NULL,
foto5 VARCHAR(50) NOT NULL,
otchet VARCHAR(7) NOT NULL,
hot VARCHAR(7) NOT NULL,
zav INT(9) NOT NULL,
autor TEXT NOT NULL,
noshow VARCHAR(7) NOT NULL,
PRIMARY KEY(ID)
)");

//Таблица для отчетов
mysql_query("CREATE TABLE $reporttable
(
ID INT(10) UNSIGNED NOT NULL auto_increment,
category TEXT NOT NULL,
title TEXT NOT NULL,
preview TEXT NOT NULL,
detail TEXT NOT NULL,
datum date NOT NULL,
date datetime NOT NULL,
foto1 VARCHAR(50) NOT NULL,
foto2 VARCHAR(50) NOT NULL,
foto3 VARCHAR(50) NOT NULL,
foto4 VARCHAR(50) NOT NULL,
foto5 VARCHAR(50) NOT NULL,
foto6 VARCHAR(50) NOT NULL,
foto7 VARCHAR(50) NOT NULL,
foto8 VARCHAR(50) NOT NULL,
foto9 VARCHAR(50) NOT NULL,
foto10 VARCHAR(50) NOT NULL,
aid INT(9) NOT NULL,
zav INT(9) NOT NULL,
hot VARCHAR(7) NOT NULL,
autor TEXT NOT NULL,
PRIMARY KEY(ID)
)");

//Таблица для комментариев к афише
mysql_query("CREATE TABLE $afishacommentstable
(
ID INT(9) UNSIGNED NOT NULL auto_increment,
tid INT(9) NOT NULL,
name VARCHAR(50) NOT NULL,
email VARCHAR(50) NOT NULL,
comment TEXT NOT NULL,
date datetime NOT NULL default '0000-00-00 00:00:00',
categ VARCHAR(50) NOT NULL,
PRIMARY KEY(ID)
)");

//Таблица для списка категорий афиши
mysql_query("CREATE TABLE $afishacatable
(
ID INT(9) UNSIGNED NOT NULL auto_increment,
category VARCHAR(100) NOT NULL,
PRIMARY KEY(ID)
)");

//Таблица для списка учреждений
mysql_query("CREATE TABLE $zavtable
(
ID INT(9) UNSIGNED NOT NULL auto_increment,
category TEXT NOT NULL,
name TEXT NOT NULL,
comment TEXT NOT NULL,
email VARCHAR(50) NOT NULL,
telephone TEXT NOT NULL,
adress TEXT NOT NULL,
url VARCHAR(100) NOT NULL,
date datetime NOT NULL,
foto1 VARCHAR(50) NOT NULL,
foto2 VARCHAR(50) NOT NULL,
foto3 VARCHAR(50) NOT NULL,
foto4 VARCHAR(50) NOT NULL,
foto5 VARCHAR(50) NOT NULL,
PRIMARY KEY(ID)
)");

//Таблица для email-адресов (рассылка афиши)
mysql_query("CREATE TABLE $emailr
(
ID INT(9) UNSIGNED NOT NULL auto_increment,
email VARCHAR(50) NOT NULL,
vac VARCHAR(3) NOT NULL,
PRIMARY KEY(ID)
)");

//Таблица для результатов поиска
mysql_query("CREATE TABLE $searchtable
(
ID INT(10) UNSIGNED NOT NULL auto_increment,
finded TEXT NOT NULL,
qwery TEXT NOT NULL,
date datetime NOT NULL,
ip VARCHAR(30) NOT NULL,
PRIMARY KEY(ID)
)");

//Таблица для qiwi платежей
mysql_query("CREATE TABLE $qiwitable
(
ID INT(9) UNSIGNED NOT NULL auto_increment,
code VARCHAR(50) NOT NULL,
pay VARCHAR(50) NOT NULL,
aid INT(9) NOT NULL,
date datetime NOT NULL default '0000-00-00 00:00:00',
PRIMARY KEY(ID)
)");

mysql_query("INSERT INTO $admintable (pass) VALUES ('')");
mysql_query("INSERT INTO $rassilka (name,status) VALUES ('admin','on')");

mysql_close($db);

echo "<h3 align=center>База данных создана!</h3><br><p align=center>Спасибо за выбор нашего скрипта! Приятной работы!<br><br><a href=index.php>Зайти на сайт</a></p><br><br>";
}
?>