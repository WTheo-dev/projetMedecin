<?php

/////////////////////////////////////////////////////////////////////////////
////////////////////   CONNEXION A LA BASE DE DONNEES    ////////////////////
/////////////////////////////////////////////////////////////////////////////

function connexionBD()
{
    $SERVER = '127.0.0.1';
    $BD = 'medecin';
    $LOGIN = 'root';
    $MDP = '';

    try {
        $BD = new PDO("mysql:host=$SERVER;dbname=$BD", $LOGIN, $MDP);
    } catch (PDOException $e) {
        die('Erreur : ' . $e->getMessage());
    }
    return $BD;
}


function identification($nom_utilisateur, $mdp)
{
    $BD = connexionBD();
    $nom_utilisateur = htmlspecialchars($nom_utilisateur);
    $mdp = htmlspecialchars($mdp);

    $verificationMembre = $BD->prepare('SELECT * FROM utilisateur WHERE nom_utilisateur = ? AND mdp = ?');
    $verificationMembre->execute(array($nom_utilisateur, $mdp));
    $hashed_password = $verificationMembre->fetchColumn();
    $BD = null;
    if ($hashed_password && password_verify($mdp, $hashed_password)) {
        return true;
    } else {
        return false;
    }
}


function recuperation_role($nom_utilisateur)
{
    $BD = connexionBD();
    $recuperationRoleMembre = $BD->prepare('SELECT id_role FROM utilisateur WHERE nom_utilisateur = ?');
    $recuperationRoleMembre->execute(array($nom_utilisateur));
    $BD = null;
    if ($recuperationRoleMembre->rowCount() > 0) {
        foreach ($recuperationRoleMembre as $row) {
            return $row['id_role'];
        }
    } else {
        return FALSE;
    }
}

function clean($champEntrant)
{
    // permet d'enlever les balises html, xml, php
    $champEntrant = strip_tags($champEntrant);
    // permet d'enlève les tags HTML et PHP
    $champEntrant = htmlspecialchars($champEntrant);
    return $champEntrant;
}

/////////////////////////////////////////////////////////////////////////////
////////////////////       GESTION DES usagerS          ////////////////////
/////////////////////////////////////////////////////////////////////////////

function listeusager()
{
    $BD = connexionBD();
    $listeusager = $BD->prepare('SELECT * from usager');
    $listeusager->execute(array());
    $result = [];
    foreach ($listeusager as $row) {
        array_push($result, array('id_usager' => $row['id_usager'], 'civilite' => $row['civilite'], 'nom' => $row['nom'], 'prenom' => $row['prenom'], 'sexe' => $row['sexe'], 'adresse' => $row['adresse'],  'code_postal' => $row['code_postal'],  'ville' => $row['ville'], 'date_nais' => $row['date_nais'], 'lieu_nais' => $row['lieu_nais'], 'num_secu' => $row['num_secu']));
    }
    return $result;
}

function unusager($nom)
{
    $BD = connexionBD();
    $nom = htmlspecialchars($nom);
    $Unusager = $BD->prepare('SELECT * from usager WHERE nom = ?');
    $Unusager->execute(array($nom));
    $BD = null;
    $result = [];
    foreach ($Unusager as $row) {
        array_push($result, array('id_usager' => $row['id_usager'], 'civilite' => $row['civilite'], 'nom' => $row['nom'], 'prenom' => $row['prenom'], 'sexe' => $row['sexe'], 'adresse' => $row['adresse'],  'code_postal' => $row['code_postal'],  'ville' => $row['ville'], 'date_nais' => $row['date_nais'], 'lieu_nais' => $row['lieu_nais'], 'num_secu' => $row['num_secu']));
    }
    return $result;
}

function ajouterusager($civilite, $nom, $prenom, $sexe, $adresse, $code_postal, $ville, $date_nais, $lieu_nais, $num_secu)
{
    $BD = connexionBD();
    if (!empty($civilite) && !empty($nom) && !empty($prenom) && !empty($sexe) && !empty($adresse) && !empty($code_postal) && !empty($ville) && !empty($date_nais) && !empty($lieu_nais) && !empty($num_secu)) {
        $ajouterusager = $BD->prepare('INSERT INTO usager(civilite, nom, prenom, sexe, adresse, code_postal, ville, date_nais, lieu_nais, num_secu) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $ajouterusager->execute(array($civilite, $nom, $prenom, $sexe, $adresse, $code_postal, $ville, $date_nais, $lieu_nais, $num_secu));
        $BD = null;
        if ($ajouterusager->rowCount() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    } else {
        return FALSE;
    }

}

function supprimerusager($id_usager)
{
    $BD = connexionBD();
    $id_usager = htmlspecialchars($id_usager);
    $supprimerusager = $BD->prepare('DELETE FROM usager where id_usager = ?');
    $supprimerusager->execute(array($id_usager));
    $BD = null;
    if ($supprimerusager->rowCount() > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function modifierusager($civilite, $nom, $prenom, $sexe, $adresse, $code_postal, $ville, $date_nais, $lieu_nais, $num_secu, $id_usager)
{
    $BD = connexionBD();
    $id_usager = htmlspecialchars($id_usager);
    $civilite = htmlspecialchars($civilite);
    $nom = htmlspecialchars($nom);
    $prenom = htmlspecialchars($prenom);
    $sexe = htmlspecialchars($sexe);
    $adresse = htmlspecialchars($adresse);
    $code_postal = htmlspecialchars($code_postal);
    $ville = htmlspecialchars($ville);
    $date_nais = htmlspecialchars($date_nais);
    $lieu_nais = htmlspecialchars($lieu_nais);
    $num_secu = htmlspecialchars($num_secu);
    $modifierusager = $BD->prepare('UPDATE usager SET civilite = ?, nom = ?, prenom = ?, sexe = ?, adresse = ?, code_postal = ?, ville = ?, date_nais = ?, lieu_nais = ?, num_secu = ? WHERE id_usager = ?');
    $modifierusager->execute(array($civilite, $nom, $prenom, $sexe, $adresse, $code_postal, $ville, $date_nais, $lieu_nais, $num_secu, $id_usager));
    $BD = null;
    if ($modifierusager->rowCount() > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function usagerExisteDeja($num_secu)
{
    $BD = connexionBD();
    $num_secu = htmlspecialchars($num_secu);
    $usagerExiste = $BD->prepare('SELECT * FROM usager WHERE num_secu = ?');
    $usagerExiste->execute(array($num_secu));
    $BD = null;
    if ($usagerExiste->rowCount() > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

/////////////////////////////////////////////////////////////////////////////
////////////////////         GESTION DES MEDECINS        ////////////////////
/////////////////////////////////////////////////////////////////////////////

function listeMedecin()
{
    $BD = connexionBD();
    $listeMedecin = $BD->prepare('SELECT * from medecin');
    $listeMedecin->execute(array());
    $BD = null;
    $result = [];
    foreach ($listeMedecin as $row) {
        array_push($result, array('id_medecin' => $row['id_medecin'], 'civilite' => $row['civilite'], 'nom' => $row['nom'], 'prenom' => $row['prenom'], 'id_utilisateur' => $row['id_utilisateur']));
    }

    return $result;
}

function unMedecin($id_medecin)
{
    $BD = connexionBD();
    $UnMedecin = $BD->prepare('SELECT * FROM medecin WHERE id_medecin = ?');
    $UnMedecin->execute(array($id_medecin));
    $BD = null;
    $result = [];
    foreach ($UnMedecin as $row) {
        array_push($result, array('civilite' => $row['civilite'], 'nom' => $row['nom'], 'prenom' => $row['prenom'], 'id_utilisateur' => $row['id_utilisateur']));
    }

    return $result;
}

function listeMedecinID($id_medecin){
    $BD= connexionBD();
    $listeIDMedecin = $BD ->prepare('SELECT id_medecin FROM medecin');
    $listeIDMedecin ->execute(array($id_medecin));
    $BD = null;
    $result =[];

    foreach ($listeIDMedecin as $row) {
        array_push($result, array('ID du Médecin' => $row['id_medecin']));
    }

    return $result;
 }

function ajouterMedecin($civilite, $nom, $prenom, $utilisateur)
{
    try {
        $BD = connexionBD();
        $civilite = htmlspecialchars($civilite);
        $nom = htmlspecialchars($nom);
        $prenom = htmlspecialchars($prenom);

        $BD->beginTransaction();
        $ajoutUtilisateur = $BD->prepare('INSERT INTO utilisateur(nom_utilisateur,mdp,id_role) VALUES (?,?,?)');
        $ajoutUtilisateur->execute(array($utilisateur['nom_utilisateur'], $utilisateur['mdp'], $utilisateur['id_role']));
        $id_utilisateur = $BD->lastInsertId();

        if (!empty($civilite) && !empty($nom) && !empty($prenom)) {
            $ajoutMedecin = $BD->prepare('INSERT INTO medecin(civilite,nom,prenom,id_utilisateur) VALUES (?,?,?,?)');
            $ajoutMedecin->execute(array($civilite, $nom, $prenom, $id_utilisateur));

            $BD->commit();

            if ($ajoutMedecin->rowCount() > 0) {
                $BD = null;
                return TRUE;
            } else {
                $BD->rollBack();
                $BD = null;
                return FALSE;
            }
        } else {
            $BD->rollBack();
            $BD = null;
            return FALSE;
        }
    } catch (PDOException $e) {
        $BD->rollBack();
        $BD = null;
        return FALSE;
    }
}


function supprimerMedecin($id_medecin)
{
    $BD = connexionBD();
    $id_medecin = htmlspecialchars($id_medecin);
    $supprimerMedecin = $BD->prepare('DELETE from medecin where id_medecin = ?');
    $supprimerMedecin->execute(array($id_medecin));
    $BD = null;
    if ($supprimerMedecin->rowCount() > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function modifierMedecin($id_medecin, $civilite, $nom, $prenom)
{
    $BD = connexionBD();
    $id_medecin = htmlspecialchars($id_medecin);
    $civilite = htmlspecialchars($civilite);
    $nom = htmlspecialchars($nom);
    $prenom = htmlspecialchars($prenom);
    $modifierMedecin = $BD->prepare('UPDATE medecin SET civilite = ?, nom = ?, prenom = ? WHERE id_medecin = ?');
    $modifierMedecin->execute(array($id_medecin, $civilite, $nom, $prenom));
    if ($modifierMedecin->rowCount() > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function MedecinExisteDeja($nom)
{
    $BD = connexionBD();
    $nom = htmlspecialchars($nom);
    $MedecinExiste = $BD->prepare('SELECT * FROM medecin WHERE nom= ?');
    $MedecinExiste->execute(array($nom));
    $BD = null;
    if ($MedecinExiste->rowCount() > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}




/////////////////////////////////////////////////////////////////////////////
////////////////////       GESTION DES CONSULTATIONS     ////////////////////
/////////////////////////////////////////////////////////////////////////////

function listeConsultation()
{
    $BD = connexionBD();
    $listeConsultation = $BD->prepare('SELECT * from consultation');
    $listeConsultation->execute(array());
    $BD = null;
    $result = [];

    foreach ($listeConsultation as $row) {
        $formattedDate = date('d-m-Y', strtotime($row['date_consult']));
        array_push(
            $result,
            array(
                'Jour du rendez-vous' => $formattedDate,
                'Heure du rendez-vous' => $row['heure_consult'],
                'Durée du Rendez-Vous' => $row['duree_consult'],
                'id_medecin' => $row['id_medecin'],
                'id_consult' => $row['id_consult']
            )
        );
    }

    return $result;
}

function uneConsultation($id_consult)
{
    $BD = connexionBD();
    $id_consult = htmlspecialchars($id_consult);
    $uneConsultation = $BD->prepare('SELECT * FROM consultation WHERE id_consult = ?');
    $uneConsultation->execute(array($id_consult));
    $BD = null;
    $result = [];

    foreach ($uneConsultation as $row) {
        $formattedDate = date('d-m-Y', strtotime($row['date_consult']));
        array_push(
            $result,
            array(
                'Jour du rendez-vous' => $formattedDate,
                'Heure du rendez-vous' => $row['heure_consult'],
                'Durée du Rendez-Vous' => $row['duree_consult'],
                'id_medecin' => $row['id_medecin']
            )
        );
    }

    return $result;
}


function listeConsultationDuJour()
{
    $BD = connexionBD();

    setlocale(LC_TIME, 'fr_FR');
    $dateDuJour = (new DateTime())->format('d-m-Y');

    $listeConsultationDuJour = $BD->prepare('SELECT * FROM consultation WHERE date_consult = STR_TO_DATE(?, "%d-%m-%Y")');
    $listeConsultationDuJour->execute(array($dateDuJour));
    $BD = null;
    $result = [];

    foreach ($listeConsultationDuJour as $row) {

        array_push(
            $result,
            array(
                'Date du rendez-vous' => (new DateTime($row['date_consult']))->format('d-m-Y'),
                'Heure du rendez-vous' => $row['heure_consult'],
                'Durée du rendez-vous' => $row['duree_consult']
            )
        );
    }

    return $result;

}



function ajouterConsultation($date_consult, $heure_consult, $duree_consult, $id_medecin, $id_usager)
{
    $BD = connexionBD();
    $date_consult = htmlspecialchars($date_consult);
    $heure_consult = htmlspecialchars($heure_consult);
    $duree_consult = htmlspecialchars($duree_consult);
    $id_medecin = htmlspecialchars($id_medecin);
    $id_usager = htmlspecialchars($id_usager);
    $ajouterConsultation = $BD->prepare('INSERT INTO consultation (date_consult, heure_consult, duree_consult, id_medecin, id_usager) VALUES (?, ?, ?, ?, ?)');

    // Exécution de la requête préparée
    $success = $ajouterConsultation->execute(array(clean($date_consult), clean($heure_consult), clean($duree_consult), clean($id_medecin), clean($id_usager)));

    $BD = null;

    // Vérification du succès de l'exécution
    if ($success) {
        return true;
    } else {
        return false;
    }
}


function modifierConsultation($id_consult, $date_consult, $heure_consult, $duree_consult, $id_medecin, $id_usager)
{
    $BD = connexionBD();
    $id_usager = htmlspecialchars($id_usager);
    $date_consult = htmlspecialchars($date_consult);
    $heure_consult = htmlspecialchars($heure_consult);
    $duree_consult = htmlspecialchars($duree_consult);
    $id_medecin = htmlspecialchars($id_medecin);
    $modifierconsultation = $BD->prepare('UPDATE consultation SET date_consult = ?, heure_consult = ?, duree_consult = ? , id_medecin = ?, id_usager = ? WHERE id_consult = ?');
    $modifierconsultation->execute(array($date_consult, $heure_consult, $duree_consult, $id_medecin, $id_usager, $id_consult));
    $BD = null;
    if ($modifierconsultation->rowCount() > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function supprimerConsultation($id_consult)
{
    $BD = connexionBD();
    $id_consult = htmlspecialchars($id_consult);
    $supprimerConsultation = $BD->prepare('DELETE from consultation WHERE id_consult = ?');
    $supprimerConsultation->execute(array($id_consult));
    $BD = null;
    if ($supprimerConsultation->rowCount() > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function ConsultationDejaExistante($id_consult, $date_consult, $heure_consult, $duree_consult, $id_medecin, $id_usager)
{
    $BD = connexionBD();
    $id_consult = htmlspecialchars($id_consult);
    $date_consult = htmlspecialchars($date_consult);
    $heure_consult = htmlspecialchars($heure_consult);
    $duree_consult = htmlspecialchars($duree_consult);
    $id_medecin = htmlspecialchars($id_medecin);
    $id_usager = htmlspecialchars($id_usager);
    $consultationExiste = $BD->prepare('SELECT * FROM consultation WHERE id_consult = ? AND date_consult = ? AND heure_consult = ? AND duree_consult = ? AND id_medecin = ? AND id_usager = ?');
    $consultationExiste->execute(array($date_consult, $heure_consult, $duree_consult, $id_medecin, $id_usager));
    $BD = null;

    if ($consultationExiste->rowCount() > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}


/////////////////////////////////////////////////////////////////////////////
////////////////////       GESTION DES STATISTISQUES     ////////////////////
/////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////////
////////////////////             GESTION API             ////////////////////
/////////////////////////////////////////////////////////////////////////////


function deliver_response($status, $status_message, $data)
{
    header("HTTP/1.1 $status $status_message");
    $response['status'] = $status;
    $response['status_message'] = $status_message;
    $response['data'] = $data;
    $json_response = json_encode($response);
    echo $json_response;
}

function get_body_token(string $bearer_token): array
{
    $tokenParts = explode('.', $bearer_token);
    $payload = base64_decode($tokenParts[1]);
    return (array) json_decode($payload);
}

function is_connected(): void
{
    if (1 == 2) {
        throw new ExceptionLoginRequire();
    }
}

//function action_permited(string $action, string $ressource, int $id = null) : void
function action_permited(): void
{
    if (1 == 2) {
        throw new ExceptionIssuficiantPermission();
    }
}
