<?php
class Gy
{
    static $classAutoloadDirs;
    
    static $app = null;
    
    public static function app($config = array())
    {
        if(is_null(self::$app))
        {
            if(isset($config['debugMode']))
                define('DEBUG_MODE', $config['debugMode']);
            else
                define('DEBUG_MODE', false);
            
            if(isset($config['classAutoloadDirs']))
                self::$classAutoloadDirs = array_map(
                    function($v){ return str_replace('.', DS, $v); },
                    $config['classAutoloadDirs']
                );
            else
                self::$classAutoloadDirs = array();
            
            if(isset($config['developerMode']['state']))
                define('DEVELOPER_MODE', $config['developerMode']['state']);
            else
                define('DEVELOPER_MODE', false);
            
            if(DEVELOPER_MODE && (!isset($config['developerMode']['ipFilters']) || !is_array($config['developerMode']['ipFilters'])))
                exit('Не определен список ip - адресов.');
            
            self::init();
            
            self::$app = new App($config);
            self::$app->run();
        }
        
        return self::$app;
    }
    
    public static function init()
    {
        error_reporting(DEBUG_MODE ? E_ALL : 0);
        
        spl_autoload_register('Gy::classLoader');
    }
    
    public static function classLoader($className)
    {
        $classFileName = $className .'.php';
        
        foreach(self::$classAutoloadDirs as $dir)
        {
            $classFileFullName = BASEDIR . DS . $dir . DS . $classFileName;
            
            if(file_exists($classFileFullName))
            {
                include_once $classFileFullName;
                return;
            }
        }
        
        if(DEBUG_MODE)
            exit('File "'. $classFileName .'" not found.');
        else
            exit(DEFAULT_ERROR_MESSAGE);
    }
}