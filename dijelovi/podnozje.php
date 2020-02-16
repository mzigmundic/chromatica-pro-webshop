			</div>

		<footer class="text-center" id="podnozje"><p>&copy; Copyright 2020 Chromatica Pro</p></footer>
	</div>
	<script>
		jQuery(window).scroll(function() {
			var vertikalniSkrol = jQuery(this).scrollTop();
			jQuery('#logotekst').css({
				"transform" : "translate(0px, " + vertikalniSkrol*0.5 + "px)"
			});

			var vertikalniSkrol = jQuery(this).scrollTop();
			jQuery('#iza-element').css({
				"transform" : "translate(0px, -" + vertikalniSkrol*0.15 + "px)"
			});

			var vertikalniSkrol = jQuery(this).scrollTop();
			jQuery('#ispred-element').css({
				"transform" : "translate(0px, -" + vertikalniSkrol*0.6 + "px)"
			});
		});

		function detaljiSkocniProzor(id) {
			var data = {"id" : id};
			jQuery.ajax({
				url : '/webshop/dijelovi/detalji_modal.php',
				method : "post",
				data : data,
				success : function(data) {
					jQuery('body').append(data);
					jQuery('#detalji-modal').modal('toggle');
				},
				error : function() {
					alert("Nešto ne valja");
				}
			});
		}

		function azurirajKosaricu(mod, uredi_id, uredi_karakteristiku) {
			var data = {
				"mod" : mod,
				"uredi_id" : uredi_id,
				"uredi_karakteristiku" : uredi_karakteristiku
			};
			jQuery.ajax({
				url : '/webshop/admin/parseri/azuriraj_kosaricu.php',
				method : "post",
				data: data,
				success : function() {
					location.reload();
				},
				error : function() {
					alert("Nešto nije u redu");
				},
			});
		}

		function dodajUKosaricu() {
			jQuery('#modal-greske').html("");
			var karakteristika = jQuery('#karakteristika').val();
			var kolicina = jQuery('#kolicina').val();
			var dostupno = jQuery('#dostupno').val();
			var greska = '';
			var data = jQuery('#dodaj-proizvod-forma').serialize();
			if (karakteristika == '' || kolicina == '' || kolicina == 0) {
				greska += '<p class="text-danger text-center">Morate odabrati karakteristiku i količinu</p>';
				jQuery('#modal-greske').html(greska);
				return;
			} else if (Number(kolicina) > Number(dostupno)) {
				greska += '<p class="text-danger text-center">Nažalost, preostalo je samo '+ dostupno +' artikala. ' + kolicina +'</p>';
				jQuery('#modal-greske').html(greska);
				return;
			} else {
				jQuery.ajax({
					url : '/webshop/admin/parseri/dodaj_u_kosaricu.php',
					method : 'post',
					data: data,
					success : function() {
						location.reload();
					},
					error : function() {alert("Nešto nije u redu");}
				});
			}
		}


	</script>
	
</body>
</html>