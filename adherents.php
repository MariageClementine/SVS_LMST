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
		<h1>Liste des adh&eacute;rents avec leurs date de derni&egrave;re cotisation.</h1>
	</div>
	<div id="zonemenu">
		<?php include_once("includes/menu.inc.php"); ?>
	</div>
	<div id="contenu">
		<p><a href="#bottom">Aller en bas de page</a></p>
		<h3>Un &eacute;l&egrave;ve &eacute;tant forc&eacute;ment adh&eacute;rent.</h2>
		<?php
//			echo "Lancement d'une requ&ecirc;te SELECT<BR>";
			//On prepare la requete
////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Je trouve cette requête un peu longue, on doit pouvoir la raccoucir au niveau du GROUP BY              //
// En plus elle est buggée : elle n'affiche pas le dernier montant payé                                   //
// Est-ce qu'il faut faire 2 requêtes ? Est-ce qu'on peut faire une requête à l'intérieur d'une requête ? //
// D'après http://dev.mysql.com/doc/refman/5.0/fr/example-maximum-row.html c'est ce qu'il faut faire avec éventuellement un ORDER BY DESC LIMIT 1
// Sauf que "SELECT * FROM adhesions WHERE date_adhesion =(select max(date_adhesion) from adhesions) group by id_adhesion" cela ne trouve que l'adhérent (les adhérents) qui a (ont) cotisé(s) en dernier //
// Autre piste : un UNION ?
////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//modification du script
			$requete = "SELECT adherents.ID_Adherent, Civilite, Nom, Prenom, Adresse1, Adresse2, Code_Postal, Ville, Telephone, Fax, Portable, Courriel1, Courriel2, Caracteristique, Carnet, MAX(Date_adhesion) as Date_adhesion , Montant FROM adherents natural join adhesions GROUP BY adherents.ID_Adherent";
//			echo "$requete<br>";		//debug
			if($result = mysql_query($requete,$id_serveur))
			{
				echo "<table border=1>";
				echo "<tr>";
				echo "<td>N°=</td>";
				echo "<td>Civilit&eacute;</td>";
				echo "<td>Nom</td>";
				echo "<td>Pr&eacute;nom</td>";
				echo "<td>Adresse&nbsp;ligne&nbsp;1</td>";
				echo "<td>Adresse&nbsp;ligne&nbsp;2</td>";
				echo "<td>Code Postal</td>";
				echo "<td>Ville</td>";
				echo "<td>T&eacute;l&eacute;phone</td>";
				echo "<td>Fax</td>";
				echo "<td>Portable</td>";
				echo "<td>Courriel&nbsp;1</td>";
				echo "<td>Courriel&nbsp;2</td>";
				echo "<td>Caract&eacute;ristique</td>";
				echo "<td>Carnet d'adresse central</td>";
				echo "<td>Date de derni&egrave;re adh&eacute;sion</td>";
				echo "<td>Montant</td>";
				echo "</tr>";
				while($ligne = mysql_fetch_array($result))
				{
				//fin de modification du script
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
					$Caracteristique= $ligne["Caracteristique"];
					$Carnet		= $ligne["Carnet"];
					if($Carnet == true )
					{
						$Carnet = "Vrai";
					}
					else
					{
						$Carnet = "Faux";
					}
					$Date_adhesion	= date_sql_to_fr($ligne['Date_adhesion']);
					$Montant	= $ligne['Montant'];
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
					echo "<td>$Caracteristique</td>";
					echo "<td>$Carnet</td>";
					echo "<td>$Date_adhesion</td>";
					echo "<td align=\"right\">$Montant</td>";
					echo "</tr>";
				}//fin du while
				echo "</table>";
			}//fin du if
			else
			{
				die("Probl&egrave;me sur la requ&ecirc;te");
			}
			echo "<br>";
			//Petit formulaire pour lancer la page d'ajout d'un adhérent
			echo "<form action=\"ajouter_adherent.php\" method=\"post\">";
			echo "<input type=\"submit\" name=\"ajouter_adh\" value=\"Ajouter adh&eacute;rent\" /><br><br>";
			echo "</form>";
			//Formulaire pour choisir l'enregistrement à modifier
			echo "<form action=\"gerer_adherent.php\" method=\"post\">";
			//Recuperation du numero de l'enregistrement a modifier
			// Remarque : il serait plus sûr de mettre une liste déroulante
			echo "Num&eacute;ro de l'adh&eacute;rent : <input type=\"text\" name=\"numero\" /> ";
			//Choix de l'action a effectuer
			echo "<select name=\"action_adherent\">";
			echo "<option value=\"Modifier\">Modifier</option>";
			echo "<option value=\"Gerer_adhesion\">G&eacute;rer adh&eacute;sion(s)</option>";
			echo "<option value=\"Passer_eleve\">Passer en &eacute;l&egrave;ve</option>";
			echo "<option value=\"Supprimer\">Supprimer</option>";
			echo "</select>";
			//Ce champ cache permet de contrôler que l'on a pas tapé un numéro supérieur au maximum
			echo "<input type=\"hidden\" name=\"dernier_id_adh_eleve\" value=\"$ID_Adherent\" /> ";
			echo "<input type=\"submit\" name=\"valider_adherent\" value=\"Valider\" /><br>";
			echo "</form>";
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
