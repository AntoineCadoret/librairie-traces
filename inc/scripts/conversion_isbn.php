<?php
/**
* @method ISBNToEAN
* @desc Convertit un ISBN en format EAN
* @param string ISBN    Le ISBN à convertir
* @return string        Le ISBN converti en EAN, ou FALSE si erreur dans le format ou la conversion
**/
function ISBNToEAN ($pIsbn)
{
    $myFirstPart = $mySecondPart = $myEan = $myTotal = "";
    if ($pIsbn == "")
        return false;
    $pIsbn = str_replace("-", "", $pIsbn);
    // ISBN-10
    if (strlen($pIsbn) == 10)
    {
        $myEan = "978" . substr($pIsbn, 0, 9);
        $myFirstPart = intval(substr($myEan, 1, 1)) + intval(substr($myEan, 3, 1)) + intval(substr($myEan, 5, 1)) + intval(substr($myEan, 7, 1)) + intval(substr($myEan, 9, 1)) + intval(substr($myEan, 11, 1));
        $mySecondPart = intval(substr($myEan, 0, 1)) + intval(substr($myEan, 2, 1)) + intval(substr($myEan, 4, 1)) + intval(substr($myEan, 6, 1)) + intval(substr($myEan, 8, 1)) + intval(substr($myEan, 10, 1));
        $tmp = intval(substr((3 * $myFirstPart + $mySecondPart), -1));
        $myControl = ($tmp == 0) ? 0 : 10 - $tmp;

        return $myEan . $myControl;
    }
    // ISBN-13
    else if (strlen($pIsbn) == 13) return $pIsbn;
    // Autre
    else return false;
}