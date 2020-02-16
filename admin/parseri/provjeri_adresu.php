<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/webshop/jezgra/init.php';
$ime = sanitiziraj($_POST['puno_ime']);
$email = sanitiziraj($_POST['email']);
$ulica = sanitiziraj($_POST['ulica']);
$grad = sanitiziraj($_POST['grad']);
$zupanija = sanitiziraj($_POST['zupanija']);
$posta = sanitiziraj($_POST['posta']);
$drzava = sanitiziraj($_POST['drzava']);

$greske = array();
$required = array(
	'puno_ime' => 'Puno Ime',
	'email'    => 'Email',
	'ulica'    => 'Ulica',
	'grad'     => 'Grad',
	'zupanija' => 'Županija',
	'posta'    => 'Pošta',
	'drzava'   => 'Država'	
);

// provjera jel su sva polja ispunjena
foreach ($required as $p => $d) {
	if (empty($_POST[$p]) || $_POST[$p] == '') {
		$greske[] = $d. ' polje je obavezno';
	}
}

// provjera email adrese
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	$greske[] = 'Molimo unesite valjani email';
}

if (!empty($greske)) {
	echo prikazi_greske($greske);
} else {
	echo 'valja';
}
?>