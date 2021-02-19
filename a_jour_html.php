<?php
$logOK=require('includes/coSite.inc.php');
if($logOK==true)
{
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="content-type" content="text/html ; charset=utf-8"/>


<!-- passage NECESSAIRE pour que le tableau soit au minimum aux dimensions de la fenetre
	sans cela, le pdf enregistré sera coupé sur la droite -->
	<style type="text/css">
	<!-- .a_jour { width:1250px;
    			   table-layout:fixed;
				 }
		 .a_jour td { word-wrap:break-word;
					}
					-->
		</style>
</head>
<body>
<?php
	include_once("includes/config.inc.php");
	include_once("includes/connexion.inc.php");
	include_once("includes/lib/lib_date.inc.php");


	$date_jour = date("m-d");
	if( ($date_jour > "09-01") && ($date_jour < "12-31"))
	{
		$date_limite = date("Y") . "-09-01";
	}
	else
	{
		if($date_jour > "01-01")
		{
			$date_limite = (date("Y")-1) . "-09-01";
		}
	}
	// Si la date du jour est ultérieure au 1er janvier il faut prendre ultérieur au 1er septembre de l'année - 1


if(isset($_POST['action']) && $_POST['action']=="Generer un HTML")
{



	$requete = "SELECT * FROM adherents natural join adhesions WHERE adhesions.Date_adhesion > ".$date_limite." GROUP BY adherents.nom,adherents.prenom";
	if($result=mysql_query($requete,$id_serveur))
	{
  ?>


		<table class="a_jour" border=1>
			<thead>
				<tr>
				<th>N°=</th>
				<th>Civilit&eacute;</th>
				<th>Nom</th>
				<th>Pr&eacute;nom</th>
				<th>Adresse ligne 1</th>
				<th>Adresse ligne 2</th>
				<th>Code Postal</th>
				<th>Ville</th>
				<th>T&eacute;l&eacute;phone</th>
				<th>Fax</th>
				<th>Portable</th>
				<th>Courriel&nbsp;1</th>
				<th>Courriel&nbsp;2</th>
				<th>Date de derni&egrave;re cotisation</th>
				</tr>
			</thead>
			<tbody>
  <?php
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
  ?>
					<tr>
					<td><?=$ID_Adherent?></td>
					<td><?=$Civilite?></td>
					<td><?=$Nom?></td>
					<td><?=$Prenom?></td>
					<td><?=$Adresse1?></td>
					<td><?=$Adresse2?></td>
					<td><?=$Code_Postal?></td>
					<td><?=$Ville?></td>
					<td><?=$Telephone?></td>
					<td><?=$Fax?></td>
					<td><?=$Portable?></td>
					<td><?=$Courriel1?></td>
					<td><?=$Courriel2?></td>
					<td><?=$Date_adhesion?></td>
					</tr>
  <?php
				}//fin du while
  ?>
			</tbody>
		</table>
		<br></br>
  <?php
		$nb_result = mysql_num_rows($result);
		echo "<b>Total $nb_result adh&eacute;rent(s).</b>";
	}
	else
	{
		echo ("Erreur sur la requete" . "<br></br>" . $requete . "<br></br>" . mysql_error() . "<br></br>");
	}

}
else
{
	echo "Vous ne devriez pas être arrivé là.";
}
  ?>
</body>
</html>
<?php
}//fin if est connecté

else
{
	header('Location: index.php');
}
?>