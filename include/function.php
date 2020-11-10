<?php

/**
 * @param     $name
 * @param int $select
 * @return string
 */
function listejour($name, $select = 1)
{
    $select--; // pour avoir l'incdiee ds le tableau
    $j     = [
        '01',
        '02',
        '03',
        '04',
        '05',
        '06',
        '07',
        '08',
        '09',
        '10',
        '11',
        '12',
        '13',
        '14',
        '15',
        '16',
        '17',
        '18',
        '19',
        '20',
        '21',
        '22',
        '23',
        '24',
        '25',
        '26',
        '27',
        '28',
        '29',
        '30',
        '31',
    ];
    $liste = "<select name='$name'>";
    foreach ($j as $i => $iValue) {
        if ($select == $i) {
            $liste .= "<option value='$iValue' selected>$iValue</option>";
        } else {
            $liste .= "<option value='$iValue'>$iValue</option>";
        }
    }
    $liste .= '</select>';

    return $liste;
}

/**
 * @param     $name
 * @param int $select
 * @return string
 */
function listemois($name, $select = 1)
{
    $select--; // pour avoir l'indice ds le tableau
    $nom   = [
        'Janvier',
        'Février',
        'Mars',
        'Avril',
        'Mai',
        'Juin',
        'Juillet',
        'Août',
        'Septembre',
        'Octobre',
        'Novembre',
        'Décembre',
    ];
    $m     = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
    $liste = "<select name=\"$name\">";
    for ($i = 0, $iMax = count($m); $i < $iMax; ++$i) {
        if ($select == $i) {
            $liste .= "<option value=\"$m[$i]\" selected>$nom[$i]</option>";
        } else {
            $liste .= "<option value=\"$m[$i]\">$nom[$i]</option>";
        }
    }
    $liste .= '</select>';

    return $liste;
}

/**
 * @param        $name
 * @param        $fin
 * @param string $select
 * @return string
 */
function listeannee($name, $fin, $select = '1930')
{
    $liste = "<select name=\"$name\">";
    for ($i = 1930; $i <= $fin; ++$i) {
        if ($select == $i) {
            $liste .= "<option value=\"$i\" selected>$i</option>";
        } else {
            $liste .= "<option value=\"$i\">$i</option>";
        }
    }
    $liste .= '</select>';

    return $liste;
}
