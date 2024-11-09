<?php
include('BdD.php');
if ($_SESSION["qui"]!=0) {header('Location:index.php');}
$men=4;
$rep=$cbdd->query('SELECT * FROM films ');
	$film = [];
	while ($donnees = $rep->fetch())
	{
	$film[$donnees["id"]]='"'.$donnees["nom"].'"<br/>de '.$donnees["ral"].'<br/>('.$donnees["ann"].')';
	}
$rep->closeCursor();
$rep=$cbdd->query('SELECT * FROM votes ');
	$vote = [];
	while ($donnees = $rep->fetch())
	{
	$vote[$donnees["id"]]=[$donnees["film"],$donnees["note"]];
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
	<h2>Résultats des votes</h2>
	<br/>
	<table>
	<?php
	$k=0;
	if ( !empty($film) ) {
		foreach ($film as $keyf => $valuef)
			{
			echo('<tr id="lcl'.$keyf.'" ><td>'.$valuef.'</td>');
			$vt[$keyf]=0;$nb[$keyf]=0;
			foreach ($vote as $key => $value)
				{
				if ($value[0]==$keyf) {$vt[$keyf]+=$value[1];$nb[$keyf]++;}
				}
			if ($nb[$keyf]!=0) {echo('<td>'.number_format($vt[$keyf]/$nb[$keyf],2,',','').' / 5<br/>(avec '.$nb[$keyf].' votants)</td></tr>'."\n");if (($vt[$keyf]/$nb[$keyf])>$k) {$k=($vt[$keyf]/$nb[$keyf]);$tr=$keyf;}} else {echo('<td>Pas encore noté</td></tr>'."\n");}
			}
		} else {
			echo '<small>Il n\'y a pas de films.</small>';
		}
	?>
	</table>
	</article>
	<br/><br/>
	</body>
<script type="text/javascript" >
document.getElementById('lcl<?php echo($tr); ?>').style.backgroundColor="#DDFFDD";
</script>
</html>