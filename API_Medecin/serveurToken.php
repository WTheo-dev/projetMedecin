<?php

require_once("jwt_utils.php");
require_once("fonctions.php");

$header = array("alg" => "HS256", "typ"=>"JWT");
$key = "pass";
header("Content-Type:application/json");
$methodeHTTP = $_SERVER['REQUEST_METHOD'];
$cle = "pass";

switch ($methodeHTTP) {
	
	case "POST" :
		try {
			$postedData = file_get_contents('php://input');
			$data=json_decode($postedData, true);
			if(empty($data['nom_utilisateur']) AND empty($data['mdp'])){
				$body = array("role" => "", "utilisateur" => "", "exp" => (time()+600));
				$RETURN_CODE = 201;
			}else{
				if(identification($data['nom_utilisateur'], $data['mdp'])){
					$RETURN_CODE = 201;
					$duree = 2592000;
					$body = array(
						"role" => recuperation_role($data['nom_utilisateur']),
						"utilisateur" => $data['nom_utilisateur'],
						"exp" => (time() + $duree)
					);
				}else{
					$RETURN_CODE = 400;
					$STATUS_MESSAGE = "Identifiant incorrect";
					$matchingData = null;
				}
			}
			if($RETURN_CODE < 400){
				$STATUS_MESSAGE = "Connexion autorisé !";
				$matchingData = generate_jwt($header, $body ,$key);	
			}
							
		} catch (\Throwable $th) {
			$RETURN_CODE = $th->getCode();
			$STATUS_MESSAGE = $th->getMessage();
			$matchingData = null;
		} finally {
			deliver_response($RETURN_CODE, $STATUS_MESSAGE, $matchingData);
		}
		break;
	
	default :
		deliver_response(405, "not implemented method", null);
		break;
}
?>
