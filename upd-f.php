<?php 
include('BdD.php');
if ($_SESSION["qui"]!=0) {header('Location:index.php');}
$cbdd->query('UPDATE films SET nom="'.$_POST["nom"].'", ral="'.$_POST["nreal"].'", ann='.$_POST["ann"].' WHERE id='.$_POST["id"].' ');
header('Location:films.php');
?>
