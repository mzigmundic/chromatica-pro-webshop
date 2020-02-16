<?php 
	require_once 'jezgra/init.php';
	include 'dijelovi/zaglavlje.php';
	include 'dijelovi/navigacija.php';
	include 'dijelovi/baner_dio.php';
	include 'dijelovi/lijeva_traka.php';

	$sql = "SELECT * FROM proizvodi";
	$kat_id = (($_POST['kat'] != '') ? sanitiziraj($_POST['kat']) : '');
	if ($kat_id == '') {
		$sql .= " WHERE id != 0";
	} else {
		$sql .= " WHERE kategorija = '$kat_id'";
	}

	$cijena_sort = (($_POST['cijena_sort'] != '') ? sanitiziraj($_POST['cijena_sort']) : '');
	$min_cijena = (($_POST['min_cijena'] != '') ? sanitiziraj($_POST['min_cijena']) : '');
	$max_cijena = (($_POST['max_cijena'] != '') ? sanitiziraj($_POST['max_cijena']) : '');
	$marka = (($_POST['marka'] != '') ? sanitiziraj($_POST['marka']) : '');

	if ($min_cijena != '') {
		$sql .= " AND cijena >= '$min_cijena'";
	}
	if ($max_cijena != '') {
		$sql .= " AND cijena <= '$max_cijena'";
	}
	if ($marka != '') {
		$sql .= " AND marka = '$marka'";
	}
	if ($cijena_sort == 'niza') {
		$sql .= " ORDER BY cijena";
	}
	if ($cijena_sort == 'visa') {
		$sql .= " ORDER BY cijena DESC";
	}

	$proizvodUpit = $db->query($sql);
	$kategorija = dohvati_kategoriju($kat_id);
	$brojPr = mysqli_num_rows($proizvodUpit);
?>
	
<div class="col-md-8">
	<div class="row">
		<?php if ($kat_id != '') : ?>
			<h2 class="text-center"><?=$kategorija['nadkategorija'] . ' ' . $kategorija['podkategorija'];?></h2>
		<?php else : ?>
			<h2 class="text-center">Webshop</h2>
		<?php endif; ?>
		<?php while ($proizvod = mysqli_fetch_assoc($proizvodUpit)) :
			$marka_id = $proizvod['marka'];
			$marka = mysqli_fetch_assoc($db->query("SELECT marka FROM marke WHERE id = '$marka_id'"));
		?>
			<div class="col-md-4 text-center proizvod-thumb">
				<h4><?= $proizvod['naziv_proizvoda'] . ' - ' . $marka['marka']; ?></h4>
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