<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cabinet Médical - Médecins</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <h2>Liste des Médecins</h2>

    <?php
    // Connexion à la base de données
    try {
        $pdo = new PDO("mysql:host=your_host;dbname=your_database", "your_username", "your_password");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Requête SQL pour sélectionner tous les médecins
        $sql = "SELECT * FROM medecin";
        $stmt = $pdo->query($sql);

        // Vérifier s'il y a des résultats
        if ($stmt->rowCount() > 0) {
            // Afficher la liste des médecins dans un tableau
            echo "<a href='ajouter_medecin.php'><button>Ajouter un médecin</button></a>";
            echo "<table border='1'>";
            echo "<tr><th>Nom</th><th>Prénom</th><th>Actions</th></tr>";
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['last_name'] . "</td>";
                echo "<td>" . $row['first_name'] . "</td>";
                echo "<td>
                        <a href='modifier_medecin.php?id=" . $row['medecin_id'] . "'>Modifier</a>
                        <a href='supprimer_medecin.php?id=" . $row['medecin_id'] . "'>Supprimer</a>
                      </td>";
                echo "</tr>";
            }
            
            echo "</table>";
        } else {
            echo "Aucun médecin trouvé.";
        }

    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }

    // Fermer la connexion à la base de données
    $pdo = null;
    ?>
</body>
</html>
