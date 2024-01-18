<?php
    require_once("jwt_utils.php");
    require_once("fonctions.php");
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
        case 'GET':
            if (isset($_GET['id_medecin'])) {
                try {
                    $RETURN_CODE = 200;
                    $STATUS_MESSAGE = "Voici le Médecin :";
                    $matchingData = unMedecin($_GET['id_medecin']);
        
                    if ($matchingData === null) {
                        throw new Exception("Aucun médecin trouvé avec l'ID spécifié");
                    }
                } catch (\Throwable $th) {
                    $RETURN_CODE = $th->getCode();
                    $STATUS_MESSAGE = $th->getMessage();
                    $matchingData = null;
                } finally {
                    deliver_response($RETURN_CODE, $STATUS_MESSAGE, $matchingData);
                }
            } elseif (isset($_GET['id_medecin'])) {
                try {
                    $RETURN_CODE = 200;
                    $STATUS_MESSAGE = "Voici la liste des ID Médecins :";
                    $matchingData = listeMedecinID();
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
                    $STATUS_MESSAGE = "Voici la liste des Médecins :";
                    $matchingData = listeMedecin();
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
                if (MedecinExisteDeja($data['nom'])) {              
                    $RETURN_CODE = 400;
                    $STATUS_MESSAGE = "Le médecin existe déjà.";
                } else {
                    // Assurez-vous que les clés nécessaires existent dans $data
                    if (isset($data['civilite'], $data['nom'], $data['prenom'], $data['nom_utilisateur'], $data['mdp'], $data['id_role'])) {
                        // Appel à la fonction inscriptionApprenti
                        if (
                            ajouterMedecin($data['civilite'], $data['nom'], $data['prenom'], [
                                'nom_utilisateur' => $data['nom_utilisateur'],
                                'mdp' => $data['mdp'],
                                'id_role' => $data['id_role']
                            ])
                        ) { 
                            $RETURN_CODE = 200;
                            $STATUS_MESSAGE = "Ajout Médecin effectué";
                        } else {
                            $RETURN_CODE = 400;
                            $STATUS_MESSAGE = "Erreur lors de l'ajout du médecin";
                        }
                    } else {
                        $RETURN_CODE = 400;
                        $STATUS_MESSAGE = "Données manquantes dans la requête";
                    }
                }
                // Envoi de la réponse
                deliver_response($RETURN_CODE, $STATUS_MESSAGE, $matchingData);
                break;
        
        case 'PUT' :
            $matchingData =  null;
            $id_medecin = $_GET['id_medecin'];
            if(modifierMedecin($id_medecin, $data['civilite'],$data['nom'],$data['prenom'])) {
                $RETURN_CODE = 200;
                $STATUS_MESSAGE = "Mise à jour du Médecin effectuée";
            } else {
                $RETURN_CODE = 400;
                $STATUS_MESSAGE = "Erreur de syntaxe ou id_medecin invalide";
            }
            deliver_response($RETURN_CODE,$STATUS_MESSAGE,$matchingData);
            break;

        case 'DELETE' :
            $id_medecin = $_GET['id_medecin'];

            if ($id_medecin) {
                $result = supprimerMedecin($id_medecin);
                if ($result === true) {
                    $RETURN_CODE = 200;
                    $STATUS_MESSAGE = "Le médecin a été supprimé avec succès.";
                    $matchingData = null;
                } else {
                    $RETURN_CODE = 400;
                    $STATUS_MESSAGE = "Le médecin n'existe pas ou à déjà été supprimé";
                    $matchingData = null;
                }
            } else {
                $RETURN_CODE = 400;
                $STATUS_MESSAGE = "L'ID du medecin est requis";
            }
            deliver_response($RETURN_CODE,$STATUS_MESSAGE,$matchingData);
            break;
        
    }
?>
