<?php
include('BdD.php');
if ($_SESSION["qui"]!=0) {header('Location:index.php');}
$_POST['vte']=preg_replace("/[^0-9]/","",$_POST['vte']);
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
	$cbdd->query('INSERT INTO pub (id,psd,mdp,eml,nm,pre,pht,act,vrf) VALUES(NULL,"","","'.encrypt(nty($_POST['ctc']),$clef).'","'.encrypt($_POST["nom"],$clef).'","'.encrypt($_POST['pre'],$clef).'","",0,3)');
	$rep=$cbdd->query('SHOW TABLE STATUS FROM fifam LIKE "pub" ');
	while ($donnees = $rep->fetch())
	{
	$last=$donnees['Auto_increment']-1;
	}
	$rep->closeCursor();
	$cbdd->exec('INSERT INTO votes (id,film,snc,tkt,qui,note,date,hr,cde) VALUES (NULL,'.$film.','.$snc.', '.$tkt.', '.$last.', '.$_POST['vte'].', "'.date("Y-m-d").'", "'.date("H:i:s").'", "'.$vrf[2].'" )');
	unset($_SESSION['code']);
	header('location:resultats.php');
	}
	}
?>