<?php

require_once("jwt_utils.php");
require_once("fonction.php");

$header = array("alg" => "HS256", "typ"=>"JWT");
$cle = "pass";
header("Content-Type:application/json");
$methodeHTTP = $_SERVER['REQUEST_METHOD'];

switch ($methodeHTTP) {
	
	case "POST" :
		try {
			$postedData = file_get_contents('php://input');
			$data=json_decode($postedData, true);
			if(empty($data['login']) AND empty($data['password'])){
				$body = array("role" => "", "utilisateur" => "", "exp" => (time()+600));
				$RETURN_CODE = 201;
			}else{
				if(identification($data['login'], $data['password'])){
					$RETURN_CODE = 201;
					$body = array("role" => recuperation_role($data['login']), "utilisateur" => $data['login'],"exp" => (time()+600));
				}else{
					$RETURN_CODE = 400;
					$STATUS_MESSAGE = "Identifiant incorrect";
					$matchingData = null;
				}
			}
			if($RETURN_CODE < 400){
				$STATUS_MESSAGE = "Connection valide";
				$matchingData = generate_jwt($header, $body ,$cle);	
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
