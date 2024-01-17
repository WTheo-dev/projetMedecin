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

        // Si aucune erreur, alors insérer les données
        if (empty($errors)) {
            try {
                $pdo = new PDO("mysql:host=your_host;dbname=your_database", "your_username", "your_password");
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = "INSERT INTO medecin (civility, first_name, last_name)
                        VALUES (:civility, :first_name, :last_name)";
                
                $stmt = $pdo->prepare($sql);
                
                $stmt->bindParam(':civility', $civility);
                $stmt->bindParam(':first_name', $firstName);
                $stmt->bindParam(':last_name', $lastName);
                
                $stmt->execute();

                echo "Médecin ajouté avec succès.";

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
