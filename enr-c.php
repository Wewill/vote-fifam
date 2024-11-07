<?php 
include('BdD.php');
if ($_SESSION["qui"]!=0) {header('Location:index.php');}
$cbdd->exec('INSERT INTO salle (id, cine, nom, num) VALUES (NULL, "'.nty($_POST["cine"]).'", "'.nty($_POST["nom"]).'", 0)');
header('Location:salles.php');
?>