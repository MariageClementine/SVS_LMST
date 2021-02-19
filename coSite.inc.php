<?session_start();

//formulaire de vérification de connexion
	$logOK=false;
	if(mysql_connect('127.0.0.1',$_SESSION['user'],$_SESSION['passwd']))
	{
		$logOK=true;
		return $logOK;
	}

	else
	{
		return $logOK;
		
	}
	


?>