<?php
include('BdD.php');
if ($_SESSION["qui"]!=0) {header('Location:index.php');}
$men=1;
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="style/style.css?s=<?php echo(rand()); ?>" />
		<link rel="icon" href="img/logo.svg" />
		<meta name="viewport" content="initial-scale=1.0">
		<title>Les films — FIFAM | Festival International du Film d'Amiens</title>
	</head>
	<body>
	<?php include('header.php'); ?>
	<article>
	<h4>Liste des films en compétition <a href="aj-f.php" id="aj" ><i class="icon icon-plus"></i></a></h4>
	<br/>
	<table>
	<tr><th>Film</th><th>Réalisateur</th><th>Année</th><th>&nbsp;</th></tr><?php
$rep=$cbdd->query('SELECT * FROM films ORDER BY nom,ann');
		while ($donnees = $rep->fetch())
		{
		echo("\n\t".'<tr><td>'.$donnees["nom"].'</td><td>'.$donnees["ral"].'</td><td>'.$donnees["ann"].'</td><td class="fin" ><a href="moins-f.php?id='.$donnees["id"].'" >&#9447;</a>&nbsp;<a href="mod-f.php?id='.$donnees["id"].'" >&#9998;</a></td></tr>');
		}
	$rep->closeCursor();
?>
	</table>
	</article>
	<br/><br/>
	</body>
</html>