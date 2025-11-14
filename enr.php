<?php
include('BdD.php');
$_SESSION['Message']="";
$id="";
$_POST['pnm']=str_replace(', ','-',ucwords(strtolower(str_replace('-',', ',nty(corr(trim($_POST["pnm"]),'p'))))));
$_POST["nm"]=strtoupper(nty(corr(trim($_POST["nm"]),'n')));
$_POST['em']=strtolower(trim(nty($_POST['em'])));
$_POST['cem']=strtolower(trim(nty($_POST['cem'])));
$rep=$cbdd->query('SELECT id FROM pub WHERE eml="'.encrypt($_POST['em'],$clef).'" OR eml="'.encrypt($_POST['cem'],$clef).'"');
	while ($donnees = $rep->fetch())
	{
	$id=$donnees['id'];
	$_SESSION['Message']='<div class="avert" >Vous avez déjà un compte.<br/>Connectez vous avec ce compte.<br/>Ou demandez le renouvellement de votre mot de passe.</div>';
	}
$rep->closeCursor();
if (nty($_POST['cmdp'])==nty($_POST['mdp']) & $_POST['cem']==$_POST['em'] & nty($_POST['nm'])!=="" & nty($_POST['pnm'])!=="" & $id=="")
	{
	$cbdd->query('INSERT INTO pub (id,psd,mdp,eml,nm,pre,pht,act,vrf) VALUES(NULL,"","'.hash("sha256",nty($_POST['mdp'])).'","'.encrypt($_POST['em'],$clef).'","'.encrypt($_POST["nm"],$clef).'","'.encrypt($_POST['pnm'],$clef).'","",0,'.(rand(100000,999999)).')');
	$rep=$cbdd->query('SELECT id,vrf FROM pub WHERE eml="'.encrypt($_POST['em'],$clef).'"');
		while ($donnees = $rep->fetch())
		{
		$id=$donnees['id'];
		$val=$donnees['vrf'];
		}
	$rep->closeCursor();
	ini_set( 'display_errors', 1 );
	error_reporting( E_ALL );
	$from = "vote@fifam.fr";
	$to = $_POST['em'];
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
	$msg.='<p>Bonjour '.$_POST['pnm'].',</p>';
	$msg.='<p>Vous êtes sur le point de finaliser votre inscription pour participer au vote du public du FIFAM.</p>';
	$msg.='<p>Pour activer votre compte, veuillez cliquer sur le lien ci-dessous :</p>';
	$msg.='<p style="margin: 20px 0;"><a href="https://vote.fifam.fr/valenr.php?q='.$id.'&v='.$val.'" style="background-color: rgb(108, 117, 125); color: white; padding: 12px 24px; text-decoration: none; border-radius: 4px; display: inline-block;">Activer mon compte</a></p>';
	$msg.='<p>Ou copiez ce lien dans votre navigateur :<br/><span style="color: rgb(108, 117, 125);">https://vote.fifam.fr/valenr.php?q='.$id.'&v='.$val.'</span></p>';
	$msg.='<p style="color: #666; font-size: 0.9em;">Si vous n\'êtes pas à l\'origine de cette demande, ne cliquez pas sur le lien et votre email sera effacé automatiquement de notre base.</p>';
	$msg.='<p>Bon festival !</p>';
	$msg.='<hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">';
	$msg.='<p style="font-size: 0.8em; color: #999;">FIFAM - Festival International du Film d\'Amiens</p>';
	$msg.='</div></body></html>';
	mail($to,$subject,$msg, $headers);
	$_SESSION['em']=$_POST['em'];
	header('Location:index.php');
	}
	else
	{
	header('Location:coin.php');
	}
?>
