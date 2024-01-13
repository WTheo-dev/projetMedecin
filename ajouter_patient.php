<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Patient</title>
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
    $address = $_POST["address"];
    $birthDate = $_POST["birth_date"];
    $birthPlace = $_POST["birth_place"];
    $socialSecurityNumber = $_POST["social_security_number"];
    $doctorId = $_POST["medecin_id"]; // Nouveau champ pour le médecin référent

    // Initialiser un tableau pour stocker les erreurs
    $errors = array();

    // Valider les données
    if (empty($civility) || empty($firstName) || empty($lastName) || empty($address) || empty($birthDate) || empty($birthPlace) || empty($socialSecurityNumber) || empty($medecinId)) {
        $errors[] = "Veuillez remplir tous les champs.";
    }

    if (!is_numeric($socialSecurityNumber) || strlen($socialSecurityNumber) !== 14) {
        $errors[] = "Le numéro de sécurité sociale doit comporter exactement 14 chiffres et être composé uniquement de chiffres.";
    }

    // Si aucune erreur, alors insérer les données
    if (empty($errors)) {
        try {
            $pdo = new PDO("mysql:host=your_host;dbname=your_database", "your_username", "your_password");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO patients (civility, first_name, last_name, address, birth_date, birth_place, social_security_number, medecin_id)
                    VALUES (:civility, :first_name, :last_name, :address, :birth_date, :birth_place, :social_security_number, :medecin_id)";
            
            $stmt = $pdo->prepare($sql);
            
            $stmt->bindParam(':civility', $civility);
            $stmt->bindParam(':first_name', $firstName);
            $stmt->bindParam(':last_name', $lastName);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':birth_date', $birthDate);
            $stmt->bindParam(':birth_place', $birthPlace);
            $stmt->bindParam(':social_security_number', $socialSecurityNumber);
            $stmt->bindParam(':medecin_id', $medecinId);
            
            $stmt->execute();

            echo "Fiche patient créée avec succès.";

        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }

        $pdo = null; // Fermer la connexion à la base de données
    } else {
        // Afficher les erreurs
        foreach ($errors as $error) {
            echo $error . "<br>";
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
