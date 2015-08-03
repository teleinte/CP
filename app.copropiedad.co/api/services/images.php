<?php
$browser = $_SERVER['HTTP_USER_AGENT'];
if(isset($_GET['user']))
{
	$url = "https://app.copropiedad.co/api/estados/preregistro/mail/";
	$fields = json_encode(array("user"=>$_GET['user'], "browser" => $browser));
	//var_dump($fields);
	//open connection
	$ch = curl_init();
	//set the url, number of POST vars, POST data
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$resultadito = curl_exec($ch);
	//close connection
	curl_close($ch);
	$final = json_decode($resultadito,true);
	//var_dump($resultadito);
	//$result = "1";
}
/*// Create a blank image and add some text
$im = imagecreatetruecolor(1, 1);
//$yellow = imagecolorallocatealpha($im, 0, 0, 0, 75);
$text_color = imagecolorallocate($im, 233, 14, 91);
//$text_color = imagecolorallocatealpha($im, 255, 255, 255,100);
//imagestring($im, 1, 5, 5,  'A Simple Text String', $text_color);
// Set the content type header - in this case image/jpeg
header('Content-Type: image/jpeg');
// Output the image
imagejpeg($im);
// Free up memory
imagedestroy($im);*/
$im = @imagecreatetruecolor(100, 25);
# important part one
imagesavealpha($im, true);
imagealphablending($im, false);
# important part two
$white = imagecolorallocatealpha($im, 255, 255, 255, 127);
imagefill($im, 0, 0, $white);
# do whatever you want with transparent image
//$lime = imagecolorallocate($im, 204, 255, 51);
//imagettftext($im, $font, 0, 0, $font - 3, $lime, "captcha.ttf", $string);
header("Content-type: image/png");
imagepng($im);
imagedestroy($im);
?>