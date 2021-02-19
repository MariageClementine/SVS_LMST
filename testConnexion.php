<?php

$logOK=require("includes/coSite.inc.php");
if($logOK==true)
{	
	echo "OK";
}
else
{
	if($logOK==false)
	{
		echo "Erreur";
	}
}

?>