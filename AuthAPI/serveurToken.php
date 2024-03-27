<?php

require_once("../CabMed/jwt_utils.php");
require_once("../CabMed/fonctions.php");

$header = array("alg" => "HS256", "typ" => "JWT");
$key = "pass";
header("Content-Type: application/json");

$methodeHTTP = $_SERVER['REQUEST_METHOD'];

switch ($methodeHTTP) {
    case "POST":
        try {
            $postedData = file_get_contents('php://input');
            $data = json_decode($postedData, true);
            if (empty($data['nom_utilisateur']) || empty($data['mdp'])) {
                $RETURN_CODE = 400;
                $STATUS_MESSAGE = "Nom d'utilisateur ou mot de passe manquant";
                $matchingData = null;
            } else {
                if (identification($data['nom_utilisateur'], $data['mdp'])) {
                    $RETURN_CODE = 200;
                    $duree = 2592000; 
                    $body = array(
                        "role" => recuperation_role($data['nom_utilisateur']),
                        "utilisateur" => $data['nom_utilisateur'],
                        "exp" => (time() + $duree) 
                    );
                    $STATUS_MESSAGE = "Connexion autorisée !";
                    $matchingData = generate_jwt($header, $body, $key);
                } else {
                    $RETURN_CODE = 401;
                    $STATUS_MESSAGE = "Identifiants incorrects";
                    $matchingData = null;
                }
            }
        } catch (\Throwable $th) {
            $RETURN_CODE = 500; 
            $STATUS_MESSAGE = $th->getMessage();
            $matchingData = null;
        } finally {
            deliver_response($RETURN_CODE, $STATUS_MESSAGE, $matchingData);
        }
        break;

    default:
        deliver_response(405, "Méthode non autorisée", null);
        break;
}
?>
