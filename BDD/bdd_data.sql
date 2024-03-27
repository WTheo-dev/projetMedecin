    -- Insertion de données de test pour la table medecin
     INSERT INTO `medecin` (`civilite`, `nom`, `prenom`, `id_utilisateur`) VALUES
    ('Monsieur', 'Smith', 'John', 1),
    ('Madame', 'Johnson', 'Emily',2),
    ('Monsieur', 'Lee', 'David',3),
    ('Madame', 'Wilson', 'Sarah',4);

    -- Insertion de données de test pour la table patient
    INSERT INTO `usager` (`civilite`, `nom`, `prenom`, `sexe`, `adresse`, `code_postal`, `ville`, `date_nais`, `lieu_nais`,`num_secu`) VALUES
    ('Madame', 'Dupont', 'Sophie', 'F', '123 Rue de la Santé', '75000', 'Paris', '1980-05-15', 'Paris', '1234567890'),
    ('Monsieur', 'Martin', 'Luc', 'M', '456 Avenue des Lilas', '13000', 'Marseille', '1995-12-10', 'Angers', '9876543210'),
    ('Madame', 'Garcia', 'Elena', 'F', '789 Chemin du Soleil', '31000', 'Toulouse', '1975-02-20', 'Lyon', '5555555555'),
    ('Monsieur', 'Tremblay', 'Pierre', 'M', '321 Avenue des Roses', '83200', 'Toulon', '1990-03-25', 'Montréal', '1111111111'),
    ('Madame', 'Andersen', 'Anna','F', '555 Elm Street', '66000', 'Perpignan', '1985-08-02', 'Copenhague', '2222222222'),
    ('Monsieur', 'Li', 'Jian', 'M', '123 Bamboo Lane', '69000', 'Lyon', '1978-11-12', 'Shanghai', '3333333333');

    -- Insertion de données de test pour la table consultation
    INSERT INTO `consultation` (`date_consult`, `heure_consult`, `duree_consult`, `id_medecin`, `id_usager`) VALUES
    (STR_TO_DATE('15/01/2024', '%d/%m/%Y'), '10:00:00', '00:30:00', 1, 1),
    (STR_TO_DATE('16/01/2024', '%d/%m/%Y'), '14:30:00','00:30:00', 2, 2),
    (STR_TO_DATE('17/01/2024', '%d/%m/%Y'), '09:15:00', '00:30:00', 3, 3),
    (STR_TO_DATE('18/01/2024', '%d/%m/%Y'), '11:45:00', '00:30:00', 4, 4),
    (STR_TO_DATE('19/01/2024', '%d/%m/%Y'), '16:00:00', '00:30:00', 1, 5);
    
    -- Insertion de données de test pour la table rôle
	INSERT INTO `role` (`id_role`,`description`) VALUES
    (1, 'Medecin'),
    (2, 'Secretaire'),
    (3, 'Usager');
    
    -- Insertion de données de test pour la table utilisateur
    INSERT INTO `utilisateur` (`id_utilisateur`,`nom_utilisateur`,`mdp`, `id_role`) VALUES 
    (1, 'utilisateur1', 'motdepasse1', 3),
    (2, 'utilisateur2', 'motdepasse2', 3),
    (3, 'utilisateur3', 'motdepasse3', 1),
    (4, 'utilisateur4', 'motdepasse4', 1),
    (5, 'utilisateur5', 'motdepasse5', 1),
    (6, 'secretaire1', 'password1234!', 2),
    (7, 'utilisateur7', 'motdepasse7', 3);
