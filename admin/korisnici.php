<?php 
	require_once '../jezgra/init.php';
	if (!prijavljen()) {
		prijava_greska_preusmjeri();
	}
	if (!ima_ovlast('admin')) {
		ovlast_greska_preusmjeri('index.php');
	}
	include 'dijelovi/zaglavlje.php';
	include 'dijelovi/navigacija.php';

	if (isset($_GET['ukloni'])) {
		$ukloni_id = sanitiziraj($_GET['ukloni']);
		$db->query("DELETE FROM korisnici WHERE id = '$ukloni_id'");
		$_SESSION['uspjeh_poruka'] = 'Korisnik je obrisan iz baze';
		header('Location: korisnici.php');
	}

	if (isset($_GET['dodaj'])) {
		$ime = ((isset($_POST['ime'])) ? sanitiziraj($_POST['ime']) : '');
		$email = ((isset($_POST['email'])) ? sanitiziraj($_POST['email']) : '');
		$lozinka = ((isset($_POST['lozinka'])) ? sanitiziraj($_POST['lozinka']) : '');
		$potvrda = ((isset($_POST['potvrda'])) ? sanitiziraj($_POST['potvrda']) : '');
		$ovlasti = ((isset($_POST['ovlasti'])) ? sanitiziraj($_POST['ovlasti']) : '');
		$greske = array();

		if ($_POST) {
			$emailBroj = mysqli_num_rows($db->query("SELECT * FROM korisnici WHERE email = '$email'"));

			if ($emailBroj > 0) {
				$greske[] = 'Taj email već postoji';
			}

			$required = array('ime', 'email', 'lozinka', 'potvrda', 'ovlasti');
			foreach ($required as $p) {
				if (empty($_POST[$p])) {
					$greske[] = 'Morate ispuniti sva polja';
					break;
				}
			}

			if (strlen($lozinka) < 5) {
				$greske[] = 'Lozinka mora imati barem 5 znakova';
			}

			if ($lozinka != $potvrda) {
				$greske[] = 'Potvrda lozinke se ne podudara s lozinkom';
			}

			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$greske[] = 'Email nije valjan';
			}

			if (!empty($greske)) {
				echo prikazi_greske($greske);
			} else {
				// add user to database
				$hash = password_hash($lozinka, PASSWORD_DEFAULT);
				$db->query("INSERT INTO korisnici (puno_ime, email, lozinka, ovlasti) VALUES ('$ime', '$email', '$hash', '$ovlasti')");
				$_SESSION['uspjeh_poruka'] = 'Korisnik je dodan';
				header('Location: korisnici.php');

			}
		}
		?>
			<h2 class="text-center">Dodaj novog korisnika</h2>
			<hr>
			<form action="korisnici.php?dodaj=1" method="post">
				<div class="form-group col-md-6">
					<label for="ime">Puno Ime:</label>
					<input type="text" name="ime" id="ime" class="form-control" value="<?=$ime;?>">
				</div>
				<div class="form-group col-md-6">
					<label for="email">Email:</label>
					<input type="email" name="email" id="email" class="form-control" value="<?=$email;?>">
				</div>
				<div class="form-group col-md-6">
					<label for="lozinka">Lozinka:</label>
					<input type="password" name="lozinka" id="lozinka" class="form-control" value="<?=$lozinka;?>">
				</div>
				<div class="form-group col-md-6">
					<label for="potvrda">Potvrda lozinke:</label>
					<input type="password" name="potvrda" id="potvrda" class="form-control" value="<?=$potvrda;?>">
				</div>
				<div class="form-group col-md-6">
					<label for="ovlasti">Ovlasti:</label>
					<select name="ovlasti" class="form-control">
						<option value=""<?=(($ovlasti == '') ? ' selected' : '')?>></option>
						<option value="urednik"<?=(($ovlasti == 'urednik') ? ' selected' : '')?>>Urednik</option>
						<option value="admin,urednik"<?=(($ovlasti == 'admin,urednik') ? ' selected' : '')?>>Admin</option>
					</select>
				</div>
				<div class="form-group col-md-6 text-right" style="margin-top: 25px">
					<a href="korisnici.php" class="btn btn-default">Odustani</a>
					<input type="submit" value="Dodaj korisnika" class="btn btn-primary">
				</div>
			</form>
		<?php
	} else {

		$korisniciUpit = $db->query("SELECT * FROM korisnici ORDER BY puno_ime");
?>

<h2 class="text-center">Korisnici</h2>
<a href="korisnici.php?dodaj=1" class="btn btn-success btn btn-success pull-right" id="dodaj-proizvod-gumb">Dodaj novog korisnika</a>
<hr>

<table class="table table-bordered table-striped table-condensed">
	<thead>
		<th></th>
		<th>Ime</th>
		<th>Email</th>
		<th>Datum Pridruživanja</th>
		<th>Posljednja prijava</th>
		<th>Ovlasti</th>
	</thead>
	<tbody>
		<?php while ($korisnik = mysqli_fetch_assoc($korisniciUpit)) : ?>
			<tr>
				<td>
					<?php if ($korisnik['id'] != $podaci_korisnika['id']) : ?>
						<a href="korisnici.php?ukloni=<?=$korisnik['id']?>" class="btn btn-default btn-xs">
							<span class="glyphicon glyphicon-remove"></span>
						</a>
					<?php endif; ?>
				</td>
				<td><?=$korisnik['puno_ime'];?></td>
				<td><?=$korisnik['email'];?></td>
				<td><?=vrijeme($korisnik['datum_pridruzivanja']);?></td>
				<td><?=(($korisnik['posljednja_prijava'] == '0000-00-00 00:00:00') ? 'Nikad' : vrijeme($korisnik['posljednja_prijava']));?></td>
				<td><?=$korisnik['ovlasti'];?></td>
			</tr>
		<?php endwhile; ?>
	</tbody>
</table>

<?php } include 'dijelovi/podnozje.php'; ?>