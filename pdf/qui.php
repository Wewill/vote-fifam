<?php
include('../BdD.php');
if ($_SESSION["qui"]=="0")
	{
	$rep=$cbdd->query('SELECT * FROM pub');
		while ($donnees = $rep->fetch())
		{
		echo('N°:'.$donnees['id'].' > '.decrypt($donnees['pre'],$clef).' > '.decrypt($donnees['nm'],$clef).' ( '.decrypt($donnees['eml'],$clef)." )<br/>\n");
		}
	$rep->closeCursor();
	}
	else
	{
	header('Location:../index.php');
	}
?>