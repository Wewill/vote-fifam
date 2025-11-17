<?php
include('BdD.php');
if ($_SESSION["qui"]!=0) {header('Location:index.php');}
$men=6;

// Statistiques globales
$stats = [];

// Nombre total d'utilisateurs
$rep = $cbdd->query('SELECT COUNT(*) as total FROM pub WHERE id!=0');
$stats['total'] = $rep->fetch()['total'];
$rep->closeCursor();

// Utilisateurs actifs (compte validé)
$rep = $cbdd->query('SELECT COUNT(*) as actifs FROM pub WHERE act=1 AND id!=0');
$stats['actifs'] = $rep->fetch()['actifs'];
$rep->closeCursor();

// Utilisateurs en attente de validation (lien email non cliqué)
$rep = $cbdd->query('SELECT COUNT(*) as attente FROM pub WHERE act=0 AND vrf!=0 AND id!=0');
$stats['attente'] = $rep->fetch()['attente'];
$rep->closeCursor();

// Utilisateurs ayant voté
$rep = $cbdd->query('SELECT COUNT(DISTINCT qui) as votants FROM votes WHERE qui!=0');
$stats['votants'] = $rep->fetch()['votants'];
$rep->closeCursor();

// Utilisateurs n'ayant pas encore voté (actifs mais sans vote)
$stats['non_votants'] = $stats['actifs'] - $stats['votants'];

// Nombre total de votes
$rep = $cbdd->query('SELECT COUNT(*) as total_votes FROM votes WHERE qui!=0');
$stats['total_votes'] = $rep->fetch()['total_votes'];
$rep->closeCursor();
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="style/style.css?s=<?php echo(rand()); ?>" />
		<link rel="icon" href="img/logo.svg" />
		<meta name="viewport" content="initial-scale=1.0">
		<title>Les utilisateurs — FIFAM | Festival International du Film d'Amiens</title>
	</head>
	<body>
	<?php include('header.php'); ?>
	<article>
	<h4>Liste des utilisateurs</h4>
	<?php if (isset($_SESSION['Message'])) {echo($_SESSION['Message']);unset($_SESSION['Message']);} ?>

	<div class="stats">
		<div class="stat-box">
			<div class="stat-label">Total utilisateurs</div>
			<div class="stat-number"><?php echo $stats['total']; ?></div>
		</div>
		<div class="stat-box actif">
			<div class="stat-label">Comptes validés</div>
			<div class="stat-number"><?php echo $stats['actifs']; ?></div>
		</div>
		<div class="stat-box attente">
			<div class="stat-label">En attente de validation</div>
			<div class="stat-number"><?php echo $stats['attente']; ?></div>
		</div>
		<div class="stat-box vote">
			<div class="stat-label">Ont voté</div>
			<div class="stat-number"><?php echo $stats['votants']; ?></div>
		</div>
		<div class="stat-box non-vote">
			<div class="stat-label">N'ont pas voté</div>
			<div class="stat-number"><?php echo $stats['non_votants']; ?></div>
		</div>
		<div class="stat-box vote">
			<div class="stat-label">Total de votes</div>
			<div class="stat-number"><?php echo $stats['total_votes']; ?></div>
		</div>
	</div>

	<br/>
	<table class="user">
	<tr>
		<th>Nom</th>
		<th>Prénom</th>
		<th>Email</th>
		<th>Statut</th>
		<th>A voté</th>
		<th>Nb votes</th>
		<th>Lien validé</th>
		<th colspan="3">&nbsp;</th>
	</tr><?php
$rep=$cbdd->query('SELECT p.id, p.nm, p.pre, p.eml, p.act, p.vrf,
					COUNT(DISTINCT v.id) as nb_votes
					FROM pub p
					LEFT JOIN votes v ON p.id = v.qui
					WHERE p.id != 0
					GROUP BY p.id
					ORDER BY p.id DESC');
		while ($donnees = $rep->fetch())
		{
		$nom = decrypt($donnees["nm"],$clef);
		$prenom = decrypt($donnees["pre"],$clef);
		$email = decrypt($donnees["eml"],$clef);

		// Statut du compte
		if ($donnees["act"] == 1) {
			$statut = '<span class="status-oui">Actif</span>';
		} else {
			$statut = '<span class="status-attente">Inactif</span>';
		}

		// A voté ?
		$a_vote = $donnees["nb_votes"] > 0 ? '<span class="status-oui">Oui</span>' : '<span class="status-non">Non</span>';
		$nb_votes = $donnees["nb_votes"];

		// Lien email validé ?
		if ($donnees["vrf"] == 0) {
			$lien_valide = '<span class="status-oui">Oui</span>';
		} else if ($donnees["vrf"] >= 100000 && $donnees["act"] == 1) {
			$lien_valide = '<span class="status-attente">Réinit. mdp</span>';
		} else if ($donnees["vrf"] >= 100000) {
			$lien_valide = '<span class="status-attente">En attente</span>';
		} else {
			$lien_valide = '<span class="status-non">Non</span>';
		}

		// Boutons d'action
		$btn_email = '<a href="renvoyer-email.php?id='.$donnees["id"].'" title="Renvoyer email" style="font-size: 130%; vertical-align: 0.2em;">&#9993;</a>';
		$btn_mdp = '<a href="reset-mdp.php?id='.$donnees["id"].'" title="Réinitialiser MDP">↩︎</a>';
		$btn_suppr = '<a href="moins-u.php?id='.$donnees["id"].'" title="Supprimer">&#9447;</a>';

		echo("\n\t".'<tr><td>'.$nom.'</td><td>'.$prenom.'</td><td>'.$email.'</td><td>'.$statut.'</td><td>'.$a_vote.'</td><td>'.$nb_votes.'</td><td>'.$lien_valide.'</td><td class="fin" >'.$btn_email.'</td><td class="fin" >'.$btn_mdp.'</td><td class="fin" >'.$btn_suppr.'</td></tr>');
		}
	$rep->closeCursor();
?>
	</table>
	</article>
	<br/><br/>
	</body>
</html>
