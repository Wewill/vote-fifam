<?php
include('BdD.php');
if ($_SESSION["qui"]!=0) {header('Location:index.php');}
$men=3;
$salle='<select name="sal" >';
$rep=$cbdd->query('SELECT dta FROM site WHERE id=1 ');
		while ($donnees = $rep->fetch())
		{
		$dte=explode("|",$donnees["dta"]);
		}
	$rep->closeCursor();
$rep=$cbdd->query('SELECT * FROM salle ORDER BY cine, nom ');
		while ($donnees = $rep->fetch())
		{
		if ($donnees["id"]==$_GET["s"]) {$sel="selected ";} else {$sel="";}
		$salle.='<option value="'.$donnees["id"].'" '.$sel.'>'.$donnees["cine"].' ('.$donnees["nom"].')</option>';
		}
	$rep->closeCursor();
$salle.='</select>';
$film='<select name="film" >';
$rep=$cbdd->query('SELECT * FROM films ORDER BY nom, ann ');
		while ($donnees = $rep->fetch())
		{
		if ($donnees["id"]==$_GET["f"]) {$sel="selected ";} else {$sel="";}
		$film.='<option value="'.$donnees["id"].'" '.$sel.'>'.$donnees["nom"].'</option>';
		}
	$rep->closeCursor();
$film.='</select>';
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="style/style.css?s=<?php echo(rand()); ?>" />
		<link rel="icon" href="img/logo.svg" />
		<meta name="viewport" content="initial-scale=1.0">
		<title>Ajouter une séance — FIFAM | Festival International du Film d'Amiens</title>
	</head>
	<body>
<?php include('header.php'); ?>
	<article>
	<form method="post" action="enr-s.php" >
	<br/>
	<small class="muted">Attention ! Je suis sur le point d'ajouter une séance dans la liste.</small>
	<br/><br/>
	<table>
	<tr><th>Séance</th><th>Film</th></tr>
	<tr><td>Du <input type="date" value="<?php echo($dte[0]); ?>" name="dte" min="<?php echo($dte[0]); ?>" max="<?php echo($dte[1]); ?>" required /><br/>à <input type="time" value="" name="deb" required /></td><td><?php echo($film); ?><br/><?php echo($salle); ?></td></tr>
	</table>
	<br/>
	<input type="submit" value=" Ajouter " onclick="return confirm('Je confirme l\'ajout de cette séance.')" />
	<a href="seances.php" ><input type="button" value=" Retour à la liste " /></a>
	</form>
	</article>
	</body>
</html>