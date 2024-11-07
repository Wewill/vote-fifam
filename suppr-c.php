<?php 
include('BdD.php');
if ($_SESSION["qui"]!=0) {header('Location:index.php');}
$cbdd->query('DELETE FROM salle WHERE id='.$_POST["id"].' ');
header('Location:salles.php');
?>