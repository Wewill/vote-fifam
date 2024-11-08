<?php
include('BdD.php');
if ($_SESSION["qui"]!=0) {header('Location:index.php');}
$men=3;
$_GET['s']=preg_replace("/[^0-9]/","",$_GET['s']);
$_GET['id']=preg_replace("/[^0-9]/","",$_GET['id']);
$_GET['f']=preg_replace("/[^0-9]/","",$_GET['f']);
$rep=$cbdd->query('SELECT id FROM votes WHERE snc='.$_GET["id"].' ');
	while ($donnees = $rep->fetch())
	{
	$alrt="disabled";
	}
$rep->closeCursor();
$salle='<select name="sal" >';
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
		<title>Supprimer une séance — FIFAM | Festival International du Film d'Amiens</title>
	</head>
	<body>
<?php include('header.php'); ?>
	<article>
	<form method="post" action="upd-s.php" >
	<br/>
	Attention !<br/>Je suis sur le point de<br/>modifier cette séance dans la liste.
	<br/><br/>
	<table>
	<tr><th>Séance</th><th>Film / Salle</th></tr>
<?php 
$rep=$cbdd->query('SELECT * FROM seances WHERE id='.$_GET["id"].' ');
		while ($donnees = $rep->fetch())
		{
		echo('<tr><td>Du <input type="date" value="'.$donnees["dte"].'" name="dte" /><br/>à <input type="time" value="'.$donnees["deb"].'" name="deb" /><td>'.$film.'<br/>'.$salle.'</td></tr>');
		}
	$rep->closeCursor();
?>
	</table>
	<br/>
	<input type="hidden" value="<?php echo($_GET["id"]); ?>" name="id" />
	<input type="submit" onclick="return confirm('Je confirme la modification de cette séance.')" value=" Modifier " <?php echo($alrt); ?>/>
	<a href="seances.php" ><input type="button" value=" Retour à la liste " /></a>
	</form>
	</article>
	</body>
</html>