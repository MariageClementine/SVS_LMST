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
		<h1>Gestion d'un Sourd.</h1>
	</div>
	<div id="zonemenu">
		<?php include_once("includes/menu.inc.php"); ?>
	</div>
	<div id="contenu">
		<p><a href="#bottom">Aller en bas de page</a></p>
<?php
//Si on a clique sur le bouton "Valider" (sourd)
if(isset($_POST['valider_sourd']))
{
	//On recupere le numero de l'enregistrement
	$recup_num	= $_POST['numero'];
//	echo "Clic modifier $recup_num<br>";
	$recup_id	= $_POST['dernier_id_sourd'];
	$recup_action	= $_POST['action_sourd'];
//	echo "Dernier ID $recup_id<br>";

	//Si on a bien saisi un chiffre et qu'il n'est pas superieur au nombre d'enregistrement de la table
	//Ce test suppose que les ID_Adh_Eleves sont bien consecutifs et qu'il n'y a pas de "trous"
	if( ($recup_num >= 1) & ($recup_num <= $recup_id) )
	{
		//Si l'enregistrement existe
		$requete = "SELECT * FROM adherents WHERE ID_Adherent = $recup_num";
//		echo "$requete<br>";
		if($result = mysql_query($requete,$id_serveur))
		{
			if($nb_result = mysql_num_rows($result))
			{
//				echo "Saisie Sourd num&eacute;ro $recup_num correcte<br>";
				switch($recup_action)
				{
					case "Modifier":
						echo "Modifier Sourd num&eacute;ro $recup_num<br>";
						//On recupere le contenu de l'enregistrement demande
						$requete = "SELECT * FROM sourds WHERE ID_Sourd = $recup_num";
						//On execute la requete
						if($result = mysql_query($requete,$id_serveur))
						{
//							echo "Requete SELECT OK<br>";
							//Il ne peut y avoir qu'un seul enregistrement. Ce n'est donc pas la peine de mettre un while
							$ligne = mysql_fetch_array($result);
							$ID_Sourd	= $ligne["ID_Sourd"];
							$Civilite	= $ligne["Civilite"];
							$Nom		= $ligne["Nom"];
							$Prenom		= $ligne["Prenom"];
							$Adresse1	= $ligne["Adresse1"];
							$Adresse2	= $ligne["Adresse2"];
							$Code_Postal	= $ligne["Code_Postal"];
							$Ville		= $ligne["Ville"];
							$Telephone	= $ligne["Telephone"];
							$Fax		= $ligne["Fax"];
							$Portable	= $ligne["Portable"];
							$Courriel	= $ligne["Courriel"];
							//On cree le formulaire en le remplissant avec ce que l'on a recupere
							echo "<form action=\"\" method=\"post\">";
							echo "<table>";
							echo "<tr>";
							echo "<td>Civilit&eacute; :</td>";
							echo "<td>";
							echo "<SELECT NAME=\"civilite\">";
							$liste_civilite = getEnumVals($id_serveur,"sourds","Civilite");
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
							echo "<td><input type=\"text\" name=\"prenom\" value=\"$Prenom\" maxlength=\"25\" /></td>";
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
							echo "<td>Courriel :</td>";
							echo "<td><input type=\"text\" name=\"courriel\" value=\"$Courriel\" maxlength=\"40\" /></td>";
							echo "</tr>";
							echo "</table>";
							echo "<input type=\"hidden\" name=\"id_sourd\" value=\"$ID_Sourd\" />";
							echo "<input type=\"submit\" name=\"modifier_sourd\" value=\"Modifier\" /><br>";
							echo "</form>";
						}
						else
						{
							echo "Requete SELECT NOK<br>";
						}
					break;

					case "Passer en adherent":
						echo "Passage en adh&eacute;rant du Sourd numéro $recup_num.<br>";
						//On insere le Sourd dans la table adherents_eleves
						//D'abord on verifie si l'enregistrement existe deja
						//Pour cela on recupere les informations dans la table sourds
						$requete_sourd = "SELECT * FROM sourds WHERE ID_Sourd = $recup_num";
						if($result_sourd = mysql_query($requete_sourd,$id_serveur))
						{
//							echo "$requete_sourd<br>";
							$ligne_sourd		= mysql_fetch_array($result_sourd);
							$Civilite_sourd		= $ligne_sourd['Civilite'];
							$Nom_sourd		= $ligne_sourd['Nom'];
							$Prenom_sourd		= $ligne_sourd['Prenom'];
							$Adresse1_sourd		= str_replace("'","\'",$ligne_sourd['Adresse1']);
							$Adresse2_sourd		= str_replace("'","\'",$ligne_sourd['Adresse2']);
							$Code_Postal_sourd	= $ligne_sourd['Code_Postal'];
							$Ville_sourd		= $ligne_sourd['Ville'];
							$Telephone_sourd	= $ligne_sourd['Telephone'];
							$Fax_sourd		= $ligne_sourd['Fax'];
							$Portable_sourd		= $ligne_sourd['Portable'];
							$Courriel_sourd		= $ligne_sourd['Courriel'];
							$Signe_sourd		= $ligne_sourd['Signe'];
							//Ensuite on recherche les mêmes valeurs dans la table adherents_eleves
							$requete_eleve = "SELECT * FROM adherents WHERE Nom = '$Nom_sourd' AND Prenom = '$Prenom_sourd'";
//							echo "$requete_eleve<br>";
							//Execution de la requete
							if($result_eleve = mysql_query($requete_eleve,$id_serveur))
							{
								//S'il y a un resultat
								if( $nb_result = mysql_num_rows($result_eleve))
								{
									echo "<b>Ce Sourd est d&eacute;j&agrave; un adh&eacute;rent. Merci de le supprimer</b><br>";
									//Le supprimer automatiquement ?
								}
								else
								{
									echo "Ce Sourd n'est pas encore adh&eacute;rent. On continue.<br>";
									//Sinon on insere les valeurs dans la table 'adherents_eleves'
									$req="SELECT max(ID_Adherent)+1 FROM adherents";
									$occur=mysql_query($req);
									$maLigne=mysql_fetch_array($occur);
									$ID_Adherent= $maLigne[0];

									$requete_adherent = "INSERT INTO adherents(ID_Adherent, Civilite, Nom, Prenom, Adresse1, Adresse2, Code_Postal, Ville, Telephone, Fax, Portable, Courriel1, Courriel2, Signe, Caracteristique, Carnet) values($ID_Adherent, '$Civilite_sourd', '$Nom_sourd', '$Prenom_sourd', '$Adresse1_sourd', '$Adresse2_sourd', '$Code_Postal_sourd', '$Ville_sourd', '$Telephone_sourd', '$Fax_sourd', '$Portable_sourd', '$Courriel_sourd', '', '$Signe_sourd', 'Sourd(e)', 0)";
//									echo "$requete_adherent<br>";
									if($result_adherent = mysql_query($requete_adherent,$id_serveur))
									{
										$req_id="SELECT max(ID_Adherent) from adherents";
										$result=mysql_query($req_id);
										$occ=mysql_fetch_array($result);
										$nouv_id=$occ[0];
										echo "L'adh&eacute;rent(e) $Nom_sourd $Prenom_sourd a &eacute;t&eacute; correctement transf&eacute;r&eacute;(e) en adh&eacute;rent avec le nouveau num&eacute;ro $nouv_id.<br>";
										//Puis on ajoute l'enregistrement de son adhesion dans la table adhesions
										$date_adhesion = date("Y-m-d"); //On prend la date du jour
										$req2="SELECT max(ID_Adhesion)+1 FROM adhesions";
										$occur2=mysql_query($req2);
										$maLigne2=mysql_fetch_array($occur2);
										$ID_Adhesion=$maLigne2[0];
										$requete_adhesion = "INSERT INTO adhesions (ID_Adhesion,ID_Adherent,Date_adhesion) VALUES ($ID_Adhesion, $nouv_id, '$date_adhesion')";
//										echo "$requete_adhesion<br>";
										//On execute la requete
										if($result = mysql_query($requete_adhesion,$id_serveur))
										{
/////////////////////////////////////////////////////////////////////////
// Il doit être possible de faire une fonction ajout_adherent_eleve () //
/////////////////////////////////////////////////////////////////////////
											echo "La date d'adh&eacute;sion du Sourd $Nom_sourd $Prenom_sourd a &eacute;t&eacute; correctement ajout&eacute;e.<br>";
											//Enfin, puisque tout c'est bien passé jusque là on supprime le Sourd de la table 'sourds'
											$requete = "DELETE FROM sourds WHERE ID_Sourd = $recup_num";
											if($result = mysql_query($requete,$id_serveur))
											{
												echo "Suppression de la table 'Sourds' OK<br>";
											}
											else
											{
												echo "Suppression de la table 'Sourds' NOK<br>";
											}
										}
										else
										{
											echo "INSERT date_adhesion Sourd NOK<br>";
											echo ($req2 . "<br>");
											echo ($ID_Adhesion . "<br>");
											echo ($requete_adhesion ."<br");

										}
									}
									else
									{
										die("Probl&eacute;me lors de l'ajout de l'adh&eacute;rent Sourd" . "<br>" . mysql_error() . "<br>"."debug: " . "<br>"."requete id: ".$req."<br>"."id: ".$ID_Adherent . "<br>"."requete insert: ".$requete_adherent . "<br>");
									
									}
								}//fin else
							}//fin if
							else
							{
								die("Erreur sur la requ&ecirc;te pour v&eacute;rification de l'adh&eacute;rent" . mysql_error() . "<br>");
							}
						}//fin if
						else
						{
							die("Erreur sur la requ&ecirc;te pour v&eacute;rification du Sourd" . mysql_error() . "<br>");
						}
					break;


					case "Supprimer" :
					//	echo "Supprimer<br>";	//debug
						//On verifie si c'est un eleve
						$requete = "SELECT * FROM sourds WHERE ID_Sourd = $recup_num";
						if($result = mysql_query($requete,$id_serveur))
						{
							//On supprime de la table 'adherents_eleves'
							$requete = "DELETE FROM sourds WHERE ID_Sourd = $recup_num";
//							echo "$requete<br>";
							if($result = mysql_query($requete,$id_serveur))
							{
								echo "Suppression du Sourd correctement effectu&eacute;e";
							}
							else
							{
								echo "Erreur sur la requ&ecirc;te de suppression du Sourd.<br>";
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
	//Si on a clique sur le bouton "Modifier" (sourd)
	if(isset($_POST['modifier_sourd']))
	{
		echo "Modification du Sourd<br>";
		//On recupere les donnees
		$recup_id_sourd		= $_POST['id_sourd'];
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
		$recup_courriel		= $_POST['courriel'];
		//On prepare la requete
		$requete = "UPDATE sourds SET Civilite = '$recup_civilite', Nom = '$recup_nom', Prenom = '$recup_prenom', Adresse1 = '$recup_adresse1', Adresse2 = '$recup_adresse2', Code_Postal = '$recup_code_postal', Ville = '$recup_ville', Telephone = '$recup_telephone', Fax = '$recup_fax', Portable = '$recup_portable', Courriel = '$recup_courriel' WHERE ID_Sourd = $recup_id_sourd";
//		echo "$requete<br>";
		//Execution de la requete
		if($result = mysql_query($requete,$id_serveur))
		{
			echo "Mise &agrave; jour correctement effectu&eacute;e";
		}
		else
		{
			echo "Erreur sur la mise &agrave; jour<br>";
		}
	}
	else
	{
		echo "Vous ne devriez pas &ecirc;tre arriv&eacute; ici.<br>";
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