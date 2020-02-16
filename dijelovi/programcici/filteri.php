<?php
	$kat_id = ((isset($_REQUEST['kat'])) ? sanitiziraj($_REQUEST['kat']) : '');

	$cijena_sort = ((isset($_REQUEST['cijena_sort'])) ? sanitiziraj($_REQUEST['cijena_sort']) : '');
	$min_cijena = ((isset($_REQUEST['min_cijena'])) ? sanitiziraj($_REQUEST['min_cijena']) : '');
	$max_cijena = ((isset($_REQUEST['max_cijena'])) ? sanitiziraj($_REQUEST['max_cijena']) : '');
	$m = ((isset($_REQUEST['marka'])) ? sanitiziraj($_REQUEST['marka']) : '');

	$markeUpit = $db->query("SELECT * FROM marke ORDER BY marka");
?>

<h3 class="text-center">Pretraži po:</h3><hr>
<h4 class="text-center">cijeni</h4>
<form action="pretrazi.php" method="post">
	<input type="hidden" name="kat" value="<?=$kat_id;?>">
	<input type="hidden" name="cijena_sort" value="0">
	<input type="radio" name="cijena_sort" value="niza"<?=(($cijena_sort == 'niza') ? ' checked': '');?>> Od niže ka višoj<br>
	<input type="radio" name="cijena_sort" value="visa"<?=(($cijena_sort == 'visa') ? ' checked': '');?>> Od više ka nižoj<br><br>

	<input type="text" name="min_cijena" class="cijena-rang" placeholder="Min" value="<?=$min_cijena;?>">do
	<input type="text" name="max_cijena" class="cijena-rang" placeholder="Max" value="<?=$max_cijena;?>"><br><br>

	<h4 class="text-center">marci</h4>
	<input type="radio" name="marka" value=""<?=(($m == '') ? ' checked' : '');?>> Sve<br>

	<?php while ($marka = mysqli_fetch_assoc($markeUpit)): ?>
		<input type="radio" name="marka" value="<?=$marka['id'];?>"<?=(($m == $marka['id']) ? ' checked': '');?>> <?=$marka['marka'];?><br>
	<?php endwhile; ?><br>
	<hr>
	<div class="text-center">
		<input type="submit" value="Traži" class="btn btn-sm btn-primary">
	</div>


	
</form>