<?php
include('BdD.php');
$men=0;
if (preg_match("/^[A-Z]{2}[-]\d{4}[-]\w{6}$/",$_GET['n'])) {$_SESSION["code"]=$_GET["n"];}
if (!isset($_SESSION["qui"]) && isset($_SESSION["code"])) {if (!isset($_SESSION['em'])) {header('Location:coin.php');}}
else if ($_SESSION["code"]!="") {header('Location:vote.php');}
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="style/style.css?s=<?php echo(rand()); ?>" />
		<link rel="icon" href="img/logo.svg" />
		<meta name="viewport" content="initial-scale=1.0">
		<meta name="ROBOTS" content="all" />
		<meta name="revised" content="<?php echo(date("Y-m-d")); ?>" />
		<meta name="keywords" content="FIFAM,Festival,International,Film,Amiens,<?php echo(date("Y")); ?>,vote,public,iszir" />
		<meta name="description" content="Retrouvez ici le travail des élèves du lycée Edouard Branly d'Amiens. Collecte du vote du public du FIFAM <?php echo(date("Y")); ?>" />
		<title>Vote du public — FIFAM | Festival International du Film d'Amiens</title>
	</head>
	<body>
	<?php include('header.php'); ?>
	<article>
	<br/><img src="img/Logotype_fifam_plein.svg" height="190" alt="Logotype FIFAM"/>
	<?php if (isset($_SESSION['em'])) {echo('<p class="muted" >Allez consulter l\'adresse mail :<br/>'.$_SESSION['em'].'<br/>pour valider votre inscription</p>');unset($_SESSION['em']);} ?>
	<br/>
	<h1>Bienvenue sur le site <br/>du vote du public <br/>du 44<sup>e</sup> Festival International<br/>du Film d'Amiens <?php echo(date("Y")); ?></h1>
	</article>
	</body>
</html>