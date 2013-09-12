<?php
	if(!isset($swimport))
	{
		$swimport = array('Config', 'Errors', 'File', 'Request', 'Response', 'SMysql', 'Utils', 'Encoding');
	}
	
	for($i = 0; $i < count($swimport); $i++)
	{
		include($swimport[$i].'.php');
	}
	
	unset($swimport);
?>