<?php

function prikazi_greske($greske) {
	$prikaz = '<ul class="bg-danger">';
	foreach ($greske as $greska) {
		$prikaz .= '<li class="text-danger">' . $greska . '</li>';
	}
	$prikaz .= '</ul>';
	return $prikaz;
}

function sanitiziraj($opasno) {
	return htmlentities($opasno, ENT_QUOTES, "UTF-8");
}

function novac($broj) {
	return number_format($broj, 2). ' kuna';
}

function prijavi($korisnik_id) {
	$_SESSION['korisnik_id'] = $korisnik_id;
	global $db;
	$vrijeme = date("Y-m-d H:i:s");
	$db->query("UPDATE korisnici SET posljednja_prijava = '$vrijeme' WHERE id = '$korisnik_id'");
	$_SESSION['uspjeh_poruka'] = 'Prijavljeni ste';
	header('Location: index.php');
}

function prijavljen() {
	if (isset($_SESSION['korisnik_id']) && $_SESSION['korisnik_id'] > 0) {
		return true;
	}
	return false;
}

function prijava_greska_preusmjeri($url = 'prijava.php') {
	$_SESSION['neuspjeh_poruka'] = 'Da bi ste pristupili stranici morate se prijavit';
	header('Location: ' . $url);
}

function ovlast_greska_preusmjeri($url = 'prijava.php') {
	$_SESSION['neuspjeh_poruka'] = 'Nemate dopuštenje za pristup stranici';
	header('Location: ' . $url);
}

function ima_ovlast($ovlast = 'admin') {
	global $podaci_korisnika;
	$ovlasti = explode(',', $podaci_korisnika['ovlasti']);
	if (in_array($ovlast, $ovlasti, true)) {
		return true;
	}
	return false;
}

function vrijeme($vr) {
	return date("d M, Y H:i", strtotime($vr));
}

function dohvati_kategoriju($podkategorija_id) {
	global $db;
	$id = sanitiziraj($podkategorija_id);
	$sql = "SELECT n.id AS 'nid', n.kategorija AS 'nadkategorija', p.id AS 'pid', p.kategorija AS 'podkategorija'
			FROM kategorije p
			INNER JOIN kategorije n
			ON p.nadkategorija = n.id
			WHERE p.id = '$id'";
	$kategorija = mysqli_fetch_assoc($db->query($sql));
	return $kategorija;
}

function karakteristikeUPolje($string) {
	$karakteristikePolje = explode(',', $string);
	$returnPolje = array();
	foreach ($karakteristikePolje as $karakteristika) {
		$s = explode(':', $karakteristika);
		$returnPolje[] = array('karakteristika' => $s[0], 'kolicina' => $s[1]);
	}
	return $returnPolje;
}

function karakteristikeUString($karakteristike) {
	$karakteristikeString = '';
	foreach ($karakteristike as $karakteristika) {
		$karakteristikeString .= $karakteristika['karakteristika']. ':' . $karakteristika['kolicina'].',';
	}
	$trimed = rtrim($karakteristikeString, ',');
	return $trimed;
}