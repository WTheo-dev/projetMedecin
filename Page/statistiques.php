<?php
include('menu.php');
include('bdd.php');

// Initialisation des variables
$repartition_usagers = array("moins25" => array("hommes" => 0, "femmes" => 0),
                             "entre25et50" => array("hommes" => 0, "femmes" => 0),
                             "plus50" => array("hommes" => 0, "femmes" => 0));
$duree_consultations = array();

try {
    // Récupération de la répartition des patients selon leur âge
    $sql_repartition_usagers = "SELECT 
        SUM(CASE WHEN TIMESTAMPDIFF(YEAR, date_naissance, CURDATE()) < 25 AND civilite = 'M.' THEN 1 ELSE 0 END) AS moins25_hommes,
        SUM(CASE WHEN TIMESTAMPDIFF(YEAR, date_naissance, CURDATE()) < 25 AND civilite = 'Mme' THEN 1 ELSE 0 END) AS moins25_femmes,
        SUM(CASE WHEN TIMESTAMPDIFF(YEAR, date_naissance, CURDATE()) BETWEEN 25 AND 50 AND civilite = 'M.' THEN 1 ELSE 0 END) AS entre25et50_hommes,
        SUM(CASE WHEN TIMESTAMPDIFF(YEAR, date_naissance, CURDATE()) BETWEEN 25 AND 50 AND civilite = 'Mme' THEN 1 ELSE 0 END) AS entre25et50_femmes,
        SUM(CASE WHEN TIMESTAMPDIFF(YEAR, date_naissance, CURDATE()) > 50 AND civilite = 'M.' THEN 1 ELSE 0 END) AS plus50_hommes,
        SUM(CASE WHEN TIMESTAMPDIFF(YEAR, date_naissance, CURDATE()) > 50 AND civilite = 'Mme' THEN 1 ELSE 0 END) AS plus50_femmes
        FROM usagers";

    $result_repartition_usagers = $conn->query($sql_repartition_usagers);
    $row_repartition_usagers = $result_repartition_usagers->fetch(PDO::FETCH_ASSOC);

    // Récupération de la durée totale des consultations par médecin avec le nom et prénom du médecin
    $sql_duree_consultations = "SELECT medecins.nom AS nom_medecin, medecins.prenom AS prenom_medecin, COALESCE(SUM(rendez_vous.duree_consultation), 0) AS total_duree
    FROM medecins
    LEFT JOIN rendez_vous ON medecins.id = rendez_vous.id_medecin
    GROUP BY medecins.nom, medecins.prenom";

    $result_duree_consultations = $conn->query($sql_duree_consultations);
    while ($row_duree_consultations = $result_duree_consultations->fetch(PDO::FETCH_ASSOC)) {
        $duree_consultations[] = $row_duree_consultations;
    }

    // Paramètre pour spécifier l'ordre de tri (ascendant ou descendant)
    $ordre_tri = isset($_GET['ordre_tri']) && ($_GET['ordre_tri'] == 'desc') ? 'desc' : 'asc';

    // Trier le tableau $duree_consultations par la durée totale
    usort($duree_consultations, function($a, $b) use ($ordre_tri) {
        return ($ordre_tri == 'asc') ? $a['total_duree'] - $b['total_duree'] : $b['total_duree'] - $a['total_duree'];
    });

} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques</title>
    <link rel="stylesheet" href="../Css/statistiques.css">
</head>
<body>

    <h1>Statistiques</h1>

    <?php
    // Affichage de la répartition des patients selon leur âge
    echo "<h2>Répartition des patients selon leur âge et sexe</h2>";
    echo "<table class='tab1' border='1'>";
    echo "<tr><th>Tranche d'âge</th><th>Nb Hommes</th><th>Nb Femmes</th></tr>";
    echo "<tr><td>Moins de 25 ans</td><td>{$row_repartition_usagers['moins25_hommes']}</td><td>{$row_repartition_usagers['moins25_femmes']}</td></tr>";
    echo "<tr><td>Entre 25 et 50 ans</td><td>{$row_repartition_usagers['entre25et50_hommes']}</td><td>{$row_repartition_usagers['entre25et50_femmes']}</td></tr>";
    echo "<tr><td>Plus de 50 ans</td><td>{$row_repartition_usagers['plus50_hommes']}</td><td>{$row_repartition_usagers['plus50_femmes']}</td></tr>";
    echo "</table>";

    // Affichage de la durée totale des consultations par médecin
    echo "<h2>Durée totale des consultations par médecin</h2>";

    // Formulaire pour choisir l'ordre de tri
    echo "<form method='get' action='{$_SERVER['PHP_SELF']}'>";
    echo "<label for='ordre_tri'>Ordre :</label>";
    echo "<select name='ordre_tri' id='ordre_tri' onchange='this.form.submit()'>";
    echo "<option value='asc' " . ($ordre_tri == 'asc' ? 'selected' : '') . ">Croissant</option>";
    echo "<option value='desc' " . ($ordre_tri == 'desc' ? 'selected' : '') . ">Décroissant</option>";
    echo "</select>";
    echo "</form>";

    echo "<table class='tab2' border='1'>";
    echo "<tr><th>Médecin</th><th>Durée totale (heures)</th></tr>";

    // Boucle pour afficher chaque médecin et sa durée totale
    foreach ($duree_consultations as $medecin) {
        // Convertir la durée totale de minutes à heures
        $total_duree_heures = floor($medecin['total_duree'] / 60);
        $total_duree_minutes = $medecin['total_duree'] % 60;
        echo "<tr><td>{$medecin['prenom_medecin']} {$medecin['nom_medecin']}</td><td>{$total_duree_heures}h {$total_duree_minutes}min</td></tr>";
    }

    echo "</table>";
    ?>

    <?php
    include('footer.php');
    ?>

</body>
</html>
