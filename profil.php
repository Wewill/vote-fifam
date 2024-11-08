<?php
include('BdD.php');
$men=10;
$rep=$cbdd->query('SELECT nm,pre FROM pub WHERE id='.$_SESSION["qui"].' ');
		while ($donnees = $rep->fetch())
		{
		$nom=$donnees["nm"];
		$pre=$donnees["pre"];
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
		<title>Mon profil — FIFAM | Festival International du Film d'Amiens</title>
	</head>
	<body>
<?php include('header.php'); ?>
	<article>
	<h2>Mon profil</h2>
	<span class="frm">
	<form method="post" action="modp.php" >
	<?php echo(decrypt($pre,$clef).' '.decrypt($nom,$clef)); ?>
	</form>
	</span>
	<br/><br/><br/><br/>
	<a href="dcnx.php" ><input type="button" value=" Je me déconnecte " /></a>
	</article>
	</body>
</html>