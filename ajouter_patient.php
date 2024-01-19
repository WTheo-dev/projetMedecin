<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Patient</title>
    <link rel="stylesheet" href="ajouter_patient.css">
</head>

<body>

    <?php
    // Inclure la session PHP
    session_start();
    include 'header.php'; 

        // Traitement du formulaire lors de la soumission POST
        if (isset($_SESSION['jwt_token'])) {
            $token = $_SESSION['jwt_token'];

         
        } else {
             // Rediriger vers la page de connexion si le token n'est pas présent
        header('Location: connexion.php');
        exit();
        }
    
?>


    <h2>Formulaire Patient</h2>

    <form method="POST" action="./API_Medecin/APIPatient.php">
        <label for="civilite">Civilité:</label>
        <select name="civilite" required>
            <option value="M.">M.</option>
            <option value="Mme">Mme</option>
        </select><br>

        Prénom: <input type="text" name="prenom"><br>
        Nom: <input type="text" name="nom"><br>
        Adresse: <input type="text" name="adresse"><br>
        Date de naissance: <input type="date" name="date_naissance" max="<?php echo date('d-m-Y'); ?>"><br>
        Lieu de naissance: <input type="text" name="lieu_naissance"><br>
        Numéro de sécurité sociale: <input type="text" name="num_secu" maxlength="14" pattern="\d+"
            title="Entrez uniquement des chiffres"><br>

        Médecin Référent:
        <select name="id_medecin">
            <?php
            try {
                $api_url = "./API_Medecin/APIMedecin.php";
            
                $api_response = file_get_contents($api_url);
                $medecins = json_decode($api_response, true);
                echo '<script>console.log("medecins: ", ' . json_encode($medecins) . ')</script>';

            
                if ($medecins && is_array($medecins)) {
                    foreach ($medecins as $medecin) {
                        $option_value = $medecin['id_medecin'];
                        $display_text = $medecin['nom'] . ' ' . $medecin['prenom'];
            
                        echo "<option value='" . $option_value . "'>" . $display_text . "</option>";
                    }
                } else {
                    echo "<option value=''>Aucun médecin disponible</option>";
                }
            } catch (Exception $e) {
                echo "Erreur : " . $e->getMessage();
            }
            ?>
        </select>
        <br>
        <input type="submit" value="Enregistrer">
    </form>

</body>

</html>
