-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Ven 14 Juin 2013 à 11:54
-- Version du serveur: 5.5.31
-- Version de PHP: 5.3.10-1ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `lmst`
--

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `adherents_a_jour`
--
CREATE TABLE IF NOT EXISTS `adherents_a_jour` (
`Civilite` enum('M.','Mme','M. ou Mme','Melle','Famille','Association')
,`Nom` varchar(20)
,`Prenom` varchar(26)
);
-- --------------------------------------------------------

--
-- Structure de la table `adherents_eleves`
--

CREATE TABLE IF NOT EXISTS `adherents_eleves` (
  `ID_Adh_Eleve` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `Civilite` enum('M.','Mme','M. ou Mme','Melle','Famille','Association') NOT NULL,
  `Nom` varchar(20) NOT NULL,
  `Prenom` varchar(26) NOT NULL,
  `Adresse1` varchar(40) NOT NULL,
  `Adresse2` varchar(25) NOT NULL,
  `Code_Postal` varchar(5) NOT NULL,
  `Ville` varchar(22) NOT NULL,
  `Telephone` varchar(20) NOT NULL,
  `Fax` varchar(20) NOT NULL,
  `Portable` varchar(20) NOT NULL,
  `Courriel1` varchar(40) NOT NULL,
  `Courriel2` varchar(40) NOT NULL,
  `Signe` longblob NOT NULL,
  `Caracteristique` set('Entendant(e)','Sourd(e)','Malentendant(e)','Aveugle') NOT NULL,
  `Carnet` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID_Adh_Eleve`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=164 ;

--
-- Contenu de la table `adherents_eleves`
--

INSERT INTO `adherents_eleves` (`ID_Adh_Eleve`, `Civilite`, `Nom`, `Prenom`, `Adresse1`, `Adresse2`, `Code_Postal`, `Ville`, `Telephone`, `Fax`, `Portable`, `Courriel1`, `Courriel2`, `Signe`, `Caracteristique`, `Carnet`) VALUES

-- Supprimé car confidentiel
(``,``,``,``,``,``,``,``,``,``,``,``,``,``,``,``);

-- --------------------------------------------------------

--
-- Structure de la table `adhesions`
--

CREATE TABLE IF NOT EXISTS `adhesions` (
  `ID_Adhesion` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ID_Adh_Eleve` mediumint(8) unsigned NOT NULL,
  `Date_adhesion` date NOT NULL,
  `Montant` tinyint(4) unsigned NOT NULL,
  PRIMARY KEY (`ID_Adhesion`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=201 ;

--
-- Contenu de la table `adhesions`
--

INSERT INTO `adhesions` (`ID_Adhesion`, `ID_Adh_Eleve`, `Date_adhesion`, `Montant`) VALUES

-- Supprimé car confidentiel
(``,``,``,``);

-- --------------------------------------------------------

--
-- Structure de la table `adhesions_institutionnels`
--

CREATE TABLE IF NOT EXISTS `adhesions_institutionnels` (
  `ID_Adh_Institut` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ID_Institutionnel` mediumint(8) unsigned NOT NULL,
  `Date_adhesion` date NOT NULL,
  PRIMARY KEY (`ID_Adh_Institut`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `adhesions_sourds`
--

CREATE TABLE IF NOT EXISTS `adhesions_sourds` (
  `ID_Adhesion_sourd` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ID_Sourd` mediumint(8) unsigned NOT NULL,
  `Date_adhesion` date NOT NULL,
  PRIMARY KEY (`ID_Adhesion_sourd`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `courriels`
--
CREATE TABLE IF NOT EXISTS `courriels` (
`ID_Adh_Eleve` mediumint(8) unsigned
,`Civilite` enum('M.','Mme','M. ou Mme','Melle','Famille','Association')
,`Nom` varchar(20)
,`Prenom` varchar(26)
,`Adresse1` varchar(40)
,`Adresse2` varchar(25)
,`Code_Postal` varchar(5)
,`Ville` varchar(22)
,`Telephone` varchar(20)
,`Fax` varchar(20)
,`Portable` varchar(20)
,`Courriel1` varchar(40)
,`Courriel2` varchar(40)
,`Signe` longblob
,`Caracteristique` set('Entendant(e)','Sourd(e)','Malentendant(e)','Aveugle')
,`Carnet` tinyint(1)
);
-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `courrier_papier`
--
CREATE TABLE IF NOT EXISTS `courrier_papier` (
`ID_Adh_Eleve` mediumint(8) unsigned
,`Civilite` enum('M.','Mme','M. ou Mme','Melle','Famille','Association')
,`Nom` varchar(20)
,`Prenom` varchar(26)
,`Adresse1` varchar(40)
,`Adresse2` varchar(25)
,`Code_Postal` varchar(5)
,`Ville` varchar(22)
,`Telephone` varchar(20)
,`Fax` varchar(20)
,`Portable` varchar(20)
,`Courriel1` varchar(40)
,`Courriel2` varchar(40)
,`Signe` longblob
,`Caracteristique` set('Entendant(e)','Sourd(e)','Malentendant(e)','Aveugle')
);
-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `fax`
--
CREATE TABLE IF NOT EXISTS `fax` (
`ID_Adh_Eleve` mediumint(8) unsigned
,`Civilite` enum('M.','Mme','M. ou Mme','Melle','Famille','Association')
,`Nom` varchar(20)
,`Prenom` varchar(26)
,`Adresse1` varchar(40)
,`Adresse2` varchar(25)
,`Code_Postal` varchar(5)
,`Ville` varchar(22)
,`Telephone` varchar(20)
,`Fax` varchar(20)
,`Portable` varchar(20)
,`Courriel1` varchar(40)
,`Courriel2` varchar(40)
,`Signe` longblob
,`Caracteristique` set('Entendant(e)','Sourd(e)','Malentendant(e)','Aveugle')
);
-- --------------------------------------------------------

--
-- Structure de la table `institutionnels`
--

CREATE TABLE IF NOT EXISTS `institutionnels` (
  `ID_Institut` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `Civilite` enum('M.','Mme','Melle','Famille') NOT NULL,
  `Nom` varchar(20) NOT NULL,
  `Prenom` varchar(20) NOT NULL,
  `Fonction` varchar(20) NOT NULL,
  `Adresse1` varchar(30) NOT NULL,
  `Adresse2` varchar(30) NOT NULL,
  ` Code_Postal` varchar(5) NOT NULL,
  `Ville` varchar(25) NOT NULL,
  `Telephone` varchar(19) NOT NULL,
  `Fax` varchar(19) NOT NULL,
  `Portable` varchar(19) NOT NULL,
  `Courriel` varchar(40) NOT NULL,
  `Carnet` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID_Institut`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;
(())
--
-- Contenu de la table `institutionnels`
--

INSERT INTO `institutionnels` (`ID_Institut`, `Civilite`, `Nom`, `Prenom`, `Fonction`, `Adresse1`, `Adresse2`, ` Code_Postal`, `Ville`, `Telephone`, `Fax`, `Portable`, `Courriel`, `Carnet`) VALUES

-- Supprimé car confidentiel
(``,``,``,``,``,``,``,``,``,``,``,``,``,``);

-- --------------------------------------------------------

--
-- Structure de la table `niveaux_atteints`
--

CREATE TABLE IF NOT EXISTS `niveaux_atteints` (
  `ID_Niveau_atteint` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ID_Eleve` mediumint(8) unsigned NOT NULL,
  `Niveau_atteint` enum('A0','A1','A2','A3','A4','A5','A6','B1') NOT NULL,
  `Date_debut` date NOT NULL,
  `Date_fin` date NOT NULL,
  PRIMARY KEY (`ID_Niveau_atteint`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=121 ;

--
-- Contenu de la table `niveaux_atteints`
--

INSERT INTO `niveaux_atteints` (`ID_Niveau_atteint`, `ID_Eleve`, `Niveau_atteint`, `Date_debut`, `Date_fin`) VALUES


-- Supprimé car confidentiel
(``,``,``,``,``);

-- --------------------------------------------------------

--
-- Structure de la table `niveaux_eleves`
--
-- utilisé(#1356 - View 'lmst.niveaux_eleves' references invalid table(s) or column(s) or function(s) or definer/invoker of view lack rights to use them)
-- utilisé (#1356 - View 'lmst.niveaux_eleves' references invalid table(s) or column(s) or function(s) or definer/invoker of view lack rights to use them)

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `niveau_max_eleves`
--
CREATE TABLE IF NOT EXISTS `niveau_max_eleves` (
`ID_Eleve` mediumint(8) unsigned
,`Nom` varchar(20)
,`Prenom` varchar(26)
,`Date_debut` date
,`Date_fin` date
,`Niveau_atteint` enum('A0','A1','A2','A3','A4','A5','A6','B1')
,`Eleve` tinyint(1)
);
-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `portables`
--
CREATE TABLE IF NOT EXISTS `portables` (
`ID_Adh_Eleve` mediumint(8) unsigned
,`Civilite` enum('M.','Mme','M. ou Mme','Melle','Famille','Association')
,`Nom` varchar(20)
,`Prenom` varchar(26)
,`Adresse1` varchar(40)
,`Adresse2` varchar(25)
,`Code_Postal` varchar(5)
,`Ville` varchar(22)
,`Telephone` varchar(20)
,`Fax` varchar(20)
,`Portable` varchar(20)
,`Courriel1` varchar(40)
,`Courriel2` varchar(40)
,`Signe` longblob
,`Caracteristique` set('Entendant(e)','Sourd(e)','Malentendant(e)','Aveugle')
);
-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `sans_coordonnees`
--
CREATE TABLE IF NOT EXISTS `sans_coordonnees` (
`ID_Adh_Eleve` mediumint(8) unsigned
,`Civilite` enum('M.','Mme','M. ou Mme','Melle','Famille','Association')
,`Nom` varchar(20)
,`Prenom` varchar(26)
,`Adresse1` varchar(40)
,`Adresse2` varchar(25)
,`Code_Postal` varchar(5)
,`Ville` varchar(22)
,`Telephone` varchar(20)
,`Fax` varchar(20)
,`Portable` varchar(20)
,`Courriel1` varchar(40)
,`Courriel2` varchar(40)
,`Signe` longblob
,`Caracteristique` set('Entendant(e)','Sourd(e)','Malentendant(e)','Aveugle')
);
-- --------------------------------------------------------

--
-- Structure de la table `sourds`
--

CREATE TABLE IF NOT EXISTS `sourds` (
  `ID_Sourd` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `Civilite` enum('M.','Mme','Melle','Famille') NOT NULL,
  `Nom` varchar(20) NOT NULL,
  `Prenom` varchar(20) NOT NULL,
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- Contenu de la table `sourds`
--

INSERT INTO `sourds` (`ID_Sourd`, `Civilite`, `Nom`, `Prenom`, `Adresse1`, `Adresse2`, `Code_Postal`, `Ville`, `Telephone`, `Fax`, `Courriel`, `Portable`, `Signe`) VALUES


-- Supprimé car confidentiel
(``,``,``,``,``,``,``,``,``,``,``,``,``);

-- --------------------------------------------------------

--
-- Structure de la table `toujours_eleve`
--

CREATE TABLE IF NOT EXISTS `toujours_eleve` (
  `ID_toujours_eleve` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ID_Eleve` mediumint(8) unsigned NOT NULL,
  `Eleve` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID_toujours_eleve`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=121 ;

--
-- Contenu de la table `toujours_eleve`
--

INSERT INTO `toujours_eleve` (`ID_toujours_eleve`, `ID_Eleve`, `Eleve`) VALUES

--Supprimé car confidentiel
(``,``,``);

-- --------------------------------------------------------

--
-- Structure de la vue `adherents_a_jour`
--
DROP TABLE IF EXISTS `adherents_a_jour`;

CREATE ALGORITHM=UNDEFINED DEFINER=`lmst`@`%` SQL SECURITY DEFINER VIEW `adherents_a_jour` AS select `adherents_eleves`.`Civilite` AS `Civilite`,`adherents_eleves`.`Nom` AS `Nom`,`adherents_eleves`.`Prenom` AS `Prenom` from (`adherents_eleves` join `adhesions`) where ((`adherents_eleves`.`ID_Adh_Eleve` = `adhesions`.`ID_Adh_Eleve`) and (year(`adhesions`.`Date_adhesion`) > (year(now()) - 1))) order by `adherents_eleves`.`Nom`;

-- --------------------------------------------------------

--
-- Structure de la vue `courriels`
--
DROP TABLE IF EXISTS `courriels`;

CREATE ALGORITHM=UNDEFINED DEFINER=`lmst`@`%` SQL SECURITY DEFINER VIEW `courriels` AS select `adherents_eleves`.`ID_Adh_Eleve` AS `ID_Adh_Eleve`,`adherents_eleves`.`Civilite` AS `Civilite`,`adherents_eleves`.`Nom` AS `Nom`,`adherents_eleves`.`Prenom` AS `Prenom`,`adherents_eleves`.`Adresse1` AS `Adresse1`,`adherents_eleves`.`Adresse2` AS `Adresse2`,`adherents_eleves`.`Code_Postal` AS `Code_Postal`,`adherents_eleves`.`Ville` AS `Ville`,`adherents_eleves`.`Telephone` AS `Telephone`,`adherents_eleves`.`Fax` AS `Fax`,`adherents_eleves`.`Portable` AS `Portable`,`adherents_eleves`.`Courriel1` AS `Courriel1`,`adherents_eleves`.`Courriel2` AS `Courriel2`,`adherents_eleves`.`Signe` AS `Signe`,`adherents_eleves`.`Caracteristique` AS `Caracteristique`,`adherents_eleves`.`Carnet` AS `Carnet` from `adherents_eleves` where (`adherents_eleves`.`Courriel1` <> '') order by `adherents_eleves`.`Nom`;

-- --------------------------------------------------------

--
-- Structure de la vue `courrier_papier`
--
DROP TABLE IF EXISTS `courrier_papier`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `courrier_papier` AS select `adherents_eleves`.`ID_Adh_Eleve` AS `ID_Adh_Eleve`,`adherents_eleves`.`Civilite` AS `Civilite`,`adherents_eleves`.`Nom` AS `Nom`,`adherents_eleves`.`Prenom` AS `Prenom`,`adherents_eleves`.`Adresse1` AS `Adresse1`,`adherents_eleves`.`Adresse2` AS `Adresse2`,`adherents_eleves`.`Code_Postal` AS `Code_Postal`,`adherents_eleves`.`Ville` AS `Ville`,`adherents_eleves`.`Telephone` AS `Telephone`,`adherents_eleves`.`Fax` AS `Fax`,`adherents_eleves`.`Portable` AS `Portable`,`adherents_eleves`.`Courriel1` AS `Courriel1`,`adherents_eleves`.`Courriel2` AS `Courriel2`,`adherents_eleves`.`Signe` AS `Signe`,`adherents_eleves`.`Caracteristique` AS `Caracteristique` from `adherents_eleves` where ((`adherents_eleves`.`Courriel1` = '') and (`adherents_eleves`.`Adresse1` <> ''));

-- --------------------------------------------------------

--
-- Structure de la vue `fax`
--
DROP TABLE IF EXISTS `fax`;

CREATE ALGORITHM=UNDEFINED DEFINER=`lmst`@`%` SQL SECURITY DEFINER VIEW `fax` AS select `adherents_eleves`.`ID_Adh_Eleve` AS `ID_Adh_Eleve`,`adherents_eleves`.`Civilite` AS `Civilite`,`adherents_eleves`.`Nom` AS `Nom`,`adherents_eleves`.`Prenom` AS `Prenom`,`adherents_eleves`.`Adresse1` AS `Adresse1`,`adherents_eleves`.`Adresse2` AS `Adresse2`,`adherents_eleves`.`Code_Postal` AS `Code_Postal`,`adherents_eleves`.`Ville` AS `Ville`,`adherents_eleves`.`Telephone` AS `Telephone`,`adherents_eleves`.`Fax` AS `Fax`,`adherents_eleves`.`Portable` AS `Portable`,`adherents_eleves`.`Courriel1` AS `Courriel1`,`adherents_eleves`.`Courriel2` AS `Courriel2`,`adherents_eleves`.`Signe` AS `Signe`,`adherents_eleves`.`Caracteristique` AS `Caracteristique` from `adherents_eleves` where ((`adherents_eleves`.`Courriel1` = '') and (`adherents_eleves`.`Adresse1` = '') and (`adherents_eleves`.`Fax` <> ''));

-- --------------------------------------------------------

--
-- Structure de la vue `niveau_max_eleves`
--
DROP TABLE IF EXISTS `niveau_max_eleves`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `niveau_max_eleves` AS select `niveaux_atteints`.`ID_Eleve` AS `ID_Eleve`,`adherents_eleves`.`Nom` AS `Nom`,`adherents_eleves`.`Prenom` AS `Prenom`,min(`niveaux_atteints`.`Date_debut`) AS `Date_debut`,max(`niveaux_atteints`.`Date_fin`) AS `Date_fin`,max(`niveaux_atteints`.`Niveau_atteint`) AS `Niveau_atteint`,`toujours_eleve`.`Eleve` AS `Eleve` from ((`niveaux_atteints` join `adherents_eleves`) join `toujours_eleve`) where ((`niveaux_atteints`.`ID_Eleve` = `adherents_eleves`.`ID_Adh_Eleve`) and (`niveaux_atteints`.`ID_Eleve` = `toujours_eleve`.`ID_Eleve`)) group by `adherents_eleves`.`Nom`,`adherents_eleves`.`Prenom`;

-- --------------------------------------------------------

--
-- Structure de la vue `portables`
--
DROP TABLE IF EXISTS `portables`;

CREATE ALGORITHM=UNDEFINED DEFINER=`lmst`@`%` SQL SECURITY DEFINER VIEW `portables` AS select `adherents_eleves`.`ID_Adh_Eleve` AS `ID_Adh_Eleve`,`adherents_eleves`.`Civilite` AS `Civilite`,`adherents_eleves`.`Nom` AS `Nom`,`adherents_eleves`.`Prenom` AS `Prenom`,`adherents_eleves`.`Adresse1` AS `Adresse1`,`adherents_eleves`.`Adresse2` AS `Adresse2`,`adherents_eleves`.`Code_Postal` AS `Code_Postal`,`adherents_eleves`.`Ville` AS `Ville`,`adherents_eleves`.`Telephone` AS `Telephone`,`adherents_eleves`.`Fax` AS `Fax`,`adherents_eleves`.`Portable` AS `Portable`,`adherents_eleves`.`Courriel1` AS `Courriel1`,`adherents_eleves`.`Courriel2` AS `Courriel2`,`adherents_eleves`.`Signe` AS `Signe`,`adherents_eleves`.`Caracteristique` AS `Caracteristique` from `adherents_eleves` where ((`adherents_eleves`.`Courriel1` = '') and (`adherents_eleves`.`Adresse1` = '') and (`adherents_eleves`.`Fax` = '') and (`adherents_eleves`.`Portable` <> ''));

-- --------------------------------------------------------

--
-- Structure de la vue `sans_coordonnees`
--
DROP TABLE IF EXISTS `sans_coordonnees`;

CREATE ALGORITHM=UNDEFINED DEFINER=`lmst`@`%` SQL SECURITY DEFINER VIEW `sans_coordonnees` AS select `adherents_eleves`.`ID_Adh_Eleve` AS `ID_Adh_Eleve`,`adherents_eleves`.`Civilite` AS `Civilite`,`adherents_eleves`.`Nom` AS `Nom`,`adherents_eleves`.`Prenom` AS `Prenom`,`adherents_eleves`.`Adresse1` AS `Adresse1`,`adherents_eleves`.`Adresse2` AS `Adresse2`,`adherents_eleves`.`Code_Postal` AS `Code_Postal`,`adherents_eleves`.`Ville` AS `Ville`,`adherents_eleves`.`Telephone` AS `Telephone`,`adherents_eleves`.`Fax` AS `Fax`,`adherents_eleves`.`Portable` AS `Portable`,`adherents_eleves`.`Courriel1` AS `Courriel1`,`adherents_eleves`.`Courriel2` AS `Courriel2`,`adherents_eleves`.`Signe` AS `Signe`,`adherents_eleves`.`Caracteristique` AS `Caracteristique` from `adherents_eleves` where ((`adherents_eleves`.`Courriel1` = '') and (`adherents_eleves`.`Adresse1` = '') and (`adherents_eleves`.`Fax` = '') and (`adherents_eleves`.`Portable` = ''));

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
