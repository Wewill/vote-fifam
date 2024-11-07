<?php 
include('BdD.php');
if ($_SESSION["qui"]!=0) {header('Location:index.php');}
$cbdd->query('UPDATE seances SET sal='.$_POST["sal"].', film='.$_POST["film"].', dte="'.$_POST["dte"].'", deb="'.$_POST["deb"].'" WHERE id='.$_POST["id"].' ');
header('Location:seances.php');
?>