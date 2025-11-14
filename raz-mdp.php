<?php
include('BdD.php');
$vrif="niet";
$_POST['em1']=strtolower(trim(nty($_POST['em1'])));
$rep=$cbdd->query('SELECT * FROM pub WHERE eml="'.encrypt($_POST['em1'], $clef).'" AND act=1 ');
		while ($donnees = $rep->fetch())
		{
		if (strtoupper(decrypt($donnees["pre"], $clef)[0])==$_POST['inip'] && strtoupper(decrypt($donnees["nm"], $clef)[0])==$_POST['inin']) {$id=$donnees["id"];$vrif="OK";$pnm=decrypt($donnees["pre"], $clef);}
		}
	$rep->closeCursor();
	echo($vrif);
if ($vrif=="OK") 
	{
	$val=rand(100000,999999);
	$cbdd->query('UPDATE pub SET vrf='.$val.' WHERE id='.$id.' ');
	$from = "vote@fifam.fr"; 
	$to = $_POST['em1'];
	$subject = "[FIFAM] Réinitialisation du mot de passe";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
	$headers .= 'From: <'.$from."\r\n".'>Reply-To: <'.$from.">\r\nTo: <".$to.">\r\n".'X-Mailer: PHP/'.phpversion();
	$msg="Bonjour ".$pnm.",<br/><br/>Vous avez demandé la réinitialsation de votre mot de passe du site du vote du public du FIFAM.<br/>Pour cela il vous faut cliquer sur le lien ci dessous :<br/>".'<a href="https://vote.fifam.fr/mod-mdp.php?q='.$id.'&v='.$val.'" />https://vote.fifam.fr/mod-mdp.php?q='.$id.'&v='.$val.'</a><br/><br/>Si vous n\'êtes pas à l\'origine de cette demande, aucune modification ne sera effectuée sur votre compte.<br/><br/>Bon festival !';
	mail($to,$subject,$msg, $headers);	
	$_SESSION['em']=$_POST['em1'];
	header('Location:index.php');
	}
else
	{
	header('Location:dem-mdp.php');
	}
?>
