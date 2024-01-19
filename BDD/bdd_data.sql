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
INSERT INTO rendezvous (`id_patient`, `date_rdv`, `heure_rdv`, `duree_rdv`, `id_medecin`) VALUES
    (1, STR_TO_DATE('15/01/2024', '%d/%m/%Y'), '10:00:00', '00:30:00', 1),
    (2, STR_TO_DATE('16/01/2024', '%d/%m/%Y'), '14:30:00','00:30:00', 2),
    (3, STR_TO_DATE('17/01/2024', '%d/%m/%Y'), '09:15:00', '00:30:00', 3),
    (4, STR_TO_DATE('18/01/2024', '%d/%m/%Y'), '11:45:00', '00:30:00', 4),
    (5, STR_TO_DATE('19/01/2024', '%d/%m/%Y'), '16:00:00', '00:30:00', 5);
    INSERT INTO `role` (`id_role`,`description`) VALUES
    (1, 'Medecin'),
    (2, 'Secretaire');
    
    INSERT INTO `utilisateur` (`id_utilisateur`,`nom_utilisateur`,`mdp`, `id_role`) VALUES 
    (1, 'utilisateur1', 'motdepasse1', 3),
    (2, 'utilisateur2', 'motdepasse2', 3),
    (3, 'utilisateur3', 'motdepasse3', 1),
    (4, 'utilisateur4', 'motdepasse4', 1),
    (5, 'utilisateur5', 'motdepasse5', 1),
    (6, 'utilisateur6', 'motdepasse6', 2),
    (7, 'utilisateur7', 'motdepasse7', 3);
