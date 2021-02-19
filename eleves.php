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
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<link href="css/styles.css" rel="stylesheet" type="text/css">
	</head>
	<body>
	<?php include_once("includes/config.inc.php"); ?>
	<?php include_once("includes/lib/lib_date.inc.php"); ?>
	<?php include_once("includes/lib/lib_forms.inc.php"); ?>
	<?php include_once("includes/connexion.inc.php"); ?>
	<div id="page">
		<?php include_once("includes/header.inc.php"); ?>
		<div id="titrePage">
				<h1>Liste des &eacute;l&egrave;ves avec leurs niveaux respectifs.</h2>
		</div>
		<div id="zonemenu">
			<?php include_once("includes/menu.inc.php"); ?>
		</div>
		<div id="contenu">
			<p><a href="#bottom">Aller en bas de page</a></p>
			<h3>Rappel : un &eacute;l&egrave;ve est avant tout un adh&eacute;rent. Pour ajouter un &eacute;l&egrave;ve commencer par le rajouter en adh&eacute;rent.</h3>
	<?php
	//Si on a clique sur le bouton "Valider"
	if(isset($_POST['valider_eleve']))
	{
		//On recupere le numero de l'eleve
		$recup_action = $_POST['action_eleve'];
		$recup_num = $_POST['numero'];
	//	echo "Clic ajouter niveau pour $recup_num<br>";
		$recup_id = $_POST['dernier_id_eleve'];
	//	echo "Nb enregistrements $recup_id<br>";

		//Si le numero que l'on a saisi est compris entre 1 et le nombre d'enregistrement
//		if( ($recup_num >= 1) & ($recup_num <= $recup_id) )
		//{
			
			/// On verifie si l'enregistrement existe //
			//Preparation de la requete
			$requete = "SELECT * FROM adherents WHERE ID_Adherent = $recup_num";

			//Execution de la requete
			if($result = mysql_query($requete,$id_serveur))
			{
				//Si la requete a donne des resultats
				if($nb_result = mysql_num_rows($result))
				{

					//On relit le nom et le prenom
					$ligne = mysql_fetch_array($result);
					$recup_prenom	= $ligne['Prenom'];
					$recup_nom	= $ligne['Nom'];
				
					//au vu de la modification de la base, il faut récuperer une nouvelle valeur: l'id de l'eleve
					$req="SELECT ID_Eleve FROM eleves where ID_Adherent = $recup_num ";
					$occur=mysql_query($req);
					$maLigne	= mysql_fetch_array($occur);
					$recup_num_elv=$maLigne[0];

//					echo "Saisie correcte";
					//On recupere le contenu de l'enregistrement demande : la liste des niveaux que cet eleve a effectue
					echo "Liste des niveaux atteints par <b>$recup_prenom $recup_nom</b><br>";
					//ICI
					$requete = "SELECT * FROM niveaux_atteints natural join eleves WHERE ID_Eleve = $recup_num_elv ";
					//On execute la requete
					if($result = mysql_query($requete,$id_serveur))
					{
						//On affiche le tableau des niveaux que cet eleve a atteint
						echo "<table border=1>";
						echo "<tr>";
						echo "<td>N° du niveau=</td>";
						echo "<td>Niveau atteint</td>";
						echo "<td>Date d&eacute;but</td>";
						echo "<td>Date fin</td>";
						echo "</tr>";

						while($ligne = mysql_fetch_array($result))
						{
							$ID_Niveau_atteint	=	$ligne['ID_Niveau_atteint'];
							$Niveau_atteint		=	$ligne['Niveau_atteint'];
							$Date_debut		=	date_sql_to_fr($ligne['Date_debut']);
							$Date_fin		=	date_sql_to_fr($ligne['Date_fin']);
							//En theorie cela ne sert a rien de le mettre la car la valeur est toujours la meme mais on est oblige
//							$Toujours_eleve		= 	$ligne['Eleve'];
							echo "<tr>";
							echo "<td>$ID_Niveau_atteint</td>";
							echo "<td>$Niveau_atteint</td>";
							echo "<td>$Date_debut</td>";
							echo "<td>$Date_fin</td>";
							echo "</tr>";
						}
						echo "</table>";

						//Selon l'action que l'on a demande
						switch($recup_action)
						{
							case "Modifier niveau" :
								//On cree le formulaire pour choisir le niveau a modifier
								echo "<form action=\"\" method=\"post\">";
								echo "Niveau &agrave; modifier : <input type=\"text\" name=\"niveau_a_modifier\"/>";
								echo "<input type=\"submit\" name=\"modifier_niveau\" value=\"Modifier niveau\" /><br>";
								echo "</form>";
							break;

							case "Ajouter niveau" :
								//On cree le formulaire pour ajouter un nouveau niveau
								echo "<form action=\"\" method=\"post\">";
								echo "<table>";
								echo "<tr>";
								echo "<td>Niveau atteint :</td>";
								//Liste deroulante contenant l'ensemble des niveaux
////////////////////////////	///
//// Fonction Liste niveau /	///
////////////////////////////	///
								echo "<td>";
								echo "<select name=\"niveau_atteint\">";
								//On demande les caracteristiques du champ ENUM
								$result=mysql_query("SHOW COLUMNS FROM niveaux_atteints WHERE field='niveau_atteint'",$id_serveur);
								//On recupere le resultat de la requete par colonne/champ dans un tableau
								$colonne = mysql_fetch_row($result);
								//On extrait les differentes valeurs du ENUM
								foreach(explode("','",substr($colonne[1],6,-2)) as $valeur)
								{
									//Que l'on encadre par ce qui va bien
									print("<option>$valeur</option>");
								}
								echo "</select>";
								echo "</td>";
								echo "</tr>";
								echo "<tr>";
								echo "<td>Date de d&eacute;but :</td>";
								echo "<td><input type=\"text\" name=\"date_debut\"/> (jj-mm-aaaa)</td>";
								echo "</tr>";
								echo "<tr>";
								echo "<td>Date de fin :</td>";
								echo "<td><input type=\"text\" name=\"date_fin\"/> (jj-mm-aaaa)</td>";
								echo "</tr>";
								echo "</table>";
								echo " <input type=\"hidden\" name=\"eleve\" value=\"$recup_num\" />";
								echo " <input type=\"submit\" name=\"ajout_niveau\" value=\"Ajouter niveau\" /><br>";
								echo "</form>";	
							break;

							case "Supprimer niveau" :
								//On cree le formulaire pour choisir le niveau a supprimer
								echo "<form action=\"\" method=\"post\">";
								echo "Niveau &agrave; supprimer : <input type=\"text\" name=\"niveau_a_supprimer\"/> ";
								echo "<input type=\"submit\" name=\"supprimer_niveau\" value=\"Supprimer niveau\" /><br>";
								echo "</form>";
							break;

							case "Enlever eleve" :
								//On cree la requete pour devalider l'eleve
								$requete = "UPDATE eleves SET tjs_eleve = FALSE WHERE ID_Eleve = $recup_num_elv";
								if($result = mysql_query($requete,$id_serveur))
								{
									echo "Mise &agrave; jour de l'&eacute;l&egrave;ve correctement effectu&eacute;e.<br>";
								}
								else
								{
									echo "Erreur lors de la mise &agrave; jour de l'&eacute;l&egrave;ve.<br>";
								}
							break;

							case "Recreer eleve":
								//On cree la requete pour revalider l'eleve
								$requete = "UPDATE eleves SET tjs_eleve = TRUE WHERE ID_Eleve = $recup_num_elv";
								if($result = mysql_query($requete,$id_serveur))
								{
									echo "Mise &agrave; jour de l'&eacute;l&egrave;ve correctement effectu&eacute;e.<br>";
								}
								else
								{
									echo "Erreur lors de la mise &agrave; jour de l'&eacute;l&egrave;ve.<br>";
								}
							break;

							case "Supprimer eleve" :
								//On cree la requete pour supprimer de la table toujours eleve
								$requete = "DELETE FROM niveaux_atteints WHERE ID_Eleve = $recup_num_elv";
								if($result = mysql_query($requete,$id_serveur))
								{
									echo "Suppression des niveaux atteints correctement effectu&eacute;e.<br>";
									//On cree la requete pour supprimer de la table niveaux_atteints
									$requete = "DELETE FROM eleves WHERE ID_Eleve = $recup_num_elv";
									if(mysql_query($requete,$id_serveur))
									{
										echo "Suppression de l'&eacute;l&egrave;ve correctement effectu&eacute;e.<br>";
										echo "Si n&eacute;cessaire, vous pouvez supprimer l'eleve des adh&eacute;rents.<br>";
									}
									else
									{
										echo "Erreur lors de la suppression de l'eleve.<br>";
									}

								}
								else
								{
									echo "Erreur lors de la suppression du niveau atteint.<br>";
								}
							break;
							default:
								echo "Action sur l'eacute;l&egrave;ve incorrecte<br>";
						}
					}
					else
					{
						echo "$requete<br>";
						die("Probl&egrave;me sur la requ&ecirc;te :");
					}
				}
				else
				{
					echo "Cet &eacute;l&egrave;ve n'existe pas<br>";
				}
			}
			else
			{
				echo "Erreur de saisie $recup_num n'existe pas<br>";
			}
		//}
		/*else
		{
			echo "Saisie incorrecte<br>";
			echo "Numero = $recup_num<br>";
			echo "Dernier id = $recup_id";
		}*/
	}
	else
	{
		// Traitement des actions //
		//Si on a clique sur le bouton Modifier (niveau)
		if(isset($_POST['modifier_niveau']))
		{
			//On recupere les donnees
			$recup_id_niveau = $_POST['niveau_a_modifier'];
			echo "recup_id_niveau : $recup_id_niveau<br>";
			//On cree la requete pour recuperer toutes les informations
			$requete = "SELECT * FROM niveaux_atteints WHERE ID_niveau_atteint = $recup_id_niveau";
			echo "$requete<br>";
			//On execute la requete
			if($result = mysql_query($requete,$id_serveur))
			{
				//On recupere le resultat de la requete
				$ligne = mysql_fetch_array($result);
				$Niveau_atteint	= $ligne['Niveau_atteint'];
				$Date_debut	= date_sql_to_fr($ligne['Date_debut']);
				$Date_fin	= date_sql_to_fr($ligne['Date_fin']);
				echo "Niveau atteint : $Niveau_atteint";
				//On cree le formulaire pour afficher les donnees
				echo "<form action=\"\" method=\"post\">";
				echo "<table>";
				echo "<tr>";
				echo "<td>Niveau atteint :</td>";
				echo "<td>";
				echo "<select name=\"valid_niveau_atteint\">";
				//On demande les caracteristiques du champ ENUM
				$result = mysql_query("SHOW COLUMNS FROM niveaux_atteints WHERE field='Niveau_atteint'",$id_serveur);
				//On recupere le resultat de la requete par colonne/champ dans un tableau
				$colonne = mysql_fetch_row($result);
				//On extrait les differentes valeurs du ENUM
				foreach(explode("','",substr($colonne[1],6,-2)) as $valeur)
				{
					//Que l'on encadre par ce qui va bien
					//Si la valeur est celle de l'eleve
					if( $valeur == $Niveau_atteint )
					{
						//On la selectionne
						print("<option selected>$valeur</option>");
					}
					else
					{
						print("<option>$valeur</option>");
					}
				}
				echo "</select>";
				echo "</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td>Date de d&eacute;but :</td>";
				echo "<td><input type=\"text\" name=\"valid_date_debut\" value=\"$Date_debut\" maxlength=\"10\" /> (jj-mm-aaaa)</td>";
				echo "</tr>";
				echo "<tr>";
				echo "<td>Date de fin :</td>";
				echo "<td><input type=\"text\" name=\"valid_date_fin\" value=\"$Date_fin\" maxlength=\"10\" /> (jj-mm-aaaa)</td>";
				echo "</tr>";
				echo "</table>";
				//On valide
				echo "<input type =\"hidden\" name=\"valid_id_niveau\" value=\"$recup_id_niveau\" />";
				echo "<input type =\"submit\" name=\"modif_niveau\" value=\"Modifier\" />";
				echo "</form>";
			}
			else
			{
				echo "Erreur requ&ecirc;te modification niveau<br>";
			}
		}
		else
		{
			//Si on a clique sur le bouton "Ajout niveau"
			if(isset($_POST['ajout_niveau']))
			{
				//On recupere les valeurs
				$recup_niveau_atteint	= $_POST['niveau_atteint'];
				$recup_date_debut	= $_POST['date_debut'];
				$recup_date_fin		= $_POST['date_fin'];
				$recup_eleve		= $_POST['eleve'];
				echo "Donn&eacute;es recup&eacute;r&eacute;es :<br>";
				echo "recup_niveau_atteint : $recup_niveau_atteint<br>";
				echo "recup_date_debut : $recup_date_debut<br>";
				echo "recup_date_fin : $recup_date_fin<br>";
				/// On controle que l'on a bien saisie des dates et les reconvertis au format SQL ///
				//La date de debut doit non seulement etre une vraie date mais aussi etre strictement superieure a la date de creation de l'association
				$date_debut_sql = date_fr_to_sql($recup_date_debut);
				echo "date_debut_sql : $date_debut_sql<br>";
				if( ($date_debut_sql) && ($date_debut_sql > $date_creation ) )
				{
					echo "Date debut OK<br>";
					//La date de fin doit etre strictement superieure a la date de debut
					$date_fin_sql = date_fr_to_sql($recup_date_fin);
					echo "date_fin_sql : $date_fin_sql<br>";
					if( ($date_fin_sql) && ($date_fin_sql > $date_debut_sql) )
					{
						echo "Date fin OK<br>";
						//On met a jour avec les nouvelles valeurs
						//Preparation de la requete
						//on recupere l'id max+1
						$req="SELECT max(ID_Niveau_atteint)+1 FROM niveaux_atteints";
						$occur=mysql_query($req);
						$maLigne=mysql_fetch_array($occur);
						$ID_niv=$maLigne[0];
						$requete = "INSERT INTO niveaux_atteints (ID_Niveau_atteint, ID_Eleve, Niveau_atteint, Date_debut, Date_fin) VALUES ($ID_niv,$recup_eleve, '$recup_niveau_atteint', '$date_debut_sql', '$date_fin_sql')";
						echo "$requete<br>";
						//Execution de la requete
						if($result = mysql_query($requete,$id_serveur))
						{
							echo "Enregistrement ajout&eacute; avec succ&eacute;s";
	/////////////////////////////
	// retour a la page Eleves //
	/////////////////////////////
						}
						else
						{
							die("Probl&egrave;me sur la requ&ecirc;te INSERT");
						}
						//Dans le cas d'un eleve la seule modification est un ajout de niveau, si on veut changer ses coordonnes il faut passer par Adherents puisqu'un eleve est forcement adherent
					}
					else
					{
						echo "Ce n'est pas une date de fin<br>";
					}
				}
				else
				{
					echo "Le $date_debut_sql n'est pas une date de d&eacute;but correcte<br>";
					echo "Date cr&eacute;ation : $date_creation";
				}
			}
			else
			{
				//Si on a clique sur le bouton 'supprimer_niveau'
				if(isset($_POST['supprimer_niveau']))
				{
					//On recupere le numero de l'enregistrement a supprimer
					$recup_niveau_a_supprimer = $_POST['niveau_a_supprimer'];
					//Si l'enregistrement existe
					$requete = "SELECT * FROM niveaux_atteints WHERE ID_Niveau_atteint = $recup_niveau_a_supprimer";
					if($result = mysql_query($requete,$id_serveur))
					{
						//S'il y a un enregistrement
						if( $nb_result = mysql_num_rows($result))
						{
							//On prepare la requete de suppression
							$requete = "DELETE FROM niveaux_atteints WHERE ID_Niveau_atteint = $recup_niveau_a_supprimer";
							//Et on l'execute
							if($result = mysql_query($requete,$id_serveur))
							{
								echo "Niveau correctement supprim&eacute;.<br>";
							}
							else
							{
								echo "Erreur lors de la suppression du niveau.<br>";
							}
						}
						else
						{
							echo "Cet enregistrement n'existe pas.<br>";
						}
					}
					else
					{
						echo "Erreur lors de la v&eacute;rification du niveau &agrave; supprimer.<br>";
					}
				}
				else
				{
					/// Traitement de la validation des actions ///
					//Si on a clique sur le bouton 'Modifier' niveau
					if(isset($_POST['modif_niveau']))
					{
						//On recupere les donnees
						$recup_valid_id_niveau		= $_POST['valid_id_niveau']; //Identifiant
						$recup_valid_niveau_atteint	= $_POST['valid_niveau_atteint']; //Niveau
						//En les convertissant si necessaire
						$recup_valid_date_debut		= date_fr_to_sql($_POST['valid_date_debut']);
						$recup_valid_date_fin		= date_fr_to_sql($_POST['valid_date_fin']);

						//On prepare la requete
						$requete = "UPDATE niveaux_atteints SET Niveau_atteint = '$recup_valid_niveau_atteint', Date_debut ='$recup_valid_date_debut', Date_fin = '$recup_valid_date_fin' WHERE ID_Niveau_atteint = $recup_valid_id_niveau";
						echo "requete : $requete<br>";
						//On l'execute
						if($result = mysql_query($requete,$id_serveur))
						{
							echo "Mise à jour de l'&eacute;l&egrave;ve correctement effectu&eacute;e.<br>";
						}
						else
						{
							echo "Erreur lors mise à jour de l'&eacute;l&egrave;ve.<br>";
						}
					}
					else
					{
						//Si on a clique sur rien
	//					echo "Lancement d'une requ&ecirc;te SELECT<BR>";
						$requete = "SELECT adherents.ID_Adherent, eleves.ID_Eleve, Nom, Prenom, max(Niveau_atteint) niv, Date_debut,Date_fin,tjs_eleve FROM niveaux_atteints natural join eleves natural join adherents group by ID_Eleve";
						//echo ($requete);	//debug
						if($result = mysql_query($requete,$id_serveur))
						{
							echo "<table border=1>";
							echo "<tr>";
	//ajouter le champ tjs_eleve
							echo "<td>N°= adh&eacute;rent</td>";
							echo "<td>N°= &eacute;l&egrave;ve</td>";
							echo "<td>Nom</td>";
							echo "<td>Pr&eacute;nom</td>";
							echo "<td>Niveau atteint</td>";
							echo "<td>Date d&eacute;but</td>";
							echo "<td>Date fin</td>";
							echo "<td>Toujours &eacute;l&egrave;ve</td>";
							echo "</tr>";
							while($ligne = mysql_fetch_array($result))
							{
								//Recuperation des valeurs des enregistrements par nom du champ
								$ID_Adherent=   $ligne['ID_Adherent'];
								$ID_Eleve	=	$ligne['ID_Eleve'];
								$Nom		=	$ligne['Nom'];
								$Prenom		=	$ligne['Prenom'];
								$Niveau_atteint= $ligne['niv'];
								$Date_debut	=	date_sql_to_fr($ligne['Date_debut']);
								$Date_fin	=	date_sql_to_fr($ligne['Date_fin']);
								$Tjs_eleve	=	$ligne['tjs_eleve'];
								//Mise en forme des resultats dans un tableau
								echo "<tr>";
								echo "<td>$ID_Adherent</td>";
								echo "<td>$ID_Eleve</td>";
								echo "<td>$Nom</td>";
								echo "<td>$Prenom</td>";
								echo "<td>$Niveau_atteint</td>";
								echo "<td>$Date_debut</td>";
								echo "<td>$Date_fin</td>";
								if ($Tjs_eleve == TRUE)
								{
									echo "<td>Oui</td>";
								}
								else
								{
									echo "<td>Non</td>";
								}
								echo "</tr>";
							}
							echo "</table>";
						}
						else
						{
							die("Probl&egrave;me sur la requ&ecirc;te");
						}
						echo "<br>";
						//Formulaire pour choisir l'enregistrement sur lequel travailler
						echo "<form action=\"\" method=\"post\">";
						//Recuperation du numero de l'enregistrement a modifier
						echo "Num&eacute;ro d'adherent de l'&eacute;l&egrave;ve : <input type=\"text\" name=\"numero\"/> ";
						echo "<select name=\"action_eleve\">";
						echo "<option>Modifier niveau</option>";
						echo "<option>Ajouter niveau</option>";
						echo "<option>Supprimer niveau</option>";
						echo "<option value=\"Enlever eleve\">Enlever &eacute;l&egrave;ve</option>";
						echo "<option value=\"Recreer eleve\">Recr&eacute;er &eacute;l&egrave;ve</option>";
						echo "<option value=\"Supprimer eleve\">Supprimer &eacute;l&egrave;ve</option>";
						echo "</select>";
						//Champ cache pour recuperer le nombre d'enregistrement
	//					echo "$nb_result";
						echo "<input type=\"hidden\" name=\"dernier_id_eleve\" value=\"$ID_Eleve\" />";
						echo "<input type=\"submit\" name=\"valider_eleve\" value=\"Valider\" /><br>";
						echo "</form>";
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