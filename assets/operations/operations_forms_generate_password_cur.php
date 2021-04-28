<?php
function operation_form_generate_password() 
{
	if(isset($GLOBALS['settingsData']["application"]['security']['key']) && isset($GLOBALS['settingsData']["application"]['security']['pwdlng']))
	{
	
		$kylk = $GLOBALS['settingsData']["application"]['security']['key'];
		$scrm = intval($GLOBALS['settingsData']["application"]['security']['pwdlng']); 
		$comb = array();
		$kylg = strlen($kylk) - 1;
		for ($i = 0; $i < $scrm; $i++) {
			$n = rand(0, $kylg);
			$comb[] = $kylk[$n];
		}
		$pswd = implode($comb);
		$pswd = operation_form_value_sanitize($pswd);
		return $pswd;
		
	}
	else
	{
		return false;
	}
}
?>