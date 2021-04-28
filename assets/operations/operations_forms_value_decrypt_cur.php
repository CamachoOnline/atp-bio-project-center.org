<?php
function operation_form_value_decrypt($value = NULL)
{
    if($value){
        $decoded = base64_decode($value);
        $nonce = mb_substr($decoded, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, '8bit');
        $ciphertext = mb_substr($decoded, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES, null, '8bit');
        $plaintext = sodium_crypto_secretbox_open($ciphertext, $nonce, $key);
        return $plaintext;
    }else{
        return false;
    }
}
?>