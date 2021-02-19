<?session_start();
//connexion

?>
<html>
	<head>
		<title>Connexion</title>
		<meta name="author" content="MARIAGE Clementine">
		<meta http-equiv="content-type" content="text/html ; charset=utf-8"/>
	</head>
	<body>
		<h1>Accès restreint, veuillez vous connecter pour continuer</h1>
		<table>
		<form name="fConnexion" action="index.php" method="POST" >
			<tr><td>Login:</td><td><input type="text" name="log"></td></tr>
			<tr><td>Mot de passe : </td><td><input type="password" name="mdp"></td></tr>
			<tr><td><input type="submit" value="Ok" name="action"></td></tr>
		</form>
		</table>
	</body>
</html>

<?php
if(isset($_POST['action']) && $_POST['action']=="Ok")
{
	$log=trim($_POST['log']);
	$mdp=trim($_POST['mdp']);
	//echo $log;	//debug
	//echo $mdp;	//debug

	//si connexion ok
	if(@mysql_connect('127.0.0.1',$log,$mdp))
	{	
		$_SESSION['user']=$log;
		$_SESSION['passwd']=$mdp;
		//on accede au site
		//header("Location: indexAccueil.php");

		?>
		<meta http-equiv="refresh" content="0; URL=indexAccueil.php">
		<?php
	}
		
	//sinon
	else
	{
		echo("Erreur de connexion: Login ou Mot de passe incorrect.");
	}//fin sinon
}
?>