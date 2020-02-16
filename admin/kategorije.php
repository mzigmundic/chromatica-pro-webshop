<?php 
	require_once '../jezgra/init.php';
	if (!prijavljen()) {
		prijava_greska_preusmjeri();
	}
	include 'dijelovi/zaglavlje.php';
	include 'dijelovi/navigacija.php';

	$sql = "SELECT * FROM kategorije WHERE nadkategorija = 0";
	$rez = $db->query($sql);
	$greske = array();
	$kategorija = '';
	$post_nadkategorija = '';

	// Edit Category
	if (isset($_GET['uredi']) && !empty($_GET['uredi'])) {
		$uredi_id = sanitiziraj((int)$_GET['uredi']);
		$uredi_sql = "SELECT * FROM kategorije WHERE id = '$uredi_id'";
		$uredi_rez = $db->query($uredi_sql);
		$uredi_kategoriju = mysqli_fetch_assoc($uredi_rez);
	}

	// Delete Category
	if (isset($_GET['ukloni']) && !empty($_GET['ukloni'])) {
		$ukloni_id = sanitiziraj((int)$_GET['ukloni']);
		$sql = "SELECT * FROM kategorije WHERE id = '$ukloni_id'";
		$rez = $db->query($sql);
		$kategorija = mysqli_fetch_assoc($rez);
		if ($kategorija['nadkategorija'] == 0) {
			$sql = "DELTE FROM kategorije WHRE nadkategorija = '$ukloni_id'";
			$db->query($sql);
		}
		$uksql = "DELETE FROM kategorije WHERE id = '$ukloni_id'";
		$db->query($uksql);
		header('Location: kategorije.php');
	}

	// Proces Form
	if (isset($_POST) && !empty($_POST)) {
		$post_nadkategorija = sanitiziraj($_POST['nadkategorija']);
		$kategorija = sanitiziraj($_POST['kategorija']);
		$sqlforma = "SELECT * FROM kategorije WHERE kategorija = '$kategorija' AND nadkategorija = '$post_nadkategorija'";
		if (isset($_GET['uredi'])) {
			$id = $uredi_kategoriju['id'];
			$sqlforma = "SELECT * FROM kategorije WHERE kategorija = '$kategorija' AND nadkategorija = '$post_nadkategorija'";
		}
		$frez = $db->query($sqlforma);
		$broj = mysqli_num_rows($frez);
		// id category is blank
		if ($kategorija == '') {
			$greske[] .= 'Kategorija ne može biti prazna';
		}

		// if exists in database
		if ($broj > 0) {
			$greske[] .= 'Kategorija ' . $kategorija . ' već postoji.';
		}

		// Display errors or update database
		if (!empty($greske)) {
			// display errors
			$display = prikazi_greske($greske); ?>
		<script>
			jQuery('document').ready(function(){
				jQuery('#greske').html('<?=$display;?>');
			});
		</script>

		<?php } else {
			// update database
			$azurirajsql = "INSERT INTO kategorije (kategorija, nadkategorija) VALUES ('$kategorija', '$post_nadkategorija')";
			if (isset($_GET['uredi'])) {
				$azurirajsql = "UPDATE kategorije SET kategorija = '$kategorija', nadkategorija = '$post_nadkategorija' WHERE id = 'uredi_id'";
			}
			$db->query($azurirajsql);
			header('Location: kategorije.php');
		}

	}

	$kategorija_vrijednost = '';
	$nadkategorija_vrijednost = 0;
	if (isset($_GET['uredi'])) {
		$kategorija_vrijednost = $uredi_kategoriju['kategorija'];
		$nadkategorija_vrijednost = $uredi_kategoriju['nadkategorija'];
	} else {
		if (isset($_POST)) {
			$kategorija_vrijednost = $kategorija;
			$nadkategorija_vrijednost = $post_nadkategorija;
		}
	}
?>

<h2 class="text-center">Kategorije</h2><hr>
<div class="row">
	<div class="col-md-6"><br>
		<div class="col-md-8 col-md-offset-2">
			<form action="kategorije.php<?= (isset($_GET['uredi']) ? '?uredi=' . $uredi_id: ''); ?>" method="POST" class="form">
				<legend><?=(isset($_GET['uredi']) ? 'Uredi ' : 'Dodaj ')?>kategoriju</legend>
				<div id="greske"></div>
				<div class="form-group">
					<label for="nadkategorija">Nadkategorija</label>
					<select name="nadkategorija" id="nadkategorija" class="form-control">
						<option value="0" <?=(($nadkategorija_vrijednost == 0) ? 'selected="selected"': '')?>>Nadkategorija</option>
						<?php while ($nadkategorija = mysqli_fetch_assoc($rez)): ?>
							<option value="<?=$nadkategorija['id']; ?>" <?=(($nadkategorija_vrijednost == $nadkategorija['id']) ? 'selected="selected"': '')?>><?=$nadkategorija['kategorija']?></option>
						<?php endwhile; ?>
					</select>
				</div>
				<div class="form-group">
					<label for="kategorija">Kategorija</label>
					<input type="text" class="form-control" name="kategorija" id="kategorija" value="<?=$kategorija_vrijednost;?>">
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-success" value="<?= (isset($_GET['uredi']) ? 'Uredi ' : 'Dodaj '); ?>kategoriju">
				</div>
			</form>
		</div>
	</div>


	<div class="col-md-6">
		<table class="table table-bordered">
			<thead>
				<th>Kategorija</th>
				<th>Nadkategorija</th>
				<th></th>
			</thead>
			<tbody>
				<?php 
					$sql = "SELECT * FROM kategorije WHERE nadkategorija = 0";
					$rez = $db->query($sql);
					while ($nadkategorija = mysqli_fetch_assoc($rez)) :
						$nadkategorija_id = (int)$nadkategorija['id'];
						$sql2 = "SELECT * FROM kategorije WHERE nadkategorija = '$nadkategorija_id'";
						$podrez = $db->query($sql2);
				?>
					<tr class="bg-primary">
						<td><?=$nadkategorija['kategorija']?></td>
						<td></td>
						<td>
							<a href="kategorije.php?uredi=<?=$nadkategorija['id']?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
							<a href="kategorije.php?ukloni=<?=$nadkategorija['id']?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span></a>
						</td>
					</tr>
					<?php while ($podkategorija = mysqli_fetch_assoc($podrez)) : ?>
						<tr class="bg-info">
							<td><?=$podkategorija['kategorija']?></td>
							<td><?=$nadkategorija['kategorija']?></td>
							<td>
								<a href="kategorije.php?uredi=<?=$podkategorija['id']?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
								<a href="kategorije.php?ukloni=<?=$podkategorija['id']?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span></a>
							</td>
						</tr>
					<?php endwhile; ?>
				<?php endwhile; ?>
			</tbody>
		</table>
	</div>
</div>

<?php include 'dijelovi/podnozje.php'; ?>