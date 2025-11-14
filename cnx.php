<?php
include('BdD.php');
$vrif="niet";
$email_existe=false;
$_POST['em1']=strtolower(trim(nty($_POST['em1'])));

// Vérifier si l'email existe
$rep_check=$cbdd->query('SELECT id FROM pub WHERE eml="'.encrypt($_POST['em1'], $clef).'" AND act=1 ');
if ($rep_check->fetch()) {
	$email_existe=true;
}
$rep_check->closeCursor();

// Vérifier email + mot de passe
$rep=$cbdd->query('SELECT id FROM pub WHERE eml="'.encrypt($_POST['em1'], $clef).'" AND mdp="'.hash("sha256",nty($_POST['mdp1'])).'" AND act=1 ');
	while ($donnees = $rep->fetch())
	{
	$vrif="OK";
	$id=$donnees["id"];
	}
	$rep->closeCursor();

if ($vrif=="OK") {
	$_SESSION['Message']="";
	$_SESSION["qui"]="".$id."";
	header('Location:index.php');
} else {
	unset($_SESSION["qui"]);
	if (!$email_existe) {
		$_SESSION['Message']='<div class="avert" >Cet e-mail n\'existe pas dans notre base de données.</div>';
	} else {
		$_SESSION['Message']='<div class="avert" >Mot de passe incorrect.</div>';
	}
	header('Location:coin.php');
}
?>
