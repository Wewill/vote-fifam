<?php
include('BdD.php');
if ($_SESSION["qui"]!=0) {header('Location:index.php');}
$men=2;
$rep=$cbdd->query('SELECT id FROM seances WHERE sal='.$_GET["id"].' ');
	while ($donnees = $rep->fetch())
	{
	$alrt="disabled";
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
		<title>Modifier une salle</title>
	</head>
	<body>
<?php include('header.php'); ?>
	<article>
	<form method="post" action="upd-c.php" >
	<br/>
	Attention !<br/>Je suis sur le point de<br/>modifier cette salle de la liste.
	<br/><br/>
	<table>
	<tr><th>Cinéma</th><th>salle</th></tr>
<?php 
$rep=$cbdd->query('SELECT * FROM salle WHERE id='.$_GET["id"].' ');
		while ($donnees = $rep->fetch())
		{
		echo('<tr><td><input type="text" value="'.$donnees["cine"].'" name="cine" /></td><td><input type="text" value="'.$donnees["nom"].'" name="nom" /></td></tr>');
		}
	$rep->closeCursor();
?>
	</table>
	<br/>
	<input type="hidden" value="<?php echo($_GET["id"]); ?>" name="id" />
	<input type="submit" onclick="return confirm('Je confirme la modification de cette salle.')" value=" Modifier " <?php echo($alrt); ?>/>
	<a href="salles.php" ><input type="button" value=" Retour à la liste " /></a>
	</form>
	</article>
	</body>
</html>