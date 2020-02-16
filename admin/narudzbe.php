<?php 
	require_once '../jezgra/init.php';

	if (!prijavljen()) {
		header('Location: login.php');
	}

	include 'dijelovi/zaglavlje.php';
	include 'dijelovi/navigacija.php';

	// Isporuči narudžbu
	if (isset($_GET['isporuci']) && $_GET['isporuci'] == 1) {
		$kosarica_id = sanitiziraj((int)$_GET['kosarica_id']);
		$db->query("UPDATE kosarice SET isporuceno = 1 WHERE id = '$kosarica_id'");
		$_SESSION['uspjeh_poruka'] = "Narudžba je isporučena";
		header('Location: index.php');
	}


	$trans_id = sanitiziraj((int)$_GET['trans_id']);
	$trans = mysqli_fetch_assoc($db->query("SELECT * FROM transakcije WHERE id = '$trans_id'"));
	$kosarica_id = $trans['kosarica_id'];
	$kosarica = mysqli_fetch_assoc($db->query("SELECT * FROM kosarice WHERE id = '$kosarica_id'"));
	$artikli = json_decode($kosarica['artikli'],true);
	$idPolje = array();

	foreach ($artikli as $artikl) {
		$idPolje[] = $artikl['id'];
	}

	$ids = implode(',', $idPolje);
	$proizvodUpit = $db->query("
			SELECT p.id as 'id', p.naziv_proizvoda as 'naziv_proizvoda', p.marka as 'mid', k.id as 'kid', k.kategorija as 'podkategorija', n.kategorija as 'nadkategorija', m.marka as 'marka'
			FROM proizvodi p
			LEFT JOIN kategorije k ON p.kategorija = k.id
			LEFT JOIN kategorije n ON k.nadkategorija = n.id
			LEFT JOIN marke m on p.marka = m.id
			WHERE p.id IN ($ids)
		");
	while ($pr = mysqli_fetch_assoc($proizvodUpit)) {
		foreach ($artikli as $artikl) {
			if ($artikl['id'] == $pr['id']) {
				$x = $artikl;
				continue;
			}
		}
		$proizvodi[] = array_merge($x, $pr);
	}
?>

<h2 class="text-center">Naručeni Artikli</h2>
<table class="table table-condensed table-bordered table-striped">
	<thead>
		<th>Količina</th>
		<th>Naziv proizvoda</th>
		<th>Kategorija</th>
		<th>Karakteristika</th>
	</thead>
	<tbody>
		<?php foreach($proizvodi as $proizvod) : ?>
			<tr>
				<td><?=$proizvod['kolicina'];?></td>
				<td><?=$proizvod['naziv_proizvoda'] . ' - ' . $proizvod['marka'];?></td>
				<td><?=$proizvod['nadkategorija']. ' -> ' . $proizvod['podkategorija'];?></td>
				<td><?=$proizvod['karakteristika'];?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<h3 class="text-center">Detalji narudžbe</h3>
		<table class="table table-condensed table-striped table-bordered">
			<tbody class="text-center">
				<tr>
					<td>Glavnica</td>
					<td><?=novac($trans['ukupna_cijena']);?></td>
				</tr>
				<tr>
					<td>Porez</td>
					<td><?=novac($trans['porez']);?></td>
				</tr>
				<tr>
					<td>Ukupno</td>
					<td><?=novac($trans['ukupna_cijena_s_porezom']);?></td>
				</tr>
				<tr>
					<td>Vrijeme narudžbe</td>
					<td><?=vrijeme($trans['vrijeme_transakcije']);?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="col-md-6 col-md-offset-3">
		<h3 class="text-center">Adresa isporuke</h3>
		<address class="text-center">
			<?=$trans['puno_ime'];?><br>
			<?=$trans['ulica'] . ', ' . $trans['grad'];?><br>
			<?=$trans['posta'];?><br>
			<?=$trans['zupanija'];?><br>
			<?=$trans['drzava'];?>
		</address>
	</div>
</div>
<div class="col-md-6 col-md-offset-3">
	<div class="col-md-6">
		<a href="index.php" class="btn btn-large btn-default btn-block">Odustani</a>
	</div>
	<div class="col-md-6">
		<a href="narudzbe.php?isporuci=1&kosarica_id=<?=$kosarica_id;?>" class="btn btn-large btn-danger btn-block">Isporuči narudžbu</a>
	</div>
</div>



<?php include 'dijelovi/podnozje.php'; ?>