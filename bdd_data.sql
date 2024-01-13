    -- Insertion de données de test pour la table medecin
    INSERT INTO `medecin` (`id_medecin`,`civilite`, `nom`, `prenom`, `id_utilisateur`) VALUES
    (1,'M.', 'Smith', 'John', 3),
    (2,'Mme', 'Johnson', 'Emily',4),
    (3,'M.', 'Lee', 'David',5),
    (4,'Mme', 'Wilson', 'Sarah',6);

    -- Insertion de données de test pour la table patient
    INSERT INTO `patient` (`num_secu`, `civilite`, `nom`, `prenom`, `adresse`, `date_naissance`, `lieu_naissance`) VALUES
    ('1234567890', 'Mme', 'Dupont', 'Sophie', '123 Rue de la Santé', '1980-05-15', 'Paris'),
    ('9876543210', 'M.', 'Martin', 'Luc', '456 Avenue des Lilas', '1995-12-10', 'Marseille'),
    ('5555555555', 'Mme', 'Garcia', 'Elena', '789 Chemin du Soleil', '1972-07-20', 'Lyon'),
    ('1111111111', 'M.', 'Tremblay', 'Pierre', '321 Avenue des Roses', '1990-03-25', 'Montréal'),
    ('2222222222', 'Mme', 'Andersen', 'Anna', '555 Elm Street', '1985-08-02', 'Copenhague'),
    ('3333333333', 'M.', 'Li', 'Jian', '123 Bamboo Lane', '1978-11-12', 'Shanghai');

    -- Insertion de données de test pour la table rendezvous
    INSERT INTO `rendezvous` (`id_patient`, `id_rendezvous`, `date_rdv`, `heure_rdv`, `duree_rdv`, `id_medecin`) VALUES
    (1, 1,'2023-10-10', '09:00:00', '00:30:00', 1),
    (2, 2,'2023-10-15', '14:30:00', '00:45:00', 3),
    (3, 3,'2023-10-20', '11:15:00', '01:00:00', 2),
    (4, 4,'2023-10-25', '10:30:00', '00:30:00', 4),
    (5, 5,'2023-11-05', '15:15:00', '00:45:00', 6),
    (6, 6,'2023-11-10', '08:45:00', '01:15:00', 5);

    INSERT INTO `role` (`id_role`,`description`) VALUES
    (1, 'Medecin'),
    (2, 'Secretaire'),
    (3, 'Patient');
    
    INSERT INTO `utilisateur` (`id_utilisateur`,`nom_utilisateur`,`mdp`, `id_role`) VALUES 
    (1, 'utilisateur1', 'motdepasse1', 3),
    (2, 'utilisateur2', 'motdepasse2', 3),
    (3, 'utilisateur3', 'motdepasse3', 1),
    (4, 'utilisateur4', 'motdepasse4', 1),
    (5, 'utilisateur5', 'motdepasse5', 1),
    (6, 'utilisateur6', 'motdepasse6', 2),
    (7, 'utilisateur7', 'motdepasse7', 3);
