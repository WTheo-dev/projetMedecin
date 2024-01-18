<?php
session_start();
include_once('server.php');

// Si le formulaire de connexion est soumis
if (isset($_POST['nom_utilisateur']) && isset($_POST['mdp'])) {
    // Connexion et création du token
    connexion($_POST['nom_utilisateur'], $_POST['mdp']);
} else {
    // Affiche un message d'erreur si les champs ne sont pas définis
    echo "Veuillez remplir tous les champs du formulaire.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Médecin</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="body-connexion">

    <h1 class="h1-connexion">Se connecter</h1>

    <form class="form-connexion" method="post">
        <label  class="label-connexion" for="username">Login :</label>
        <input class="input-connexion" type="text" id="nom_utilisateur" name="nom_utilisateur" placeholder="Votre login" required>

        <label class="label-connexion" for="password">Mot de passe :</label>
        <input class="input-connexion" type="password" id="mdp" name="mdp" placeholder=" Votre mot de passe " required>

        <button class="button-connexion" type="submit">Se Connecter</button>
    </form>

</body>
</html>


