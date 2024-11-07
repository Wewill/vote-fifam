<?php
include('BdD.php');
$men=10;
$vrf="niet";
if (isset($_GET['v']) && isset($_GET['q']))
	{
	$_GET['v']=preg_replace("/[^0-9]/","",$_GET['v']);
//	if ($_GET['v']==0) {$_GET['v']=33333333;}
	$_GET['q']=preg_replace("/[^0-9]/","",$_GET['q']);
	$rep=$cbdd->query('SELECT id FROM pub WHERE id='.$_GET['q'].' AND vrf='.$_GET['v'].'');
		while ($donnees = $rep->fetch())
		{
		$vrf="OK";
		}
	$rep->closeCursor();
	}
if ($vrf=="niet") {header('Location:index.php');}
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="style/style.css?s=<?php echo(rand()); ?>" />
		<link rel="icon" href="img/logo.svg" />
		<meta name="viewport" content="initial-scale=1.0">
		<title>FIFAm : RAZ MdP</title>
	</head>
	<body>
<?php include('header.php'); ?>
	<article>
	<span class="frm">
	<form method="post" action="upd-mdp.php" >
	Je change mon mot de passe :
	<br/>
	<label for="mdp">Nouveau mot de passe</label><input type="password" placeholder="Mot de passe" name="mdp" id="mdp" required />
	<label for="cmdp">Confirmation du nouveau mot de passe</label><input type="password" placeholder="Mot de passe" name="cmdp" id="cmdp" required />
	<input type="hidden" name="vrf" value="<?php echo($_GET['v']); ?>" />
	<input type="hidden" name="id" value="<?php echo($_GET['q']); ?>" />
	<input type="submit" value=" Je valide " />
	</form>
	</span>
	</article>
	</body>
</html>