<?php
include('BdD.php');
ini_set( 'display_errors', 1 );
error_reporting( E_ALL );
$vrif="niet";
$email_existe=false;
$compte_non_active=false;
$_POST['em1']=strtolower(trim(nty($_POST['em1'])));

// Vérifier d'abord si le compte existe (activé ou non)
$rep_all=$cbdd->query('SELECT * FROM pub WHERE eml="'.encrypt($_POST['em1'], $clef).'"');
	while ($donnees = $rep_all->fetch())
	{
	$email_existe=true;
	// Si le compte n'est pas activé
	if ($donnees["act"]==0) {
		if (strtoupper(decrypt($donnees["pre"], $clef)[0])==$_POST['inip'] && strtoupper(decrypt($donnees["nm"], $clef)[0])==$_POST['inin']) {
			$compte_non_active=true;
			$id=$donnees["id"];
			$val=$donnees["vrf"];
			$pnm=decrypt($donnees["pre"], $clef);
		}
	}
	// Si le compte est activé
	else if ($donnees["act"]==1) {
		if (strtoupper(decrypt($donnees["pre"], $clef)[0])==$_POST['inip'] && strtoupper(decrypt($donnees["nm"], $clef)[0])==$_POST['inin']) {
			$id=$donnees["id"];
			$vrif="OK";
			$pnm=decrypt($donnees["pre"], $clef);
		}
	}
	}
	$rep_all->closeCursor();

// Cas 1 : Compte activé - Envoi email de réinitialisation
if ($vrif=="OK")
	{
	$val=rand(100000,999999);
	$cbdd->query('UPDATE pub SET vrf='.$val.' WHERE id='.$id.' ');
	$from = "vote@fifam.fr";
	$to = $_POST['em1'];
	$subject = "[FIFAM] Réinitialisation du mot de passe";
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
	$msg.='<h2 style="color: rgb(108, 117, 125);">FIFAM - Réinitialisation du mot de passe</h2>';
	$msg.='<p>Bonjour '.$pnm.',</p>';
	$msg.='<p>Vous avez demandé la réinitialisation de votre mot de passe du site du vote du public du FIFAM.</p>';
	$msg.='<p>Pour réinitialiser votre mot de passe, veuillez cliquer sur le lien ci-dessous :</p>';
	$msg.='<p style="margin: 20px 0;"><a href="https://vote.fifam.fr/mod-mdp.php?q='.$id.'&v='.$val.'" style="background-color: rgb(108, 117, 125); color: white; padding: 12px 24px; text-decoration: none; border-radius: 4px; display: inline-block;">Réinitialiser mon mot de passe</a></p>';
	$msg.='<p>Ou copiez ce lien dans votre navigateur :<br/><span style="color: rgb(108, 117, 125);">https://vote.fifam.fr/mod-mdp.php?q='.$id.'&v='.$val.'</span></p>';
	$msg.='<p style="color: #666; font-size: 0.9em;">Si vous n\'êtes pas à l\'origine de cette demande, aucune modification ne sera effectuée sur votre compte.</p>';
	$msg.='<p>Bon festival !</p>';
	$msg.='<hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">';
	$msg.='<p style="font-size: 0.8em; color: #999;">FIFAM - Festival International du Film d\'Amiens</p>';
	$msg.='</div></body></html>';
	$mail_sent=mail($to,$subject,$msg, $headers);
	if ($mail_sent) {
		$_SESSION['Message']='<div class="valid" >Un e-mail de réinitialisation vous a été envoyé à l\'adresse <strong>'.$_POST['em1'].'</strong>.<br/>Merci de vérifier votre boîte de réception et vos spams.</div>';
	} else {
		$_SESSION['Message']='<div class="avert" >Une erreur s\'est produite lors de l\'envoi de l\'e-mail. Veuillez réessayer.</div>';
	}
	header('Location:dem-mdp.php');
	}
// Cas 2 : Compte non activé - Renvoi email d'activation
else if ($compte_non_active)
	{
	$from = "vote@fifam.fr";
	$to = $_POST['em1'];
	$subject = "[FIFAM] Confirmation d'inscription";
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
	$msg.='<h2 style="color: rgb(108, 117, 125);">FIFAM - Confirmation d\'inscription</h2>';
	$msg.='<p>Bonjour '.$pnm.',</p>';
	$msg.='<p>Votre compte n\'est pas encore activé. Pour finaliser votre inscription et participer au vote du public du FIFAM, veuillez cliquer sur le lien ci-dessous :</p>';
	$msg.='<p style="margin: 20px 0;"><a href="https://vote.fifam.fr/valenr.php?q='.$id.'&v='.$val.'" style="background-color: rgb(108, 117, 125); color: white; padding: 12px 24px; text-decoration: none; border-radius: 4px; display: inline-block;">Activer mon compte</a></p>';
	$msg.='<p>Ou copiez ce lien dans votre navigateur :<br/><span style="color: rgb(108, 117, 125);">https://vote.fifam.fr/valenr.php?q='.$id.'&v='.$val.'</span></p>';
	$msg.='<p style="color: #666; font-size: 0.9em;">Si vous n\'êtes pas à l\'origine de cette demande, ne cliquez pas sur le lien et votre email sera effacé automatiquement de notre base.</p>';
	$msg.='<p>Bon festival !</p>';
	$msg.='<hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">';
	$msg.='<p style="font-size: 0.8em; color: #999;">FIFAM - Festival International du Film d\'Amiens</p>';
	$msg.='</div></body></html>';
	$mail_sent=mail($to,$subject,$msg, $headers);
	if ($mail_sent) {
		$_SESSION['Message']='<div class="valid" >Votre compte n\'est pas encore activé.<br/>Un e-mail d\'activation vous a été renvoyé à l\'adresse <strong>'.$_POST['em1'].'</strong>.<br/>Merci de vérifier votre boîte de réception et vos spams.</div>';
	} else {
		$_SESSION['Message']='<div class="avert" >Une erreur s\'est produite lors de l\'envoi de l\'e-mail. Veuillez réessayer.</div>';
	}
	header('Location:dem-mdp.php');
	}
// Cas 3 : Erreur - Email inexistant ou initiales incorrectes
else
	{
	if (!$email_existe) {
		$_SESSION['Message']='<div class="avert" >Cet e-mail n\'existe pas dans notre base de données.</div>';
	} else {
		$_SESSION['Message']='<div class="avert" >Les initiales ne correspondent pas. Veuillez vérifier votre prénom et nom.</div>';
	}
	header('Location:dem-mdp.php');
	}
?>
