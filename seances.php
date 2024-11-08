<?php
include('BdD.php');
if ($_SESSION["qui"]!=0) {header('Location:index.php');}
$men=3;
$rep=$cbdd->query('SELECT * FROM salle');
		while ($donnees = $rep->fetch())
		{
		$salle[$donnees["id"]]=''.$donnees["cine"].'<br/>('.$donnees["nom"].')';
		}
	$rep->closeCursor();
$rep=$cbdd->query('SELECT * FROM films ');
		while ($donnees = $rep->fetch())
		{
		$film[$donnees["id"]]='"'.$donnees["nom"].'"<br/>de '.$donnees["ral"].'<br/>('.$donnees["ann"].')';
		}
	$rep->closeCursor();
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="style/style.css?s=<?php echo(rand()); ?>" />
		<link rel="icon" href="img/logo.svg" />
		<meta name="viewport" content="initial-scale=1.0">
		<title>Les séances — FIFAM | Festival International du Film d'Amiens</title>
	</head>
	<body>
<?php include('header.php'); ?>
	<article>
<br/>
Liste des séances <a href="aj-s.php" id="aj" >&#9998;</a>
<br/><br/>
	<table>
	<tr><th>Date</th><th>Séance</th><th>Film</th><th>Cinéma</th><th>&nbsp;</th></tr>
<?php
$rep=$cbdd->query('SELECT * FROM seances ORDER BY dte ');
		while ($donnees = $rep->fetch())
		{
		echo('<tr><td>'.strftime("%A<br/>%d<br/>%B", strtotime($donnees["dte"])).'</td><td>'.strftime("%kh%M", strtotime($donnees["deb"])).'<br/>&#128499;</td><td>'.$film[$donnees["film"]].'</td><td>'.$salle[$donnees["sal"]].'</td><td class="fin" ><a href="moins-s.php?id='.$donnees["id"].'" >&#9447;</a><br/><a href="mod-s.php?id='.$donnees["id"].'&f='.$donnees["film"].'&s='.$donnees["sal"].'" >&#9998;</a><br/><a href="pdf-b.php?id='.$donnees["id"].'" >&#127903;</a></td></tr>');
		}
	$rep->closeCursor();
?>
	</table>
	</article>
	<br/><br/>
	</body>
</html>