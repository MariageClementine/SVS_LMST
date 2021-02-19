<?php
$logOK=require('includes/coSite.inc.php');
if($logOK==true)
{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Gestion des adh&eacute;rents de l'association &laquo; Le Monde des Sourds pour tous &raquo</title>
<meta name="author" content="MARIAGE Clémentine">
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
		<h1>Liste des institutionnels.</h1>
	</div>
	<div id="zonemenu">
		<?php include_once("includes/menu.inc.php"); ?>
	</div>
	<div id="contenu">
		<p><a href="#bottom">Aller en bas de page</a></p>
<?php

/////////////////////////////////
// Verification et validation ///
/////////////////////////////////

//Si on a clique sur le bouton "Ajouter" (adherent)
if(isset($_POST['ajout_inst']))
{
	//On recupere les donnees
	$Civilite	= $_POST['civilite'];
	// Pas le prénom car il peut être composé
	$Nom		= str_replace("'","\'",strtoupper($_POST['nom']));
	$Prenom		= $_POST['prenom'];
	$Fonction   =$_POST['fonction'];
	//On rajoute un caractère d'échapement pour gérer le guillemet
	$Adresse1	= str_replace("'","\'",$_POST['adresse1']);
	$Adresse2	= str_replace("'","\'",$_POST['adresse2']);
	$Code_Postal	= $_POST['code_postal'];
	$Ville		= str_replace("'","\'",strtoupper($_POST['ville']));
	//Pour le stockage dans la base de données on enlève les espaces dans tous les numéros de téléphone
	$Telephone	= str_replace(" ","",$_POST['telephone']);
	$Fax		= str_replace(" ","",$_POST['fax']);
	$Portable	= str_replace(" ","",$_POST['portable']);
	$Courriel	= $_POST['courriel'];
	$Carnet		= $_POST['carnet'];
	//On verifie le code postal il peut être un chiffre compris entre 01000 et 99999 ou vide
	if( (is_numeric($Code_Postal) & ($Code_Postal >= "01000") & ($Code_Postal <= "99999")) || ($Code_Postal == "") )
	{
//		echo "Code Postal $Code_Postal correct<br>";
		//On verifie les courriels qui peuvent aussi être vide
//		echo "V&eacute;rification $Courriel<br>";
		if( checkMail($Courriel) || $Courriel == "") 
		{
//			echo "Courriels $Courriel1 correct<br>";
			
			//il faut récuperer l'id du dernier adhérent pour l'incrémenter pour le nouveau
			$req= "SELECT max(ID_Institut)+1 FROM institutionnels";
			$occur=mysql_query($req);
			$maLigne= mysql_fetch_array($occur);
			$ID_Inst=$maLigne[0];
					 

			$requete = "INSERT INTO institutionnels (ID_Institut, Civilite, Nom, Prenom, Fonction, Adresse1, Adresse2, Code_Postal, Ville, Telephone, Fax, Portable, Courriel, Carnet) VALUES(".$ID_Inst.",'$Civilite', '$Nom', '$Prenom', '$Fonction', '$Adresse1', '$Adresse2', '$Code_Postal', '$Ville', '$Telephone', '$Fax', '$Portable', '$Courriel', $Carnet)";
//			echo "$requete<br>";
			//On execute la requete
			if($result = mysql_query($requete,$id_serveur))
			{

				echo "L'institutionnel $Nom $Prenom a &eacute;t&eacute; correctement ajout&eacute; avec le num&eacute;ro $ID_Inst.<br>";

			}
			else
			{
				die ($ID_Inst . "<br>" . $requete . "<br>" . "Probl&egrave;me lors de l'ajout de l'institutionnel" . mysql_error() . "<br>");
					
			}
				
		}
		else
		{
			echo "Courriel $Courriel incorrect<br>";
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
	//Si on a clique sur le bouton "Ajouter institutionnel" de la page institutionnel OU si on a fait une erreur
	if(isset($_POST['ajouter_inst']))
	{
		echo "Ajout d'institutionnel<br>";
		//On construit le formulaire
		echo "<form action=\"\" method=\"post\">";
		echo "<table>";

		//Recupération du contenu de l'enum des civilités
		echo "<tr>";
		echo "<td>Civilit&eacute; :</td>";
		echo "<td>";
		echo "<SELECT NAME=\"civilite\">";
		$liste_civilite = getEnumVals($id_serveur,"institutionnels","civilite");		
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
		echo "<td>Fonction :</td>";
		echo "<td><input type=\"text\" name=\"fonction\" maxlength=\"30\" /></td>";
		echo "<tr>";

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
		echo "<td>Courriel :</td>";
		echo "<td><input type=\"text\" name=\"courriel\" maxlength=\"40\" /></td>";
		echo "</tr>";

		echo "<tr>";
		echo "<td>Carnet :</td>";
		echo "<td>";
		echo "<input type=\"radio\" name=\"carnet\" value=0 CHECKED>Faux";
		echo "<input type=\"radio\" name=\"carnet\" value=1>Vrai<br>";
		echo "</td>";
		echo "</tr>";

		echo "</table>";
		echo "<input type=\"submit\" name=\"ajout_inst\" value=\"Ajouter\" /><br>";
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