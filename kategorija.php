<?php 
	require_once 'jezgra/init.php';
	include 'dijelovi/zaglavlje.php';
	include 'dijelovi/navigacija.php';
	include 'dijelovi/baner_dio.php';
	include 'dijelovi/lijeva_traka.php';

	if (isset($_GET['kat'])) {
		$kat_id = sanitiziraj($_GET['kat']);
	} else {
		$kat_id = '';
	}

	$proizvodiKategorije = $db->query("SELECT * FROM proizvodi WHERE kategorija = '$kat_id' ORDER BY id");
	$kategorija = dohvati_kategoriju($kat_id);
	$brojPr = mysqli_num_rows($proizvodiKategorije);
?>
	
<div class="col-md-8">
	<div class="row">
		<h2 class="text-center"><?=$kategorija['nadkategorija'] . ' ' . $kategorija['podkategorija'];?></h2>
		<?php while ($proizvod = mysqli_fetch_assoc($proizvodiKategorije)) : 
			$marka_id = $proizvod['marka'];
			$marka = mysqli_fetch_assoc($db->query("SELECT marka FROM marke WHERE id = '$marka_id'"));
		?>
			<div class="col-md-4 text-center proizvod-thumb">
				<h4><?= $proizvod['naziv_proizvoda'] . ' - ' . $marka['marka'];  ?></h4>
				<?php $fotke = explode(',', $proizvod['slika']) ?>
				<img src="<?= $fotke[0]; ?>" alt="<?= $proizvod['naziv_proizvoda']; ?>" class="slika-thumb">
				<p class="cijena">Cijena: <?= novac($proizvod['cijena']); ?></p>
				<button type="button" class="btn btn-small btn-info" onclick="detaljiSkocniProzor(<?= $proizvod['id']; ?>)">Više o proizvodu</button>
			</div>
		<?php endwhile; ?>
		<?php if ($brojPr == 0) : ?>
			<h5 class="text-center" style="margin-top: 80px;">Nema proizvoda</h5>
		<?php endif; ?>

	</div>
</div>

<?php
	include 'dijelovi/desna_traka.php';
	include 'dijelovi/podnozje.php';
?>