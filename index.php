<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cabinet Médical - Accueil</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <?php include 'header.php'; ?>

    <?php
require_once("calendrier.php");

calendrier(date("n"),date("Y"));

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



