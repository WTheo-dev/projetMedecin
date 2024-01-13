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
        if (isset($_GET['id_rendezvous'])) {
            try {
                $RETURN_CODE = 200;
                $STATUS_MESSAGE = "Voici le Rendez-Vous:";
                $matchingData = uneConsultation($_GET['id_rendezvous']);

                if ($matchingData === null) {
                    throw new Exception("Aucun rendez-vous n'a été trouvé avec l'ID spécifié");
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
                $STATUS_MESSAGE = "Voici la liste des Consultations :";
                $matchingData = listeConsultation();
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
        break;

    case 'PUT':
        break;

    case 'DELETE':
        $id_rendezvous = $_GET['id_rendezvous'];

            if ($id_rendezvous) {
                $result = supprimerConsulation($id_rendezvous);
                if ($result === true) {
                    $RETURN_CODE = 200;
                    $STATUS_MESSAGE = "Le rendez-vous a été supprimé avec succès.";
                    $matchingData = null;
                } else {
                    $RETURN_CODE = 400;
                    $STATUS_MESSAGE = "Le rendez-vous n'existe pas ou à déjà été supprimé";
                    $matchingData = null;
                }
            } else {
                $RETURN_CODE = 400;
                $STATUS_MESSAGE = "L'ID du rendez-vous est requis";
            }
            deliver_response($RETURN_CODE,$STATUS_MESSAGE,$matchingData);
        break;

    default:
        deliver_response(405, "not implemented method", null);
        break;
}