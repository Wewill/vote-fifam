<?
include('BdD.php');
if ($_GET['OK']=="OK") 
{
$rep=$cbdd->query('SELECT * FROM pub ');
	while ($donnees = $rep->fetch())
	{
		echo($donnees['id'].".".decrypt($donnees['eml'], $clef)." / ".decrypt($donnees['nm'], $clef)." / ".decrypt($donnees['pre'], $clef)."</br>");
	}
}
else
{
header('Location:index.php');
}
?>