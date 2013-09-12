<?php

/*
 * TODO tag to test: own, singer, technical
 */
$query_type = '';

include_once('config.php');

function removeTrash($str) {
        if (!is_string($str))//ахах, такие исключения ты прорабатываешь, а на существование проверку не всегда делаешь :D :D :D
                return $str; //да клал я на эти нотисы))) а тут фатальную ошибку выдавать может
        return preg_replace(array("/Read\ more.+$/si", "/User\-contributed\ text.+$/si", "/(\s+\w+[\.\!\?\;])\s*(\w+)/sui"), array("", "", "$1<br/>$2"), strip_tags($str));
}

function transl($st) {
        setlocale(LC_ALL, 'ru_RU');
        if (preg_match('/[^A-Za-z0-9_\-.]/', $st)) {
                $tr = array(
                    "А" => "A", "Б" => "B", "В" => "V", "Г" => "G",
                    "Д" => "D", "Е" => "E", "Ж" => "J", "З" => "Z", "И" => "I",
                    "Й" => "Y", "К" => "K", "Л" => "L", "М" => "M", "Н" => "N",
                    "О" => "O", "П" => "P", "Р" => "R", "С" => "S", "Т" => "T",
                    "У" => "U", "Ф" => "F", "Х" => "H", "Ц" => "TS", "Ч" => "CH",
                    "Ш" => "SH", "Щ" => "SCH", "Ъ" => "", "Ы" => "YI", "Ь" => "",
                    "Э" => "E", "Ю" => "YU", "Я" => "YA", "а" => "a", "б" => "b",
                    "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ж" => "j",
                    "з" => "z", "и" => "i", "й" => "y", "к" => "k", "л" => "l",
                    "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
                    "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h",
                    "ц" => "ts", "ч" => "ch", "ш" => "sh", "щ" => "sch", "ъ" => "y",
                    "ы" => "yi", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya"
                );
                $st = strtr($st, $tr);
                $st = preg_replace('/[^\sA-Za-z0-9_\-.]/', '', $st);
        }
        return $st;
}

//$_REQUEST['text'] = isset($_REQUEST['text'])?strtr(strtolower($_REQUEST['text']), $genres_replace_map):$_REQUEST['text'];
$_REQUEST['text'] = preg_replace(array("/^[^\wА-Яа-яЁё]+/ui", "/[^\wА-Яа-яЁё]+$/ui"), '', $_REQUEST['text']) . '';
$_REQUEST['artist'] = preg_replace(array("/^[^\wА-Яа-яЁё]+/ui", "/[^\wА-Яа-яЁё]+$/ui"), '', $_REQUEST['artist']) . '';
$_REQUEST['track'] = preg_replace(array("/^[^\wА-Яа-яЁё]+/ui", "/[^\wА-Яа-яЁё]+$/ui"), '', $_REQUEST['track']) . '';
$page = empty($_REQUEST['page']) ? 0 : $_REQUEST['page'];


if (empty($_REQUEST['artist']) && empty($_REQUEST['track'])) {
        if (empty($_REQUEST['text'])) {
                $query_type = 'nothing';
        } else {

                //$_REQUEST['text'] = isset($genres_replace_map[$_REQUEST['text']]) ? $genres_replace_map[$_REQUEST['text']] : $_REQUEST['text'];

                $pos = strripos($_REQUEST['text'], '–');
                $pos = ($pos !== false && ( strripos($_REQUEST['text'], '-') === false || $pos > strripos($_REQUEST['text'], '-') ) ) ? $pos : strripos($_REQUEST['text'], '-');
                $pos = ($pos !== false && ( strripos($_REQUEST['text'], '—') === false || $pos > strripos($_REQUEST['text'], '—') ) ) ? $pos : strripos($_REQUEST['text'], '—');

                if ($pos !== false && $pos < (strlen($_REQUEST['text']) - 3)) {
                        $artist = substr($_REQUEST['text'], 0, $pos);
                        $track = substr($_REQUEST['text'], $pos, strlen($_REQUEST['text']));
                        $track = $track;
                } else {
                        $artist = null;
                        $track = $_REQUEST['text'];
                }
                $tag = transl(strtr($_REQUEST['text'], $genres_replace_map));
        }
} else {
        $artist = $_REQUEST['artist'];
        $track = $_REQUEST['track'];
        if (!empty($track)) {
                $query_type = "track";
        } else {
                $query_type = 'artist';
        }
}
if ($artist !== null)
        $artist = preg_replace(array("/^[^\wА-Яа-яЁё]*/ui", "/[^\wА-Яа-яЁё]+$/ui", "/[^\wА-Яа-яЁё]+/i"), array('', '', ' '), $artist);
if (!empty($track) && $track != $_REQUEST['text']) {
        $track = preg_replace(array("/^[^\wА-Яа-яЁё]*/ui", "/[^\wА-Яа-яЁё]*$/ui"), '', $track);
}
//var_dump($track);

$tag_info = LFMapi('tag.getInfo', array('tag' => $tag, 'lang' => 'ru'));
$artist_info = LFMapi('artist.getInfo', array('artist' => (empty($artist) ? $_REQUEST['text'] : $artist), 'lang' => 'ru', 'autocorrect' => 1));


if (
        ( empty($artist) || $artist == $_REQUEST['text'] ) &&
        isset($artist_info['artist']) &&
        ($artist_info['artist']['stats']['listeners'] > $tag_info['tag']['taggings']) &&
        !(isset($artist_info['error']) && $artist_info['error'] == 6 ) &&
        $artist_info['artist']['name'] != '[unknown]'
)
        $query_type = 'artist';
// если нет ошибки №6(ошибочный тег), если есть текст и текст длинной > 5 символов
if (empty($query_type) && !(isset($tag_info['error']) && $tag_info['error'] == 6 ) && isset($tag_info['tag']['wiki']['content']) && strlen($tag_info['tag']['wiki']['content']) > 5) {
        $query_type = 'tag';
        $_REQUEST['text'] = $tag;
        /*
         * TODO записать стиль в кукис
         */
}

if ($query_type == 'artist') {
        if (!(isset($artist_info['error']) && $artist_info['error'] == 6 ) && $artist_info['artist']['stats']['listeners'] > 1000 && $artist_info['artist']['name'] != '[unknown]') {
                $query_type = 'artist';
        }
}
$tracks = array();

if (empty($_REQUEST['only_info'])) {
        if ($query_type == 'artist') {
                $tracks = LFMapi('artist.getTopTracks', array('artist' => (empty($artist) ? $_REQUEST['text'] : $artist), 'autocorrect' => 1, 'limit' => MUSIC_LIMIT_CELLS_SEARCH, 'page' => $page));
                $tracks = $tracks['toptracks']["track"];
        } else if ($query_type == 'tag') {
                $tracks = LFMapi('tag.getTopTracks', array('tag' => $_REQUEST['text'], 'limit' => MUSIC_LIMIT_CELLS_SEARCH, 'page' => $page));
                $tracks = $tracks['toptracks']["track"];
        }

        $s_tracks = LFMapi('track.search', array('track' => $track, 'artist' => $artist, 'limit' => MUSIC_LIMIT_CELLS_SEARCH, 'page' => $page));


        // если номер страницй не вышел за пределы результатов
        if (!($page * $s_tracks['results']['opensearch:itemsPerPage'] < $s_tracks['results']['opensearch:totalResults'])) {
                $endOfPages = true;
        } else {
                $endOfPages = false;

                // то объеденить массивы (если массив улчших треков исполнителя и массив из поиска существуют)
                if (!is_array($tracks)) {
                        $tracks = $s_tracks['results']["trackmatches"]["track"];
                } else if (isset($s_tracks['results']["trackmatches"]) && is_array($s_tracks['results']["trackmatches"]["track"])) {
                        $tracks = array_merge($tracks, $s_tracks['results']["trackmatches"]["track"]);
                }

                // да и отсортировать, по нубски и сердито
                for ($i = 0, $l = sizeof($tracks); $i < $l; $i++)
                        for ($j = $i + 1; $j < $l; $j++) {
                                if (!isset($tracks[$i]['playcount']))
                                        $tracks[$i]['playcount'] = 0;
                                if (!isset($tracks[$j]['playcount']))
                                        $tracks[$j]['playcount'] = 0;
                                if ($tracks[$i]['playcount'] < $tracks[$j]['playcount']) {
                                        $b = $tracks[$i]['playcount'];
                                        $tracks[$i]['playcount'] = $tracks[$j]['playcount'];
                                        $tracks[$j]['playcount'] = $b;
                                }
                        }
        }
}

if (empty($query_type) || $query_type == 'track') {
        if (!empty($artist) && !empty($track)) {
                $track_info = LFMapi('track.getInfo', array('artist' => $artist, 'track' => $track, 'autocorrect' => 1));
        }
        if (!empty($tracks[0]['image'][3])) {
                $img = $tracks[0]['image'][3]['#text'];
        } else if (!empty($track_info['track']['album']['image'][3]['#text'])) {
                $img = $track_info['track']['album']['image'][3]['#text'];
        } else {
                $img = $artist_info['artist']['image'][4]['#text'];
        }
        //echo '<div class="search-tip clearit" style="width: 300px; padding: 5px;"><img src="' . $img . '" alt />' . print_r($track_info['track']['toptags'], true) . '</div>';
        $wiki = removeTrash($track_info['track']['wiki']['content']);
}

if ((is_string($tracks) || sizeof($tracks) == 0) && empty($_REQUEST['only_info'])) {
        $query_type = 'nothingFound';
}
?>