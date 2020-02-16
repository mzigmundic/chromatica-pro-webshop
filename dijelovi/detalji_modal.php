<?php require_once '../jezgra/init.php';


$id = (int)$_POST['id'];
$proizvod = mysqli_fetch_assoc($db->query("SELECT * FROM proizvodi WHERE id = '$id'"));

$marka_id = $proizvod['marka'];
$marka = mysqli_fetch_assoc($db->query("SELECT marka FROM marke WHERE id = '$marka_id'"));

$karakteristike_kolicine_string = rtrim($proizvod['karakteristike'], ',');
$karakteristike_kolicine = explode(',', $karakteristike_kolicine_string);

?>

<? ob_start(); ?>
<div class="modal fade details-1" id="detalji-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button class="close" type="button" onclick="zatvoriSkocniProzor()" aria-label="close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title text-center"><?= $proizvod['naziv_proizvoda']; ?></h4>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<div class="row">
						<span id="modal-greske" class="bg-danger"></span>
						<div class="col-sm-6 fotorama">
							<?php $fotke = explode(',', $proizvod['slika']);
							foreach ($fotke as $fotka) : ?>
								<img src="<?= $fotka; ?>" alt="<?= $proizvod['slika']; ?>" class="detalji img-responsive">
							<?php endforeach; ?>
						</div>
						<div class="col-sm-6">
							<h4>Detalji</h4>
							<p><?= nl2br($proizvod['opis']); ?></p>
							<hr>
							<p>Cijena: <?= novac($proizvod['cijena']); ?></p>
							<p>Marka: <?= $marka['marka']; ?></p>
							<form action="dodaj_u_kosaricu" method="POST" id="dodaj-proizvod-forma">
								<input type="hidden" name="proizvod_id" value="<?=$id;?>">
								<input type="hidden" name="dostupno" id="dostupno" value="">
								<div class="from-group">
									<label for="karakteristika">Karakteristika:</label>
									<select name="karakteristika" id="karakteristika" class="form-control">
										<option value=""></option>
											<?php foreach ($karakteristike_kolicine as $karakteristika_kolicina) {
												$vk_polje = explode(':', $karakteristika_kolicina);
												$karakteristika = $vk_polje[0];
												$dostupno = $vk_polje[1];
												if ($dostupno > 0) {
													echo '<option value="' . $karakteristika . '" data-dostupno="' . $dostupno .'">'. $karakteristika . ' (' . $dostupno . ' dostupno)</option>';
												}
											}
											?>
									</select>
								</div>
								<div class="form-group">
									<div>
										<label for="kolicina">Količina:</label>
										<input type="number" min="0" class="form-control" id="kolicina" name="kolicina">
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-defaut" onclick="zatvoriSkocniProzor()">Zatvori</button>
				<button class="btn btn-success" onclick="dodajUKosaricu(); return false;"><span class="glyphicon glyphicon-shopping-cart"></span> Dodaj u košaricu</button>
			</div>
		</div>
	</div>
</div>

<script>

	jQuery('#karakteristika').change(function() {
		var dostupno = jQuery('#karakteristika option:selected').data("dostupno");
		jQuery('#dostupno').val(dostupno);
	});

	$(function () {
		$('.fotorama').fotorama({
			'loop':true,
			'autoplay':true,
		});
	})

	function zatvoriSkocniProzor() {
		jQuery('#detalji-modal').modal('hide');
		setTimeout(function() {
			jQuery('#detalji-modal').remove();
			jQuery('.modal-backdrop').remove();
		}, 500);
	}
</script>

<?php echo ob_get_clean(); ?>