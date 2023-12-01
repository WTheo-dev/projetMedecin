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
}

function ajouterPatient($civilité,$nom, $prenom) {
    $BD = connexionBD();
    $addPatient = $BD->prepare('INSERT INTO patient ');
    $addPatient->execute(array());
}

function supprimerPatient($idPatient){
    $BD = connexionBD();
    $idPatient = htmlspecialchars($idPatient);
    $supprimerPatient = $BD->prepare('DELETE FROM patient where Id_patient = ?');
    $supprimerPatient->execute(array($idPatient));
    $BD = null;
    if ($supprimerPatient->rowCount() > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function modifierPatient($idPatient){
    $BD = connexionBD();
    $idPatient = htmlspecialchars($idPatient);
    $modifierPatient = $BD->prepare('UPDATE INTO patient');
    $modifierPatient-> execute(array($idPatient));
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
}

function ajouterMedecin($Civilité, $Nom, $Prénom, $medecin) {
    $BD = connexionBD();
    $ajouterMedecin = $BD -> prepare('INSERT INTO medecin(Civilité, Nom, Prénom) VALUES (?, ?, ?, ?)');
    $ajouterMedecin -> execute(array(($medecin),$Civilité, $Nom, $Prénom));
    $BD = null;
    if ($ajouterMedecin == null) {
        return TRUE;
    } else {
        return FALSE;
    }
}


function supprimerMedecin($idMedecin) {
    $BD = connexionBD();
    $idMedecin = htmlspecialchars($idMedecin);
    $supprimerMedecin = $BD->prepare('DELETE from medecin where id_medecin = ?');
    $supprimerMedecin->execute(array($idMedecin));
    $BD = null;
    if ($supprimerMedecin->rowCount() > 0) {
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

function affichageConsultation() {
    $BD = connexionBD();
    $listeConsultation = $BD->prepare('SELECT * from rendezvous');
    $listeConsultation -> execute(array());
    $BD = null;
    if ($listeConsultation == null) {
        return TRUE;
    } else {
        return FALSE;
    }
}


function ajouterConsultation() {
    $BD = connexionBD();
}

function modifierConsultation() {
    $BD = connexionBD();
}

function modifierConsultationExistante() {
    $BD = connexionBD();
}

function supprimerConsulation($idConsultation) {
    $BD = connexionBD();
    $idConsultation = htmlspecialchars($idConsultation);
    $supprimerConsulation = $BD->prepare('DELETE from rendezvous from id_Consultation');
    $supprimerConsulation->execute(array($idConsultation));
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