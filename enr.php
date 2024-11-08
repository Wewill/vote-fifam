<?php
include('BdD.php');
$_SESSION['Message']="";
$id="";
$_POST['pnm']=str_replace(', ','-',ucwords(strtolower(str_replace('-',', ',nty(corr(trim($_POST["pnm"]),'p'))))));
$_POST["nm"]=strtoupper(nty(corr(trim($_POST["nm"]),'n')));
$rep=$cbdd->query('SELECT id FROM pub WHERE eml="'.encrypt(nty($_POST['em']),$clef).'" OR eml="'.encrypt(nty($_POST['cem']),$clef).'"');
	while ($donnees = $rep->fetch())
	{
	$id=$donnees['id'];
	$_SESSION['Message']='<div class="avert" >Vous avez déjà un compte.<br/>Connectez vous avec ce compte.<br/>Ou demandez le renouvellement de votre mot de passe.</div>';
	}
$rep->closeCursor();
if (nty($_POST['cmdp'])==nty($_POST['mdp']) & nty($_POST['cem'])==nty($_POST['em']) & nty($_POST['nm'])!=="" & nty($_POST['pnm'])!=="" & $id=="")
	{
	$cbdd->query('INSERT INTO pub (id,psd,mdp,eml,nm,pre,pht,act,vrf) VALUES(NULL,"","'.hash("sha256",nty($_POST['mdp'])).'","'.encrypt(nty($_POST['em']),$clef).'","'.encrypt($_POST["nm"],$clef).'","'.encrypt($_POST['pnm'],$clef).'","",0,'.(rand(100000,999999)).')');
	$rep=$cbdd->query('SELECT id,vrf FROM pub WHERE eml="'.encrypt(nty($_POST['em']),$clef).'"');
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
	$headers .= 'From: "Fifam" <'.$from.">\r\n".'Reply-To: <'.$from.">\r\nTo: <".$to.">\r\n".'X-Mailer: PHP/'.phpversion();
	$msg="Bonjour ".$_POST['pnm'].",<br/><br/>Vous êtes sur le point de finaliser votre inscription pour participer au vote du public du FIFAM.<br/>Pour cela il vous faut cliquer sur le lien ci dessous :<br/>".'<a href="https://vote.fifam.fr/valenr.php?q='.$id.'&v='.$val.'" />https://vote.fifam.fr/valenr.php?q='.$id.'&v='.$val.'</a><br/><br/>Si vous n\'êtes pas à l\'origine de cette demande, ne cliquez pas sur le lien et votre email sera effacé automatiquement de notre base sous 10 minutes.<br/><br/>Bon festival !';
	mail($to,$subject,$msg, $headers);
	$_SESSION['em']=$_POST['em'];
	header('Location:index.php');
	}
	else
	{
	header('Location:coin.php');
	}
?>
