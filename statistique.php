<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques</title>
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
            margin: 20px;
        }

        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <h2>Statistiques</h2>

    <?php
    // Connexion à la base de données
    try {
        $pdo = new PDO("mysql:host=your_host;dbname=your_database", "your_username", "your_password");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Répartition des usagers selon leur sexe et leur âge
        $ageGroups = ["Moins de 25 ans", "Entre 25 et 50 ans", "Plus de 50 ans"];

        echo "<h3>Répartition des usagers selon leur sexe et leur âge</h3>";
        echo "<table>";
        echo "<tr><th>Tranche d'âge</th><th>Nb Hommes</th><th>Nb Femmes</th></tr>";

        foreach ($ageGroups as $ageGroup) {
            echo "<tr>";
            echo "<td>$ageGroup</td>";

            // Calculer l'âge à partir de la date de naissance
            $ageQuery = "SELECT COUNT(*) as count FROM patients 
                         WHERE TIMESTAMPDIFF(YEAR, datenaissance, CURDATE()) BETWEEN :minAge AND :maxAge
                         AND civilite = :civilite";
            
            switch ($ageGroup) {
                case "Moins de 25 ans":
                    $minAge = 0;
                    $maxAge = 24;
                    break;
                case "Entre 25 et 50 ans":
                    $minAge = 25;
                    $maxAge = 50;
                    break;
                case "Plus de 50 ans":
                    $minAge = 51;
                    $maxAge = 999; // Utilisez une valeur élevée pour un âge supérieur à 50
                    break;
                default:
                    $minAge = 0;
                    $maxAge = 999;
            }

            // Utiliser la civilité pour déterminer le sexe
            $sexQuery = "SELECT civility, COUNT(*) as count FROM patients 
                         WHERE TIMESTAMPDIFF(YEAR, datenaissance, CURDATE()) BETWEEN :minAge AND :maxAge
                         GROUP BY civilite";

            $stmt = $pdo->prepare($ageQuery);
            $stmt->bindParam(':minAge', $minAge);
            $stmt->bindParam(':maxAge', $maxAge);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Initialiser le compteur pour chaque sexe
            $countHommes = 0;
            $countFemmes = 0;

            // Parcourir les résultats et incrémenter le compteur approprié
            foreach ($result as $row) {
                if ($row['civilite'] == 'M') {
                    $countHommes += $row['count'];
                } elseif ($row['civilite'] == 'Mme') {
                    $countFemmes += $row['count'];
                }
            }

            // Afficher le nombre total pour chaque sexe dans la tranche d'âge
            echo "<td>" . $countHommes . "</td>";
            echo "<td>" . $countFemmes . "</td>";

            echo "</tr>";
        }

        echo "</table>";

        // Durée totale des consultations effectuées par chaque médecin
        echo "<h3>Durée totale des consultations par médecin (en heures)</h3>";
        echo "<table>";
        echo "<tr><th>Médecin</th><th>Durée totale (heures)</th></tr>";

        // Ajoutez ici la logique pour récupérer la durée totale des consultations par médecin.
        // Vous devez remplacer la requête fictive par la requête SQL appropriée pour votre base de données.
        $query = "SELECT medecin_id, SUM(duration) as total_duration FROM consultations GROUP BY medecin_id";
        $stmt = $pdo->query($query);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>Médecin " . $row['medecin_id'] . "</td>";
            echo "<td>" . $row['total_duration'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";

    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }

    // Fermer la connexion à la base de données
    $pdo = null;
    ?>
</body>
</html>
