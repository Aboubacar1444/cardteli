<?php // src/Service/FileUploader.php
namespace App\Services;


class CryptageData
{
    public function cryptage($chaine, ?string $key_password  = '')
    {
        $encrypted_chaine = openssl_encrypt($chaine, "AES-128-ECB", $key_password);

        return $encrypted_chaine;
    }

    public function decryptage($encrypted_chaine, ?string $key_password  = '')
    {
        $decrypted_chaine = openssl_decrypt(
            $encrypted_chaine,
            "AES-128-ECB",
            $key_password
        );

        return $decrypted_chaine;
    }

    public function urlEncode($parametre)
    {
        $parametreHache = urlencode($parametre);

        return $parametreHache;
    }

    public function urlDencode($parametre)
    {
        $parametreHache = urldecode($parametre);

        return $parametreHache;
    }
}
