<?php

namespace App\Extensions\Service;

use App\Entity\BasecoAutorisations;

class Autorisation
{

    public function lecture($site, $fonctions, $value, $roles)
    {
        if (in_array("ROLE_MANAGER", $roles) == true || $site == "DSFO-ADMIN") {
            return $value;
        } else {
            if (in_array($site, $value->getAutorisations()[0]['SITES']) == true) {
                if ($fonctions == "CC") {
                    if (in_array("LIRE", $value->getAutorisations()[1]['CC']) == true) {
                        return $value;
                    }
                } else if ($fonctions == "BO") {
                    if (in_array("LIRE", $value->getAutorisations()[2]['BO']) == true) {
                        return $value;
                    }
                } else if ($fonctions == "SUP") {
                    if (in_array("LIRE", $value->getAutorisations()[3]['SUP']) == true) {
                        return $value;
                    }
                } else if ($fonctions == "AQ") {
                    if (in_array("LIRE", $value->getAutorisations()[4]['AQ']) == true) {
                        return $value;
                    }
                } else if ($fonctions == "AQ_OML") {
                    if (in_array("LIRE", $value->getAutorisations()[5]['AQOML']) == true) {
                        return $value;
                    }
                } else if ($fonctions == "RO") {
                    if (in_array("LIRE", $value->getAutorisations()[6]['OP']) == true) {
                        return $value;
                    }
                } else if ($fonctions == "AO") {
                    if (in_array("LIRE", $value->getAutorisations()[7]['AO']) == true) {
                        return $value;
                    }
                } else if ($fonctions == "FORMA") {
                    if (in_array("LIRE", $value->getAutorisations()[7]['FORMA']) == true) {
                        return $value;
                    }
                }
            } else {
                return null;
            }
        }
    }

    public function tableau($tableau, $ficheAutoriser, $role, $indic): string
    {

        $gescos = "false";
        $data = '<div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive"><fieldset class="fieldset"><legend class="legend">Résultat des recherches</legend>
                            <table class="table table-striped custom-table m-b-0  w-100 ' . $tableau . '">
                                <thead>
                                    <tr>
                                        <th>DESCRIPTION</th>
                                        <th>TYPE</th>
                                        <th>DATE DE DEBUT</th>
                                        <th>DATE DE FIN</th>
                                        <th>PRIORITE</th>
                                   ';
        if (in_array('ROLE_GESCO_GP', $role) == true || in_array('ROLE_GESCO_RS', $role) == true) {

            if ($indic == "ONTIME") {
                $data .= '<th>DATES</th><th class="text-center">ON TIME</th><th class="text-center upper">Gestionnaires</th>';
            } else {
                $data .= '<th>DATES</th><th class="text-center">' . $indic . '</th><th class="text-center">Gestionnaires</th>';
            }
            $gescos = "true";
        }

        $data .= '</tr></thead><tbody>';

        foreach (array_unique($ficheAutoriser, SORT_REGULAR) as $value) {
            if ($value != null) {

                if ($value->getChargement()->getSla()->getPriorites() <= 2) {
                    $prio = '<a class="btn btn-white btn-sm btn-rounded" ><i class="far fa-dot-circle text-danger"></i> Haute </a>';
                } elseif ($value->getChargement()->getSla()->getPriorites() > 2 && $value->getChargement()->getSla()->getPriorites() <= 5) {
                    $prio = '<a class="btn btn-white btn-sm btn-rounded " ><i class="far fa-dot-circle text-warning"></i> Moyenne </a>';
                } else {
                    $prio = '<a class="btn btn-white btn-sm btn-rounded " ><i class="far fa-dot-circle text-success"></i> Bas </a>';
                }
                if ($gescos == "true") {
                    if ($indic == "ONTIME") {
                        if ($value->getChargement()->getBasecoOnTime()->getTemps() <= 0) {
                            $indicateurs = '<span  class="badge badge-success-border ">En avance de ' . $value->getChargement()->getBasecoOntime()->getTemps() * -1 . ' mn</span>';
                        } else {
                            $indicateurs = '<span  class="badge badge-danger-border ">En retard de ' . $value->getChargement()->getBasecoOntime()->getTemps() . $value->getChargement()->getBasecoOntime()->getId() . ' mn</span>';
                        };
                    } elseif ($indic == "EXACTITUDE") {
                        $indicateurs = $value->getChargement()->getBasecoChargementsControl()->getExactitude() . '%';
                    } elseif ($indic == "UTILITE") {
                        $indicateurs = $value->getChargement()->getBasecoChargementsControl()->getUtilite() . '%';
                    }


                    $gesco = ' <td class="text-center"><i class="far fa-calendar-alt"></i></td><td class="text-center">
                           ' . $indicateurs . '
                        </td>
                        <td class="text-center">
                          ' . $value->getChargement()->getGestionnaires()->getPrenom() . ' ' .  $value->getChargement()->getGestionnaires()->getNom() . '
                        </td>';
                } else {
                    $gesco = "";
                }
                $datefin = '<span  class="badge badge-info-border ">En cours</span>';
                if (!is_null($value->getChargement()->getDateFin())) {
                    $datefin = $value->getChargement()->getDateFin()->format('d-m-Y à H:i');
                }

                $data .= '<tr>
                        <td><a  href="/baseconnaissance/show/contenu/' . $value->getChargement()->getUrl() . '">' . $value->getChargement()->getTitres() . '</a></td>
                        <td>' . $value->getChargement()->getSla()->getNatures() . '</td>
                        <td>' . $value->getChargement()->getDateDebut()->format('d-m-Y à H:i') . '</td>
                        <td class="text-center">' . $datefin . '</td>
                        <td>
                            <div class="dropdown action-label">
                            ' . $prio . '
                            </div>
                        </td>
                        ' . $gesco . '
                    </tr>';
            }
        }
        $data .= '</tbody></table></div></div></fieldset></div>';

        return $data;
    }
}
