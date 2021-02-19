<?php
$logOK=require('includes/coSite.inc.php');
if($logOK==true)
{
?>
<!DOCTYPE HTML>
<html>
	<head>
	
		<?php header('Content-Type: text/html; charset=iso-8859-1'); ?>
			<style type="text/css">
			<!-- body{ width:90%;
						font-family: tahoma,arial; }
		 		div#expediteur{text-align: left;}
		 		div#destinataire{text-align:right;}
		 		div#ville_date{text-align: center;}
		 		div#contenu{text-align:left;
		 			width:90%;
    			   position:absolute;
    			word-wrap:break-word;}
					-->
		</style>

	</head>
	<body>

<?php
		//on inclut les fichiers necessaires
		include_once("includes/config.inc.php");
		include_once("includes/connexion.inc.php");
		include_once("includes/lib/lib_date.inc.php");

		//on va avoir besoin de la date
		$date_jour = date("m-d");
		if( ($date_jour > "09-01") && ($date_jour < "12-31"))
		{
			$date_limite = date("Y") . "-09-01";
			$date_max = date("Y") . "-10-23";
		}
		else
		{
			if($date_jour > "01-01")
			{
				$date_limite = (date("Y")-1) . "-09-01";
				$date_max = (date("Y")-1) . "-10-23";
			}
		}
		$date_mail=date("y-m-d");
		//si on a bien choisi cette option
		if(isset($_POST['action']) && $_POST['action']=="Avertir les adherents non a jour")
		{
			//echo ($date_max . "<br>");	//debug
			//echo ($date_mail . "<br>"); //debug
			//on récupère les données
			$sql="SELECT * FROM adherents natural join adhesions WHERE Courriel1='' GROUP BY adherents.nom,adherents.prenom HAVING max(adhesions.Date_adhesion)  < '$date_limite'";
			//echo ($sql . "<br>" . mysql_error() . "<br>") ;
			if($occur=mysql_query($sql, $id_serveur))
			{
				while($ligne = mysql_fetch_array($occur))
				{
					//on récup les données
					$civilite =$ligne['Civilite'];
					$nom=$ligne['Nom'];
					$prenom=$ligne['Prenom'];
					$adresse1=$ligne['Adresse1'];
					//si il y a complement d'adresse
					if($ligne['Adresse2']!='')
					{
						$adresse2=$ligne['Adresse2'];
					}
					$cp=$ligne['Code_Postal'];
					$ville=$ligne['Ville'];
					
	
					//on prépare le courrier
					?>
					<div id="expediteur">
						<p>Association Le Monde des Sourds pour Tous</p>
						<p>22 boulevard G&eacute;n&eacute;ral de Gaulle</p>
						<p>05000 Gap</p>
					</div>
					<br></br>
					<br></br>

					<div id="destinataire">
						<p><?=$civilite?> <?=$nom?> <?=$prenom?></p>
						<p><?=$adresse1?></p>
<?php
						//si on a un compl d'adresse
						if(isset($adresse2))
						{
?>	
						<p><?=$adresse2?></p>
<?php
						}	
?>
						<p><?=$cp?> <?=$ville?></p>
					</div>
					<br></br>
					<br></br>

					<div id="ville_date">
						<p>A gap , le <?=$date_mail?> . </p>
					</div>
					<br></br>
					<br></br>
<?php
					if( ($date_jour > "09-01") && ($date_jour < "12-31"))
					{
						$date1 = date("Y");
						$date2 = (date("Y")+1);
					}
					else
					{
						if($date_jour > "01-01")
						{
							$date1 = (date("Y")-1) ;
							$date2 = date("Y");
						}
					}
?>
					<div id="contenu">
						<p>Madame, Monsieur, </p>
						<p>Lors de(s) ann&eacute;e(s) pr&eacute;c&eacute;dente(s), nous avons d&eacute;j&agrave; 
							eu le plaisir de vous compter parmi nos membres. Or, sauf erreur ou omission malencontreuse 
							de notre part, nous n'avons &agrave; ce jour pas re&ccedil;u votre cotisation pour l'ann&eacute;e <?=$date1?>-<?=$date2?>.
							Si vous souhaitez toujours faire partie de notre association, nous vous remercions de bien vouloir nous
							faire parvenir votre ch&egrave;que de cotisation d'un montant de _____&euro;  &agrave; notre adresse ci-dessus.
							En esp&eacute;rant avoir le plaisir de vous compter à nouveau parmi nos membres prochainement, recevez, 
							<?=$civilite?>, nos amicales salutations.
						</p>
						<br></br>
						<p>Sourdialement.</p>
						<p>L'association Le Monde des Sourds pour Tous.</p>
					</div>
					<!--je sais il y en a beaucoup, mais pas le choix-->
						<br></br><br></br><br></br><br></br><br></br><br></br>
						<br></br><br></br><br></br><br></br><br></br><br></br><br></br><br></br>
						
					<?php

				}	//fin while
			}//fin if
			else
			{
				echo ("erreur requete" . "<br>");
			}	



		}	
		else
		{
			echo ("Vous ne devriez pas être arrivé ici.");
		}
?>
	</body>
</html>