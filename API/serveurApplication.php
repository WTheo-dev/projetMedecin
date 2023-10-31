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
    
        case "GET" :
            if($role == 2 && !empty($_GET['publisher'])){
                $matchingData = articles_publisher($utilisateur);
            }else{
                $matchingData = tous_articles($role);
            }
            try{
                $RETURN_CODE = 200;
                $STATUS_MESSAGE = "Succes ! Les donnees autorisees pour votre role sont accessible";

            } catch (\Throwable $th) {
                $RETURN_CODE = $th->getCode();
                $STATUS_MESSAGE = $th->getMessage();
                $matchingData = null;
            } finally {
                deliver_response($RETURN_CODE, $STATUS_MESSAGE, $matchingData);
            }
            break;

        case "POST" :
            $matchingData = NULL;
            if($role == 2){
                if(publier_article($data['titre'], $data['contenu'], $utilisateur)){
                    $RETURN_CODE = 200;
                    $STATUS_MESSAGE = "Publication effectue";
                }else{
                    $RETURN_CODE = 400;
                    $STATUS_MESSAGE = "Erreur de syntaxe";
                }
            }else{
                $RETURN_CODE = 403;
                $STATUS_MESSAGE = "Vous ne possedez pas le role approprie";
            }
            deliver_response($RETURN_CODE, $STATUS_MESSAGE, $matchingData);
            break;

            case "DELETE" :
                $matchingData = NULL;
                if($role == 1){
                    if(supprimer_article($_GET['id'])){
                        $RETURN_CODE = 204;
                        $STATUS_MESSAGE = "Suppression effectue";
                    }else{
                        $RETURN_CODE = 400;
                        $STATUS_MESSAGE = "Erreur de syntaxe";
                    }
                }elseif($role == 2){
                    if($utilisateur == createur_articles($_GET['id'])){
                        if(supprimer_article($_GET['id'])){
                            $RETURN_CODE = 204;
                            $STATUS_MESSAGE = "Suppression effectue";
                        }else{
                            $RETURN_CODE = 400;
                            $STATUS_MESSAGE = "Erreur de syntaxe";
                        }
                    }else{
                        $RETURN_CODE = 403;
                        $STATUS_MESSAGE = "Cet article n'est pas le votre";
                    }
                }else{
                    $RETURN_CODE = 403;
                    $STATUS_MESSAGE = "Vous ne possedez pas le role approprie";
                }
                deliver_response($RETURN_CODE, $STATUS_MESSAGE, $matchingData);
                break;
            
            case "PUT" :
                $matchingData = NULL;
                if($role == 2){
                    if($utilisateur == createur_articles($_GET['id'])){
                        if(modifier_article($utilisateur, $_GET['id'], $data["titre"], $data["contenu"])){
                            $RETURN_CODE = 200;
                            $STATUS_MESSAGE = "Modification effectue";
                        }else{
                            $RETURN_CODE = 400;
                            $STATUS_MESSAGE = "Erreur de syntaxe";
                        }
                    }else{
                        $RETURN_CODE = 400;
                        $STATUS_MESSAGE = "Cet article n'est pas le votre";
                    }
                }else{
                    $RETURN_CODE = 403;
                    $STATUS_MESSAGE = "Vous ne possedez pas le role approprie";
                }
                deliver_response($RETURN_CODE, $STATUS_MESSAGE, $matchingData);
                break;
        
        default :
            deliver_response(405, "not implemented method", null);
            break;
    }

?>