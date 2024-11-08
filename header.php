	<header id="hc">
	<?php $clr[$men]='class="current"'; $cl[$men]='style="filter:grayscale(0);"'; $cp[$men]='filter:grayscale(0);'; ?>
	&nbsp;
	<a href="index.php" class="icons home" <?php echo($cl[0]); ?>><i class="icon icon-premiere-2"></i></a><?php if ($_SESSION["qui"]=="0") {echo('&nbsp;|&nbsp;<a href="films.php" '.$clr[1].'>Films</a>&nbsp;|&nbsp;<a href="salles.php" '.$clr[2].'>Salles</a>&nbsp;|&nbsp;<a href="seances.php" '.$clr[3].'>Séances</a>&nbsp;|&nbsp;<a href="resultats.php" '.$clr[4].'>Votes</a>');} else if (isset($_SESSION["qui"])) {echo('&nbsp;|&nbsp;<a href="votes.php" '.$clr[5].'>Votes</a>');}?>
	&nbsp;|&nbsp;
	<a href="coin.php" class="icons home" style="<?php echo($cp[10]); ?>" ><i class="icon icon-guest"></i></a>
	</header>