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
    
    switch ($http_method) {
        
        case "POST" :
        if($role == 2){
            $matchingData = NULL;
                if($utilisateur != createur_articles($_GET['id'])){
                    if(articles_existe($_GET['id'])){
                        if(!deja_liker($utilisateur, $_GET['id'])){
                            if($data['like'] == 1 OR $data['like'] == 0){
                                if(ajouter_like($data["like"], $_GET['id'], $utilisateur)){
                                    $RETURN_CODE = 201;
                                    $STATUS_MESSAGE = "Reaction effectue avec succes";
                                }else{
                                    $RETURN_CODE = 400;
                                    $STATUS_MESSAGE = "La reaction a echoue";
                                }
                            }else{
                                $RETURN_CODE = 400;
                                $STATUS_MESSAGE = "Le format du like est incorrect";
                            }
                        }else{
                            retirer_like($_GET['id'], $utilisateur);
                            $RETURN_CODE = 201;
                            $STATUS_MESSAGE = "Reaction annule, le like ou le dislike a ete retire";
                        }
                    }else{
                        $RETURN_CODE = 400;
                        $STATUS_MESSAGE = "L'article n'existe pas";
                    }    
                }else{
                    $RETURN_CODE = 400;
                    $STATUS_MESSAGE = "Vous ne pouvez pas liker ou disliker votre propre article";
                }
        }else{
            $RETURN_CODE = 403;
            $STATUS_MESSAGE = "Vous ne possedez pas le role approprie";
        }
            $matchingData = NULL;
            deliver_response($RETURN_CODE, $STATUS_MESSAGE, $matchingData);
            break;

        default :
            deliver_response(405, "not implemented method", null);
            break;
    }

?>