<?php 

// Cette fonction prend l'object au format tablulaire SQL 
// et retourne un objet dont la structure correspond au format
// devant être retourné par l'API. 
function ConversionforfaitsSQLEnObjet($forfaitsSQL) {
    $forfaitsObj = new stdClass();
    $forfaitsObj->destination = $forfaitsSQL["destination"];
    $forfaitsObj->villeDepart = $forfaitsSQL["villeDepart"];
   
    $forfaitsObj->hotel = new stdClass();
    $forfaitsObj->hotel->nom = $forfaitsSQL["nom"];
    $forfaitsObj->hotel->adresse = $forfaitsSQL["adresse"];
    $forfaitsObj->hotel->nombreEtoiles = $forfaitsSQL["nombreEtoiles"];
    $forfaitsObj->hotel->nombreChambres = $forfaitsSQL["nombreChambres"];

    $forfaitsObj->caracteristiques = explode(";", $forfaitsSQL["caracteristiques"]);

    $forfaitsObj->dateDepart = $forfaitsSQL["dateDepart"];
    $forfaitsObj->duree = $forfaitsSQL["duree"];
    $forfaitsObj->prix = $forfaitsSQL["prix"];
    $forfaitsObj->rabais = $forfaitsSQL["rabais"];
    $forfaitsObj->forfaitVedette = $forfaitsSQL["forfaitVedette"];

    return $forfaitsObj;
}
?>