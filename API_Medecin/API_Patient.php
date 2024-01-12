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
                $STATUS_MESSAGE = "Voici le Patient :";
                $matchingData = unPatient($_GET['nom']);
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
                $STATUS_MESSAGE = "Voici la liste des Patients :";
                $matchingData = listePatient();
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
        $matchingData =  null;
        $id_patient = $_GET['id_patient'];
        if(modifierPatient($id_patient,$data['num_secu'],$data['civilite'],$data['nom'],$data['prenom'],$data['adresse'],$data['date_naissance'],$data['lieu_naissance'])) {
            $RETURN_CODE = 200;
            $STATUS_MESSAGE = "Mise à jour du Patient effectuée";
        } else {
            $RETURN_CODE = 400;
            $STATUS_MESSAGE = "Erreur de syntaxe ou id_patient invalide";
        }
        deliver_response($RETURN_CODE,$STATUS_MESSAGE,$matchingData);
        break;

    case 'DELETE':
        $id_patient = $_GET['id_patient'];

        if ($id_patient) {
            $result = supprimerPatient($id_patient);
            if ($result === true) {
                $RETURN_CODE = 200;
                $STATUS_MESSAGE = "Le Patient a été supprimé avec succès.";
                $matchingData = null;
            } else {
                $RETURN_CODE = 400;
                $STATUS_MESSAGE = "Le Patient n'existe pas ou à déjà été supprimé";
                $matchingData = null;
            }
        } else {
            $RETURN_CODE = 400;
            $STATUS_MESSAGE = "L'ID du patient est requis";
        }
        deliver_response($RETURN_CODE, $STATUS_MESSAGE, $matchingData);
        break;

    default:
        deliver_response(405, "not implemented method", null);
        break;
}