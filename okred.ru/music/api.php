<?php

/*
 * Автор: NeZeD
 *
 * Запущу ка я курл тут и сразу =)
 */
$__ch = curl_init();
curl_setopt($__ch, CURLOPT_RETURNTRANSFER, 1);
define('lfm_cache_time_offset', -5); // 3 символа - 17 минут, 4 символа - 2ч. 46м., 5 символов - 27 часов
define('y_cache_time_offset', -5);

/**
 * Функция очистки директории кэширования
 * 
 * @param string $dir Директория кэша
 * @param int $time_offset Количество цифр влияющих на время кэширования
 * @author NeZeD <nezed.ru>
 * @return null
 */
function clearCache($dir = 'cache/', $time_offset = 5) {
        $dir = rtrim($dir, '/') . '/';
        if (strlen($dir) < 3)
                return;
        if(!is_dir($dir)) {
                mkdir($dir);
                return;
        }
        if ($h = @opendir($dir)) {
                while (false !== ($file = readdir($h))) {
                        if ($file[0] != '.' && is_file($dir . $file) && (substr(filemtime($dir . $file), 0, $time_offset) < substr(time(), 0, $time_offset))) {
                                if (!empty($file))
                                        @unlink($dir . $file);
                        }
                }
                closedir($h);
        }
        return;
}

/**
 * Функция trim массива
 * 
 * @param array $a Входной массив
 * @param string $c Список удаляемых символов
 * @author NeZeD <nezed.ru>
 * @return array
 */
function a_trim($a, $c = null) {
        if (is_array($a)) {
//                for( $i = 0, $l = sizeof($a); $i < $l; $i++ )
//                        $a[$i] = a_trim($a[$i], $c);
                foreach ($a as $key => $value) {
                        $a[$key] = a_trim($a[$key], $c);
                }
                return $a;
        } else if (is_string($a)) {
                if ($c !== null)
                        return trim($a, $c);
                else
                        return trim($a);
        } else {
                return $a;
        }
}

/**
 * Функция поиска значения в массиве
 * @param array $array Массив внутри которого будет произведен поиск
 * @param mixed $search Искомое
 * @author NeZeD <nezed.ru>
 * @return boolean 
 */
function value_in_array($array, $search) {
        if (is_array($array)) {
                foreach ($array as $key => $value) {
                        if(value_in_array($array[$key], $search)) {
                                return true;
                        }
                }
                return false;
        } else {
                return ($array == $search);
        }
        
}

/**
 * Функция запроса к LastFM API
 * 
 * @global object $__ch Объект открытого curl
 * @param string $method Метод API
 * @param array $params Параметры метода
 * @param int $errors Количество ошибок выполнения этого запроса
 * @author NeZeD <nezed.ru>
 * @return mixed 
 */
function LFMapi($method, $params = null, $errors = 0) {
        global $__ch;

        $query = 'http://ws.audioscrobbler.com/2.0/?method=' . $method . '&api_key=dd4bd578a85b0c5925db99a2d03a0a00&format=json&lang=ru';
        if ($params !== null) {
                foreach ($params as $key => $value) {
                        if ($key !== 'lang')
                                $query .= '&' . rawurlencode($key) . '=' . rawurlencode($value);
                }
        }
        // контроль времени жизни кэша запроса
        $query .= '&timedump=' . substr(time(), 0, lfm_cache_time_offset);
        // файл кеширования этого запроса
        $cache_file = 'cache/lastfm/' . md5($query) . '.nz';

        if ($errors > 6) //Если больше 6 ошибок подключения то останавливаем попытки
                return;

        if (!file_exists($cache_file) || !($response = file_get_contents($cache_file))) {
                curl_setopt($__ch, CURLOPT_URL, $query);
                $response = curl_exec($__ch);
                if ($response !== false) {
                        @file_put_contents($cache_file, $response);
                        // если этот запрос не был найден в кеше то скорее всего он был просрочен
                        // и необходимо удалить все просроченыйе файлы кеша
                        clearCache('cache/lastfm/', lfm_cache_time_offset);
                }
        }
        /*
         * Если нет проблем с подключением сокета (т.е. соединение интернет функционирует нормально), то продолжаем 
         */
        if ($response !== false) {
                $result = json_decode($response, true);

                /*
                 *  Обработка кодов ошибок.
                 * код 29 означает что запросы выполняются слишком часто
                 */
                if (isset($result['error'])) {
                        if ($result['error'] == 29) {
                                sleep(1);
                                return LFMapi($method, $params, $errors);
                        } else {
                                //echo 'API Error '.print_r($result['error'], true).'<br/>';
                        }
                        //return;
                }

                return $result;
        } else {
                /*
                 * Если возникли проблемы с интернет поключением повторяем запрос
                 * и увеличиваем количество ошибок подключания на 1
                 */
                return LFMapi($method, $params, ++$errors);
        }
}

/**
 * Получение популярных треков с Яндекс.Музыки
 * 
 * @global object $__ch Объект открытого curl
 * @param int $page Номер страницы результатов
 * @param string $genre Желаемый жанр
 * @author NeZeD <nezed.ru>
 * @return array 
 */
function YAM_getTopTracks($page = 0, $genre = 'all') {
        global $__ch;

        // контроль времени запроса
        $cache_file = $genre . '&timedump=' . substr(time(), 0, y_cache_time_offset) . '&page=' . (int) $page;
        // файл кеширования этого запроса
        $cache_file = 'cache/YAM/' . md5($cache_file) . '.nz';

        if (!file_exists($cache_file) || (null == ($r = file_get_contents($cache_file)) ) || strlen($r) < 50 ) {
                // очищаем кэш
                clearCache('cache/YAM/', y_cache_time_offset);
                // инициализация, указание страницы поиска
                curl_setopt($__ch, CURLOPT_URL, 'http://music.yandex.ru/fragment/top/tracks/genre/' . $genre . ( $page > 0 ? '?page=' . $page : ''));

                // получаем страницу поиска
                while (false === ($r = curl_exec($__ch)));
                // сохраняем в кэш
                @file_put_contents($cache_file, $r);
        }

        return YAM_parser($r);
}

/**
 * Поиск по сервису Я.М
 * 
 * @global object $__ch Объект открытого curl
 * @param string $text Поисковый запрос
 * @param int $page Страница результатов
 * @author NeZeD <nezed.ru>
 * @return array 
 */
function YAM($text, $page = 0) {
        global $__ch;

        // контроль времени запроса
        $cache_file = $text . '&timedump=' . substr(time(), 0, y_cache_time_offset) . '&page=' . (int) $page;
        // файл кеширования этого запроса
        $cache_file = 'cache/YAM/' . md5($cache_file) . '.nz';

        if (!file_exists($cache_file) || (null == ($r = file_get_contents($cache_file)) )) {
                // очищаем кэш
                clearCache('cache/YAM/', y_cache_time_offset);
                
                // инициализация, указание страницы поиска
                curl_setopt($__ch, CURLOPT_URL, 'http://music.yandex.ru/fragment/search?text=' . rawurlencode($text) . '&type=tracks' . ( $page > 0 ? '&page=' . $page : '' ));

                // получаем страницу поиска
                while (false === ($r = curl_exec($__ch)));
                
                // сохраняем в кэш
                @file_put_contents($cache_file, $r);
        }

        return YAM_parser($r);
}

/**
 * Функция обработки результатов полученных с Я.М
 * 
 * @param string $r Контент страницы
 * @author NeZeD <nezed.ru>
 * @return array 
 */
function YAM_parser($r) {
        $results = array();
        // разбиваем на результаты
        $res = preg_split("/\<\/div\>\<div\ class\=\"b\-track\s+js\-track\s+js\-track/i", $r);

        // обрабатываем каждый результат  (первый и последний результат не треки)
        for ($i = 1, $l = sizeof($res); $i < $l; $i++) {
                // получаем только значение свойства onclick в котором вся информация о треке
                if (preg_match("/\<span\ class\=\"b\-track\_\_version\"\>[^\<]+/i", $res[$i], $m)) {
                        $v = strip_tags(preg_replace("/\<span\ class\=\"b\-track\_\_version\"\>/i", '', $m[0]));
                }
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
                        ), $res[$i]
                );

                $t = json_decode($res[$i], true);
                if (!$t) {
                        // если не получилось разобрать то в лог
                        //file_put_contents('YAM_parse_error.log', $res[$i] . PHP_EOL . PHP_EOL, FILE_APPEND);
                } else {
                        if (!empty($v))
                                $t['version'] = $v;
                        $t = a_trim($t);
                        if ( !is_array($t[0]) && !in_array($t, $results) && !value_in_array($results, $t['title'])) {
                                $results[] = $t;
                        }
                }
        }
        return $results;
}

/**
 * Функция получения ссылки на .mp3 с Я.М
 * 
 * @global object $__ch Объект открытого curl
 * @param srting $sd Storage-dir трека на Я.М
 * @param string $id ID трека на Я.М
 * @author NeZeD <nezed.ru>
 * @return string 
 */
function YAM_getUrl($sd, $id) {
        global $__ch;

        // получаем страницу в filename трека
        curl_setopt($__ch, CURLOPT_URL, 'http://storage.music.yandex.ru/get/' . $sd . '/2.xml');
        while (false === ($r = curl_exec($__ch)));
        $filename = preg_replace("/.*?filename\=\"([^\'\"]+).+$/si", "$1", $r);
        // получаем страницу с информацией для загрузки
        curl_setopt($__ch, CURLOPT_URL, 'http://storage.music.yandex.ru/download-info/' . $sd . '/' . $filename);
        while (false === ($r = curl_exec($__ch)));

        // убираем мусор из xml ответа и приводим к формату json
        if (strpos($r, 'regional-host') !== false)
                $r = preg_replace("/^.*?\<\/regional\-host\>/i", '', $r);
        else
                $r = preg_replace("/^.*?\<download\-info\>/i", '', $r);
        $r = preg_replace(array("/\<\/download-info\>.*$/i", "/\<([\w\-]+)[^\>]*\>/i", "/\<\/.*?\>/i"), array('', "\"$1\": \"", "\", \r\n"), $r);
        $r = json_decode('{' . substr(trim($r), 0, -1) . '}', true);

        if ($r !== null) {
                // генерация волшебной ссылки со всеми плюшками
                return "http://" . $r['host'] . "/get-mp3/" . md5('XGRlBW9FXlekgbPrRHuSiA' . substr($r['path'], 1) . $r['s']) . "/" . $r['ts'] . $r['path'] . "?track-id=" . $id . '&from=service-search';
        }
        return;
}
?>