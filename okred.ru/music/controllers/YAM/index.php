<?php
// XGRlBW9FXlekgbPrRHuSiA

include_once 'api.php';

YAP('angerist');
var_dump(YAM('Daft Punk — Harder Better Faster Stronger'));

die('this is developer test file');
/*
echo '<pre style="text-align: center">';


function YAM($text) {
        $results = array();
        
        // инициализация, указание страницы поиска
        $ch = curl_init('http://music.yandex.ru/fragment/search?text='.  rawurlencode($text).'&type=tracks');
        // возвращать через return а не выводить на страницу
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // получаем страницу поиска
        while( false === ($r = curl_exec($ch)) );
        // разбиваем на результаты
        $res = preg_split("/\<\/div\>\<div\ class\=\"b\-track\s+js\-track\s+js\-track/i", $r);
        // обрабатываем каждый результат  (первый и последний результат не треки)
        for( $i = 1, $l = sizeof($res); $i < $l; $i++ ) {
                // получаем только значение свойства onclick в котором вся информация о треке
                $res[$i] = preg_replace("/.*?return\s+([^\}]+\}).+$/si", "$1", $res[$i]);
                // приводим результат к формату максимально обрабатываемому как json
                $res[$i] = preg_replace(
                        array(
                                "/\'+/i",
                                "/\&quot\;/i",
                                "/\{\s*\"/i",
                                "/\"\s*\}/i",
                                "/([\,\:])\s*\"/i"
                        ), array(
                                "",
                                "\"",
                                "{\"",
                                "\"}",
                                "$1 \""
                        ),
                        $res[$i]
                );

                $t = json_decode($res[$i], true);
                if( !$t ) {
                        // если не получилось разобрать то в лог
                        file_put_contents('YAM_parse_error.log', $res[$i].PHP_EOL.PHP_EOL, FILE_APPEND);
                } else {
                        // получаем страницу в filename трека
                        curl_setopt($ch, CURLOPT_URL, 'http://storage.music.yandex.ru/get/'.$t['storage_dir'].'/2.xml');
                        while( false === ($r = curl_exec($ch)) );
                        $filename = preg_replace("/.*?filename\=\"([^\'\"]+).+$/si", "$1", $r);
                        // получаем страницу с информацией для загрузки
                        curl_setopt($ch, CURLOPT_URL, 'http://storage.music.yandex.ru/download-info/'.$t['storage_dir'].'/'.$filename);
                        while( false === ($r = curl_exec($ch)) );
                        // убираем мусор из xml ответа и приводим к формату json
                        $r = preg_replace(array("/^.*?\<\/regional\-host\>/i", "/\<\/download-info\>.*$/i", "/\<([\w\-]+)[^\>]*\>/i", "/\<\/.*?\>/i"), array('', '', "\"$1\": \"", "\", \r\n"), $r);
                        $r = json_decode('{'.substr(trim($r), 0, -1).'}', true);
                        
                        if( $r !== null ) {
                                // генерация волшебной ссылки со всеми плюшками
                                $t['url'] = "http://".$r['host']."/get-mp3/".md5('XGRlBW9FXlekgbPrRHuSiA'.substr($r['path'], 1) . $r['s'])."/".$r['ts'].$r['path']."?track-id=".$t['id'].'&from=service-search';
                                $results[] = $t;
                        }
                }
        }
        return $results;
}

var_dump(YAM('miss k8'));
*/
?>