<?php 
	require_once '../jezgra/init.php';
	if (!prijavljen()) {
		header('Location: prijava.php');
	}
	include 'dijelovi/zaglavlje.php';
	include 'dijelovi/navigacija.php';
?>

<?php
	$transUpit = "SELECT t.id, t.kosarica_id, t.puno_ime, t.opis, t.vrijeme_transakcije, t.ukupna_cijena_s_porezom, k.artikli, k.placeno, k.isporuceno FROM transakcije t
		LEFT JOIN kosarice k ON t.kosarica_id = k.id
		WHERE k.placeno = 1 AND k.isporuceno = 0
		ORDER BY t.vrijeme_transakcije";

	$transRez = $db->query($transUpit);

?>

<div class="col-md-12">
	<h2 class="text-center">Narudžbe za isporuku</h2><hr>
	<table class="table table-bordered table striped table-condensed">
		<thead>
			<th></th>
			<th>Ime</th>
			<th>Opis</th>
			<th>Ukupno</th>
			<th>Datum</th>
		</thead>
		<tbody>
			<?php while ($narudzba = mysqli_fetch_assoc($transRez)) : ?>
				<tr>
					<td class="text-center"><a href="narudzbe.php?trans_id=<?=$narudzba['id'];?>" class="btn btn-xs btn-info">Detalji</a></td>
					<td><?=$narudzba['puno_ime'];?></td>
					<td><?=$narudzba['opis'];?></td>
					<td><?=novac($narudzba['ukupna_cijena_s_porezom']);?></td>
					<td><?=vrijeme($narudzba['vrijeme_transakcije']);?></td>
				</tr>
			<?php endwhile; ?>
		</tbody>
	</table>
</div>






<?php include 'dijelovi/podnozje.php'; ?>