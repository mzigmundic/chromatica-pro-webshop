<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/webshop/jezgra/init.php';
$mod = sanitiziraj($_POST['mod']);
$uredi_karakteristiku = sanitiziraj($_POST['uredi_karakteristiku']);
$uredi_id = sanitiziraj($_POST['uredi_id']);

$kosarica = mysqli_fetch_assoc($db->query("SELECT * FROM kosarice WHERE id = '$kosarica_id'"));
$artikli = json_decode($kosarica['artikli'], true);
$azurirani_artikli = array();
$domena = (($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false);

if ($mod == 'uklonijedan') {
	foreach ($artikli as $artikl) {
		if ($artikl['id'] == $uredi_id && $artikl['karakteristika'] == $uredi_karakteristiku) {
			$artikl['kolicina'] = $artikl['kolicina'] - 1;
		}
		if ($artikl['kolicina'] > 0) {
			$azurirani_artikli[] = $artikl;
		}
	}
}

if ($mod == 'dodajjedan') {
	foreach ($artikli as $artikl) {
		if ($artikl['id'] == $uredi_id && $artikl['karakteristika'] == $uredi_karakteristiku) {
			$artikl['kolicina'] = $artikl['kolicina'] + 1;
		}
		$azurirani_artikli[] = $artikl;
	}
}

var_dump($azurirani_artikli);

if (!empty($azurirani_artikli)) {
	$json_azuriran = json_encode($azurirani_artikli);
	$db->query("UPDATE kosarice SET artikli = '$json_azuriran' WHERE id = '$kosarica_id'");
	$_SESSION['uspjeh_poruka'] = 'Košarica ažurirana';
}

if (empty($azurirani_artikli)) {
	$db->query("DELETE FROM kosarice WHERE id = '$kosarica_id'");
	setcookie(KOSARICA_COOKIE, '', 1, '/', $domena, false);
}
?>