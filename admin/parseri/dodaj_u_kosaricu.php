<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/webshop/jezgra/init.php';
$proizvod_id = sanitiziraj($_POST['proizvod_id']);
$karakteristika = sanitiziraj($_POST['karakteristika']);
$dostupno = sanitiziraj($_POST['dostupno']);
$kolicina = sanitiziraj($_POST['kolicina']);

$artikl = array();
$artikl[] = array(
	'id'        => $proizvod_id,
	'karakteristika'  => $karakteristika,
	'kolicina'  => $kolicina,
);


$domena = (($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false);
$proizvod = mysqli_fetch_assoc($db->query("SELECT * FROM proizvodi WHERE id = '$proizvod_id'"));
$_SESSION['uspjeh_poruka'] = 'Dodano u košaricu: ' . $proizvod['naziv_proizvoda'];

// provjeri da li cookie kosarice postoji

if ($kosarica_id != '') {
	$kosarica = mysqli_fetch_assoc($db->query("SELECT * FROM kosarice WHERE id = '$kosarica_id'"));
	$prijasnji_artikli = json_decode($kosarica['artikli'], true);
	$artikl_par = 0;
	$novi_artikli = array();
	foreach ($prijasnji_artikli as $partikl) {
		if ($artikl[0]['id'] == $partikl['id'] && $artikl[0]['karakteristika'] == $partikl['karakteristika']) {
			$partikl['kolicina'] = $partikl['kolicina'] + $artikl[0]['kolicina'];
			if ($partikl['kolicina'] > $dostupno) {
				$partikl['kolicina'] = $dostupno;
			}
			$artikl_par = 1;
		}
		$novi_artikli[] = $partikl;
	}
	if ($artikl_par != 1) {
		$novi_artikli = array_merge($artikl, $prijasnji_artikli);
	}
	$artikli_json = json_encode($novi_artikli);
	$kosarica_istek = date("Y-m-d H:i:s", strtotime("+30 days"));
	$db->query("UPDATE kosarice SET artikli = '$artikli_json', vrijeme_isteka = '$kosarica_istek' WHERE id = '$kosarica_id'");
	setcookie(KOSARICA_COOKIE, '', 1, "/", $domena, false);
	setcookie(KOSARICA_COOKIE, $kosarica_id, KOSARICA_COOKIE_ISTEK, '/', $domena, false);

} else {
	// dodaj kosaricu u bazu i postavi cookie
	$artikli_json = json_encode($artikl);
	$kosarica_istek = date("Y-m-d H:i:s", strtotime("+30 days"));
	$db->query("INSERT INTO kosarice (artikli, vrijeme_isteka) VALUES ('$artikli_json', '$kosarica_istek')");
	$kosarica_id = $db->insert_id;
	setcookie(KOSARICA_COOKIE, $kosarica_id, KOSARICA_COOKIE_ISTEK, '/', $domena, false);
}
echo $artikli_json;
?>
