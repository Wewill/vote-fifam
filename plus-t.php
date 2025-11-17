<?php 
include('BdD.php');
if ($_SESSION["qui"]!=0) {header('Location:index.php');}
include("../phpqrcode/qrlib.php");
$_GET['s']=preg_replace("/[^0-9]/","",$_GET['s']);
// Récupérer le nombre de tickets à générer (par défaut 12)
$nb_tickets = isset($_GET['n']) ? intval($_GET['n']) : 12;
// Valider que c'est une valeur autorisée
if (!in_array($nb_tickets, [4, 12, 180, 252, 300])) {
	$nb_tickets = 12;
}
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
	// Vérifier si la ligne compteur existe (identifiée par serie='', nno=0, code='', snc=0)
	$rep=$cbdd->query('SELECT COUNT(*) as cnt FROM tickets WHERE serie="" AND nno=0 AND code="" AND snc=0');
	$count = $rep->fetch();
	if ($count['cnt'] == 0) {
		// Initialiser le compteur de séries (commence à AA)
		$cbdd->exec('INSERT INTO tickets (serie, nno, code, film, snc, val) VALUES ("", 0, "", 0, 0, 64)');
	}
	$rep->closeCursor();

	$rep=$cbdd->query('SELECT id, film, val FROM tickets WHERE serie="" AND nno=0 AND code="" AND snc=0 LIMIT 1');
		while ($donnees = $rep->fetch())
		{
		$counter_id=$donnees["id"];
		$c1=$donnees["film"];
		$c2=$donnees["val"];
		$c2++;
		if ($c2==91) {$c2=65;$c1++;}
		$film=''.chr($c1+65).chr($c2).''; // +65
 		}
	$rep->closeCursor();
	$cbdd->query('UPDATE tickets SET film='.$c1.', val='.$c2.' WHERE id='.$counter_id);
	}
for ($x=0;$x<$nb_tickets;$x++) 
	{
	//die(var_dump($film));
	$code=substr(str_shuffle("abcdefghijkmnopqrstuvwxyz123456789ABCDEFGHJKLMNPQRSTUVWXYZ"),0,6);
	$nume=substr('000'.($nno+$x).'',-4);
	QRcode::png('https://vote.fifam.fr?n='.$film.'-'.$nume.'-'.$code.'','qr/'.$film.'-'.$nume.'.png','H',5,4);
	$cbdd->exec('INSERT INTO tickets (id, serie, nno, code, film, snc, val) VALUES (NULL,"'.$film.'", '.($nno+$x).', "'.$code.'", '.$f.','.$_GET['s'].', 1 )');
	}
header('Location:pdf-b.php?id='.$_GET['s'].'');
?>
