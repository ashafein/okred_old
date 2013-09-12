<?php	
	define('MYSQL_DEBUG', true);
	class SMysql {		
	    private $last;
		private $num_rows;
		
		public function __construct($host, $base, $user, $pass) 
		{
			$sql = @mysql_connect($host,$user,$pass);
			if(!$sql)
			{
				throw new Exception(Errors::MYSQL);
				return;
			}
			
            $select_result = @mysql_select_db($base);
            if(!$select_result) {
				throw new Exception(Errors::MYSQL);
				return;
			}
		}
		
		/**
			Осуществляет запрос $query и возвращает результат
			
			$query - запрос
			$is_fetched - превратить ли сразу распарсенный результат
			$is_fall - убивать ли скрипт при ошибке
		*/
		public function query($query, $is_fetched = false, $is_fall = true)
		{
			$this->last = mysql_query($query);
			$this->num_rows = ($this->last)?@mysql_num_rows($this->last):0;
			$this->num_rows = ($this->num_rows != null)?$this->num_rows:0;
			
			if (!$this->last && $is_fall)
			{
				if(MYSQL_DEBUG)
				{
					echo '<br><b>Произошла ошибка при запросе в mysql!</b><br><br>Запрос: '.$query.'<br><br>MySQL вовзращает ошибку: '.mysql_error().'<br><br>';
					die();
				}
				else
				{
				    throw new Exception(Errors::MYSQL);
					return;
				}
			}
			return ($is_fetched)?$this->lastFetchRows():$this->last;
		}
		
		/**
			Преврашает результат последнего запроса в массив с ключами, 
			если строка одна -- возвращается объект, без индексов массива
			
			$is_free - если true, то mysql ответ очищается
			$name - название блока, в который поместить результаты
		*/
		public function lastFetchRows($is_free = true, $name='')
		{
		    if(!$this->last)
			{
			    return array();
			}
			
			$keys = array();
			for ($i = 0; $i < $this->num_rows; $i++)
			{
				$keys[$i] = mysql_fetch_assoc($this->last);
				/*$keys[$i] = array();
					foreach($fetch as $index => $value)
					{
					$keys[$i][$index] = (is_numeric($value))?((int)$value):$value;
				}*/
			}
			$keys = ($this->num_rows == 1)?$keys[0]:$keys;
			
			($is_free)?$this->free():null;
			
			return ($name=='')?$keys:array($name=>$keys);
		}
		
		/**
			Возвращает последний запрос
		*/
		public function lastSql()
		{
			return $this->last;
		}
		
		/**
			Возвращает ID последнего вставленного объекта
		*/
		public function lastId()
		{
			return @mysql_insert_id();
		}
		
		/**
			Возвращает количество строк посленего запроса
		*/
		public function lastNumRows()
		{
			return $this->num_rows;
		}
		
		/**
			Очищает память
		*/
		public function free()
		{
			@mysql_free_result($this->last);
			
		}
		
		/**
			Закрывает соединение
		*/
		public function close()
		{
			@mysql_close();
		}
	}
?>	