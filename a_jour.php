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
		<h1>Liste des adh&eacute;rents &agrave; jour de leur cotisation.</h1>
	</div><!--fin div titrepage-->
	<div id="zonemenu">
		<?php include_once("includes/menu.inc.php"); ?>
	</div><!--fin div zonemenu-->
	<div id="contenu">
		<p><a href="#bottom">Aller en bas de page</a></p>
		<?php
////////////////////////////////////////////////////////////////////////////////////////////////
//			echo "Lancement d'une requ&ecirc;te SELECT<BR>";
			// Si la date du jour est entre le 1er septembre et le 31 décembre il faut prendre entre ultérieur au 1er septembre le de l'année en cours
			$date_jour = date("m-d");
			echo "Date du jour : $date_jour<br>";
			if( $date_jour > "09-01" & $date_jour < "12-31")
			{
				$date_limite = date("Y") . "-09-01";
			}
			// Si la date du jour est ultérieure au 1er janvier il faut prendre ultérieur au 1er septembre de l'année - 1
			if($date_jour > "01-01")
			{
				$date_limite = (date("Y")-1) . "-09-01";
			}
			echo "Date limite : $date_limite<br>";
			//modification du script
			//On prepare la requete
			$requete = "SELECT * FROM adherents natural join adhesions GROUP BY adherents.nom,adherents.prenom HAVING max(adhesions.Date_adhesion) > '$date_limite' ";
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
				echo "<td>Date de derni&egrave;re cotisation</td>";
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
					$Date_adhesion	= date_sql_to_fr($ligne['Date_adhesion']);
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
					echo "<td>$Date_adhesion</td>";
					echo "</tr>";
				}//fin du while
				echo "</table>";
				echo "<br>";
				$nb_result = mysql_num_rows($result);
				echo "<b>Total $nb_result adh&eacute;rent(s).</b>";
			}//fin du if
			//fin de modification
			else
			{
				die("Probl&egrave;me sur la requ&ecirc;te d'affichage des courriels " . mysql_error() . ".");
			}


		?>
		<br></br>
		<table border=1>
			<tr>
				<td>
					<form action="a_jour_html.php" method="post">
						<input type="submit" name="action" value="Generer un HTML"/>
					</form>
				</td>
				<td>
					<p>Une fois la page g&eacute;n&eacute;r&eacute;e, cliquez sur "Imprimer".</p>
					<p> Un enregistrement au format PDF vous sera propos&eacute;.</p>

				<td>
					<form action=" " method="post">
						<input type="submit" name="action" value="Liste des adherents non a jour"/>
					</form>
				</td>
				<td>
					<p>Listing csv des adh&eacute;rents non &agrave; jour.</p>
				</td>
			</tr>
			<tr>
				<td>
					<form action="" method="post">
						<input type="submit" name="action" value="Generer un CSV"/>
					</form>
				</td>
				<td>
					<p>Une fois votre fichier t&eacute;l&eacute;charg&eacute;, ouvrez-le avec OpenOffice Calc, </p>
					<p>puis enregistrez-le sous le nom souhait&eacute; au format ODS.</p>
					<p>N'oubliez pas de d&eacute;cocher l'espace dans le choix des s&eacute;parateurs quand Office s'ouvrira!</p>
				</td>
				<td>
					<form action="pa_jour_pdf.php" method="post">
						<input type="submit" name="action" value="Lettres de relance"/>
					</form>
				</td>
				<td>
					<p>T&eacute;l&eacute;charge un fichier pdf contenant les lettres </p>
					<p>de relance destin&eacute;es aux adh&eacute;rents non &agrave; jour.</p>
				</td>
			</tr>

		</table>

		<br></br>

	</div><!--fin div contenu-->
		<?php include_once("includes/footer.inc.php"); 		

			//si on veut générer un csv des adherents a jour
			if(isset($_POST['action']) && $_POST['action']=="Generer un CSV")
			{
				//si le fichier existe deja sur le serveur
				if(file_exists("csv/a_jour.csv"))
				{
					//on le supprime
					@unlink("csv/a_jour.csv");
				}
				   //creation du nouveau fichier
				$idFichierCsv=fopen("csv/a_jour.csv","w");
				  //requete
				$sql="SELECT ID_Adherent, Civilite, Nom, Prenom, Adresse1, Adresse2, Code_Postal, Ville, Telephone, Fax, Portable, Courriel1, Courriel2, Date_adhesion FROM adherents natural join adhesions GROUP BY adherents.nom,adherents.prenom HAVING max(adhesions.Date_adhesion) > '$date_limite' ";
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
				document.location.replace("csv/a_jour.csv");
				// -->
				</script>';
			} 

			//si on veut générer un csv des adherents NON a jour( pour mail)
			if(isset($_POST['action']) && $_POST['action']=="Liste des adherents non a jour")
			{
				//si le fichier existe deja sur le serveur
				if(file_exists("csv/pa_jour_mail.csv"))
				{
					//on le supprime
					@unlink("csv/pa_jour_mail.csv");
				}
				   //creation du nouveau fichier
				$idFichierCsv=fopen("csv/pa_jour_mail.csv","w");
				  //requete
				$sql="SELECT Civilite, Nom, Prenom, Adresse1, Adresse2, Code_Postal, Ville FROM adherents natural join adhesions WHERE Courriel1='' GROUP BY adherents.nom,adherents.prenom HAVING max(adhesions.Date_adhesion)  < '$date_limite'";
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
				document.location.replace("csv/pa_jour_mail.csv");
				// -->
				</script>';
			} 

?>

</div><!--fin div page-->
</body>
</html>
<?php
}//fin if est connecté

else
{
	header('Location: index.php');
}
?>

