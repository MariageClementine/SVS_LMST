<?php
$logOK=require('includes/coSite.inc.php');
if($logOK==true)
{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Gestion des adh&eacute;rents de l'association &laquo; Le Monde des Sourds pour tous &raquo;</title>
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
		<h1>Liste des adh&eacute;rents avec leurs date de derni&egrave;re cotisation.</h1>
	</div>
	<div id="zonemenu">
		<?php include_once("includes/menu.inc.php"); ?>
	</div>
	<div id="contenu">
		<p><a href="#bottom">Aller en bas de page</a></p>
		<h3>Un &eacute;l&egrave;ve &eacute;tant forc&eacute;ment adh&eacute;rent</h3>
<?php

/////////////////////////////////
// Verification et validation ///
/////////////////////////////////

//Si on a clique sur le bouton "Ajouter" (adherent)
if(isset($_POST['ajout_adh']))
{
	//On recupere les donnees
	$Civilite	= $_POST['civilite'];
	//On en profite pour convertir le nom et la ville en majuscule car, pour le publipostage, La Poste aime bien et on prend en compte une éventuelle apostrophe
	// Pas le prénom car il peut être composé
	$Nom		= str_replace("'","\'",strtoupper($_POST['nom']));
	$Prenom		= $_POST['prenom'];
	//On rajoute un caractère d'échapement pour gérer le guillemet
	$Adresse1	= str_replace("'","\'",$_POST['adresse1']);
	$Adresse2	= str_replace("'","\'",$_POST['adresse2']);
	$Code_Postal	= $_POST['code_postal'];
	$Ville		= str_replace("'","\'",strtoupper($_POST['ville']));
	//Pour le stockage dans la base de données on enlève les espaces dans tous les numéros de téléphone
	$Telephone	= str_replace(" ","",$_POST['telephone']);
	$Fax		= str_replace(" ","",$_POST['fax']);
	$Portable	= str_replace(" ","",$_POST['portable']);
	$Courriel1	= $_POST['courriel1'];
	$Courriel2	= $_POST['courriel2'];
	$Caracteristique= $_POST['caracteristique'];
	$Date_adhesion	= $_POST['date_adhesion'];
	$Montant	= $_POST['montant'];
	$Carnet		= $_POST['carnet'];
	//On verifie le code postal il peut être un chiffre compris entre 01000 et 99999 ou vide
	if( (is_numeric($Code_Postal) & ($Code_Postal >= "01000") & ($Code_Postal <= "99999")) || ($Code_Postal == "") )
	{
//		echo "Code Postal $Code_Postal correct<br>";
		//On verifie les courriels qui peuvent aussi hélas être vide
//		echo "V&eacute;rification $Courriel<br>";
		if( (checkMail($Courriel1) || $Courriel1 == "") && (checkMail($Courriel2) || $Courriel2 == "") )
		{
//			echo "Courriels $Courriel1 et $Courriel2 corrects<br>";
			//On verifie la date d'adhesion
			$date_adhesion_sql = date_fr_to_sql($Date_adhesion);
//			echo "date_creation : $date_creation<br>";
//			echo "date_adhesion_sql : $date_adhesion_sql<br>";
			//Si la convertion c'est bien passe ET si on a saisi une date superieure a la date de creation ET inférieure ou égale à la date du jour
			if( ($date_adhesion_sql) && (strtotime($Date_adhesion) > $date_creation) ) //date creation est au format SQL
			{
//				echo "Date d'adhesion correcte<br>";
				//Si on a bien tapé un chiffre dans le montant
				if(is_numeric($Montant))
				{
					//On peut enregistrer dans la base
					//D'abord dans la table adherents
					//modification de script
					//il faut récuperer l'id du dernier adhérent pour l'incrémenter pour le nouveau
					$req= "SELECT max(ID_Adherent)+1 FROM adherents";
					$occur=mysql_query($req);
					$maLigne= mysql_fetch_array($occur);
					 $ID_Adh=$maLigne[0];
					 

					$requete = "INSERT INTO adherents (ID_Adherent, Civilite, Nom, Prenom, Adresse1, Adresse2, Code_Postal, Ville, Telephone, Fax, Portable, Courriel1, Courriel2, Signe, Caracteristique, Carnet) VALUES(".$ID_Adh.",'$Civilite', '$Nom', '$Prenom', '$Adresse1', '$Adresse2', '$Code_Postal', '$Ville', '$Telephone', '$Fax', '$Portable', '$Courriel1', '$Courriel2', '', '$Caracteristique', $Carnet)";
//					echo "$requete<br>";
					//On execute la requete
					if($result = mysql_query($requete,$id_serveur))
					{
						//On recupere le dernier identifiant créé lors de l'insertion de la requête précédente
						//(pas sûre que ca soit très utile de REfaire une requete pour ca, mais sait-on jamais....)
						$req2="SELECT max(ID_Adherent) FROM adherents";
						$occur2=mysql_query($req2);
						$maLigne2=mysql_fetch_array($occur2);
						$ID_Adherent=$maLigne2[0];
						//on recupere l'identifiant a creer pour l'adhesion
						$req3="SELECT max(ID_Adhesion)+1 FROM adhesions";
						$occur3=mysql_query($req3);
						$maLigne3=mysql_fetch_array($occur3);
						$ID_Adhesion=$maLigne3[0];
						echo "L'adh&eacute;rent(e) $Nom $Prenom a &eacute;t&eacute; correctement ajout&eacute;(e) avec le num&eacute;ro $ID_Adherent.<br>";
						//Puis on ajoute l'enregistrement de son adhesion dans la table adhesions
						$requete2 = "INSERT INTO adhesions (ID_Adhesion,ID_Adherent,Date_adhesion,Montant) VALUES ($ID_Adhesion, $ID_Adherent, '$date_adhesion_sql', $Montant)";
//						echo "$requete<br>";
					//fin de modification
						//On execute la requete
						if($result = mysql_query($requete2,$id_serveur))
						{
							echo "La date d'adh&eacute;sion a &eacute;t&eacute; correctement ajout&eacute;e<br>";
						}
						else
						{
							echo "INSERT date_adhesion NOK<br>";
						}
					}
					else
					{
						echo ($ID_Adh); //debug
						die("Probl&egrave;me lors de l'ajout de l'adh&eacute;rent" . mysql_error() . "<br>");
						
					}
				}
				else
				{
					echo "Veuillez saisir un chiffre dans le montant.<br>";
				}
/////////////////////////////////////////////////////////////////
//Il faudrait faire apparaitre ces messages dans le formulaire //
// pour éviter de revenir en arrière ce qui n'est pas pratique //
/////////////////////////////////////////////////////////////////
			}
			else
			{
				echo "Date d'adh&eacute;sion $date_adhesion_sql incorrecte<br>";
			}
		}
		else
		{
			echo "Courriel $Courriel1 ou $Courriel2 incorrect<br>";
		}
	}
	else
	{
		echo "Code Postal $Code_Postal incorrect";
	}
}
else
{
//////////////////////////////////
/// Construction du formulaire ///
//////////////////////////////////
	//Si on a clique sur le bouton "Ajouter adherent" de la page adhérent OU si on a fait une erreur
	if(isset($_POST['ajouter_adh']))
	{
		echo "Ajout d'adh&eacute;rent<br>";
		//On construit le formulaire
		echo "<form action=\"\" method=\"post\">";
		echo "<table>";

		//Recupération du contenu de l'enum des civilités
		echo "<tr>";
		echo "<td>Civilit&eacute; :</td>";
		echo "<td>";
		echo "<SELECT NAME=\"civilite\">";
		$liste_civilite = getEnumVals($id_serveur,"adherents","civilite");		
		//On parcours le tableau du début à la fin
		for ($ID_Civilite = 0;$ID_Civilite<Count($liste_civilite);$ID_Civilite++)
		{
			//Et on constitue la liste déroulante
			echo "<OPTION VALUE=\"$liste_civilite[$ID_Civilite]\">$liste_civilite[$ID_Civilite]</OPTION>";
		}
		echo "</SELECT>";
		echo "</td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td>Nom :</td>";
		echo "<td><input type=\"text\" name=\"nom\" maxlength=\"20\" /></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Pr&eacute;nom :</td>";
		echo "<td><input type=\"text\" name=\"prenom\" maxlength=\"26\" /></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Adresse ligne 1 :</td>";
		echo "<td><input type=\"text\" name=\"adresse1\" maxlength=\"40\" /></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Adresse ligne 2 :</td>";
		echo "<td><input type=\"text\" name=\"adresse2\" maxlength=\"25\" /></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Code Postal :</td>";
		echo "<td><input type=\"text\" name=\"code_postal\" maxlength=\"5\" /></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Ville :</td>";
		echo "<td><input type=\"text\" name=\"ville\" maxlength=\"22\" /></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>T&eacute;l&eacute;phone :</td>";
		echo "<td><input type=\"text\" name=\"telephone\" maxlength=\"19\" /></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Fax :</td>";
		echo "<td><input type=\"text\" name=\"fax\" maxlength=\"19\" /></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Portable :</td>";
		echo "<td><input type=\"text\" name=\"portable\" maxlength=\"19\" /></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Courriel 1 :</td>";
		echo "<td><input type=\"text\" name=\"courriel1\" maxlength=\"40\" /></td>";
		echo "</tr>";
		echo "<td>Courriel 2 :</td>";

		echo "<td><input type=\"text\" name=\"courriel2\" maxlength=\"40\" /></td>";
		echo "</tr>";
		//On fera le "Signe" plus tard car c'est un peu plus complique
		echo "<tr>";
		echo "<td>Caract&eacute;ristique :</td>";
		echo "<td>";
		echo "<SELECT MULTIPLE NAME=\"caracteristique\">";
		$liste_caracteristique = getEnumVals($id_serveur,"adherents","Caracteristique");
		//On parcours le tableau du début à la fin
		for ($ID_Caracteristique = 0;$ID_Caracteristique<Count($liste_caracteristique);$ID_Caracteristique++)
		{
			//Et on constitue la liste déroulante
			//Si la valeur courant de la liste est différente de celle d'origine
			if($liste_caracteristique[$ID_Caracteristique]!=$ID_Caracteristique)
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
		echo "</tr>";
		echo "<tr>";
		echo "<td>Date d'adh&eacute;sion :</td>";
		echo "<td><input type=\"text\" name=\"date_adhesion\" maxlength=\"10\" /> (jj-mm-aaaa)</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Montant :</td>";
		echo "<td><input type=\"text\" name=\"montant\" maxlength=\"2\" /></td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>Carnet :</td>";
		echo "<td>";
		echo "<input type=\"radio\" name=\"carnet\" value=0 CHECKED>Faux";
		echo "<input type=\"radio\" name=\"carnet\" value=1>Vrai<br>";
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		echo "<input type=\"submit\" name=\"ajout_adh\" value=\"Ajouter\" /><br>";
		echo "</form>";
	}
	else
	{
		echo "Vous &ecirc;tes arriv&eacute;s sur cette page par erreur";
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