<?php 
include('BdD.php');
if ($_SESSION["qui"]!=0) {header('Location:index.php');}
$cbdd->query('DELETE FROM seances WHERE id='.$_POST["id"].' ');
$rep=$cbdd->query('SELECT * FROM tickets WHERE snc='.$_POST["id"].' ');
	while ($donnees = $rep->fetch())
	{
	$nume=substr('000'.$donnees["nno"].'',-4);
	unlink('qr/'.$donnees['serie'].'-'.$nume.'.png');
	$cbdd->query('DELETE FROM tickets WHERE id='.$donnees["id"].' ');
	}
$rep->closeCursor();
header('Location:seances.php');
?>