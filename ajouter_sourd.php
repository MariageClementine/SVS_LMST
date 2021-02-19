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
		<h1>Ajout d'un Sourd.</h1>
	</div>
	<div id="zonemenu">
		<?php include_once("includes/menu.inc.php"); ?>
	</div>
	<div id="contenu">
		<p><a href="#bottom">Aller en bas de page</a></p>
<?php
//Si on a clique sur le bouton "Ajouter" (Sourd)
if(isset($_POST['ajout_sourd']))
{
	//On recupere les donnees
	$Civilite	= $_POST['civilite'];
	//On en profite pour convertir le nom et la ville en majuscule car, pour le publipostage, La Poste aime bien
	// et on met le prénom avec la première lettre en majuscule car c'est plus joli
	// Pas le prénom car il peut être composé
	$Nom		= strtoupper($_POST['nom']);
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
	$Courriel	= $_POST['courriel'];
	//On verifie le code postal
	if( is_numeric($Code_Postal) & ($Code_Postal >= "01000") & ($Code_Postal <= "99999") )
	{
//		echo "Code Postal $Code_Postal correct<br>";
		//On verifie le courriel qui peut aussi hélas être vide
//		echo "V&eacute;rification $Courriel<br>";
		if(checkMail($Courriel) || $Courriel == "")
		{
//			echo "Courriel $Courriel correct<br>";
			//on récupère le futur identifiant du nouveau sourd
			$req2="SELECT max(ID_Sourd)+1 from sourds";
			if($occur=mysql_query($req2,$id_serveur))
			{
				$maLigne=mysql_fetch_array($occur);
				$ID_Sourd=$maLigne[0];
				//On peut enregistrer dans la base
				$requete = "INSERT INTO sourds (ID_Sourd, Civilite, Nom, Prenom, Adresse1, Adresse2, Code_Postal, Ville, Telephone, Fax, Portable, Courriel, Signe) VALUES($ID_Sourd, '$Civilite', '$Nom', '$Prenom', '$Adresse1', '$Adresse2', '$Code_Postal', '$Ville', '$Telephone', '$Fax', '$Portable', '$Courriel', '')";
//				echo "$requete<br>";
				//On execute la requete
				
				if($result = mysql_query($requete,$id_serveur))
				{
					//On recupere le dernier identifiant créé lors de l'insertion de la requête précédente
					$req3="SELECT max(ID_Sourd) FROM sourds";
					$occur=mysql_query($req3);
					$maLigne=mysql_fetch_array($occur);
					$id_nouveau=$maLigne[0];

					echo "Le Sourd $Nom $Prenom a &eacute;t&eacute; correctement ajout&eacute;(e) avec le num&eacute;ro $id_nouveau.<br>";
				}
				else
				{
					echo $requete;
					die("Probl&egrave;me lors de l'ajout du Sourd" . mysql_error() . "<br>");
				}
			}
			else
			{
				die("probl&egrave;me lors de la recuperation de l'id du nouveau sourd" . mysql_error() . "<br>");
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
	//Si on a clique sur le bouton 'Ajouter Sourd'
	if(isset($_POST['ajouter_sourd']))
	{
		echo "Ajout d'un Sourd.<br>";
		//On construit le formulaire
		echo "<form action=\"\" method=\"post\">";
		echo "<table>";
		echo "<tr>";
		echo "<td>Civilit&eacute; :</td>";
		echo "<td>";
		echo "<SELECT NAME=\"civilite\">";
		$liste_civilite = getEnumVals($id_serveur,"sourds","civilite");		
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
		echo "<td><input type=\"text\" name=\"prenom\" maxlength=\"25\" /></td>";
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
		echo "<td>Courriel :</td>";
		echo "<td><input type=\"text\" name=\"courriel\" maxlength=\"40\" /></td>";
		echo "</tr>";
		//On fera le "Signe" plus tard car c'est un peu plus complique
		echo "</table>";
		echo "<input type=\"submit\" name=\"ajout_sourd\" value=\"Ajouter\" /><br>";
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