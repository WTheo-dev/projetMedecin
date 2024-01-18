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
<?php
session_start();
include_once('./API_Medecin/fonctions.php');

// Si le formulaire de connexion est soumis
if (isset($_POST['nom_utilisateur']) && isset($_POST['mdp'])) {
    // Construit les données à envoyer à l'API
    $data = array(
        'nom_utilisateur' => $_POST['nom_utilisateur'],
        'mdp' => $_POST['mdp']
    );

    // Convertit les données en format JSON
    $json_data = json_encode($data);

    // URL de l'API
    $api_url = 'http://localhost/projetMedecin/API_Medecin/serveurToken.php';

    // Options pour la requête HTTP
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => $json_data,
        ),
    );

    // Crée le contexte pour la requête HTTP
    $context  = stream_context_create($options);

    // Effectue la requête HTTP et récupère la réponse
    $response = file_get_contents($api_url, false, $context);

    // Vérifie si la réponse est réussie
    if ($response !== false) {
        // Décoder la réponse JSON
        $token = json_decode($response, true);

        // Vérifie si la création du token a réussi
        if ($token) {
            // Stocke le token en session ou faites ce que vous devez faire avec le token
            $_SESSION['token'] = $token;

            // Redirige l'utilisateur vers la page souhaitée après la connexion
            header('Location: index.php');
            exit();
        } else {
            // Gestion des erreurs lors de la création du token
            echo "Erreur lors de la création du token. Veuillez réessayer.";
        }
    } else {
        // Gestion des erreurs lors de la requête HTTP
        echo "Erreur lors de la communication avec l'API. Veuillez réessayer.";
    }
} else {
    // Affiche un message d'erreur si les champs ne sont pas définis
    echo "Veuillez remplir tous les champs du formulaire.";
}
?>


