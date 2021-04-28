<?php
class value {
	
	public function absoluteUrl()
	{
	
		$url = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://';
		$url .= $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
		return $url;
		
	}

	public function decrypt($value = NULL)
	{
		$appsec = $GLOBALS["settingsData"]["application"]["security"];
		if($value && $appsec)
		{

			$cphr = $appsec["siph"];
			$ivlngth = openssl_cipher_iv_length($cphr);
			$opts = 0;
			$deiv = $appsec["ivct"];
			$deky = $appsec["enky"];
			return openssl_decrypt($value, $cphr, $deky, $opts, $deiv);
			
		}
		else
		{
			
			return false;
			
		}
	}
	
	public function delegate ( $value = NULL, $name = NULL, $type = NULL )
	{
		
		if(str_contains ( $name , "eml" ) && $value)
		{
			
			if($type == "decrypt")
			{
				return $this -> decrypt($value);
			}
			
			if($type == "encrypt")
			{
				return $this -> encrypt($value);
			}
	
		}
		else
		{
			return $value;
		}
		
	}
	
	public function encrypt($value = NULL)
	{
		$appsec = $GLOBALS["settingsData"]["application"]["security"];
		if($value && $appsec)
		{

			$cphr = $appsec["siph"];
			$ivlngth = openssl_cipher_iv_length($cphr);
			$opts = 0;
			$eniv = $appsec["ivct"];
			$enky =  $appsec["enky"];
			return openssl_encrypt($value, $cphr, $enky, $opts, $eniv);

		}else{

			return false;

		}

	}
	
	public function hash($value = NULL)
	{
		
		if($value)
		{
			
			$hVal = password_hash($value, PASSWORD_ARGON2I);
			
			return $hVal;
			
		}
		else
		{
			
			return false;
			
		}
	}
	
	public function verifypass($subpass = NULL, $hashpass = NULL)
	{
		
		if($subpass && $hashpass)
		{
			
			return password_verify($subpass,$hashpass);
			
		}
		
	}
	
	public function get($data = NULL, $name = NULL)
	{
		
		if($data and $name)
		{
			
			$type = gettype($data);
			
			if($type === "object" or $type === "array")
			{
				
				if(array_key_exists($name,$data))
				{
					return $data[$name];
					
				}else{
					
					return false;
					
				}
				
			}
			
		}
		else if($data)
		{
		
			return $data;
			
		}
		else
		{
		
			return false;
			
		}
		
	}
	
	public function sanitize($value = NULL, $remove_nl = true)
	{
		$str = $this -> strip($value);

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
	
	public function strip($value = NULL)
	{
		
		$str = stripslashes($value);
		
		return $str;
		
	}

}
?>