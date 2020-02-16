<?php

$db = mysqli_connect('127.0.0.1', 'root', 'password', 'webshop');
if (mysqli_connect_errno()) {
	echo 'Povezivanje s bazom neuspješno: ' . mysqli_connect_error();
	die();
}
mysqli_set_charset($db, "utf8");

session_start();

require_once $_SERVER['DOCUMENT_ROOT'].'/webshop/konfiguracija.php';
require_once BAZAURL.'asistent/pomocne_funkcije.php';

$kosarica_id = '';
/*
$domena = (($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false);
setcookie(KOSARICA_COOKIE, '', 1, "/", $domena, false);
*/
if (isset($_COOKIE[KOSARICA_COOKIE])) {
	$kosarica_id = sanitiziraj($_COOKIE[KOSARICA_COOKIE]);
}

if (isset($_SESSION['korisnik_id'])) {
	$korisnik_id = $_SESSION['korisnik_id'];
	$podaci_korisnika = mysqli_fetch_assoc($db->query("SELECT * FROM korisnici WHERE id = '$korisnik_id'"));
	$puno_ime = explode(' ', $podaci_korisnika['puno_ime']);
	$podaci_korisnika['ime'] = $puno_ime[0];
	$podaci_korisnika['prezime'] = $puno_ime[1];
}

if (isset($_SESSION['uspjeh_poruka'])) {
	echo '<div class="bg-success"><p class="text-success text-center" style="margin:0; font-size:18px;">'.$_SESSION['uspjeh_poruka'].'</p></div>';
	unset($_SESSION['uspjeh_poruka']);
}

if (isset($_SESSION['neuspjeh_poruka'])) {
	echo '<div class="bg-danger"><p class="text-danger text-center" style="margin:0; font-size:18px;">'.$_SESSION['neuspjeh_poruka'].'</p></div>';
	unset($_SESSION['neuspjeh_poruka']);
}

