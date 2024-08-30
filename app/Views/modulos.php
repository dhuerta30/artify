<?php require "layouts/header.php"; ?>
<?php require 'layouts/sidebar.php'; ?>
<link href="<?=$_ENV["BASE_URL"]?>css/sweetalert2.min.css" rel="stylesheet">
<style>
.btn.btn-default {
    background: #fff;
}
@media (min-width: 576px){
	.modal-dialog {
		max-width: 700px!important;
		margin: 1.75rem auto;
	}
}

.form-control {
    min-width: 200px;
}
</style>
<div class="content-wrapper">
	<section class="content">
		<div class="card mt-4">
			<div class="card-body">
				<?=$render?>
				<div class="emergente"></div>
			</div>
		</div>
	</section>
</div>
<div id="pdocrud-ajax-loader">
    <img width="300" src="<?=$_ENV["BASE_URL"]?>app/libs/script/images/ajax-loader.gif" class="pdocrud-img-ajax-loader"/>
</div>
<script src="<?=$_ENV["BASE_URL"]?>js/sweetalert2.all.min.js"></script>
<script>
$(document).on("pdocrud_after_ajax_action",function(event, obj, data){
    refrechMenu();
    $('.label_Visibilidad_filtro').hide();
    $('.data_visibilidad_filtro').hide();
    $('.data_visibilidad_filtro').attr('required', false);
    $('.pdocrud-button-url').removeClass('pdocrud-actions');
    construirFrase();
});

$(document).on("change", ".crud_type", function(){
    let val = $(this).val();
    if(val == "CRUD"){
        $(".id_tabla").attr("disabled", "disabled");
        $(".id_tabla").removeAttr("required");
        $(".query").removeAttr("required");
        $(".query").attr("disabled", "disabled");
    } else {
        $(".id_tabla").removeAttr("disabled");
        $(".id_tabla").attr("required", "required");
        $(".query").attr("required", "required");
        $(".query").removeAttr("disabled");
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
        $('.pdocrud-button-url').removeClass('pdocrud-actions');
        Swal.fire({
            title: "Genial!",
            text: json.message,
            icon: "success",
            confirmButtonText: "Aceptar"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Guardado con éxito!",
                    icon: "success",
                    confirmButtonText: "Aceptar"
                });
                $('.pdocrud-back').click();
            }
        });
    }
});

$(document).on("click", ".agregar_muestras", function(){
    construirFrase();
});

function construirFrase() {
    $('.pdocrud-left-join').on("keyup change", ".nombre, .tipo_de_campo, .nulo, .indice, .autoincrementable, .longitud", function() {
        var $row = $(this).closest('tr');
        // Get input values within the row
        var campo1 = $row.find('.nombre').val().trim();
        var campo2 = $row.find('.tipo_de_campo').val().trim();
        var campo3 = $row.find('.nulo').val().trim();
        var campo4 = $row.find('.indice').val().trim();
        var campo5 = $row.find('.autoincrementable').val().trim();
        var campo6 = $row.find('.longitud').val().trim();

        if(campo2 == "Numerico"){
            campo2 = "INT";
        }

        if(campo4 == "Primario"){
            campo4 = "PRIMARY KEY";
        } else {
            campo4 = "";
        }

        if(campo5 == "Si"){
            campo5 = "AUTO_INCREMENT,";
        }

        // Construir la frase
        var frase = `${campo1} ${campo2} ${campo4} ${campo3} ${campo5} ${campo6} `;

        // Asignar la frase al textarea
        $('.columns_table').val(frase);
    });
}

construirFrase();

</script>
<?php require 'layouts/footer.php'; ?>