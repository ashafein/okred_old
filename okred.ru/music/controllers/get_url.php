<?php

include_once 'api.php';

if( !empty($_REQUEST['sd']) && !empty($_REQUEST['id']) ) {
	echo YAM_getUrl($_REQUEST['sd'], $_REQUEST['id']);
}