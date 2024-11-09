<?php
include('BdD.php');
$men=5;
$rep=$cbdd->query('SELECT * FROM films ');
	$film = [];
	while ($donnees = $rep->fetch())
	{
	$film[$donnees["id"]]='"'.$donnees["nom"].'"<br/>de '.$donnees["ral"].'<br/>('.$donnees["ann"].')';
	}
$rep->closeCursor();
$rep=$cbdd->query('SELECT * FROM votes WHERE qui='.$_SESSION["qui"].' ');
	$vote = [];
	while ($donnees = $rep->fetch())
	{
	$vote[$donnees["id"]]=[$donnees["film"],$donnees["note"],$donnees["cde"]];
	$code[$donnees["id"]]=$donnees["cde"];
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
		<title>Résultats des votes — FIFAM | Festival International du Film d'Amiens</title>
	</head>
	<body>
<?php include('header.php'); ?>
	<article>
	<h2>Mes votes</h2>
	<table>
	<?php
	if ( !empty($film) ) {
		foreach ($film as $keyf => $valuef)
			{
			echo('<tr><td>'.$valuef.'</td>');
			$vt[$keyf]=0;$nb=0;
			foreach ($vote as $key => $value)
				{
				if ($value[0]==$keyf) {$vt[$keyf]+=$value[1];$cd[$keyf]=$value[2];$nb=1;}
				}
			if ($nb!=0) {echo('<td>'.$vt[$keyf].' / 5<br/>Ticket n° :<br/>'.$cd[$keyf].'</td></tr>'."\n");} else {echo('<td>Je n\'ai pas voté</td></tr>'."\n");}
			}
		} else {
			echo '<small>Il n\'y a pas de films.</small>';
		}
	?>
	</table>
	</article>
	<br/><br/>
	</body>
</html>