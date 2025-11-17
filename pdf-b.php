<?php
include('BdD.php');
if ($_SESSION["qui"]!=0) {header('Location:index.php');}
$men=3;
$nbil=0;
$rep=$cbdd->query('SELECT * FROM seances WHERE id='.$_GET['id'].' ');
	while ($donnees = $rep->fetch())
	{
	$snc='<tr><td colspan="5" >Séance du '.strftime("%A %d %B", strtotime($donnees["dte"])).' de '.strftime("%kh%M", strtotime($donnees["deb"])).'</td></tr>';
	$f=$donnees["film"];
	}
$rep->closeCursor();
$rep=$cbdd->query('SELECT * FROM films WHERE id='.$f.' ');
	while ($donnees = $rep->fetch())
	{
	$film='"'.$donnees["nom"].'"<br/>de '.$donnees["ral"].'<br/>('.$donnees["ann"].')';
	}
$rep->closeCursor();
$rep=$cbdd->query('SELECT * FROM votes WHERE snc='.$_GET['id'].' ');
	while ($donnees = $rep->fetch())
	{
	$nbil++;
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
		<title>Billets de vote — FIFAM | Festival International du Film d'Amiens</title>
	</head>
	<body>
<?php include('header.php'); ?>
	
	<article>
	<h4>Liste des billets</h4>
	<br/>
	<table>
	<tr><th>Film</th><th>Billets</th><th>Série</th><th>Nb</th><th>&nbsp;</th></tr>
	<?php
	$nb=0;
	echo(''.$snc.'<tr><td>'.$film.'</td><td class="mini" >');
	$x=0;
	$rep=$cbdd->query('SELECT * FROM tickets WHERE snc='.$_GET['id'].' AND val=1 ORDER BY nno');
			while ($donnees = $rep->fetch())
			{
			$x++;
			if ($x%6==0) {$sep="<br/>";} else {$sep=" | ";}
			echo(''.$donnees["code"].$sep.'');
			$serie=$donnees["serie"];
			$der=$donnees["nno"];
			$val=$donnees["val"];
			$nb++;
			}
		$rep->closeCursor();
		if ($val<2) {$impr='<a href="impr-t.php?s='.$_GET['id'].'" target="_blank" onclick="return confirm(\'Je confirme la création du PDF des bulletins de vote.\')" >&#128424;</a>';}
		if ($serie=='') {$serie='<input type="text" name="" maxlength="2" required />';}
		echo('</td><td>'.$serie.'</td><td>'.$nb.' / '.($nb+$nbil).'</td><td class="fin" >'.$impr.'<br/><a href="plus-t.php?s='.$_GET['id'].'&n=4" onclick="return confirm(\'Je confirme la création de 4 bulletins de vote.\')" >&#10798; 4</a><br/><a href="plus-t.php?s='.$_GET['id'].'&n=12" onclick="return confirm(\'Je confirme la création de 12 bulletins de vote.\')" >&#10798; 12</a><br/><a href="plus-t.php?s='.$_GET['id'].'&n=180" onclick="return confirm(\'Je confirme la création de 180 bulletins de vote.\')" >&#10798; 180</a><br/><a href="plus-t.php?s='.$_GET['id'].'&n=252" onclick="return confirm(\'Je confirme la création de 252 bulletins de vote.\')" >&#10798; 252</a><br/><a href="plus-t.php?s='.$_GET['id'].'&n=300" onclick="return confirm(\'Je confirme la création de 300 bulletins de vote.\')" >&#10798; 300</a></td><tr>');
	?>
	</table>
	<br/>
	<input type="hidden" value="<?php echo($_GET["id"]); ?>" name="id" />
	<a href="seances.php" ><input type="button" value=" Retour à la liste " /></a>
	</form>
	</article>
	</body>
</html>