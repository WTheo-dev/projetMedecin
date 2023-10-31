<?php

/////////////////////////////////////////////////////////////////////////////
////////////////////   CONNECTION A LA BASE DE DONNEES   ////////////////////
/////////////////////////////////////////////////////////////////////////////

function connection_base_donnee(){
    try{
        $baseDeDonnees = new PDO("mysql:host=localhost;dbname=ProjetR401",'utilisateur','password');
    }catch(PDOException $e){
        die('Erreur : '.$e->getMessage());
    }
    return $baseDeDonnees;
}

function identification($login, $password){
    $login = htmlspecialchars($login);
    $password = htmlspecialchars($password);
    $baseDeDonnees = connection_base_donnee();
    $verificationMembre = $baseDeDonnees->prepare('SELECT * FROM utilisateur WHERE nom_utilisateur = ? AND mot_de_passe = ?');
    $verificationMembre->execute(array($login, $password));
    $baseDeDonnee = null;
    if($verificationMembre->rowCount() > 0){
        return TRUE;
    }else{
        return FALSE;
    } 
}

function  recuperation_role($login)  {
    $baseDeDonnees = connection_base_donnee();
    $recuperationRoleMembre = $baseDeDonnees->prepare('SELECT id_role FROM utilisateur WHERE nom_utilisateur = ?');
    $recuperationRoleMembre->execute(array($login));
    $baseDeDonnee = null;
    if($recuperationRoleMembre->rowCount() > 0){
        foreach($recuperationRoleMembre as $row){
            return $row['id_role'];
        }
    }else{
        return FALSE;
    } 
}


/////////////////////////////////////////////////////////////////////////////
////////////////////       GESTION DES UTILISATEURS      ////////////////////
/////////////////////////////////////////////////////////////////////////////


function nom_membre_id($idMembre){
    $baseDeDonnee = connection_base_donnee();
    $rechercheMembre = $baseDeDonnee->prepare('SELECT * FROM utilisateur WHERE id_utilisateur = ?');
    $rechercheMembre->execute(array($idMembre));
    $baseDeDonnee = null;
    if($rechercheMembre->rowCount() > 0){
        foreach($rechercheMembre as $row){
            return $row['nom_utilisateur'];
        }
    }else{
        return FALSE;
    }
}

function id_membre_nom($nomMembre){
    $baseDeDonnee = connection_base_donnee();
    $rechercheMembre = $baseDeDonnee->prepare('SELECT * FROM utilisateur WHERE nom_utilisateur = ?');
    $rechercheMembre->execute(array($nomMembre));
    $baseDeDonnee = null;
    if($rechercheMembre->rowCount() > 0){
        foreach($rechercheMembre as $row){
            return $row['id_utilisateur'];
        }
    }else{
        return FALSE;
    }
}


/////////////////////////////////////////////////////////////////////////////
////////////////////         GESTION DES ARTICLES        ////////////////////
/////////////////////////////////////////////////////////////////////////////


function tous_articles($role){
    $baseDeDonnees = connection_base_donnee();
    $listeArticles = $baseDeDonnees->prepare('SELECT * FROM articles');
    $listeArticles->execute(array());
    $baseDeDonnee = null;
    $resultat = [];
    if(empty($role)){
        foreach($listeArticles as $row){
            array_push($resultat, array('contenu' => $row['contenu'], 'date' => $row['date_de_publication'], 'publisher' => nom_membre_id($row['id_utilisateur'])));
        }
        return $resultat;
    }elseif($role == 2){
        foreach($listeArticles as $row){
            $like = compteur_like_dislike($row['id_articles']);
            array_push($resultat, array('contenu' => $row['contenu'], 'date' => $row['date_de_publication'], 'publisher' => nom_membre_id($row['id_utilisateur']), 'like' => $like[0], 'dislike' => $like[1]));
        }
        return $resultat;
    }elseif($role == 1){
        foreach($listeArticles as $row){
            $like = compteur_like_dislike($row['id_articles']);
            $liste = liste_like_dislike($row['id_articles']);
            array_push($resultat, array('contenu' => $row['contenu'], 'date' => $row['date_de_publication'], 'publisher' => nom_membre_id($row['id_utilisateur']), 'like' => $like[0], 'listeLike' => $liste[0], 'dislike' => $like[1], 'listeDislike' => $liste[1]));
        }
        return $resultat;
    }
}

function supprimer_article($idArticle){
    $baseDeDonnee = connection_base_donnee();
    $idArticle = htmlspecialchars($idArticle);
    $suppressionArticle = $baseDeDonnee->prepare('DELETE FROM articles WHERE id_articles = ?');
    $suppressionArticle->execute(array($idArticle));
    $baseDeDonnee = null;
    if($suppressionArticle->rowCount() > 0){
        return TRUE;
    }else{
        return FALSE;
    }
}

function modifier_article($utilisateur, $idArticle, $titre, $contenu){
    $baseDeDonnee = connection_base_donnee();
    $idArticle = htmlspecialchars($idArticle);
    $titre = htmlspecialchars($titre);
    $contenu = htmlspecialchars($contenu);
    $datePublication = date('y-m-d');
    $suppressionArticle = $baseDeDonnee->prepare('UPDATE articles SET titre = ? , contenu = ?, date_de_publication = ? WHERE id_articles = ?');
    $suppressionArticle->execute(array($titre, $contenu, $datePublication, $idArticle));
    $baseDeDonnee = null;
    if($suppressionArticle->rowCount() > 0){
        return TRUE;
    }else{
        return FALSE;
    }
}

function articles_existe($idArticle){
    $baseDeDonnee = connection_base_donnee();
    $rechercheMembre = $baseDeDonnee->prepare('SELECT * FROM articles WHERE id_articles = ?');
    $rechercheMembre->execute(array($idArticle));
    $baseDeDonnee = null;
    if($rechercheMembre->rowCount() > 0){
        return TRUE;
    }else{
        return FALSE;
    }
}

function createur_articles($idArticle){
    $baseDeDonnee = connection_base_donnee();
    $rechercheMembre = $baseDeDonnee->prepare('SELECT * FROM articles WHERE id_articles = ?');
    $rechercheMembre->execute(array($idArticle));
    $baseDeDonnee = null;
    if($rechercheMembre->rowCount() > 0){
        foreach($rechercheMembre as $row){
            return nom_membre_id($row['id_utilisateur']);
        }
    }else{
        return "-1";
    }
}

function articles_publisher($utilisateur){
    $baseDeDonnee = connection_base_donnee();
    $idMembre = id_membre_nom($utilisateur);
    $rechercheArticle = $baseDeDonnee->prepare('SELECT * FROM articles WHERE id_utilisateur = ?');
    $rechercheArticle->execute(array($idMembre));
    $resultat = [];
    $baseDeDonnee = null;
    if($rechercheArticle->rowCount() > 0){
        foreach($rechercheArticle as $row){
            $like = compteur_like_dislike($row['id_articles']);
            array_push($resultat, array('contenu' => $row['contenu'], 'date' => $row['date_de_publication'], 'publisher' => nom_membre_id($row['id_utilisateur']), 'like' => $like[0], 'dislike' => $like[1]));
        }
        return $resultat;
    }else{
        return FALSE;
    }
}

function publier_article($titre, $contenu, $utilisateur){
    $baseDeDonnee = connection_base_donnee();
    $titre = htmlspecialchars($titre);
    $contenu = htmlspecialchars($contenu);
    $utilisateur = htmlspecialchars($utilisateur);
    $datePublication = date('y-m-d');
    $ajoutPublication = $baseDeDonnee->prepare('INSERT INTO articles(titre, contenu, date_de_publication, id_utilisateur) VALUES (?, ?, ?, ?)');
    $ajoutPublication->execute(array($titre, $contenu, $datePublication, id_membre_nom($utilisateur)));
    $baseDeDonnee = null;
    if($ajoutPublication->rowCount() > 0){
        return TRUE;
    }else{
        return FALSE;
    }
}


/////////////////////////////////////////////////////////////////////////////
////////////////////          GESTION DES LIKES          ////////////////////
/////////////////////////////////////////////////////////////////////////////


function compteur_like_dislike($idArticle){
    $baseDeDonnees = connection_base_donnee();
    $listeLike = $baseDeDonnees->prepare('SELECT * FROM apprecier WHERE id_articles = ?');
    $listeLike->execute(array($idArticle));
    $baseDeDonnee = null;
    $compteurLikeDislike = [];
    $nombreTotalLikeDislike = $listeLike->rowCount();
    $compteurLike = 0;
    foreach($listeLike as $row){
        $compteurLike += $row['type'];
    }
    array_push($compteurLikeDislike, $compteurLike, $nombreTotalLikeDislike - $compteurLike);
    return $compteurLikeDislike;
}
    
function liste_like_dislike($idArticle){
    $baseDeDonnees = connection_base_donnee();
    $listeAllLike = $baseDeDonnees->prepare('SELECT * FROM apprecier WHERE id_articles = ?');
    $listeAllLike->execute(array($idArticle));
    $baseDeDonnee = null;
    $listeLikeDislike = [];
    $listeLike = [];
    $listeDislike = [];
    if($listeAllLike->rowCount() > 0){
        foreach($listeAllLike as $row){
            if($row['type'] == 1){
                array_push($listeLike, nom_membre_id($row['id_utilisateur']));
            }else{
                array_push($listeDislike, nom_membre_id($row['id_utilisateur']));
            }
            
        }
    }
    array_push($listeLikeDislike, $listeLike, $listeDislike);
    return $listeLikeDislike;
}

function deja_liker($utilisateur, $idArticle){
    $baseDeDonnee = connection_base_donnee();
    $idMembre = id_membre_nom($utilisateur);
    $rechercheMembre = $baseDeDonnee->prepare('SELECT * FROM apprecier WHERE id_utilisateur = ? AND id_articles = ?');
    $rechercheMembre->execute(array($idMembre, $idArticle));
    $baseDeDonnee = null;
    if($rechercheMembre->rowCount() > 0){
        return TRUE;
    }else{
        return FALSE;
    }
}

function ajouter_like($like, $idArticle, $utilisateur){
    $baseDeDonnee = connection_base_donnee();
    $like = htmlspecialchars($like);
    $idMembre = id_membre_nom($utilisateur);
    $ajoutLike = $baseDeDonnee->prepare('INSERT INTO apprecier(id_utilisateur, id_articles, type) VALUES (?, ?, ?)');
    $ajoutLike->execute(array($idArticle,$idMembre, $like));
    $baseDeDonnee = null;
    if($ajoutLike->rowCount() > 0){
        return TRUE;
    }else{
        return FALSE;
    }
}

function retirer_like($idArticle, $utilisateur){
    $baseDeDonnee = connection_base_donnee();
    $idMembre = id_membre_nom($utilisateur);
    $retirerLike = $baseDeDonnee->prepare('DELETE FROM apprecier WHERE id_articles = ? AND id_utilisateur = ?');
    $retirerLike->execute(array($idMembre, $idArticle));
    $baseDeDonnee = null;
    if($retirerLike->rowCount() > 0){
        return TRUE;
    }else{
        return FALSE;
    }
}


/////////////////////////////////////////////////////////////////////////////
////////////////////             GESTION API             ////////////////////
/////////////////////////////////////////////////////////////////////////////


function deliver_response($status, $status_message, $data){
	header("HTTP/1.1 $status $status_message");
	$response['status'] = $status;
	$response['status_message'] = $status_message;
	$response['data'] = $data;
	$json_response = json_encode($response);
	echo $json_response;
}

function get_body_token(string $bearer_token) : array{
    $tokenParts = explode('.', $bearer_token);
    $payload = base64_decode($tokenParts[1]);
    return (array) json_decode($payload);
}

function is_connected() : void{
	if (1 == 2) {
		throw new ExceptionLoginRequire();
	}
}

//function action_permited(string $action, string $ressource, int $id = null) : void
function action_permited() : void{
	if (1 == 2) {
		throw new ExceptionIssuficiantPermission();
	}
}
?>