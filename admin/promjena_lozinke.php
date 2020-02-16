<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/webshop/jezgra/init.php';
if (!prijavljen()) {
	prijava_greska_preusmjeri();
}
include 'dijelovi/zaglavlje.php';


$hash = $podaci_korisnika['lozinka'];
$stara_lozinka = trim(((isset($_POST['stara_lozinka'])) ? sanitiziraj($_POST['stara_lozinka']) : ''));
$lozinka = trim(((isset($_POST['lozinka'])) ? sanitiziraj($_POST['lozinka']) : ''));
$potvrda = trim(((isset($_POST['potvrda'])) ? sanitiziraj($_POST['potvrda']) : ''));
$hash_novi = password_hash($lozinka, PASSWORD_DEFAULT);
$korisnik_id = $podaci_korisnika['id'];
$greske = array();


?>


<div id="login-forma">
	<div>
		<?php 
			if ($_POST) {
				// form validaton
				if (empty($_POST['stara_lozinka']) || empty($_POST['lozinka']) || empty($_POST['potvrda'])) {
					$greske[] = 'Morate unijeti sva polja';
				}


				if (strlen($lozinka) < 5) {
					$greske[] = 'Lozinka mora biti sadržavati barem 5 znakova';
				}

				// check if new password matches confirm
				if ($lozinka != $potvrda) {
					$greske[] = 'Potvrda lozinke se ne slaže s novom lozinkom';
				}


				if (!password_verify($stara_lozinka, $hash)) {
					$greske[] = 'Stara lozinka je neispravna';
				}

				// check for errors
				if (!empty($greske)) {
					echo prikazi_greske($greske);
				} else {
					// promjeni lozinku
					$db->query("UPDATE korisnici SET lozinka = $hash_novi WHERE id = '$korisnik_id'");
					$_SESSION['uspjeh_poruka'] = "Vaša lozinka je uspješno promjenjena";
					header('Location: index.php');
				}
			}

		?>

	</div>
	<h2 class="text-center">Promjeni Lozinku</h2>
	<hr>

	<form action="promjena_lozinke.php" method="post">
		<div class="form-group">
			<label for="stara_lozinka">Stara lozinka:</label>
			<input type="password" name="stara_lozinka" id="stara_lozinka" class="form-control" value="<?=$stara_lozinka;?>">
		</div>
		<div class="form-group">
			<label for="lozinka">Nova lozinka:</label>
			<input type="password" name="lozinka" id="lozinka" class="form-control" value="<?=$lozinka;?>">
		</div>
		<div class="form-group">
			<label for="potvrda">Potvrda nove lozinke:</label>
			<input type="password" name="potvrda" id="potvrda" class="form-control" value="<?=$potvrda;?>">
		</div>
		<div class="form-group">
			<a href="index.php" class="btn btn-default">Odustani</a>
			<input type="submit" value="Potvrdi" class="btn btn-primary">
		</div>
	</form>
	<p class="text-right"><a href="/webshop/index.php" alt="home">Posjeti Stranicu</a></p>
</div>


<?php include 'dijelovi/podnozje.php'; ?>