<?php

require_once("./CabMed/jwt_utils.php");
require_once("./CabMed/fonctions.php");

$header = array("alg" => "HS256", "typ" => "JWT");
$key = "pass";
session_start();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $nom_utilisateur = isset($_POST['nom_utilisateur']) ? $_POST['nom_utilisateur'] : '';
        $mdp = isset($_POST['mdp']) ? $_POST['mdp'] : '';

        if (empty($nom_utilisateur) || empty($mdp)) {
            throw new Exception("Veuillez remplir tous les champs du formulaire.");
        }

        if (identification($nom_utilisateur, $mdp)) {
            $duree = 2592000;
            $body = array(
                "role" => recuperation_role($nom_utilisateur),
                "utilisateur" => $nom_utilisateur,
                "exp" => (time() + $duree)
            );

            $token = generate_jwt($header, $body, $key);

            $_SESSION['jwt_token'] = $token;

            header("Location: index.php");
            exit;
        } else {
            throw new Exception("Identifiant incorrect. Veuillez vérifier vos informations de connexion.");
        }
    } catch (Exception $e) {
        $erreur_message = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Connexion</title>
    <link rel="stylesheet" href="style.css"> 
</head>

<body class="body-connexion">

    <h1 class="h1-connexion">Se connecter</h1>

    <form class="form-connexion" method="post">
        <?php if (isset($erreur_message)) { ?>
            <p class="erreur-message"><?php echo $erreur_message; ?></p>
        <?php } ?>

        <label class="label-connexion" for="username">Login :</label>
        <input class="input-connexion" type="text" id="nom_utilisateur" name="nom_utilisateur" placeholder="Votre login" required>

        <label class="label-connexion" for="password">Mot de passe :</label>
        <input class="input-connexion" type="password" id="mdp" name="mdp" placeholder="Votre mot de passe" required>

        <button class="button-connexion" type="submit">Se Connecter</button>
    </form>

</body>
</html>
