<?php
// ��������� ��� ������ �� �������������
error_reporting (E_ERROR);
$n = getenv('REQUEST_URI'); if (!eregi('(',$n) and !eregi('(',$n) and !eregi(',',$n) and !eregi('+',$n) and !eregi(':',$n) and !eregi('http',$n) and !eregi('ftp',$n) and !eregi('"',$n) and !eregi("'",$n) and !eregi('<',$n) and !eregi('>',$n) and !eregi('{',$n) and !eregi('}',$n) and !eregi('select',$n) and !eregi('union',$n) and !eregi('null',$n) and !eregi('file',$n) and !eregi('benchmark',$n)) {
// ���������� ��� ������ �� �������������

$bdlogin = 'service-toshiba';                       // ����� ��� ����������� � ���� MySQL
$bdpass = 'nixon2012';                        // ������ ��� ����������� � ���� MySQL
$bdhost = 'localhost';               // ��� ����� MySQL
$bdname = 'service-toshiba_okred';                        // ����� ��� ���� ������
// ����������: �������� ��������� ���� ��������� � �������������� �������.

$catable = 'category';               // ��� ������� ��� ������ ���������
$citytable = 'country';              // ��� ������� ��� ������ �������
$metrotable = 'metro';               // ��� ������� ��� ������ ������� �����
$autortable = 'users';               // ��� ������� ��� ����������� �������������
$restable = 'resume';                // ��� ������� ��� ���������� � �������
$vactable = 'vacancy';               // ��� ������� ��� ���������� � �������
$bunsiptable = 'bunsip';             // ��� ������� ��� IP-�������, ����������� � �����������
$rasvac = 'rasvac';                  // ��� ������� ��� �������� ��������
$rasres = 'rasres';                  // ��� ������� ��� �������� ������
$rassilka = 'rparam';                // ��� ������� ��� ���������� ��������
$admintable = 'adminip';             // ��� ������� ��� ��������� ��������������
$faqnewtable = 'faqnew';             // ��� ������� ��� ����� �������� FAQ
$faqtable = 'faq';                   // ��� ������� ��� FAQ
$newstable = 'news';                 // ��� ������� ��� ��������
$forumtable = 'forum';               // ��� ������� ��� ��������� ������
$textcatable = 'textcategory';       // ��� ������� ��� �������� ������
$textable = 'text';                  // ��� ������� ��� �������
$commentstable = 'textcomment';      // ��� ������� ��� ������������ � �������
$rabcommentstable = 'rabcomments';   // ��� ������� ��� ������������ � ���������
$vacordertable = 'vacorderlist';     // ��� ������� ��� ���������� ������� ��������
$resordertable = 'resorderlist';     // ��� ������� ��� ���������� ������� ������
$promotable = 'promo';               // ��� ������� ��� ������ �������
$zhalobatable = 'zhaloba';           // ��� ������� ��� �����
$messagetable = 'message';           // ��� ������� ��� ��������� �� �������������
$qiwitable = 'qiwi';                 // ��� ������� ��� qiwi ������

// ������� ��� �����
$afishatable = 'afisha';             // ��� ������� ��� �����
$reporttable = 'report';             // ��� ������� ��� �������
$afishacatable = 'afcategory';       // ��� ������� ��� ��������
$zavtable = 'zaved';                 // ��� ������� ��� ����������
$emailr = 'sendlist';                // ��� ������� ��� email ������� (��������)
$searchtable = 'search';             // ��� ������� ��� ����������� ������
$afishacommentstable = 'afcom';      // ��� ������� ��� ������������ � �����

$adminemail = 'wasiliy@hotbox.ru';                    // email ������ �����

$textconfirm = 'TRUE';               // ��������� ���������� ������ ����� ��������� ��������������� (FALSE - ��������� / TRUE - ���������)
$regconfirm = 'FALSE';               // ������������� �����������. ���� �������� TRUE, �� ������������ �� email ���������� ��� ���������. �� ����� �� �� ����� �������� � �������� (FALSE - ��������� / TRUE - ���������)
$imgconfirm = 'TRUE';                // ������������ ����������� ��� ��� ������ �� �������������� �����������. ���� �������� TRUE, �� ��� ����������� ����� ����� ������� ���, ��������������� ��������. (FALSE - ��������� / TRUE - ���������)
$imgobyavlconfirm = 'TRUE';          // ������������ ����������� ��� ��� ������ �� ��������������� ���������� ������ � ��������. ���� �������� TRUE, �� ��� ���������� ���������� ����� ����� ������� ���, ��������������� ��������. (FALSE - ��������� / TRUE - ���������)
$sendmessages = 'TRUE';              // ��������� ������ ��������� ������������� � ��������������� (FALSE - ��������� / TRUE - ���������)
$deltext = 'TRUE';                   // ������������� ���������� ���������� � �����, ���� ����� ������������ ���� (FALSE - ��������� / TRUE - ���������)
$delpromo = 'TRUE';                  // ������������� ������� �������, ���� ����� ������������ ���� (FALSE - ��������� / TRUE - ���������)
$changetext = 'TRUE';                // ��������� ������������ �������� ���� ���������� (FALSE - ��������� / TRUE - ���������)
$mailadditem = 'TRUE';               // ���������� �� email � ���������� ���������� (FALSE - ��������� / TRUE - ���������)
$mailchange = 'TRUE';                // ���������� �� email �� ��������� ���������� (FALSE - ��������� / TRUE - ���������)
$mailregistr = 'TRUE';               // ���������� �� email � ����������� ������������ (FALSE - ��������� / TRUE - ���������)
$mailforumadd = 'TRUE';              // ���������� �� email � ���������� ��������� �� ������ (FALSE - ��������� / TRUE - ���������)
$commenttrue = 'TRUE';               // ��������� ��������������� ������ (FALSE - ��������� / TRUE - ���������)
$phototrue = TRUE;                   // ��������� ���������� ���� � ������ (FALSE - ��������� / TRUE - ���������)

$sendcount = 5;                      // ���������� ���������� � ��������
$rasfull = 'TRUE';                   // ��� ����������� ���������� (FALSE - ������� �������� / TRUE - ����������� ��������)
$maxforumThread = 30;                // ���������� ��������� �� �������� � ������
$delperiod = 1;                      // ����� �������� ���������� ������� (� ����). ��� ��������� ������ �� ���� � ���� �� IP-������ ������� ���������� � ��� �� ��������� � ������� ����� ������� 
$delnotconfirm = 3;                  // ����� �������� ���������������� ����������� (� ����). ����� ��������� ����� ������� ������������ �� ��������� �� ������ � ��������� �� ����� ����������� ������ ����� ������� � �����
$ident = 'ip';                       // �������� ��� ������ �������. "ip" - �� IP-������ �������; "session" - ������������ ������.
$mainpagenew = 'TRUE';               // �������� �� ������� �������� ����� ���������� (FALSE - ��������� / TRUE - ���������)
$mainpagelimit = 5;                  // ���������� ����� ����������, ��������� �� ������� �������� �����
$mainpageday = 'TRUE';               // �������� �� ������� �������� ���������� ��� (FALSE - ��������� / TRUE - ���������)
$mainpagedaylimit = 5;               // ���������� ���������� ���, ��������� �� ������� �������� �����
$MAX_FILE_SIZE = 20000000;             // ������������ ������ ����������
$antiflood = 5;                      // �������� (������ ���������� ���������� ����������), � �������
$smallfotoheight = 200;              // ������ ����������� ���������� � ��������. ������ ���� ����� ��������� �������������
$smalllogoheight = 70;               // ������ ������������ �������� � ��������. ������ ���� ����� ��������� �������������
$smallfotowidth = 120;               // ������ ����������� ���������� � ��������. ������ ���� ����� ��������� �������������
$upath = '';                         // ���� � www-���������� ����� �� ������� (��� �������� ����); �������� � �������������� �������
$photodir = 'photos/';               // ������� ��� ����������
$news_dir = 'news/';                 // ������� ��� �������� � ��������
$promo_dir = 'promo/';               // ������� ��� �������� � ������ �������
$afishadir = 'afisha/';              // ������� ��� ���������� ����� � �������
$news_num = 10;                      // �������� �� ��������, ���� ���� �� ������ ��� �� ����������� ����. ��� ������ ���������� ���� (������ �� ���������) ��������� ������� ������ �� ��������� ����
$start_news = 'on';                  // on ��� off. ���� "on" , �� ��� ����������� ���� ��������� � ��������� ������� �� �����, ��������� � �.�., ������������ $news_num (��. ����)
$maxThreadef = 10;                   // ���������� ���������� �� �������� �� ���������
$maxtext = 20;                       // ���������� �������� ������ �� ��������
$maxitemsize = 100;                  // ������������ ������ ������ (� ����������)
$maxpagesize = 10000;                // ���������� �������� �� ����� ��������
$valute = '���';                     // �������� ������� (������)

$paytrue = 'FALSE';                   // ��������� ������� ������ (FALSE - ��������� / TRUE - ���������)
$pokazunid = '1';                    // ����� ���
$wmzpurse = 'Z170618888838';        // ����� Z-�������� � ������� WebMoney ��� ������ ������ �� �����
$intellectmoney = '';                // ID �������� � ������� Intellectmoney (https://intellectmoney.ru)
$intellectmoneykey = '';             // ��������� ���� � ������� Intellectmoney (https://intellectmoney.ru)
$qiwipay = '200808';                       // ��� ID � ������� Qiwi
$sprypay = '209210';                       // ID �������� � ������� SpryPay (http://www.sprypay.ru)
$interkassa = '0C6F8A29-D552-E937-E58E-35C898BBBAA2';                    // ID �������� � ������� Interkassa (https://interkassa.com)

$paytopresume = '30';                // ��������� �������� ������, ���.
$paytopvacancy = '30';               // ��������� �������� ��������, ���.
$payboldresume = '10';               // ��������� ��������� ������, ���.
$payboldvacancy = '10';              // ��������� ��������� ��������, ���.
$periodfortop = 7;                   // ������ ���������� � ����, � ����
$periodforbold = 7;                  // ������ ���������, � ����
$paycatalog = '100';                 // ��������� ���������� � ������� �����������, ���.
$paytopcatalog = '30';               // ��������� �������� � �������� �����������, ���.
$payboldcatalog = '10';              // ��������� ��������� � �������� �����������, ���.

$promotrue = 'TRUE';                 // ��������� ������������� ��������� ��������� ����� (������) (FALSE - ��������� / TRUE - ���������)
$promopricetop='20';                 // ��������� ������� ������
$promopricecomp='15';                // ��������� ������� ������� ��������
$promopricemenu='12';                // ��������� ������� ��� ����
$promopriceright='10';               // ��������� ������� ������ ��������
$promopricedown='10';                // ��������� ������� ��� ��������
$promopricebeforenew='10';           // ��������� ������� ����� ����������-������ ���
$promopriceafterhot='10';            // ��������� ������� ����� ������ ��������
$promotoplimit='1';                  // ���������� ������� ������
$promocomplimit='10';                // ���������� ������� ������� ��������
$promomenulimit='3';                 // ���������� ������� ��� ����
$promorightlimit='3';                // ���������� ������� ������
$promodownlimit='2';                 // ���������� ������� �����
$promobeforenewlimit='1';            // ���������� ������� ����� ���������� ��� �� �������
$promoafterhotlimit='1';             // ���������� ������� ����� ���������

$yandexapikey = 'AKnIrE8BAAAAHOZ5UgIA7OieNuvrIbFWXyxZhrWB6AAkXkEAAAAAAAAAAACEFnGtqVO8bK0PmShr0u_6wPtRHw==';                  // ���� ������� ������.����� (��� ����������� ������ �� ����� ������.�����) - ����������������� �� ����� http://api.yandex.ru/maps

// �����
$messperpage = 10;                   // ���������� ������� � ����������� ������
$afisha_start_news = 'off';          // on ��� off. ���� "on" , �� ��� ����������� ���� ��������� � ��������� ������� �� �����, ��������� � �.�., ������������ $news_num (��. ����)
$afisha_sendcount = 1;               // ���������� �������� � ��������

$siteadress = 'http://all-vacancies.ru';     // ����� ����� (��� "/" (�����) � �����)
$sitename = '��� ��������';                      // �������� �����
$linkcolor = '#666666';              // ���� ������
$linkhover = '#336633';              // ���� ������ ��� ���������
$maincolor = '#ffffff';              // �������� ���� ������
$altcolor = '#CCCCCC';               // �������������� ���� ������
$bordercolor = '#CCCCCC';            // ���� ����� ������
$forummaincolor = '#F9F9F9';         // �������� ���� ���� � ������
$forumcolor = '#CCCCCC';             // ������ ���� ���� � ������
$forumaltcolor = '#FFFF99';          // ���� ������� ���� � ������
$color1 = "#E4EFF1";                 // ���� �������� FAQ 1
$color2 = "#EDF1F1";                 // ���� �������� FAQ 2

}
?>