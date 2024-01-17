<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Liste des patients</title>
</head>
<body>
  <h1>Liste des patients</h1>
  <table>
    <thead>
      <tr>
        <th>Civilité</th> 
        <th>Nom</th>
        <th>Prénom</th>
        <th>Adresse</th>
        <th>Date de naissance</th>
        <th>Numéro de sécurité sociale</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody id="patientList">
    </tbody>
  </table>

  <br>
  <button onclick="window.location.href='ajouterPatient.html'">Ajouter Patient</button>

  <script src="patients.js"></script>
</body>
</html>
