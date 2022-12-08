<?php





$key = sodium_crypto_aead_xchacha20poly1305_ietf_keygen();
$nonce = random_bytes(SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF_NPUBBYTES);
 


function encrypter($donnee) {
    global  $key, $nonce;
    
    $mdp_crypte = sodium_crypto_aead_xchacha20poly1305_ietf_encrypt($donnee, '', $nonce, $key);
    
    return $mdp_crypte;
    
}



function decrypter($donnee) {
    global $key, $nonce;

    $mdp_origin = sodium_crypto_aead_xchacha20poly1305_ietf_decrypt($donnee, '', $nonce, $key);
    
    return $mdp_origin;
    
}



    
   
