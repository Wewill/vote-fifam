<?php 
include('BdD.php');
if ($_SESSION["qui"]!=0) {header('Location:index.php');}
include("../phpqrcode/qrlib.php");
$_GET['s']=preg_replace("/[^0-9]/","",$_GET['s']);
$film='';
$rep=$cbdd->query('SELECT film FROM seances WHERE id='.$_GET['s'].'');
	while ($donnees = $rep->fetch())
	{
	$f=$donnees["film"];
	}
$rep->closeCursor();
$nno=0;
$rep=$cbdd->query('SELECT serie,nno FROM tickets WHERE film='.$f.' AND snc='.$_GET['s'].' ORDER BY nno ');
	while ($donnees = $rep->fetch())
	{
	$film=$donnees["serie"];
	$nno=$donnees["nno"];
	$nno++;
	}
$rep->closeCursor();
if ($film=='')
	{
	$rep=$cbdd->query('SELECT film,val FROM tickets WHERE id=0 ');
		while ($donnees = $rep->fetch())
		{
		$c1=$donnees["film"];
		$c2=$donnees["val"];
		$c2++;
		if ($c2==91) {$c2=65;$c1++;}
		$film=''.chr($c1+65).chr($c2).''; // +65
 		}
	$rep->closeCursor();
	$cbdd->query('UPDATE tickets SET film='.$c1.', val='.$c2.' WHERE id=0 ');
	}
for ($x=0;$x<12;$x++) 
	{
	//die(var_dump($film));
	$code=substr(str_shuffle("abcdefghijkmnopqrstuvwxyz123456789ABCDEFGHJKLMNPQRSTUVWXYZ"),0,6);
	$nume=substr('000'.($nno+$x).'',-4);
	QRcode::png('https://vote.fifam.fr?n='.$film.'-'.$nume.'-'.$code.'','qr/'.$film.'-'.$nume.'.png','H',5,4);
	$cbdd->exec('INSERT INTO tickets (id, serie, nno, code, film, snc, val) VALUES (NULL,"'.$film.'", '.($nno+$x).', "'.$code.'", '.$f.','.$_GET['s'].', 1 )');
	}
header('Location:pdf-b.php?id='.$_GET['s'].'');
?>
