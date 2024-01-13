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

function identification($login, $password){
    $login = htmlspecialchars($login);
    $password = htmlspecialchars($password);
    $BD = connexionBD();
    $verificationMembre = $BD->prepare('SELECT * FROM utilisateur WHERE nom_utilisateur = ? AND mdp = ?');
    $verificationMembre->execute(array($login, $password));
    $BD = null;
    if($verificationMembre->rowCount() > 0){
        return TRUE;
    }else{
        return FALSE;
    } 
}

function  recuperation_role($login)  {
    $BD = connexionBD();
    $recuperationRoleMembre = $BD->prepare('SELECT id_role FROM utilisateur WHERE nom_utilisateur = ?');
    $recuperationRoleMembre->execute(array($login));
    $BD = null;
    if($recuperationRoleMembre->rowCount() > 0){
        foreach($recuperationRoleMembre as $row){
            return $row['id_role'];
        }
    }else{
        return FALSE;
    } 
}

/////////////////////////////////////////////////////////////////////////////
////////////////////       GESTION DES PATIENTS          ////////////////////
/////////////////////////////////////////////////////////////////////////////

function listePatient(){
    $BD = connexionBD();
    $listePatient = $BD->prepare('SELECT * from patient');
    $listePatient ->execute(array());
    $result = [];
    foreach($listePatient as $row) {
        array_push($result, array('num_secu' => $row['num_secu'], 'civilite' => $row['civilite'], 'nom' => $row['nom'], 'prenom' => $row['prenom'], 'adresse' => $row['adresse'], 'date_naissance' => $row['date_naissance'], 'lieu_naissance' => $row['lieu_naissance'], 'id_patient'=> $row['id_patient']));
    }
    return $result;
}

function unPatient($nom) {
    $BD = connexionBD();
    $nom = htmlspecialchars($nom);
    $UnPatient = $BD ->prepare('SELECT * from patient WHERE nom = ?');
    $UnPatient -> execute(array($nom));
    $BD = null;
    $result = [];
    foreach($UnPatient as $row) {
        array_push($result, array('num_secu' => $row['num_secu'], 'civilite' => $row['civilite'], 'nom' => $row['nom'], 'prenom' => $row['prenom'], 'adresse' => $row['adresse'], 'date_naissance' => $row['date_naissance'], 'lieu_naissance' => $row['lieu_naissance'], 'id_patient'=> $row['id_patient']));
    }
    return $result;
}

function ajouterPatient($num_secu, $civilite,$nom, $prenom, $adresse, $date_naissance, $lieu_naissance) {
    $BD = connexionBD();
    if (!empty($num_secu) && !empty($civilite) && !empty($nom) && !empty($prenom) && !empty($adresse) && !empty($date_naissance) && !empty($lieu_naissance)) {
        $ajouterPatient = $BD -> prepare('INSERT INTO patient(num_secu, civilite, nom, prenom, adresse, date_naissance, lieu_naissance VALUES (?, ?, ?, ?, ?, ?, ?)');
        $ajouterPatient -> execute(array($num_secu, $civilite,$nom, $prenom, $adresse, $date_naissance, $lieu_naissance));
        $BD = null;
        if($ajouterPatient -> rowCount() > 0 ) {
            return TRUE; 
        } else {
            return FALSE;
        }
    } else {
        return FALSE;
    }

}

function supprimerPatient($id_patient){
    $BD = connexionBD();
    $id_patient = htmlspecialchars($id_patient);
    $supprimerPatient = $BD->prepare('DELETE FROM patient where id_patient = ?');
    $supprimerPatient->execute(array($id_patient));
    $BD = null;
    if ($supprimerPatient->rowCount() > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function modifierPatient($id_patient, $num_secu, $civilite,$nom, $prenom, $adresse, $date_naissance, $lieu_naissance){
    $BD = connexionBD();
    $id_patient = htmlspecialchars($id_patient);
    $num_secu = htmlspecialchars($num_secu);
    $civilite = htmlspecialchars($civilite);
    $nom = htmlspecialchars($nom);
    $prenom = htmlspecialchars($prenom);
    $adresse = htmlspecialchars($adresse);
    $date_naissance = htmlspecialchars($date_naissance);
    $lieu_naissance = htmlspecialchars($lieu_naissance);
    $modifierPatient = $BD->prepare('UPDATE patient SET num_secu = ?, civilite = ?, nom = ?, prenom = ?, adresse = ?, date_naissance = ?, lieu_naissance = ? WHERE id_patient = ?');
    $modifierPatient->execute(array($num_secu, $civilite, $nom, $prenom, $adresse, $date_naissance, $lieu_naissance, $id_patient));
    $BD = null;
    if($modifierPatient->rowCount() > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

/////////////////////////////////////////////////////////////////////////////
////////////////////         GESTION DES MEDECINS        ////////////////////
/////////////////////////////////////////////////////////////////////////////

function listeMedecin() {
    $BD = connexionBD();
    $listeMedecin = $BD->prepare('SELECT * from medecin');
    $listeMedecin -> execute(array());
    $BD = null;
    $result = [];
    foreach($listeMedecin as $row) {
        array_push($result, array('civilite' =>$row['civilite'], 'nom' =>$row['nom'], 'prenom' =>$row['prenom'],'id_utilisateur'=>$row['id_utilisateur']));
    }

    return $result;
}

function unMedecin($id_medecin) {
    $BD = connexionBD();
    $UnMedecin = $BD ->prepare('SELECT * FROM medecin WHERE id_medecin = ?');
    $UnMedecin ->execute(array($id_medecin));
    $BD = null;
    $result = [];
    foreach($UnMedecin as $row) {
        array_push($result, array('civilite' =>$row['civilite'], 'nom' =>$row['nom'], 'prenom' =>$row['prenom'],'id_utilisateur'=>$row['id_utilisateur']));
    }

    return $result;
}
function ajouterMedecin($civilite, $nom, $prenom) {
    $BD = connexionBD();
    $ajouterMedecin = $BD -> prepare('INSERT INTO medecin(civilite, nom, prenom) VALUES (?, ?, ?, ?)');
    $ajouterMedecin -> execute(array($civilite, $nom, $prenom));
    $BD = null;
    if ($ajouterMedecin == null) {
        return TRUE;
    } else {
        return FALSE;
    }
}


function supprimerMedecin($id_medecin) {
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

function modifierMedecin($id_medecin, $civilite, $nom, $prenom) {
    $BD = connexionBD();
    $id_medecin = htmlspecialchars($id_medecin);
    $civilite = htmlspecialchars($civilite);
    $nom = htmlspecialchars($nom);
    $prenom = htmlspecialchars($prenom);
    $modifierMedecin = $BD ->prepare('UPDATE medecin SET civilite = ?, nom = ?, prenom = ? WHERE id_medecin = ?');
    $modifierMedecin ->execute(array($id_medecin, $civilite, $nom, $prenom));
    if ($modifierMedecin ->rowCount() > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}
function ajouterMedecinReferent(){
    $BD = connexionBD();
}



/////////////////////////////////////////////////////////////////////////////
////////////////////       GESTION DES RENDEZ-VOUS       ////////////////////
/////////////////////////////////////////////////////////////////////////////

function listeConsultation() {
    $BD = connexionBD();
    $listeConsultation = $BD->prepare('SELECT * from rendezvous');
    $listeConsultation -> execute(array());
    $BD = null;
    $result = [];
    foreach($listeConsultation as $row) {
        array_push($result, array('Jour et Heure du rendez-vous' =>$row['dateheure_rdv'], 'Durée du Rendez-Vous' =>$row['duree_rdv'], 'id_medecin' =>$row['id_medecin'],'id_rendezvous'=>$row['id_rendezvous']));
    }

    return $result;
}

function uneConsultation($id_rendezvous) {
    $BD = connexionBD();
    $id_rendezvous = htmlspecialchars($id_rendezvous);
    $uneConsultation = $BD->prepare('SELECT * FROM rendezvous WHERE id_rendezvous = ?');
    $uneConsultation -> execute(array($id_rendezvous));
    $BD = null;
    $result = [];
    foreach($uneConsultation as $row) {
        array_push($result, array('Jour et Heure du rendez-vous' =>$row['dateheure_rdv'], 'Durée du Rendez-Vous' =>$row['duree_rdv'], 'id_medecin' =>$row['id_medecin']));
    }

    return $result;
}

function ConsultationDuJour() {
    $BD = connexionBD();
    $consultationDuJour = $BD ->prepare('SELECT * FROM rendezvous WHERE date_rdv = ?');
    $consultationDuJour -> execute(array());
    $BD = null;
    $result = [];
    foreach($consultationDuJour as $row) {
        array_push($result, array('Jour du rendez-vous'=> $row['date_rdv'], 'Heure du rendez-vous' => $row['heure_rdv']));
    }
    return $result;
}


function ajouterConsultation() {
    $BD = connexionBD();
    $ajouterConsultation = $BD->prepare('INSERT INTO rendezvous(id_patient,id_rendezvous,dateheure_rdv,duree_rdv,id_medecin VALUES (?,?,?,?,?)');
    $ajouterConsultation ->execute(array());
    $BD = null;
    if ($ajouterConsultation==null) {
        return TRUE;
    } else {
        return FALSE;
    }
}


function modifierConsultation($id_rendezvous, $id_patient, $dateheure_rdv, $duree_rdv, $id_medecin) {
    $BD = connexionBD();
    $id_rendezvous = htmlspecialchars($id_rendezvous);
    $id_patient = htmlspecialchars($id_patient);
    $dateheure_rdv = htmlspecialchars($dateheure_rdv);
    $duree_rdv = htmlspecialchars($duree_rdv);
    $id_medecin = htmlspecialchars($id_medecin);
    $modifierRendezvous = $BD->prepare('UPDATE rendezvous SET id_patient = ?, dateheure_rdv = ?, duree_rdv = ? , id_medecin = ? WHERE id_rendezvous = ?');
    $modifierRendezvous -> execute(array($id_patient,$dateheure_rdv,$duree_rdv,$id_medecin, $id_rendezvous));
    $BD = null;
    if ($modifierRendezvous ->rowCount() > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function supprimerConsulation($id_rendezvous) {
    $BD = connexionBD();
    $id_rendezvous = htmlspecialchars($id_rendezvous);
    $supprimerConsulation = $BD->prepare('DELETE from rendezvous WHERE id_rendezvous = ?');
    $supprimerConsulation->execute(array($id_rendezvous));
    $BD = null;
    if($supprimerConsulation ->rowCount()> 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function filtreConsultation() {
    $BD = connexionBD();
}

function ChevauchementNonOK() {
    $BD = connexionBD();
}

/////////////////////////////////////////////////////////////////////////////
////////////////////       GESTION DES STATISTISQUES     ////////////////////
/////////////////////////////////////////////////////////////////////////////

function tempsTotalConsultation(){
    $BD = connexionBD();
}


/////////////////////////////////////////////////////////////////////////////
////////////////////             GESTION API             ////////////////////
/////////////////////////////////////////////////////////////////////////////


function deliver_response($status, $status_message, $data){
	header("HTTP/1.1 $status $status_message");
	$response['status'] = $status;
	$response['status_message'] = $status_message;
	$response['data'] = $data;
	$json_response = json_encode($response);
	echo $json_response;
}

function get_body_token(string $bearer_token) : array{
    $tokenParts = explode('.', $bearer_token);
    $payload = base64_decode($tokenParts[1]);
    return (array) json_decode($payload);
}

function is_connected() : void{
	if (1 == 2) {
		throw new ExceptionLoginRequire();
	}
}

//function action_permited(string $action, string $ressource, int $id = null) : void
function action_permited() : void{
	if (1 == 2) {
		throw new ExceptionIssuficiantPermission();
	}
}
?>