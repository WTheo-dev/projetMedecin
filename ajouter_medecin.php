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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupérer les données du formulaire
        $civility = isset($_POST["civility"]) ? $_POST["civility"] : '';
        $firstName = $_POST["first_name"];
        $lastName = $_POST["last_name"];

        // Valider les données
        $errors = array();

        if (empty($civility) || empty($firstName) || empty($lastName)) {
            $errors[] = "Veuillez remplir tous les champs.";
        }

        // Si aucune erreur, alors insérer les données dans l'API REST
        if (empty($errors)) {
            try {
                $apiUrl = 'http://localhost/projetMedecin/API_Medecin/APIMedecin.php'; // Remplacez par l'URL de votre API
                $apiData = array(
                    'civilite' => $civility,
                    'nom' => $lastName,
                    'prenom' => $firstName,
                    // Ajoutez d'autres clés et valeurs nécessaires pour votre API
                );

                $ch = curl_init($apiUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($apiData));
                curl_setopt($ch, CURLOPT_POST, 1);

                $apiResponse = curl_exec($ch);
                $apiStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                curl_close($ch);

                // Vérifiez la réponse de l'API et affichez le message approprié
                if ($apiStatusCode == 200) {
                    echo "Médecin ajouté avec succès.";
                } else {
                    echo "Erreur lors de l'ajout du médecin via l'API. Code de statut : $apiStatusCode";
                }
            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }
        } else {
            // Afficher les erreurs
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
        }
    }
    ?>

    <h2>Ajouter Médecin</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Civilité:
        <input type="radio" name="civility" value="M" id="civility_m" checked>
        <label for="civility_m">M</label>
        
        <input type="radio" name="civility" value="Mme" id="civility_mme">
        <label for="civility_mme">Mme</label>
        <br>

        Prénom: <input type="text" name="first_name"><br>
        Nom: <input type="text" name="last_name"><br>

        <input type="submit" value="Ajouter Médecin">
    </form>

</body>
</html>
