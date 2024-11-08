<?php 
	ini_set( 'display_errors', 1 );
	error_reporting( E_ALL );
	$from = "vote@fifam.fr";
	$to = 'jp@kily.fr';
	$subject = "[FIFAM] Confirmation d'inscription";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
	$headers .= 'From: "Fifam" <'.$from.">\r\n".'Reply-To: <'.$from.">\r\nTo: <".$to.">\r\n".'X-Mailer: PHP/'.phpversion();
	$msg="Bonjour ".$_POST['pnm'].",<br/><br/>Vous êtes sur le point de finaliser votre inscription pour participer au vote du public du FIFAM.<br/>Pour cela il vous faut cliquer sur le lien ci dessous :<br/>".'<a href="https://vote.fifam.fr/valenr.php?q='.$id.'&v='.$val.'" />https://vote.fifam.fr/valenr.php?q='.$id.'&v='.$val.'</a><br/><br/>Si vous n\'êtes pas à l\'origine de cette demande, ne cliquez pas sur le lien et votre email sera effacé automatiquement de notre base sous 10 minutes.<br/><br/>Bon festival !';
	mail($to,$subject,$msg, $headers);
?>
