<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/webshop/jezgra/init.php';
if (!prijavljen()) {
		prijava_greska_preusmjeri();
	}
include 'dijelovi/zaglavlje.php';
include 'dijelovi/navigacija.php';


// Ukloni proizvod
if (isset($_GET['ukloni'])) {
	$id = sanitiziraj($_GET['ukloni']);
	$db->query("DELETE FROM proizvodi WHERE id = '$id'");
	header('Location: proizvodi.php');
}


//  Dodaj novi ili uredi postojeci proizvod 
if (isset($_GET['dodaj']) || isset($_GET['uredi'])) {
	$markaUpit = $db->query("SELECT * FROM marke ORDER BY marka");
	$nadkategorijaUpit = $db->query("SELECT * FROM kategorije WHERE nadkategorija = 0 ORDER BY kategorija");

	$naziv_proizvoda = ((isset($_POST['naziv_proizvoda']) && $_POST['naziv_proizvoda'] != '') ? sanitiziraj($_POST['naziv_proizvoda']) : '');
	$marka = ((isset($_POST['marka']) && $_POST['marka'] != '') ? sanitiziraj($_POST['marka']) : '');
	$nadkategorija = ((isset($_POST['nadkategorija']) && $_POST['nadkategorija'] != '') ? sanitiziraj($_POST['nadkategorija']) : '');
	$kategorija = ((isset($_POST['podkategorija']) && $_POST['podkategorija'] != '') ? sanitiziraj($_POST['podkategorija']) : '');
	$cijena = ((isset($_POST['cijena']) && $_POST['cijena'] != '') ? sanitiziraj($_POST['cijena']) : '');
	$opis = ((isset($_POST['opis']) && $_POST['opis'] != '') ? sanitiziraj($_POST['opis']) : '');
	$karakteristike =  rtrim( ((isset($_POST['karakteristike']) && $_POST['karakteristike'] != '') ? sanitiziraj($_POST['karakteristike']) : ''), ',' );
	
	$spremljenaSlika = '';
	$putanjaSlike = '';
	if (isset($_GET['uredi'])) {
		$urediId = (int)$_GET['uredi'];
		$proizvod = mysqli_fetch_assoc($db->query("SELECT * FROM proizvodi WHERE id = '$urediId'"));
		if (isset($_GET['ukloni_sliku'])) {
			$imgi = (int)$_GET['imgi'] - 1;
			$slike = explode(',', $proizvod['slika']);
			$slikaUrl = $_SERVER['DOCUMENT_ROOT'] . $slike[$imgi];
			unlink($slikaUrl);
			unset($slike[$imgi]);
			$slikeString = implode(',', $slike);
			$db->query("UPDATE proizvodi SET slika = '$slikeString' WHERE id = '$urediId'");
			header('Location: proizvodi.php?uredi=' . $urediId);
		}
		$kategorija = ((isset($_POST['podkategorija']) && !empty($_POST['podkategorija']))? sanitiziraj($_POST['podkategorija']) : $proizvod['kategorija']);
		$naziv_proizvoda = ((isset($_POST['naziv_proizvoda']) && !empty($_POST['naziv_proizvoda']))? sanitiziraj($_POST['naziv_proizvoda']) : $proizvod['naziv_proizvoda']);
		$marka = ((isset($_POST['marka']) && !empty($_POST['marka']))? sanitiziraj($_POST['marka']) : $proizvod['marka']);
		$nadkategorijaRez = mysqli_fetch_assoc($db->query("SELECT * FROM kategorije WHERE id = '$kategorija'"));
		$nadkategorija = ((isset($_POST['nadkategorija']) && !empty($_POST['nadkategorija'])) ? sanitiziraj($_POST['nadkategorija']) : $nadkategorijaRez['nadkategorija']);
		$cijena = ((isset($_POST['cijena']) && !empty($_POST['cijena']))? sanitiziraj($_POST['cijena']) : $proizvod['cijena']);
		$opis = ((isset($_POST['opis']))? sanitiziraj($_POST['opis']) : $proizvod['opis']);
		$karakteristike = rtrim(((isset($_POST['karakteristike']) && !empty($_POST['karakteristike']))? sanitiziraj($_POST['karakteristike']) : $proizvod['karakteristike']), ',');
		$spremljenaSlika = (($proizvod['slika'] != '') ? $proizvod['slika'] : '');
		$putanjaSlike = $spremljenaSlika;
	}

	if (!empty($karakteristike)) {
			$karakteristikeString = sanitiziraj($karakteristike);
			$karakteristikeString = rtrim($karakteristikeString, ',');
			$karakteristikePolje = explode(',', $karakteristikeString);
			$vPolje = array();
			$kPolje = array();
			foreach ($karakteristikePolje as $ss) {
				$s = explode(':', $ss);
				$vPolje[] = $s[0];
				$kPolje[] = $s[1];
			}
		} else {
			$karakteristikePolje = array();
		}

	if ($_POST) {
		$greske = array();
		

		$required = array('naziv_proizvoda', 'marka', 'cijena', 'podkategorija', 'karakteristike');
		$dopusteneEkstenzije = array('png', 'jpg', 'jpeg', 'gif');
		$uploadPutanja = array();
		$tmpLokacija = array();

		foreach ($required as $polja) {
			if ($_POST[$polja] == '') {
				$greske[] = 'Sva polja s * su obavezna';
				break;
			}
		}

		$brojFotki = count($_FILES['fotka']['name']);
		if ($brojFotki > 0) {
			for ($i = 0; $i < $brojFotki; $i++) {
				$name = $_FILES['fotka']['name'][$i];
				$imePolje = explode('.', $name);
				$imeFajla = $imePolje[0];
				$ekstenzijaFajla = $imePolje[1];
				$mime = explode('/', $_FILES['fotka']['type'][$i]);
				$mimeTip = $mime[0];
				$mimeEkstenzija = $mime[1];
				$tmpLokacija[] = $_FILES['fotka']['tmp_name'][$i];
				$velicinaFajla = $_FILES['fotka']['size'][$i];
				$uploadIme = md5(microtime().$i).'.'.$ekstenzijaFajla;
				$uploadPutanja[] = BAZAURL.'slike/proizvodi/'.$uploadIme;
				if ($i != 0) {
					$putanjaSlike .= ',';
				}
				$putanjaSlike .= '/webshop/slike/proizvodi/'.$uploadIme;
				if ($mimeTip != 'image') {
					$greske[] = 'Tip podatka treba biti jpg, jpeg, gif, ili png';
				}
				if (!in_array($ekstenzijaFajla, $dopusteneEkstenzije)) {
					$greske[] = 'Slika nije u odgovarajucem formatu';
				}
				if ($velicinaFajla > 15000000) {
					$greske[] = 'Velicina mora biti manja od 15 megabajta';
				}
				if ($ekstenzijaFajla != $mimeEkstenzija && ($mimeTip == 'jpeg' && $ekstenzijaFajla != 'jpg')) {
					$greske[] = 'Tip podatka ne odgovara podatku';
				}
			}
		}
		if (!empty($greske)) {
			echo prikazi_greske($greske);
		} else {
			if ($brojFotki > 0) {
				for ($i=0; $i < $brojFotki; $i++) { 
					move_uploaded_file($tmpLokacija[$i], $uploadPutanja[$i]);
				}
			}
			$insertSql = "INSERT INTO proizvodi (`naziv_proizvoda`, `cijena`, `marka`, `kategorija`, `opis`, `karakteristike`, `slika`) VALUES ('$naziv_proizvoda', '$cijena', '$marka', '$kategorija', '$opis', '$karakteristike', '$putanjaSlike')";
			if (isset($_GET['uredi'])) {
				$insertSql = "UPDATE proizvodi SET naziv_proizvoda = '$naziv_proizvoda', cijena = '$cijena', marka = '$marka', kategorija = '$kategorija', karakteristike = '$karakteristike', slika = '$putanjaSlike', opis = '$opis' WHERE id = '$urediId'";
			}
			$db->query($insertSql);
			header('Location: proizvodi.php');
		}
	} 

?>

	<h2 class="text-center"><?=((isset($_GET['uredi']))?'Uredi ':'Dodaj novi ');?> proizvod</h2><hr>
	<form action="proizvodi.php?<?=((isset($_GET['uredi']))?'uredi='.$urediId:'dodaj=1');?>" method="POST" enctype="multipart/form-data">
		<div class="form-group col-md-3">
			<label for="naziv_proizvoda">Naziv Proizvoda*:</label>
			<input type="text" name="naziv_proizvoda" id="naziv_proizvoda" class="form-control" value="<?=$naziv_proizvoda;?>">
		</div>
		<div class="form-group col-md-3">
			<label for="marka">Marka:*</label>
			<select name="marka" id="marka" class="form-control">
				<option value="<?=(($marka == '')?'selected':'')?>"></option>
				<?php while ($mrk = mysqli_fetch_assoc($markaUpit)) : ?>
					<option value="<?=$mrk['id'];?>" <?=(($marka == $mrk['id'])?'selected':'');?>><?=$mrk['marka'];?></option>
				<?php endwhile; ?>
			</select>
		</div>
		<div class="form-group col-md-3">
			<label for="nadkategorija">Nadkategorija:*</label>
			<select name="nadkategorija" id="nadkategorija" class="form-control">
				<option value="<?=(($nadkategorija == '')?'selected':'');?>"></option>
				<?php while ($nk = mysqli_fetch_assoc($nadkategorijaUpit)) : ?>
					<option value="<?=$nk['id'];?>" <?=(($nadkategorija == $nk['id'])?'selected':'');?>><?=$nk['kategorija'];?></option>
				<?php endwhile; ?>
			</select>
		</div>
		<div class="form-group col-md-3">
			<label for="podkategorija">Podkategorija:*</label>
			<select name="podkategorija" id="podkategorija" class="form-control">
				
			</select>
		</div>
		<div class="form-group col-md-3">
			<label for="cijena">Cijena:*</label>
			<input type="text" name="cijena" id="cijena" class="form-control" value="<?=$cijena;?>">
		</div>
		<div class="form-group col-md-3">
			<label for="">Količine i Karakteristike:*</label>
			<button class="btn btn-default form-control" onclick="jQuery('#karakteristikeModal').modal('toggle'); return false;">Količine i Karakteristike</button>
		</div>

		<div class="form-group col-md-3">
			<label for="karakteristike">Pregled količina i karakteristika</label>
			<input type="text" name="karakteristike" id="karakteristike" class="form-control" value="<?=$karakteristike;?>" readonly>
		</div>

		<div class="form-group col-md-6">
			<?php if($spremljenaSlika != '') : ?>
				<?php 
					$imgi = 1;
					$slike = explode(',', $spremljenaSlika);
				?>
				<?php foreach ($slike as $slika) : ?>
					<div class="col-md-4 spremljena-slika">
						<img src="<?=$slika;?>" alt="spremljena_slika"><br>
						<a href="proizvodi.php?ukloni_sliku=1&uredi=<?=$urediId;?>&imgi=<?=$imgi;?>" class="text-danger">Ukloni sliku</a>
					</div>
				<?php 
					$imgi++;
					endforeach; ?>
			<?php else : ?>
				<label for="fotka">Slika proizvoda:</label>
				<input type="file" name="fotka[]" id="fotka" class="form-control" multiple>
			<?php endif; ?>
		</div>

		<div class="form-group col-md-6">
			<label for="opis">Opis:</label>
			<textarea name="opis" id="opis" class="form-control" rows="6"><?=$opis;?></textarea>
		</div>

		<div class="form-group pull-right">
			<a href="proizvodi.php" class="btn btn-default">Odustani</a>
			<input type="submit" value="<?=((isset($_GET['uredi']))?'Uredi ':'Dodaj ');?>proizvod" class="btn btn-success">
		</div>
		<div class="clearfix"></div>
	</form>

	<!-- Modal -->
	<div class="modal fade" id="karakteristikeModal" tabindex="-1" role="dialog" aria-labelledby="karakteristikeModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-naziv_proizvoda" id="karakteristikeModalLabel">Karakteristika i Količina</h4>
	      </div>
	      <div class="modal-body">
	      	<div class="container-fluid">
		        <?php for ($i = 1; $i <= 12; $i++) : ?>
					<div class="form-group col-md-4">
						<label for="karakteristika<?=$i;?>">Karakteristika</label>
						<input type="text" name="karakteristika<?=$i;?>" id="karakteristika<?=$i;?>" value="<?=((!empty($vPolje[$i-1]))?$vPolje[$i-1]:'');?>" class="form-control">
					</div>
					<div class="form-group col-md-2">
						<label for="kol<?=$i;?>">Količina</label>
						<input type="number" name="kol<?=$i;?>" id="kol<?=$i;?>" value="<?=((!empty($kPolje[$i-1]))?$kPolje[$i-1]:'');?>" min="0" class="form-control">
					</div>
		        <?php endfor; ?>
	        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Zatvori</button>
	        <button type="button" class="btn btn-primary" onclick="azurirajKarakteristike();jQuery('#karakteristikeModal').modal('toggle');return false;">Spremi</button>
	      </div>
	    </div>
	  </div>
	</div>

<?php		
	} else {

	$sql = "SELECT * FROM proizvodi";
	$prezs = $db->query($sql);
	if (isset($_GET['istaknuto'])) {
		$id = (int)$_GET['id'];
		$istaknuto = (int)$_GET['istaknuto'];
		$istaknutoSql = "UPDATE proizvodi SET istaknuto = '$istaknuto' WHERE id = '$id'";
		$db->query($istaknutoSql);
		header('Location: proizvodi.php');
	}
?>

<h2 class="text-center">Proizvodi</h2>
<a href="proizvodi.php?dodaj=1" class="btn btn-success pull-right" id="dodaj-proizvod-gumb">Dodaj Proizvod</a>
<hr>


<table class="table table-bordered table-condensed table-striped">
	<thead>
		<th></th>
		<th>Proizvod</th>
		<th>Marka</th>
		<th>Cijena</th>
		<th>Kategorija</th>
		<th>Istaknuto</th>
	</thead>
	<tbody>
		<?php while ($proizvod = mysqli_fetch_assoc($prezs)) : 
			$podkategorijaID = $proizvod['kategorija'];
			$katSql = "SELECT * FROM kategorije WHERE id = '$podkategorijaID'";
			$rez = $db->query($katSql);
			$podkategorija = mysqli_fetch_assoc($rez);
			$nadkategorijaID = $podkategorija['nadkategorija'];
			$pSql = "SELECT * FROM kategorije WHERE id = '$nadkategorijaID'";
			$prez = $db->query($pSql);
			$nadkategorija = mysqli_fetch_assoc($prez);
			$kategorija = $nadkategorija['kategorija'].' -> '.$podkategorija['kategorija'];

			$marka_id = $proizvod['marka'];
			$marka = mysqli_fetch_assoc($db->query("SELECT marka FROM marke WHERE id = '$marka_id'"));


		?>
			<tr>
				<td>
					<a href="proizvodi.php?uredi=<?=$proizvod['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
					<a href="proizvodi.php?ukloni=<?=$proizvod['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span></a>
				</td>
				<td>
					<?=$proizvod['naziv_proizvoda'];?>
				</td>
				<td><?=$marka['marka'];?></td>
				<td>
					<?=novac($proizvod['cijena']);?>
				</td>
				<td><?=$kategorija;?></td>
				<td>
					<a href="proizvodi.php?istaknuto=<?=(($proizvod['istaknuto'] == 0)?'1':'0');?>&id=<?=$proizvod['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-<?=(($proizvod['istaknuto'] == 1)?'minus':'plus');?>"></span></a>&nbsp <?=(($proizvod['istaknuto'] == 1)?'Ukloni iz istaknutih':'Istakni');?>
				</td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>




<?php } include 'dijelovi/podnozje.php'; ?>

<script>
	jQuery('document').ready(function() {
		opcijePodkategorije('<?=$kategorija;?>');
	});
</script>
