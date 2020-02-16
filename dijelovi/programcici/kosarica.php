<h3 class="text-center">Košarica</h3>
<div>
	<?php if(empty($kosarica_id)) : ?>
		<p class="text-center">Vaša košarica je prazna</p>
	<?php else: 
		$kos = mysqli_fetch_assoc($db->query("SELECT * FROM kosarice WHERE id = '$kosarica_id'"));
		$artikli = json_decode($kos['artikli'], true);
		$ukupna_cijena = 0;
	?>

		<table class="table table-condensed" id="kosarica-programcic">
			<tbody>
				<?php foreach ((array)$artikli as $artikl) :
					$art_id = $artikl['id'];
					$proizvod = mysqli_fetch_assoc($db->query("SELECT * FROM proizvodi WHERE id = '$art_id'"));
				?>
					<tr>
						<td class="col-md-1"><?=$artikl['kolicina']. 'x';?></td>
						<td class="col-md-6"><?=substr($proizvod['naziv_proizvoda'], 0, 20) . ((strlen($proizvod['naziv_proizvoda']) > 20) ? '...' : '');?></td>
						<td class="col-md-5 text-right"><?=$artikl['kolicina'] * $proizvod['cijena'];?> kn</td>
					</tr>
				<?php 
					$ukupna_cijena += ($artikl['kolicina'] * $proizvod['cijena']);
					endforeach; ?>
					<tr>
						<td></td>
						<td>Ukupno</td>
						<td class="text-right"><?=$ukupna_cijena;?> kn</td>
					</tr>
			</tbody>
		</table>
		<div class="text-center">
			<a href="kosarica.php" class="btn btn-sm btn-primary">Vidi Košaricu</a>
		</div>
	<?php endif; ?><hr><br>
</div>