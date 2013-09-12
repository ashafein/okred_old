<?
header("Content-type: image/png");
srand((double)microtime()*1000000);
$num = rand('000000','999999'); 
setcookie('reg_num', $num); 
$img = imagecreate('60','20'); 
$back = imagecolorallocate($img, 255, 255, 255); 
$black = imagecolorallocate($img, 0, 0, 0);
$green = imagecolorallocate($img, 0, 147, 0); 
$blue = imagecolorallocate($img, 0, 146, 255); 
$red = imagecolorallocate($img, 255, 0, 0); 
imageline($img, 59, 0, 8, 15, $green); 
imageline($img, 0, 19, 49, 10 , $black); 
imageline($img, 35, 19, 07, 0 , $red); 
imageline($img, 0, 0, 59, 0, $blue); 
imageline($img, 0, 0, 0, 19 , $blue); 
imageline($img, 0, 19, 59, 19 , $blue); 
imageline($img, 59, 0, 59, 19 , $blue); 
imagestring($img,5,4,3,$num,$black); 
imagepng($img);
?>