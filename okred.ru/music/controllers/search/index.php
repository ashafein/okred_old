<?php

$query_type = '';

include_once('config.php');
include_once('pp_api.php');

function removeTrash($str) {
        if (!is_string($str))//ахах, такие исключения ты прорабатываешь, а на существование проверку не всегда делаешь :D :D :D
                return $str; //да клал я на эти нотисы))) а тут фатальную ошибку выдавать может
                
// регулярное выражение удаляет копирайты в конце и права растространения информации, так-же удаляются html теги
        return preg_replace(array("/Read\ more.+$/si", "/User\-contributed\ text.+$/si", "/(\s+\w+[\.\!\?\;])\s*(\w+)/sui"), array("", "", "$1<br/>$2"), strip_tags($str));
}

function translitString($st) {
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

// регулярные выражения удаляют небуквенные символы в начале и конце
//$_REQUEST['text'] = isset($_REQUEST['text'])?strtr(strtolower($_REQUEST['text']), $genres_replace_map):$_REQUEST['text'];
$_REQUEST['text'] = preg_replace(array("/^[^\wА-Яа-яЁё]+/ui", "/[^\wА-Яа-яЁё]+$/ui"), '', $_REQUEST['text']) . '';
$_REQUEST['artist'] = preg_replace(array("/^[^\wА-Яа-яЁё]+/ui", "/[^\wА-Яа-яЁё]+$/ui"), '', $_REQUEST['artist']) . '';
$_REQUEST['track'] = preg_replace(array("/^[^\wА-Яа-яЁё]+/ui", "/[^\wА-Яа-яЁё\)]+$/ui"), '', $_REQUEST['track']) . '';
$page = empty($_REQUEST['page']) ? 0 : $_REQUEST['page'];


// проверка на текстовый поиск а не запрос по треку и артисту
if (empty($_REQUEST['artist']) && empty($_REQUEST['track'])) {
        if (empty($_REQUEST['text'])) {
                // если все параметры пучты
                $query_type = 'nothing';
        } else if (!preg_match("/\-s$/i", $_REQUEST['text'])) {

                //$_REQUEST['text'] = isset($genres_replace_map[$_REQUEST['text']]) ? $genres_replace_map[$_REQUEST['text']] : $_REQUEST['text'];
                // разбиение запроса на исполгнителя и трек

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
                // ихем совпадения в таблице жанров, заменяем и транслителируем
                $tag = translitString(strtr($_REQUEST['text'], $genres_replace_map));
        }
} else {

        // если запрос по артисту и названию трека
        $artist = $_REQUEST['artist'];
        $track = $_REQUEST['track'];

        // если параметр трека пуст значит запрос по артисту
        if (!empty($track)) {
                $query_type = "track";
        } else {
                $query_type = 'artist';
        }
}

// удаление небуквенных символов в начале и конце
if ($artist !== null)
        $artist = preg_replace(array("/^[^\wА-Яа-яЁё]*/ui", "/[^\wА-Яа-яЁё]+$/ui", "/[^\wА-Яа-яЁё]+/ui"), array('', '', ' '), $artist);
if (!empty($track) && $track != $_REQUEST['text']) {
        $track = preg_replace(array("/^[^\wА-Яа-яЁё]*/ui", "/[^\wА-Яа-яЁё\)]*$/ui"), '', $track);
}
//var_dump($track);
// получение информации по стилю и по артисту
//$tag_info = LFMapi('tag.getInfo', array('tag' => $tag, 'lang' => 'ru'));
//$artist_info = LFMapi('artist.getInfo', array('artist' => (empty($artist) ? $_REQUEST['text'] : $artist), 'lang' => 'ru', 'autocorrect' => 1));
//
//// если текстовый запрос то проверить подходит ли он под запрос по артисту
//if (
//        // это текстовый запрос по артисту
//        ( empty($artist) || $artist == $_REQUEST['text'] ) &&
//        // результат получен
//        isset($artist_info['artist']) &&
//        // артист с этим именем популярней жанра с этим именем
//        ($artist_info['artist']['stats']['listeners'] > $tag_info['tag']['taggings']) &&
//        // нет ошибки "непривильное имя артиста"
//        !(isset($artist_info['error']) && $artist_info['error'] == 6 ) &&
//        // имя артиста установленно
//        $artist_info['artist']['name'] != '[unknown]'
//)
//        $query_type = 'artist';
//// если нет ошибки №6(ошибочный тег), если есть текст и текст длинной > 5 символов
//if (empty($query_type) && !(isset($tag_info['error']) && $tag_info['error'] == 6 ) && isset($tag_info['tag']['wiki']['content']) && strlen($tag_info['tag']['wiki']['content']) > 5) {
//        $query_type = 'tag';
//        $_REQUEST['text'] = $tag;
//}
/*
  if ($query_type == 'artist') {
  if (!(isset($artist_info['error']) && $artist_info['error'] == 6 ) && $artist_info['artist']['stats']['listeners'] > 1000 && $artist_info['artist']['name'] != '[unknown]') {
  $query_type = 'artist';
  }
  } */
$tracks = array();


/*
 * TODO Включить это
 * Это включение результатов в поиск из локальной базы данных
 * И разобраться с ебаным FULLTEXT который не работает в их таблице данных =(
if (!$page) {
        $t = null;
        if (!empty($track)) {
                $t = $db->query("SELECT * FROM  `music_files` WHERE title LIKE '%" . preg_replace("/\W+/ui", '%', $db->escape($track)) . "%' AND artist LIKE '%" . preg_replace("/\W+/ui", '%', $db->escape($artist)) . "%';");
        } else {
                $t = $db->query("SELECT * FROM  `music_files` WHERE title LIKE  '%" . preg_replace(array("/^\W*(.*?)\W*$/sui", "/\W+/ui"), array('$1', "%' OR title LIKE  '%"), ' '.trim($db->escape($_REQUEST['text']))) . "%';");
        }
        
        if (is_array($t) && sizeof($t) > 0)
                $tracks = array_merge($tracks, $t);
}
 */

//if (empty($_REQUEST['only_info']) && $query_type != 'nothing') {
/*
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
 */
$endOfPages = false;
if (!empty($_REQUEST['text'])) {
        //$tracks = YAM($_REQUEST['text'], $page);
        $t = PP($_REQUEST['text'], $page);
        if (is_array($t))
                $tracks = array_merge($tracks, $t);
        $t = YAM($_REQUEST['text'], $page);
        if (is_array($t))
                $tracks = array_merge($tracks, $t);
} else {
        $tracks = YAM((!empty($artist) ? $artist . ' - ' : '') . $track, $page);
}
if (sizeof($tracks) < 1)
        $endOfPages = true;
//} else {
//        if( empty($_REQUEST['data_sd']) || empty($_REQUEST['data_id']) ) {
//                if( !empty($_REQUEST['text']) ) {
//                        $tracks = YAM($_REQUEST['text'], 0);
//                } else {
//                        $tracks = YAM( (!empty($artist) ? $artist.' - ' : '').$track, 0);
//                }
//                if( sizeof($tracks) < 1 ) {
//                        if( !empty($_REQUEST['text']) ) {
//                                $t = preg_replace("/[\(\[][^\)\[]*[\)\]]/sui", '', $_REQUEST['text']);
//                                if( $_REQUEST['text'] != $t )
//                                        $tracks = YAM($t, 0);
//                        } else {
//                                $t = preg_replace("/[\(\[][^\)\[]*[\)\]]/sui", '', $track);
//                                if( $track != $t )
//                                        $tracks = YAM( (!empty($artist) ? $artist.' - ' : '').$t, 0);
//                        }
//                }
//                
//                if( sizeof($tracks) > 0 )
//                        $track_url = YAM_getUrl($tracks[0]['storage_dir'], $tracks[0]['id']);
//                else
//                        $track_url = '';
//        } else {
//                $track_url = YAM_getUrl($_REQUEST['data_sd'], $_REQUEST['data_id']);
//        }
//}
//if (empty($query_type) || $query_type == 'track') {
//        // если запрос по треку и переданы параметры track, artist или успешно разделен текстовый запрос
//        if (!empty($artist) && !empty($track)) {
//                $track_info = LFMapi('track.getInfo', array('artist' => $artist, 'track' => $track, 'autocorrect' => 1));
//        }
//        
//        // выбрать доступную картинку
//        if (!empty($tracks[0]['image'][3])) {
//                $img = $tracks[0]['image'][3]['#text'];
//        } else if (!empty($track_info['track']['album']['image'][3]['#text'])) {
//                $img = $track_info['track']['album']['image'][3]['#text'];
//        } else {
//                $img = $artist_info['artist']['image'][4]['#text'];
//        }
//        //echo '<div class="search-tip clearit" style="width: 300px; padding: 5px;"><img src="' . $img . '" alt />' . print_r($track_info['track']['toptags'], true) . '</div>';
//        $wiki = removeTrash($track_info['track']['wiki']['content']);
//}

if ((is_string($tracks) || sizeof($tracks) == 0) && empty($_REQUEST['only_info'])) {
        $query_type = 'nothingFound';
} else {
        $query_type = 'track';
}
?>