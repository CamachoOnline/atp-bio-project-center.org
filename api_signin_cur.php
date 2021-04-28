<?php
	
	$rootDir = __DIR__;
	$file = __FILE__;

	/* VARIABLES & ARRAYS */
	$settingsData = "";
	$emailData = "";

	$tables =[];/* declare tables array */
	$columns =[];/* declare names array */
	$values = [];/* declare values array */

	$username = null;/* declare username variable */
	$useremail = null;/* declare useremail variable */
	$userpassword = null;/* declare userpassword variable */
	$confirm = null;

	/* INCLUDES */
	include "assets/class/CLASS_core_cur.php";
	include "assets/app/app_data_cur.php";
	include "assets/db/DB_core_cur.php";
	include "assets/operations/OPERATIONS_core_cur.php";

	/* CLASSES */
	$nvalue = new value();

	/* Is there post data and database has been defined */
	if($_POST['usr_usn'] && $_POST['usr_psw'] && isset($GLOBALS['DB']))
	{
		
		/* Get post data */
		$myusername = isset($_POST['usr_usn']) ? $_POST['usr_usn'] : false;
		$mypassword = isset($_POST['usr_psw']) ? $_POST['usr_psw'] : false;

		$usercheck = "SELECT * FROM usr_tbl WHERE usr_usn = '" . $myusername . "' AND usr_act = '1'";

		$result = mysqli_query($DB, $usercheck);
		$user = mysqli_fetch_assoc($result);
		$userid = $user['usr_id'];
		$password_hash = $user['usr_psw'];
		$active = $user['usr_act'];
		$match = $nvalue -> verifypass($_POST['usr_psw'], $password_hash);

		//echo "Id: ".$userid." | Pw: ".$password_hash.", Match: ".$match." | Active: ".$active;
		if($match){

			$_SESSION["LOGGEDIN"] = $userid;
			
			if($user["usr_eml"]){
				
				$nemail = new value();
				$demail = $nemail -> decrypt($user["usr_eml"]);
				$user["usr_eml"] = $demail;
				
			}
			
			$_SESSION["USERDATA"] = $user;
			
			
			
			echo "sgn_success|";

		}
		else if(!$match)
		{

			echo "sgn_password|";

		}
		else if(!$active)
		{
			
			echo "sgn_notactive|";
			
		}
		else if(!$user)
		{
			
			echo "sgn_nouser|";
			
		}
		
	}

?>