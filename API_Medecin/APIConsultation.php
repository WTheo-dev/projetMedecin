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
        try {
            $RETURN_CODE = 200;
            
            if (isset($_GET['id_rendezvous'])) {
                $STATUS_MESSAGE = "Voici le Rendez-Vous:";
                $matchingData = uneConsultation($_GET['id_rendezvous']);
                
                if ($matchingData === null) {
                    throw new Exception("Aucun rendez-vous n'a été trouvé avec l'ID spécifié");
                }
            } else {
                if (isset($_GET['date_rdv'])) {
                    $STATUS_MESSAGE = "Voici la liste des rendez-vous du Jour :";
                    $matchingData = listeConsultationDuJour();
                } else {
                    $STATUS_MESSAGE = "Voici la liste des Rendez-vous :";
                    $matchingData = listeConsultation();
                }
            }
        } catch (\Throwable $th) {
            $RETURN_CODE = $th->getCode();
            $STATUS_MESSAGE = $th->getMessage();
            $matchingData = null;
        } finally {
            deliver_response($RETURN_CODE, $STATUS_MESSAGE, $matchingData);
        }
        break;
    

    case 'POST':
        $matchingData = null;
        if (ajouterConsultation($data['id_patient'],$data['date_rdv'],$data['heure_rdv'],$data['duree_rdv'], $data['$id_medecin'])) {
            $RETURN_CODE = 200;
            $STATUS_MESSAGE = "Création du rendez-vous effectué";
        } else {
            $RETURN_CODE = 400;
            $STATUS_MESSAGE = "Création impossible ou rendez-vous déjà existant";
        }
        deliver_response($RETURN_CODE,$STATUS_MESSAGE,$matchingData);
        break;

    case 'PUT':
        $matchingData = null;
        $id_rendezvous = $_GET['$id_rendezvous'];

            if(modifierConsultation($id_rendezvous,$data['id_patient'],$data['date_rdv'],$data['heure_rdv'],$data['duree_rdv'], $data['$id_medecin'])) {
                $RETURN_CODE = 200;
                $STATUS_MESSAGE = "Modifications du rendez-vous effectuée.";
            } else {
                $RETURN_CODE = 400;
                $STATUS_MESSAGE = "Modification du rendez-vous impossible ou rendez-vous inexistant";
            }
            deliver_response($RETURN_CODE,$STATUS_MESSAGE,$matchingData);
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