<?php
class YandexRequest
{
    const MAX_QUERY_LENGTH = 400;
    const MAX_QUERY_WORDS = 40;
    
    private
        $host,
        $user,
        $key,
        $query,
        $page;
    
    public $errors = array();
    
    public function __construct($query, $page = 0)
    {
        $this->query = trim($query);
        $this->page = abs((int)$page);
        $this->host = Gy::app()->config['yandexRequestParams']['host'];
        $this->user = Gy::app()->config['yandexRequestParams']['user'];
        $this->key = Gy::app()->config['yandexRequestParams']['key'];
    }
    
    public function validate()
    {
        
        if($this->query == '')
            $this->errors[] = 'Пустой запрос.';
        
        if(strlen($this->query) > self::MAX_QUERY_LENGTH)
            $this->errors[] = 'Запрос должен содеражть не более '. self::MAX_QUERY_LENGTH .' символов.';
        
        if(count(explode(' ', $this->query)) > self::MAX_QUERY_WORDS)
            $this->errors[] = 'Запрос должен содеражть не более '. self::MAX_QUERY_WORDS .' слов.';
        
        if(empty($this->key))
            $this->errors[] = 'Не указан ключ запроса.';
        
        if(empty($this->user))
            $this->errors[] = 'Не указан пользователь.';
        
        if(empty($this->host))
            $this->errors[] = 'Не указан адрес запроса.';
        
        return count($this->errors) == 0;
    }
    
    public function request()
    {
        $response = file_get_contents($this->createQueryString());
        //$response = file_get_contents('./lesson.xml');
        
        $xml = @simplexml_load_string($response);
        
        if($xml == false)
            $this->errors[] = 'Нет ответа от сервера.';
        
        return $xml;
    }
    
    public function createQueryString()
    {
        return $this->host .'?'
            .implode('&', array(
                'user='. $this->user,
                'key='. $this->key,
                'page='. $this->page,
                'query='. urlencode($this->query),
                'l10n=ru',
            ));
    }
}