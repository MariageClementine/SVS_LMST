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
		<h1>Liste des adh&eacute;rents n'ayant ni t&eacute;l&eacute;phone, ni fax, ni portable, ni adresse courriel.</h1>
	</div>
	<div id="zonemenu">
		<?php include_once("includes/menu.inc.php"); ?>
	</div>
	<div id="contenu">
		<p><a href="#bottom">Aller en bas de page</a></p>
		<?php
//			echo "Lancement d'une requ&ecirc;te SELECT<BR>";
			//On prepare la requete
			$requete = "SELECT * FROM adherents WHERE Telephone='' and Fax='' and Portable='' and Courriel1=''";
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
					echo "</tr>";
				}//fin du while
				echo "</table>";
				echo "<br>";
				$nb_result = mysql_num_rows($result);
				echo "<b>Total $nb_result adh&eacute;rents.</b>";
			}//fin du if
			else
			{
				die("Probl&egrave;me sur la requ&ecirc;te d'affichage des courriels " . mysql_error() . ".");
			}
		?>
	
	<table border=1>
			<tr>
				<td>
					<form action="sans_coordonnees_html.php" method="post">
						<input type="submit" name="action" value="Generer un HTML"/>
					</form>
				</td>
				<td>
					<p>Une fois la page g&eacute;n&eacute;r&eacute;e, cliquez sur "Imprimer".</p><p> Un enregistrement au format PDF vous sera propos&eacute;.</p>
			</tr>
			<tr>
				<td>
					<form action="" method="post">
						<input type="submit" name="action" value="Generer un CSV"/>
					</form>
				</td>
				<td>
					<p>Une fois votre fichier t&eacute;l&eacute;charg&eacute;, ouvrez-le avec OpenOffice Calc, </p><p>puis enregistrez-le sous le nom souhait&eacute; au format ODS.</p>
				</td>
			</tr>
		</table>

		<br></br>
		<?php include_once("includes/footer.inc.php"); 		
		//si il existe, on le supprime

			//si on veut générer un csv
			if(isset($_POST['action']) && $_POST['action']=="Generer un CSV")
			{
				//si le fichier existe deja sur le serveur
				if(file_exists("csv/sans_coordonnees.csv"))
				{
					//on le supprime
					@unlink("csv/sans_coordonnees.csv");
				}
				   //creation du nouveau fichier
				$idFichierCsv=fopen("csv/sans_coordonnees.csv","w");
				  //requete
				$sql="SELECT * FROM adherents WHERE Telephone='' and Fax='' and Portable='' and Courriel1=''";
				$resultat=mysql_query($sql,$id_serveur);
				  //boucle d'obtention des nuplets issus de la table de la bdd
				while($monTableau=mysql_fetch_row($resultat))
				{
					  //formation de la ligne a ecrire
					$laLigneAEcrire=join(";",$monTableau)."\n";
		  			  //ecriture
					fputs($idFichierCsv,$laLigneAEcrire);		
				}  //fin de la boucle
	
				fclose($idFichierCsv);
				echo '<script language="Javascript">
				<!--
				document.location.replace("csv/sans_coordonnees.csv");
				// -->
				</script>';
			} 
			 ?>
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