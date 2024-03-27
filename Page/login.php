<?php
require_once("../CabMed/jwt_utils.php");
require_once("../CabMed/fonctions.php");

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
    <title>Page d'Authentification</title>
    <link rel="stylesheet" href="../Css/utilisateur.css">
</head>
<body>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <h2>Connexion</h2>
        <label class="label-connexion" for="nom_utilisateur">utilisateur :</label>
        <input class="input-connexion" type="text" id="nom_utilisateur" name="nom_utilisateur" placeholder="Votre utilisateur" required>

        <label class="label-connexion" for="mdp">Mot de passe :</label>
        <input class="input-connexion" type="password" id="mdp" name="mdp" placeholder="Votre mot de passe" required>

        <button class="button-connexion" type="submit">Se Connecter</button>

        <?php
    // Afficher le message d'erreur s'il existe
    if (!empty($erreur_message)) {
        echo '<p style="color: red;">' . $erreur_message . '</p>';
    }
    ?>
    </form>

</body>
</html>
