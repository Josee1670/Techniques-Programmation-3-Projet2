<?php

// Cette fonction prend l'object au format tablulaire SQL 
// et retourne un objet dont la structure correspond au format
// devant être retourné par l'API. 
function ConversionreservationsSQLEnObjet($reservationsSQL) {
    $reservationsObj = new stdClass();
    $reservationsObj->de = $reservationsSQL["de"];
    $reservationsObj->vers = $reservationsSQL["vers"];
    $reservationsObj->date = $reservationsSQL["date"];

    $reservationsObj->duree = explode(";", $reservationsSQL["duree"]);

    $reservationsObj->occupation = new stdClass();
    $reservationsObj->occupation->nombreDePassagersAdultes = $reservationsSQL["nombreDePassagersAdultes"];
    $reservationsObj->occupation->nombreDePassagersEnfants = $reservationsSQL["nombreDePassagersEnfants"];
    $reservationsObj->occupation->nombreDeChambres = $reservationsSQL["nombreDeChambres"];

    return $reservationsObj;
}
?>