<?php

namespace App\Services;



class ConnexionInternet
{



    public function ConnexionInternet(): string
    {
        if (!$sock = @fsockopen('www.google.fr', 80, $num, $error, 5)) {
            $statut = "Non";
        } else {
            $statut = "Oui";
        };
        return $statut;
    }
}