-- Script de restauration de l'application "GSB Frais"

-- Administration de la base de données
CREATE DATABASE gsb_frais_b3;
CREATE USER 'userGsb'@'localhost' IDENTIFIED BY 'LeGroupeDesAlex6';
GRANT ALL PRIVILEGES ON `gsb_frais_b3`.* TO userGsb@localhost;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET SQL_SAFE_UPDATES = 0;
USE gsb_frais_b3 ;

-- Création de la structure de la base de données
CREATE TABLE IF NOT EXISTS fraisforfait (
  id char(3) NOT NULL,
  libelle char(20) DEFAULT NULL,
  montant decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS etat (
  id char(2) NOT NULL,
  libelle varchar(30) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS gsb_role (
    id int NOT NULL AUTO_INCREMENT,
    libelle varchar(50) NOT NULL,
    PRIMARY KEY (id)
)ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS visiteur (
  id int NOT NULL AUTO_INCREMENT,
  nom char(30) DEFAULT NULL,
  prenom char(30)  DEFAULT NULL, 
  login char(20) DEFAULT NULL,
  mdp char(20) DEFAULT NULL,
  adresse char(30) DEFAULT NULL,
  cp char(5) DEFAULT NULL,
  ville char(30) DEFAULT NULL,
  dateembauche date DEFAULT NULL,
  id_role int NOT NULL,  
  PRIMARY KEY (id),
  FOREIGN KEY (id_role) REFERENCES gsb_role(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS fichefrais (
  idvisiteur int NOT NULL,
  mois char(6) NOT NULL,
  nbjustificatifs int(11) DEFAULT NULL,
  montantvalide decimal(10,2) DEFAULT NULL,
  datemodif date DEFAULT NULL,
  idetat char(2) DEFAULT 'CR',
  PRIMARY KEY (idvisiteur,mois),
  FOREIGN KEY (idetat) REFERENCES etat(id),
  FOREIGN KEY (idvisiteur) REFERENCES visiteur(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS lignefraisforfait (
  idvisiteur int NOT NULL,
  mois char(6) NOT NULL,
  idfraisforfait char(3) NOT NULL,
  quantite int(11) DEFAULT NULL,
  PRIMARY KEY (idvisiteur,mois,idfraisforfait),
  FOREIGN KEY (idvisiteur, mois) REFERENCES fichefrais(idvisiteur, mois),
  FOREIGN KEY (idfraisforfait) REFERENCES fraisforfait(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS lignefraishorsforfait (
  id int(11) NOT NULL auto_increment,
  idvisiteur int NOT NULL,
  mois char(6) NOT NULL,
  libelle varchar(100) DEFAULT NULL,
  date date DEFAULT NULL,
  montant decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (idvisiteur, mois) REFERENCES fichefrais(idvisiteur, mois)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS vehicule (
id int AUTO_INCREMENT, 
matricule varchar(9) not null,
 puissanceFiscal int not null,
 typeEssence set('essence','diesel') not null,
 idvisiteur int not null,
 CONSTRAINT PRIMARY KEY(id),
 CONSTRAINT FOREIGN KEY (idvisiteur) REFERENCES visiteur(id) 
);

-- Alimentation des données paramètres
INSERT INTO fraisforfait (id, libelle, montant) VALUES
('ETP', 'Forfait Etape', 110.00),
('KM', 'Frais Kilométrique', 0.62),
('NUI', 'Nuitée Hôtel', 80.00),
('REP', 'Repas Restaurant', 25.00);

INSERT INTO etat (id, libelle) VALUES
('RB', 'Remboursée'),
('CL', 'Saisie clôturée'),
('CR', 'Fiche créée, saisie en cours'),
('VA', 'Validée'),
('MP', 'Mise en paiement');

INSERT INTO gsb_role (libelle) VALUES ('visiteur'),('comptable');

INSERT INTO `vehicule`(`matricule`, `puissanceFiscal`, `typeEssence`, `idvisiteur`) VALUES ('BH-980-AW',5,'essence',1);

-- Récupération des utilisateurs
INSERT INTO visiteur ( nom, prenom, login, mdp, adresse, cp, ville, dateembauche,id_role) VALUES
('Villechalane', 'Louis', 'lvillachane', 'jux7g', '8 rue des Charmes', '46000', 'Cahors', '2005-12-21',1),
('Andre', 'David', 'dandre', 'oppg5', '1 rue Petit', '46200', 'Lalbenque', '1998-11-23',1),
('Bedos', 'Christian', 'cbedos', 'gmhxd', '1 rue Peranud', '46250', 'Montcuq', '1995-01-12',1),
('Tusseau', 'Louis', 'ltusseau', 'ktp3s', '22 rue des Ternes', '46123', 'Gramat', '2000-05-01',1),
('Bentot', 'Pascal', 'pbentot', 'doyw1', '11 allée des Cerises', '46512', 'Bessines', '1992-07-09',1),
('Bioret', 'Luc', 'lbioret', 'hrjfs', '1 Avenue gambetta', '46000', 'Cahors', '1998-05-11',1),
('Bunisset', 'Francis', 'fbunisset', '4vbnd', '10 rue des Perles', '93100', 'Montreuil', '1987-10-21',1),
('Bunisset', 'Denise', 'dbunisset', 's1y1r', '23 rue Manin', '75019', 'paris', '2010-12-05',1),
('Cacheux', 'Bernard', 'bcacheux', 'uf7r3', '114 rue Blanche', '75017', 'Paris', '2009-11-12',1),
('Cadic', 'Eric', 'ecadic', '6u8dc', '123 avenue de la République', '75011', 'Paris', '2008-09-23',1),
('Charoze', 'Catherine', 'ccharoze', 'u817o', '100 rue Petit', '75019', 'Paris', '2005-11-12',1),
('Clepkens', 'Christophe', 'cclepkens', 'bw1us', '12 allée des Anges', '93230', 'Romainville', '2003-08-11',1),
('Cottin', 'Vincenne', 'vcottin', '2hoh9', '36 rue Des Roches', '93100', 'Monteuil', '2001-11-18',1),
('Daburon', 'François', 'fdaburon', '7oqpv', '13 rue de Chanzy', '94000', 'Créteil', '2002-02-11',1),
('De', 'Philippe', 'pde', 'gk9kx', '13 rue Barthes', '94000', 'Créteil', '2010-12-14',1),
('Debelle', 'Michel', 'mdebelle', 'od5rt', '181 avenue Barbusse', '93210', 'Rosny', '2006-11-23',1),
('Debelle', 'Jeanne', 'jdebelle', 'nvwqq', '134 allée des Joncs', '44000', 'Nantes', '2000-05-11',1),
('Debroise', 'Michel', 'mdebroise', 'sghkb', '2 Bld Jourdain', '44000', 'Nantes', '2001-04-17',1),
('Desmarquest', 'Nathalie', 'ndesmarquest', 'f1fob', '14 Place d Arc', '45000', 'Orléans', '2005-11-12',1),
('Desnost', 'Pierre', 'pdesnost', '4k2o5', '16 avenue des Cèdres', '23200', 'Guéret', '2001-02-05',1),
('Dudouit', 'Frédéric', 'fdudouit', '44im8', '18 rue de l église', '23120', 'GrandBourg', '2000-08-01',1),
('Duncombe', 'Claude', 'cduncombe', 'qf77j', '19 rue de la tour', '23100', 'La souteraine', '1987-10-10',1),
('Enault-Pascreau', 'Céline', 'cenault', 'y2qdu', '25 place de la gare', '23200', 'Gueret', '1995-09-01',1),
('Eynde', 'Valérie', 'veynde', 'i7sn3', '3 Grand Place', '13015', 'Marseille', '1999-11-01',1),
('Finck', 'Jacques', 'jfinck', 'mpb3t', '10 avenue du Prado', '13002', 'Marseille', '2001-11-10',1),
('Frémont', 'Fernande', 'ffremont', 'xs5tq', '4 route de la mer', '13012', 'Allauh', '1998-10-01',1),
('Gest', 'Alain', 'agest', 'dywvt', '30 avenue de la mer', '13025', 'Berre', '1985-11-01',1),
('Bertin', 'Alexis', 'abertin', 'a7ghy', '18 avenue colbert', '83000', 'Toulon', '2003-09-05',2),
('Contussi', 'Alex', 'acontussi', 'b7zs5', '113 boulevard marc chagall ', '83390', 'Cuers', '2000-03-01',2);





ALTER TABLE visiteur
MODIFY mdp CHAR(255) ;

ALTER TABLE visiteur ADD email TEXT NULL;
UPDATE visiteur SET email = CONCAT(login,"@swiss-galaxy.com");

ALTER TABLE visiteur ADD code CHAR(4);

UPDATE `etat` SET `libelle`='Validée' WHERE id = 'VA';
