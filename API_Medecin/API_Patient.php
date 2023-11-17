<?php
    require_once("jwt_utils.php");
    require_once("fonction.php");
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

    switch($http_method) {

        case 'GET' :
            try {

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