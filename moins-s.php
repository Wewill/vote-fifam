<?php
include('BdD.php');
if ($_SESSION["qui"]!=0) {header('Location:index.php');}
$men=3;
$_GET['id']=preg_replace("/[^0-9]/","",$_GET['id']);
$rep=$cbdd->query('SELECT id FROM votes WHERE snc='.$_GET["id"].' ');
	while ($donnees = $rep->fetch())
	{
	$alrt="disabled";
	}
$rep->closeCursor();
$rep=$cbdd->query('SELECT * FROM salle');
		while ($donnees = $rep->fetch())
		{
		$salle[$donnees["id"]]=''.$donnees["cine"].'<br/>('.$donnees["nom"].')';
		}
	$rep->closeCursor();
$rep=$cbdd->query('SELECT * FROM films ');
		while ($donnees = $rep->fetch())
		{
		$film[$donnees["id"]]='"'.$donnees["nom"].'"<br/>de '.$donnees["real"].'<br/>('.$donnees["ann"].')';
		}
	$rep->closeCursor();?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="style/style.css?s=<?php echo(rand()); ?>" />
		<link rel="icon" href="img/logo.svg" />
		<meta name="viewport" content="initial-scale=1.0">
		<title>Supprimer une séance — FIFAM | Festival International du Film d'Amiens</title>
	</head>
	<body>
<?php include('header.php'); ?>
	<article>
	<form method="post" action="suppr-s.php" >
	<br/>
	<small class="muted">Attention ! Je suis sur le point de supprimer cette séance de la liste.</small>
	<br/><br/>
	<table>
	<tr><th>Date</th><th>Séance</th><th>Film</th><th>Cinéma</th></tr>
<?php 
$rep=$cbdd->query('SELECT * FROM seances WHERE id='.$_GET["id"].' ');
		while ($donnees = $rep->fetch())
		{
		echo('<tr><td>'.strftime("%A<br/>%d<br/>%B", strtotime($donnees["dte"])).'</td><td>'.strftime("%kh%M", strtotime($donnees["deb"])).'<br/>&#128499;</td><td>'.$film[$donnees["film"]].'</td><td>'.$salle[$donnees["sal"]].'</td></tr>');
		}
	$rep->closeCursor();
?>
	</table>
	<br/>
	<input type="hidden" value="<?php echo($_GET["id"]); ?>" name="id" />
	<input type="submit" value=" Supprimer " onclick="return confirm('Je confirme la suppression définitive de cette séance.')" <?php echo($alrt); ?>/>
	<a href="seances.php" ><input type="button" value=" Retour à la liste " /></a>
	</form>
	</article>
	</body>
</html>