<?
require 'vkapi.class.php';
 
$api_id = '3740778'; // Insert here id of your application
$vk_id = '54451705'; // Insert here you vk id
 
$VK = new vkapi($api_id, $vk_id);
 
$resp = $VK->api('audio.search', 
   array(
         'q'=>'The Beatles',
				 'auto_complete'=>'1',
				 'sort'=>'2',
				 'count'=>'25',
				 'offset'=>'0'
				)
				);
echo '<pre>'; 
print_r($resp);
echo '</pre>';  
?>
