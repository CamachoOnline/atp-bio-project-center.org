<?php
class generate 
{
	public function confirm ($code)
	{
		
		$absoluteURL = new value();
		$absolute = $absoluteURL -> absoluteUrl();
		
		if($code && $absolute)
		{
		
			$url = $absolute."confirmreg.php?code=".$code;
			return $url;
			
		}
		else
		{
		
			return false;
			
		}
		
	}
	
	public function password() 
	{
		
		if(isset($GLOBALS['settingsData']["application"]['security']['key']) && isset($GLOBALS['settingsData']["application"]['security']['pwdlng']))
		{
			
			$nvalue = new value();
			$kylk = $GLOBALS['settingsData']["application"]['security']['key'];
			$scrm = intval($GLOBALS['settingsData']["application"]['security']['pwdlng']); 
			$comb = array();
			$kylg = strlen($kylk) - 1;
			for ($i = 0; $i < $scrm; $i++) {
				$n = rand(0, $kylg);
				$comb[] = $kylk[$n];
			}
			$pswd = implode($comb);
			$pswd = $nvalue -> sanitize($pswd);
			
			return $pswd;

		}
		else
		{
			
			return false;
			
		}
		
	}
	
	public function username($fname = NULL, $lname = NULL)
	{
		
		$nvalue = new value();
		
		if($fname && $lname)
		{

			return $nvalue -> sanitize(ucfirst($fname).ucfirst($lname));

		}
		
	}
	
	public function token ()
	{
		return bin2hex(openssl_random_pseudo_bytes(16));
	}
		
}
?>