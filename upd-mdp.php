<?php 
include('BdD.php');
$rep=$cbdd->query('SELECT * FROM pub WHERE id='.nty($_POST['id']).' AND vrf='.nty($_POST['vrf']).' ');
	while ($donnees = $rep->fetch())
	{
	$id=$donnees['id'];
	$vrf=$donnees['vrf'];
	$em=decrypt($donnees['eml'], $clef);
	$pnm=decrypt($donnees['pre'], $clef);
	}
$rep->closeCursor();
if (nty($_POST['cmdp'])==nty($_POST['mdp']) && $id==$_POST['id'])
	{
	$cbdd->query('UPDATE pub SET vrf=0, mdp="'.hash("sha256",nty($_POST['mdp'])).'" WHERE id='.nty($_POST["id"]).' ');
	$from = "vote@fifam.fr"; 
	$to = $em;
	$subject = "[FIFAM] Mot de passe modifié";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
	$headers .= 'From: <'.$from."\r\n".'>Reply-To: <'.$from.">\r\nTo: <".$to.">\r\n".'X-Mailer: PHP/'.phpversion();
	$msg="Bonjour ".$pnm.",<br/><br/>Votre mot de passe du site du vote du public du FIFAM a bien été modifié.<br/>Vous pouvez vous connecte avec en cliquant sur le lien ci-dessous :<br/>".'<a href="https://vote.fifam.fr/coin.php" />https://vote.fifam.fr/coin.php</a><br/><br/>Bon festival !';
	mail($to,$subject,$msg, $headers);
	$_SESSION['em']=$em;
	header('Location:index.php');
	}
	else
	{
	header('Location:mod_mdp.php?q='.$id.'&v='.$vrf.'-');
	}
?>
