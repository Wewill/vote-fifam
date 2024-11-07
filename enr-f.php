<?php 
include('BdD.php');
if ($_SESSION["qui"]!=0) {header('Location:index.php');}
$cbdd->exec('INSERT INTO films (id, nom, ral, ann, ref) VALUES (NULL,"'.nty($_POST["nom"]).'", "'.nty($_POST["nreal"]).'", '.preg_replace("/[^0-9]/","",$_POST["ann"]).', "" )');
header('Location:films.php');
?>
