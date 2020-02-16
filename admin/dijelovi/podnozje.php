			</div>

		<footer class="text-center" id="podnozje">&copy; Copyright 2020 Chromatica Pro - Admin</footer>
	</div>
	<script>

		function azurirajKarakteristike() {
			var karakteristikeString = '';
			for (let i = 1; i <= 12; i++) {
				if (jQuery('#karakteristika'+i).val() != '') {
					karakteristikeString += jQuery('#karakteristika'+i).val()+':'+jQuery('#kol'+i).val()+',';
				}
			}
			jQuery('#karakteristike').val(karakteristikeString);
		}

		function opcijePodkategorije(selected) {
			if (typeof selected === 'undefined') {
				var selected = '';
			}
			var nadkategorijaID = jQuery('#nadkategorija').val();
			jQuery.ajax({
				url: '/webshop/admin/parseri/podkategorije.php',
				type: 'POST',
				data: {nadkategorijaID: nadkategorijaID, selected: selected},
				success: function(data) {
					jQuery('#podkategorija').html(data);
				},
				error: function() {alert("Nešto nije u redu s podkategorijama")},
			});
		}
		jQuery('select[name="nadkategorija"]').change(function() {
			opcijePodkategorije();
		});
	</script>
</body>
</html>