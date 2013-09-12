<?php
class App
{
    public $config;
    
    public function __construct($config)
    {
        $this->config = $config;
    }
    
    public function run()
    {
        try
        {
            if(DEVELOPER_MODE && !in_array($_SERVER['REMOTE_ADDR'], $this->config['developerMode']['ipFilters']))
                $controllerName = 'developermode';
            else
                $controllerName = 'search';
            
            $controllerName = strtolower($controllerName);
            
            $action = 'index';
            
            $controllerClassName = ucfirst($controllerName) .'Controller';
            $this->controller = new $controllerClassName(array('id'=>$controllerName, 'action'=>$action));
            $this->controller->run();
        }
        catch(CException $e)
        {
            $e->output();
        }
        catch(HttpException $e)
        {
            $e->output();
        }
    }
    
    public function end()
    {
        exit;
    }
}