<?php
include('BdD.php');
if ($_SESSION["qui"]!=0) {header('Location:index.php');}
$men=6;
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="style/style.css?s=<?php echo(rand()); ?>" />
		<link rel="icon" href="img/logo.svg" />
		<meta name="viewport" content="initial-scale=1.0">
		<title>Les utilisateurs — FIFAM | Festival International du Film d'Amiens</title>
	</head>
	<body>
	<?php include('header.php'); ?>
	<article>
	<h4>Liste des utilisateurs</h4>
	<br/>
	<table>
	<tr><th>Nom</th><th>Prénom</th><th>Email</th><th>Pseudo</th><th>Photo</th><th>Actif</th><th>Vérifié</th></tr><?php
$rep=$cbdd->query('SELECT id,nm,pre,eml,psd,pht,act,vrf FROM pub ORDER BY nm,pre');
		while ($donnees = $rep->fetch())
		{
		$nom = decrypt($donnees["nm"],$clef);
		$prenom = decrypt($donnees["pre"],$clef);
		$email = decrypt($donnees["eml"],$clef);
		$pseudo = $donnees["psd"];
		$photo = $donnees["pht"];
		$actif = $donnees["act"] == 1 ? 'Oui' : 'Non';
		$verifie = $donnees["vrf"] == 1 ? 'Oui' : 'Non';

		echo("\n\t".'<tr><td>'.$nom.'</td><td>'.$prenom.'</td><td>'.$email.'</td><td>'.$pseudo.'</td><td>'.$photo.'</td><td>'.$actif.'</td><td>'.$verifie.'</td></tr>');
		}
	$rep->closeCursor();
?>
	</table>
	</article>
	<br/><br/>
	</body>
</html>
