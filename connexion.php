<?php
// Inclure les dépendances nécessaires (jwt_utils.php et fonctions.php)
require_once("./API_Medecin/jwt_utils.php");
require_once("./API_Medecin/fonctions.php");

// Définir l'algorithme de signature, la clé secrète, et initialiser la session
$header = array("alg" => "HS256", "typ" => "JWT");
$key = "pass";
session_start();

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Récupérer les données du formulaire
        $nom_utilisateur = isset($_POST['nom_utilisateur']) ? $_POST['nom_utilisateur'] : '';
        $mdp = isset($_POST['mdp']) ? $_POST['mdp'] : '';

        // Vérifier les champs du formulaire
        if (empty($nom_utilisateur) || empty($mdp)) {
            throw new Exception("Veuillez remplir tous les champs du formulaire.");
        }

        // Vérifier les informations d'identification
        if (identification($nom_utilisateur, $mdp)) {
            // Créer le corps du JWT
            $duree = 2592000; // Durée du token en secondes (30 jours dans cet exemple)
            $body = array(
                "role" => recuperation_role($nom_utilisateur),
                "utilisateur" => $nom_utilisateur,
                "exp" => (time() + $duree)
            );

            // Générer le token JWT
            $token = generate_jwt($header, $body, $key);

            // Stocker le token dans la session
            $_SESSION['jwt_token'] = $token;

            // Rediriger vers index.php
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
