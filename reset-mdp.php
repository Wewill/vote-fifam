<?php
include('BdD.php');
if ($_SESSION["qui"]!=0) {header('Location:index.php');}
$men=6;
$_GET["id"]=preg_replace("/[^0-9]/","",$_GET["id"]);

// Vérifier qu'on ne modifie pas l'admin (id=0)
if ($_GET["id"]==0) {
	header('Location:utilisateurs.php');
	exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="style/style.css?s=<?php echo(rand()); ?>" />
		<link rel="icon" href="img/logo.svg" />
		<meta name="viewport" content="initial-scale=1.0">
		<title>Réinitialiser le mot de passe — FIFAM | Festival International du Film d'Amiens</title>
	</head>
	<body>
<?php include('header.php'); ?>
	<article>
	<form method="post" action="exec-reset-mdp.php" >
	<br/>
	<small class="muted">Je suis sur le point de réinitialiser le mot de passe de cet utilisateur.</small>
	<br/><br/>
	<table>
	<tr><th>Nom</th><th>Prénom</th><th>Email</th><th>Statut</th></tr>
	<?php
		$rep=$cbdd->query('SELECT p.id, p.nm, p.pre, p.eml, p.act
						   FROM pub p
						   WHERE p.id = '.$_GET["id"].' ');
		while ($donnees = $rep->fetch())
		{
		$nom = decrypt($donnees["nm"],$clef);
		$prenom = decrypt($donnees["pre"],$clef);
		$email = decrypt($donnees["eml"],$clef);
		$statut = $donnees["act"] == 1 ? '<span class="status-oui">Actif</span>' : '<span class="status-attente">Inactif</span>';

		echo('<tr><td>'.$nom.'</td><td>'.$prenom.'</td><td>'.$email.'</td><td>'.$statut.'</td></tr>');
		}
		$rep->closeCursor();
	?>
	</table>
	<br/>
	<span class="frm">
	<label>Nouveau mot de passe :</label>
	<input type="password" name="mdp" required minlength="6" />
	<label>Confirmer le mot de passe :</label>
	<input type="password" name="cmdp" required minlength="6" />
	</span>
	<br/><br/>
	<input type="hidden" value="<?php echo($_GET["id"]); ?>" name="id" />
	<input type="submit" value=" Réinitialiser le mot de passe " />
	<a href="utilisateurs.php" ><input type="button" value=" Retour à la liste " /></a>
	</form>
	</article>
	</body>
</html>
