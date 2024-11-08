<?php
include('BdD.php');
if ($_SESSION['qui']==0) {header('location:voter.php');} 
else
{
$men=5;
if (isset($_SESSION['code']))
	{
	$film=0;
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
		$qui=$donnees["ral"];
		}
	$rep->closeCursor();
	if ($film==0) {unset($_SESSION['code']); $_SESSION['err']="Ticket déjà utilisé."; header('location:err.php');}
	}
	else
	{
	header('location:votes.php');
	}
$rep=$cbdd->query('SELECT id FROM votes WHERE qui='.$_SESSION['qui'].' AND film='.$film.' ');
	while ($donnees = $rep->fetch())
	{
	unset($_SESSION['code']);
	$_SESSION['err']="Film déjà noté.";
	header('location:err.php');
	}
$rep->closeCursor();
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
<b>Mon vote pour<br/>"<a href="https://www.fifam.fr/" target="_blank" style="color:blue;" ><?php echo($titre); ?></a>"</b>
<br/><i>de <?php echo($qui); ?></i>
<br/><br/>
	<a href="vvote.php?v=1" onclick="return confirm('Je confirme ma note de 1/5 ?')" ><img src="img/v1.png" class="vt" /></a>
	<a href="vvote.php?v=2" onclick="return confirm('Je confirme ma note de 2/5 ?')" ><img src="img/v2.png" class="vt" /></a>
	<a href="vvote.php?v=3" onclick="return confirm('Je confirme ma note de 3/5 ?')" ><img src="img/v3.png" class="vt" /></a>
	<a href="vvote.php?v=4" onclick="return confirm('Je confirme ma note de 4/5 ?')" ><img src="img/v4.png" class="vt" /></a>
	<a href="vvote.php?v=5" onclick="return confirm('Je confirme ma note de 5/5 ?')" ><img src="img/v5.png" class="vt" /></a>
<br/><br/>
Je selectionne ma note<br/>(5 étant la meilleure note)
	</article>
	</body>
</html>