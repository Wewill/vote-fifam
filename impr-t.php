<?php
include('BdD.php');
if ($_SESSION["qui"]!=0) {header('Location:index.php');}
$_GET['s']=preg_replace("/[^0-9]/","",$_GET['s']);
$rep=$cbdd->query('SELECT * FROM seances WHERE id='.$_GET['s'].' ');
$donnees = $rep->fetch();
$film=$donnees["film"];
$rep->closeCursor();
$rep=$cbdd->query('SELECT * FROM films WHERE id='.$film.' ');
$donnees = $rep->fetch();
$nom=$donnees["nom"];
$ral=$donnees["ral"];
$ann=$donnees["ann"];
$rep->closeCursor();
require('../fpdf2/fpdf.php');
ob_get_clean();
$pdf = new FPDF('P', 'mm', array(210, 297));
$pdf->SetMargins(0, 0);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial','B',9.5);
$pdf->SetDrawColor(200,200,200);
$pdf->SetAutoPageBreak(false);
$tr=0;
$pls=0;
$rep=$cbdd->query('SELECT * FROM tickets WHERE snc="'.$_GET['s'].'" AND val=1 ORDER BY nno ');
	while ($donnees = $rep->fetch())
	{
	if ($tr%4==0) {$pdf->AddPage(); $tr=0; $pdf->Line( 105,0,105,10); $pdf->Line( 105,287,105,297);}
	if ($tr%2==0) {$pls=0;$pdf->Line( 0,floor(($tr+2)/2)*148.5,10,floor(($tr+2)/2)*148.5);} else {$pls=105;$pdf->Line(200,floor(($tr+2)/2)*148.5,210,floor(($tr+2)/2)*148.5);}

		$nume=substr('000'.$donnees["nno"].'',-4);
		$pdf->SetXY(59.5+$pls,(floor($tr/2)*148.5+10));
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(40,10,iconv('UTF-8', 'ISO-8859-1//TRANSLIT','Prix du public'),0,1,'C');
		$pdf->SetX(59.5+$pls);
		$pdf->SetFont('Arial','I',10);
		$pdf->Cell(40,7,iconv('UTF-8', 'ISO-8859-1//TRANSLIT','Vote numérique :'),0,1,'C');
		$pdf->SetXY(10+$pls,(floor($tr/2)*148.5+60));
		$pdf->SetFont('Arial','B',12);
		$pdf->Cell(85,5,''.iconv('UTF-8', 'ISO-8859-1//TRANSLIT',html_entity_decode($nom)).'',0,1,'C');
		$pdf->SetX(10+$pls);
		$pdf->SetFont('Arial','I',10);
		$pdf->Cell(85,5,'de '.iconv('UTF-8', 'ISO-8859-1//TRANSLIT',html_entity_decode($ral)).' ('.$ann.')',0,1,'C');
		$pdf->Image('qr/'.$donnees["serie"].'-'.$nume.'.png', 68+$pls, (floor($tr/2)*148.5+28), -250);
		$pdf->Image('img/liqrn.png', 74.5+$pls, (floor($tr/2)*148.5+34.5), -860);
		//$pdf->Image('img/t-lico.jpg', 10+$pls, (floor($tr/2)*148.5+8), -400);
		$pdf->Image('img/t-lico-'.(date("Y") - 1980).'.jpg', 10+$pls, (floor($tr/2)*148.5+8), -400); // ex: t-lico-44.jpg, t-lico-45.jpg ...
		for ($x=0;$x<5;$x++)
			{
			$pdf->Image('img/logolico.png', 16+$pls+($x*15), (floor($tr/2)*148.5+75-($x*0.85)), (-2400+($x*200)));
			}
		$pdf->SetTextColor(255, 255, 255);
		$pdf->SetXY(20+$pls,(floor($tr/2)*148.5+78));
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(85,5,'1            2             3            4             5',0,1,'L');
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetXY(10+$pls,(floor($tr/2)*148.5+87));
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(85,11,iconv('UTF-8', 'ISO-8859-1//TRANSLIT','Entourez votre note (5 étant la meilleure)'),0,1,'C');
		$pdf->SetFont('Arial','I',8);
		$pdf->SetX(10+$pls);
		$pdf->MultiCell(85, 4, iconv('UTF-8', 'ISO-8859-1//TRANSLIT',"Deux personnes seront tiré.e.s au sort et gagneront une carte Licorne pour la prochaine édition du Festival International du Film d'Amiens !"));
		$pdf->SetFont('Arial','B',10);
		$pdf->SetX(10+$pls);
		$pdf->Cell(85,7,'Nom : _____________________________________',0,1,'L');
		$pdf->SetX(10+$pls);
		$pdf->Cell(85,7,iconv('UTF-8', 'ISO-8859-1//TRANSLIT','Prénom : __________________________________'),0,1,'L');
		$pdf->SetX(10+$pls);
		$pdf->Cell(85,7,iconv('UTF-8', 'ISO-8859-1//TRANSLIT','Téléphone : ________________________________'),0,1,'L');
		$pdf->SetX(10+$pls);
		$pdf->Cell(85,7,iconv('UTF-8', 'ISO-8859-1//TRANSLIT','E-mail : ____________________________________'),0,1,'L');
	
		
		
	$tr++;
	}
$rep->closeCursor();
$pdf->Output('pdf/Tickets.pdf','F');
header('location:pdf/Tickets.pdf');
?>