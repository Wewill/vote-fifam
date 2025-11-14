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
	$headers .= 'From: "FIFAM - Festival International du Film d\'Amiens" <'.$from.">\r\n";
	$headers .= 'Reply-To: '.$from."\r\n";
	$headers .= 'Return-Path: '.$from."\r\n";
	$headers .= 'X-Mailer: PHP/'.phpversion()."\r\n";
	$headers .= 'X-Priority: 3'."\r\n";
	$headers .= 'Message-ID: <'.time().'-'.$id.'@vote.fifam.fr>'."\r\n";
	$msg='<!DOCTYPE html><html><head><meta charset="utf-8"></head><body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">';
	$msg.='<div style="max-width: 600px; margin: 0 auto; padding: 20px;">';
	$msg.='<h2 style="color: rgb(108, 117, 125);">FIFAM - Mot de passe modifié</h2>';
	$msg.='<p>Bonjour '.$pnm.',</p>';
	$msg.='<p>Votre mot de passe du site du vote du public du FIFAM a bien été modifié.</p>';
	$msg.='<p>Vous pouvez maintenant vous connecter en cliquant sur le lien ci-dessous :</p>';
	$msg.='<p style="margin: 20px 0;"><a href="https://vote.fifam.fr/coin.php" style="background-color: rgb(108, 117, 125); color: white; padding: 12px 24px; text-decoration: none; border-radius: 4px; display: inline-block;">Se connecter</a></p>';
	$msg.='<p>Ou copiez ce lien dans votre navigateur :<br/><span style="color: rgb(108, 117, 125);">https://vote.fifam.fr/coin.php</span></p>';
	$msg.='<p style="color: #666; font-size: 0.9em;">Si vous n\'êtes pas à l\'origine de cette modification, veuillez contacter l\'administrateur immédiatement.</p>';
	$msg.='<p>Bon festival !</p>';
	$msg.='<hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">';
	$msg.='<p style="font-size: 0.8em; color: #999;">FIFAM - Festival International du Film d\'Amiens</p>';
	$msg.='</div></body></html>';
	mail($to,$subject,$msg, $headers);
	$_SESSION['Message']='<div class="valid" >Votre mot de passe a bien été modifié ! Vous pouvez maintenant vous connecter avec votre nouveau mot de passe.</div>';
	header('Location:coin.php');
	}
	else
	{
	header('Location:mod_mdp.php?q='.$id.'&v='.$vrf.'-');
	}
?>
