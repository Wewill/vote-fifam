<?php 
include('BdD.php');
if ($_SESSION["qui"]!=0) {header('Location:index.php');}
$cbdd->exec('INSERT INTO seances (id, sal, film, dte, deb) VALUES (NULL, '.nty($_POST["sal"]).', '.nty($_POST["film"]).', "'.$_POST["dte"].'", "'.$_POST["deb"].':00")');
header('Location:seances.php');
?>