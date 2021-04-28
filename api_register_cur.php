<?php
//echo "Register";
/*
$rootDir = __DIR__;
$file = __FILE__;
*/

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

$field = false;/* declare field variable */
$fName = null;/* declare first name variable will be used to construct username */
$lName = null;/* declare last name variable will be used to construct username */

/* INCLUDES */
include "assets/class/CLASS_core_cur.php";
include "assets/app/app_data_cur.php";
include "assets/db/DB_core_cur.php";
include "assets/operations/OPERATIONS_core_cur.php";

/* CLASSES */
$ngenerate = new generate();
$nvalue = new value();
$regemail = new email();
$DB = $GLOBALS['DB'];
$DBaccess = new access_db();
$mailed = false;
$success = [];
$userid = null;

/* PROCESS incoming form POST */
if($_POST)
{
	
	/* process each key and value found in POST */
	$POSTLength 	= count($_POST);
	$pos 			= 0;
	$inc 			= 0;
	
	$fName 			= NULL;
	$useremail 		= NULL;
	$username 		= NULL;
	$userpassword	= NULL;
	$confirm		= NULL;
	$encryptedemail = NULL;
	$up				= false;
	
    foreach($_POST as $key => $value)
    {
		
		$cKey		= explode("_",$key);
		$tableId	= $cKey[0];
		$table		= $tableId."_tbl";
		$field		= $cKey[1];

		if(!in_array($table, $tables))
		{
			array_push($tables, $table);
			array_push($success, "false");
			$inc = 0;
		}

		$pos = count($tables)-1;

		$columns[$pos][$inc] = $key;
		if($tableId == "usr")
		{
		
			switch($field)
			{
					
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
					$value = $nvalue -> encrypt($useremail);
					$encryptedemail = $value;
				break;
					
			}
			
		}

		$values[$pos][$inc] = $value;
		
		if($tableId == "usr" && !$up && $fName && $lName)
		{
			
            $inc++;
            $username = $ngenerate -> username($fName,$lName);
            $columns[$pos][$inc] = "usr_usn";
            $values[$pos][$inc] = $username;

            $inc++;
            $userpassword = $ngenerate -> password();
            $columns[$pos][$inc] = "usr_psw";
            $values[$pos][$inc] = $nvalue -> hash($userpassword);
			
			$inc++;
            $token = $ngenerate -> token();
            $columns[$pos][$inc] = "usr_tkn";
            $values[$pos][$inc] = $token;
            $confirm = $ngenerate -> confirm($token);

			$up = true;
			
			$inc++;
				
		}
		else 
		{
			
			$inc++;
			
		}
		
    }
		
    if($DB && $DBaccess && $tables && $columns && $values)
    {
		
		$hashedemail = $DBaccess -> getData("usr","*","usr_eml",$encryptedemail);
		
		$deemail = $nvalue -> decrypt($hashedemail);

        if ($useremail == $deemail) 
        {

            return "exists";

        }
        else
        {

			$tLength 	= count($tables);
			$cLength 	= count($columns);
			$vLength 	= count($values);

			$tString 	= "";
			$nString 	= "";
			$vLength 	= "";
			
			for($i = 0; $i < $tLength; $i++)
			{

				$cColumns = implode(",",$columns[$i]);
				$cValues = "";

				$cvLength = count($values[$i]);
				for($j = 0; $j < $cvLength; $j++)
				{

					$cValues.= "'".$values[$i][$j]."'";
					if($j<$cvLength-1)
					{
						$cValues.=",";
					}

				}
				
				$query = "INSERT INTO ".$tables[$i]." (".$cColumns.") VALUES(".$cValues.")";
				
				
				if($DB -> query($query))
				{
					
					$fields = array("firstname"=>$fName, "useremail"=>$useremail, "username"=>$username, "userpassword"=>$userpassword, "confirm"=>$confirm);
					$regemail -> send("register", $fields);
					echo "reg_success|";	
						
				}
				else
				{

					echo "reg_fail|".$DB->error;

				}

			}

		}

	}
	
}

?>