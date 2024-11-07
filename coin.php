<?php
include('BdD.php');
if ($_SESSION["qui"]!="") {header('Location:profil.php');}
$men=10;
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="style/style.css?s=<?php echo(rand()); ?>" />
		<link rel="icon" href="img/logo.svg" />
		<meta name="viewport" content="initial-scale=1.0">
		<title>FIFAm : vote du public</title>
	</head>
	<body>
<?php include('header.php'); ?>
	<article>
	<?php echo($_SESSION['Message']);$_SESSION['Message']="" ?>
	<span class="frm" >
	<form method="post" action="cnx.php" >
	Déjà inscrit, je me connecte
	<label for="em1">Adresse email</label><input type="email" placeholder="Adresse email" name="em1" id="em1" value="<?php echo($_SESSION['em']); ?>" required />
	<label for="mdp1">Mot de passe</label><input type="password" placeholder="Mot de passe" name="mdp1" id="mdp1" required />
	<a href="dem-mdp.php" class="mdpo" >Mot de passe oublié</a>
	<input type="submit" value="Je me connecte" />
	</form>
	</span>
	<span class="frm">
	<form method="post" action="enr.php" >
	C'est mon premier vote
	<br/>
	<label for="em">Adresse email</label><input type="email" placeholder="Adresse email" name="em" id="em" required />
	<label for="cem">Confirmation de l'adresse email</label><input type="email" placeholder="Confirmation de l'adresse email" name="cem" id="cem" required />
	<label for="nm">Nom</label><input type="text" placeholder="Nom de famille" name="nm" id="nm" required />
	<label for="pnm">Prénom</label><input type="text" placeholder="Prénom" name="pnm" id="pnm" required />
	<label for="mdp">Mot de passe</label><input type="password" placeholder="Mot de passe" name="mdp" id="mdp" required />
	<label for="cmdp">Confirmation du mot de passe</label><input type="password" placeholder="Mot de passe" name="cmdp" id="cmdp" required />
	<input type="submit" value="Je m'inscris" />
	</form>
	</span>
	</article>
	</body>
</html>