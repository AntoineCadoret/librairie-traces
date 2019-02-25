<?php
/**
 * @auteur Beverly Cagelet <beverly.cagelet.protic@gmail.com>
 * TODO - les apostrophes
 * TODO - la coupure mobile
 */

function ameliorerTitre($strTitre)
{
    if (strpos($strTitre,"(")==""){
        $strTitreAmeliore = $strTitre;
    }
    else {
        $intDepart = strpos($strTitre,"(");
        $intFin = strpos($strTitre,")");

        $strTitreIncomplet = substr($strTitre,0,$intDepart);;

        $strDeterminant = substr($strTitre,$intDepart+1,($intFin-$intDepart-1));

        $strTitreAmeliore = $strDeterminant . " " . $strTitreIncomplet;
    }
    return $strTitreAmeliore;
}