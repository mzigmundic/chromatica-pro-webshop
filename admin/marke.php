<?php 
	require_once '../jezgra/init.php';
	if (!prijavljen()) {
		prijava_greska_preusmjeri();
	}
	include 'dijelovi/zaglavlje.php';
	include 'dijelovi/navigacija.php';
?>

<?php
	// Dohvati marke iz baze
	$sql = "SELECT * FROM marke ORDER BY marka";
	$marke_rez = $db->query($sql);

	$greske = array();

	// Uredi marke
	if (isset($_GET['uredi']) && !empty($_GET['uredi']) ) {
		$uredi_id = sanitiziraj((int)$_GET['uredi']);
		$sql2 = "SELECT * FROM marke WHERE ID = '$uredi_id'";
		$uredi_rez = $db->query($sql2);
		$eMarka = mysqli_fetch_assoc($uredi_rez);
	}

	// Ukloni marke
	if (isset($_GET['ukloni']) && !empty($_GET['ukloni']) ) {
		$ukloni_id = sanitiziraj((int)$_GET['ukloni']);
		$sql = "DELETE FROM marke WHERE id = '$ukloni_id'";
		$db->query($sql);
		header('Location: marke.php');
	}

	// Ako je dodaj forma submitana
	if (isset($_POST['dodaj_submit'])) {
		$marka = sanitiziraj($_POST['marka']);
		// Provjeri jel marka prazna
		if ($_POST['marka'] == '') {
			$greske[] .= 'Morate unijeti marku';
		}

		// Provjeri jel marka vec postoji u bazi
		$sql = "SELECT * FROM marke WHERE marka = '$marka'";
		if (isset($_GET['uredi'])) {
			$sql = "SELECT * FROM marke WHERE marka = '$marka' AND id != '$uredi_id'";
		}
		$rez = $db->query($sql);
		$broj = mysqli_num_rows($rez);
		if ($broj > 0) {
			$greske[] .= $marka .' marka već postoji.';
		}

		// Prikazi greske
		if (!empty($greske)) {
			echo prikazi_greske($greske);
		} else {
			// Dodaj marku u bazu
			$sql = "INSERT INTO marke (marka) VALUES ('$marka')";
			if (isset($_GET['uredi'])) {
				$sql = "UPDATE marke SET marka = '$marka' WHERE id = '$uredi_id'";
			}
			$db->query($sql);
			header('Location: marke.php');

		}

	}

?>

<h2 class="text-center">Marke</h2>
<hr>

<div class="text-center">
	<form action="marke.php<?=(isset($_GET['uredi']) ? '?uredi=' .$uredi_id : '')?>" class="form-inline" method="POST">
		<div class="form-group">
			<?php 
				$marka_vrijednost = '';
				if (isset($_GET['uredi'])) {
					$marka_vrijednost = $eMarka['marka'];
				} else {
					if (isset($_POST['marka'])) {
						$marka_vrijednost = sanitiziraj($_POST['marka']);
					}
				} 
			?>
			<label for="marka"><?=(isset($_GET['uredi']) ? 'Uredi ' : 'Dodaj ')?>Marku:</label>
			<input type="text" name="marka" id="marka" class="form-control" value="<?=$marka_vrijednost?>">
			<?php if (isset($_GET['uredi'])) : ?>
				<a href="marke.php" class="btn btn-default">Odustani</a>
			<?php endif; ?>
			<input type="submit" name="dodaj_submit" value="<?=(isset($_GET['uredi']) ? 'Potvrdi promjene' : 'Dodaj ')?>" class="btn btn-success">
		</div>
	</form>
</div>
<hr>

<table class="table table-bordered table-striped table-condensed tablica-admin">
	<thead>
		<th></th>
		<th>Marka</th>
		<th></th>
	</thead>
	<tbody>
		<?php while ($marka = mysqli_fetch_assoc($marke_rez)) : ?>
			<tr>
				<td><a href="marke.php?uredi=<?= $marka['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a></td>
				<td><?= $marka['marka']; ?></td>
				<td><a href="marke.php?ukloni=<?= $marka['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span></a></td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>

<?php include 'dijelovi/podnozje.php'; ?>