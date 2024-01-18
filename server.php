<?php
// La fonction connexion doit être modifiée pour ne pas rediriger directement
function connexion($nom_utilisateur, $mdp)
{
    $data = array("nom_utilisateur" => $nom_utilisateur, "mdp" => $mdp);
    $data_string = json_encode($data);

    $result = file_get_contents(
        'http://localhost/projetMedecin/API_Medecin/serveurToken.php',
        false,
        stream_context_create(array(
            'http' => array(
                'method' => 'POST',
                'content' => $data_string,
                'header' => array(
                    'Content-Type: application/json' . "\r\n" .
                    'Content-Length:' . strlen($data_string) . "\r\n"
                )
            )
        ))
    );

    $data = json_decode($result, true);

    if ($data['data'] !== false) {
        // Ne pas rediriger ici
        $_SESSION['token'] = $data['data'];
    } else {
        // La connexion a échoué, affichez un message d'erreur ici
        echo "Échec de la connexion. Veuillez vérifier vos identifiants.";
    }
}
?>