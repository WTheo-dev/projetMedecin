<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Médecin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <?php include 'header.php'; ?>

    <?php
    session_start();
    if (isset($_SESSION['jwt_token'])) {
        $token = $_SESSION['jwt_token'];
        try {
            $api_url = "http://localhost/projetMedecin/API_Medecin/APIMedecin.php";
            
            $options = [
                'http' => [
                    'method' => 'POST',
                    'header' => 'Authorization: Medecin ' . $token,
                ],
            ];

            $context = stream_context_create($options);
            $response = file_get_contents($api_url, false, $context);

            $data = json_decode($response, true);
        }
        catch (Exception $e) {
            // Handle exceptions if any
            echo 'Error: ' . $e->getMessage();
        }
    } else {
        header('Location: connexion.php');
        exit();
    }
    ?>

    <h2>Ajouter Médecin</h2>

    <form method="POST" action="./API_Medecin/AjouterMedecin.php">
        Civilité:
        <input type="radio" name="civilite" value="M" id="civilite_m" checked>
        <label for="civilite_m">M</label>
        
        <input type="radio" name="civilite" value="Mme" id="civilite_mme">
        <label for="civilite_mme">Mme</label>
        <br>

        Prénom: <input type="text" name="prenom" required><br>
        Nom: <input type="text" name="nom" required><br>
        Nom d'utilisateur: <input type="text" name="nom_utilisateur" required><br>
        Mot de Passe: <input type="password" name="mdp"required><br>
        Rôle: <input type="number" name="id_role" min="1" max="2" required><br>


        <input type="submit" value="Ajouter Médecin">
    </form>

</body>
</html>
