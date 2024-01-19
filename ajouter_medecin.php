<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Médecin</title>
    <link rel="stylesheet" href="ajouter_medecin.css">
</head>
<body>
    
    <?php include 'header.php'; ?>

    <?php
session_start();

if (isset($_SESSION['jwt_token'])) {
    $token = $_SESSION['jwt_token'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupérer les données du formulaire
        $civilite = $_POST['civilite'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $nom_utilisateur = $_POST['nom_utilisateur'];
        $mdp = $_POST['mdp'];
        $id_role = $_POST['id_role'];

        try {
            $api_url = "http://localhost/projetMedecin/API_Medecin/APIMedecin.php";

            $options = [
                'http' => [
                    'header' => 'Content-type: application/x-www-form-urlencoded\r\n'
                                . 'Authorization: Medecin ' . $token,
                    'method' => 'POST',
                    'content' => http_build_query($data),
                ],
            ];

            $context = stream_context_create($options);
            $response = file_get_contents($api_url, false, $context);

            if ($response === false) {
                echo 'Erreur file_get_contents : ' . error_get_last()['message'];
            } else {
                $result = json_decode($response, true);

                // Traitez la réponse de l'API selon vos besoins
                if ($result['success']) {
                    echo 'Médecin ajouté avec succès.';
                } else {
                    echo 'Erreur lors de l\'ajout du médecin : ' . $result['message'];
                }
            }
        } catch (Exception $e) {
            echo 'Erreur: ' . $e->getMessage();
        }
    }
} else {
    header('Location: connexion.php');
    exit();
}
?>

    <h2>Ajouter Médecin</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="civilite">Civilité:</label>
        <select name="civilite" required>
            <option value="M.">M.</option>
            <option value="Mme">Mme</option>
            <!-- Ajouter d'autres options si nécessaire -->
        </select><br>

        <label for="nom">Nom:</label>
        <input type="text" name="nom" required><br>

        <label for="prenom">Prénom:</label>
        <input type="text" name="prenom" required><br>

        <label for="nom_utilisateur">Nom Utilisateur: </label>
        <input type ="text" name="nom_utilisateur" required><br>

        <label for="mdp">Mot de passe: </label>
        <input type ="password" name="mdp" required><br>

        <label for="id_role">ID_Role:</label>
        <select name="id_role" required>
            <option value="1">1</option>
            <option value="2">2</option>
            <!-- Ajouter d'autres options si nécessaire -->
        </select><br>

        <input type="submit" value="Ajouter Médecin">
    </form>

</body>
</html>
