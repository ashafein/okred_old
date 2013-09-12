<?php
define('API_KEY', '5abdf40d67cae20e98cb7fc6933748d6');
define('API_SECRET_KEY', '70978a4093f90e405960a16bebfe8b8f');
define('CLIENT_ID', 'tst'); //Paste your clientID
define('CLIENT_VERSION', '1.0');

function charts(){
$params = array(
    'method'  => 'chart.gettoptracks', // API функция
    'api_key' => API_KEY, // ваш API key
);
 
$request = file_get_contents('http://ws.audioscrobbler.com/2.0/?' . http_build_query($params, '', '&'));
echo $xml = new SimpleXMLElement($request);
$charts = '';
 
foreach ($xml->tracks->track as $track)
{
    $charts .= '<li>';
    $charts .= '<a href="' . $track->artist->url . '">' . $track->artist->name .	 '</a> — ';
    $charts .= $track->name . ' (' . $track->playcount . ')';
    $charts .= '</li>' . "\n";
}
return $charts;
}

function xml2arr($xml, $recursive = false){
	if(!$recursive)
		$array = simplexml_load_string($xml);
	else $array = $xml ;
	$newArray    = array() ;
	$array         = (array)$array ;
	foreach($array as $key =>$value){
		$value    = (array)$value ;
		if(isset($value[0]))
			$newArray[$key] = trim($value[0]);
		else
			$newArray[$key] = xml2arr($value,true);
	}
	return $newArray ;
}

function loginLastFM($url, $type, $post = null){
	if($ch    = curl_init($url)){
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Vpleer.ru Scrobbler.');
		$type = $type == 'get'    ?    curl_setopt($ch, CURLOPT_POST, 0)    :    curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_setopt($ch, CURLOPT_REFERER, 'http://www.lastfm.ru/api/');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$content    = curl_exec($ch);
		curl_close($ch);
		return $content;
	}
	else{
		return 'notconnect';
	}
}

//1st step. Get token from $_GET['token']
function getKey($token, $API_KEY, $API_SECRET_KEY){
	$api_sig = md5('api_key'.$API_KEY.'methodauth.getSessiontoken'.$token.$API_SECRET_KEY);
	$get = 'method=auth.getSession&api_key='.$API_KEY.'&token='.$token.'&api_sig='.$api_sig;    
	$return = xml2arr(loginLastFM('http://ws.audioscrobbler.com/2.0/', 'get', $get));
	return $return;
}

//handShake. Рукопожатие. Вызывается каждый раз когда что-либо не сработало
    function handShake($user, $key, $time, $CLIENT_ID, $CLIENT_VERSION, $API_KEY, $API_SECRET_KEY)
    {
        $handtoken    = md5($API_SECRET_KEY.$time);    
        $handget    = 'hs=true&p=1.2.1&c='.$CLIENT_ID.'&v='.$CLIENT_VERSION.'&u='.$user.'&t='.$time.'&a='.$handtoken.'&api_key='.$API_KEY.'&sk='.$key;
        $handshake    = loginLastFM('http://post.audioscrobbler.com/', 'get', $handget);
        $handecho    = explode("\n", $handshake);
        return $handecho;
    }
	
	//Посылаем на last.fm все данные песни на момент начала проигрывания
    function nowPlaying($session, $artist, $song, $duration)
    {
        $playget    = 's='.$session.'&a='.$artist.'&t='.$song.'&b=&l='.$duration.'&n=&m=';
        $playnow    = loginLastFM('http://post.audioscrobbler.com:80/np_1.2', 'post', $playget);
        return $playnow;
    }
	
	//Посылаем на last.fm все данные песни на момент окончания проигрывания или спустя 50% проигрывания трека
    function submission($session, $artist, $song, $duration, $starttime)
    {
        $subget        = 's='.$session.'&a[0]='.$artist.'&t[0]='.$song.'&i[0]='.$starttime.'&o[0]=P&r[0]=&l[0]='.$duration.'&b[0]=&n[0]=&m[0]=';
        $submission    = loginLastFM('http://post2.audioscrobbler.com:80/protocol_1.2', 'post', $subget);
        return $submission;
    }
    
    function doShake($fmuser, $fmkey, $time, $CLIENT_ID, $CLIENT_VERSION, $API_KEY, $API_SECRET_KEY)
    {
        $handshake    = handShake($fmuser, $fmkey, $time, $CLIENT_ID, $CLIENT_VERSION, $API_KEY, $API_SECRET_KEY);
        $handerror    = trim($handshake[0]);
        $session    = trim($handshake[1]);
        if($handerror == 'OK' && isset($session))
        {
            setcookie('fmsess', $session, time() + 3600 * 24 * 730, '/', '.'.$_SERVER['HTTP_HOST']);
            return 'OK';
        }
        else
        {
            return 'Error : '.$handerror;
        }
    }
    
    $time        = time();

    //Если к нам пришли ппервый раз с last.fm, то ставим куки с необходимыми данными
    if(isset($_GET['token']))
    {
        $return        = getKey($_GET['token'], API_KEY, API_SECRET_KEY);
        $error        = isset($return['error'])            ?    $return['error']            :    null;
        $key        = isset($return['session']['key'])    ?    $return['session']['key']    :    null;
        $user        = isset($return['session']['name'])    ?    $return['session']['name']    :    null;
        if(!isset($error) && isset($key) && isset($user))
        {
            setcookie('fmkey', $key, time() + 3600 * 24 * 730, '/', '.'.$_SERVER['HTTP_HOST']);
            setcookie('fmuser', $user, time() + 3600 * 24 * 730, '/', '.'.$_SERVER['HTTP_HOST']);
            setcookie('scrobb', 'on', time() + 3600 * 24 * 730, '/', '.'.$_SERVER['HTTP_HOST']);
            $a    = doShake($user, $key, $time, CLIENT_ID, CLIENT_VERSION, API_KEY, API_SECRET_KEY);
            header('Location: /scrobb/');
        }
        else
        {
            echo $error;
        }
    }
    
    //1й раз? Надо пожать ручку
    if(isset($_COOKIE['fmkey'], $_COOKIE['fmuser']) && !isset($_COOKIE['fmsess']) && (isset($_POST['nowplaying']) || isset($_POST['submission'])))
    {
        $a    = doShake($_COOKIE['fmuser'], $_COOKIE['fmkey'], $time, CLIENT_ID, CLIENT_VERSION, API_KEY, API_SECRET_KEY);
        echo $a;
    }
    
    //Начали играть!
    if(isset($_POST['nowplaying'], $_COOKIE['fmkey'], $_COOKIE['fmuser'], $_COOKIE['fmsess']))
    {
        $artist        = isset($_POST['artist'])    ?    urldecode($_POST['artist'])    :    'Undefined';
        $song        = isset($_POST['song'])        ?    urldecode($_POST['song'])        :    'Undefined';
        $duration    = isset($_POST['duration'])    ?    urldecode($_POST['duration'])    :    'Undefined';
        setcookie('fmtime', $time, time() + 600, '/', '.'.$_SERVER['HTTP_HOST']);
        echo $playnow    = nowPlaying($_COOKIE['fmsess'], $artist, $song, $duration);
        if(!strstr($playnow, 'OK'))
        {
            echo doShake($_COOKIE['fmuser'], $_COOKIE['fmkey'], $time, CLIENT_ID, CLIENT_VERSION, API_KEY, API_SECRET_KEY);
            //$playnow    = nowPlaying($_COOKIE['fmsess'], $artist, $song, $duration);
        }
    }
    
    //Отправляем на last.fm
    if(isset($_POST['submission'], $_COOKIE['fmkey'], $_COOKIE['fmuser'], $_COOKIE['fmsess']))
    {
        $artist        = isset($_POST['artist'])    ?    urldecode($_POST['artist'])        :    'Undefined';
        $song        = isset($_POST['song'])        ?    urldecode($_POST['song'])        :    'Undefined';
        $duration    = isset($_POST['duration'])    ?    urldecode($_POST['duration'])    :    'Undefined';
        $starttime    = isset($_COOKIE['fmtime'])    ?    $_COOKIE['fmtime']    : time();
        echo $submiss    = submission($_COOKIE['fmsess'], $artist, $song, $duration, $starttime);
        if(!strstr($submiss, 'OK'))
        {
            echo doShake($_COOKIE['fmuser'], $_COOKIE['fmkey'], $time, CLIENT_ID, CLIENT_VERSION, API_KEY, API_SECRET_KEY);
            //$submiss    = submission($_COOKIE['fmsess'], $artist, $song, $duration, $starttime);
        }
    }
?>