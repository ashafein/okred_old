<?php
	class Response
	{
		public static function formResponse($response)
		{
			return array(
            'response' => $response
			);
		}
		
		public static function formError($error)
		{
			return array(
            'error' => array(
			'error_msg' => $error,
            ),
			);
		}					
		
		public static function sendResult($result)
		{
			header('Content-Type: text/html; charset='.CODEPAGE);//выдаем заголовком кодировку
			die(json_encode($result));
		}
	}
?>