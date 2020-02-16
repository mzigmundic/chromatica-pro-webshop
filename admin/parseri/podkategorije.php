<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/webshop/jezgra/init.php';

	$nadkategorijaID = (int)$_POST['nadkategorijaID'];
	$selected = sanitiziraj($_POST['selected']);
	$podkategorijaUpit = $db->query("SELECT * FROM kategorije WHERE nadkategorija = '$nadkategorijaID' ORDER BY kategorija");
	ob_start();
?>

<option value=""></option>
<?php while ($podkategorija = mysqli_fetch_assoc($podkategorijaUpit)) : ?>
	<option value="<?=$podkategorija['id'];?>" <?=(($selected == $podkategorija['id'])?'selected':'');?>><?=$podkategorija['kategorija'];?></option>
<?php endwhile; ?>

<?php
	echo ob_get_clean();
?>