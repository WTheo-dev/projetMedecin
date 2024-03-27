<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cabinet Médical - usagers</title>
    <link rel="stylesheet" href="usagers.css">
</head>
<body>
    <?php 
    session_start(); // Démarrer la session
    include 'header.php'; 
    ?>
    <h2>Liste des usagers</h2>

    <?php
    // Vérifier si le token est présent dans la session
    if (isset($_SESSION['jwt_token'])) {
        $token = $_SESSION['jwt_token'];

        try {
            // Utilisez le token dans votre API pour récupérer la liste des usagers
            $api_url = "http://localhost/projetMedecin/CabMed/GestionPatients.php";
            

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
                // Afficher la liste des usagers dans un tableau
                echo "<a href='ajouter_patient.php'><button>Ajouter un usager</button></a>";

                echo "<table border='1'>";
                echo "<tr><th>ID usager</th><th>Civilité</th><th>Nom</th><th>Prénom</th><th>Sexe</th><th>Adresse</th><th>Code postal</th><th>Ville</th><th>Actions</th></tr>";
                
                foreach ($data['data'] as $usager) {
                    echo "<tr>";
                    echo "<td>" . $usager['id_usager'] . "</td>";
                    echo "<td>" . $usager['civilite'] . "</td>";
                    echo "<td>" . $usager['nom'] . "</td>";
                    echo "<td>" . $usager['prenom'] . "</td>";
                    echo "<td>" . $usager['sexe'] . "</td>";
                    echo "<td>" . $usager['adresse'] . "</td>";
                    echo "<td>" . $usager['code_postal'] . "</td>";
                    echo "<td>" . $usager['ville'] . "</td>";
                    echo "<td>
                            <a href='modifier_patient.php?id=" . $usager['id_usager'] . "'>Modifier</a>
                            <a href='supprimer_patient.php?id=" . $usager['id_usager'] . "'>Supprimer</a>
                          </td>";
                    echo "</tr>";
                }
                
                echo "</table>";
            } else {
                echo "Aucun usager trouvé.";
            }
           

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
