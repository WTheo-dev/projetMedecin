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
////////////////////       GESTION DES PATIENTS          ////////////////////
/////////////////////////////////////////////////////////////////////////////

function listePatient(){

}

function ajouterPatient($civilité,$nom, $prenom) {
    
}

function supprimerPatient($idPatient){

}

function modifierPatient(){

}