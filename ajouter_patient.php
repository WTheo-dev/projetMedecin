<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Patient</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
// Inclure la session PHP
session_start();

// Inclure le fichier fonctions.php
include './API_Medecin/fonctions.php';

// Inclure le fichier d'en-tête
include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Traitement du formulaire lors de la soumission POST
    if (isset($_SESSION['token'])) {
        $token = $_SESSION['token'];

        // Récupérer les données du formulaire
        $civilite = $_POST['civilite'];
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $adresse = $_POST['adresse'];
        $date_naissance = $_POST['date_naissance'];
        $lieu_naissance = $_POST['lieu_naissance'];
        $num_secu = $_POST['num_secu'];
        $id_medecin = $_POST['id_medecin'];

        try {
            // Appeler la fonction de création de patient
            $response = ajouterPatient($civilite, $prenom, $nom, $adresse, $date_naissance, $lieu_naissance, $num_secu);

            // Gérer la réponse de la fonction (peut être un message de succès ou d'erreur)
            echo $response;
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
}
?>

<h2>Formulaire Patient</h2>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    Civilité:
    <input type="radio" name="civility" value="M" id="civility_m" checked>
    <label for="civility_m">M</label>
    
    <input type="radio" name="civility" value="Mme" id="civility_mme">
    <label for="civility_mme">Mme</label>
    <br>

    Prénom: <input type="text" name="first_name"><br>
    Nom: <input type="text" name="last_name"><br>
    Adresse: <input type="text" name="address"><br>
    Date de naissance: <input type="date" name="birth_date" max="<?php echo date('Y-m-d'); ?>"><br>
    Lieu de naissance: <input type="text" name="birth_place"><br>
    Numéro de sécurité sociale: <input type="text" name="social_security_number" maxlength="14" pattern="\d+" title="Entrez uniquement des chiffres"><br>
    
    <!-- Ajout du menu déroulant pour les médecins référents -->
    Médecin Référent:
    <select name="medecin_id">
        <?php
            // Récupérer la liste des médecins depuis la base de données
            try {
                $pdo = new PDO("mysql:host=your_host;dbname=your_database", "your_username", "your_password");
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = "SELECT * FROM doctors";
                $stmt = $pdo->query($sql);

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . $row['medecin_id'] . "'>" . $row['medecin_name'] . "</option>";
                }

            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }

            $pdo = null; // Fermer la connexion à la base de données
        ?>
    </select>
    <br>

    <input type="submit" value="Enregistrer">
</form>

</body>
</html>
