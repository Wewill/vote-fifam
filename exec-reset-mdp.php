<?php
include('BdD.php');
if ($_SESSION["qui"]!=0) {header('Location:index.php');}
$_POST["id"]=preg_replace("/[^0-9]/","",$_POST["id"]);

// Vérifier qu'on ne modifie pas l'admin (id=0)
if ($_POST["id"]==0) {
	$_SESSION['Message']='<div class="avert" >Impossible de modifier le mot de passe de l\'administrateur.</div>';
	header('Location:utilisateurs.php');
	exit();
}

// Vérifier que les mots de passe correspondent
if ($_POST['mdp'] != $_POST['cmdp']) {
	$_SESSION['Message']='<div class="avert" >Les mots de passe ne correspondent pas.</div>';
	header('Location:reset-mdp.php?id='.$_POST["id"]);
	exit();
}

// Vérifier que le mot de passe fait au moins 6 caractères
if (strlen($_POST['mdp']) < 6) {
	$_SESSION['Message']='<div class="avert" >Le mot de passe doit contenir au moins 6 caractères.</div>';
	header('Location:reset-mdp.php?id='.$_POST["id"]);
	exit();
}

// Récupérer les infos de l'utilisateur
$rep=$cbdd->query('SELECT * FROM pub WHERE id='.$_POST["id"].' ');
$donnees = $rep->fetch();
$rep->closeCursor();

if (!$donnees) {
	$_SESSION['Message']='<div class="avert" >Utilisateur introuvable.</div>';
	header('Location:utilisateurs.php');
	exit();
}

$email = decrypt($donnees["eml"], $clef);
$prenom = decrypt($donnees["pre"], $clef);

// Réinitialiser le mot de passe et mettre vrf à 0
$nouveau_mdp_hash = hash("sha256", nty($_POST['mdp']));
$cbdd->query('UPDATE pub SET mdp="'.$nouveau_mdp_hash.'", vrf=0, act=1 WHERE id='.$_POST["id"].' ');

// Envoyer un email de notification
$from = "vote@fifam.fr";
$to = $email;
$subject = "[FIFAM] Votre mot de passe a été réinitialisé";
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
$headers .= 'From: "FIFAM - Festival International du Film d\'Amiens" <'.$from.">\r\n";
$headers .= 'Reply-To: '.$from."\r\n";
$headers .= 'Return-Path: '.$from."\r\n";
$headers .= 'X-Mailer: PHP/'.phpversion()."\r\n";
$headers .= 'X-Priority: 3'."\r\n";
$headers .= 'Message-ID: <'.time().'-'.$_POST["id"].'@vote.fifam.fr>'."\r\n";

$msg='<!DOCTYPE html><html><head><meta charset="utf-8"></head><body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">';
$msg.='<div style="max-width: 600px; margin: 0 auto; padding: 20px;">';
$msg.='<h2 style="color: rgb(108, 117, 125);">FIFAM - Mot de passe réinitialisé</h2>';
$msg.='<p>Bonjour '.$prenom.',</p>';
$msg.='<p>Votre mot de passe du site du vote du public du FIFAM a été réinitialisé par l\'administrateur.</p>';
$msg.='<p>Vous avez reçu votre nouveau mot de passe directement de l\'administrateur.</p>';
$msg.='<p>Vous pouvez maintenant vous connecter en cliquant sur le lien ci-dessous :</p>';
$msg.='<p style="margin: 20px 0;"><a href="https://vote.fifam.fr/coin.php" style="background-color: rgb(108, 117, 125); color: white; padding: 12px 24px; text-decoration: none; border-radius: 4px; display: inline-block;">Se connecter</a></p>';
$msg.='<p>Ou copiez ce lien dans votre navigateur :<br/><span style="color: rgb(108, 117, 125);">https://vote.fifam.fr/coin.php</span></p>';
$msg.='<p style="color: #666; font-size: 0.9em;">Si vous n\'êtes pas à l\'origine de cette demande, contactez l\'administrateur immédiatement.</p>';
$msg.='<p>Bon festival !</p>';
$msg.='<hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">';
$msg.='<p style="font-size: 0.8em; color: #999;">FIFAM - Festival International du Film d\'Amiens</p>';
$msg.='</div></body></html>';

mail($to, $subject, $msg, $headers);

$_SESSION['Message']='<div class="valid" >Le mot de passe de <strong>'.$email.'</strong> a été réinitialisé avec succès.<br/>Le compte est maintenant actif et l\'utilisateur a été notifié par email.</div>';
header('Location:utilisateurs.php');
?>
