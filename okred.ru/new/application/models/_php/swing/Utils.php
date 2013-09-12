<?php
	class Utils
	{
		/*
		    $var_name - название переменной в parameters
		*/
		public static function limitNum($num, $min = null, $max = null)
		{
			return (($max == null) || ($num <= $max)) && (($min == null) || ($num >= $min));
		}
		
		/*
		    $var_name - название переменной в parameters
		*/
		public static function limitLength($str, $min = null, $max = null)
		{
			$length = strlen($str);
			return (($max == null) || ($length <= $max)) && (($min == null) || ($length >= $min));
		}
		
		public static function randomString($length = 8){
			$chars = 'abcdefgjlhiknrstyz0123456789';
			$numChars = strlen($chars);
			$string = '';
			for ($i = 0; $i < $length; $i++) {
				$string .= substr($chars, rand(1, $numChars) - 1, 1);
			}
			return $string;
		}
		
		/*
		   “ранслитерирует и убирает некоторые лишние символы, преобразу€ в url формат
		   
		   Ќедоработанно.
		*/
		public static function toURL($str) 
		{
			$translit_map = array(
			'а'=>'a', 'б'=>'b', 'в'=>'v', 'г'=>'g', 
			'д'=>'d', 'е'=>'e', 'ж'=>'zh', 'з'=>'z', 
			'и'=>'i', 'й'=>'j', 'к'=>'k', 'л'=>'l', 
			'м'=>'m', 'н'=>'n', 'о'=>'o', 'п'=>'p', 
			'р'=>'r', 'с'=>'s', 'т'=>'t', 'у'=>'u', 
			'ф'=>'f', 'х'=>'h', 'ц'=>'c', 'ч'=>'ch', 
			'ш'=>'sh', 'щ'=>'sch', 'ы'=>'y', 'э'=>'e', 
			'ю'=>'ju', '€'=>'ja', ' '=>'-', 'Є'=>'e', 
			'ъ'=>'', 'ь'=>''
			);
			return strtr(strtolower($str), $translit_map);
		}
		
		public static function fetchBlocks($sql, $name='')
		{
			$keys = array();
			for ($i = 0; $i < mysql_num_rows($sql); $i++)
			{
				$fetch = mysql_fetch_assoc($sql);
				$keys[$i] = array();
				foreach($fetch as $index => $value)
				{
					$keys[$i][$index] = (is_numeric($value))?((int)$value):$value;
				}
			}
			return ($name=='')?$keys:array($name=>$keys);
		}
	}								