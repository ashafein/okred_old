<?php

include_once 'api.php';
//	include_once 'music_facts.php';

$style = '';
$style = !empty($_COOKIE['style']) ? $_COOKIE['style'] : $style;
$style = !empty($_REQUEST['style']) ? $_REQUEST['style'] : $style;
if ($style == 'all' || empty($style)) {
        unset($style);
} else {
        $style = str_replace(array('\'', '`', '"'), '', $style);
}

if (isset($style)) {
//        $top_tracks = LFMapi('tag.getTopTracks', array('tag' => $style, 'limit' => MUSIC_LIMIT_CELLS_MAIN_TRACKS));
//        $top_tracks = $top_tracks['toptracks'];
        $top_artists = LFMapi('tag.getTopArtists', array('tag' => $style, 'limit' => MUSIC_LIMIT_CELLS_MAIN_ARTISTS));
        $top_artists = $top_artists['topartists'];

        $top_tracks = array();

        if (!preg_match("/\-s$/i", $style)) {

                for ($i = 0, $l = ceil(30); $i < $l; $i++) {
                        $t = YAM_getTopTracks($i, $style);
                        if (is_array($t)) {
                                $top_tracks = array_merge($top_tracks, $t);
                        }
                }
        } else {

                for ($i = 0, $l = ceil(10); $i < $l; $i++) {
                        $t = YAM($style, $i);
                        if (is_array($t)) {
                                $top_tracks = array_merge($top_tracks, $t);
                        }
                }
        }

        //$top_tracks = array_merge(YAM_getTopTracks(0, $style), YAM_getTopTracks(1, $style), YAM_getTopTracks(2, $style));
} else {
        /*
         * Поскольку ласт не является хранителем mp3 то похоже нахер он вообще сдался...
         * Для главной держи метод получения популярных треков
         * YAM_getTopTracks($page, $genre);  // возврат такой-же как в поиске у функции YAM()
         * список жанров у яндекса скудный так что лучше спизди с music.yandex.ru (там они на главной все есть)
         */

//        $top_tracks = LFMapi('chart.getTopTracks', array('limit' => MUSIC_LIMIT_CELLS_MAIN_TRACKS));
//        $top_tracks = $top_tracks['tracks'];
        $top_artists = LFMapi('chart.getTopArtists', array('limit' => MUSIC_LIMIT_CELLS_MAIN_ARTISTS));
        $top_artists = $top_artists['artists'];
        $top_tracks = array();
        for ($i = 0, $l = ceil(10); $i < $l; $i++) {
                $t = YAM_getTopTracks($i);
                if (is_array($t)) {
                        $top_tracks = array_merge($top_tracks, $t);
                }
        }
}
$top_tracks = array_slice($top_tracks, 0, 250);
?>