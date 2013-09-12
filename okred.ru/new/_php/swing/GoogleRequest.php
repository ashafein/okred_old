<?php
class GoogleRequest
{
    const MAX_QUERY_LENGTH = 400;
    const MAX_QUERY_WORDS = 40;
    const RSZ = 8;
    
    private
        $host,
        $key,
        $query,
        $page,
        $request;
    
    public $errors = array();
    
    public function __construct($query, $page = 0)
    {
        $this->query = trim($query);
        $this->page = abs((int)$page);
        $this->host = Gy::app()->config['googleRequestParams']['host'];
        $this->key  = Gy::app()->config['googleRequestParams']['key'];
        $this->start = $page * self::RSZ;
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
        
        if(empty($this->host))
            $this->errors[] = 'Не указан адрес запроса.';
        
        return count($this->errors) == 0;
    }
    
    public function request()
    {
        return json_decode(file_get_contents($this->createQueryString()));
    }
    
    public function createQueryString()
    {//http://ajax.googleapis.com/ajax/services/search/web?v=1.0&key=AIzaSyBRwETzaVS-EsPYjFbidXdJjmXJmLm1b2M&q=php&rsz=8&hl=ru
        return $this->host .'?'
            .implode('&', array(
                'v=1.0',
                'key='. $this->key,
                'q='. urlencode($this->query),
                'hl=ru',
                'rsz='. self::RSZ,
                'start='. $this->start,
                //'safe=active',
                'userip='. $_SERVER['REMOTE_ADDR'],
            ));
    }
}