<?php
include('BdD.php');
if ($_SESSION["qui"]!=0) {header('Location:index.php');}
$men=4;
$rep=$cbdd->query('SELECT * FROM films ');
	while ($donnees = $rep->fetch())
	{
	$film[$donnees["id"]]='"'.$donnees["nom"].'"<br/>de '.$donnees["ral"].'<br/>('.$donnees["ann"].')';
	}
$rep->closeCursor();
$rep=$cbdd->query('SELECT * FROM votes ');
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
		<title>Résultats des votes</title>
	</head>
	<body>
<?php include('header.php'); ?>
	<article>
<br/>
Résultats des votes
<br/><br/>
<table>
<?php
$k=0;
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
?>
	</table>
	</article>
	<br/><br/>
	</body>
<script type="text/javascript" >
document.getElementById('lcl<?php echo($tr); ?>').style.backgroundColor="#DDFFDD";
</script>
</html>