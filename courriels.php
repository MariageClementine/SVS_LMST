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
		<h1>Liste des adh&eacute;rents ayant au moins une adresse courriel.</h1>
	</div>
	<div id="zonemenu">
		<?php include_once("includes/menu.inc.php"); ?>
	</div>
	<div id="contenu">
		<p><a href="#bottom">Aller en bas de page</a></p>
		<?php
//			echo "Lancement d'une requ&ecirc;te SELECT<BR>";
			//On prepare la requete
		//modification du script
			$requete = "SELECT * FROM adherents WHERE Courriel1!='' order by Nom,Prenom";
			if($result = mysql_query($requete,$id_serveur))
			{
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
				echo "<td>T&eacute;l&eacute;phone</td>";
				echo "<td>Fax</td>";
				echo "<td>Portable</td>";
				echo "<td>Courriel&nbsp;1</td>";
				echo "<td>Courriel&nbsp;2</td>";
				echo "</tr>";
				while($ligne = mysql_fetch_array($result))
				{
					//Recuperation des valeurs des enregistrements par nom du champ
					$ID_Adherent	= $ligne["ID_Adherent"];
					$Civilite	= $ligne["Civilite"];
					$Nom		= $ligne["Nom"];
					$Prenom		= $ligne["Prenom"];
					$Adresse1	= $ligne["Adresse1"];
					$Adresse2	= $ligne["Adresse2"];
					$Code_Postal	= $ligne["Code_Postal"];
					$Ville		= $ligne["Ville"];
					//On insère des espaces insécables (pour que ça n'aille pas à la ligne)
					// entre les chiffres car c'est plus facile à lire
					$Telephone	= chunk_split($ligne["Telephone"],2,"&nbsp;");
					$Fax		= chunk_split($ligne["Fax"],2,"&nbsp;");
					$Portable	= chunk_split($ligne["Portable"],2,"&nbsp;");
					$Courriel1	= $ligne["Courriel1"];
					$Courriel2	= $ligne["Courriel2"];
					$Signe		= $ligne["Signe"];
					//Mise en forme des resultats dans un tableau
					echo "<tr>";
					echo "<td>$ID_Adherent</td>";
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
					echo "<td><a href=\"mailto:$Courriel1\">$Courriel1</a></td>";
					echo "<td><a href=\"mailto:$Courriel2\">$Courriel2</a></td>";
					echo "</tr>";
				}//fin du while
				echo "</table>";
				echo "<br>";
				$nb_result = mysql_num_rows($result);
				echo "<b>Total $nb_result adh&eacute;rents.</b>";
			}//fin du if
			//fin de modification
			else
			{
				die("Probl&egrave;me sur la requ&ecirc;te d'affichage des courriels " . mysql_error() . ".");
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