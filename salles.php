<?php
include('BdD.php');
if ($_SESSION["qui"]!=0) {header('Location:index.php');}
$men=2;
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="style/style.css?s=<?php echo(rand()); ?>" />
		<link rel="icon" href="img/logo.svg" />
		<meta name="viewport" content="initial-scale=1.0">
		<title>Les salles — FIFAM | Festival International du Film d'Amiens</title>
	</head>
	<body>
	<?php include('header.php'); ?>
	<article>
	<h4>Liste des salles de projection <a href="aj-c.php" id="aj" >&#9998;</a></h4>
	<br/>
	<table>
	<tr><th>Cinéma</th><th>Salle</th><th>&nbsp;</th></tr>
	<?php
	$rep=$cbdd->query('SELECT * FROM salle ORDER BY cine,nom ');
			while ($donnees = $rep->fetch())
			{
			echo('<tr><td>'.$donnees["cine"].'</td><td>'.$donnees["nom"].'</td><td class="fin" ><a href="moins-c.php?id='.$donnees["id"].'" >&#9447;</a>&nbsp;<a href="mod-c.php?id='.$donnees["id"].'" >&#9998;</a></td></tr>');
			}
		$rep->closeCursor();
	?>
	</table>
	</article>
	<br/><br/>
	</body>
</html>