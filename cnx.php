<?php 
include('BdD.php');
$_SESSION['Message']='<div class="avert" >E-mail ou mot de passe incorrect.</div>';
$vrif="niet";
$rep=$cbdd->query('SELECT id FROM pub WHERE eml="'.encrypt(nty($_POST['em1']), $clef).'" AND mdp="'.hash("sha256",nty($_POST['mdp1'])).'" AND act=1 ');
		while ($donnees = $rep->fetch())
		{
		$vrif="OK";
		$id=$donnees["id"];
		$_SESSION['Message']="";
		}
	$rep->closeCursor();
	echo($vrif);
if ($vrif=="OK") {$_SESSION["qui"]="".$id."";header('Location:index.php');} else {unset($_SESSION["qui"]);header('Location:coin.php');}
?>