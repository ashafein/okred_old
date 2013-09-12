<?php
class BaseController
{
    public $id;
    public $defaultAction = 'index';
    public $action;
    
    public function __construct($config = array())
    {
        $this->id = $config['id'];
        $this->action = 'action'. ucfirst(strtolower(!empty($config['action']) ? $config['action'] : $this->defaultAction));
        
        if(!method_exists($this, $this->action))
            throw new HttpException(404, 'Page not found.');
    }
    
    public function run($params = array())
    {
        return call_user_func_array(
            array(
                $this,
                $this->action,
            ),
            $params
        );
    }
    
    public function renderPartial($templateName, $params = array(), $output = true)
    {
		$dirname = dirname($templateName);
		
		if($dirname == '.')
            $templateName = Gy::app()->config['templatesPath'] . DS . $this->id . DS . $templateName .'.php';
        
        if(file_exists($templateName))
        {
            ob_start();
            
            extract($params);
            
            include $templateName;
            
            if($output)
                ob_end_flush();
            else
            {
                $o = ob_get_contents();
                ob_end_clean();
                return $o;
            }
        }
        else
            throw new CException('File "'. $templateName .'" not found.');
    }
    
    public function render($templateName, $params = array(), $output = true)
    {
        header('Content-type: text/html;charset='. Gy::app()->config['charset']);
        $layoutName = implode(DS, array(
            Gy::app()->config['templatesPath'],
            Gy::app()->config['mainTemplate'],
        ));
        
        if(file_exists($layoutName))
        {
            ob_start();
            
            include BASEDIR .DS .'_php'. DS .'beaver.php';
            
            $content = $this->renderPartial($templateName, $params, false);
            
            include $layoutName;
            
            if($output)
                ob_end_flush();
            else
            {
                $o = ob_get_contents();
                ob_end_clean();
                return $o;
            }
        }
        else
            throw new CException('File "'. $layoutName .'" not found.');
    }
}