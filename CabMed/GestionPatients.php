<?php
require_once("jwt_utils.php");
require_once("fonctions.php");
header("Content-Type:application/json");
$http_method = $_SERVER['REQUEST_METHOD'];

$bearer_token = get_bearer_token();
if (is_jwt_valid($bearer_token, "pass")) {
    $decoded_jwt = get_body_token($bearer_token);
    $role = $decoded_jwt['role'];
    $utilisateur = $decoded_jwt['utilisateur'];
} else {
    deliver_response(403, "Connexion obligatoire", null);
    die("Acces echoue");
}

$postedData = file_get_contents('php://input');
$data = json_decode($postedData, true);

switch ($http_method) {

    case 'GET':
        if (isset($_GET['nom'])) {
            try {
                $RETURN_CODE = 200;
                $STATUS_MESSAGE = "Voici l'usager :";
                $matchingData = unUsager($_GET['nom']);

                if ($matchingData === null) {
                    throw new Exception("Aucun usager trouvé avec l'ID spécifié");
                }
                
            } catch (\Throwable $th) {
                $RETURN_CODE = $th->getCode();
                $STATUS_MESSAGE = $th->getMessage();
                $matchingData = null;
            } finally {
                deliver_response($RETURN_CODE, $STATUS_MESSAGE, $matchingData);
            }
        } else {
            try {
                $RETURN_CODE = 200;
                $STATUS_MESSAGE = "Voici la liste des usagers :";
                $matchingData = listeUsager();
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
            $matchingData = null;
            if (UsagerExisteDeja($data['num_secu'])) {
                $RETURN_CODE = 400;
                $STATUS_MESSAGE = "L'usager existe déjà avec le même numéro de sécurité sociale";
            } else {
                // Si l'usager n'existe pas, ajouter le nouveau usager
                if (ajouterUsager($data['civilite'], $data['nom'], $data['prenom'], $data['sexe'], $data['adresse'], $data['code_postal'], $data['ville'], $data['date_nais'], $data['lieu_nais'], $data['num_secu'])) {
                    $RETURN_CODE = 200;
                    $STATUS_MESSAGE = "Ajout de l'usager correctement effectué";
                } else {
                    $RETURN_CODE = 400;
                    $STATUS_MESSAGE = "L'ajout du nouveau usager n'a pas pu être réalisé ou l'usager existe déjà";
                }
            }
        
            deliver_response($RETURN_CODE, $STATUS_MESSAGE, $matchingData);
        break;
        

    case 'PUT':
        $matchingData =  null;
        $id_usager = $_GET['id_usager'];
        if(modifierUsager($id_usager,$data['civilite'], $data['nom'], $data['prenom'], $data['sexe'], $data['adresse'], $data['code_postal'], $data['ville'], $data['date_nais'], $data['lieu_nais'], $data['num_secu'])) {
            $RETURN_CODE = 200;
            $STATUS_MESSAGE = "Mise à jour de l'usager effectué";
        } else {
            $RETURN_CODE = 400;
            $STATUS_MESSAGE = "Erreur de syntaxe ou id_usager invalide";
        }
        deliver_response($RETURN_CODE,$STATUS_MESSAGE,$matchingData);
        break;

    case 'DELETE':
        $id_usager = $_GET['id_usager'];

        if ($id_usager) {
            $result = supprimerUsager($id_usager);
            if ($result === true) {
                $RETURN_CODE = 200;
                $STATUS_MESSAGE = "L'usager a été supprimé avec succès.";
                $matchingData = null;
            } else {
                $RETURN_CODE = 400;
                $STATUS_MESSAGE = "L'usager n'existe pas ou à déjà été supprimé";
                $matchingData = null;
            }
        } else {
            $RETURN_CODE = 400;
            $STATUS_MESSAGE = "L'ID de l'usager est requis";
        }
        deliver_response($RETURN_CODE, $STATUS_MESSAGE, $matchingData);
        break;

    default:
        deliver_response(405, "not implemented method", null);
        break;
}