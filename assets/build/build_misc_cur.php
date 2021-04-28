<?php
function generate_username($lngth){
	$user = bin2hex(random_bytes($lngth));
	return $user;
}
function generate_password($fn,$ln){
	$pass = NULL;
	$pass = substr($fn,0,1);
	$pass .= substr($ln,0,strlen($ln))."$";
	$pass .= str_replace('-', '', date("Y-m-d"));
	return $pass;
}
function randomPassword($length) {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $length; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
?>