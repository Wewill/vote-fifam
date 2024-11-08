<?php
include('BdD.php');
if ($_SESSION["qui"]!=0) {header('Location:index.php');}
$men=1;
$_GET['id']=preg_replace("/[^0-9]/","",$_GET['id']);
$rep=$cbdd->query('SELECT id FROM votes WHERE film='.$_GET["id"].' ');
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
		<title>Modifier un film — FIFAM | Festival International du Film d'Amiens</title>
	</head>
	<body>
<?php include('header.php'); ?>
	<article>
	<form method="post" action="upd-f.php" >
	<br/>
	Attention !<br/>Je suis sur le point de<br/>modifier ce film dans la liste.
	<br/><br/>
	<table>
	<tr><th>Film</th><th>Réalisateur</th><th>Année</th></tr>
<?php 
$rep=$cbdd->query('SELECT * FROM films WHERE id='.$_GET["id"].' ');
		while ($donnees = $rep->fetch())
		{
		echo('<tr><td><input type="text" value="'.$donnees["nom"].'" name="nom" /></td><td><input type="text" value="'.$donnees["ral"].'" name="nreal" /></td><td><input type="number" value="'.$donnees["ann"].'" name="ann" min="1800" max="'.date("Y").'" /></td></tr>');
		}
	$rep->closeCursor();
?>
	</table>
	<br/>
	<input type="hidden" value="<?php echo($_GET["id"]); ?>" name="id" />
	<input type="submit" onclick="return confirm('Je confirme la modification de ce film.')" value=" Modifier " <?php echo($alrt); ?>/>
	<a href="films.php" ><input type="button" value=" Retour à la liste " /></a>
	</form>
	</article>
	</body>
</html>