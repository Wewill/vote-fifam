<?php
include('BdD.php');
if ($_SESSION["qui"]!=0) {header('Location:index.php');}
$_GET["id"]=preg_replace("/[^0-9]/","",$_GET["id"]);

// Vérifier qu'on ne modifie pas l'admin (id=0)
if ($_GET["id"]==0) {
	$_SESSION['Message']='<div class="avert" >Impossible de renvoyer un email à l\'administrateur.</div>';
	header('Location:utilisateurs.php');
	exit();
}

// Récupérer les infos de l'utilisateur
$rep=$cbdd->query('SELECT * FROM pub WHERE id='.$_GET["id"].' ');
$donnees = $rep->fetch();
$rep->closeCursor();

if (!$donnees) {
	$_SESSION['Message']='<div class="avert" >Utilisateur introuvable.</div>';
	header('Location:utilisateurs.php');
	exit();
}

$email = decrypt($donnees["eml"], $clef);
$prenom = decrypt($donnees["pre"], $clef);
$actif = $donnees["act"];

// Générer un nouveau code de vérification
$val = rand(100000,999999);
$cbdd->query('UPDATE pub SET vrf='.$val.' WHERE id='.$_GET["id"].' ');

$from = "vote@fifam.fr";
$to = $email;

// Si le compte n'est pas activé, envoyer un email d'activation
if ($actif == 0) {
	$subject = "[FIFAM] Confirmation d'inscription";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
	$headers .= 'From: "FIFAM - Festival International du Film d\'Amiens" <'.$from.">\r\n";
	$headers .= 'Reply-To: '.$from."\r\n";
	$headers .= 'Return-Path: '.$from."\r\n";
	$headers .= 'X-Mailer: PHP/'.phpversion()."\r\n";
	$headers .= 'X-Priority: 3'."\r\n";
	$headers .= 'Message-ID: <'.time().'-'.$_GET["id"].'@vote.fifam.fr>'."\r\n";

	$msg='<!DOCTYPE html><html><head><meta charset="utf-8"></head><body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">';
	$msg.='<div style="max-width: 600px; margin: 0 auto; padding: 20px;">';
	$msg.='<h2 style="color: rgb(108, 117, 125);">FIFAM - Confirmation d\'inscription</h2>';
	$msg.='<p>Bonjour '.$prenom.',</p>';
	$msg.='<p>Votre compte n\'est pas encore activé. Pour finaliser votre inscription et participer au vote du public du FIFAM, veuillez cliquer sur le lien ci-dessous :</p>';
	$msg.='<p style="margin: 20px 0;"><a href="https://vote.fifam.fr/valenr.php?q='.$_GET["id"].'&v='.$val.'" style="background-color: rgb(108, 117, 125); color: white; padding: 12px 24px; text-decoration: none; border-radius: 4px; display: inline-block;">Activer mon compte</a></p>';
	$msg.='<p>Ou copiez ce lien dans votre navigateur :<br/><span style="color: rgb(108, 117, 125);">https://vote.fifam.fr/valenr.php?q='.$_GET["id"].'&v='.$val.'</span></p>';
	$msg.='<p style="color: #666; font-size: 0.9em;">Cet email a été renvoyé par l\'administrateur.</p>';
	$msg.='<p>Bon festival !</p>';
	$msg.='<hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">';
	$msg.='<p style="font-size: 0.8em; color: #999;">FIFAM - Festival International du Film d\'Amiens</p>';
	$msg.='</div></body></html>';

	$message_type = "d'activation";
} else {
	// Sinon, envoyer un email de réinitialisation de mot de passe
	$subject = "[FIFAM] Réinitialisation du mot de passe";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
	$headers .= 'From: "FIFAM - Festival International du Film d\'Amiens" <'.$from.">\r\n";
	$headers .= 'Reply-To: '.$from."\r\n";
	$headers .= 'Return-Path: '.$from."\r\n";
	$headers .= 'X-Mailer: PHP/'.phpversion()."\r\n";
	$headers .= 'X-Priority: 3'."\r\n";
	$headers .= 'Message-ID: <'.time().'-'.$_GET["id"].'@vote.fifam.fr>'."\r\n";

	$msg='<!DOCTYPE html><html><head><meta charset="utf-8"></head><body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">';
	$msg.='<div style="max-width: 600px; margin: 0 auto; padding: 20px;">';
	$msg.='<h2 style="color: rgb(108, 117, 125);">FIFAM - Réinitialisation du mot de passe</h2>';
	$msg.='<p>Bonjour '.$prenom.',</p>';
	$msg.='<p>L\'administrateur a demandé la réinitialisation de votre mot de passe du site du vote du public du FIFAM.</p>';
	$msg.='<p>Pour réinitialiser votre mot de passe, veuillez cliquer sur le lien ci-dessous :</p>';
	$msg.='<p style="margin: 20px 0;"><a href="https://vote.fifam.fr/mod-mdp.php?q='.$_GET["id"].'&v='.$val.'" style="background-color: rgb(108, 117, 125); color: white; padding: 12px 24px; text-decoration: none; border-radius: 4px; display: inline-block;">Réinitialiser mon mot de passe</a></p>';
	$msg.='<p>Ou copiez ce lien dans votre navigateur :<br/><span style="color: rgb(108, 117, 125);">https://vote.fifam.fr/mod-mdp.php?q='.$_GET["id"].'&v='.$val.'</span></p>';
	$msg.='<p style="color: #666; font-size: 0.9em;">Si vous n\'avez pas demandé cette réinitialisation, contactez l\'administrateur.</p>';
	$msg.='<p>Bon festival !</p>';
	$msg.='<hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">';
	$msg.='<p style="font-size: 0.8em; color: #999;">FIFAM - Festival International du Film d\'Amiens</p>';
	$msg.='</div></body></html>';

	$message_type = "de réinitialisation";
}

$mail_sent = mail($to, $subject, $msg, $headers);

if ($mail_sent) {
	$_SESSION['Message']='<div class="valid" >Email '.$message_type.' renvoyé à <strong>'.$email.'</strong>.<br/>Le lien a été mis à jour.</div>';
} else {
	$_SESSION['Message']='<div class="avert" >Erreur lors de l\'envoi de l\'email. Vérifiez la configuration du serveur mail.</div>';
}

header('Location:utilisateurs.php');
?>
