<?php
include('BdD.php');
if ($_SESSION["qui"]!="") {header('Location:profil.php');}
$men=10;
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="style/style.css?s=<?php echo(rand()); ?>" />
		<link rel="icon" href="img/logo.svg" />
		<meta name="viewport" content="initial-scale=1.0">
		<title>Mot de passe oublié</title>
	</head>
	<body>
<?php include('header.php'); ?>
	<article>
	<span class="frm" >
	<form method="post" action="raz-mdp.php" >
	RAZ de mon mot de passe :
	<label for="em1"><br/>Adresse email</label><input type="email" placeholder="Adresse email" name="em1" id="em1" value="<?php echo($_SESSION['em']); ?>" required />
	<br/>
	<table>
	<tr><th>Initiale de<br/>mon prénom</th><th>Initiale de<br/>mon nom</th></tr>
	<tr><td>
<?php
$alf=str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ");
for ($x=0;$x<26;$x++) {if ($alf[$x]=="A") {$slc="checked ";} else {$slc="";}; echo('<input type="radio" id="p'.$x.'" name="inip" value="'.$alf[$x].'" '.$slc.'/><label for="p'.$x.'" class="rdio" >'.$alf[$x].'</label>');}
?>	
	</td><td>
<?php
$alf=str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ");
for ($x=0;$x<26;$x++) {if ($alf[$x]=="A") {$slc=" checked ";} else {$slc="";}; echo('<input type="radio" id="n'.$x.'" name="inin" value="'.$alf[$x].'" '.$slc.'/><label for="n'.$x.'" class="rdio" >'.$alf[$x].'</label>');}
?>	
	</td></tr>
	<table>
	<input type="submit" value=" Envoyer " />
	</form>
	</span>
	</article>
	</body>
</html>