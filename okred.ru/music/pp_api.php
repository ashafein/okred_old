<?php

$_pch = curl_init();
curl_setopt($_pch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($_pch, CURLOPT_TIMEOUT, 15);
curl_setopt($_pch, CURLOPT_CONNECTTIMEOUT, 5);
/**
 * Количество цифр в unix дате влияющих на время жизни кэша
 */
define('pp_cache_time_offset', -5); // 3 символа - 17 минут, 4 символа - 2ч. 46м., 5 символов - 27 часов

function PP($search = 'музычка', $page = 0) {
        global $_pch;

        // контроль времени запроса
        $cache_file.= $search . '&timedump=' . substr(time(), 0, pp_cache_time_offset) . '&page=' . (int) $page;
        // файл кеширования этого запроса
        $cache_file = 'cache/pp/' . md5($search) . '.nz';

        if (!file_exists($cache_file) || (null == ($r = file_get_contents($cache_file)) || (null == ($json = json_decode($r, true))) )) {
                
                clearCache('cache/pp/', pp_cache_time_offset);
                
                curl_setopt($_pch, CURLOPT_URL, 'http://pleer.com/mobile/search?q=' . rawurlencode($search));
                if ($page) {
                        curl_setopt($_pch, CURLOPT_HTTPHEADER, array('X-Requested-With' => 'XMLHttpRequest'));
                        curl_setopt($_pch, CURLOPT_REFERER, "http://pleer.com/mobile/"); //без палева :D
                        curl_setopt($_pch, CURLOPT_POST, 1);
                        curl_setopt($_pch, CURLOPT_POSTFIELDS, 'page=' . $page);
                }

                while (false === ($r = curl_exec($_pch)));
                $r = preg_replace(array("/.*?\<li\ class\=\"track\"\ id\=\"t([^\"]+).*?class\=\"artist\"\>([^\<]+).*?class\=\"title\"\>([^\<]+)/sui", "/\}\,\<.+$/sui"), array("{\"pid\": \"$1\", \"artist\": \"$2\", \"title\": \"$3\"},", '}'), $r);
                @file_put_contents($cache_file, '[' . $r . ']');
                $json = json_decode('[' . $r . ']', true);
        }

        if (is_array($json))
                return $json;
        else
                return array();
}