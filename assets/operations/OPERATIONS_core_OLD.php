<?php
function oper_sanitize_sql($str){
	if( function_exists( "mysql_real_escape_string" ) )
    {
          $ret_str = mysql_real_escape_string( $str );
    }
    else
    {
          $ret_str = addslashes( $str );
    }
    return $ret_str;
}
function oper_email_user(){
	
	$c_user = isset($_SESSION['user']) ? $_SESSION['user'] : NULL;
    $c_name = isset($_SESSION['name']) ? $_SESSION['name'] : NULL;
    $c_email = isset($_SESSION['email']) ? $_SESSION['email'] : NULL;
	
	if($c_user && $c_name && $c_email){
		$to      = $email; // Send email to our user
		$subject = 'Signup | Verification'; // Give the email a subject 
		$message = '

		Thanks for signing up!
		Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.

		------------------------
		Username: '.$name.'
		Password: '.$password.'
		------------------------

		Please click this link to activate your account:
		http://www.yourwebsite.com/verify.php?email='.$email.'&hash='.$hash.'

		'; // Our message above including the link

		$headers = 'From:noreply@yourwebsite.com' . "\r\n"; // Set from headers
		mail($to, $subject, $message, $headers); // Send our email
	}
	
}
function oper_register_user(){
	
	$db = $GLOBALS['db'];
	
	$email = mysqli_real_escape_string($db, $_POST['usr_eml']);
	
	$user_check_query = "SELECT * FROM usr_tbl WHERE usr_eml='$email' LIMIT 1";
	$result = mysqli_query($db, $user_check_query);
	$user = mysqli_fetch_assoc($result);
	
	if ($user) { // if user exists
		
		if ($user['usr_eml'] === $email) {
			array_push($pageErrors,array("usr_eml"=>"Email already exists"));
		}
		
	}else{
		
		$username = NULL;
		$firstname = mysqli_real_escape_string($db, $_POST['usr_fnm']);
		$middleinitial = mysqli_real_escape_string($db, $_POST['usr_mdl']);
		$lastname = mysqli_real_escape_string($db, $_POST['usr_lnm']);
		$phone = mysqli_real_escape_string($db, $_POST['usr_phn']);
		$role = mysqli_real_escape_string($db, $_POST['usr_rle']);
		
		$username = ucfirst($firstname).ucfirst($lastname);
		$sec_verbage = randomPassword(16);

		$pep = $GLOBALS['pepp'];
		$svb_pepped = hash_hmac("sha256", $sec_verbage, $pep);
		$svb_hhd = password_hash($svb_pepped, PASSWORD_ARGON2ID);
		$hash = md5(rand(0,1000));
		$hash = mysqli_real_escape_string($db, $hash);

		$query = "INSERT INTO usr_tbl(usr_usn, usr_psw, usr_hash, usr_fnm, usr_mdl, usr_lnm, usr_eml, usr_phn, usr_rle) VALUES ('$username','$svb_hhd','$hash','$firstname','$middleinitial','$lastname','$email','$phone','$role')";
		mysqli_query($db, $query);
		$_SESSION['user'] = $username;
		$_SESSION['pword'] = $sec_verbage;
		$_SESSION['name'] = $firstname; 
		$_SESSION['email'] = $email;
		
		oper_email_user();

	}
}
function oper_signin_user(){
	
	$db = $GLOBALS['db'];
	
	$myusername = $_POST['usr_usn'];
	$mypassword = $_POST['usr_psw'];

	$sql = "SELECT * FROM usr_tbl WHERE usr_usn = '$myusername' and usr_psw = '$mypassword'";
	$result = mysqli_query($db,$sql);
	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	
	if($row){
		$active = $row['active'];

		$count = mysqli_num_rows($result);

		// If result matched $myusername and $mypassword, table row must be 1 row

		if($count == 1) {
			session_register("myusername");
			$_SESSION['usr_id'] = $result['id'];
			$_SESSION['usr_usn'] = $myusername;
			$_SESSION['login_user'] = $myusername;
			header("location: profile.php");
		}else {
			array_push($GLOBALS["pageError"], array('signin'=>$GLOBALS['pageError_signIn_userpass']));
			include $GLOBALS['rootDir']."/assets/build/app_page_cur.php";
		}
	}else{
		array_push($GLOBALS["pageError"], array('signin'=>$GLOBALS['pageError_signIn_nouser']));
		include $GLOBALS['rootDir']."/assets/build/app_page_cur.php";
	}
	
}
?>