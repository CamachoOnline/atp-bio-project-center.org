<?php
class attributes{
	
	public $data;
	public $element;
	
	function __constructor($data, $element)
	{
	
		$this -> data = $data;
		$this -> element = $element;
		
	}
	
	public function classes($Data = NULL, $Name = NULL)
	{
		
		$Length = count($Data);
	
		if($Data && $Length > 0)
		{
		
			$cData = $GLOBALS["settingsData"]["application"];
			$vClasses = $cData["void"]["classes"];
			$cPrefix = new value();

			$classPrefix = $cPrefix -> get($cData, "classpre");

			$jsPrefix = $cPrefix -> get($cData, "jspre");
			
			$myClasses = "";

			for($i = 0; $i < $Length; $i++)
			{

				$Class = $Data[$i];
				if($Class)
				{
					if($classPrefix && !in_array($Class,$vClasses))
					{
					
						$myClasses .= $classPrefix.$Class; 
					
					}
					else
					{
					
						$myClasses .= $Class;
					
					}

					if($jsPrefix && !in_array($Class,$vClasses))
					{
					
						$myClasses .= " ";
						$myClasses .= $jsPrefix.$Class;
					
					}

				}
				else
				{
					
					if($i === 0)
					{
						
						$myClasses .= $classPrefix;
						$myClasses .= " ";
						$myClasses .= $jsPrefix;
					
					}

				}
				if($i < ($Length-1))
				{
				
					$myClasses .= " ";
				
				}
			}

			return $myClasses;

		}
	
	}
	
	public function dbvalue($name = NULL)
	{
		
		if($name)
		{
			
			$aDBAccess = new access_db();
			$attrValue = $aDBAccess -> getData($name);
			
			if($attrValue)
			{
				return $attrValue; 	
			}
			else
			{
				return NULL;
			}
			 
			
		}
		
	}
	
	public function get()
	{
		
		$Data = $this -> data;
		$Element = $this -> element;
		$Type = NULL;

		if($Data)
		{

			$length		= count($Data);
			$Attributes = NULL;
			$value		= NULL;
			$dbValue 	= NULL;
			
			/* Loop thru all the attributes passed */
			for($i = 0; $i < $length; $i++)
			{ 
			
				$data = $Data[$i];
				
				$Name = array_key_exists ("name",$data) ? $data["name"] : NULL;
				$Value = array_key_exists ("value",$data) ? $data["value"] : NULL;
				
				/* if the attribute is 'name' is the value of the attribute found in userData */
				if($Name === "type")
				{
					
					$Type = $Value;
					
				}
				
				if($Name === "name" && isset($Value) && ($Element == "input" && $Type == "text"))
				{
					
					$dbValue	= $this -> dbvalue($Value);
					
				}
				
				/* if not at the end of loop add a space */
				if($i != $length)
				{

						$Attributes .= ' ';

				}
				
				/* Set the attribute name */
				$Attributes .= $Name;
				
				/* Is the attribute in the void list set in settings data */
				if(!in_array($Name,$GLOBALS["settingsData"]["application"]["void"]["attributes"],true))
				{
				
					/* Add ' =" ' */
					$Attributes .= '="';

					/* If the attribute name is 'class' */
					if($Name == "class")
					{
						
						/* Grab element definition data */
						$elementsDefData = isset($GLOBALS["elementDefData"]) ? $GLOBALS["elementDefData"] : NULL;
						
						/*  */
						$elementData = isset($elementsDefData) && array_key_exists ($Element,$elementsDefData) ? $elementsDefData[$Element] : NULL;
						
						/*  */
						$elementAttr = $elementData ? $elementData["attributes"] : NULL;
						$elementClasses = $elementAttr ? $elementAttr[0]["value"] : NULL;
						

						$classData = $Value;

						$Classes = NULL;

						if($elementClasses && $Element != "body" && $Element != "header" && $Element != "main" && $Element != "footer")
						{
							
							$Array = new arrays();
							$Array -> arrays = [$elementClasses,$classData];
							$Combined = $Array->combine();
							$Classes = $Combined;
							

						}
						else if($elementClasses)
						{
							
							$Classes = $elementClasses;
						
						}
						else
						{
						
							$Classes = $classData;
						
						}

						if($Classes)
						{
						
							$Attributes .= $this->classes($Classes);
						
						}

					}
					else
					{

						$myValue = NULL;

						// Id
						if($Name == "id")
						{

							if($Element=="section")
							{
								
								$myValue = $Element."_".$GLOBALS["compInc"];
							
							}
							else if($Element=="article")
							{
							
								$myValue = $Element."_".$GLOBALS["compInc"]."_".$GLOBALS["artInc"];
							
							}
							else
							{

								$myValue = $Value;
							
							}
							
						}
						else
						{
							
							$myValue = $Value;
						
						}

						$Attributes .= $myValue;

					}

					$Attributes .= '"'; 
				}

			}
			
			/* If value is set from database add the value attribute */
			if(isset($dbValue))
			{
				$Attributes .= ' value="'.$dbValue.'"';
			}
			 
			
			return $Attributes;
			
		}
	
	}
	
}
?>