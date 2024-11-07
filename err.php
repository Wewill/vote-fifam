<?php
include('BdD.php');
$men=5;
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
		<meta name="keywords" content="FIFAM,Festival,International,Film,Amiens,2023,vote,public,iszir" />
		<meta name="description" content="Retrouvez ici le travail des élèves du lycée Edouard Branly d'Amiens. Collecte du vote du public du FIFAm 2023" />
		<title>FIFAm : vote du public</title>
	</head>
	<body>
<?php include('header.php'); ?>
	<article>
	<br/><img src="img/logocolor.svg" /><br/><br/>
	Oups !<br/><br/><?php echo($_SESSION['err']); unset($_SESSION['err']); ?>
	</article>
	</body>
</html>