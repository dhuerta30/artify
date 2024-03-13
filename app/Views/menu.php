<?php require "layouts/header.php"; ?>
<?php require 'layouts/sidebar.php'; ?>
<link href="<?=$_ENV["BASE_URL"]?>css/sweetalert2.min.css" rel="stylesheet">
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
		<div class="card">
			<div class="card-body">
				<?=$render?>
				<?=$select2?>
			</div>
		</div>
	</section>
</div>
<div id="pdocrud-ajax-loader">
    <img width="300" src="<?=$_ENV["BASE_URL"]?>app/libs/script/images/ajax-loader.gif" class="pdocrud-img-ajax-loader"/>
</div>
<script src="<?=$_ENV["BASE_URL"]?>js/sweetalert2.all.min.js"></script>
<script>
$(document).on("pdocrud_after_ajax_action", function(event, obj, data){
	let action = $(obj).attr('data-action');

	sortable();
	sortableSubmenu();

	if(action == "add"){
		$.ajax({
			url: "<?=$_ENV["BASE_URL"]?>js/icons.json",
			dataType: "json",
			beforeSend: function() {
				$("#pdocrud-ajax-loader").show();
			},
			success: function(data){
				$("#pdocrud-ajax-loader").hide();
				$('.icono_menu, .icono_submenu').html(`<option>Seleccionar Icono</option>`);

				// Recorre cada grupo de íconos
				$.each(data[0].icons, function(index, group){
					// Recorre cada ícono en el grupo
					$.each(group.items, function(index, icon){
						// Agrega cada ícono como una opción al menú desplegable
						$('.icono_menu, .icono_submenu').append(`<option value="${icon}"><i class="${icon}"></i> ${icon}</option>`);
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
				let icono_menu = data['data'][0]['icono_menu'];

                $('.icono_menu').html(`<option>Seleccionar Icono</option>`);
                
                // Recorre cada grupo de íconos
                $.each(data["icons"][0].icons, function(index, group){
                    // Recorre cada ícono en el grupo
                    $.each(group.items, function(index, icon){
                        // Agrega cada ícono como una opción al menú desplegable
						let selected = (icono_menu === icon) ? 'selected' : '';
                    	$('.icono_menu').append(`<option value="${icon}" ${selected}>${icon}</option>`);
                    });
                });
            }
        });

		$.ajax({
            type: "POST",
            url: "<?=$_ENV["BASE_URL"]?>home/editar_iconos_submenu",
            dataType: "json",
            data: { id: id },
			beforeSend: function() {
				$("#pdocrud-ajax-loader").show();
			},
            success: function(data){
                $("#pdocrud-ajax-loader").hide();
				let icono_submenu = data['data'][0]['icono_submenu'];

                $('.icono_submenu').html(`<option>Seleccionar Icono</option>`);
                
                // Recorre cada grupo de íconos
                $.each(data["icons"][0].icons, function(index, group){
                    // Recorre cada ícono en el grupo
                    $.each(group.items, function(index, icon){
                        // Agrega cada ícono como una opción al menú desplegable
						let selected = (icono_submenu === icon) ? 'selected' : '';
                    	$('.icono_submenu').append(`<option value="${icon}" ${selected}>${icon}</option>`);
                    });
                });
            }
        });
	} else if(action == "delete"){
		refrechMenu();
	}
});

function refrechMenu(){
	$.ajax({
		type: "POST",
		url: "<?=$_ENV["BASE_URL"]?>home/refrescarMenu",
		dataType: "json",
		success: function(response){
			$('.menu_generator').html(response);
		}
	});
}

$(document).on("pdocrud_after_submission", function(event, obj, data){
    let json = JSON.parse(data);

    if(json.message){

		refrechMenu();

        $('.pdocrud-back').click();
		sortable();
		sortableSubmenu();
        Swal.fire({
            title: "Genial!",
            text: json.message,
            icon: "success",
            confirmButtonText: "Aceptar"
        });
    }
});

function sortable(){
	$(".pdocrud-table tbody").sortable({
	  handle: '.reordenar_fila',
      helper: function(e, ui) {
        var clone = $(ui).clone();
        clone.css('position', 'absolute');
        return clone.get(0);
      },
      start: function(e, ui) {
        ui.helper.addClass("dragging");
      },
      stop: function(e, ui) {
        ui.item.removeClass("dragging");
      },
	  update: function(event, ui){
		var newOrder = [];
		$(".pdocrud-table tbody tr").each(function() {
			newOrder.push($(this).data("id"));
		});

		updateUrl = "<?=$_ENV["BASE_URL"]?>home/actualizar_orden_menu";

		$.ajax({
			type: "POST",
			url: updateUrl,
			dataType: "json",
			data: { order: newOrder },
			beforeSend: function() {
				$("#pdocrud-ajax-loader").show();
			},
			success: function(response) {
				$("#pdocrud-ajax-loader").hide();
				$('#pdocrud_search_btn').click();
				refrechMenu();
				Swal.fire({
					title: "Genial!",
					text: response['success'],
					icon: "success",
					confirmButtonText: "Aceptar"
				});
			}
		});

	  }
    }).disableSelection();
}

function sortableSubmenu(){
	$(".submenutable tbody").sortable({
	  handle: '.reordenar_fila_submenu',
      helper: function(e, ui) {
        var clone = $(ui).clone();
        clone.css('position', 'absolute');
        return clone.get(0);
      },
      start: function(e, ui) {
        ui.helper.addClass("dragging");
      },
      stop: function(e, ui) {
        ui.item.removeClass("dragging");
      },
	  update: function(event, ui){
		var newOrderSub = [];
		$(".submenutable tbody tr").each(function() {
			newOrderSub.push($(this).data("id"));
		});

		console.log(newOrderSub);

		updateUrl = "<?=$_ENV["BASE_URL"]?>home/actualizar_orden_submenu";

		$.ajax({
			type: "POST",
			url: updateUrl,
			dataType: "json",
			data: { order: newOrderSub },
			beforeSend: function() {
				$("#pdocrud-ajax-loader").show();
			},
			success: function(response) {
				$("#pdocrud-ajax-loader").hide();
				$('#pdocrud_search_btn').click();
				refrechMenu();
				Swal.fire({
					title: "Genial!",
					text: response['success'],
					icon: "success",
					confirmButtonText: "Aceptar"
				});
			}
		});

	  }
    }).disableSelection();
}

$(document).ready(function() {
    sortable();
	sortableSubmenu();
});
</script>
<?php require 'layouts/footer.php'; ?>