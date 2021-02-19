-- script de schéma de base de données pour le site de gestion lmst
-- créé par MARIAGE Clémentine le 17/06/2013
-- moteurs: mySQL, innoDB

--
-- suppression d'un éventuel schéma existant
--
DROP TABLE IF EXISTS adhesions, niveaux_atteints, eleves, adherents, institutonnels, sourds;


-- /!\!!!!! Les auto-increments ont été enlevés pour éviter les erreurs au niveau de l'execution php. l'auto incrément se fait 
-- directement dans le PHP
-- -------------------------------------------------


--
-- structure de la table adherents
--
CREATE TABLE IF NOT EXISTS `adherents` (
  `ID_Adherent` mediumint(8) NOT NULL,
  `Civilite` enum('M.','Mme','M. ou Mme','Melle','Famille','Association') NOT NULL,
  `Nom` varchar(30) NOT NULL,
  `Prenom` varchar(30) NOT NULL,
  `Adresse1` varchar(40) NOT NULL,
  `Adresse2` varchar(25) NOT NULL,
  `Code_Postal` varchar(5) NOT NULL,
  `Ville` varchar(25) NOT NULL,
  `Telephone` varchar(20) NOT NULL,
  `Fax` varchar(20) NOT NULL,
  `Portable` varchar(20) NOT NULL,
  `Courriel1` varchar(40) NOT NULL,
  `Courriel2` varchar(40) NOT NULL,
  `Signe` longblob NOT NULL,
  `Caracteristique` set('Entendant(e)','Sourd(e)','Malentendant(e)','Aveugle') NOT NULL,
  `Carnet` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID_Adherent`)
) ENGINE=innodb ;

-- --------------------------------------

--
-- Structure de la table adhesions
--
CREATE TABLE IF NOT EXISTS `adhesions` (
  `ID_Adhesion` mediumint(8) NOT NULL,
  `ID_Adherent` mediumint(8) NOT NULL,
  `Date_adhesion` date NOT NULL,
  `Montant` tinyint(4) NOT NULL,
  PRIMARY KEY (`ID_Adhesion`)
) ENGINE=innodb;

-- --------------------------------------

--
-- Structure de la table institutionnels
--
CREATE TABLE IF NOT EXISTS `institutionnels` (
  `ID_Institut` mediumint(8) NOT NULL,
  `Civilite` enum('M.','Mme','Melle','Famille') NOT NULL,
  `Nom` varchar(30) NOT NULL,
  `Prenom` varchar(30) NOT NULL,
  `Fonction` varchar(20) NOT NULL,
  `Adresse1` varchar(30) NOT NULL,
  `Adresse2` varchar(30) NOT NULL,
  `Code_Postal` varchar(5) NOT NULL,
  `Ville` varchar(25) NOT NULL,
  `Telephone` varchar(19) NOT NULL,
  `Fax` varchar(19) NOT NULL,
  `Portable` varchar(19) NOT NULL,
  `Courriel` varchar(40) NOT NULL,
  `Carnet` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID_Institut`)
) ENGINE=innodb;

-- --------------------------------------

--
-- structure de la table niveaux_atteints
--
CREATE TABLE IF NOT EXISTS `niveaux_atteints` (
  `ID_Niveau_atteint` mediumint(8) NOT NULL,
  `ID_Eleve` mediumint(8)  NOT NULL,
  `Niveau_atteint` enum('A0','A1','A2','A3','A4','A5','A6','B1') NOT NULL,
  `Date_debut` date NOT NULL,
  `Date_fin` date NOT NULL,
  PRIMARY KEY (`ID_Niveau_atteint`)
) ENGINE=innodb ;

-- ---------------------------------------

--
-- Structure de la table `sourds`
--

CREATE TABLE IF NOT EXISTS `sourds` (
  `ID_Sourd` mediumint(8)NOT NULL ,
  `Civilite` enum('M.','Mme','Melle','Famille') NOT NULL,
  `Nom` varchar(30) NOT NULL,
  `Prenom` varchar(30) NOT NULL,
  `Adresse1` varchar(40) NOT NULL,
  `Adresse2` varchar(25) NOT NULL,
  `Code_Postal` varchar(5) NOT NULL,
  `Ville` varchar(20) NOT NULL,
  `Telephone` varchar(19) NOT NULL,
  `Fax` varchar(19) NOT NULL,
  `Courriel` varchar(30) NOT NULL,
  `Portable` varchar(19) NOT NULL,
  `Signe` longblob NOT NULL,
  PRIMARY KEY (`ID_Sourd`)
) ENGINE=innodb;

--  --------------------------------------------

--
-- Structure de la table eleves
-- 

CREATE TABLE IF NOT EXISTS `eleves`(
	`ID_Eleve` mediumint(8)  NOT NULL,
	`ID_Adherent` mediumint(8),
	`tjs_eleve` tinyint(1) NOT NULL,
	PRIMARY KEY (`ID_Eleve`,`ID_Adherent`)
)
engine=innodb;

-- 
-- mise en place des contraintes d'intégrité référentielles
-- 

-- de niveaux_atteints a eleves
ALTER TABLE niveaux_atteints ADD FOREIGN KEY (ID_Eleve) REFERENCES eleves(ID_Eleve);

-- de eleves a adhérents
ALTER TABLE eleves ADD FOREIGN KEY (ID_Adherent) REFERENCES adherents (ID_Adherent);

-- d'adhesions a adherents
ALTER TABLE adhesions ADD FOREIGN KEY (ID_Adherent) REFERENCES adherents (ID_Adherent);