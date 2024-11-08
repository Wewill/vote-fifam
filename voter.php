<?php
include('BdD.php');
if ($_SESSION['qui']!=0) {header('location:vote.php');} 
else
{
$men=5;
if (isset($_SESSION['code']))
	{
	$film=0;
	$qui=0;
	$vrf=explode('-',$_SESSION['code']);
	$rep=$cbdd->query('SELECT * FROM tickets WHERE serie="'.$vrf[0].'" AND nno='.$vrf[1].' AND code="'.$vrf[2].'" AND val=1 ');
		while ($donnees = $rep->fetch())
		{
		$film=$donnees["film"];
		}
	$rep->closeCursor();
	$titre="";
	$rep=$cbdd->query('SELECT * FROM films WHERE id='.$film.' ');
		while ($donnees = $rep->fetch())
		{
		$idf=$donnees["nom"];
		$titre=$donnees["nom"];
		}
	$rep->closeCursor();
	if ($film==0) 
		{
		$rep=$cbdd->query('SELECT qui,note FROM votes WHERE cde="'.$vrf[2].'" ');
		while ($donnees = $rep->fetch())
			{
			$qui=$donnees['qui'];
			$note=''.$donnees['note'].' / 5';
			}
		$rep->closeCursor();
		$rep=$cbdd->query('SELECT nm,pre FROM pub WHERE id='.$qui.' ');
		while ($donnees = $rep->fetch())
			{
			$nom=decrypt($donnees["pre"],$clef).' '.decrypt($donnees["nm"],$clef);
			}
		$rep->closeCursor();/**/
		unset($_SESSION['code']);
		$_SESSION['err']="Ticket déjà utilisé par<br/>".$nom."<br/>".$note.'';
		header('location:err.php');
		}
	}
else
	{
	header('location:resultats.php');
	}
}
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="style/style.css?s=<?php echo(rand()); ?>" />
		<link rel="icon" href="img/logo.svg" />
		<meta name="viewport" content="initial-scale=1.0">
		<title>Vote du public — FIFAM | Festival International du Film d'Amiens</title>
	</head>
	<body>
<?php include('header.php'); ?>
	<article>
<br/>
Un vote pour<br/>"<?php echo($titre); ?>"
<br/><br/>
<form method="post" action="vvoter.php" >
<span class="frm" >
<table>
<tr><th><br/>Prénom</th></tr>
<tr><td>
<input type="text" placeholder="Prénom" name="pre" value="" required />
</td></tr>
<tr><th><br/>Nom</th></tr>
<tr><td>
<input type="text" placeholder="Nom" name="nom" value="" required />
</td></tr>
<tr><th><br/>Contact</th></tr>
<tr><td>
<input type="text" placeholder="e-mail ou tel." name="ctc" value="" required />
</td></tr>
<tr><th><br/>Note sur 5</th></tr>
<tr><td>
<input type="radio" id="n1" name="vte" value="1" /><label for="n1" class="rdio" >1</label>
<input type="radio" id="n2" name="vte" value="2" /><label for="n2" class="rdio" >2</label>
<input type="radio" id="n3" name="vte" value="3" checked /><label for="n3" class="rdio" >3</label>
<input type="radio" id="n4" name="vte" value="4" /><label for="n4" class="rdio" >4</label>
<input type="radio" id="n5" name="vte" value="5" /><label for="n5" class="rdio" >5</label>	
</td></tr>
<tr><th><input type="submit" value=" Valider " /></th></tr>
</table>
</span>
</form>
	</article>
	</body>
</html>