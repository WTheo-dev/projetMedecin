<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Médecin</title>
    <link rel="stylesheet" href="style.css">
</head>

<body class="body-connexion">

    <h1 class="h1-connexion">Se connecter</h1>

    <form class="form-connexion" method="post">
        <label  class="label-connexion" for="username">Login :</label>
        <input class="input-connexion" type="text" id="username" name="username" placeholder="Votre login" required>

        <label class="label-connexion" for="password">Mot de passe :</label>
        <input class="input-connexion" type="password" id="password" name="password" placeholder=" Votre mot de passe " required>

        <button class="button-connexion" type="submit">Se Connecter</button>
    </form>

</body>
</html>
