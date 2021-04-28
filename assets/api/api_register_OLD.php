<?php

$rootDir = __DIR__;
$file = __FILE__;

/* VARIABLES & ARRAYS */
$settingsData = "";

$tables =[];/* declare tables array */
$names =[];/* declare names array */
$values = [];/* declare values array */

$username = null;/* declare username variable */
$useremail = null;/* declare useremail variable */
$userpassword = null;/* declare userpassword variable */
$confirm = null;

$field = false;/* declare field variable */
$fName = null;/* declare first name variable will be used to construct username */
$lName = null;/* declare last name variable will be used to construct username */

/* INCLUDES */
include "../class/CLASS_core_cur.php";
//include "../app/app_data_cur.php";
include "../db/DB_core_cur.php";
include "../operations/OPERATIONS_core_cur.php";

/* PROCESS incoming form POST */
if($_POST && isset($GLOBALS['DB']))
{
	$pos = 0;
	$int = 0;
	/* process each key and value found in POST */
    foreach($_POST as $key => $val)
    {
        if($key && $val){/* there is a key and value */
			
            $ckey = explode("_", $key);

            $table = $ckey[0]."_tbl";
            $field = $ckey[1];
            $value = null;


            if(!in_array($table, $tables))
            {
                $tables[$pos] = $table;
            }

            $pos = count($tables);
			

            $names[$pos][$int] = $key;

            if($val)
            {
                $value = $val;

                switch($field){
                    case "fnm" :
                        $fName = ucfirst(strtolower($value));
                        $value = $fName;
                    break;
                    case "lnm" :
                        $lName = ucfirst(strtolower($value));
                        $value = $lName;
                        
                    break;
                    case "eml" :
                        $useremail = $value;
                        $value = operation_form_value_hash($value);
                    break;
                    default :
                        $values[$pos][$int] = $value;
                    break;
                }

            }
			if(isset($fName) && isset($lName))
            {
                $username = operation_form_generate_username($fName,$lName);
                $names[$pos][$int+1] = "usr_usn";
                $values[$pos][$int+1] = $username;

            }
            if($username)
            {
                $userpassword = operation_form_generate_password();
                $names[$pos][$int+1] = "usr_psw";
                $values[$pos][$int+1] = operation_form_value_hash($userpassword);
            }
			if(isset($useremail))
            {
                $emailhash = operation_form_value_hash($useremail);
                $names[$pos][$int+1] = "usr_hsh";
                $values[$pos][$int+1] = $emailhash;
                $confirm = operations_get_url_confirm(urlencode($emailhash));
            }
			$int++;
        }

    }
	//echo $confirm;

	$qry_usercheck = "SELECT * FROM usr_tbl WHERE usr_eml='$useremail' LIMIT 1";
	//echo $qry_usercheck;
	$result = mysqli_query($GLOBALS['DB'], $qry_usercheck);
	$user = mysqli_fetch_assoc($result);
	

	if ($user) 
	{ // if user exists
		if(password_verify($useremail, $user['usr_eml']))
		{
			echo "2";
		}
	}else{

		$tLength = count($tables);
		$nLength = count($names);
		$vLength = count($values);
		
		$tString = "";
		$nString = "";
		$vLength = "";
			
        $added = NULL;

        for($i = 0; $i < $tLength; $i++){

            $cName = implode(", ",$names[$i]);
            $cValue = implode(", ", $values[$i]);

            $query = "INSERT INTO ".$tables[$i]." (".$cName.") VALUES(".$cValue.")";
            echo $query;

            if(!mysql_query($query, $GLOBALS['DB']))
            {
                $added = false;
                echo "failure-reg";

            }else{
                $added = true;
                echo "success-reg";
            }

        }

        if($added){
            /* PREPARE EMAIL */
            $regemail = new email();
            $regemail -> data = array('firstname'=>$fname,'useremail'=>$useremail,'username'=>$username,'password'=>$password,'confirm'=>$confirm);

            $status = $regemail -> send();

            if($status)
            {
                echo "success-confirm";
            }else{
                echo "failure-confirm";
            }


        }
	}
}
/*
if($row){

    $active = $row['active'];
    $count = mysqli_num_rows($result);

    // If result matched $myusername and $mypassword, table row must be 1 row

    if($count == 1) {
        $_SESSION['user_id'] = $result['usr_id'];
        $_SESSION['usr_usn'] = $myusername;
        echo "cuccess";
    }else {
        echo "nouser";
    }
}else{
    echo "nouser";
}
*/
?>