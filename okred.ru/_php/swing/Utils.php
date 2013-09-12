<?php
	class Utils
	{
		/*
		    $var_name - �������� ���������� � parameters
		*/
		public static function limitNum($num, $min = null, $max = null)
		{
			return (($max == null) || ($num <= $max)) && (($min == null) || ($num >= $min));
		}
		
		/*
		    $var_name - �������� ���������� � parameters
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
		   ��������������� � ������� ��������� ������ �������, ���������� � url ������
		   
		   �������������.
		*/
		public static function toURL($str) 
		{
			$translit_map = array(
			'�'=>'a', '�'=>'b', '�'=>'v', '�'=>'g', 
			'�'=>'d', '�'=>'e', '�'=>'zh', '�'=>'z', 
			'�'=>'i', '�'=>'j', '�'=>'k', '�'=>'l', 
			'�'=>'m', '�'=>'n', '�'=>'o', '�'=>'p', 
			'�'=>'r', '�'=>'s', '�'=>'t', '�'=>'u', 
			'�'=>'f', '�'=>'h', '�'=>'c', '�'=>'ch', 
			'�'=>'sh', '�'=>'sch', '�'=>'y', '�'=>'e', 
			'�'=>'ju', '�'=>'ja', ' '=>'-', '�'=>'e', 
			'�'=>'', '�'=>''
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