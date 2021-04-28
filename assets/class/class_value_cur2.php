<?php

class generate 
{
	
	public function generate_password() 
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
			$pswd = $this -> value_sanitize($pswd);
			
			return $pswd;

		}
		else
		{
			
			return false;
			
		}
		
	}
	
	public function generate_username($fname = NULL, $lname = NULL)
	{
		
		if($fname && $lname)
		{

			return $this -> value_sanitize(ucfirst($fname).ucfirst($lname));

		}
		
	}
	
	public function generate_token ()
	{
		return bin2hex(openssl_random_pseudo_bytes(16));
	}
	
	public function value_decrypt($value = NULL)
	{
		
		if($value)
		{
			
			$decoded = base64_decode($value);
			$nonce = mb_substr($decoded, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, '8bit');
			$ciphertext = mb_substr($decoded, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, null, '8bit');
			$plaintext = sodium_crypto_secretbox_open($ciphertext, $nonce, $key);
			
			return $plaintext;
			
		}
		else
		{
			
			return false;
			
		}
	}
	
	public function value_encrypt($value = NULL)
	{

		if($value)
		{

			$chain = random_bytes(SODIUM_CRYPTO_SECRETBOX_KEYBYTES);
			$scramble = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
			$cphr = sodium_crypto_secretbox($value, $scramble, $chain);
			$encoded = base64_encode($chain . $cphr);
			
			return($encoded);

		}else{

			return false;

		}

	}
	
	public function value_hash($value = NULL)
	{
		
		if($value)
		{
			
			$hVal = password_hash($value, PASSWORD_DEFAULT);
			
			return $hVal;
			
		}
		else
		{
			
			return false;
			
		}
	}
	
	public function value_sanitize($value = NULL,$remove_nl=true)
	{
		$str = $this -> value_strip($value);

		if($remove_nl)
		{
			
			$injections = array('/(\n+)/i',
				'/(\r+)/i',
				'/(\t+)/i',
				'/(%0A+)/i',
				'/(%0D+)/i',
				'/(%08+)/i',
				'/(%09+)/i'
				);
			$str = preg_replace($injections,'',$str);
			
		}

		return $str;
		
	}
	
	public function value_strip($value = NULL)
	{
		
		$str = stripslashes($value);
		
		return $str;
		
	}
	
	public function value_delegate ( $value = NULL, $name = NULL, $type = NULL )
	{
		
		if(str_contains ( $name , "eml" ) && $value)
		{
			
			if($type == "decrypt")
			{
				return $this -> value_decrypt($value);
			}
			
			if($type == "encrypt")
			{
				return $this -> value_encrypt($value);
			}
	
		}
		else
		{
			return $value;
		}
		
	}
	
	
}

?>