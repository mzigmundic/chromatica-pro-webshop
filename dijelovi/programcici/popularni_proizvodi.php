<h3 class="text-center">Popularni proizvodi</h3>
<?php 
	$popUpit = $db->query("SELECT * FROM kosarice WHERE placeno = 1 ORDER BY id DESC LIMIT 5");
	$rez = array();
	while ($row = mysqli_fetch_assoc($popUpit)) {
		$rez[] = $row;
	}
	$row_broj = $popUpit->num_rows;
	$koristeni_ids = array();
	for ($i=0; $i < $row_broj; $i++) { 
		$json_artikli = $rez[$i]['artikli'];
		$artikli = json_decode($json_artikli, true);
		foreach ($artikli as $artikl) {
			if (!in_array($artikl['id'], $koristeni_ids)) {
				$koristeni_ids[] = $artikl['id'];
			}
		}
	}
?>
<div id="popularni-proizvodi">
	<table class="table table-condensed">
		<?php foreach ($koristeni_ids as $id) : 
			$proizvod = mysqli_fetch_assoc($db->query("SELECT id, naziv_proizvoda FROM proizvodi WHERE id = '$id'"))
		?>
		<tr>
			<td>
				<?=substr($proizvod['naziv_proizvoda'], 0, 25) . ((strlen($proizvod['naziv_proizvoda']) > 25) ? '...' : '');?>
			</td>
			<td>
				<a class="text-primary popularni-link" onclick="detaljiSkocniProzor('<?=$id;?>')">Vidi</a>
			</td>
		</tr>


		<?php endforeach; ?>
	</table>

</div>