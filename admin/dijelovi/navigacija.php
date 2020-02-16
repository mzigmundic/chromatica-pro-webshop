<?php 

$korisnici = mysqli_fetch_assoc($upit = $db->query("SELECT * FROM korisnici WHERE id = '$korisnik_id'"));
$brojNarudzbi = mysqli_fetch_row($db->query("SELECT COUNT(*) FROM kosarice WHERE placeno = 1 AND isporuceno = 0"));
$ovlasti = $korisnici['ovlasti'];
$hello = '';
if ($ovlasti == 'admin,urednik') {
	$hello = 'Admin';
}
if ($ovlasti == 'urednik') {
	$hello = 'Urednik';
}


?>


<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container">
		<ul class="nav navbar-nav">
			<li><a href="index.php">Narudžbe (<?=$brojNarudzbi[0];?>)</a></li>
			<li><a href="marke.php">Marke</a></li>
			<li><a href="kategorije.php">Kategorije</a></li>
			<li><a href="proizvodi.php">Proizvodi</a></li>
			<li><a href="povijest.php">Povijest</a></li>
			<?php if (ima_ovlast('admin')) : ?>
				<li><a href="korisnici.php">Korisnici</a></li>
			<?php endif; ?>
			
		</ul>
		<ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=$podaci_korisnika['ime'] . ' (' . $hello . ')';?>
					<span class="caret"></span>
				</a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="promjena_lozinke.php">Promjeni lozinku</a></li>
					<li><a href="odjava.php">Odjavi Me</a></li>
				</ul>
			</li>
		</ul>
	</div>
</nav>