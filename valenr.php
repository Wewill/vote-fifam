<?php 
include('BdD.php');
$_GET['q']=preg_replace("/[^0-9]/","",$_GET['q']);
$_GET['v']=preg_replace("/[^0-9]/","",$_GET['v']);
if ($_GET['v']==0) {$_GET['v']=33333333;}
$vrif="niet";
$id="";
unset($_SESSION["qui"]);
$rep=$cbdd->query('SELECT id,act,vrf FROM pub WHERE id='.$_GET['q'].' AND vrf='.$_GET['v'].' ');
		while ($donnees = $rep->fetch())
		{
		if ($donnees["act"]==0 && $donnees["vrf"]==$_GET['v']) {$id=$donnees["id"];$vrif="OK";}
		}
	$rep->closeCursor();
if ($vrif=="OK")
	{
	$cbdd->query('UPDATE pub SET vrf=0, act=1 WHERE id='.$_GET['q'].' ');
	$_SESSION["qui"]="".$id."";
	$_SESSION['Message']='<div class="valid" >Votre compte est maintenant activé ! Vous pouvez désormais participer au vote du public.</div>';
	header('Location:index.php');
	}
	else
	{
	$_SESSION['Message']='<div class="avert" >Ce lien d\'activation est invalide ou a déjà été utilisé.</div>';
	header('Location:index.php');
	}
?>
