<?php
function operations_email_user_registration($email = NULL, $subject = NULL, $mssg = NULL){
	/*
	if(isset($name) && isset($email) && isset($username) && isset($password) && isset($hash) && isset($GLOBALS['settingsData']["system"]["email"]["noreply"]) && isset($GLOBALS['settingsData']["admin"]["email"])&& isset($GLOBALS['settingsData']["system"]["phone"])){
		
		$noreply = $GLOBALS['settingsData']["system"]["email"]["noreply"];
		$phone	 = $GLOBALS['settingsData']["system"]["phone"];
		$admin_email = $GLOBALS['settingsData']["admin"]["email"];
		
		$to      = $email; // Send email to our user
		$subject = 'ATP-Bio Register | Verification'; // Give the email a subject 
		$message = '

		Thanks,'.$name.' for Registering with ATP-Bio!
		Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.

		------------------------
		Username: '.$username.'
		Password: '.$password.'
		------------------------

		Please click this link to activate your account:
		http://www.atp-bio-.com/verify.php?code='.$hash.'
		
		If you have questions or need assistance please contact your administrator at '.$phone.' or '.$admin_email.'
		'; // Our message above including the link

		$headers = 'From:'.$noreply. "\r\n"; // Set from headers
		mail($to, $subject, $message, $headers); // Send our email
	}
	*/
	if(
		isset($email) && isset($subject) && isset($mssg) &&
		isset($GLOBALS['settingsData']["system"]["email"]["header"]["mime"]) && 
		isset($GLOBALS['settingsData']["system"]["email"]["header"]["type"]) && 
		isset($GLOBALS['settingsData']["system"]["email"]["header"]["charset"]) && 
		isset($GLOBALS['settingsData']["system"]["email"]["from"]) && 
		isset($GLOBALS['settingsData']["admin"]["email"]) && 
		isset($GLOBALS['settingsData']["system"]["phone"])
	){
		
		$mime	 = $GLOBALS['settingsData']["system"]["email"]["header"]["mime"];
		$type	 = $GLOBALS['settingsData']["system"]["email"]["header"]["type"];
		$char	 = $GLOBALS['settingsData']["system"]["email"]["header"]["charset"];
		$from	 = $GLOBALS['settingsData']["system"]["email"]["from"];
		
		/* EMAIL */
		$to 	 = $email;
		$subject = $subject;
		$from 	 = $from;

		// To send HTML mail, the Content-type header must be set
		$headers  =  $mime. "\r\n";
		$headers .= 'Content-type: '.$type.'; charset='.$char. "\r\n";

		// Create email headers
		$headers .= 'From: '.$from."\r\n".
			'Reply-To: '.$from."\r\n" .
			'X-Mailer: PHP/' . phpversion();

		// Compose a simple HTML email message
		$message = '<html><body>';
		$message .= $mssg;
		$message .= '</body></html>';

		// Sending email
		if(mail($to, $subject, $message, $headers))
		{
			echo 'Your mail has been sent successfully.';
		}else{
			echo 'Unable to send email. Please try again.';
		}
	}
}
?>