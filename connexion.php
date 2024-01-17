<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Médecin</title>
    <style>
        .body-connexion {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column; /* Permet au contenu d'être empilé verticalement */
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .h1-connexion {
            margin-top: 0;
            margin-bottom: 20px;
        }

        .form-connexion {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        .label-connexion {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .input-connexion {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .connexion-button {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        .connexion-button:hover {
            background-color: #45a049;
        }
    </style>
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
