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
<?php include_once("includes/lib/lib_db.inc.php"); ?>
<?php include_once("includes/connexion.inc.php"); ?>
<div id="page">
	<?php include_once("includes/header.inc.php"); ?>
	<div id="titrePage">
		<h1>Gestion d'un institutionnel.</h1>
	</div>
	<div id="zonemenu">
		<?php include_once("includes/menu.inc.php"); ?>
	</div>
	<div id="contenu">
		<p><a href="#bottom">Aller en bas de page</a></p>

<?php

//Si on a clique sur le bouton "Valider" (adherent) -> sur plusieurs actions
if(isset($_POST['valider_inst']))
{
	//On recupere le numero de l'enregistrement
	$recup_num	= $_POST['numero'];
//	echo "Clic modifier $recup_num<br>";
	$recup_id	= $_POST['dernier_id_inst'];
	$recup_action	= $_POST['action_inst'];
//	echo "Dernier ID $recup_id<br>";

	//Si on a bien saisi un chiffre et qu'il n'est pas superieur au nombre d'enregistrements de la table
	//Ce test suppose que les ID_Institut sont bien consecutifs et qu'il n'y a pas de "trous"
	if( ($recup_num >= 1) & ($recup_num <= $recup_id) )
	{
		//modification du script
		//Si l'enregistrement existe
		$requete = "SELECT * FROM institutionnels WHERE ID_Institut = $recup_num";
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
						$requete = "SELECT * FROM institutionnels WHERE ID_Institut = $recup_num";
						//On execute la requete
						if($result = mysql_query($requete,$id_serveur))
						{
//							echo "Requete SELECT OK<br>";
							//Il ne peut y avoir qu'un seul enregistrement. Ce n'est donc pas la peine de mettre un while
							$ligne = mysql_fetch_array($result);
							$ID_Institut	= $ligne["ID_Institut"];
							$Civilite	= $ligne["Civilite"];
							//On oublie pas de faire les conversion de caractères qui vont bien
							$Nom		= str_replace("'","\'",strtoupper($ligne["Nom"]));
							$Prenom		= $ligne["Prenom"];
							$Fonction   = $ligne["Fonction"];
							$Adresse1	= $ligne["Adresse1"];
							$Adresse2	= $ligne["Adresse2"];
							$Code_Postal	= $ligne["Code_Postal"];
							$Ville		= $ligne["Ville"];
							$Telephone	= $ligne["Telephone"];
							$Fax		= $ligne["Fax"];
							$Portable	= $ligne["Portable"];
							$Courriel   = $ligne["Courriel"];
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
							echo "<td>Fonction :</td>";
							echo "<td><input type=\"text\" name=\"fonction\" value=\"$Fonction\" maxlength=\"30\" /></td>";
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
							echo "<td>Courriel&nbsp; :</td>";
							echo "<td><input type=\"text\" name=\"courriel\" value=\"$Courriel\" maxlength=\"40\" /></td>";
							echo "</tr>";
						
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
							echo "<input type=\"hidden\" name=\"id_inst\" value=\"$ID_Institut\" />";
							echo "<input type=\"submit\" name=\"modif_inst\" value=\"Modifier\" /><br>";
							echo "</form>";
						}
						else
						{
							echo "Requete SELECT NOK<br>";
						}
						break;

	
				
					case "Supprimer" :
						//On supprime de la table 'institutionnels'
						
						$requete = "DELETE FROM institutionnels WHERE ID_Institut = $recup_num";
//						echo "$requete<br>";	//debug
						
						
						if($result = mysql_query($requete,$id_serveur))
						{
							echo "Suppression correctement effectu&eacute;e";
						}
						else
						{
							echo "Erreur sur la requ&ecirc;te de suppression de l'institutionnel.<br>";
						}
						
					break;

					default :
					echo "Ce n'est pas possible : $recup_action<br>";
				}//fin du switch
			}
			else
			{
				echo "Cet institutionnel n'existe pas.<br>";
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
	if(isset($_POST['modif_inst']))
	{
		echo "Modification institutionnel<br>";
		//On recupere les donnees
		$recup_id_inst		= $_POST['id_inst'];
		$recup_civilite		= $_POST['civilite'];
		//On met le nom en majscule
		$recup_nom		= strtoupper($_POST['nom']);
		//On ne met pas le prénom en minuscule puis la première en majscule à cause des prénoms composés
		$recup_prenom		= $_POST['prenom'];
		$recup_fonction     =$_POST['fonction'];
		$recup_adresse1		= str_replace("'","\'",$_POST['adresse1']);
		$recup_adresse2		= str_replace("'","\'",$_POST['adresse2']);
		$recup_code_postal	= $_POST['code_postal'];
		//On met la ville en majuscule
		$recup_ville		= str_replace("'","\'",strtoupper($_POST['ville']));
		//Pour le stockage dans la base de données on enlève les espaces
		$recup_telephone	= str_replace(" ","",$_POST['telephone']);
		$recup_fax		= str_replace(" ","",$_POST['fax']);
		$recup_portable		= str_replace(" ","",$_POST['portable']);
		$recup_courriel	= $_POST['courriel'];
		$recup_carnet		= $_POST['carnet'];
		//On prepare la requete
		$requete = "UPDATE institutionnels SET Civilite = '$recup_civilite', Nom = '$recup_nom', Prenom = '$recup_prenom', Fonction ='$recup_fonction', Adresse1 = '$recup_adresse1', Adresse2 = '$recup_adresse2', Code_Postal = '$recup_code_postal', Ville = '$recup_ville', Telephone = '$recup_telephone', Fax = '$recup_fax', Portable = '$recup_portable', Courriel = '$recup_courriel', Carnet = '$recup_carnet' WHERE ID_Institut = $recup_id_inst";
		//Execution de la requete
		if(mysql_query($requete,$id_serveur))
		{
			echo "Mise &agrave; jour correctement effectu&eacute;e<br>";
			echo "Carnet : $recup_carnet";
		}
		else
		{
			die("Erreur sur la mise &agrave; jour <br> ". $requete . "<br>");
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