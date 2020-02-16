<?php
require_once 'jezgra/init.php';
include 'dijelovi/zaglavlje.php';
include 'dijelovi/navigacija.php';
include 'dijelovi/baner_dio.php';

if ($kosarica_id != '') {
	$kosarica = mysqli_fetch_assoc($db->query("SELECT * FROM kosarice WHERE id = '$kosarica_id'"));
	$artikli = json_decode($kosarica['artikli'], true);
	$i = 1;
	$ukupna_cijena_s_porezom = 0;
	$broj_artikala = 0;
}
?>

<div class="col-md-12">
	<div class="row">
		<h2 class="text-center">Košarica</h2>
		<hr>
		<?php if ($kosarica_id == '') : ?>
			<div class="bg-danger">
				<p class="text-center text-danger">
					Vaša košarica je prazna
				</p>
			</div>
		<?php else : ?>
			<table class="table table-bordered table-striped table-condensed text-center">
				<thead class="tablica-head">
					<th>#</th>
					<th>Artikl</th>
					<th>Cijena</th>
					<th>Količina</th>
					<th>Karakteristika</th>
					<th>Ukupno</th>
				</thead>
				<tbody>
					<?php 
						foreach ($artikli as $artikl) {
							$proizvod_id = $artikl['id'];
							$proizvod = mysqli_fetch_assoc($db->query("SELECT * FROM proizvodi WHERE id = '$proizvod_id'"));
							$karakteristika_polje = explode(',', $proizvod['karakteristike']);
							foreach ($karakteristika_polje as $karakteristikaString) {
								$v = explode(':', $karakteristikaString);
								if ($v[0] == $artikl['karakteristika']) {
									$dostupno = $v[1];
								}
							}
							?>
							<tr>
								<td><?=$i;?></td>
								<td><?=$proizvod['naziv_proizvoda'];?></td>
								<td><?=novac($proizvod['cijena']);?></td>
								<td>
									<button class="btn btn-xs btn-default" onclick="azurirajKosaricu('uklonijedan', '<?=$proizvod['id'];?>', '<?=$artikl['karakteristika'];?>')">-
									</button>
									<?=$artikl['kolicina'];?>
									<?php if ($artikl['kolicina'] < $dostupno) : ?>
										<button class="btn btn-xs btn-default" onclick="azurirajKosaricu('dodajjedan', '<?=$proizvod['id'];?>', '<?=$artikl['karakteristika'];?>')">+</button>
									<?php else : ?>
										<span class="text-danger">Maksimum</span>

									<?php endif; ?>
								</td>
								<td><?=$artikl['karakteristika'];?></td>
								<td><?=novac($artikl['kolicina'] * $proizvod['cijena']);?></td>
							</tr>
							<?php
							$i++;
							$broj_artikala += $artikl['kolicina'];
							$ukupna_cijena_s_porezom += ($proizvod['cijena'] * $artikl['kolicina']);
						}
						$ukupna_cijena = $ukupna_cijena_s_porezom - POREZNA_STOPA * $ukupna_cijena_s_porezom;
						$porez = $ukupna_cijena_s_porezom - $ukupna_cijena;
					?>
				</tbody>
			</table>
			<table class="table table-bordered table-condensed text-center">
				<legend>Ukupno</legend>
				<thead class="tablica-head">
					<th>Ukupno Artikla</th>
					<th>Glavnica</th>
					<th>Porez</th>
					<th>Ukupna Cijena</th>
				</thead>
				<tbody>
					<tr>
						<td><?=$broj_artikala;?></td>
						<td><?=novac($ukupna_cijena);?></td>
						<td><?=novac($porez);?></td>
						<td class="bg-success" style="font-weight: bold;"><?=novac($ukupna_cijena_s_porezom);?></td>
					</tr>
				</tbody>
			</table>

			<!-- Naplata -->
			<button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#naplataModal">
				<span class="glyphicon glyphicon-shopping-cart"></span>
			  Naplata >>
			</button>

			<!-- Modal -->
			<div class="modal fade" id="naplataModal" tabindex="-1" role="dialog" aria-labelledby="naplataModalLabel">
			  <div class="modal-dialog modal-lg" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="naplataModalLabel">Ardresa Isporuke</h4>
			      </div>
			      <div class="modal-body">
			      	<div class="row">
				        <form action="placanje.php" method="post" id="placanje-forma">
				        	<span class="bg-danger" id="placanje-greske"></span>
				        	<input type="hidden" name="porez" value="<?=$porez;?>">
				        	<input type="hidden" name="ukupna_cijena" value="<?=$ukupna_cijena;?>">
				        	<input type="hidden" name="ukupna_cijena_s_porezom" value="<?=$ukupna_cijena_s_porezom;?>">
				        	<input type="hidden" name="kosarica_id" value="<?=$kosarica_id;?>">
				        	<input type="hidden" name="opis" value="<?='Broj artikala: '.$broj_artikala;?>">
				        	<div id="korak1" style="display: block;">
				        		<div class="form-group col-md-6">
				        			<label for="puno_ime">Ime i Prezime:</label>
				        			<input type="text" class="form-control" id="puno_ime" name="puno_ime">
				        		</div>
				        		<div class="form-group col-md-6">
				        			<label for="email">Email:</label>
				        			<input type="email" class="form-control" id="email" name="email">
				        		</div>
				        		<div class="form-group col-md-6">
				        			<label for="ulica">Ulica i broj:</label>
				        			<input type="text" class="form-control" id="ulica" name="ulica">
				        		</div>
				        		<div class="form-group col-md-6">
				        			<label for="grad">Grad:</label>
				        			<input type="text" class="form-control" id="grad" name="grad">
				        		</div>
				        		<div class="form-group col-md-6">
				        			<label for="zupanija">Županija:</label>
				        			<input type="text" class="form-control" id="zupanija" name="zupanija">
				        		</div>
				        		<div class="form-group col-md-6">
				        			<label for="posta">Pošta:</label>
				        			<input type="text" class="form-control" id="posta" name="posta">
				        		</div>
				        		<div class="form-group col-md-6">
				        			<label for="drzava">Država:</label>
				        			<input type="text" class="form-control" id="drzava" name="drzava">
				        		</div>
				        	</div>
				        	<div id="korak2" style="display: none;">
				        		<div class="form-group col-md-6">
				        			<label for="broj">Broj kartice:</label>
				        			<input type="text" id="broj" class="form-control">
				        		</div>
				        		<div class="form-group col-md-6">
				        			<label for="skod">Sigurnosni Kod:</label>
				        			<input type="text" id="skod" class="form-control">
				        		</div>
				        	</div>
				        </form>
			        </div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Odustani</button>
			        <button type="button" class="btn btn-primary" onclick="provjeriAdresu();" id="gumb-nastavi">Nastavi >></button>
			        <button type="button" class="btn btn-primary" onclick="nazadNaAdresu();" id="gumb-nazad" style="display: none;"><< Nazad</button>
			        <button type="submit" form="placanje-forma" class="btn btn-primary" id="gumb-zavrsi" style="display: none;">Završi >></button>
			      </div>
			    </div>
			  </div>
			</div>
		<?php endif; ?>
	</div>
</div>

<script>

	function nazadNaAdresu() {
		jQuery('#placanje-greske').html("");
		jQuery('#korak1').css("display", "block");
		jQuery('#korak2').css("display", "none");
		jQuery('#gumb-nastavi').css("display", "inline-block");
		jQuery('#gumb-nazad').css("display", "none");
		jQuery('#gumb-zavrsi').css("display", "none");
		jQuery('#naplataModalLabel').html("Adresa Isporuke");
	}

	function provjeriAdresu() {
		var data = {
			'puno_ime' : jQuery('#puno_ime').val(),
			'email' : jQuery('#email').val(),
			'ulica' : jQuery('#ulica').val(),
			'grad' : jQuery('#grad').val(),
			'zupanija' : jQuery('#zupanija').val(),
			'posta' : jQuery('#posta').val(),
			'drzava' : jQuery('#drzava').val(),
		};
		jQuery.ajax({
			url : '/webshop/admin/parseri/provjeri_adresu.php',
			method : 'post',
			data : data,
			success : function(data) {
				if (data != 'valja') {
					jQuery('#placanje-greske').html(data);
				}
				if (data == 'valja') {
					jQuery('#placanje-greske').html("");
					jQuery('#korak1').css("display", "none");
					jQuery('#korak2').css("display", "block");
					jQuery('#gumb-nastavi').css("display", "none");
					jQuery('#gumb-nazad').css("display", "inline-block");
					jQuery('#gumb-zavrsi').css("display", "inline-block");
					jQuery('#naplataModalLabel').html("Unesite podatke kartice");
				}
			},
			error : function() {alert("Nešto nije u redu");},
		});
	}

</script>


<?php include 'dijelovi/podnozje.php'; ?>