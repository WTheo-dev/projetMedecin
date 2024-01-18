<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cabinet Médical - Accueil</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
  
<?php 
session_start(); // Démarrer la session

// Vérifier si le token est présent dans la session
if (isset($_SESSION['token'])) {
    $token = $_SESSION['token'];
}

include 'header.php';
?>

<h1 class="titre"></h1>
<div class="erreur"></div>

<?php

require_once "API_Medecin/fonctions.php";
$medecins = listeMedecin();

echo '<div>';
echo '<select name="medecin" id="id_medecin">';
echo '<option value="all"> Liste des médecins </option>';

foreach ($medecins as $medecin) {
    echo '<option value="' . $medecin['id_medecin'] . '">';
    echo $medecin['civilite'] . ' ' . $medecin['nom'] . ' ' . $medecin['prenom'];
    echo '</option>';
}

echo '</select>';
echo '</div>';
?>

<?php
require_once("calendrier.php");
calendrier(date("n"), date("Y"), $id_medecin, $id_patient, $heure_rdv);
?>

<div id="myModal" class="modal">
    <div class="modal-content">
        <div id="modalContent"></div>
        <button onclick="closeModal()">Fermer</button>
        <button onclick="ajouterModal()"> Ajouter </button>
        <button onclick="modifierModal()"> Modifier </button>
        <button onclick="saveModal()"> Sauvegarder </button>
    </div>
</div>

</body>
</html>
