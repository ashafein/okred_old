<?php

$_REQUEST['singer'] = trim($_REQUEST['singer']);
$_REQUEST['song'] = trim($_REQUEST['song']);
if (!empty($_FILES['file']) && !empty($_REQUEST['singer']) && !empty($_REQUEST['song'])) {


        $ch = curl_init('http://pleer.com/upload/send');

        set_time_limit(120);

        $file = $_FILES['file']['tmp_name'];

        /*
         * TODO Включить это
         * тут все норм работает
        include_once '../../../../_php/db.php';
        $file_hash = md5_file($file);
        $this_file = $db->findSingle('music_files', array('hash', $file_hash), array('artist', 'track', 'file'));
        if (sizeof($this_file) > 0) {
                $mp3_file = $this_file[0]['file'];
        } else {
                $mp3_file = 'mp3/' . microtime(1) . '.mp3';
                copy($file, '../../../' . $mp3_file);
        }
        if( $this_file[0]['artist'] != $_REQUEST['singer'] && $this_file[0]['track'] != $_REQUEST['song'] ) {
                $db->insert('music_files', array('artist' => $_REQUEST['singer'], 'title' => $_REQUEST['song'], 'file' => $mp3_file, 'uploadtime' => time(), 'hash' => $file_hash));
        }
         */
        
//        $fp = fopen($file, 'r');
//        curl_setopt($ch, CURLOPT_UPLOAD, 1);
//        curl_setopt($ch, CURLOPT_INFILE, $fp);
//        curl_setopt($ch, CURLOPT_INFILESIZE, filesize($file));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "User-Agent" => "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.71 Safari/537.36",
            "Accept" => "application/json, text/javascript, */*",
            "Origin" => "http://pleer.com",
            'X-Requested-With' => 'XMLHttpRequest',
            "Accept-Language" => "ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4",
            "Accept-Encoding" => "gzip,deflate",
            "Content-Type" => "multipart/form-data",
            "Content-Length" => filesize($file)
        ));

        curl_setopt($ch, CURLOPT_REFERER, "http://pleer.com/"); //без палева :D
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('MAX_FILE_SIZE' => 20971520, 'file' => '@' . $file));

        while (false === ($r = curl_exec($ch)));
        $response = json_decode($r, true);
        if ($response == null) {
                if (!headers_sent())
                        header("HTTP/1.0 500 Internal Server Error");
                die('Internal Server Error.');
        } else if (!empty($response['file_id'])) {
                curl_setopt($ch, CURLOPT_URL, 'http://pleer.com/upload/correct_name');
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "User-Agent" => "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.71 Safari/537.36",
                    "Accept" => "application/json, text/javascript, */*",
                    "Origin" => "http://pleer.com",
                    'X-Requested-With' => 'XMLHttpRequest',
                    "Accept-Language" => "ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4",
                    "Accept-Encoding" => "gzip,deflate",
                    "Content-Type" => "multipart/form-data"
                ));
                curl_setopt($ch, CURLOPT_POSTFIELDS, array('file_id' => $response['file_id'], 'singer' => $_REQUEST['singer'], 'song' => $_REQUEST['song']));
                while (false === ($r = curl_exec($ch)));
        }
        echo '<h5>Файл успешно загружен и будет доступен<br/> после прохождения модерации!</h5><button onclick="document.location.href = \'' . $_SERVER['HTTP_REFERER'] . '\'">Загрузить еще?</button>';
        echo '<!-- ' . $response['file_id'];
        var_dump($response);
        echo ' -->';
} else {
        if (!headers_sent())
                header("HTTP/1.0 400 Bad Request");
        die('Bad request.');
}