<?php

/////////////////////////////////////////////////////////////////////////////
////////////////////   CONNEXION A LA BASE DE DONNEES    ////////////////////
/////////////////////////////////////////////////////////////////////////////

function connexionBD(){
    $host = 'localhost';
    $db = 'medecin';
    $user = 'root';
    $pass = ' ';
    try{
        $BD = new PDO("mysql:host=$host;dbname=$db",$user,$pass);
    }catch(PDOException $e){
        die('Erreur : '.$e->getMessage());
    }
    return $BD;

}
function identification($login, $password) {
    $login = htmlspecialchars($login);
    $password = htmlspecialchars($password);
    $BD = connexionBD();



}

/////////////////////////////////////////////////////////////////////////////
////////////////////    GESTION DES AUTHENTIFICATIONS    ////////////////////
/////////////////////////////////////////////////////////////////////////////

function estConnecte() {

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
    $supprimerPatient = $BD->prepare('DELETE patient where id_Patient = ?');
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

function ajouterMedecin() {
    $BD = connexionBD();
}

function supprimerMedecin($idMedecin) {
    $BD = connexionBD();
    $idMedecin = htmlspecialchars($idMedecin);
    $supprimerMedecin = $BD->prepare('DELETE medecin from id_Medecin where id_Medecin = ?');
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
    $supprimerConsulation = $BD->prepare('DELETE consultation from id_Consultation');
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