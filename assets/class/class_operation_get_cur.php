<?php

class operation_get 
{

	function __constructor()
	{
	
		
		
	}
	
	public function url_absolute()
    {
		
        $scriptFolder = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://';
        $scriptFolder .= $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
        return $scriptFolder;
		
    }
    public function url_confirm($code = NULL)
    {
		
        if($code)
		{
			
            $url = ($this -> operations_get_url_absolute())."/confirmreg.php?code=".$code;
            return $url;
			
        }
		else
		{
			
            return false;
			
        }
		
    }
	
}

?>