<?php
$logOK=require('includes/coSite.inc.php');
if($logOK==true)
{

include_once("includes/config.inc.php"); 
include_once("includes/lib/lib_date.inc.php");
include_once("includes/connexion.inc.php"); 

			//si on veut générer le pdf
			if(isset($_POST['action']) && $_POST['action']=="Lettres de relance")
			{
			$date_jour = date("m-d");
			if( $date_jour > "09-01" & $date_jour < "12-31")
			{
				$date_limite = date("Y") . "-09-01";
			}
			// Si la date du jour est ultérieure au 1er janvier il faut prendre ultérieur au 1er septembre de l'année - 1
			if($date_jour > "01-01")
			{
				$date_limite = (date("Y")-1) . "-09-01";
			}
				//on appelle fpdf
				require("fpdf/fpdf.php");
				$date_mail=date("d-m-Y");
				//requete
				$sql="SELECT * FROM adherents natural join adhesions WHERE Courriel1='' GROUP BY adherents.nom,adherents.prenom HAVING max(adhesions.Date_adhesion)  < '$date_limite'";
				//echo ($sql . "<br>" . mysql_error() . "<br>") ;
				//si la requete marche
				if($occur=mysql_query($sql, $id_serveur))
				{
					//si on a des résultats
					if(mysql_num_rows($occur))
					{
						define('EURO',chr(128));
						if(file_exists("csv/pa_jour_mail.pdf"))
						{
							@unlink("csv/pa_jour_mail.pdf");
						}
						//on crée le pdf
						$pdf=new FPDF();
						//on lui donne une police (imperatif)
						$pdf->SetFont('Arial','','14');
						//pour chaque adherent
						while($ligne = mysql_fetch_array($occur))
						{
							//on crée une page 
							$pdf->AddPage();
							//on récup les données
							$civilite =utf8_decode($ligne['Civilite']);
							$nom=utf8_decode($ligne['Nom']);
							$prenom=utf8_decode($ligne['Prenom']);
							$adresse1=utf8_decode($ligne['Adresse1']);
							//si il y a complement d'adresse
							if($ligne['Adresse2']!='')
							{
								$adresse2=utf8_decode($ligne['Adresse2']);
							}
							$cp=utf8_decode($ligne['Code_Postal']);
							$ville=utf8_decode($ligne['Ville']);
							
			
							//on prépare le courrier

							//expediteur
							$pdf->Cell(0,5,"Association Le Monde des Sourds pour Tous",0,1,"L");
							$pdf->Cell(0,5,utf8_decode("22 boulevard Général de Gaulle"),0,1,"L");
							$pdf->Cell(0,5,"05000 Gap",0,1,"L");
							$pdf->Ln(30);
							
						
							//destinataire
							$pdf->Cell(0,5,"$civilite $nom $prenom",0,1,"R");
							$pdf->Cell(0,5,"$adresse1",0,1,"R");

							//si on a un compl d'adresse
							if(isset($adresse2))
							{
		
							$pdf->Cell(0,5,"$adresse2",0,1,"R");
							}	

							$pdf->Cell(0,5,"$cp $ville",0,1,"R");
							$pdf->Ln(30);
							
							//ville et date
							$pdf->Cell(0,5,"A gap , le $date_mail .",0,1,"C");				

							//on genere automatiquement l'annee scolaire en cours
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
							$pdf->Ln(25);
							$pdf->Cell(0,5,"Madame, Monsieur,",0,1,"L");
							$pdf->Ln(15);
							$pdf->MultiCell(0,5,utf8_decode("Lors de(s) année(s) précédente(s), nous avons déjà eu le plaisir de vous compter parmi nos membres. \nOr, sauf erreur ou omission malencontreuse de notre part, nous n'avons à ce jour pas reçu votre cotisation pour l'année $date1 - $date2. \nSi vous souhaitez toujours faire partie de notre association, nous vous remercions de bien vouloir nous	faire parvenir votre chèque de cotisation d'un montant de _____").EURO.utf8_decode(" à notre adresse ci-dessus. \nEn espérant avoir le plaisir de vous compter à nouveau parmi nos membres prochainement, recevez, $civilite, nos amicales salutations."),0,"L");
							$pdf->Ln(20);
							$pdf->Cell(0,5,"Sourdialement.",0,1,"L");
							$pdf->Cell(0,5,"L'association Le Monde des Sourds pour Tous.",0,1,"L");

						}	//fin while
						//on ferme et enregistre le pdf 
						$pdf->SetAuthor("MARIAGE Clementine");
						$pdf->Output("csv/pa_jour_mail.pdf","D");
					}//fin if on a des resultats
					else
					{
						echo("Tous les adherents sont à jour.");
					}
				}//fin if requete marche
				else
				{
					echo ("erreur requete" . "<br>");
				}	
			}


}//fin if est connecté

else
{
	header('Location: index.php');
}
?>