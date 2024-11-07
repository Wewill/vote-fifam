<?php 
include('BdD.php');
if ($_SESSION["qui"]!=0) {header('Location:index.php');}
$cbdd->query('DELETE FROM films WHERE id='.$_POST["id"].' ');
header('Location:films.php');
?>