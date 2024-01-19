<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cabinet Médical - Médecins</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php 
    session_start(); // Démarrer la session
    include 'header.php'; 
    ?>
    <h2>Liste des Médecins</h2>

    <?php
    // Vérifier si le token est présent dans la session
    if (isset($_SESSION['jwt_token'])) {
        $token = $_SESSION['jwt_token'];

        try {
            // Utilisez le token dans votre API pour récupérer la liste des médecins
            $api_url = "http://localhost/projetMedecin/API_Medecin/APIMedecin.php";
            

            $options = [
                'http' => [
                    'method' => 'GET',
                    'header' => 'Authorization: Medecin ' . $token,
                ],
            ];

            $context = stream_context_create($options);
            $response = file_get_contents($api_url, false, $context);

            // Vérifier s'il y a des résultats dans la réponse de l'API
            $data = json_decode($response, true);

            if (isset($data['data']) && !empty($data['data'])) {
                // Afficher la liste des médecins dans un tableau
                

                echo "<table border='1'>";
                echo "<tr><th>Civilité</th><th>Nom</th><th>Prénom</th><th>ID medecin</th><th>Actions</th></tr>";
                
                foreach ($data['data'] as $medecin) {
                    echo "<tr>";
                    echo "<td>" . $medecin['civilite'] . "</td>";
                    echo "<td>" . $medecin['nom'] . "</td>";
                    echo "<td>" . $medecin['prenom'] . "</td>";
                    echo "<td>" . $medecin['id_medecin'] . "</td>";
                    echo "<td>
                            <a href='modifier_medecin.php?id=" . $medecin['id_medecin'] . "'>Modifier</a>
                            <a href='supprimer_medecin.php?id=" . $medecin['id_medecin'] . "'>Supprimer</a>
                          </td>";
                    echo "</tr>";
                }
                
                echo "</table>";
            } else {
                echo "Aucun medecin trouvé.";
            }
            echo "<a href='ajouter_medecin.php'><button>Ajouter un medecin</button></a>";

        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
    } else {
        // Rediriger vers la page de connexion si le token n'est pas présent
        header('Location: connexion.php');
        exit();
    }
    ?>
</body>
</html>
