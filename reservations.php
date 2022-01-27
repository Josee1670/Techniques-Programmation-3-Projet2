<?php
include_once './include/config.php'; 
include_once 'include/fonctions1.php'; 

header('Content-Type: application/json;');
header('Access-Control-Allow-Origin: *'); 

$mysqli = new mysqli($host, $username, $password, $database); // Établissement de la connexion à la base de données
if ($mysqli -> connect_errno) { // Affichage d'une erreur si la connexion échoue
  echo 'Échec de connexion à la base de données MySQL: ' . $mysqli -> connect_error;
  exit();
} 

switch($_SERVER['REQUEST_METHOD'])
{
case 'GET':  // GESTION DES DEMANDES DE TYPE GET
	if(isset($_GET['id'])) { 
		if ($requete = $mysqli->prepare("SELECT * FROM reservations WHERE id=?")) {  
		  $requete->bind_param("i", $_GET['id']); 
		  $requete->execute(); 

		  $resultat_requete = $requete->get_result(); 
		  $reservationsSQL = $resultat_requete->fetch_assoc(); 

		  // Convesion de l'objet au format JSON désiré
          $reservationsObj = ConversionreservationsSQLEnObjet($reservationsSQL);

		  echo json_encode($reservationsObj, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

		  $requete->close(); 
		}
	} else {
		$requete = $mysqli->query("SELECT * FROM reservations");
		$listereservationsObj = [];

		while ($reservationsSQL = $requete->fetch_assoc()) {
			// Convesion de l'objet au format JSON désiré
			$reservationsObj = ConversionreservationsSQLEnObjet($reservationsSQL);

			//Ajout du reservations à la liste
			array_push($listereservationsObj, $reservationsObj);
		}
		
		echo json_encode($listereservationsObj, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		$requete->close();
	}
	break;
case 'POST':  // GESTION DES DEMANDES DE TYPE POST
	$reponse = new stdClass();
	$reponse->message = "Ajout d'une reservations: ";
	
	$corpsJSON = file_get_contents('php://input');
	$data = json_decode($corpsJSON, TRUE); 

	$de = $data['de'];
	$vers = $data['vers'];
	$date = $data['date'];
	$duree_str = $data['duree'];
	$nombreDePassagersAdultes = $data['occupation']['NombreDePassagersAdultes'];
	$nombreDePassagersEnfants = $data['occupation']['NombreDePassagersEnfants'];
	$nombreDeChambres = $data['occupation']['nombreDeChambres'];


	if(isset($de) && isset($vers) && isset($date) && isset($duree) && isset($nombreDePassagersAdultes) && isset($NombreDePassagersEnfants) && isset($NombreDeChambres)) {
      $duree_str = implode(';', $duree);

		if ($requete = $mysqli->prepare("INSERT INTO reservations (de, vers, date, duree, nombreDePassagersAdultes, NombreDePassagersEnfants, NombreDeChambres) VALUES(?, ?, ?, ?, ?, ?, ?)")) {      
        $requete->bind_param("ssddddd", $de, $vers, $date, $duree, $nombreDePassagersAdultes, $NombreDePassagersEnfants, $NombreDeChambres, $_GET['id']);

        if($requete->execute()) { 
          $reponse->message .= "Succès";  
        } else {
          $reponse->message .=  "Erreur dans l'exécution de la requête";  
        }

        $requete->close(); 
      } else  {
        $reponse->message .=  "Erreur dans la préparation de la requête";  
      } 
    } else {
		$reponse->message .=  "Erreur dans le corps de l'objet fourni";  
	}
	echo json_encode($reponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	
	break;
case 'PUT':  // GESTION DES DEMANDES DE TYPE PUT
	$reponse = new stdClass();
	$reponse->message = "Édition d'une reservations: ";

	$de = $data['de'];
	$vers = $data['vers'];
	$date = $data['date'];
	$duree_str = $data['duree'];
	$nombreDePassagersAdultes = $data['occupation']['NombreDePassagersAdultes'];
	$nombreDePassagersEnfants = $data['occupation']['NombreDePassagersEnfants'];
	$nombreDeChambres = $data['occupation']['nombreDeChambres'];
	
	$corpsJSON = file_get_contents('php://input');
	$data = json_decode($corpsJSON, TRUE); 
	if(isset($_GET['id'])) { 
		if(isset($de) && isset($vers) && isset($date) && isset($duree) && isset($nombreDePassagersAdultes) && isset($NombreDePassagersEnfants) && isset($NombreDeChambres)) {
		  if ($requete = $mysqli->prepare("UPDATE reservations SET de=?, vers=?, date=?, duree=?, nombreDePassagersAdultes=?, NombreDePassagersEnfants=?, NombreDeChambres=? WHERE id=?")) {     
			$requete->bind_param("ssddddd", $de, $vers, $date, $duree, $nombreDePassagersAdultes, $dNombreDePassagersEnfants, $NombreDeChambres);

			if($requete->execute()) { 
			  $reponse->message .= "Succès";  
			} else {
			  $reponse->message .=  "Erreur dans l'exécution de la requête";  
			}

			$requete->close(); 
		  } else  {
			$reponse->message .=  "Erreur dans la préparation de la requête";  
		  } 
		} else {
			$reponse->message .=  "Erreur dans le corps de l'objet fourni";  
		}
	} else {
		$reponse->message .=  "Erreur dans les paramètres (aucun identifiant fourni)";  
	}
	
	echo json_encode($reponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	break;
case 'DELETE':  // GESTION DES DEMANDES DE TYPE DELETE
	$reponse = new stdClass();
	$reponse->message = "Suppression d'une reservations: ";
	if(isset($_GET['id'])) { 
		if ($requete = $mysqli->prepare("DELETE FROM reservations WHERE id=?")) {     
			$requete->bind_param("i", $_GET['id']);

			if($requete->execute()) { 
			  $reponse->message .= "Succès";  
			} else {
			  $reponse->message .=  "Erreur dans l'exécution de la requête";  
			}

			$requete->close(); 
		  } else  {
			$reponse->message .=  "Erreur dans la préparation de la requête";  
		  } 
	} else {
		$reponse->message .=  "Erreur dans les paramètres (aucun identifiant fourni)";  
	}
	echo json_encode($reponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	break;
default:
	$reponse = new stdClass();
	$reponse->message = "Opération non supportée";	
	echo json_encode($reponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

$mysqli->close(); 
?>