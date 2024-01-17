<?php

function connexion($nom_utilisateur, $mdp)
{
  $data = array("nom_utilisateur" => $nom_utilisateur,"mdp" => $mdp);
  $data_string = json_encode($data);
  /// Envoi de la requête
  //var_dump($data_string);
  $result = file_get_contents(
    'http://localhost/projetMedecin/API_Medecin/serveurToken.php',
    false,
    stream_context_create(array(
        'http' => array(
            'method' => 'POST', 
            'content' => $data_string,
            'header' => array(
                'Content-Type: application/json'."\r\n"
                .'Content-Length:'.strlen($data_string) . "\r\n"
                )
            )
        )
    )
);
  $data = json_decode($result, true);
  //var_dump($data);
  if($data['data'] != false) {
    $_SESSION['token'] = $data['data'];  
    header('Location: index.php');
  } else {
    echo '<h2 style="color: red; position: absolute; top: 10%; left: 50%; transform: translate(-50%,-50%);">Connexion échouée</h2>';
  }
}