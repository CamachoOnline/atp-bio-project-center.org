<?php
class access_db {

	public $tables;
	public $columns;
	public $values;
	public $user;
	public $db;
	
	function __constructor($tables = NULL, $columns = NULL, $values = NULL, $user = NULL)
	{
	
		$this -> tables = $tables;
		$this -> columns = $columns;
		$this -> values = $values;
		$this -> user = $user;
		
	}
	
	public function insertData ($tables = NULL, $columns = NULL, $values = NULL)
	{
		
		$DB = $this -> getDB();
		
		if($DB && $tables && $columns && $values)
		{
			
			$tLength 	= count($tables);
			$cLength 	= count($columns);
			$vLength 	= count($values);

			$tString 	= "";
			$nString 	= "";
			$vLength 	= "";

			$status		= NULL;
			
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
				print_r($query);
				$DB->query($query);
					
			}
			
			return $status;

		}
		
	}
	
	public function getDB ()
	{
		
		$this -> db = $GLOBALS['DB'];
		$DB = $this -> db;
		
		if ( $DB -> connect_errno)
		{
			
			return "reg_server". $DB -> connect_error;
			exit();
			
        }
		else
		{
			
			return $DB;
			
		}
		
		

	}
	
	public function getColumnData( $name = NULL )
	{
		
		
        $DB = $this -> getDB();

        $dbdata = explode("_",$name);
        $table = $dbdata[0];
        $column = $name;

        $query = "SELECT ".$name." FROM ".$table."_tbl WHERE usr_id='".$_SESSION["LOGGEDIN"]."' LIMIT 1";

        if($result = $DB ->query($query))
        {
            $cinfo = $result -> fetch_array();

            if($cinfo){

                $dbVALUE = new value();
                $value = $dbVALUE -> value_delegate($cinfo[$name],$name,"decrypt");

                return $value;

            }


        }
		
		
	}
	
	public function getData ($table = NULL, $select = NULL, $column = NULL, $value = NULL  )
	{
		
		$DB = $this -> getDB();
		
		if($DB && $table && $select && $column && $value)
		{
			
			//"SELECT * FROM usr_tbl WHERE usr_eml='$emailcheck' LIMIT 1";
			$user = "SELECT ".$select." FROM ".$table."_tbl WHERE ".$column."='".$value."' AND usr_act='1' LIMIT 1";
			$result = mysqli_query($DB, $user);
			$userData = mysqli_fetch_assoc($result);
			
			return $userData;
			
		}
		
	}
	
	public function getTblData($table = NULL, $column = NULL, $id = NULL)
	{
		
		$DB = $this -> getDB();
		
		if($DB)
		{
			
			$query = "SELECT * FROM " . $table . " WHERE " . $column . " = '" . $id . "'";
			$result = mysqli_query($DB, $query);
			$resultData = mysqli_fetch_assoc($result);
			return $resultData;
		
		}
		
	}
	
	public function getProData($ids = NULL)
	{
		
		if($ids)
		{
			$array = explode(",",$ids)||false;
			
			if($array)
			{
				$dataArray = [];
				$length = count($array);
				for($i = 0; $i < $length; $i++){
					
					$dataArray[$i] = $this -> getTblData("pro_tbl","pro_id",$array[$i]);
					
				}
				
				return $dataArray;
				
			}
			else
			{
				
				return $this -> getTblData("pro_tbl","pro_id",$ids);
				
			}
			
			
		}
		
	}
	
	public function getDemData($who = NULL)
	{
		
		if($who)
		{
			
			return $this -> getTblData("dem_tbl","usr_id",$who);
			
		}
		
	}
	
	public function getIntData($who = NULL)
	{
		
		if($who)
		{
			
			return $this -> getTblData("int_tbl","int_id",$who);
			
		}
		
	}
	
	public function getUsrData($who = NULL)
	{
		
		if($who)
		{

			return $this -> getTblData("usr_tbl","usr_id",$who);

		}
		
	}

	
}
?>