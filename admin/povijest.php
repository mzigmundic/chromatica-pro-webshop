<?php 
	require_once '../jezgra/init.php';
	if (!prijavljen()) {
		header('Location: prijava.php');
	}
	include 'dijelovi/zaglavlje.php';
	include 'dijelovi/navigacija.php';
?>

	<?php 
		$trenutnaGod = date("Y");
		$proslaGod = $trenutnaGod - 1;
		$trenutnaGodUpit = $db->query("SELECT ukupna_cijena_s_porezom, vrijeme_transakcije FROM transakcije WHERE YEAR(vrijeme_transakcije) = '$trenutnaGod'");
		$proslaGodUpit = $db->query("SELECT ukupna_cijena_s_porezom, vrijeme_transakcije FROM transakcije WHERE YEAR(vrijeme_transakcije) = '$proslaGod'");
		$trenutna = array();
		$prosla = array();
		$trenutnaTotal = 0;
		$proslaTotal = 0;

		while ($x = mysqli_fetch_assoc($trenutnaGodUpit)) {
			$mjesec = (int)date("n", strtotime($x['vrijeme_transakcije']));
			if (!array_key_exists($mjesec, $trenutna)) {
				$trenutna[$mjesec] = $x['ukupna_cijena_s_porezom'];
			} else {
				$trenutna[$mjesec] += $x['ukupna_cijena_s_porezom'];
			}
			$trenutnaTotal += $x['ukupna_cijena_s_porezom'];
		}
		while ($y = mysqli_fetch_assoc($proslaGodUpit)) {
			$mjesec = date("n", strtotime($y['vrijeme_transakcije']));
			if (!array_key_exists($mjesec, $prosla)) {
				$prosla[(int)$mjesec] = $y['ukupna_cijena_s_porezom'];
			} else {
				$prosla[(int)$mjesec] += $y['ukupna_cijena_s_porezom'];
			}
			$proslaTotal += $y['ukupna_cijena_s_porezom'];
		}

	?>
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<h2 class="text-center">Prodaje po mjesecima</h2><hr>
		<table class="table table-condensed table-striped table-bordered">
			<thead>
				<th style="text-align: right;">Mjesec</th>
				<th style="text-align: right;"><?=$proslaGod;?></th>
				<th style="text-align: right;"><?=$trenutnaGod;?></th>
			</thead>
			<tbody class="text-right">
				<?php for ($i = 1; $i <= 12; $i++) : 
					$dt = DateTime::createFromFormat('!n', $i);
				?>
					<tr>
						<td><?=$dt->format("n") .'. mjesec';?></td>
						<td><?=(array_key_exists($i, $prosla)) ? novac($prosla[$i]) : novac(0);?></td>
						<td><?=(array_key_exists($i, $trenutna)) ? novac($trenutna[$i]) : novac(0);?></td>
					</tr>
				<?php endfor; ?>
				<tr>
					<td class="bg-success"><strong>Ukupno:</strong></td>
					<td class="bg-success"><strong><?=novac($proslaTotal);?></strong></td>
					<td class="bg-success"><strong><?=novac($trenutnaTotal);?></strong></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<?php include 'dijelovi/podnozje.php'; ?>