<?php

require_once 'jezgra/init.php';

$puno_ime = sanitiziraj($_POST['puno_ime']);
$email = sanitiziraj($_POST['email']);
$ulica = sanitiziraj($_POST['ulica']);
$grad = sanitiziraj($_POST['grad']);
$zupanija = sanitiziraj($_POST['zupanija']);
$posta = sanitiziraj($_POST['posta']);
$drzava = sanitiziraj($_POST['drzava']);
$porez = sanitiziraj($_POST['porez']);
$ukupna_cijena = sanitiziraj($_POST['ukupna_cijena']);
$ukupna_cijena_s_porezom = sanitiziraj($_POST['ukupna_cijena_s_porezom']);
$kosarica_id = sanitiziraj($_POST['kosarica_id']);
$opis = sanitiziraj($_POST['opis']);

try {


	$arez = mysqli_fetch_assoc($db->query("SELECT * FROM kosarice WHERE id = '$kosarica_id'"));
	$artikli = json_decode($arez['artikli'], true);

	foreach ($artikli as $artikl) {
		$noveKarakteristike = array();
		$artikl_id = $artikl['id'];
		$proizvod = mysqli_fetch_assoc($db->query("SELECT karakteristike FROM proizvodi WHERE id = '$artikl_id'"));
		$karakteristike = karakteristikeUPolje($proizvod['karakteristike']);
		foreach ($karakteristike as $karakteristika) {
			if ($karakteristika['karakteristika'] == $artikl['karakteristika']) {
				$kol = $karakteristika['kolicina'] - $artikl['kolicina'];
				$noveKarakteristike[] = array('karakteristika' => $karakteristika['karakteristika'], 'kolicina' => $kol);
			} else {
				$noveKarakteristike[] = array('karakteristika' => $karakteristika['karakteristika'], 'kolicina' => $karakteristika['kolicina']);
			}
		}
		$karakteristikaString = karakteristikeUString($noveKarakteristike);
		$db->query("UPDATE proizvodi SET karakteristike = '$karakteristikaString' WHERE id = '$artikl_id'");
	}

	$db->query("UPDATE kosarice SET placeno = 1 WHERE id = '$kosarica_id'");

	$db->query("INSERT INTO transakcije (kosarica_id, puno_ime, email, ulica, grad, zupanija, posta, drzava, ukupna_cijena, porez, ukupna_cijena_s_porezom, opis) VALUES ('$kosarica_id', '$puno_ime', '$email', '$ulica', '$grad', '$zupanija', '$posta', '$drzava', '$ukupna_cijena', '$porez', '$ukupna_cijena_s_porezom', '$opis')");


	$domena = (($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false);
	setcookie(KOSARICA_COOKIE, '', 1, '/', $domena, false);

	include 'dijelovi/zaglavlje.php';
	include 'dijelovi/navigacija.php';
	include 'dijelovi/baner_dio.php';
?>

	<h1 class="text-center text-success">Hvala Vam!</h1>
	<div class="col-md-8 col-md-offset-2">
		<p>Uspješno ste platili <?=novac($ukupna_cijena_s_porezom);?></p><br>
		<p>Vaša narudžba će biti isporučena na sljedeću adresu:</p>
		<address>
				<?=$puno_ime;?><br>
				<?=$ulica;?><br>
				<?=$grad . ' ' . $posta . ', ' .$zupanija ;?><br>
				<?=$drzava;?><br>
		</address>
	</div>

<?php
	include 'dijelovi/podnozje.php';

} catch (Exception $e) {
	echo $e;
}

?>