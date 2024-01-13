<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cabinet Médical - Patients</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <h2>Liste des Patients</h2>

    <?php
    // Connexion à la base de données
    try {
        $pdo = new PDO("mysql:host=your_host;dbname=your_database", "your_username", "your_password");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Requête SQL pour sélectionner tous les patients
        $sql = "SELECT * FROM patients";
        $stmt = $pdo->query($sql);

        // Vérifier s'il y a des résultats
        if ($stmt->rowCount() > 0) {
            // Afficher la liste des patients dans un tableau
            echo "<a href='ajouter_patient.php'><button>Ajouter un patient</button></a>";
            echo "<table border='1'>";
            echo "<tr><th>Civilité</th><th>Prénom</th><th>Nom</th><th>Actions</th></tr>";
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['civility'] . "</td>";
                echo "<td>" . $row['first_name'] . "</td>";
                echo "<td>" . $row['last_name'] . "</td>";
                echo "<td>
                        <a href='modifier_patient.php?id=" . $row['patient_id'] . "'>Modifier</a>
                        <a href='supprimer_patient.php?id=" . $row['patient_id'] . "'>Supprimer</a>
                      </td>";
                echo "</tr>";
            }
            
            echo "</table>";
        } else {
            echo "Aucun patient trouvé.";
        }

    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }

    // Fermer la connexion à la base de données
    $pdo = null;
    ?>
</body>
</html>
