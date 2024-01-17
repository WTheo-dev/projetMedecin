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
  
<?php include 'header.php'; ?>

<h1 class="titre"></h1>
<div class="erreur"></div>

<div> 
    <select name="medecin" id="id_medecin">
        <option value="all"> Liste des médecins </option>
    </select> 
</div>


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



