<?php
	class Request
	{
		public $method;
		public $parameters;
		
		/*
		    Делает переменные чистыми
		*/
		public function tidyVars($vars) 
		{
			foreach($vars as &$var)
			{
				$var = str_replace(array("'", ';', '\x1a', '\x00'), array('&#39;', '&#059;', '', ''), $var);
				$var = htmlentities($var);
				$var = trim($var);
			}
			return $vars;
		}
		
		/*
			Проверяет существование переменных/-ной
		*/
		public function isExist($names)
		{
	        if(is_array($names))
			{
				for($i = 0; $i < count($names); $i++)
				{
					if(!isset($this->parameters[$names[$i]])) return false;
				}
			}
			else
			{
			    return isset($this->parameters[$names]);
			}
			return true;
		}
		
		/* 
		    Проверяет ли, попадет ли числовая переменная в params в лимиты ее значения, если null -- значение игнорируется
			
			$var_name - название переменной в parameters
		*/
		public function limitNum($var_name, $min = null, $max = null)
		{
			if($this -> isExist($var_name))
			{
				$this -> parameters[$var_name] = (int)$this -> parameters[$var_name];
				return Utils::limitNum($this -> parameters[$var_name], $min, $max); 
			}
			else
			{
				return false;
			}
		}
		
		/* 
		    Проверяет ли, попадет ли строковая переменная в params в лимиты ее длины, если null -- значение игнорируется
			
			$var_name - название переменной в parameters
		*/
		public function limitLength($var_name, $min = null, $max = null)
		{
		    if($this -> isExist($var_name))
			{
				return Utils::limitLength($this -> parameters[$var_name], $min, $max); 
			}
			else
			{
				return false;
			}
		}
		
		/**
		   Получает значение переменной, если оная существует или возвращает значение по умолчанию
		   
		   $var_name -- название переменной в parameters
		   $default -- значение, в случае если переменная не существует
		*/
		public function getVariable($var_name, $default = '')
		{
		    return ($this -> isExist($var_name))?$this -> parameters[$var_name]:$default;
		}
	}					