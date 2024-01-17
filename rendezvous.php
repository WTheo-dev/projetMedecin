<?php
// votre_script_php.php

// Fonction pour récupérer les rendez-vous du jour
function getRendezVous($day) {
    // Ici, vous devez faire une requête à votre base de données pour obtenir les rendez-vous du jour
    // La structure de la requête dépendra de la façon dont vous stockez les rendez-vous dans votre base de données
    // Assurez-vous de sécuriser votre code pour éviter les injections SQL
    // ...

    // Exemple de réponse formatée en JSON
    $rendezVous = [
        ["heure" => "09:00", "nom" => "Doe", "prenom" => "John"],
        ["heure" => "10:30", "nom" => "Smith", "prenom" => "Jane"],
        // ... autres rendez-vous
    ];

    echo json_encode($rendezVous);
}

// Fonction pour ajouter un nouveau rendez-vous
function ajouterRendezVous($heure, $nom, $prenom) {
    // Ici, vous devez faire une requête à votre base de données pour ajouter le nouveau rendez-vous
    // La structure de la requête dépendra de la façon dont vous stockez les rendez-vous dans votre base de données
    // Assurez-vous de sécuriser votre code pour éviter les injections SQL
    // ...

    // Exemple de réponse formatée en JSON
    $response = ["message" => "Rendez-vous ajouté avec succès.", "day" => date("Y-m-d")];
    echo json_encode($response);
}

// Gestion des actions
$action = isset($_POST['action']) ? $_POST['action'] : '';

switch ($action) {
    case 'getRendezVous':
        $day = isset($_GET['day']) ? $_GET['day'] : date("Y-m-d");
        getRendezVous($day);
        break;

    case 'ajouterRendezVous':
        $heure = isset($_POST['heure']) ? $_POST['heure'] : '';
        $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
        $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
        ajouterRendezVous($heure, $nom, $prenom);
        break;

    // Ajoutez d'autres cas pour d'autres actions si nécessaire

    default:
        // Cas par défaut
        echo json_encode(["message" => "Action non reconnue."]);
        break;
}
?>
