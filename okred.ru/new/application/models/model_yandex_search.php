<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_yandex_search extends CI_Model {

    const MAX_QUERY_LENGTH = 400;
    const MAX_QUERY_WORDS = 40;

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
    public function validate($query,$error=array())
    {
        
        if($query == '')
            $error = 'Пустой запрос.';
        
        if(strlen($query) > self::MAX_QUERY_LENGTH)
            $error = 'Запрос должен содеражть не более '. self::MAX_QUERY_LENGTH .' символов.';
        
        if(count(explode(' ', $query)) > self::MAX_QUERY_WORDS)
            $error = 'Запрос должен содеражть не более '. self::MAX_QUERY_WORDS .' слов.';
        
        if(empty($this->key))
            $error = 'Не указан ключ запроса.';
        
        if(empty($this->user))
            $error = 'Не указан пользователь.';
        
        if(empty($this->host))
            $error = 'Не указан адрес запроса.';
        
        return count($error) == 0;
    }

    public function request($query,$page) {
        $response = file_get_contents(
            'http://xmlsearch.yandex.com/xmlsearch?'
            .implode('&', array(
                'user=okred666',
                'key=03.220929676:082022c635db15ee106328c3ac4637ca',
                'page='. $page,
                'query='. urlencode($query),
                'l10n=ru',
            ))
        );
        echo $response;
        //$response = file_get_contents('./lesson.xml');
        
        $xml = @simplexml_load_string($response);
        
        if($xml == false)
            $error = 'Нет ответа от сервера.';
        
        return $xml;
    }
}
