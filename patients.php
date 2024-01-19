<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cabinet Médical - Patients</title>
    <link rel="stylesheet" href="patients.css">
</head>
<body>
    <?php 
    session_start(); // Démarrer la session
    include 'header.php'; 
    ?>
    <h2>Liste des Patients</h2>

    <?php
    // Vérifier si le token est présent dans la session
    if (isset($_SESSION['jwt_token'])) {
        $token = $_SESSION['jwt_token'];

        try {
            // Utilisez le token dans votre API pour récupérer la liste des patients
            $api_url = "http://localhost/projetMedecin/API_Medecin/API_Patient.php";
            

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
                // Afficher la liste des patients dans un tableau
                echo "<a href='ajouter_patient.php'><button>Ajouter un patient</button></a>";

                echo "<table border='1'>";
                echo "<tr><th>Civilité</th><th>Nom</th><th>Prénom</th><th>Adresse</th><th>ID Patient</th><th>Actions</th></tr>";
                
                foreach ($data['data'] as $patient) {
                    echo "<tr>";
                    echo "<td>" . $patient['civilite'] . "</td>";
                    echo "<td>" . $patient['nom'] . "</td>";
                    echo "<td>" . $patient['prenom'] . "</td>";
                    echo "<td>" . $patient['adresse'] . "</td>";
                    echo "<td>" . $patient['id_patient'] . "</td>";
                    echo "<td>
                            <a href='modifier_patient.php?id=" . $patient['id_patient'] . "'>Modifier</a>
                            <a href='supprimer_patient.php?id=" . $patient['id_patient'] . "'>Supprimer</a>
                          </td>";
                    echo "</tr>";
                }
                
                echo "</table>";
            } else {
                echo "Aucun patient trouvé.";
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
