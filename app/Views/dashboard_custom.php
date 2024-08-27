
<?php require "layouts/header.php"; ?>
<?php require "layouts/sidebar.php"; ?>
<style>
	.select2-container .select2-selection--single {
		height: 38px!important;
	}
	.select2-container--default .select2-selection--single .select2-selection__arrow {
		top: 7px!important;
	}

	.select2-container {
		width:100%!important;
	}
</style>
<div class="content-wrapper">
    <section class="content">
        <div class="card mt-4">
            <div class="card-body">

                <div class="row procedimiento">
                    <div class="col-md-12">
                        <?=$render?>
                        <?=$select2?>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
<div id="pdocrud-ajax-loader">
    <img width="300" src="<?=$_ENV["BASE_URL"]?>app/libs/script/images/ajax-loader.gif" class="pdocrud-img-ajax-loader"/>
</div>
<?php require "layouts/footer.php"; ?>
<script>
    $(document).on("pdocrud_after_ajax_action", function(event, obj, data){
	let action = $(obj).attr('data-action');

	if(action == "add"){
		$.ajax({
			url: "<?=$_ENV["BASE_URL"]?>js/icons.json",
			dataType: "json",
			beforeSend: function() {
				$("#pdocrud-ajax-loader").show();
			},
			success: function(data){
				$("#pdocrud-ajax-loader").hide();
				$('.icono').html(`<option>Seleccionar Icono</option>`);

				// Recorre cada grupo de íconos
				$.each(data[0].icons, function(index, group){
					// Recorre cada ícono en el grupo
					$.each(group.items, function(index, icon){
						// Agrega cada ícono como una opción al menú desplegable
						$('.icono').append(`<option value="${icon}"><i class="${icon}"></i> ${icon}</option>`);
					});
				});
			}
		});
	} else if(action == "edit"){
		let id = $(obj).attr('data-id');

		$.ajax({
            type: "POST",
            url: "<?=$_ENV["BASE_URL"]?>home/editar_iconos_menu",
            dataType: "json",
            data: { id: id },
			beforeSend: function() {
				$("#pdocrud-ajax-loader").show();
			},
            success: function(data){
                $("#pdocrud-ajax-loader").hide();
				let icono = data['data'][0]['icono'];

                $('.icono').html(`<option>Seleccionar Icono</option>`);
                
                // Recorre cada grupo de íconos
                $.each(data["icons"][0].icons, function(index, group){
                    // Recorre cada ícono en el grupo
                    $.each(group.items, function(index, icon){
                        // Agrega cada ícono como una opción al menú desplegable
						let selected = (icono === icon) ? 'selected' : '';
                    	$('.icono').append(`<option value="${icon}" ${selected}>${icon}</option>`);
                    });
                });
            }
        });
	}
});
</script>