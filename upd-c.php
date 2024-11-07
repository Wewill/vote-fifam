<?php 
include('BdD.php');
if ($_SESSION["qui"]!=0) {header('Location:index.php');}
$cbdd->query('UPDATE salle SET cine="'.$_POST["cine"].'", nom="'.$_POST["nom"].'" WHERE id='.$_POST["id"].' ');
header('Location:salles.php');
?>