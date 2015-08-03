<?php
if(isset($_POST['captcha'])){
	if (rpHash($_POST['captcha']) == $_POST['captchaHash'])
		echo "true";
	else
		echo "false";
}

function rpHash($value) { 
    $hash = 5381; 
    $value = strtoupper($value);
    $acum = 0;
    for($i = 0; $i < strlen($value); $i++) { 
        $acum = $acum + ord(substr($value, $i)); 
    } 
    $hash = $acum * $hash;
    return $hash; 
} 
?>