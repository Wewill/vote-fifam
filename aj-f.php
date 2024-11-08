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
		<title>Ajouter un film — FIFAM | Festival International du Film d'Amiens</title>
	</head>
	<body>
<?php include('header.php'); ?>
	<article>
	<form method="post" action="enr-f.php" >
	<br/>
	Attention !<br/>Je suis sur le point d'ajouter<br/>un film dans la liste.
	<br/><br/>
	<table>
	<tr><th>Film</th><th>Réalisateur</th><th>Année</th></tr>
	<tr><td><input type="text" value="" name="nom" required /></td><td><input type="text" value="" name="nreal" required /></td><td><input type="number" value="" name="ann" min="1800" max="<?php echo(date("Y")); ?>" required /></td></tr>
	</table>
	<br/>
	<input type="submit" value=" Ajouter " onclick="return confirm('Je confirme l\'ajout de ce film.')" />
	<a href="films.php" ><input type="button" value=" Retour à la liste " /></a>
	</form>
	</article>
	</body>
</html>