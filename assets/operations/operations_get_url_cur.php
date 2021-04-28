<?php
function operations_get_url_absolute()
{
    $url = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://';
    $url .= $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
    return $url;
}
function operations_get_url_confirm($code = NULL)
{
	if($code){
		$url = operations_get_url_absolute()."/confirmreg.php?code=".$code;
		return $url;
	}else{
		return false;
	}
}
?>