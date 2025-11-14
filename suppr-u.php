<?php
include('BdD.php');
if ($_SESSION["qui"]!=0) {header('Location:index.php');}
$_POST["id"]=preg_replace("/[^0-9]/","",$_POST["id"]);

// Vérifier qu'on ne supprime pas l'admin (id=0)
if ($_POST["id"]==0) {
	header('Location:utilisateurs.php');
	exit();
}

// Supprimer tous les votes de l'utilisateur
$cbdd->query('DELETE FROM votes WHERE qui='.$_POST["id"].' ');

// Supprimer l'utilisateur
$cbdd->query('DELETE FROM pub WHERE id='.$_POST["id"].' ');

header('Location:utilisateurs.php');
?>
