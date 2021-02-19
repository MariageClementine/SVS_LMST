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
		<h1>Liste des Sourds.</h1>
	</div>
	<div id="zonemenu">
		<?php include_once("includes/menu.inc.php"); ?>
	</div>
	<div id="contenu">
		<p><a href="#bottom">Aller en bas de page</a></p>
<?php
//	echo "Lancement d'une requ&ecirc;te SELECT<BR>";
	$requete = "SELECT * FROM sourds";
	if($result = mysql_query($requete,$id_serveur))
	{
//		printf("Select a retourn&eacute; %d ligne(s).<BR>", mysqli_num_rows($result));
		echo "<table border=1>";
		echo "<tr>";
		echo "<td>N°=</td>";
		echo "<td>Civilit&eacute;</td>";
		echo "<td>Nom</td>";
		echo "<td>Pr&eacute;nom</td>";
		echo "<td>Adresse ligne 1</td>";
		echo "<td>Adresse ligne 2</td>";
		echo "<td>Code Postal</td>";
		echo "<td>Ville</td>";
		echo "<td>Telephone</td>";
		echo "<td>Fax</td>";
		echo "<td>Portable</td>";
		echo "<td>Courriel</td>";
		echo "</tr>";
		while($ligne = mysql_fetch_array($result))
		{
			//Recuperation des valeurs des enregistrements par nom du champ
			$ID_Sourd	= $ligne["ID_Sourd"];
			$Civilite	= $ligne["Civilite"];
			$Nom		= $ligne["Nom"];
			$Prenom		= $ligne["Prenom"];
			$Adresse1	= $ligne["Adresse1"];
			$Adresse2	= $ligne["Adresse2"];
			$Code_Postal	= $ligne["Code_Postal"];
			$Ville		= $ligne["Ville"];
			$Telephone	= chunk_split($ligne["Telephone"],2,"&nbsp;");
			$Fax		= chunk_split($ligne["Fax"],2,"&nbsp;");
			$Portable	= chunk_split($ligne["Portable"],2,"&nbsp;");
			$Courriel	= $ligne["Courriel"];
			$Signe		= $ligne["Signe"];
			//Mise en forme des resultats dans un tableau
			echo "<tr>";
			echo "<td>$ID_Sourd</td>";
			echo "<td>$Civilite</td>";
			echo "<td>$Nom</td>";
			echo "<td>$Prenom</td>";
			echo "<td>$Adresse1</td>";
			echo "<td>$Adresse2</td>";
			echo "<td>$Code_Postal</td>";
			echo "<td>$Ville</td>";
			echo "<td>$Telephone</td>";
			echo "<td>$Fax</td>";
			echo "<td>$Portable</td>";
			echo "<td><a href=\"mailto:$Courriel\">$Courriel</a></td>";
			echo "</tr>";
		}
		echo "</table>";
		echo "<br>";
		//Formulaire pour choisir l'enregistrement à modifier
		echo "<form action=\"ajouter_sourd.php\" method=\"post\">";
		echo "<input type=\"submit\" name=\"ajouter_sourd\" value=\"Ajouter Sourd\" /><br><br>";
		echo "</form>";
		//Formulaire pour choisir l'enregistrement à modifier
		echo "<form action=\"gerer_sourd.php\" method=\"post\">";
		//Recuperation du numero de l'enregistrement a modifier
		echo "Num&eacute;ro du Sourd : <input type=\"text\" name=\"numero\" /> ";
		//Choix de l'action a effectuer
		echo "<select name=\"action_sourd\">";
		echo "<option value=\"Modifier\">Modifier</option>";
		echo "<option value=\"Passer en adherent\">Passer en adh&eacute;rent</option>";
		echo "<option value=\"Supprimer\">Supprimer</option>";
		echo "</select>";
		//Champ cache pour recuperer le nombre d'enregistrement
		echo "<input type=\"hidden\" name=\"dernier_id_sourd\" value=\"$ID_Sourd\" /> ";
		echo "<input type=\"submit\" name=\"valider_sourd\" value=\"Valider\" /><br>";
		echo "</form>";
	}
	else
	{
		die("Probl&egrave;me sur la requ&ecirc;te");
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
