<?php
include('BdD.php');
if ($_SESSION["qui"]!=0) {header('Location:index.php');}
$men=6;
$_GET["id"]=preg_replace("/[^0-9]/","",$_GET["id"]);

// Vérifier qu'on ne supprime pas l'admin (id=0)
if ($_GET["id"]==0) {
	header('Location:utilisateurs.php');
	exit();
}

$alrt="";
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="style/style.css?s=<?php echo(rand()); ?>" />
		<link rel="icon" href="img/logo.svg" />
		<meta name="viewport" content="initial-scale=1.0">
		<title>Supprimer un utilisateur — FIFAM | Festival International du Film d'Amiens</title>
	</head>
	<body>
<?php include('header.php'); ?>
	<article>
	<form method="post" action="suppr-u.php" >
	<br/>
	<small class="muted">Attention ! Je suis sur le point de supprimer cet utilisateur.</small>
	<br/><br/>
	<table>
	<tr><th>Nom</th><th>Prénom</th><th>Email</th><th>Statut</th><th>A voté</th></tr>
	<?php
		$rep=$cbdd->query('SELECT p.id, p.nm, p.pre, p.eml, p.act, COUNT(DISTINCT v.id) as nb_votes
						   FROM pub p
						   LEFT JOIN votes v ON p.id = v.qui
						   WHERE p.id = '.$_GET["id"].'
						   GROUP BY p.id');
		while ($donnees = $rep->fetch())
		{
		$nom = decrypt($donnees["nm"],$clef);
		$prenom = decrypt($donnees["pre"],$clef);
		$email = decrypt($donnees["eml"],$clef);
		$statut = $donnees["act"] == 1 ? '<span class="status-oui">Actif</span>' : '<span class="status-attente">Inactif</span>';
		$a_vote = $donnees["nb_votes"] > 0 ? '<span class="status-oui">Oui ('.$donnees["nb_votes"].' votes)</span>' : '<span class="status-non">Non</span>';

		echo('<tr><td>'.$nom.'</td><td>'.$prenom.'</td><td>'.$email.'</td><td>'.$statut.'</td><td>'.$a_vote.'</td></tr>');
		}
		$rep->closeCursor();
	?>
	</table>
	<br/>
	<small class="muted">La suppression effacera également tous les votes associés à cet utilisateur.</small>
	<br/><br/>
	<input type="hidden" value="<?php echo($_GET["id"]); ?>" name="id" />
	<input type="submit" value=" Supprimer " onclick="return confirm('Je confirme la suppression définitive de cet utilisateur et de tous ses votes.')" />
	<a href="utilisateurs.php" ><input type="button" value=" Retour à la liste " /></a>
	</form>
	</article>
	</body>
</html>
