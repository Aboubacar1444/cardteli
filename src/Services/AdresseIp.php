<?php

namespace App\Services;



class AdresseIp
{



    public function getAdresseIp(): string
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

    public function getNavigateur(): string
    {
        if (preg_match('/MSIE/', $_SERVER["HTTP_USER_AGENT"])) {
            $navigateur =  "Internet explorer";
        } else if (preg_match('/^Mozilla\//', $_SERVER["HTTP_USER_AGENT"])) {
            $navigateur =  "Netscape";
        } else if (preg_match('/^Opera\//', $_SERVER["HTTP_USER_AGENT"])) {
            $navigateur =  "Opera";
        } else {
            $navigateur =  "inconnu";
        }

        return $navigateur;
    }
}
