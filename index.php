<?php
include_once './include/config.php'; 
include_once 'include/fonctions.php'; 

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
		if ($requete = $mysqli->prepare("SELECT * FROM forfaits WHERE id=?")) {  
		  $requete->bind_param("i", $_GET['id']); 
		  $requete->execute(); 

		  $resultat_requete = $requete->get_result(); 
		  $forfaitsSQL = $resultat_requete->fetch_assoc(); 

		  // Convesion de l'objet au format JSON désiré
          $forfaitsObj = ConversionforfaitsSQLEnObjet($forfaitsSQL);

		  echo json_encode($forfaitsObj, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

		  $requete->close(); 
		}
	} else {
		$requete = $mysqli->query("SELECT * FROM forfaits");
		$listeforfaitsObj = [];

		while ($forfaitsSQL = $requete->fetch_assoc()) {
			// Convesion de l'objet au format JSON désiré
			$forfaitsObj = ConversionforfaitsSQLEnObjet($forfaitsSQL);

			//Ajout du forfaits à la liste
			array_push($listeforfaitsObj, $forfaitsObj);
		}
		
		echo json_encode($listeforfaitsObj, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		$requete->close();
	}
	break;
case 'POST':  // GESTION DES DEMANDES DE TYPE POST
	$reponse = new stdClass();
	$reponse->message = "Ajout d'un forfaits: ";
	
	$corpsJSON = file_get_contents('php://input');
	$data = json_decode($corpsJSON, TRUE); 

	$destination = $data['destination'];
	$villeDepart = $data['villeDepart'];
	$nom = $data['hotel']['nom'];
	$adresse = $data['hotel']['adresse'];
	$nombreEtoiles = $data['hotel']['nombreEtoiles'];
	$nombreChambres = $data['hotel']['nombreChambres'];
	$caracteristiques = $data['caracteristiques'];
	$dateDepart = $data['dateDepart'];
	$duree = $data['duree'];
	$prix = $data['prix'];
	$rabais = $data['rabais'];
	$forfaitVedette = $data['forfaitVedette'];

	if(isset($destination) && isset($villeDepart) && isset($nom) && isset($adresse) && isset($nombreEtoiles)
		 && isset($nombreChambres) && isset($caracteristiques) && isset($dateDepart) && isset($duree) 
		 && isset($prix) && isset($rabais) && isset($forfaitVedette)) {
      $caracteristiques_str = implode(';', $caracteristiques);

		if ($requete = $mysqli->prepare("INSERT INTO forfaits (destination, villeDepart, nom, adresse, nombreEtoiles, nombreChambres, caracteristiques, dateDepart, duree, prix, rabais, forfaitVedette) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {      
        	$requete->bind_param("ssssddsssdds", $destination, $villeDepart, $nom, $adresse, $nombreEtoiles, $nombreChambres, 
		$caracteristiques_str, $dateDepart, $duree, $prix, $rabais, $forfaitVedette);

        if($requete->execute()) { 
          $reponse->message .= "Succès";  
        } else {
          $reponse->message .=  "Erreur dans l'exécution de la requête " . $requete->error;  
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
	$reponse->message = "Édition du forfaits: ";
	
	$corpsJSON = file_get_contents('php://input');
	$data = json_decode($corpsJSON, TRUE); 

	$destination = $data['destination'];
	$villeDepart = $data['villeDepart'];
	$nom = $data['hotel']['nom'];
	$adresse = $data['hotel']['adresse'];
	$nombreEtoiles = $data['hotel']['nombreEtoiles'];
	$nombreChambres = $data['hotel']['nombreChambres'];
	$caracteristiques = $data['caracteristiques'];
	$dateDepart = $data['dateDepart'];
	$duree = $data['duree'];
	$prix = $data['prix'];
	$rabais = $data['rabais'];
	$forfaitVedette = $data['forfaitVedette'];

	if(isset($_GET['id'])) { 
		if(isset($destination) && isset($villeDepart) && isset($nom) && isset($adresse) && isset($nombreEtoiles) && isset($nombreChambres) && isset($caracteristiques) && isset($dateDepart) && isset($duree) && isset($prix) && isset($rabais) && isset($forfaitVedette)) {
			$caracteristiques_str = implode(';', $caracteristiques);

		  if ($requete = $mysqli->prepare("UPDATE forfaits SET destination=?, villeDepart=?, nom=?, adresse=?, nombreEtoiles=?, nombreChambres=?, caracteristiques=?, dateDepart=?, duree=?, prix=?, rabais=?, forfaitVedette=? WHERE id=?")) {     
			$requete->bind_param("ssssddsssddsi", $destination, $villeDepart, $nom, $adresse, $nombreEtoiles, $nombreChambres, $caracteristiques_str, $dateDepart, $duree, $prix, $rabais, $forfaitVedette, $_GET['id']);

			if($requete->execute()) { 
			  $reponse->message .= "Succès";  
			} else {
			  $reponse->message .=  "Erreur dans l'exécution de la requête" ;  
			}

			$requete->close(); 
		  } else  {
			$reponse->message .=  "Erreur dans la préparation de la requête";  
		  } 
		} else {
			$reponse->message .=  "Erreur dans le corps de l'objet fourni" ;  
		}
	} else {
		$reponse->message .=  "Erreur dans les paramètres (aucun identifiant fourni)" . $requete->error;  
	}
	
	echo json_encode($reponse, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
	break;
case 'DELETE':  // GESTION DES DEMANDES DE TYPE DELETE
	$reponse = new stdClass();
	$reponse->message = "Suppression d'un forfaits: ";
	if(isset($_GET['id'])) { 
		if ($requete = $mysqli->prepare("DELETE FROM forfaits WHERE id=?")) {     
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