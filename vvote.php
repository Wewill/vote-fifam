<?php
include('BdD.php');
$_GET['v']=preg_replace("/[^0-9]/","",$_GET['v']);
if (isset($_SESSION['code']))
	{
	$film=0;
	$vrf=explode('-',$_SESSION['code']);
	$rep=$cbdd->query('SELECT * FROM tickets WHERE serie="'.$vrf[0].'" AND nno='.$vrf[1].' AND code="'.$vrf[2].'" ');
		while ($donnees = $rep->fetch())
		{
		$tkt=$donnees["id"];
		$film=$donnees["film"];
		$snc=$donnees["snc"];
		}
	$rep->closeCursor();
	if ($film==0) {unset($_SESSION['code']);header('location:err.php');}
	else
	{
	$cbdd->query('UPDATE tickets SET val=2 WHERE id='.$tkt.' ');
	$cbdd->exec('INSERT INTO votes (id,film,snc,tkt,qui,note,date,hr,cde) VALUES (NULL,'.$film.','.$snc.', '.$tkt.', '.$_SESSION["qui"].', '.$_GET['v'].', "'.date("Y-m-d").'", "'.date("H:i:s").'", "'.$vrf[2].'" )');
	unset($_SESSION['code']);
	header('location:votes.php');
	}
	}
?>