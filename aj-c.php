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
		<title>Ajouter une salle — FIFAM | Festival International du Film d'Amiens</title>
	</head>
	<body>
<?php include('header.php'); ?>
	<article>
	<form method="post" action="enr-c.php" >
	<br/>
	Attention !<br/>Je suis sur le point d'ajouter<br/>une salle dans la liste.
	<br/><br/>
	<table>
	<tr><th>Cinéma</th><th>salle</th></tr>
	<tr><td><input type="text" value="" name="cine" /></td><td><input type="text" value="" name="nom" /></td></tr>
	</table>
	<br/>
	<input type="submit" value=" Ajouter " onclick="return confirm('Je confirme l\'ajout de cette salle.')" />
	<a href="salles.php" ><input type="button" value=" Retour à la liste " /></a>
	</form>
	</article>
	</body>
</html>