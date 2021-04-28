<?php
function operation_form_value_encrypt($value = NULL)
{
	
    if($value)
	{
		
        $chain = random_bytes(SODIUM_CRYPTO_SECRETBOX_KEYBYTES);
        $scramble = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        $cphr = sodium_crypto_secretbox($value, $scramble, $chain);
        $encoded = base64_encode($chain . $cphr);
        return($encoded);
    
	}else{
		
        return false;
    
	}
	
}
?>