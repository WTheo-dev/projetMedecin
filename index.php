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
    include 'header.php'; 

    // Vérifier si le token est présent dans la session
    if (isset($_SESSION['jwt_token'])) {
        $token = $_SESSION['jwt_token'];
    } else { // Rediriger vers la page de connexion si le token n'est pas présent
        header('Location: connexion.php');
        exit();
    }
    ?>

    <h1 class="titre"></h1>
    <div class="erreur"></div>

    <?php

    require_once("./CabMed/fonctions.php");
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
    require_once("./CabMed/fonctions.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        try {
            $date_consult  = isset($_POST['date_consult']) ? $_POST['date_consult'] : '';
            $heure_consult = isset($_POST['heure_consult']) ? $_POST['heure_consult'] : '';
            $duree_consult = isset($_POST['duree_consult']) ? $_POST['duree_consult'] : '';
            $id_medecin    = isset($_POST['id_medecin']) ? $_POST['id_medecin'] : ''; 
            $id_usager     = isset($_POST['id_usager']) ? $_POST['id_usager'] : '';
    
            if (ConsultationDejaExistante($date_consult, $heure_consult, $duree_consult, $id_medecin, $id_usager)) {
                throw new Exception("Création impossible, consultation déjà existante pour le même médecin et patient à la même heure");
            } else {
                if (ajouterConsultation($data['id_consult'], $data['date_consult'], $data['heure_consult'], $data['duree_consult'], $data['id_medecin'], $data['id_usager'])) {
                    throw new Exception("Création du rendez-vous effectué");
                } else {
                    throw new Exception("Création impossible ou rendez-vous déjà existant");
                }
            }
        } catch (Exception $e) {
            $erreur_message = $e->getMessage();
        }
    }



    ?>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <div id="modalContent"></div>
            <button onclick="ajouterModal()"> Ajouter </button>
            <button onclick="modifierModal()"> Modifier </button>
            <button onclick="saveModal()"> Sauvegarder </button>
            <button onclick="closeModal()">Fermer</button>
        </div>
    </div>

</body>

</html>