<?php
class email 
{
	
	public $data;
	public $name;
	
	public $settings;
	public $email;
	
	public $subject;
	public $message;
	
	public function __constructor($data = NULL, $name = NULL)
	{
	
		$this -> data = $data;
		$this -> name = $name;
		
	}
	
	public function getsettings()
	{	
		$this -> settings = $GLOBALS["settingsData"];
		$this -> email = $GLOBALS["emailData"];
	}
	
	public function replaceText ($sname = NULL, $sfields = NULL, $rtext = NULL)
	{
		$fields = $sfields;
		$settings = $GLOBALS["settingsData"];
		$email = $GLOBALS["emailData"];
		$name = $sname;
		
		$text = $rtext;
		if(strpos($text, "--ORG--") !== false)
        {
            $text = str_replace("--ORG--",$settings["organization"]["name"]["short"],$text);
        }
        if(strpos($text, "--APP--") !== false)
        {
            $text = str_replace("--APP--",$settings["application"]["name"]["long"],$text);
        }
        if(strpos($text, "--NAME--") !== false)
        {
            $text = str_replace("--NAME--",$fields["firstname"],$text);
        }
        if(strpos($text, "--USERNAME--") !== false)
        {
            $text = str_replace("--USERNAME--",$fields["username"],$text);
        }
        if(strpos($text, "--PASSWORD--") !== false)
        {
            $text = str_replace("--PASSWORD--",$fields["userpassword"],$text);
        }
        if(strpos($text, "--CONFIRM--") !== false)
        {
            $text = str_replace("--CONFIRM--",$fields["confirm"],$text);
        }
        if(strpos($text, "--ADPHONE--") !== false)
        {
            $text = str_replace("--ADPHONE--",$settings["administrator"]["contact"]["phone"]["mobile"],$text);
        }
        if(strpos($text, "--ADEMAIL--") !== false)
        {
            $text = str_replace("--ADEMAIL--",$settings["administrator"]["contact"]["email"],$text);
        }
		
		return $text;
		
	}
	
	public function message ($sname = NULL, $sfields = NULL)
	{
		
		$fields = $sfields;
		$settings = $GLOBALS["settingsData"];
		$email = $GLOBALS["emailData"];
		$name = $sname;

		/*
		if(isset($name) && isset($email) && isset($settings))
		{
		*/
			$mymssg = "";
			
			$logo = isset($email["logo"]) ? $email["logo"] : NULL;
			if(isset($logo))
			{
				
				$file	= isset($logo["file"]) ? $logo["file"] : NULL;
				$alt 	= isset($logo["alt"]) ? $logo["alt"] : NULL;
				
				if($file && $alt)
				{
					$mymssg .= '<img alt="'.$alt.'" src="'.$file.'"/>';		
				}
				
			}
			
			$mssgdata = isset($email[$name]["message"]) ? $email[$name]["message"] : NULL;
			if(isset($mssgdata))
			{	
				$mssgLength = count($mssgdata);
				$mssgStyles = isset($email["styles"]) ? $email["styles"] : NULL; 
				
				for($i = 0; $i < $mssgLength; $i++){
				
					$tmssg = $mssgdata[$i];
					
					foreach($tmssg as $key => $val)
					{

						$cstyle = $mssgStyles[$key];

						$mymssg .= '<'.$key;

							if($cstyle)
							{

								$mymssg .= ' style="'.$cstyle.'"';

							}

						$mymssg .= '>';
						
						/*
						$text = $val;
						if(str_contains($text, "--ORG--"))
						{
							$text = str_replace("--ORG--",$settings["organization"]["name"]["short"],$text);
						}
						if(str_contains($text, "--APP--"))
						{
							$text = str_replace("--APP--",$settings["application"]["name"]["short"],$text);
						}
						if(str_contains($text, "--NAME--"))
						{
							$text = str_replace("--NAME--",$fields["firstname"],$text);
						}
						if(str_contains($text, "--USERNAME--"))
						{
							$text = str_replace("--USERNAME--",$fields["username"],$text);
						}
						if(str_contains($text, "--PASSWORD--"))
						{
							$text = str_replace("--PASSWORD--",$fields["userpassword"],$text);
						}
						if(str_contains($text, "--CONFIRM--"))
						{
							$text = str_replace("--CONFIRM--",$fields["confirm"],$text);
						}
						if(str_contains($text, "--ADPHONE--"))
						{
							$text = str_replace("--ADPHONE--",$settings["administrator"]["contact"]["phone"]["mobile"],$text);
						}
						if(str_contains($text, "--ADEMAIL--"))
						{
							$text = str_replace("--ADEMAIL--",$settings["administrator"]["contact"]["email"],$text);
						}
						*/
						
						$mymssg .= $this -> replaceText($name, $fields, $val);

						$mymssg .= '</'.$key.'>';

					}
				}
				
				return $mymssg;
				
			}
			else
			{
				
				return false;
				
			}
		/*
		}
		*/
	}
	
	public function send ($sname = NULL, $sfields = NULL)
	{
		
		$this -> getsettings();
		
		$fields = $sfields;
		$settings = $GLOBALS["settingsData"];
		$email = $GLOBALS["emailData"];
		$name = $sname;
		
		/*
		if($fields && $email && $name)
		{
		*/

			$header = isset($email["header"]) ? $email["header"] : NULL;
			$from = isset($email["from"]) ? $email["from"] : NULL;
			$to = isset($fields["useremail"]) ? $fields["useremail"] : NULL;
			$subject = isset($email[$name]["subject"]) ? $this -> replaceText($name, $fields, $email[$name]["subject"]) : NULL;
			
			/*
			if($header && $from && $to && $subject)
			{
			*/	
				$mime = isset($header["mime"]) ? $header["mime"] : NULL;
				$type = isset($header["type"]) ? $header["type"] : NULL;
				$char = isset($header["charset"]) ? $header["charset"] : NULL;
				
				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
				// Create email headers
				$headers .= 'From: '.$from."\r\n".
					'Reply-To: '.$from."\r\n" .
					'X-Mailer: PHP/' . phpversion();
				
				// Compose a simple HTML email message
				$mymssg = '<html><body>';
				$mymssg .= $this -> message($sname, $sfields);
				// $mymssg .= $this -> message();
				$mymssg .= '</body></html>';

				// Sending email
				if(mail($to, $subject, $mymssg, $headers))
				{
					return 'email-success';
				}else{
					return 'email-fail';
				}
			/*	
			}
			*/
		/*	
		}
		*/
	}
	
}
?>