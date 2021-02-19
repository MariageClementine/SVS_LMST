<?php
$logOK=require('includes/coSite.inc.php');
if($logOK==true)
{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Gestion des adh&eacute;rents de l'association &laquo; Le Monde des Sourds pour tous &raquo</title>
<meta name="author" content="Laurent Ceard">
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="ROBOTS" content="INDEX, FOLLOW, ALL">
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<link href="css/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php include_once("includes/config.inc.php"); ?>
<?php include_once("includes/lib/lib_date.inc.php"); ?>
<?php include_once("includes/lib/lib_forms.inc.php"); ?>
<?php include_once("includes/lib/lib_db.inc.php"); ?>
<?php include_once("includes/connexion.inc.php"); ?>
<div id="page">
	<?php include_once("includes/header.inc.php"); ?>
	<div id="titrePage">
		<h1>Gestion d'un adh&eacute;rent.</h1>
	</div>
	<div id="zonemenu">
		<?php include_once("includes/menu.inc.php"); ?>
	</div>
	<div id="contenu">
		<p><a href="#bottom">Aller en bas de page</a></p>
		<h3>Un &eacute;l&egrave;ve &eacute;tant forc&eacute;ment adh&eacute;rent.</h2>
<?php

///////////////////////////////
// Page BEAUCOUP TROP LONGUE //
// Voir ci-dessous           //
///////////////////////////////


//Si on a clique sur le bouton "Valider" (adherent) -> sur plusieurs actions
if(isset($_POST['valider_adherent']))
{
	//On recupere le numero de l'enregistrement
	$recup_num	= $_POST['numero'];
//	echo "Clic modifier $recup_num<br>";
	$recup_id	= $_POST['dernier_id_adh_eleve'];
	$recup_action	= $_POST['action_adherent'];
//	echo "Dernier ID $recup_id<br>";

	//Si on a bien saisi un chiffre et qu'il n'est pas superieur au nombre d'enregistrements de la table
	//Ce test suppose que les ID_Adh_Eleves sont bien consecutifs et qu'il n'y a pas de "trous"
	if( ($recup_num >= 1) & ($recup_num <= $recup_id) )
	{
		//modification du script
		//Si l'enregistrement existe
		$requete = "SELECT * FROM adherents WHERE ID_Adherent = $recup_num";
//		echo "$requete<br>";
		if($result = mysql_query($requete,$id_serveur))
		{
			if($nb_result = mysql_num_rows($result))
			{
//				echo "Saisie correcte<br>";
				switch($recup_action)
				{
					//modification
					case "Modifier":
//						echo "Modifier<br>";
						//On recupere le contenu de l'enregistrement demande
						$requete = "SELECT * FROM adherents WHERE ID_Adherent = $recup_num";
						//On execute la requete
						if($result = mysql_query($requete,$id_serveur))
						{
//							echo "Requete SELECT OK<br>";
							//Il ne peut y avoir qu'un seul enregistrement. Ce n'est donc pas la peine de mettre un while
							$ligne = mysql_fetch_array($result);
							$ID_Adherent	= $ligne["ID_Adherent"];
							$Civilite	= $ligne["Civilite"];
							//On oublie pas de faire les conversion de caractères qui vont bien
							$Nom		= str_replace("'","\'",strtoupper($ligne["Nom"]));
							$Prenom		= $ligne["Prenom"];
							$Adresse1	= $ligne["Adresse1"];
							$Adresse2	= $ligne["Adresse2"];
							$Code_Postal	= $ligne["Code_Postal"];
							$Ville		= $ligne["Ville"];
							$Telephone	= $ligne["Telephone"];
							$Fax		= $ligne["Fax"];
							$Portable	= $ligne["Portable"];
							$Courriel1	= $ligne["Courriel1"];
							$Courriel2	= $ligne["Courriel2"];
							$Caracteristique= $ligne["Caracteristique"];
							$Carnet		= $ligne["Carnet"];
							//On cree le formulaire en le remplissant avec ce que l'on a recupere
							echo "<form action=\"\" method=\"post\">";
							echo "<table>";
							echo "<tr>";
							echo "<td>Civilit&eacute; :</td>";
							echo "<td>";
							echo "<SELECT NAME=\"civilite\">";
							$liste_civilite = getEnumVals($id_serveur,"adherents","Civilite");
							//On parcours le tableau du début à la fin
							for ($ID_Civilite = 0;$ID_Civilite<Count($liste_civilite);$ID_Civilite++)
							{
								//Et on constitue la liste déroulante
								//Si la valeur courant de la liste est différente de celle d'origine
								if($liste_civilite[$ID_Civilite]!=$Civilite)
								{
									echo "<OPTION VALUE=\"$liste_civilite[$ID_Civilite]\">$liste_civilite[$ID_Civilite]</OPTION>";
								}
								else
								{
									//Sinon c'est elle qui est sélectionnée
									echo "<OPTION VALUE=\"$liste_civilite[$ID_Civilite]\" SELECTED>$liste_civilite[$ID_Civilite]</OPTION>";
								}
							}
							echo "</SELECT>";
							echo "</td>";
							echo "</tr>";

							echo "<tr>";
							echo "<td>Nom :</td>";
							echo "<td><input type=\"text\" name=\"nom\" value=\"$Nom\" maxlength=\"20\" /></td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td>Pr&eacute;nom :</td>";
							echo "<td><input type=\"text\" name=\"prenom\" value=\"$Prenom\" maxlength=\"26\" /></td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td>Adresse 1 :</td>";
							echo "<td><input type=\"text\" name=\"adresse1\" value=\"$Adresse1\" maxlength=\"40\" /></td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td>Adresse 2 :</td>";
							echo "<td><input type=\"text\" name=\"adresse2\" value=\"$Adresse2\" maxlength=\"25\" /></td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td>Code Postal :</td>";
							echo "<td><input type=\"text\" name=\"code_postal\" value=\"$Code_Postal\" maxlength=\"5\" /></td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td>Ville</td>";
							echo "<td><input type=\"text\" name=\"ville\" value=\"$Ville\" maxlength=\"22\" /></td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td>Telephone :</td>";
							echo "<td><input type=\"text\" name=\"telephone\" value=\"$Telephone\" maxlength=\"20\" /></td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td>Fax :</td>";
							echo "<td><input type=\"text\" name=\"fax\" value=\"$Fax\" maxlength=\"20\" /></td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td>Portable :</td>";
							echo "<td><input type=\"text\" name=\"portable\" value=\"$Portable\" maxlength=\"20\" /></td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td>Courriel&nbsp;1 :</td>";
							echo "<td><input type=\"text\" name=\"courriel1\" value=\"$Courriel1\" maxlength=\"40\" /></td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td>Courriel&nbsp;2 :</td>";
							echo "<td><input type=\"text\" name=\"courriel2\" value=\"$Courriel2\" maxlength=\"40\" /></td>";
							echo "</tr>";
							echo "<tr>";
							echo "<td>Caract&eacute;ristique :</td>";
							echo "<td>";
							echo "<SELECT MULTIPLE name=\"caracteristique\">";
							$liste_caracteristique = getEnumVals($id_serveur,"adherents","Caracteristique");
							//On parcours le tableau du début à la fin
							for ($ID_Caracteristique = 0;$ID_Caracteristique<Count($liste_caracteristique);$ID_Caracteristique++)
							{
								//Et on constitue la liste déroulante
								//Si la valeur courant de la liste est différente de celle d'origine
								if($liste_caracteristique[$ID_Caracteristique]!=$Caracteristique)
								{
									echo "<OPTION VALUE=\"$liste_caracteristique[$ID_Caracteristique]\">$liste_caracteristique[$ID_Caracteristique]</OPTION>";
								}
								else
								{
									//Sinon c'est elle qui est sélectionnée
									echo "<OPTION VALUE=\"$liste_caracteristique[$ID_Caracteristique]\" SELECTED>$liste_caracteristique[$ID_Caracteristique]</OPTION>";
								}
							}
							echo "</SELECT>";
							echo "</td>";
							echo "<tr>";
							echo "<td>Carnet d'adresse central&nbsp;:</td>";
							echo "<td>";
							if($Carnet == true)
							{
								echo "<input type=\"radio\" name=\"carnet\" value=0>Faux";
								echo "<input type=\"radio\" name=\"carnet\" value=1 CHECKED>Vrai<br>";
							}
							else
							{
								echo "<input type=\"radio\" name=\"carnet\" value=0 CHECKED>Faux";
								echo "<input type=\"radio\" name=\"carnet\" value=1>Vrai<br>";
							}
							echo "</td>";
							echo "</tr>";
							echo "</table>";
							echo "<input type=\"hidden\" name=\"id_adh_eleve\" value=\"$ID_Adherent\" />";
							echo "<input type=\"submit\" name=\"modif_adherent\" value=\"Modifier\" /><br>";
							echo "</form>";
						}
						else
						{
							echo "Requete SELECT NOK<br>";
						}
					break;

					//modif ajout et suppr adhesion -> ajouter_adherent.php
					case "Gerer_adhesion":
						echo "Gestion des adh&eacute;sions.<br>";
						//On affiche la liste des adhesions de cet adherent
						//Il faut pouvoir Ajouter, Modifier, Supprimer
						$requete = "SELECT * FROM adhesions WHERE ID_Adherent = $recup_num";
						if($result = mysql_query($requete,$id_serveur))
						{
							echo "<table border=1>";
							echo "<tr>";
							echo "<td>N°=</td>";
							echo "<td>Date d'adh&eacute;sion</td>";
							echo "<td>Montant</td>";
							echo "</tr>";
							while($ligne = mysql_fetch_array($result))
							{
								$ID_Adhesion	=	$ligne["ID_Adhesion"];
								$Date_adhesion	=	$ligne["Date_adhesion"];
								$Montant	=	$ligne["Montant"];
								echo "<tr>";
								echo "<td>$ID_Adhesion</td>";
								echo "<td>$Date_adhesion</td>";
								echo "<td align=\"right\">$Montant</td>";
								echo "</tr>";
							}
							echo "</table><br>";
							//On cree le formulaire en le remplissant avec ce que l'on a récupéré
///////////////////////////////////////////////
// Déplacer le code pointé par ce formulaire //
// dans une page gerer_adhesion.php          //
///////////////////////////////////////////////
							echo "<form action=\"\" method=\"post\">";
							//La premiere date d'adhesion est cree lors de l'ajout de l'adherent fonction "ajout_adhesion"
							echo "<input type =\"submit\" name =\"ajouter_adhesion\" value=\"Ajouter adh&eacute;sion\" /><br>";
////////////////////////////////////////////////////////////////////////////////////////////////
// Mettre une liste déroulante pour éviter les erreurs de saisie dans le numéro de l'adhérant //
////////////////////////////////////////////////////////////////////////////////////////////////
							echo "Num&eacute;ro de l'adh&eacute;sion : <input type =\"text\" name =\"num_modif\" /> ";
							echo "<select name=\"action_adhesion\">";
							echo "<option value=\"Modifier\">Modifier</option>";
							echo "<option value=\"Supprimer\">Supprimer</option>";
							echo "</select>";
							echo "<input type =\"hidden\" name=\"id_adherent\" value=\"$recup_num\" />";
							echo "<input type =\"hidden\" name=\"date_adhesion\" value=\"$Date_adhesion\" />";
							echo "<input type =\"hidden\" name=\"montant_adhesion\" value=\"$Montant\" />";
							echo "<input type =\"submit\" name=\"gest_adhesion\" value=\"Valider\" />";
							echo "</form>";
						}
						else
						{
							echo "Erreur sur la requ&ecirc;te de s&eacute;lection des adh&eacute;sions.<br>";
						}
					break;
					//créer un eleve a partir d'un adherent
					case "Passer_eleve" :
						echo "Passer &eacute;l&egrave;ve<br>";
						//On verifie si l'enregistrement existe deja
						$requete = "SELECT ID_Eleve FROM eleves WHERE ID_Adherent = $recup_num";
						if($result = mysql_query($requete,$id_serveur))
						{
							echo "$requete<br>";
							//S'il y a un resultat
							if( $nb_result = mysql_num_rows($result))
							{
								echo "<b>Cet adh&eacute;rent est d&eacute;j&agrave; un &eacute;l&egrave;ve.</b><br>";
							}
							else
							{
								//Sinon on insere les valeurs
								// Dans la table 'toujours_eleve'
								//on recupere la val max de l'id eleve et on l'incrémente
								$req="SELECT max(ID_Eleve)+1 FROM eleves";
								$occur=mysql_query($req);
								$maLigne=mysql_fetch_array($occur);
								$ID_Eleve=$maLigne[0];

								$requete = "INSERT INTO eleves (ID_Eleve, ID_Adherent, tjs_eleve) VALUES ($ID_Eleve, $recup_num, TRUE)";
								if($result = mysql_query($requete,$id_serveur))
								{
									echo "Mise &agrave; jour de la table 'eleves' OK<br>";
									//Puis on insere dans la table 'niveaux_atteints'
									$req2="SELECT max(ID_Niveau_atteint)+1 FROM niveaux_atteints";
									$occur2=mysql_query($req2);
									$maLigne2=mysql_fetch_array($occur2);
									$ID_Niveau_atteint=$maLigne2[0];

									$requete = "INSERT INTO niveaux_atteints (ID_Niveau_atteint, ID_Eleve, Niveau_atteint, Date_debut, Date_fin) VALUES ($ID_Niveau_atteint, $ID_Eleve, 'A0', now(), now())";
									if($result = mysql_query($requete,$id_serveur))
									{
										echo "Mise &agrave; jour de la table 'niveaux_atteint' OK<br>";
									}
									else
									{
										echo "Mise &agrave; jour de la table 'niveaux_atteint' NOK<br>";
									}
								}
								else
								{
									echo "Requete INSERT NOK<br>";
								}
							}
						}
						else
						{
							echo "Erreur sur la requ&ecirc;te pour v&eacute;rification de l'&eacute;l&egrave;ve<br>";
						}
					break;
					//supprimer un membre
					case "Supprimer" :
						echo "Supprimer<br>";
						//On verifie si c'est un eleve
						$requete = "SELECT * FROM eleves WHERE ID_Adherent = $recup_num";
						if($result = mysql_query($requete,$id_serveur))
						{
							if($nb_result = mysql_num_rows($result))
							{
								echo "<b>Cet adh&eacute;rent est un &eacute;l&egrave;ve. Vous devez d'abord le supprimer des &eacute;l&egrave;ves.</b><br>";
							}
							else
							{
								//On supprime de la table 'adherents'
								$req1="DELETE FROM adhesions WHERE ID_Adherent = $recup_num";
								$requete = "DELETE FROM adherents WHERE ID_Adherent = $recup_num";
//								echo "$requete<br>";	//debug
								if($result1 =mysql_query($req1,$id_serveur))
								{
									if($result = mysql_query($requete,$id_serveur))
									{
										echo "Suppression correctement effectu&eacute;e";
									}
									else
									{
										echo "Erreur sur la requ&ecirc;te de suppression de l'adh&eacute;rent.<br>";
									}
								}
								else
								{
									echo "Erreur sur la requ&ecirc;te de suppression de l'adh&eacute;sion.<br>";
								}
							}
						}
						else
						{
							echo "Erreur sur la requ&ecirc;te de v&eacute;rification.<br>";
						}
					break;

					default :
						echo "Ce n'est pas possible : $recup_action<br>";
				}//fin du switch
			}
			else
			{
				echo "Cet adh&eacute;rent n'existe pas.<br>";
			}
		}
		else
		{
			echo "Erreur lors de la requ&ecirc;te de v&eacute;rification.<br>";
		}
	}
	else
	{
		echo "Saisie incorrecte<br>";
		echo "Numero = $recup_num<br>";
		echo "Nombre resultats = $recup_id";
	}
}
else
{
	///Traitement de la validation des actions ///
	//Si on a clique sur le bouton "Modifier" (adherent)
	if(isset($_POST['modif_adherent']))
	{
		echo "Modification adh&eacute;rent<br>";
		//On recupere les donnees
		$recup_id_adh		= $_POST['id_adh_eleve'];
		$recup_civilite		= $_POST['civilite'];
		//On met le nom en majscule
		$recup_nom		= strtoupper($_POST['nom']);
		//On ne met pas le prénom en minuscule puis la première en majscule à cause des prénoms composés
		$recup_prenom		= $_POST['prenom'];
		$recup_adresse1		= str_replace("'","\'",$_POST['adresse1']);
		$recup_adresse2		= str_replace("'","\'",$_POST['adresse2']);
		$recup_code_postal	= $_POST['code_postal'];
		//On met la ville en majuscule
		$recup_ville		= str_replace("'","\'",strtoupper($_POST['ville']));
		//Pour le stockage dans la base de données on enlève les espaces
		$recup_telephone	= str_replace(" ","",$_POST['telephone']);
		$recup_fax		= str_replace(" ","",$_POST['fax']);
		$recup_portable		= str_replace(" ","",$_POST['portable']);
		$recup_courriel1	= $_POST['courriel1'];
		$recup_courriel2	= $_POST['courriel2'];
		$recup_caracteristique	= $_POST['caracteristique'];
		$recup_carnet		= $_POST['carnet'];
		//On prepare la requete
		$requete = "UPDATE adherents SET Civilite = '$recup_civilite', Nom = '$recup_nom', Prenom = '$recup_prenom', Adresse1 = '$recup_adresse1', Adresse2 = '$recup_adresse2', Code_Postal = '$recup_code_postal', Ville = '$recup_ville', Telephone = '$recup_telephone', Fax = '$recup_fax', Portable = '$recup_portable', Courriel1 = '$recup_courriel1', Courriel2 = '$recup_courriel2', Caracteristique = '$recup_caracteristique', Carnet = '$recup_carnet' WHERE ID_Adherent = $recup_id_adh";
		//Execution de la requete
		if($result = mysql_query($requete,$id_serveur))
		{
			echo "Mise &agrave; jour correctement effectu&eacute;e<br>";
			echo "Carnet : $recup_carnet";
		}
		else
		{
			echo "Erreur sur la mise &agrave; jour<br>";
		}
	}
	else
	{
		//Si on a clique sur le bouton "Ajouter adhesion" (dans gestion des adhesions)
		if(isset($_POST['ajouter_adhesion']))
		{
			//On recupere les valeurs
			$recup_id_adherent = $_POST['id_adherent'];

			//On cree le formulaire pour ajouter l'adhesion
			echo "<form action =\"\" method=\"post\">";
			echo "<table>";
			echo "<tr>";
			echo "<td>Date d'adh&eacute;sion&nbsp;:</td>";
			echo "<td><input type =\"text\" name=\"date_nouv_adhesion\"  maxlength=\"10\" /> (jj-mm-aaaa)</td>";
			echo "</tr>";
			echo "<tr>";
			echo "<td>Montant&nbsp;:</td>";
			echo "<td><input type=\"text\" name=\"nouv_montant\" maxlength=\"2\" /></td>";
			echo "</tr>";
			echo "</table>";
			echo "<input type =\"hidden\" name=\"transfert_id_adherent\" value=\"$recup_id_adherent\" />";
			echo "<input type =\"submit\" name=\"ajout_adhesion\">";
			echo "</form>";
		}
		else
		{
///////////////////////////////////////////////////////////////////
// Déplacer le code ci-dessous dans une page gerer_adhesion.php  //
//  Puis éventuellement séparer l'ajout de la gestion            //
//   en mettant deux formulaires comme pour les adhérents        //
///////////////////////////////////////////////////////////////////
			//Si on a clique sur le bouton "Valider" (gest_adhesion)
			if(isset($_POST['gest_adhesion']))
			{
				$recup_num_modif	= $_POST['num_modif'];
				$recup_action_adhesion	= $_POST['action_adhesion'];
				/*$recup_date_adh		= $_POST['date_adhesion'];
				$recup_montant_adh	= $_POST['montant_adhesion'];*/
				//On verifie que ce qui a ete saisi existe


				$requete = "SELECT * FROM adhesions WHERE ID_Adhesion = $recup_num_modif";

				if($result = mysql_query($requete,$id_serveur))
				{
///////////////////////////////////////////////////////////////////////////////
//Quel intérêt de faire passer les valeurs puisqu'on peut les relire ici !!! //
///////////////////////////////////////////////////////////////////////////////
					if($nb_result = mysql_num_rows($result))
					{
						//Selon ce que l'on a choisit
						switch($recup_action_adhesion)
						{
							case "Modifier" :
								//echo ($recup_num_modif);
								//echo ($requete);
								$occur=mysql_query($requete);
								$maLigne=mysql_fetch_array($occur);
								$date=$maLigne['Date_adhesion'];
								$montant=$maLigne['Montant'];
								//Il faut recuperer les valeurs, les mettre dans un formulaire
								//$Date_adhesion	= date_sql_to_fr($recup_date_adh);
								$Date_adhesion	= date_sql_to_fr($date);
								echo "<form action=\"\" method=\"post\">";
								echo "<table>";
								echo "<tr>";
								echo "<td>Date d'adh&eacute;sion :</td>";
								echo "<td><input type=\"text\" name=\"date_adhesion\" value=\"$Date_adhesion\" maxlength=\"10\" /> (jj-mm-aaaa)</td>";
								echo "</tr>";
								echo "<tr>";
								echo "<td>Montant :</td>";
								//echo "<td><input type=\"text\" name=\"montant_adhesion\" value=\"$recup_montant_adh\" maxlength=\"2\" /></td>";
								echo "<td><input type=\"text\" name=\"montant_adhesion\" value=\"$montant\" maxlength=\"2\" /></td>";
								echo "</tr>";
								echo "</table>";
								echo "<input type=\"hidden\" name=\"transfert_id_adhesion\" value=\"$recup_num_modif\" />";
								echo "<input type=\"submit\" name=\"modif_adhesion\" value=\"Valider\" />";
								echo "</form>";
							break;

							case "Supprimer" :
								//On prepare la requete de suppression
								$requete = "DELETE FROM adhesions WHERE ID_Adhesion = $recup_num_modif";
								//On l'execute
								if($result = mysql_query($requete,$id_serveur))
								{
									echo "La suppression a &eacute;t&eacute; correctement effectu&eacute;e<br>";
								}
								else
								{
									echo "Erreur lors de la suppression.<br>";
								}
							break;

							default :
						}
					}
					else
					{
						echo "Ce num&eacute;ro d'adh&eacute;sion n'existe pas.<br>";
					}
				}
				else
				{
					echo "Erreur sur la verification des adh&eacute;sions";
				}
			}
			else
			{
				//Validation de l'ajout d'une adhesion
				if(isset($_POST['ajout_adhesion']))
				{
					//On recupere les valeurs
					$recup_id_adherent	= $_POST['transfert_id_adherent'];
					$recup_date_adhesion	= $_POST['date_nouv_adhesion'];
					$recup_nouv_montant	= $_POST['nouv_montant'];
					//On converti la date
					$date_adhesion_sql = date_fr_to_sql($recup_date_adhesion);
					//Si la conversion c'est bien passe ET si on a saisi une date superieure a la date de creation ET inférieure ou égale à la date du jour
/////////////////
// a optimiser //
/////////////////
					$date_aujourdhui = date ("Y-m-d");
					if( ($date_adhesion_sql) && ($date_adhesion_sql > $date_creation) && ($date_adhesion_sql <= $date_aujourdhui) )
					{
						if(is_numeric($recup_nouv_montant))
						{
							echo "Date d'adhesion $date_adhesion_sql correcte.<br>";
							//On peut mettre a jour dans la base
							$req="SELECT max(ID_Adhesion)+1 FROM adhesions";
							$occur=mysql_query($req);
							$maLigne=mysql_fetch_array($occur);
							$ID_AdhesionAjout=$maLigne[0];
							$requete = "INSERT INTO adhesions (ID_Adhesion, ID_Adherent, Date_adhesion, Montant) VALUES ($ID_AdhesionAjout, $recup_id_adherent,\"$date_adhesion_sql\",$recup_nouv_montant)";
							if($result = mysql_query($requete,$id_serveur))
							{
								echo "Mise &agrave; jour de la date d'adh&eacute;sion correctement effectu&eacute;e.<br>";
							}
							else
							{
								echo "Erreur lors de la mise &agrave; jour de la date d'adh&eacute;sion.<br>";
							}
						}
						else
						{
							echo "Veuillez saisir un chiffre dans le montant.<br>";
						}
					}
					else
					{
						echo "Erreur dans la date d'adh&eacute;sion : $date_adhesion_sql, $recup_date_adhesion, $date_aujourdhui, $date_creation.<br>";
					}
				}
				else
				{
					//Validation de la modification d'une date d'adhesion
					if(isset($_POST['modif_adhesion']))
					{
						//On recupere les valeurs
						$recup_id_adhesion	= $_POST['transfert_id_adhesion'];
						$recup_date_adhesion	= $_POST['date_adhesion'];
						$recup_montant		= $_POST['montant_adhesion'];
						//On n'a pas besoin de verifier si l'identifiant existe car cela a ete fait auparavant
						//On converti la date du format francais en SQL
						$date_adhesion_sql = date_fr_to_sql($recup_date_adhesion);
						echo "date_adhesion : $recup_date_adhesion.<br>";
						echo "date_adhesion_sql : $date_adhesion_sql.<br>";
						//Si la convertion c'est bien passe ET si on a saisi une date superieure a la date de creation					
						if( ($date_adhesion_sql) && ($date_adhesion_sql > $date_creation) )
						{
//							echo "Date d'adh&eacute;sion correcte.<br>";
							//On peut mettre a jour dans la base
							$requete = "UPDATE adhesions SET Date_adhesion = '$date_adhesion_sql', Montant = $recup_montant WHERE ID_Adhesion = '$recup_id_adhesion'";
							echo "$requete<br>";
							if($result = mysql_query($requete,$id_serveur))
							{
								echo "Mise &agrave; jour de l'adh&eacute;sion correctement effectu&eacute;e.<br>";
							}
							else
							{
								echo "Erreur lors de la mise &agrave; jour de la date d'adh&eacute;sion.<br>";
							}
						}
						else
						{
							echo "Erreur dans la date d'adh&eacute;sion.<br>";
						}
					}
					else
					{
						echo "Vous ne devriez pas &ecirc;tre arriv&eacute; ici.<br>";
					}
				}
			}
		}
	}
}
?>
	<?php include_once("includes/footer.inc.php"); ?>
</div>
</body>
</html>
<?php
}//fin if est connecté

else
{
	header('Location: index.php');
}
?>
