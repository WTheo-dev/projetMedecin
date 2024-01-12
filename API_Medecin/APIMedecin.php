<?php
    require_once("jwt_utils.php");
    require_once("fonctions.php");
    header("Content-Type:application/json");
    $http_method = $_SERVER['REQUEST_METHOD'];
    
    $bearer_token = get_bearer_token();
    if(is_jwt_valid($bearer_token, "pass")){
        $decoded_jwt = get_body_token($bearer_token);
        $role = $decoded_jwt['role'];
        $utilisateur = $decoded_jwt['utilisateur'];
    } else {
        deliver_response(403, "Connexion obligatoire", null);
        die("Acces echoue");
    }

    $postedData = file_get_contents('php://input');
	$data=json_decode($postedData, true);
    
    switch ($http_method) {
        case 'GET':
            if(isset($_GET['id_medecin'])) {
                try {
                    $RETURN_CODE = 200;
                    $STATUS_MESSAGE= "Voici le Médecin :";
                    $matchingData = unMedecin($_GET['id_medecin']);
                } catch (\Throwable $th) {
                    $RETURN_CODE = $th ->getCode();
                    $STATUS_MESSAGE = $th ->getMessage();
                    $matchingData = null;
                } finally {
                    deliver_response($RETURN_CODE, $STATUS_MESSAGE, $matchingData);
                }
            } else {
                try {
                    $RETURN_CODE = 200;
                    $STATUS_MESSAGE = "Voici la liste des Médecins :";
                    $matchingData = listeMedecin();
                } catch (\Throwable $th) {
                    $RETURN_CODE = $th->getCode();
                    $STATUS_MESSAGE = $th->getMessage();
                    $matchingData = null;
                } finally {
                    deliver_response($RETURN_CODE, $STATUS_MESSAGE, $matchingData);
                }
            }   
            break;
        
        case 'POST':
            // Ajouter le code pour la méthode POST
            break;
        
        case 'PUT' :
            // Ajouter le code pour la méthode PUT
            break;

        case 'DELETE' :
            // Ajouter le code pour la méthode DELETE
            break;
        
    }
?>
