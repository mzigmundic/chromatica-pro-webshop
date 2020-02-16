<?php

$nkupit = $db->query("SELECT * FROM kategorije WHERE nadkategorija = 0");

if ($kosarica_id != '') {
	$kosarica = mysqli_fetch_assoc($db->query("SELECT * FROM kosarice WHERE id = '$kosarica_id'"));
	$artikli = json_decode($kosarica['artikli'], true);
	$broj_artikala = 0;

	foreach ($artikli as $artikl) {
		$broj_artikala += $artikl['kolicina'];
}
}
?>

<nav class="navbar navbar-inverse navbar-fixed-top" style="border: 0">
	<div class="container">
		<a href="index.php" class="navbar-brand">Naslovna</a>
		<ul class="nav navbar-nav">
			<?php while ($nadkategorija = mysqli_fetch_assoc($nkupit)) : ?>
				<?php
					$nadkategorija_id = $nadkategorija['id'];
					$sql2 = "SELECT * FROM kategorije WHERE nadkategorija = '$nadkategorija_id'";
					$pkupit = $db->query($sql2);
				?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $nadkategorija['kategorija']; ?><span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<?php while ($podkategorija = mysqli_fetch_assoc($pkupit)) : ?>
							<li><a href="kategorija.php?kat=<?=$podkategorija['id'];?>"><?php echo $podkategorija['kategorija'] ?></a></li>
						<?php endwhile; ?>
					</ul>
				</li>
			<?php endwhile; ?>
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li><a href="kosarica.php" class="kos-nav">
				<span class="glyphicon glyphicon-shopping-cart"></span>
				<span class="badge" style="margin-bottom: 10px;"><?=($kosarica_id != '') ? $broj_artikala : '';?></span>
				</a>
			</li>
		</ul>
		
	</div>
</nav>