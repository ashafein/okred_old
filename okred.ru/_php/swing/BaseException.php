<?php
class BaseException extends Exception
{
    public function __construct($code = 0, $message = '')
    {
        $this->code = $code;
        $this->message = $message;
    }
    
    public function output()
    {
        header('Content-type: text/plain;charset='. Gy::app()->config['charset']);
        
        echo DEBUG_MODE ? implode(': ', array_filter(array($this->code, $this->message))) : DEFAULT_ERROR_MESSAGE;
        
        exit;
    }
    
    public function message()
    {
        return $this->message;
    }
    
    public function code()
    {
        return $this->code;
    }
}