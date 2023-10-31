<?php

/////////////////////////////////////////////////////////////////////////////
////////////////////   CONNEXION A LA BASE DE DONNEES    ////////////////////
/////////////////////////////////////////////////////////////////////////////

function connexionBD(){
    try{
        $BD = new PDO("mysql:host=localhost;dbname=medecin",'utilisateur','password');
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
}

function supprimerPatient($idPatient){
    $BD = connexionBD();
}

function modifierPatient(){
    $BD = connexionBD();
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

function supprimerConsulation() {
    $BD = connexionBD();
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