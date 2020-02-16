<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/webshop/jezgra/init.php';
include 'dijelovi/zaglavlje.php';


$email = trim(((isset($_POST['email'])) ? sanitiziraj ($_POST['email']) : ''));
$lozinka = trim(((isset($_POST['lozinka'])) ? sanitiziraj ($_POST['lozinka']) : ''));
$greske = array();


?>

<style>
	body {
		background-image: url("/webshop/slike/baner/back.png");
		background-size: 100vw 100vh;
		background-attachment: fixed;
	}
</style>

<div id="login-forma">
	<div>
		<?php 
			if ($_POST) {
				// Validacija forme
				if (empty($_POST['email']) || empty($_POST['lozinka'])) {
					$greske[] = 'Morate unijeti email i lozinku';
				}

				// Validacija emaila
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$greske[] = 'Morate unijeti valjani email';
				}

				if (strlen($lozinka) < 5) {
					$greske[] = 'Lozinka mora biti sadržavati barem 5 znakova';
				}

				// provjera dal email vec postoji u bazi
				$upit = $db->query("SELECT * FROM korisnici WHERE email = '$email'");
				$korisnik = mysqli_fetch_assoc($upit);
				$brojKorisnika = mysqli_num_rows($upit);
				if ($brojKorisnika < 1) {
					$greske[] = 'Taj email ne postoji u bazi';
				}

				if (!password_verify($lozinka, $korisnik['lozinka'])) {
					$greske[] = 'Lozinka nije odgovarajuća';
				}

				// porovjeri jel ima gresaka
				if (!empty($greske)) {
					echo prikazi_greske($greske);
				} else {
					// logiraj korisnika
					$korisnik_id = $korisnik['id'];
					prijavi($korisnik_id);
				}
			}

		?>

	</div>
	<h2 class="text-center">Prijava</h2>
	<hr>

	<form action="prijava.php" method="post">
		<div class="form-group">
			<label for="email">Email</label>
			<input type="email" name="email" id="email" class="form-control" value="<?=$email;?>">
		</div>
		<div class="form-group">
			<label for="lozinka">Lozinka</label>
			<input type="password" name="lozinka" id="lozinka" class="form-control" value="<?=$lozinka;?>">
		</div>
		<div class="form-group">
			<input type="submit" value="Prijavi Me" class="btn btn-primary">
		</div>
	</form>
	<p class="text-right"><a href="/webshop/index.php" alt="home">Posjeti Stranicu</a></p>
</div>

